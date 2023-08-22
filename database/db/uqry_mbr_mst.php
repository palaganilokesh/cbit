<?php
include_once '../includes/inc_nocache.php'; // Clearing the cache information
include_once '../includes/inc_adm_session.php'; //checking for session
include_once '../includes/inc_usr_functions.php'; //Use function for validation and more	
include_once "../includes/inc_folder_path.php";	
if(isset($_POST['btnupdtusr']) && (trim($_POST['btnupdtusr']) != "") && isset($_POST['hdnmbrid']) && (trim($_POST['hdnmbrid']) != ""))
{
	$id = glb_func_chkvl($_POST['hdnmbrid']);
	$vrfsts = glb_func_chkvl($_POST['lstvrfsts']);
	if($vrfsts == 'r'){
		$sts = 'Rejected';
	}
	if($vrfsts == 'a'){
		$sts = 'Accepted';
	}
	if($vrfsts == 'p'){
		$sts = 'Pending';
	}
	$curdt = date('Y-m-d h:i:s');
	$sqrymbr_mst = "SELECT mbrm_id from mbr_mst where mbrm_id = '$id'";
	$srsmbr_mst = mysqli_query($conn,$sqrymbr_mst);
	$cntmbr_mst = mysqli_num_rows($srsmbr_mst);
	if($cntmbr_mst == 1)
	{
		$uqrymbr_mst="UPDATE mbr_mst set mbrm_vrfsts = '$vrfsts', mbrm_mdfdon = '$curdt', mbrm_mdfdby = '$ses_admin' where mbrm_id = '$id'";
		$ursmbr_mst = mysqli_query($conn,$uqrymbr_mst);
		if($ursmbr_mst == true)
		{
			$hdimg = "http://".$u_prjct_mnurl."/".$site_logo; //Return the URL
			$subject = "Account Information - $usr_cmpny";
			$body ="<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01//EN' 'http://www.w3.org/TR/html4/strict.dtd'>
					<html>
					<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
					<meta name='viewport' content='width=device-width, initial-scale=1.0'/>
					<title>$usr_cmpny | Order Information</title>
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

							<p>We would like to inform you that is verification in as business is $sts </p>

							<p>For suggestions / support please feel free to email us at <a href='mailto:$u_prjct_url1s' class='style:color-000'>$u_prjct_url1s.</a></p>

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
	echo $body; exit;
			  $to = $fromemail;
			  $fromemail = $u_prjct_email;			
			  $headers = 'MIME-Version: 1.0' . "\r\n";
			  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			  $headers .= "From: $fromemail" . "\r\n";
			  mail($to,$subject,$body,$headers);
			  header("location:view_all_members.php?vw=<?php echo $id;?>&sts=y&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>"); exit;
		}
		else
		{
			header("location:view_all_members.php?vw=<?php echo $id;?>&sts=y&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>"); exit;
		}
	}
	else
	{
		header("location:view_all_members.php?vw=<?php echo $id;?>&sts=y&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>"); exit;
	}
}
?>