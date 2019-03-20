<?php

switch ($this->state)  {
case "AL":
$AL ="selected";
break;
case "AK":
$AK="selected";
break;
case "AZ":
$AZ="selected";
break;
case "AR":
$AR="selected";
break;
case "CA":
$CA="selected";
break;
case "CO":
$CO="selected";
break;
case "DE":
$DE="selected";
break;
case "DC":
$DC="selected";
break;
case "FL":
$FL="selected";
break;
case "GA":
$GA="selected";
break;
case "HI":
$HI="selected";
break;
case "ID":
$ID="selected";
break;
case "IL":
$IL="selected";
break;
case "IN":
$IN="selected";
break;
case "IA":
$IA="selected";
break;
case "KS":
$KS="selected";
break;
case "KY":
$KY="selected";
break;
case "LA":
$LA="selected";
break;
case "LA":
$ME="selected";
break;
case "MD":
$MD="selected";
break;
case "MA":
$MA="selected";
break;
case "MI":
$MI="selected";
break;
case "MN":
$MN="selected";
break;
case "MS":
$MS="selected";
break;
case "MO":
$MO="selected";
break;
case "MT":
$MT="selected";
break;
case "NE":
$NE="selected";
break;
case "NV":
$NV="selected";
break;
case "NH":
$NH="selected";
break;
case "NJ":
$NJ="selected";
break;
case "NM":
$NM="selected";
break;
case "NY":
$NY="selected";
break;
case "NC":
$NC="selected";
break;
case "ND":
$ND="selected";
break;
case "OH":
$OH="selected";
break;
case "OK":
$OK="selected";
break;
case "OR":
$OR="selected";
break;
case "PA":
$PA="selected";
break;
case "RI":
$RI="selected";
break;
case "SC":
$SC="selected";
break;
case "SD":
$SD="selected";
break;
case "TN":
$TN="selected";
break;
case "TX":
$TX="selected";
break;
case "UT":
$UT="selected";
break;
case "VT":
$VT="selected";
break;
case "VA":
$VA="selected";
break;
case "WA":
$WA="selected";
break;
case "WV":
$WV="selected";
break;
case "WI":
$WI="selected";
break;
case "WY":
$WY="selected";
break;
}




$this->stateList = "
<select  name=\"state\" id=\"state\" $this->disabled/>
<option value=\"AL\" $AL>Alabama</option>
<option value=\"AK\" $AK>Alaska</option>
<option value=\"AZ\" $AZ>Arizona</option>
<option value=\"AR\" $AR>Arkansas</option>
<option value=\"CA\" $CA>California</option>
<option value=\"CO\" $CO>Colorado</option>
<option value=\"CT\" $CT>Connecticut</option>
<option value=\"DE\" $DE>Delaware</option>
<option value=\"DC\" $DC>Wash. D.C.</option>
<option value=\"FL\" $FL>Florida</option>
<option value=\"GA\" $GA>Georgia</option>
<option value=\"HI\" $HI>Hawaii</option>
<option value=\"ID\" $ID>Idaho</option>
<option value=\"IL\" $IL>Illinois</option>
<option value=\"IN\" $IN>Indiana</option>
<option value=\"IA\" $IA>Iowa</option>
<option value=\"KS\" $KS>Kansas</option>
<option value=\"KY\" $KY>Kentucky</option>
<option value=\"LA\" $LA>Louisiana</option>
<option value=\"ME\" $ME>Maine</option>
<option value=\"MD\" $MD>Maryland</option>
<option value=\"MA\" $MA>Massachusetts</option>
<option value=\"MI\" $MI>Michigan</option>
<option value=\"MN\" $MN>Minnesota</option>
<option value=\"MS\" $MS>Mississippi</option>
<option value=\"MO\" $MO>Missouri</option>
<option value=\"MT\" $MT>Montana</option>
<option value=\"NE\" $NE>Nebraska</option>
<option value=\"NV\" $NV>Nevada</option>
<option value=\"NH\" $NH>New Hampshire</option>
<option value=\"NJ\" $NJ>New Jersey</option>
<option value=\"NM\" $NM>New Mexico</option>
<option value=\"NY\" $NY>New York</option>
<option value=\"NC\" $NC>North Carolina</option>
<option value=\"ND\" $ND>North Dakota</option>
<option value=\"OH\" $OH>Ohio</option>
<option value=\"OK\" $OK>Oklahoma</option>
<option value=\"OR\" $OR>Oregon</option>
<option value=\"PA\" $PA>Pennsylvania</option>
<option value=\"RI\" $RI>Rhode Island</option>
<option value=\"SC\" $SC>So. Carolina</option>
<option value=\"SD\" $SD>So. Dakota</option>
<option value=\"TN\" $TN>Tennessee</option>
<option value=\"TX\" $TX>Texas</option>
<option value=\"UT\" $UT>Utah</option>
<option value=\"VT\" $VT>Vermont</option>
<option value=\"VA\" $VA>Virginia</option>
<option value=\"WA\" $WA>Washington</option>
<option value=\"WV\" $WV>West Virginia</option>
<option value=\"WI\" $WI>Wisconsin</option>
 <option value=\"WY\" $WY>Wyoming</option>
</select>";

?>