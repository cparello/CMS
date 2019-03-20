<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$infoTemplate = <<<INFOTEMPLATE
<div class="info">
<div id="infoImg" class="infoImg">
<img align="middle" src="images/info.png"border="0" \ >
</div>
<div class="infoTxt">
$info_text
</div>
</div>
INFOTEMPLATE;
?>