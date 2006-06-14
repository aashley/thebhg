var text="content of text here";
var delay=50;
var currentChar=1;
var destination="[not defined]";
var cernun="";
var pause = 0;
var yes = 1;

function type()
{
  if (document.getElementById)
  {
    var dest=document.getElementById(destination);
    if (dest)
    {
      dest.innerHTML=text.substr(0, currentChar);
      currentChar++
      if (currentChar>text.length)
      {
        currentChar=1;
        if (yes > 0){
        	window.location = '?module=rubicon&page=trace' + cernun;
    	} else {
	    	if (pause > 0){
		    	alert ("Your terminal hack has been spiked.");
		    	alert ("Specialist has disabled terminal access for 30 minutes.");
	    	}
	    	if (keep < 1){
	    		window.location = '?module=holonet';
    		}
    	}
      }
      else
      {
        setTimeout("type()", delay);
      }
    }
  }
}

function startTyping(textParam, delayParam, destinationParam)
{
  text=textParam;
  delay=delayParam;
  currentChar=1;
  destination=destinationParam;
  type();
}