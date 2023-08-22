<?php
session_start();
error_reporting(0);
include_once "../includes/inc_config.php";//Including user session value
include_once "../includes/inc_connection.php";//Including user session value
include_once "../includes/inc_usr_functions.php";//Including user session value
if(isset($_POST['txtemail']) && (trim($_POST['txtemail']) != "") && isset($_POST['txtpwd']) && (trim($_POST['txtpwd']) != "") && isset($_POST['txtcpwd']) && (trim($_POST['txtcpwd']) != "") && (trim($_POST['txtpwd']) == trim($_POST['txtcpwd'])))
{
	$email = glb_func_chkvl($_POST['txtemail']);
	$name = glb_func_chkvl($_POST['txtname']);
	// $username = glb_func_chkvl($_POST['txtusernm']);
	$phno = glb_func_chkvl($_POST['txtmobile']);
	$usrtyp = glb_func_chkvl($_POST['rdusrtyp']);
	// $shpnm = glb_func_chkvl($_POST['txtshpnm']);
	// $prftyp = glb_func_chkvl($_POST['rdusrprf']);
	// $gstno = glb_func_chkvl($_POST['txtgstnum']);
	// $aadno = glb_func_chkvl($_POST['txtcinnum']);
	if ($usrtyp == 'b')
	{
		$vrfsts = "p";
	}
	else
	{
		$vrfsts = "";
	}
	$password = glb_func_chkvl($_POST['txtpwd']);
	if(preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email))
	{
		$ipadrs = $_SERVER['REMOTE_ADDR'];
		$pwd = md5($_POST['txtpwd']);
		$dt = date('Y-m-d h:i:s');
		$sts = 'a';
		$sqrymbr_mst = "SELECT mbrm_emailid from mbr_mst where mbrm_emailid = '$email'";
		$srsmbr_mst = mysqli_query($conn,$sqrymbr_mst);
		$cntmbr_mst = mysqli_num_rows($srsmbr_mst);
		if($cntmbr_mst > 0)
		{
			echo "dup";
		}
		else
		{
			$iqrymbr_mst = "INSERT into mbr_mst(mbrm_emailid, mbrm_name, mbrm_phno, mbrm_usrtyp, mbrm_vrfsts, mbrm_pwd, mbrm_ipadrs, mbrm_sts, mbrm_crtdon, mbrm_crtdby) values ('$email', '$name', '$phno', '$usrtyp', '$vrfsts', '$pwd','$ipadrs', '$sts','$dt','$email')";
			$irsmbr_mst = mysqli_query($conn,$iqrymbr_mst);
			if($irsmbr_mst==true)
			{
				$hdimg = "http://".$u_prjct_mnurl."/".$site_logo; //Return the URL
				$subject = "Account Information - $usr_cmpny";
				$body ="<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01//EN' 'http://www.w3.org/TR/html4/strict.dtd'>
					<html>
					<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
					<meta name='viewport' content='width=device-width, initial-scale=1.0'/>
					<title>$usr_cmpny | Account Information</title>
					<style type='text/css'>
								  #outlook a{padding:0}body{width:100% !important;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;margin:0;padding:0;background-color:#fdfbed;font-family:Arial,Helvetica,sans-serif;font-size:12px}p{margin-top:0;margin-bottom:10px}table td{border-collapse:collapse}table{border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt}img{outline:none;text-decoration:none;-ms-interpolation-mode:bicubic}a img{border:none}.image_fix{display:block} a{color:#109547; text-decoration:none;} a:hover{color:#ea7724; text-decoration:none;}
								  </style>
								  </head>
								  <body style='margin:0; background-color:#ffffff;' marginheight='0' topmargin='0' marginwidth='0' leftmargin='0'>
								  <div style='background-color:#fff;'>
								  <table width='600'  border='0' align='center' cellpadding='5' cellspacing='1' bordercolor='#4A2E2D' style='font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px; color:#333333'>
					<tr>
					  <td align='center' bgcolor='#333333'>
						  <img src='$hdimg' alt='$usr_cmpny' hspace='10' vspace='15' width='200'></td>
					</tr>	
				  </table>
  
				  <table width='600'  border='0' align='center' cellpadding='6' cellspacing='0'>
  
						<tr>
  
						  <td><p><br>
  
							Dear Customer, 
  
							<p>Thank you for registering with us and choosing products from <em>$usr_cmpny</em>.</p>
  
							<p>Your User Email <em>$email </em>.</p>
  
							<p>Your Password <em>$password</em>.</p>
							<p>We would like to welcome you as a new member of <a href='http://$u_prjct_mnurl' target='_blank'>$u_prjct_url</a>";
							// <p>Your Username <em>$username </em>.</p>
							if ($usrtyp == 'b')
							{
								$body .= "<p>As you have registered as a Business. There will be a verification process.</p>

								<p>After Company verifies your Business then only the drug related products will be sold.</p>

								<p>An email will be received with the confirmation or rejection.</p>";
							}
							$body .= "<p>For suggestions / support please feel free to email us at <a href='mailto:$u_prjct_url1' class='style:color-000'>$u_prjct_url1.</a></p>

							<p>Sincerely, <br>
									  Customer Service,<br><br>
									  Support &amp; Answer Center,<br>
 
							<a href='http://".$u_prjct_mnurl."'>Liamsons<br>
									</p>
							</td>
  
						</tr>
  
					  </table>
  
				  </div>
  
					  </body></html>";
	
				$fromemail = $u_prjct_email;			
				$to = $fromemail;
			  $headers = 'MIME-Version: 1.0' . "\r\n";
			  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			  $headers .= "From: $fromemail" . "\r\n";
			  mail($to,$subject,$body,$headers);
			  $id = mysqli_insert_id($conn);				
			  $_SESSION['sesmbremail'] = $email;//assing value of user id to admin session
			  $_SESSION['sesmbrid'] = $id;//assing value of user id to admin session

	      $_SESSION['sesmbrusrtyp'] = $usrtyp; //assing value of user type to user session 
	      $_SESSION['sesmbrusrvrfd'] = $vrfsts; //assing value of user type to user session 
	      $_SESSION['sesmbrphn'] = $phno; //assing value of user id to admin session
	      $_SESSION['sesmbrdname'] = $name;
			  if(isset($_SESSION['cartcode']) && (trim($_SESSION['cartcode']) != ""))
			  {
					echo 'cy';
			  }
			  elseif(isset($_SESSION['pgname']) && ($_SESSION['pgname'] == "y"))
			  {
			  	$_SESSION['sesmbrmenu'] = "wshlst";
					echo "wy";
			  }
			  else
			  {
					echo 'y';
			  }
			}
			else
			{
				echo "n";
			}
		}
	}
	else
	{
		echo 'n';
	}
}
?>