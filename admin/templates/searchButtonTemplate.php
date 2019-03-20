<?php
$searchButtonTemplate = <<<SEARCHBUTTONS
<div id="headerButs">
<div id="headerButOne">
<input  type="button"  class="bord new_button" name="new_member" id="new_member"  onClick="return newMemberForm();"/>
</div>
<div id="headerButTwo">
<table align="right" class="searchTable">
<tr class="searchFields">
<td class="top">
<span class="black">Contract Id</span>
</td>
<td class="top">
<input  name="search_id" type="text" id="search_id" value="" size="25" maxlength="60"/>
</td>
<td rowspan="2" class="top">
<input  type="button"  class="bord search_button" name="search_members" id="searchIt" onClick="return searchMembers(this.id);"/>
</td>
</tr>
<tr class="searchFields">
<td>
<span class="black">Name</span>
</td>
<td>
<input  name="search_name" type="text" id="search_name" value="" size="25" maxlength="60" />
</td>
</tr>
</table>
</div>
<div class="clear"></div>
</div>
SEARCHBUTTONS;
?>