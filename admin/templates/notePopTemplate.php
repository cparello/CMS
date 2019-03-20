<?php
$notePopTemplate = <<<NOTEPOP
<div id="note">  
<table width=90% align="center"  class="noteTable">
<tr>
<td class="black" valign="middle">
Topic:
</td>
<td align="left">
<input  name="topic" type="text" id="topic" value="" size="25" maxlength="50" onKeyUp="setNoteTopic(this.value);"/>
</td>
</tr>  

<tr>
<td class="black" valign="top">
Note:
</td>
<td align="right">
<textarea cols="30" rows="5" name="message" onKeyUp="setNoteBody(this.value);"></textarea>
</td>
</tr>

<tr>
<td class="black" valign="middle">
Target:
</td>
<td align="left">
<select name="target_app" id="target_app">
<option value="">Select Group</option>
$target_drops
</select>
</td>
</tr>

<tr>
<td class="black" valign="bottom">
Priority:
</td>
<td class="black">
&nbsp;&nbsp;&nbsp;Low<input name="priority" type="radio" value="L" checked/> Medium<input name="priority" type="radio" value="M"/> High<input name="priority" type="radio" value="H"/>
</td>
</tr>

<tr>
<td colspan="2" align="right">
<a class="notes" href="javascript:void('')" onClick="return openNotes(2);">Save & Close</a>
</td>
</tr> 
</table>
</div>
NOTEPOP;
?>