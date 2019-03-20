function get_help_text(ht)   {

switch(ht)   {
case 1:
   helpText = "<b><b>SELECT CONTRACT HOLDER</b></b> to search for a client based on their name.  If a single name is typed e.g.  \"Smith\", the system will search by the last name of the client.  If two names are typed e.g.  \"John Smith\", a search will be conducted by first and last name.  If three names are entered e.g. \"John Alan Smith\", the system will search by the first, middle and last name.  You may also seach by a partial name.  For example, you can search for \"John Smith\" by entering \"J Smith\". <br><b><b>SELECT CONTRACT HOLDER</b></b> to search by the ID number of the contract issued to the client.  Note:  this is different than the ID number located on their membership card. <br><b><b>SELECT GROUP, ORGANIZATION OR FAMILY</b></b> to search by the name of a business or oganization if applicable.  Names must  be spelled accurately. <br><b><b>SELECT LAST 4 OF CREDIT CARD NUMBER</b></b> to search by the last four digits of a credit card number. <br><b><b>SELECT LAST 4 OF BANK ACCOUNT NUMBER</b></b> to search by the last four digits of a bank account number. <br><b><b>SELECT MEMBER NAME</b></b> to search for a member based on their name if they have a liability host which is when another person is paying for the membership.  If a single name is typed e.g.  \"Smith\", the system will search by the last name of the client.  If two names are typed e.g.  \"John Smith\", a search will be conducted by first and last name.  If three names are entered e.g. \"John Alan Smith\", the system will search by the first, middle and last name.  You may also seach by a partial name.  For example, you can search for \"John Smith\" by entering \"J Smith\".";                      
   return helpText;    
break;
}

}
