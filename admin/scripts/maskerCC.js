jQuery("#card_number").keyup(function(e){
        var card_number = jQuery(this).val();
        var star = "";
        if(card_number.length <= 12)
        {
            var card_number_hidden = jQuery("#card_number_hidden").val();
            var star_card_number = replaceSubstring(card_number,"*","");
            card_number_hidden = card_number_hidden+star_card_number;
            card_number_hidden = replaceSubstring(card_number_hidden,"*","");
            jQuery("#card_number_hidden").val(card_number_hidden);
            for(var i = 1; i <= card_number.length; i++)
            {
                star = star+"*";
            }
            jQuery("#card_number").val(star);
        }     
        else if(card_number.length > 12 && card_number.length <= 16)
        {
            var card_number_hidden = jQuery("#card_number_hidden").val();
            var new_card_number = "";
            for(var loop1=0; loop1 < 12; loop1++)
            {
                new_card_number = new_card_number+card_number_hidden.charAt(loop1);
            }
            for(var loop2=12; loop2 < card_number.length; loop2++)
            {
                new_card_number = new_card_number+card_number.charAt(loop2);
            }
            card_number_hidden = replaceSubstring(new_card_number,"*","");
            jQuery("#card_number_hidden").val(card_number_hidden);    
        }
    });


function replaceSubstring(inSource, inToReplace, inReplaceWith) {

  var outString = inSource;
  while (true) {
    var idx = outString.indexOf(inToReplace);
    if (idx == -1) {
      break;
    }
    outString = outString.substring(0, idx) + inReplaceWith +
      outString.substring(idx + inToReplace.length);
  }
  return outString;

}