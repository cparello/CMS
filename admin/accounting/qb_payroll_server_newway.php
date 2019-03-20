<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

// We need to make sure the correct timezone is set, or some PHP installations will complain
if (function_exists('date_default_timezone_set'))
{
	// * MAKE SURE YOU SET THIS TO THE CORRECT TIMEZONE! *
	// List of valid timezones is here: http://us3.php.net/manual/en/timezones.php
	date_default_timezone_set('America/Los_Angeles');
}

// Include path for the QuickBooks library
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/Users/keithpalmerjr/Projects/QuickBooks/');

// I always program in E_STRICT error mode... 
error_reporting(E_ALL | E_STRICT);

// There are some constants you can define to override some default... 
//define('QUICKBOOKS_DRIVER_SQL_MYSQL_PREFIX', 'myqb_');
//define('QUICKBOOKS_DRIVER_SQL_MYSQLI_PREFIX', 'myqb_');

// Require the framework
require_once 'QuickBooks.php';
include 'qb_dsn.php';
include 'qb_dbmain.php';

// A username and password you'll use in: 
//	a) Your .QWC file
//	b) The Web Connector
//	c) The QuickBooks framework
//

$stmt = $dbMain-> prepare("SELECT qb_name, qb_password FROM qb_user WHERE qb_id = '1' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($qb_name, $qb_password);
$stmt->fetch();
$stmt->close();

// 	NOTE: This has *no relationship* with QuickBooks usernames, Windows usernames, etc. 
// 		It is *only* used for the Web Connector and SOAP server! 
$user = $qb_name;
$pass = $qb_password;

//$user = 'chris11';
//$pass = 'fubar';

// The next three parameters, $map, $errmap, and $hooks, are callbacks which 
//	will be called when certain actions/events/requests/responses occur within 
//	the framework. The examples below show how to register callback 
//	*functions*, but you can actually register any of the following, using 
//	these formats:

/*
// Callback functions

$map = array(
	QUICKBOOKS_ADD_CUSTOMER => array( 'my_function_name_for_requests', 'my_function_name_for_responses' ), 
	);

$errmap = array(
	500 => 'my_function_name_for_handling_500_errors', 
	);

$hooks = array(
	QUICKBOOKS_HANDLERS_HOOK_LOGINSUCCESS => 'my_function_name_for_when_a_login_succeeds', 
	);

function my_function_name_for_requests() { ... }
function my_function_name_for_handling_500_errors() { ... }
function my_function_name_for_when_a_login_succeeds() { ... }
*/

/*
// Callback static methods
//	Remember that your methods *must be static methods* and thus can't use 
//	$this->... or other non-static methods.

$map = array(
	QUICKBOOKS_ADD_CUSTOMER => array( 'My_Class_Name::my_method_name_for_requests', 'My_ClassName::my_method_name_for_responses' ), 
	);

$errmap = array(
	500 => 'My_Class_Name::my_method_name_for_handling_500_errors', 
	);
	
$hooks = array(
	QUICKBOOKS_HANDLERS_HOOK_LOGINSUCCESS => 'My_Class_Name::my_method_name_for_when_a_login_succeeds', 
	);
	
class My_Class_Name
{
	static public function my_method_name_for_requests() { ... }
	static public function my_method_name_for_responses() { ... }
	static public function my_method_name_for_handling_500_errors() { ... }
	static public function my_method_name_for_when_a_login_succeeds() { ... }
}
*/

/*
// Callback object instance methods
//  Important! If you're using this method, remember that QuickBooks requests 
//	and responses happen during *different* HTTP connections! So, you won't be 
//	able to preserve instance variables from a request handler to a response 
//	handler without writing it to a database or file or something. 
//	
//	example:
//		HTTP connect
//			ask for request
//			framework calls request handler, sends qbXML request
//		HTTP disconnect
//
//		HTTP connect
//			send the response
//			framework calls response handler, calls any error handlers
//			framework sends back a percentage done
//		HTTP disconnect

$obj = new My_Class_Name();

$map = array(
	QUICKBOOKS_ADD_CUSTOMER => array( array( $obj, 'my_method_name_for_requests' ), array( $obj, 'my_method_name_for_responses' ) ), 
	);

$errmap = array(
	500 => array( $obj, 'my_method_name_for_handling_500_errors' ), 
	);

$hooks = array(
	QUICKBOOKS_HANDLERS_HOOK_LOGINSUCCESS => array( $obj, 'my_method_name_for_when_a_login_succeeds' ), 
	);
	
class My_Class_Name
{
	public function __construct(...)
	{
		... 
	}
	
	public function my_method_name_for_requests() { ... }
	public function my_method_name_for_responses() { ... }
	public function my_method_name_for_handling_500_errors() { ... }
	public function my_method_name_for_when_a_login_succeeds() { ... }
}
*/

// Map QuickBooks actions to handler functions
$map = array(
	QUICKBOOKS_ADD_EMPLOYEE => array( '_quickbooks_employee_add_request', '_quickbooks_employee_add_response' ),
	QUICKBOOKS_MOD_EMPLOYEE => array( '_quickbooks_employee_mod_request', '_quickbooks_employee_mod_response' ), 
    QUICKBOOKS_QUERY_EMPLOYEE => array( '_quickbooks_employee_query_request', '_quickbooks_employee_query_response' ),
    QUICKBOOKS_ADD_TIMETRACKING => array( '_quickbooks_timetracking_add_request', '_quickbooks_timetracking_add_response' ),
    QUICKBOOKS_MOD_TIMETRACKING => array( '_quickbooks_timetracking_mod_request', '_quickbooks_timetracking_mod_response' ),
    QUICKBOOKS_ADD_PAYROLLITEMWAGE => array( '_quickbooks_payrollitemwage_add_request', '_quickbooks_payrollitemwage_add_response' ),
    QUICKBOOKS_QUERY_PAYROLLITEMWAGE => array( '_quickbooks_payrollitemwage_query_request', '_quickbooks_payrollitemwage_query_response' ),    
	//'*' => array( '_quickbooks_customer_add_request', '_quickbooks_customer_add_response' ), 
	// ... more action handlers here ...
	);

// This is entirely optional, use it to trigger actions when an error is returned by QuickBooks
$errmap = array(
	3070 => '_quickbooks_error_stringtoolong',				// Whenever a string is too long to fit in a field, call this function: _quickbooks_error_stringtolong()
	3100 => '_quickbooks_error_e3100',
    // 'CustomerAdd' => '_quickbooks_error_customeradd', 	// Whenever an error occurs while trying to perform an 'AddCustomer' action, call this function: _quickbooks_error_customeradd()
	// '*' => '_quickbooks_error_catchall', 				// Using a key value of '*' will catch any errors which were not caught by another error handler
	// ... more error handlers here ...
	);
// An array of callback hooks
$hooks = array(
	// There are many hooks defined which allow you to run your own functions/methods when certain events happen within the framework
	// QUICKBOOKS_HANDLERS_HOOK_LOGINSUCCESS => '_quickbooks_hook_loginsuccess', 	// Run this function whenever a successful login occurs
	);

/*
function _quickbooks_hook_loginsuccess($requestID, $user, $hook, &$err, $hook_data, $callback_config)
{
	// Do something whenever a successful login occurs...
}
*/

// Logging level
//$log_level = QUICKBOOKS_LOG_NORMAL;
$log_level = QUICKBOOKS_LOG_VERBOSE;
//$log_level = QUICKBOOKS_LOG_DEBUG;				
//$log_level = QUICKBOOKS_LOG_DEVELOP;		// Use this level until you're sure everything works!!!

// What SOAP server you're using 
//$soapserver = QUICKBOOKS_SOAPSERVER_PHP;			// The PHP SOAP extension, see: www.php.net/soap
$soapserver = QUICKBOOKS_SOAPSERVER_BUILTIN;		// A pure-PHP SOAP server (no PHP ext/soap extension required, also makes debugging easier)

$soap_options = array(		// See http://www.php.net/soap
	);

$handler_options = array(
	//'authenticate_dsn' => ' *** YOU DO NOT NEED TO PROVIDE THIS CONFIGURATION VARIABLE TO USE THE DEFAULT AUTHENTICATION METHOD FOR THE DRIVER YOU'RE USING (I.E.: MYSQL) *** '
	//'authenticate_dsn' => 'ldapv3://ldap.example.com:389/ou=People,dc=example,dc=com',
	//'authenticate_dsn' => 'mysql://emsdata:6ym5yst3ms!@174.121.5.4/bac_admin?quickbooks_user',  
	//'authenticate_dsn' => 'postgresql://user:pass@localhost/database?quickbooks_user', 
	//'authenticate_dsn' => 'function://your_function_name_here', 
	);		// See the comments in the QuickBooks/Server/Handlers.php file

$driver_options = array(		// See the comments in the QuickBooks/Driver/<YOUR DRIVER HERE>.php file ( i.e. 'Mysql.php', etc. )
	'max_log_history' => 1024,	// Limit the number of quickbooks_log entries to 1024
	'max_queue_history' => 64, 	// Limit the number of *successfully processed* quickbooks_queue entries to 64
	);

$callback_options = array(
	);

// * MAKE SURE YOU CHANGE THE DATABASE CONNECTION STRING BELOW TO A VALID MYSQL USERNAME/PASSWORD/HOSTNAME *
// 
// This assumes that:
//	- You are connecting to MySQL with the username 'root'
//	- You are connecting to MySQL with an empty password
//	- Your MySQL server is located on the same machine as the script ( i.e.: 'localhost', if it were on another machine, you might use 'other-machines-hostname.com', or '192.168.1.5', or ... etc. )
//	- Your MySQL database name containing the QuickBooks tables is named 'quickbooks' (if the tables don't exist, they'll be created for you) 
//**************************************$dsn = 'mysqli://emsdata:6ym5yst3ms!@192.155.92.4/bac_admin';*****************
//$dsn = 'mysql://root:password@localhost/your_database';				// Connect to a MySQL database with user 'root' and password 'password'
//$dsn = 'mysqli://root:@localhost/quickbooks_mysqli';					// Connect to a MySQL database using the PHP MySQLi extension
//$dsn = 'mssql://kpalmer:password@192.168.18.128/your_database';		// Connect to MS SQL Server database
//$dsn = 'pgsql://pgsql:password@localhost/your_database';				// Connect to a PostgreSQL database 
//$dsn = 'pearmdb2.mysql://root:password@localhost/your_database';		// Connect to MySQL using the PEAR MDB2 database abstraction library
//$dsn = 'sqlite://filename';											// Connect to an SQLite database

if (!QuickBooks_Utilities::initialized($dsn))
{
	// Initialize creates the neccessary database schema for queueing up requests and logging
	QuickBooks_Utilities::initialize($dsn);
	
	// This creates a username and password which is used by the Web Connector to authenticate
	QuickBooks_Utilities::createUser($dsn, $user, $pass);
	
	//================================================================================================================
	function loadEmployeeCompare($user_id) {
	include 'qb_dbmain.php';
	//$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin');   
	
	$stmt = $dbMain-> prepare("SELECT COUNT(*) AS count FROM qb_employee_info WHERE user_id = '$user_id' ");
	$stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($count);
	$stmt->fetch();
	
	if($count == 0) {
	   return false;
	  }else{
	   return true;	  
	  }
    $stmt->close();
	}
 //=====================================================================================================================
   $Queue = new QuickBooks_Queue($dsn); 
      
   //$this->loadLastPayrollCloseDate();
   //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin');   
	
	$stmt = $dbMain-> prepare("SELECT status_bit FROM qb_status WHERE status_id = '1' ");
	$stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($status_bit);
	$stmt->fetch();
    $stmt->close();
    
    $stmt = $dbMain-> prepare("SELECT MAX(payroll_id) FROM qb_payroll_settled");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($payroll_id); 
   $stmt->fetch();
   $stmt->close();
   
   //$use_qb_already = false;
     
     
   if ($status_bit == '1'){
    
         $wage_added_qb = 'Y';
         $sql = "UPDATE qb_wage_types  SET wage_added_qb = ? WHERE wage_id = '1'";
         $stmt = $dbMain->prepare($sql);
         $stmt->bind_param('s', $wage_added_qb);
         $stmt->execute();        
         $stmt->close();
         
         $wage_added_qb = 'Y';
         $sql = "UPDATE qb_wage_types  SET wage_added_qb = ? WHERE wage_id = '2'";
         $stmt = $dbMain->prepare($sql);
         $stmt->bind_param('s', $wage_added_qb);
         $stmt->execute();        
         $stmt->close();
         
         $wage_added_qb = 'Y';
         $sql = "UPDATE qb_wage_types  SET wage_added_qb = ? WHERE wage_id = '3'";
         $stmt = $dbMain->prepare($sql);
         $stmt->bind_param('s', $wage_added_qb);
         $stmt->execute();        
         $stmt->close();
         
         $wage_added_qb = 'Y';
         $sql = "UPDATE qb_wage_types  SET wage_added_qb = ? WHERE wage_id = '4'";
         $stmt = $dbMain->prepare($sql);
         $stmt->bind_param('s', $wage_added_qb);
         $stmt->execute();        
         $stmt->close();
         
         $wage_added_qb = 'Y';
         $sql = "UPDATE qb_wage_types  SET wage_added_qb = ? WHERE wage_id = '3'";
         $stmt = $dbMain->prepare($sql);
         $stmt->bind_param('s', $wage_added_qb);
         $stmt->execute();        
         $stmt->close();
        
        //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 	
        
        
        $stmt = $dbMain-> prepare("SELECT DISTINCT wage_id FROM qb_wage_types WHERE wage_id != '0' ");
       $stmt->execute();      
       $stmt->store_result();      
       $stmt->bind_result($wage_id); 
    
        while ($stmt->fetch()) { 
                   $primary_key_of_your_employee = $wage_id;
                   $Queue->enqueue(QUICKBOOKS_QUERY_PAYROLLITEMWAGE, $primary_key_of_your_employee,10);
                 } 
        $stmt->close();      
                        
       $stmt = $dbMain-> prepare("SELECT user_id FROM qb_payroll_settled WHERE user_id != '0' AND payroll_id = '$payroll_id' ");
       $stmt->execute();      
       $stmt->store_result();      
       $stmt->bind_result($user_id); 
    
        while ($stmt->fetch()) { 
                   $primary_key_of_your_employee = $user_id;
                   $Queue->enqueue(QUICKBOOKS_QUERY_EMPLOYEE, $primary_key_of_your_employee,9);
                 }
        $stmt->close();
                        
        //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 	
        
       $stmt = $dbMain-> prepare("SELECT user_id FROM qb_payroll_settled WHERE user_id != '0' AND payroll_id = '$payroll_id' ");
       $stmt->execute();      
       $stmt->store_result();      
       $stmt->bind_result($user_id); 
    
        while ($stmt->fetch()) { 
                  
                   $match = loadEmployeeCompare($user_id);
                   $primary_key_of_your_employee = $user_id;
                   if ($match == true){
                    $Queue->enqueue(QUICKBOOKS_MOD_EMPLOYEE, $primary_key_of_your_employee,8);
                   $Queue->enqueue(QUICKBOOKS_ADD_TIMETRACKING, $primary_key_of_your_employee,7);
                   }else{
                    $Queue->enqueue(QUICKBOOKS_ADD_EMPLOYEE, $primary_key_of_your_employee,8);
                    $Queue->enqueue(QUICKBOOKS_ADD_TIMETRACKING, $primary_key_of_your_employee,7);
                   }
                   
                                                         
                       }   
       $stmt->close();          
        }else if ($status_bit == '0'){
            
                             $status_bit = '1';
                             $sql = "UPDATE qb_status  SET status_bit = ? WHERE status_id = '1'";
                             $stmt = $dbMain->prepare($sql);
                             $stmt->bind_param('s', $status_bit);
                             $stmt->execute();        
                             $stmt->close();
                             
                            
                            //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 	
                            $stmt = $dbMain-> prepare("SELECT wage_added_qb FROM qb_wage_types WHERE wage_id = '1' ");
                            $stmt->execute();      
                            $stmt->store_result();      
                            $stmt->bind_result($wage_added_qb); 
                            $stmt->fetch();
                            $stmt->close();
                            
                            if ($wage_added_qb == 'N'){
                                $primary_key_of_your_employee = 1; 
                                $Queue->enqueue(QUICKBOOKS_ADD_PAYROLLITEMWAGE, $primary_key_of_your_employee,9);
                            }
                            
                             $stmt = $dbMain-> prepare("SELECT wage_added_qb FROM qb_wage_types WHERE wage_id = '2' ");
                            $stmt->execute();      
                            $stmt->store_result();      
                            $stmt->bind_result($wage_added_qb); 
                            $stmt->fetch();
                            $stmt->close();
                            
                            if ($wage_added_qb == 'N'){
                                $primary_key_of_your_employee = 2; 
                                $Queue->enqueue(QUICKBOOKS_ADD_PAYROLLITEMWAGE, $primary_key_of_your_employee,9);
                            }  
                                
                            $stmt = $dbMain-> prepare("SELECT wage_added_qb FROM qb_wage_types WHERE wage_id = '3' ");
                            $stmt->execute();      
                            $stmt->store_result();      
                            $stmt->bind_result($wage_added_qb); 
                            $stmt->fetch();
                            $stmt->close();
                            
                            if ($wage_added_qb == 'N'){
                                $primary_key_of_your_employee = 3; 
                                $Queue->enqueue(QUICKBOOKS_ADD_PAYROLLITEMWAGE, $primary_key_of_your_employee,9);
                            }   
                            
                            $stmt = $dbMain-> prepare("SELECT wage_added_qb FROM qb_wage_types WHERE wage_id = '4' ");
                            $stmt->execute();      
                            $stmt->store_result();      
                            $stmt->bind_result($wage_added_qb); 
                            $stmt->fetch();
                            $stmt->close();
                            
                            if ($wage_added_qb == 'N'){
                                $primary_key_of_your_employee = 4; 
                                $Queue->enqueue(QUICKBOOKS_ADD_PAYROLLITEMWAGE, $primary_key_of_your_employee,9);
                            }     
                            
                            $stmt = $dbMain-> prepare("SELECT wage_added_qb FROM qb_wage_types WHERE wage_id = '5' ");
                            $stmt->execute();      
                            $stmt->store_result();      
                            $stmt->bind_result($wage_added_qb); 
                            $stmt->fetch();
                            $stmt->close();
                            
                            if ($wage_added_qb == 'N'){
                                $primary_key_of_your_employee = 5; 
                                $Queue->enqueue(QUICKBOOKS_ADD_PAYROLLITEMWAGE, $primary_key_of_your_employee,9);
                            }    
                               
                                
                                
                            //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 	
                            $stmt = $dbMain-> prepare("SELECT user_id FROM qb_payroll_settled WHERE user_id != '0' AND payroll_id = '$payroll_id' ");
                            $stmt->execute();      
                            $stmt->store_result();      
                            $stmt->bind_result($user_id); 
                        
                            while ($stmt->fetch()) { 
                                      
                                     /* $match = loadEmployeeCompare($user_id);
                                       
                                          if($match == true) {
                                            $Queue->enqueue(QUICKBOOKS_MOD_EMPLOYEE, $primary_key_of_your_employee,8);
                                            $Queue->enqueue(QUICKBOOKS_MOD_TIMETRACKING, $primary_key_of_your_employee,7);
                                            }else{*/
                                            $primary_key_of_your_employee = $user_id;
                                            $Queue->enqueue(QUICKBOOKS_ADD_EMPLOYEE, $primary_key_of_your_employee,8);
                                            $Queue->enqueue(QUICKBOOKS_ADD_TIMETRACKING, $primary_key_of_your_employee,7);
                                            //$Queue->enqueue(QUICKBOOKS_ADD_PAYROLLITEMWAGE, $primary_key_of_your_employee,9);
                                            //}
                        
                                     }
                            $stmt->close();
                            }
   
   
   
    
   
       
      
             
            
    
	
	// Also note the that ->enqueue() method supports some other parameters: 
	// 	string $action				The type of action to queue up
	//	mixed $ident = null			Pass in the unique primary key of your record here, so you can pull the data from your application to build a qbXML request in your request handler
	//	$priority = 0				You can assign priorities to requests, higher priorities get run first
	//	$extra = null				Any extra data you want to pass to the request/response handler
	//	$user = null				If you're using multiple usernames, you can pass the username of the user to queue this up for here
	//	$qbxml = null				
	//	$replace = true				
	// 
	// Of particular importance and use is the $priority parameter. Say a new 
	//	customer is created and places an order on your website. You'll want to 
	//	send both the customer *and* the sales receipt to QuickBooks, but you 
	//	need to ensure that the customer is created *before* the sales receipt, 
	//	right? So, you'll queue up both requests, but you'll assign the 
	//	customer a higher priority to ensure that the customer is added before 
	//	the sales receipt. 
	// 
	//	Queue up the customer with a priority of 10
	// 	$Queue->enqueue(QUICKBOOKS_ADD_CUSTOMER, $primary_key_of_your_customer, 10);
	//	
	//	Queue up the invoice with a priority of 0, to make sure it doesn't run until after the customer is created
	//	$Queue->enqueue(QUICKBOOKS_ADD_SALESRECEIPT, $primary_key_of_your_order, 0);
}

// Create a new server and tell it to handle the requests
//__construct($dsn_or_conn, $map, $errmap = array(), $hooks = array(), $log_level = QUICKBOOKS_LOG_NORMAL, $soap = QUICKBOOKS_SOAPSERVER_PHP, $wsdl = QUICKBOOKS_WSDL, $soap_options = array(), $handler_options = array(), $driver_options = array(), $callback_options = array());
$Server = new QuickBooks_Server($dsn, $map, $errmap, $hooks, $log_level, $soapserver, QUICKBOOKS_WSDL, $soap_options, $handler_options, $driver_options, $callback_options);
$response = $Server->handle(true, true);

/*
// If you wanted, you could do something with $response here for debugging

$fp = fopen('/path/to/file.log', 'a+');
fwrite($fp, $response);
fclose($fp);*/

$ourFileName = "errorlog.txt";
$ourFileHandle = fopen($ourFileName, 'a+') or die("can't open file");                         
fwrite($ourFileHandle, $response);                       
fclose($ourFileHandle);
//==========================================================================================================================      
/**
 * Generate a qbXML response to add a particular customer to QuickBooks
 * 
 * So, you've queued up a QUICKBOOKS_ADD_CUSTOMER request with the 
 * QuickBooks_Queue class like this: 
 * 	$Queue = new QuickBooks_Queue('mysql://user:pass@host/database');
 * 	$Queue->enqueue(QUICKBOOKS_ADD_CUSTOMER, $primary_key_of_your_customer);
 * 
 * And you're registered a request and a response function with your $map 
 * parameter like this:
 * 	$map = array( 
 * 		QUICKBOOKS_ADD_CUSTOMER => array( '_quickbooks_customer_add_request', '_quickbooks_customer_add_response' ),
 * 	 );
 * 
 * This means that every time QuickBooks tries to process a 
 * QUICKBOOKS_ADD_CUSTOMER action, it will call the 
 * '_quickbooks_customer_add_request' function, expecting that function to 
 * generate a valid qbXML request which can be processed. So, this function 
 * will generate a qbXML CustomerAddRq which tells QuickBooks to add a 
 * customer. 
 * 
 * Our response function will in turn receive a qbXML response from QuickBooks 
 * which contains all of the data stored for that customer within QuickBooks. 
 * 
 * @param string $requestID					You should include this in your qbXML request (it helps with debugging later)
 * @param string $action					The QuickBooks action being performed (CustomerAdd in this case)
 * @param mixed $ID							The unique identifier for the record (maybe a customer ID number in your database or something)
 * @param array $extra						Any extra data you included with the queued item when you queued it up
 * @param string $err						An error message, assign a value to $err if you want to report an error
 * @param integer $last_action_time			A unix timestamp (seconds) indicating when the last action of this type was dequeued (i.e.: for CustomerAdd, the last time a customer was added, for CustomerQuery, the last time a CustomerQuery ran, etc.)
 * @param integer $last_actionident_time	A unix timestamp (seconds) indicating when the combination of this action and ident was dequeued (i.e.: when the last time a CustomerQuery with ident of get-new-customers was dequeued)
 * @param float $version					The max qbXML version your QuickBooks version supports
 * @param string $locale					
 * @return string							A valid qbXML request
 */
function _quickbooks_employee_add_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{
    
    $length = 0;
   include 'qb_dbmain.php';
   
   $stmt = $dbMain-> prepare("SELECT MAX(payroll_id) FROM qb_payroll_settled");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($payroll_id); 
   $stmt->fetch();
   $stmt->close();
   
  //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 	
   $stmt = $dbMain ->prepare("SELECT emp_fname, emp_mname, emp_lname, emp_street, emp_city, emp_state, emp_zip, emp_phone1, emp_phone2, social_security, type_key, payment_cycle, comp_type, hours_projected, total_hours, add_sub_one, add_sub_desc_one, add_sub_amount_one, add_sub_two,add_sub_desc_two, add_sub_amount_two, add_sub_three, add_sub_desc_three, add_sub_amount_three,
add_sub_four, add_sub_desc_four, add_sub_amount_four, commission_amount, base_payment_amount, ot_hours_tier_2, overtime, base_prorate_amount, total_payment_amount, payment_date,
close_date, consolidate FROM qb_payroll_settled WHERE user_id ='$ID' AND payroll_id = '$payroll_id'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($emp_fname, $emp_mname, $emp_lname, $emp_street, $emp_city, $emp_state, $emp_zip, $emp_phone1, $emp_phone2, $social_security, $type_key, $payment_cycle, $comp_type, $hours_projected, $total_hours, $add_sub_one, $add_sub_desc_one, $add_sub_amount_one, $add_sub_two,$add_sub_desc_two, $add_sub_amount_two, $add_sub_three, $add_sub_desc_three, $add_sub_amount_three, $add_sub_four, $add_sub_desc_four, $add_sub_amount_four, $commission_amount, $base_payment_amount, $ot_hours_tier_2, $overtime, $base_prorate_amount, $total_payment_amount, $payment_date, $close_date, $consolidate);
   $stmt->fetch();
   $emp_mname = substr($emp_mname,0,1);
   

   
   switch ($payment_cycle){
        case "D":
        $pay_period = "Daily";
        break;
        case "W":
        $pay_period = "Weekly";
        break;
        case "B":
        $pay_period = "Biweekly";
        break;
        case "M":
        $pay_period = "Monthly";
        break;
        }
    
   /* if ($payment_cycle == "B"){
    $pay_period = "Biweekly";
   }*/
   if ($comp_type == "H"){
    $payroll_item_wage_name = "Hourly";
    $payroll_item_wage_name_ot1 = "OT Regular";
    $payroll_item_wage_name_ot2 = "OT Double Time";
    $using_time_data = 1;
    $rate = $total_payment_amount / $total_hours;
    $rate = round($rate, 2);
    $rate_ot_1 = $rate * 1.5;
    $rate_ot_2 = $rate * 2;
    $using_time_data_paychecks = "UseTimeData";
    
    	$xml = 
               '<?xml version="1.0" encoding="utf-8"?>
                 <?qbxml version="6.0"?>
	           	  <QBXML>
	       		   <QBXMLMsgsRq onError="stopOnError">
                    <EmployeeAddRq requestID="' . $requestID . '">
				    	<EmployeeAdd>
                            <FirstName >'. $emp_fname . '</FirstName>
                            <MiddleName >'. $emp_mname . '</MiddleName>
                            <LastName >'. $emp_lname . '</LastName>
                            <EmployeeAddress>
                              <Addr1 >'. $emp_street . '</Addr1>
                              <City >'. $emp_city . '</City>
                              <State >'. $emp_state . '</State>
                              <PostalCode >'. $emp_zip . '</PostalCode>
                            </EmployeeAddress>
                            <Phone >'. $emp_phone1 . '</Phone>	
                            <Mobile >'. $emp_phone2 . '</Mobile>
                            <SSN >'. $social_security . '</SSN> 
                            <EmployeeType >Regular</EmployeeType>
                            <EmployeePayrollInfo>
                              <PayPeriod >'. $pay_period . '</PayPeriod>
                              <Earnings> 
                                <PayrollItemWageRef>
                                   <FullName >'. $payroll_item_wage_name . '</FullName>
                                </PayrollItemWageRef>
                                <Rate >'. $rate . '</Rate>
                              </Earnings>
                              <Earnings> 
                                <PayrollItemWageRef>
                                   <FullName >'. $payroll_item_wage_name_ot1 . '</FullName>
                                </PayrollItemWageRef>
                                <Rate >'. $rate_ot_1 . '</Rate>
                              </Earnings>
                              <Earnings> 
                                <PayrollItemWageRef>
                                   <FullName >'. $payroll_item_wage_name_ot2 . '</FullName>
                                </PayrollItemWageRef>
                                <Rate >'. $rate_ot_2 . '</Rate>
                              </Earnings>
                            <UseTimeDataToCreatePaychecks >'. $using_time_data_paychecks . '</UseTimeDataToCreatePaychecks>
                            </EmployeePayrollInfo>					
					</EmployeeAdd>
                  </EmployeeAddRq>
                 </QBXMLMsgsRq>
	           	</QBXML>';
    
                   }elseif ($comp_type == "S"){
                    $payroll_item_wage_name = "Salary";
                    $using_time_data = 0;
                    $rate = $total_payment_amount;
                    $using_time_data_paychecks = "DoNotUseTimeData";
                    $xml = 
                               '<?xml version="1.0" encoding="utf-8"?>
                                 <?qbxml version="6.0"?>
                	           	  <QBXML>
                	       		   <QBXMLMsgsRq onError="stopOnError">
                                    <EmployeeAddRq requestID="' . $requestID . '">
                				    	<EmployeeAdd>
                                            <FirstName >'. $emp_fname . '</FirstName>
                                            <MiddleName >'. $emp_mname . '</MiddleName>
                                            <LastName >'. $emp_lname . '</LastName>
                                            <EmployeeAddress>
                                              <Addr1 >'. $emp_street . '</Addr1>
                                              <City >'. $emp_city . '</City>
                                              <State >'. $emp_state . '</State>
                                              <PostalCode >'. $emp_zip . '</PostalCode>
                                            </EmployeeAddress>
                                            <Phone >'. $emp_phone1 . '</Phone>	
                                            <Mobile >'. $emp_phone2 . '</Mobile>
                                            <SSN >'. $social_security . '</SSN> 
                                            <EmployeeType >Regular</EmployeeType>
                                            <EmployeePayrollInfo>
                                              <PayPeriod >'. $pay_period . '</PayPeriod>
                                              <Earnings> 
                                                <PayrollItemWageRef>
                                                   <FullName >'. $payroll_item_wage_name . '</FullName>
                                                </PayrollItemWageRef>
                                                <Rate >'. $rate . '</Rate>
                                              </Earnings>
                                            <UseTimeDataToCreatePaychecks >'. $using_time_data_paychecks . '</UseTimeDataToCreatePaychecks>
                                            </EmployeePayrollInfo>					
                					</EmployeeAdd>
                                  </EmployeeAddRq>
                                 </QBXMLMsgsRq>
                	           	</QBXML>';
                    
                   }elseif ($comp_type == "HC"){
                    $payroll_item_wage_name_1 = "Hourly";
                    $payroll_item_wage_name_2 = "Commission";
                    $payroll_item_wage_name_ot1 = "OT Regular";
                    $payroll_item_wage_name_ot2 = "OT Double Time";
                    $using_time_data = 0;
                    $rate = $total_payment_amount / $total_hours;
                    $rate = round($rate, 2);
                    $rate_ot_1 = $rate * 1.5;
                    $rate_ot_2 = $rate * 2;
                    $Commission = $commission_amount;
                    $using_time_data_paychecks = "UseTimeData";
                    $xml = 
                               '<?xml version="1.0" encoding="utf-8"?>
                                 <?qbxml version="6.0"?>
                	           	  <QBXML>
                	       		   <QBXMLMsgsRq onError="stopOnError">
                                    <EmployeeAddRq requestID="' . $requestID . '">
                				    	<EmployeeAdd>
                                            <FirstName >'. $emp_fname . '</FirstName>
                                            <MiddleName >'. $emp_mname . '</MiddleName>
                                            <LastName >'. $emp_lname . '</LastName>
                                            <EmployeeAddress>
                                              <Addr1 >'. $emp_street . '</Addr1>
                                              <City >'. $emp_city . '</City>
                                              <State >'. $emp_state . '</State>
                                              <PostalCode >'. $emp_zip . '</PostalCode>
                                            </EmployeeAddress>
                                            <Phone >'. $emp_phone1 . '</Phone>	
                                            <Mobile >'. $emp_phone2 . '</Mobile>
                                            <SSN >'. $social_security . '</SSN> 
                                            <EmployeeType >Regular</EmployeeType>
                                            <EmployeePayrollInfo>
                                              <PayPeriod >'. $pay_period . '</PayPeriod>
                                              <Earnings> 
                                                <PayrollItemWageRef>
                                                   <FullName >'. $payroll_item_wage_name_1 . '</FullName>
                                                </PayrollItemWageRef>
                                                <Rate >'. $rate . '</Rate>
                                              </Earnings>
                                              <Earnings> 
                                                <PayrollItemWageRef>
                                                   <FullName >'. $payroll_item_wage_name_2 . '</FullName>
                                                </PayrollItemWageRef>
                                                <Rate >'. $Commission . '</Rate>
                                              </Earnings>
                                              <Earnings> 
                                                <PayrollItemWageRef>
                                                   <FullName >'. $payroll_item_wage_name_ot1 . '</FullName>
                                                </PayrollItemWageRef>
                                                <Rate >'. $rate_ot_1 . '</Rate>
                                              </Earnings>
                                              <Earnings> 
                                                <PayrollItemWageRef>
                                                   <FullName >'. $payroll_item_wage_name_ot2 . '</FullName>
                                                </PayrollItemWageRef>
                                                <Rate >'. $rate_ot_2 . '</Rate>
                                              </Earnings>
                                            <UseTimeDataToCreatePaychecks >'. $using_time_data_paychecks . '</UseTimeDataToCreatePaychecks>
                                            </EmployeePayrollInfo>					
                					</EmployeeAdd>
                                  </EmployeeAddRq>
                                 </QBXMLMsgsRq>
                	           	</QBXML>';
                    
                   }elseif ($comp_type == "SC"){
                    $payroll_item_wage_name_1 = "Salary";
                    $payroll_item_wage_name_2 = "Commission";
                    $using_time_data = 0;
                    $rate = $total_payment_amount;
                    $Commission = $commission_amount;
                    $using_time_data_paychecks = "DoNotUseTimeData";
                    $xml = 
                               '<?xml version="1.0" encoding="utf-8"?>
                                 <?qbxml version="6.0"?>
                	           	  <QBXML>
                	       		   <QBXMLMsgsRq onError="stopOnError">
                                    <EmployeeAddRq requestID="' . $requestID . '">
                				    	<EmployeeAdd>
                                            <FirstName >'. $emp_fname . '</FirstName>
                                            <MiddleName >'. $emp_mname . '</MiddleName>
                                            <LastName >'. $emp_lname . '</LastName>
                                            <EmployeeAddress>
                                              <Addr1 >'. $emp_street . '</Addr1>
                                              <City >'. $emp_city . '</City>
                                              <State >'. $emp_state . '</State>
                                              <PostalCode >'. $emp_zip . '</PostalCode>
                                            </EmployeeAddress>
                                            <Phone >'. $emp_phone1 . '</Phone>	
                                            <Mobile >'. $emp_phone2 . '</Mobile>
                                            <SSN >'. $social_security . '</SSN> 
                                            <EmployeeType >Regular</EmployeeType>
                                            <EmployeePayrollInfo>
                                              <PayPeriod >'. $pay_period . '</PayPeriod>
                                              <Earnings> 
                                                <PayrollItemWageRef>
                                                   <FullName >'. $payroll_item_wage_name_1 . '</FullName>
                                                </PayrollItemWageRef>
                                                <Rate >'. $rate . '</Rate>
                                              </Earnings>
                                              <Earnings> 
                                                <PayrollItemWageRef>
                                                   <FullName >'. $payroll_item_wage_name_2 . '</FullName>
                                                </PayrollItemWageRef>
                                                <Rate >'. $Commission . '</Rate>
                                              </Earnings>
                                            <UseTimeDataToCreatePaychecks >'. $using_time_data_paychecks . '</UseTimeDataToCreatePaychecks>
                                            </EmployeePayrollInfo>					
                					</EmployeeAdd>
                                  </EmployeeAddRq>
                                 </QBXMLMsgsRq>
                	           	</QBXML>';
                    
                   }
    
    
   		
   $stmt->close();
   return trim($xml);
}
//===================================================================================================================================================
/**
 * Receive a response from QuickBooks 
 * 
 * @param string $requestID					The requestID you passed to QuickBooks previously
 * @param string $action					The action that was performed (CustomerAdd in this case)
 * @param mixed $ID							The unique identifier of the record
 * @param array $extra			
 * @param string $err						An error message, assign a valid to $err if you want to report an error
 * @param integer $last_action_time			A unix timestamp (seconds) indicating when the last action of this type was dequeued (i.e.: for CustomerAdd, the last time a customer was added, for CustomerQuery, the last time a CustomerQuery ran, etc.)
 * @param integer $last_actionident_time	A unix timestamp (seconds) indicating when the combination of this action and ident was dequeued (i.e.: when the last time a CustomerQuery with ident of get-new-customers was dequeued)
 * @param string $xml						The complete qbXML response
 * @param array $idents						An array of identifiers that are contained in the qbXML response
 * @return void
 */
function _quickbooks_employee_add_response($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
{	
	// Great, customer $ID has been added to QuickBooks with a QuickBooks 
	//	ListID value of: $idents['ListID']
	// 
	// We probably want to store that ListID in our database, so we can use it 
	//	later. (You'll need to refer to the customer by either ListID or Name 
	//	in other requests, say, to update the customer or to add an invoice for 
	//	the customer. 
    include 'qb_dbmain.php';
    
  	$user_id = $ID;
    $list_id = $idents['ListID'];
    $edit_sequence = $idents['EditSequence'];
    
    //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin');   
	
	$stmt = $dbMain-> prepare("SELECT COUNT(*) AS count FROM qb_employee_info WHERE user_id = '$user_id' ");
	$stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($count);
	$stmt->fetch();
	
	if($count == 0) {
	   $match =  false;
	  }else{
	   $match =  true;	  
	  }
    
    
    //$match = loadEmployeeCompare($user_id);
    
    if($match == false) {
    //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 
    $sql = "INSERT INTO qb_employee_info VALUES (?,?,?)";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('iss',$user_id, $list_id, $edit_sequence);
    $stmt->execute();        
    $stmt->close();
        }else{
            //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 
            $sql = "UPDATE qb_employee_info  SET list_id = ?, edit_sequence = ?  WHERE user_id = '$ID'";
            $stmt = $dbMain->prepare($sql);
            $stmt->bind_param('ss', $list_id, $edit_sequence);
            $stmt->execute();        
            $stmt->close();
         }
  /*
	mysql_query("UPDATE your_customer_table SET quickbooks_listid = '" . mysql_escape_string($idents['ListID']) . "' WHERE user_id = " . (int) $ID);
	*/
}
//======================================================================================================================================
/** 
 * 
 * @param string $requestID					You should include this in your qbXML request (it helps with debugging later)
 * @param string $action					The QuickBooks action being performed (CustomerAdd in this case)
 * @param mixed $ID							The unique identifier for the record (maybe a customer ID number in your database or something)
 * @param array $extra						Any extra data you included with the queued item when you queued it up
 * @param string $err						An error message, assign a value to $err if you want to report an error
 * @param integer $last_action_time			A unix timestamp (seconds) indicating when the last action of this type was dequeued (i.e.: for CustomerAdd, the last time a customer was added, for CustomerQuery, the last time a CustomerQuery ran, etc.)
 * @param integer $last_actionident_time	A unix timestamp (seconds) indicating when the combination of this action and ident was dequeued (i.e.: when the last time a CustomerQuery with ident of get-new-customers was dequeued)
 * @param float $version					The max qbXML version your QuickBooks version supports
 * @param string $locale					
 * @return string							A valid qbXML request
 */
function _quickbooks_employee_mod_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{
    include 'qb_dbmain.php';
	/*
		<CustomerRef>
			<ListID>80003579-1231522938</ListID>
		</CustomerRef>	
	*/
	//$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin');   
    $stmt = $dbMain-> prepare("SELECT MAX(payroll_id) FROM qb_payroll_settled");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($payroll_id); 
   $stmt->fetch();
   $stmt->close();
   
    $user_id = $ID;
	
	$stmt = $dbMain-> prepare("SELECT list_id, edit_sequence FROM qb_employee_info WHERE user_id = '$user_id' ");
	$stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($list_id, $edit_sequence);
	$stmt->fetch();
    $stmt->close();
	
    $employeeAdd = "";
    $length = 0;
    $qb_id = "";
   
  //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 	
   $stmt = $dbMain ->prepare("SELECT emp_fname, emp_mname, emp_lname, emp_street, emp_city, emp_state, emp_zip, emp_phone1, emp_phone2, social_security, type_key, payment_cycle, comp_type, hours_projected, total_hours, add_sub_one, add_sub_desc_one, add_sub_amount_one, add_sub_two,add_sub_desc_two, add_sub_amount_two, add_sub_three, add_sub_desc_three, add_sub_amount_three,
add_sub_four, add_sub_desc_four, add_sub_amount_four, commission_amount, base_payment_amount,  ot_hours_tier_2, overtime, base_prorate_amount, total_payment_amount, payment_date, close_date, consolidate FROM qb_payroll_settled WHERE user_id ='$ID' AND payroll_id = '$payroll_id'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($emp_fname, $emp_mname, $emp_lname, $emp_street, $emp_city, $emp_state, $emp_zip, $emp_phone1, $emp_phone2, $social_security, $type_key, $payment_cycle, $comp_type, $hours_projected, $total_hours, $add_sub_one, $add_sub_desc_one, $add_sub_amount_one, $add_sub_two,$add_sub_desc_two, $add_sub_amount_two, $add_sub_three, $add_sub_desc_three, $add_sub_amount_three, $add_sub_four, $add_sub_desc_four, $add_sub_amount_four, $commission_amount, $base_payment_amount, $ot_hours_tier_2, $overtime, $base_prorate_amount, $total_payment_amount, $payment_date, $close_date, $consolidate);
   $stmt->fetch();
  
   $emp_mname = substr($emp_mname,0,1);
   
   $qb_id_join = "$list_id-$edit_sequence";
   $qb_id_array = explode("-", $qb_id_join);
   $l_id = $qb_id_array[0];
   $e_seq = $qb_id_array[1];
   $qb_id = "$l_id-$e_seq";
   
    switch ($payment_cycle){
        case "D":
        $pay_period = "Daily";
        break;
        case "W":
        $pay_period = "Weekly";
        break;
        case "B":
        $pay_period = "Biweekly";
        break;
        case "M":
        $pay_period = "Monthly";
        break;
        }
    
   /* if ($payment_cycle == "B"){
    $pay_period = "Biweekly";
   }*/
   if ($comp_type == "H"){
    $payroll_item_wage_name = "Hourly";
    $payroll_item_wage_name_ot1 = "OT Regular";
    $payroll_item_wage_name_ot2 = "OT Double Time";
    $using_time_data = 1;
    $rate = $total_payment_amount / $total_hours;
    $rate = round($rate, 2);
    $rate_ot_1 = $rate * 1.5;
    $rate_ot_2 = $rate * 2;
    $using_time_data_paychecks = "UseTimeData";
    
    $xml = 
               '<?xml version="1.0" encoding="utf-8"?>
                    <?qbxml version="6.0"?>
                    <QBXML>
                      <QBXMLMsgsRq onError="stopOnError">
                        <EmployeeModRq requestID="' . $requestID . '">
                          <EmployeeMod>
                            <ListID>'. $qb_id . '</ListID>
                            <EditSequence >'. $edit_sequence . '</EditSequence>
                            <FirstName>'. $emp_fname . '</FirstName>
                            <MiddleName>'. $emp_mname . '</MiddleName>
                            <LastName>'. $emp_lname . '</LastName>
                            <EmployeeAddress>
                                  <Addr1 >'. $emp_street . '</Addr1>
                                  <City >'. $emp_city . '</City>
                                  <State >'. $emp_state . '</State>
                                  <PostalCode>'. $emp_zip . '</PostalCode>
                            </EmployeeAddress>
                            <Phone>'. $emp_phone1 . '</Phone>
                            <Mobile>'. $emp_phone2 . '</Mobile> 
                                <EmployeePayrollInfoMod>
                                    <PayPeriod >'. $pay_period . '</PayPeriod>
                                        <Earnings>
                                            <PayrollItemWageRef>
                                            <FullName >'. $payroll_item_wage_name . '</FullName>
                                            </PayrollItemWageRef>
                                            <Rate >'. $rate . '</Rate>
                                        </Earnings>
                                        <Earnings> 
                                            <PayrollItemWageRef>
                                               <FullName >'. $payroll_item_wage_name_ot1 . '</FullName>
                                            </PayrollItemWageRef>
                                            <Rate >'. $rate_ot_1 . '</Rate>
                                        </Earnings>
                                        <Earnings> 
                                            <PayrollItemWageRef>
                                               <FullName >'. $payroll_item_wage_name_ot2 . '</FullName>
                                            </PayrollItemWageRef>
                                            <Rate >'. $rate_ot_2 . '</Rate>
                                        </Earnings>
                                    <UseTimeDataToCreatePaychecks>'. $using_time_data_paychecks . '</UseTimeDataToCreatePaychecks>
                                </EmployeePayrollInfoMod>
                        </EmployeeMod>
                      </EmployeeModRq>
    	             </QBXMLMsgsRq>
		          </QBXML>';
   }elseif ($comp_type == "S"){
    $payroll_item_wage_name = "Salary";
    $using_time_data = 0;
    $rate = $total_payment_amount;
    $using_time_data_paychecks = "DoNotUseTimeData";
    
    $xml = 
               '<?xml version="1.0" encoding="utf-8"?>
                    <?qbxml version="6.0"?>
                    <QBXML>
                      <QBXMLMsgsRq onError="stopOnError">
                        <EmployeeModRq requestID="' . $requestID . '">
                          <EmployeeMod>
                            <ListID>'. $qb_id . '</ListID>
                            <EditSequence >'. $edit_sequence . '</EditSequence>
                            <FirstName>'. $emp_fname . '</FirstName>
                            <MiddleName>'. $emp_mname . '</MiddleName>
                            <LastName>'. $emp_lname . '</LastName>
                            <EmployeeAddress>
                                  <Addr1 >'. $emp_street . '</Addr1>
                                  <City >'. $emp_city . '</City>
                                  <State >'. $emp_state . '</State>
                                  <PostalCode>'. $emp_zip . '</PostalCode>
                            </EmployeeAddress>
                            <Phone>'. $emp_phone1 . '</Phone>
                            <Mobile>'. $emp_phone2 . '</Mobile> 
                                <EmployeePayrollInfoMod>
                                    <PayPeriod >'. $pay_period . '</PayPeriod>
                                        <Earnings>
                                            <PayrollItemWageRef>
                                            <FullName >'. $payroll_item_wage_name . '</FullName>
                                            </PayrollItemWageRef>
                                            <Rate >'. $rate . '</Rate>
                                        </Earnings>
                                    <UseTimeDataToCreatePaychecks>'. $using_time_data_paychecks . '</UseTimeDataToCreatePaychecks>
                                </EmployeePayrollInfoMod>
                        </EmployeeMod>
                      </EmployeeModRq>
    	             </QBXMLMsgsRq>
		          </QBXML>';
   }elseif ($comp_type == "HC"){
    $payroll_item_wage_name_1 = "Hourly";
    $payroll_item_wage_name_2 = "Commission";
    $payroll_item_wage_name_ot1 = "OT Regular";
    $payroll_item_wage_name_ot2 = "OT Double Time";
    $using_time_data = 0;
    $rate = $total_payment_amount / $total_hours;
    $rate = round($rate, 2);
    $rate_ot_1 = $rate * 1.5;
    $rate_ot_2 = $rate * 2;
    $Commission = $commission_amount;
    $using_time_data_paychecks = "UseTimeData";
    
    $xml = 
               '<?xml version="1.0" encoding="utf-8"?>
                    <?qbxml version="6.0"?>
                    <QBXML>
                      <QBXMLMsgsRq onError="stopOnError">
                        <EmployeeModRq requestID="' . $requestID . '">
                          <EmployeeMod>
                            <ListID>'. $qb_id . '</ListID>
                            <EditSequence >'. $edit_sequence . '</EditSequence>
                            <FirstName>'. $emp_fname . '</FirstName>
                            <MiddleName>'. $emp_mname . '</MiddleName>
                            <LastName>'. $emp_lname . '</LastName>
                            <EmployeeAddress>
                                  <Addr1 >'. $emp_street . '</Addr1>
                                  <City >'. $emp_city . '</City>
                                  <State >'. $emp_state . '</State>
                                  <PostalCode>'. $emp_zip . '</PostalCode>
                            </EmployeeAddress>
                            <Phone>'. $emp_phone1 . '</Phone>
                            <Mobile>'. $emp_phone2 . '</Mobile> 
                                <EmployeePayrollInfoMod>
                                    <PayPeriod >'. $pay_period . '</PayPeriod>
                                        <Earnings>
                                            <PayrollItemWageRef>
                                            <FullName >'. $payroll_item_wage_name_1 . '</FullName>
                                            </PayrollItemWageRef>
                                            <Rate >'. $rate . '</Rate>
                                        </Earnings>
                                        <Earnings>
                                            <PayrollItemWageRef>
                                            <FullName >'. $payroll_item_wage_name_2 . '</FullName>
                                            </PayrollItemWageRef>
                                            <Rate >'. $Commission . '</Rate>
                                        </Earnings>
                                         <Earnings> 
                                            <PayrollItemWageRef>
                                               <FullName >'. $payroll_item_wage_name_ot1 . '</FullName>
                                            </PayrollItemWageRef>
                                            <Rate >'. $rate_ot_1 . '</Rate>
                                        </Earnings>
                                        <Earnings> 
                                            <PayrollItemWageRef>
                                               <FullName >'. $payroll_item_wage_name_ot2 . '</FullName>
                                            </PayrollItemWageRef>
                                            <Rate >'. $rate_ot_2 . '</Rate>
                                        </Earnings>
                                    <UseTimeDataToCreatePaychecks>'. $using_time_data_paychecks . '</UseTimeDataToCreatePaychecks>
                                </EmployeePayrollInfoMod>
                        </EmployeeMod>
                      </EmployeeModRq>
    	             </QBXMLMsgsRq>
		          </QBXML>';
   }elseif ($comp_type == "SC"){
    $payroll_item_wage_name_1 = "Salary";
    $payroll_item_wage_name_2 = "Commission";
    $using_time_data = 0;
    $rate = $total_payment_amount;
    $Commission = $commission_amount;
    $using_time_data_paychecks = "DoNotUseTimeData";
    
    $xml = 
               '<?xml version="1.0" encoding="utf-8"?>
                    <?qbxml version="6.0"?>
                    <QBXML>
                      <QBXMLMsgsRq onError="stopOnError">
                        <EmployeeModRq requestID="' . $requestID . '">
                          <EmployeeMod>
                            <ListID>'. $qb_id . '</ListID>
                            <EditSequence >'. $edit_sequence . '</EditSequence>
                            <FirstName>'. $emp_fname . '</FirstName>
                            <MiddleName>'. $emp_mname . '</MiddleName>
                            <LastName>'. $emp_lname . '</LastName>
                            <EmployeeAddress>
                                  <Addr1 >'. $emp_street . '</Addr1>
                                  <City >'. $emp_city . '</City>
                                  <State >'. $emp_state . '</State>
                                  <PostalCode>'. $emp_zip . '</PostalCode>
                            </EmployeeAddress>
                            <Phone>'. $emp_phone1 . '</Phone>
                            <Mobile>'. $emp_phone2 . '</Mobile> 
                                <EmployeePayrollInfoMod>
                                    <PayPeriod >'. $pay_period . '</PayPeriod>
                                        <Earnings>
                                            <PayrollItemWageRef>
                                            <FullName >'. $payroll_item_wage_name_1 . '</FullName>
                                            </PayrollItemWageRef>
                                            <Rate >'. $rate . '</Rate>
                                        </Earnings>
                                        <Earnings>
                                            <PayrollItemWageRef>
                                            <FullName >'. $payroll_item_wage_name_2 . '</FullName>
                                            </PayrollItemWageRef>
                                            <Rate >'. $Commission . '</Rate>
                                        </Earnings>
                                    <UseTimeDataToCreatePaychecks>'. $using_time_data_paychecks . '</UseTimeDataToCreatePaychecks>
                                </EmployeePayrollInfoMod>
                        </EmployeeMod>
                      </EmployeeModRq>
    	             </QBXMLMsgsRq>
		          </QBXML>';
   }            
   
  
   
   			
     
    $stmt->close();
    return trim($xml);
    
                
  }
//===============================================================================================================================================
/**
 * Receive a response from QuickBooks 
 * 
 * @param string $requestID					The requestID you passed to QuickBooks previously
 * @param string $action					The action that was performed (CustomerAdd in this case)
 * @param mixed $ID							The unique identifier of the record
 * @param array $extra			
 * @param string $err						An error message, assign a valid to $err if you want to report an error
 * @param integer $last_action_time			A unix timestamp (seconds) indicating when the last action of this type was dequeued (i.e.: for CustomerAdd, the last time a customer was added, for CustomerQuery, the last time a CustomerQuery ran, etc.)
 * @param integer $last_actionident_time	A unix timestamp (seconds) indicating when the combination of this action and ident was dequeued (i.e.: when the last time a CustomerQuery with ident of get-new-customers was dequeued)
 * @param string $xml						The complete qbXML response
 * @param array $idents						An array of identifiers that are contained in the qbXML response
 * @return void
 */
function _quickbooks_employee_mod_response($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
{	
    include 'qb_dbmain.php';
    
	$user_id = $ID;
    $list_id = $idents['ListID'];
    $edit_sequence = $idents['EditSequence'];
    
    //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin');   
	
	$stmt = $dbMain-> prepare("SELECT COUNT(*) AS count FROM qb_employee_info WHERE user_id = '$user_id' ");
	$stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($count);
	$stmt->fetch();
	
	if($count == 0) {
	   $match =  false;
	  }else{
	   $match =  true;	  
	  }
    
    
    //$match = loadEmployeeCompare($user_id);
    
    if($match == false) {
    //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 
    $sql = "INSERT INTO qb_employee_info VALUES (?,?,?)";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('iss',$user_id, $list_id, $edit_sequence);
    $stmt->execute();        
    $stmt->close();
        }else{
            //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 
            $sql = "UPDATE qb_employee_info  SET list_id = ?, edit_sequence = ?  WHERE user_id = '$ID'";
            $stmt = $dbMain->prepare($sql);
            $stmt->bind_param('ss', $list_id, $edit_sequence);
            $stmt->execute();        
            $stmt->close();
         }
}
//=========================================================================================================================
function _quickbooks_employee_query_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{
    include 'qb_dbmain.php';
    $length = 0;
    $full_name = "";
   
  //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 	
   $stmt = $dbMain ->prepare("SELECT emp_fname, emp_mname, emp_lname FROM qb_payroll_settled WHERE user_id ='$ID'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($emp_fname, $emp_mname, $emp_lname);
   $stmt->fetch();
   $emp_mname = substr($emp_mname,0,1);
   $full_name = "$emp_fname $emp_mname $emp_lname";
    
   			$xml = 
               '<?xml version="1.0" encoding="utf-8"?>
                 <?qbxml version="6.0"?>
	           	  <QBXML>
	       		   <QBXMLMsgsRq onError="stopOnError">
                    <EmployeeQueryRq requestID="' . $requestID . '">
                            <NameFilter> 
                            <MatchCriterion >EndsWith</MatchCriterion>
                            <Name >'. $emp_lname . '</Name>
                            </NameFilter>			
                  </EmployeeQueryRq>
                 </QBXMLMsgsRq>
	           	</QBXML>';
   $stmt->close();
   return trim($xml);
}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function _quickbooks_employee_query_response($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
{	
    include 'qb_dbmain.php';
	// Great, customer $ID has been added to QuickBooks with a QuickBooks 
	//	ListID value of: $idents['ListID']
	// 
	// We probably want to store that ListID in our database, so we can use it 
	//	later. (You'll need to refer to the customer by either ListID or Name 
	//	in other requests, say, to update the customer or to add an invoice for 
	//	the customer. 
  	$user_id = $ID;
    $list_id = $idents['ListID'];
    $edit_sequence = $idents['EditSequence'];
    $txn_id = 0;
    
    //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 
    $sql = "INSERT INTO qb_employee_info VALUES (?,?,?)";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('iss',$user_id, $list_id, $edit_sequence);
    $stmt->execute();        
    $stmt->close();
    
  /*
	mysql_query("UPDATE your_customer_table SET quickbooks_listid = '" . mysql_escape_string($idents['ListID']) . "' WHERE user_id = " . (int) $ID);
	*/
}

//======================================================================================================================================
function _quickbooks_timetracking_add_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{
    include 'qb_dbmain.php';
    $stmt = $dbMain-> prepare("SELECT MAX(payroll_id) FROM qb_payroll_settled");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($payroll_id); 
   $stmt->fetch();
   $stmt->close();
    //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin');   
   
    $user_id = $ID;
	
	$stmt = $dbMain-> prepare("SELECT list_id, edit_sequence FROM qb_employee_info WHERE user_id = '$user_id' ");
	$stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($list_id, $edit_sequence);
	$stmt->fetch();
    $stmt->close();


  //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 	
   $stmt = $dbMain ->prepare("SELECT emp_fname, emp_mname, emp_lname, emp_street, emp_city, emp_state, emp_zip, emp_phone1, emp_phone2, social_security, type_key, payment_cycle, comp_type, hours_projected, total_hours, add_sub_one, add_sub_desc_one, add_sub_amount_one, add_sub_two,add_sub_desc_two, add_sub_amount_two, add_sub_three, add_sub_desc_three, add_sub_amount_three,
add_sub_four, add_sub_desc_four, add_sub_amount_four, commission_amount, base_payment_amount, ot_hours_tier_2, overtime, base_prorate_amount, total_payment_amount, payment_date,
close_date, consolidate FROM qb_payroll_settled WHERE user_id ='$ID' AND payroll_id = '$payroll_id'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($emp_fname, $emp_mname, $emp_lname, $emp_street, $emp_city, $emp_state, $emp_zip, $emp_phone1, $emp_phone2, $social_security, $type_key, $payment_cycle, $comp_type, $hours_projected, $total_hours, $add_sub_one, $add_sub_desc_one, $add_sub_amount_one, $add_sub_two,$add_sub_desc_two, $add_sub_amount_two, $add_sub_three, $add_sub_desc_three, $add_sub_amount_three, $add_sub_four, $add_sub_desc_four, $add_sub_amount_four, $commission_amount, $base_payment_amount, $ot_hours_tier_2, $overtime, $base_prorate_amount, $total_payment_amount, $payment_date, $close_date, $consolidate);
   $stmt->fetch();
   $stmt->close();
   
   $stmt = $dbMain ->prepare("SELECT old_user_id, type_key FROM qb_second_job_userid WHERE new_user_id = '$user_id' AND type_key = '$type_key'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($user_id2, $type_key2); 
$stmt->fetch();
$rowCount = $stmt->num_rows;
$stmt->close();
if($rowCount > 0){
     $stmt = $dbMain-> prepare("SELECT comp_amount FROM basic_compensation WHERE user_id = '$user_id2' AND comp_type = '$comp_type' AND type_key = '$type_key2'");
	$stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($comp_amount);
	$stmt->fetch();
    $stmt->close();
}elseif ($rowCount <= 0){
     $stmt = $dbMain-> prepare("SELECT comp_amount FROM basic_compensation WHERE user_id = '$user_id' AND comp_type = '$comp_type' AND type_key = '$type_key'");
	$stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($comp_amount);
	$stmt->fetch();
    $stmt->close();
}

  
  
  $total_hours = sprintf("%01.2f", $total_hours);
  $array = explode(".", $total_hours);
  $time_interval = "PT$array[0]H$array[1]M0S";
  
  $ot_hours_tier_2 = $ot_hours_tier_2 /($comp_amount * 2);
  $ot_hours_tier_2 = sprintf("%01.2f", $ot_hours_tier_2);
  $array = explode(".", $ot_hours_tier_2);
  $time_interval_2 = "PT$array[0]H$array[1]M0S";
  
  $overtime = $overtime / ($comp_amount * 1.5);
  $overtime = sprintf("%01.2f", $overtime);
  $array = explode(".", $overtime);
  
  $time_interval_3 = "PT$array[0]H$array[1]M0S";
  
  
   $qb_id_join = "$list_id-$edit_sequence";
   $qb_id_array = explode("-", $qb_id_join);
   $l_id = $qb_id_array[0];
   $e_seq = $qb_id_array[1];
   $qb_id = "$l_id-$e_seq";
   
    if (($comp_type == "H") OR ($comp_type == "HC")){
    $payroll_item_wage_name = "Hourly";
    $payroll_item_wage_name_ot1 = "OT Regular";
    $payroll_item_wage_name_ot2 = "OT Double Time";
   }
   if (($comp_type == "S") OR ($comp_type == "SC")){
    $payroll_item_wage_name = "Salary";
    $payroll_item_wage_name_ot1 = "OT Regular";
    $payroll_item_wage_name_ot2 = "OT Double Time";
   }
   
   			$xml = 
               '<?xml version="1.0" encoding="utf-8"?>
                <?qbxml version="2.1"?>
                <QBXML>
                    <QBXMLMsgsRq onError="stopOnError">
                        <TimeTrackingAddRq requestID="' . $requestID . '">
                            <TimeTrackingAdd>
                                <TxnDate >'. $close_date . '</TxnDate>
                                <EntityRef> 
                                    <ListID >'. $qb_id . '</ListID> 
                                </EntityRef>
                                <Duration >'. $time_interval . '</Duration>
                                <PayrollItemWageRef>
                                <FullName >'. $payroll_item_wage_name . '</FullName>
                                </PayrollItemWageRef>
                                <IsBillable>0</IsBillable>
                            </TimeTrackingAdd>
                        </TimeTrackingAddRq>
                        <TimeTrackingAddRq requestID="' . $requestID . '">
                            <TimeTrackingAdd>
                                <TxnDate >'. $close_date . '</TxnDate>
                                <EntityRef> 
                                    <ListID >'. $qb_id . '</ListID> 
                                </EntityRef>
                                <Duration >'. $time_interval_3 . '</Duration>
                                <PayrollItemWageRef>
                                <FullName >'. $payroll_item_wage_name_ot1 . '</FullName>
                                </PayrollItemWageRef>
                                <IsBillable>0</IsBillable>
                            </TimeTrackingAdd>
                        </TimeTrackingAddRq>
                        <TimeTrackingAddRq requestID="' . $requestID . '">
                            <TimeTrackingAdd>
                                <TxnDate >'. $close_date . '</TxnDate>
                                <EntityRef> 
                                    <ListID >'. $qb_id . '</ListID> 
                                </EntityRef>
                                <Duration >'. $time_interval_2 . '</Duration>
                                <PayrollItemWageRef>
                                <FullName >'. $payroll_item_wage_name_ot2 . '</FullName>
                                </PayrollItemWageRef>
                                <IsBillable>0</IsBillable>
                            </TimeTrackingAdd>
                        </TimeTrackingAddRq>
                    </QBXMLMsgsRq>
                </QBXML>';
     
    
    return trim($xml);          
    }
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function _quickbooks_timetracking_add_response($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
{	
    include 'qb_dbmain.php';
	$user_id = $ID;
    $edit_sequence = $idents['EditSequence'];
    $txn_id =  $idents['TxnID'];
    
    $stmt = $dbMain-> prepare("SELECT MAX(payroll_id) FROM qb_payroll_settled");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($payroll_id); 
   $stmt->fetch();
   $stmt->close();
    
    //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 	
    $stmt = $dbMain ->prepare("SELECT close_date FROM qb_payroll_settled WHERE user_id ='$ID' AND payroll_id = '$payroll_id'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($close_date);
    $stmt->fetch();
   
    $txn_date = $close_date;
    
    //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin');   
	
	$stmt = $dbMain-> prepare("SELECT COUNT(*) AS count FROM qb_txn WHERE user_id = '$user_id' ");
	$stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($count);
	$stmt->fetch();
	
	if($count == 0) {
	   $match =  false;
	  }else{
	   $match =  true;	  
	  }
    
    
    //$match = loadEmployeeCompare($user_id);
    
    if($match == false) {
    //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 
    $sql = "INSERT INTO qb_txn VALUES (?,?,?,?)";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('isss',$user_id, $txn_date, $txn_id, $edit_sequence);
    $stmt->execute();        
    $stmt->close();
        }else{
            //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 
            $sql = "UPDATE qb_txn  SET txn_id = ?, edit_sequence = ?, txn_date = ?  WHERE user_id = '$ID'";
            $stmt = $dbMain->prepare($sql);
            $stmt->bind_param('ss', $txn_id, $edit_sequence,$txn_date);
            $stmt->execute();        
            $stmt->close();
         }
}
//=========================================================================================================
function _quickbooks_timetracking_mod_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{
    include 'qb_dbmain.php';
	/*
		<CustomerRef>
			<ListID>80003579-1231522938</ListID>
		</CustomerRef>	
	*/
	//$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin');   
    $stmt = $dbMain-> prepare("SELECT MAX(payroll_id) FROM qb_payroll_settled");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($payroll_id); 
   $stmt->fetch();
   $stmt->close();
   
    $user_id = $ID;
    
    $stmt = $dbMain-> prepare("SELECT list_id FROM qb_employee_info WHERE user_id = '$user_id' ");
	$stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($list_id);
	$stmt->fetch();
    $stmt->close();
	
	$stmt = $dbMain-> prepare("SELECT txn_id, edit_sequence FROM qb_txn WHERE user_id = '$user_id' ");
	$stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($txn_id, $edit_sequence);
	$stmt->fetch();
    $stmt->close();
	
    $employeeAdd = "";
    $length = 0;
    $qb_id = "";
   
  //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 	
   $stmt = $dbMain ->prepare("SELECT emp_fname, emp_mname, emp_lname, emp_street, emp_city, emp_state, emp_zip, emp_phone1, emp_phone2, social_security, type_key, payment_cycle, comp_type, hours_projected, total_hours, add_sub_one, add_sub_desc_one, add_sub_amount_one, add_sub_two,add_sub_desc_two, add_sub_amount_two, add_sub_three, add_sub_desc_three, add_sub_amount_three,
add_sub_four, add_sub_desc_four, add_sub_amount_four, commission_amount, base_payment_amount, ot_hours_tier_2, overtime, base_prorate_amount, total_payment_amount, payment_date,
close_date, consolidate FROM qb_payroll_settled WHERE user_id ='$ID' AND payroll_id = '$payroll_id'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($emp_fname, $emp_mname, $emp_lname, $emp_street, $emp_city, $emp_state, $emp_zip, $emp_phone1, $emp_phone2, $social_security, $type_key, $payment_cycle, $comp_type, $hours_projected, $total_hours, $add_sub_one, $add_sub_desc_one, $add_sub_amount_one, $add_sub_two,$add_sub_desc_two, $add_sub_amount_two, $add_sub_three, $add_sub_desc_three, $add_sub_amount_three, $add_sub_four, $add_sub_desc_four, $add_sub_amount_four, $commission_amount, $base_payment_amount, $ot_hours_tier_2, $overtime, $base_prorate_amount, $total_payment_amount, $payment_date, $close_date, $consolidate);
   $stmt->fetch();
  
   $emp_mname = substr($emp_mname,0,1);
   
   $stmt = $dbMain-> prepare("SELECT comp_amount FROM basic_compensation WHERE user_id = '$user_id' AND comp_type = '$comp_type'");
	$stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($comp_amount);
	$stmt->fetch();
    $stmt->close();
  
  $total_hours = sprintf("%01.2f", $total_hours);
  $array = explode(".", $total_hours);
  $time_interval = "PT$array[0]H$array[1]M0S";
  
  $ot_hours_tier_2 = $ot_hours_tier_2 /($comp_amount * 2);
  $ot_hours_tier_2 = sprintf("%01.2f", $ot_hours_tier_2);
  $array = explode(".", $ot_hours_tier_2);
  $time_interval_2 = "PT$array[0]H$array[1]M0S";
  
  $overtime = $overtime / ($comp_amount * 1.5);
  $overtime = sprintf("%01.2f", $overtime);
  $array = explode(".", $overtime);
  
  $time_interval_3 = "PT$array[0]H$array[1]M0S";
   
  
   
   			$xml = 
               '<?xml version="1.0" encoding="utf-8"?>
                <?qbxml version="6.0"?>
                <QBXML>
                  <QBXMLMsgsRq onError="stopOnError">
                    <TimeTrackingModRq requestID="' . $requestID . '">
                      <TimeTrackingMod> 
                       <TxnID>'. $txn_id . '</TxnID> 
                       <EditSequence >'. $edit_sequence . '</EditSequence>
                        <TxnDate >'. $close_date . '</TxnDate>
                         <EntityRef> 
                            <ListID >'. $list_id . '</ListID>
                         </EntityRef>
                        <Duration >'. $time_interval . '</Duration> 
                    </TimeTrackingMod>
                </TimeTrackingModRq>
                <TimeTrackingModRq requestID="' . $requestID . '">
                      <TimeTrackingMod> 
                       <TxnID>'. $txn_id . '</TxnID> 
                       <EditSequence >'. $edit_sequence . '</EditSequence>
                        <TxnDate >'. $close_date . '</TxnDate>
                         <EntityRef> 
                            <ListID >'. $list_id . '</ListID>
                         </EntityRef>
                        <Duration >'. $time_interval_3 . '</Duration> 
                    </TimeTrackingMod>
                    <TimeTrackingModRq requestID="' . $requestID . '">
                      <TimeTrackingMod> 
                       <TxnID>'. $txn_id . '</TxnID> 
                       <EditSequence >'. $edit_sequence . '</EditSequence>
                        <TxnDate >'. $close_date . '</TxnDate>
                         <EntityRef> 
                            <ListID >'. $list_id . '</ListID>
                         </EntityRef>
                        <Duration >'. $time_interval_2 . '</Duration> 
                    </TimeTrackingMod>
                </TimeTrackingModRq>
                </TimeTrackingModRq>
                </QBXMLMsgsRq>
                </QBXML>';
     
    $stmt->close();
    return trim($xml);
    
   }
   
//=========================================================================================================================================
function _quickbooks_timetracking_mod_response($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents){
    
    include 'qb_dbmain.php';
    
    
    $user_id = $ID;
    $edit_sequence = $idents['EditSequence'];
    $txn_id =  $idents['TxnID'];
    
    $stmt = $dbMain-> prepare("SELECT MAX(payroll_id) FROM qb_payroll_settled");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($payroll_id); 
   $stmt->fetch();
   $stmt->close();
    
    //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 	
   $stmt = $dbMain ->prepare("SELECT close_date FROM qb_payroll_settled WHERE user_id ='$ID' AND payroll_id = '$payroll_id'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($close_date);
   $stmt->fetch();
    
    $txn_date = "$close_date";
    
    //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin');   
	
	$stmt = $dbMain-> prepare("SELECT COUNT(*) AS count FROM qb_txn WHERE user_id = '$user_id' ");
	$stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($count);
	$stmt->fetch();
	
	if($count == 0) {
	   $match =  false;
	  }else{
	   $match =  true;	  
	  }
    
    
    //$match = loadEmployeeCompare($user_id);
    
    if($match == false) {
    //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 
    $sql = "INSERT INTO qb_txn VALUES (?,?,?,?)";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('isss',$user_id, $txn_date, $txn_id, $edit_sequence);
    $stmt->execute();        
    $stmt->close();
        }else{
            //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 
            $sql = "UPDATE qb_txn  SET txn_id = ?, edit_sequence = ?, txn_date = ?  WHERE user_id = '$ID'";
            $stmt = $dbMain->prepare($sql);
            $stmt->bind_param('sss', $txn_id, $edit_sequence, $txn_date);
            $stmt->execute();        
            $stmt->close();
         }
}
//======================================================================================================================================
function _quickbooks_payrollitemwage_add_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{ 
    include 'qb_dbmain.php';
    /*$user_id = $ID;
    
  $dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 	
   $stmt = $dbMain ->prepare("SELECT emp_fname, emp_mname, emp_lname, emp_street, emp_city, emp_state, emp_zip, emp_phone1, emp_phone2, social_security, type_key, payment_cycle, comp_type, hours_projected, total_hours, add_sub_one, add_sub_desc_one, add_sub_amount_one, add_sub_two,add_sub_desc_two, add_sub_amount_two, add_sub_three, add_sub_desc_three, add_sub_amount_three,
add_sub_four, add_sub_desc_four, add_sub_amount_four, commission_amount, base_payment_amount, base_prorate_amount, total_payment_amount, payment_date,
close_date, consolidate FROM qb_payroll_settled WHERE user_id ='$ID'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($emp_fname, $emp_mname, $emp_lname, $emp_street, $emp_city, $emp_state, $emp_zip, $emp_phone1, $emp_phone2, $social_security, $type_key, $payment_cycle, $comp_type, $hours_projected, $total_hours, $add_sub_one, $add_sub_desc_one, $add_sub_amount_one, $add_sub_two,$add_sub_desc_two, $add_sub_amount_two, $add_sub_three, $add_sub_desc_three, $add_sub_amount_three, $add_sub_four, $add_sub_desc_four, $add_sub_amount_four, $commission_amount, $base_payment_amount, $base_prorate_amount, $total_payment_amount, $payment_date, $close_date, $consolidate);
   $stmt->fetch();
  */
  
  //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 	
   $stmt = $dbMain ->prepare("SELECT wage_type FROM qb_wage_types WHERE wage_id ='$ID'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($wage_type);
   $stmt->fetch();
  
   
   if($wage_type == "H") {
   			$xml = 
               '<?xml version="1.0" encoding="utf-8"?>
                  <?qbxml version="6.0"?>
                   <QBXML>
                    <QBXMLMsgsRq onError="stopOnError">
                     <PayrollItemWageAddRq requestID="' . $requestID . '">
                      <PayrollItemWageAdd>
                         <Name >Hourly</Name>
                            <WageType >HourlyRegular</WageType>
                            <ExpenseAccountRef>
                            <FullName >Payroll Expenses</FullName>
                            </ExpenseAccountRef>
                      </PayrollItemWageAdd>
                </PayrollItemWageAddRq>
                </QBXMLMsgsRq>
                </QBXML>';
                }else if ($wage_type == "S"){
                        $xml = 
                                   '<?xml version="1.0" encoding="utf-8"?>
                                      <?qbxml version="6.0"?>
                                       <QBXML>
                                        <QBXMLMsgsRq onError="stopOnError">
                                         <PayrollItemWageAddRq requestID="' . $requestID . '">
                                          <PayrollItemWageAdd>
                                             <Name >Salary</Name>
                                                <WageType >SalaryRegular</WageType>
                                                <ExpenseAccountRef>
                                                <FullName >Payroll Expenses</FullName>
                                                </ExpenseAccountRef>
                                          </PayrollItemWageAdd>
                                    </PayrollItemWageAddRq>
                                    </QBXMLMsgsRq>
                                     </QBXML>';
                                    }else if ($wage_type == "HCSC"){
                                                $xml = 
                                                   '<?xml version="1.0" encoding="utf-8"?>
                                                      <?qbxml version="6.0"?>
                                                       <QBXML>
                                                        <QBXMLMsgsRq onError="stopOnError">
                                                          <PayrollItemWageAddRq  requestID="' . $requestID . '">
                                                          <PayrollItemWageAdd>
                                                             <Name >Commission</Name>
                                                                <WageType >Commission</WageType>
                                                                <ExpenseAccountRef>
                                                                <FullName >Payroll Expenses</FullName>
                                                                </ExpenseAccountRef>
                                                          </PayrollItemWageAdd>
                                                    </PayrollItemWageAddRq>
                                                    </QBXMLMsgsRq>
                                                     </QBXML>';
                                                    }else if ($wage_type == "OT1"){
                                                $xml = 
                                                   '<?xml version="1.0" encoding="utf-8"?>
                                                      <?qbxml version="6.0"?>
                                                       <QBXML>
                                                        <QBXMLMsgsRq onError="stopOnError">
                                                          <PayrollItemWageAddRq  requestID="' . $requestID . '">
                                                          <PayrollItemWageAdd>
                                                             <Name >OT Regular</Name>
                                                                <WageType >HourlyOvertime</WageType>
                                                                <ExpenseAccountRef>
                                                                <FullName >Payroll Expenses</FullName>
                                                                </ExpenseAccountRef>
                                                          </PayrollItemWageAdd>
                                                    </PayrollItemWageAddRq>
                                                    </QBXMLMsgsRq>
                                                     </QBXML>';
                                                    }else if ($wage_type == "OT2"){
                                                $xml = 
                                                   '<?xml version="1.0" encoding="utf-8"?>
                                                      <?qbxml version="6.0"?>
                                                       <QBXML>
                                                        <QBXMLMsgsRq onError="stopOnError">
                                                          <PayrollItemWageAddRq  requestID="' . $requestID . '">
                                                          <PayrollItemWageAdd>
                                                             <Name >OT Double Time</Name>
                                                                <WageType >HourlyOvertime</WageType>
                                                                <ExpenseAccountRef>
                                                                <FullName >Payroll Expenses</FullName>
                                                                </ExpenseAccountRef>
                                                          </PayrollItemWageAdd>
                                                    </PayrollItemWageAddRq>
                                                    </QBXMLMsgsRq>
                                                     </QBXML>';
                                                    }
                                                    
    $stmt->close();
    return trim($xml);          
    }
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function _quickbooks_payrollitemwage_add_response($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
{	
    include 'qb_dbmain.php';
	$user_id = $ID;
    $list_id = $idents['ListID'];
    $edit_sequence = $idents['EditSequence'];
    
    //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin');   
	
	$stmt = $dbMain-> prepare("SELECT COUNT(*) AS count FROM qb_item_payroll_wage WHERE user_id = '$user_id' ");
	$stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($count);
	$stmt->fetch();
	
	if($count == 0) {
	   $match =  false;
	  }else{
	   $match =  true;	  
	  }
    
    
    //$match = loadEmployeeCompare($user_id);
    
    if($match == false) {
    //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 
    $sql = "INSERT INTO qb_item_payroll_wage VALUES (?,?,?)";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('iss',$user_id, $list_id, $edit_sequence);
    $stmt->execute();        
    $stmt->close();
        }else{
            //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 
            $sql = "UPDATE qb_item_payroll_wage SET list_id = ?, edit_sequence = ?  WHERE user_id = '$ID'";
            $stmt = $dbMain->prepare($sql);
            $stmt->bind_param('ss', $list_id, $edit_sequence);
            $stmt->execute();        
            $stmt->close();
         }
     $wage_added_qb = 'Y';
     //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 
     $sql = "UPDATE qb_wage_types SET wage_added_qb = ?  WHERE wage_id = '$ID'";
     $stmt = $dbMain->prepare($sql);
     $stmt->bind_param('s', $wage_added_qb);
     $stmt->execute();        
     $stmt->close();    
         
}
//=========================================================================================================
//=========================================================================================================================
function _quickbooks_payrollitemwage_query_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{
    include 'qb_dbmain.php';
    $length = 0;
    $full_name = "";
   
    //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 	
   $stmt = $dbMain ->prepare("SELECT wage_type FROM qb_wage_types WHERE wage_id ='$ID'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($wage_type);
   $stmt->fetch();
   
    if ($wage_type == "H"){
        $payroll_item_wage = "Hourly";}
     else if ($wage_type == "S"){
        $payroll_item_wage = "Salary";
        }else if ($wage_type == "HCSC"){
        $payroll_item_wage = "Commission";
        }
        
   			$xml = 
            
               ' <?xml version="1.0" encoding="utf-8"?>
                 <?qbxml version="6.0"?>
	           	  <QBXML>
	       		   <QBXMLMsgsRq onError="stopOnError">
                    <PayrollItemWageQueryRq requestID="' . $requestID . '">
                            <NameFilter> 
                            <MatchCriterion >Contains</MatchCriterion> 
                            <Name >'. $payroll_item_wage . '</Name>
                            </NameFilter>
                  </PayrollItemWageQueryRq>
                 </QBXMLMsgsRq>
	           	</QBXML>';
   $stmt->close();
   return trim($xml);
}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function _quickbooks_payrollitemwage_query_response($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
{	
    include 'qb_dbmain.php';
	// Great, customer $ID has been added to QuickBooks with a QuickBooks 
	//	ListID value of: $idents['ListID']
	// 
	// We probably want to store that ListID in our database, so we can use it 
	//	later. (You'll need to refer to the customer by either ListID or Name 
	//	in other requests, say, to update the customer or to add an invoice for 
	//	the customer. 
	$user_id = $ID;
    $list_id = $idents['ListID'];
    $edit_sequence = $idents['EditSequence'];
    
    
    //$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 
    $sql = "INSERT INTO qb_item_payroll_wage VALUES (?,?,?)";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('iss',$user_id, $list_id, $edit_sequence);
    $stmt->execute();        
    $stmt->close();
    
  /*
	mysql_query("UPDATE your_customer_table SET quickbooks_listid = '" . mysql_escape_string($idents['ListID']) . "' WHERE user_id = " . (int) $ID);
	*/
}

//======================================================================================================================================
    
/**
 * Catch and handle a "that string is too long for that field" error (err no. 3070) from QuickBooks
 * 
 * @param string $requestID			
 * @param string $action
 * @param mixed $ID
 * @param mixed $extra
 * @param string $err
 * @param string $xml
 * @param mixed $errnum
 * @param string $errmsg
 * @return void
 */
 //====================================================================
function _quickbooks_error_stringtoolong($requestID, $user, $action, $ID, $extra, &$err, $xml, $errnum, $errmsg)
{
	mail('christopherparello@gmail.com', 
		'QuickBooks error occured!', 
		'QuickBooks thinks that ' . $action . ': ' . $ID . ' has a value which will not fit in a QuickBooks field...');
}
//===================================================
function _quickbooks_error_duplicateentry($requestID, $user, $action, $ID, $extra, &$err, $xml, $errnum, $errmsg)
{
	mail('christopherparello@gmail.com', 
		'QuickBooks error occured!', 
		'QuickBooks thinks that ' . $action . ': ' . $ID . ' has a value which is already in QuickBooks ');
}
//================================================================
function _quickbooks_error_e3100($requestID, $user, $action, $ID, $extra, &$err, $xml, $errnum, $errmsg){
   include 'qb_dbmain.php';
    global $dsn;
   
    global $Queue;
   
    if ($action == QUICKBOOKS_ADD_CUSTOMER)
    {
       
        $stmt = $dbMain-> prepare("SELECT MAX(payroll_id) FROM qb_payroll_settled");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($payroll_id); 
   $stmt->fetch();
   $stmt->close();
        // Rename customer enqueue again
        
       $blank = '';
       //$number = rand(0,99);
       $sql = "UPDATE qb_payroll_settled SET emp_lname = CONCAT_WS(' ', emp_lname, '$ID')  WHERE user_id = '$ID' AND payroll_id = '$payroll_id'";
     $stmt = $dbMain->prepare($sql);
     $stmt->bind_param('s', $blank);
     $stmt->execute();        
     $stmt->close(); 
     
        //mysql_query('UPDATE customers SET surname = CONCAT_WS(" ", surname, '.rand(0,99).') WHERE customerID = '.$ID);
       
        $Queue->enqueue(QUICKBOOKS_ADD_CUSTOMER, $ID, 8);
        
        mail('christopherparello@gmail.com', 
		'QuickBooks error occured!', 
		'QuickBooks thinks that ' . $action . ': ' . $ID . ' has a value which is already in QuickBooks so last name now has a number after it');
       
    }
   
    return false;
   
}

?>