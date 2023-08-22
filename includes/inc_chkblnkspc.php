<script language="javascript">
function chkspc(cntrl)
{
	var spchars;
	var spcsts;
	var len = document.getElementById(cntrl).value.length - 1;
	spchars = " ";
	spcsts = "f"; //false
	if(spchars.indexOf(document.getElementById(cntrl).value.charAt(0)) != -1)
	{
		spcsts = "t"; //true
		alert("Spaces are not allowed in the first place");				
	}
	else if(spchars.indexOf(document.getElementById(cntrl).value.charAt(len)) != -1)
	{
		spcsts = "t"; //true
		alert("Spaces are not allowed in the last place");								
	}
	if(spcsts == "t")
	{
		document.getElementById(cntrl).focus();
		return false;				
	}
}
</script>