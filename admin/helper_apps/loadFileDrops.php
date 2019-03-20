<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class loadFileDrops {

private $directoryName = null;
private $dropOptions = null;
private $numberDrops = null;
private $fileName = null;



function setDirectoryName($directoryName) {
              $this->directoryName= $directoryName;
              }
              
function setNumberDrops($numberDrops) {
              $this->numberDrops= $numberDrops;
              }
              
//---------------------------------------------------------------------------------------------
function createDropOptions() {

//this takes the info from the file and creates a descrption for the drop down
$fileName = preg_replace('/.pdf/', "",$this->fileName); 
$fileHandleArray = explode("_", $fileName);
$fileHandleLength = count($fileHandleArray);
$i = 0;

while ($i <= $fileHandleLength) {
 
           $fileVar = $fileHandleArray[$i];      
             if (is_numeric($fileVar)) {
                 $dateForm .= "$fileVar/";
                 }else{
                 $descForm .= "$fileVar ";             
                 }

          $i++;
          }

$dateForm = rtrim($dateForm, "/");
$descForm = trim($descForm);
$fileDescription = "$descForm $dateForm";

if(preg_match('/.pdf/',$this->fileName)) {
  $this->dropOptions .= "<option value=\"$this->fileName\">$fileDescription</option>\n";
  }


}
//---------------------------------------------------------------------------------------------
function parseFileDrops() {

$dir = "../$this->directoryName";
$i = 1;

$root = scandir($dir, 1);
    foreach($root as $value) {           
                     if($i <= $this->numberDrops) {    
                         $this->fileName = $value;
                         if($value != "") {
                             $this->createDropOptions();
                           }
                       }
                   $i++;
                 }
    
}
//----------------------------------------------------------------------------------------------
function getDropOptions() {
         return($this->dropOptions);
         }
         
         
}
?>