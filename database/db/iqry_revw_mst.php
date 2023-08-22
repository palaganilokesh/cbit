<?php 

	session_start();
	include_once '../includes/inc_nocache.php'; 
	include_once('../includes/inc_usr_functions.php');
	include_once('../includes/inc_connection.php');
	include_once('../includes/inc_config.php');
	//print_r($_REQUEST);
	if( isset($_POST['rwmsg']) && (trim($_POST['rwmsg']) != ''))
	{

				$toemail = 'info@liamsons.com';
				//$rating = $_REQUEST['rwrating'];
			$rating = $_REQUEST['rwrating'];
				//$rwname = $_REQUEST['rwname'];
				//$rwemail = $_REQUEST['rwemail'];
				//$rwtitle = $_REQUEST['rwtitle'];
				$message = $_REQUEST['rwmsg'];
		        
				 $rwname  = $_SESSION['sesmbrdname'];
				$rwemail = $_SESSION['sesmbremail']; 
				if($rwemail ==''){
					$rwemail = $_REQUEST['mbremail']; }else{
						$rwemail =$rwemail ;}
				$membrid = $_SESSION['sesmbrid'];
				if($membrid ==''){
					$membrid = $_REQUEST['mbrid']; }else{
						$membrid =$membrid ;}
						
			    if($rwname ==''){
					$rwname = $rwemail;
				}
			    $hdnprdid = $_REQUEST['hdnprodid'];
		        $dt       = date('Y-m-d h:i:s');
				$iqryprodrvw_mst="insert into prodrvw_mst(
									prodrvwm_name,prodrvwm_mbrm_id,prodrvwm_enqry,prodrvwm_prodm_id,
									prodrvwm_sts,prodrvwm_ttle,prodrvwm_rtng,prodrvwm_crtdon,
									prodrvwm_crtdby) values(
									'$rwname','$membrid','$message','$hdnprdid',
									'i','','$rating','$dt',
									'$rwemail')"; 
						//	echo 	$iqryprodrvw_mst; exit;
				$irsprodrvw_mst = mysqli_query($conn,$iqryprodrvw_mst) or die(mysql_error());
				if($irsprodrvw_mst == true){
				$subject   = "$usr_pgtl Product Review";
				$body  = "<table width='550' border='0' align='center' cellpadding='5' cellspacing='0' style='border:1px solid #dfdfdf;font-family:Arial,sans-serif; font-size:16px;'>
				<tr>
				<td height='50' colspan='2' align='center' bgcolor='#3D4094'><strong style='color:#FFFFFF'>Liamsons - Product Review Details</strong></td>
				</tr>
				<tr>
				<td><strong>Customer Name</strong></td>
				<td>".$rwname."</td>
				</tr>
				<tr>
				<td bgcolor='#f5f5f5'><strong>Email</strong></td>
				<td bgcolor='#f5f5f5'>".$rwemail."</td>
				</tr>
				<tr>
				<td><strong>Product Rating</strong></td>
				<td>".$rating."</td>
				</tr>
				<tr>
				<td colspan='2' bgcolor='#FFFFFF'><strong>Review Description</strong><br>".$message."</td>
				</tr>
				</table>";
        echo $body; exit;
				$headers 	 = "MIME-Version: 1.0\r\n";
				$headers 	.= "Content-Type: text/html;charset=utf-8 \r\n";				
				$headers 	.= "From: $rwemail" . "\r\n";
				if(mail($toemail,$subject,$body,$headers)) {
					echo 1;
				} else {
					echo 0;
				}

				?>
<script type="text/javascript">


			   	location.href = "<?php echo $rtpth;?>thankyou.php";



			</script>

				<?php
			}
	}
			else{
				echo 0;
			}
		/*}
		else{
			echo 0;
		}*/
?>
