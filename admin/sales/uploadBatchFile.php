<?php



$ajaxSwitch = $_REQUEST['ajaxSwitch'];
$ourFileName = $_REQUEST['fileName'];
if($ajaxSwitch == 1){

require"../dbConnect.php";

            
          
                
                $stmt = $dbMain->prepare("SELECT MIN(club_id) FROM club_info  WHERE club_name != ''");//>=
                $stmt->execute();  
                $stmt->store_result();      
                $stmt->bind_result($club_id); 
                $stmt->fetch();
                $stmt->close();
                
                $stmt = $dbMain ->prepare("SELECT gateway_id, passwordfd FROM billing_gateway_fields WHERE club_id= '$club_id'");
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($userName, $password);
                $stmt->fetch();
                $stmt->close();
                
                $file_key = "";
                $sql = "INSERT INTO billing_batch_filename VALUES (?,?)";
                $stmt = $dbMain->prepare($sql);
                $stmt->bind_param('is', $file_key, $ourFileName);
                $stmt->execute();
                $stmt->close();
                // $remote_file = "batchFile.csv";
            
                // set up basic connection
                $ftp_server = "batch-ftp.safewebservices.com";
                $conn_id = ftp_ssl_connect( $ftp_server, 5920 );//ftp_connect($ftp_server);
                
                // login with username and password
                $login_result = ftp_login($conn_id, $userName, $password);
                ftp_pasv($conn_id, true);
                ftp_chdir($conn_id, "/upload/");
                
                
                // upload a file
                if (ftp_put($conn_id, $ourFileName, "$ourFilePath$ourFileName", FTP_ASCII)) {
                // echo "successfully uploaded $ourFileName\n";
                } else {
               //  echo "There was a problem while uploading $ourFileName   test\n";
                }
            
                // close the connection
                ftp_close($conn_id);
                $status = 1;
                
                  
                
    




//====================================================================================================





//echo "test";

    
    echo "$status";
    exit;

//echo "$batchedRecordsCount";


}else{
    echo "99";
    exit;
}
//include"updateTablesFailedTransaction.php";
//$update = new updateTablesFailedTransaction();
//$update->moveData();

//include"batchSqlReports.php";
//$upload = new batchSqlReports();
//$upload->fileMaker();

?>
