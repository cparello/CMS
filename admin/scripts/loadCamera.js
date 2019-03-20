function loadCamera(userId, employeeName) {

var parameters = "";
parameters = parameters+'?user_id='+userId;
parameters = parameters+'&employee_name='+employeeName;

window.open("takeEmployeeSnapshot.php" +parameters+ "","","scrollbars=yes,menubar=no,height=455,width=525,resizable=no,toolbar=no,location=no,status=no");

}