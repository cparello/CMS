<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class statusForms {

private $statusType;
private $statusForm;
private $statusHeader;
private $formTypeHeader;

function setStatusType($statusType) {
           $this->statusType = $statusType;
           }


//------------------------------------------------------------------------------------------------------------
function createStatusForm()  {

$status_form = "
<tr>
<td class=\"black\" valign=\"bottom\">
$this->statusHeader
</td>
<td>
<input name=\"service_status\" type=\"radio\"  value=\"$this->statusType\" checked />
</td>
</tr>
<tr>
<td colspan=\"2\" class=\"black\">
&nbsp;
</td>
</tr>";


return $status_form;


}
//-------------------------------------------------------------------------------------------------------------
function loadStatusForms()  {

              switch($this->statusType) {          
                       case"N":
                       $this->statusHeader = 'NEW:';
                       $this->formTypeHeader = 'New Services Application';
                       $this->statusForm = $this->createStatusForm();
                       break;
                       case"R":
                       $this->statusHeader = 'RENEWAL:';
                       $this->statusForm = $this->createStatusForm();
                       break;
                       case"U":
                       $this->statusHeader = 'UPGRADE:';
                       $this->formTypeHeader = 'Service Upgrade Agreement';
                       $this->statusForm = $this->createStatusForm();
                       break;
                    }

}
//-------------------------------------------------------------------------------------------------------------
function getStatusForm() {
          return($this->statusForm);
          }

function getFormTypeHeader() {
          return($this->formTypeHeader);
          }





}
?>