<?php	
error_reporting(0);
	include_once 'includes/inc_nocache.php'; // Clearing the cache information
	//include_once 'includes/inc_usr_functions.php';//Use function for validation and more
	include_once "includes/inc_connection.php";  
	include_once 'includes/inc_config.php'; 
	if(isset($_POST['btnenq']) && ($_POST['btnenq'] != "") && 	
	   isset($_POST['txtname']) && ($_POST['txtname'] != "") && 
	   isset($_POST['txtemail']) && ($_POST['txtemail']) != ""){
		$name     = glb_func_chkvl($_POST['txtname']);
		$email     = glb_func_chkvl($_POST['txtemail']);
		$phone    = glb_func_chkvl($_POST['txtphone']);
        $sub    = glb_func_chkvl($_POST['txtsubject']);
        $msg    = glb_func_chkvl($_POST['txtmessage']);
	
		date_default_timezone_set("Asia/kolkata");
		$curdt    =  date('Y-m-d h:i:s');
	
		$iqryenq_mst="INSERT into gnrlenqry_mst( gnrlenqrym_emailid,gnrlenqrym_name,gnrlenqrym_phno,gnrlenqrym_sub,
	 gnrlenqrym_msg,gnrlenqrym_prty,gnrlenqrym_sts,gnrlenqrym_crtdon,gnrlenqrym_crtdby)values(
						  '$email','$name','$phone','$sub',
						  '$msg',1,'a','$curdt','$email')";
			$irsenq_mst = mysqli_query($conn,$iqryenq_mst);
			if($irsenq_mst==true)
			{
				
				$message = "<table width='60%' border='0' align='center' cellpadding='3' cellspacing='2'>
								<tr>	
								<td colspan='3' align='center'><h1>Chaitanya Bharathi Institute of Technology  - General Enquiry Form</h1></td>
								</tr>	
								<tr>	
								<td  bgcolor='#F0F0F0'>Name*</td>
								<td  bgcolor='#F0F0F0'>:</td>				
								<td  bgcolor='#F0F0F0'>".$name."</td>
								</tr>				  	
								<tr>
								<td bgcolor='#F5F5F5'>Email*</td>
								<td bgcolor='#F5F5F5'>:</td>
								<td bgcolor='#F5F5F5'>".$email."</td>
								</tr>	
								<tr>
								<td bgcolor='#F0F0F0'>Phone*</td>
								<td bgcolor='#F0F0F0'>:</td>						
								<td bgcolor='#F0F0F0'>".$phone."</td>
								</tr>
								<tr>
								<td bgcolor='#F0F0F0'>Subject*</td>
								<td bgcolor='#F0F0F0'>:</td>
								<td bgcolor='#F0F0F0'>".$sub."</td>
								</tr>
								<tr>
								<td bgcolor='#F0F0F0'>Message*</td>
								<td bgcolor='#F0F0F0'>:</td>
								<td bgcolor='#F0F0F0'>$msg</td>
								</tr>
								
								</table>";
								// echo $message;exit;
								// $u_prjct_email_info=' principal@cbit.ac.in';
                                $u_prjct_email_info=' lokeshp@adroitinfoactive.net';
							$fromemail = $email;
							$to = $u_prjct_email_info;
							$headers = 'MIME-Version: 1.0' . "\r\n";
							$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
							$headers .= "From: $fromemail" . "\r\n";
							$subject = "CBIT - General Enquiry Form";
							if (mail($to, $subject, $message, $headers))
							{
								?>
								<script>
									location.href='thankyou-for-quick-enquiry';
								</script>
							
							<?php
							}
							else
							{
								?>
						
								<script>
								location.href='error';
                               
							</script>
							
							<?php
							}
							$gmsg = "Record saved successfully";
							}
			
			}
			else{
				$gmsg = "Record not saved";
			}
		
	
?>
