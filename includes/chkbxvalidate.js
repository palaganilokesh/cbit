// JavaScript Document
function Check(chk,cntname,chkbxval){
  	if (chk.length != undefined){	
		if(document.getElementById(cntname).checked==true){	
			for (i = 0; i < chk.length; i++){
				chk[i].checked = true ;		
			}
		}else{
			for (i = 0; i < chk.length; i++){
			chk[i].checked = false ;
			}
		}
	}
	else{		
	  if(document.getElementById(cntname).checked==true){   
	  	chk.checked = true; 
	  }
	  else{
	  	chk.checked = false; 
	  }
	}
	document.getElementById(chkbxval).value='n';
	if(document.getElementById(cntname).checked==true){
		document.getElementById(chkbxval).value='y';
	}
}
function addchkval(id,cntrname,frmnm,fldnm)
{
	var chk= document.forms[frmnm].elements[fldnm];
	var chkval = document.getElementById(cntrname).value;
	if(id != "")
	{
 		chkval = chkval + "," + id;
	}
	document.getElementById(cntrname).value=chkval;
	
}
function updatests(cntrname,frmnm,fldnm)
{
	if(document.getElementById(cntrname).value == "")
	{
		var chk= document.forms[frmnm].elements[fldnm];
		var chkval ="";
		if (chk.length != undefined)
		{
			for (i = 0; i < chk.length; i++)
			{
				if(chk[i].checked == true)
				{
					 var chval	=  chk[i].value;
					 chkval = chkval + "," + chval;
				}
			}
		}
		else
		{
	 		 chval	=  chk.value;
			 chkval = chkval + "," + chval;
		}
		document.getElementById(cntrname).value=chkval;
	}
	var val = confirm('You Want to Update the status');
	if(val == true)
	{
		document.getElementById(frmnm).submit();
	}
}
function deleteall(cntrname,frmnm,fldnm)
{
	var chk=document.forms[frmnm].elements[fldnm];
	var total=""
	//alert(chk.length);
if (chk.length != undefined)
{
	for(var m=0; m < chk.length; m++){
	if(chk[m].checked)
	total +=chk[m].value + "\n"
	}
}
else
{
	total = 1;
}
	if(total=="")
	{
		alert("Please select the item to delete");
		return false;
	}
	else
	{
		var chkval = "";
		if (chk.length != undefined)
		{
			for (i = 0; i < chk.length; i++)
			{
				if(chk[i].checked == true)
				{
				 var chval	=  chk[i].value;
				 chkval = chkval + "," + chval;
				}
			}
		}
		else
		{
				 chval	=  chk.value;
				 chkval = chkval + "," + chval;
		}
		document.getElementById(cntrname).value=chkval;
		var val = confirm('Are YouSure?');
		if(val == true)
		{
			document.getElementById(frmnm).submit();
		}
	}

}