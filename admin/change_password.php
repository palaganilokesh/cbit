<?php
include_once '../includes/inc_nocache.php';        // Clearing the cache information
include_once '../includes/inc_adm_session.php'; //Check whether the session is created or not
include_once '../includes/inc_connection.php';     //Make connection with the database
include_once '../includes/inc_usr_functions.php';  //Use function for validation and more
include_once '../includes/inc_config.php';

global $msg;
if (
	isset($_POST['btnsubmit']) && (trim($_POST['btnsubmit']) != "") &&
	isset($_POST['txtopwd']) && (trim($_POST['txtopwd']) != "") &&
	isset($_POST['txtnpwd']) && (trim($_POST['txtnpwd']) != "") &&
	isset($_POST['txtcpwd']) && (trim($_POST['txtcpwd']) != "") &&
	(trim($_POST['txtnpwd']) == trim($_POST['txtcpwd']))
) {

	$lgnm_opwd = md5(trim($_POST['txtopwd']));
	$lgnm_npwd = md5(trim($_POST['txtnpwd']));
	$lgnm_cpwd = md5(trim($_POST['txtcpwd']));

	if ($lgnm_npwd == $lgnm_cpwd) {
		$curdt			= date('Y-m-d h:i:s');
		$uqrylgn_mst 	= "update 
									lgn_mst 
							   set
									lgnm_pwd='$lgnm_npwd', 
									lgnm_mdfdon = '$curdt',
									lgnm_mdfdby = '$ses_admin'
								where 
									lgnm_pwd='$lgnm_opwd' and 
									lgnm_typ='$ses_admtyp' and 
									lgnm_sts = 'a'  and
									lgnm_uid='$ses_admin'";
		$urslgn_mst  = mysqli_query($conn, $uqrylgn_mst);
		$cntrec		 = mysqli_affected_rows($conn);
		if ($cntrec == 1) {
			$sid             =  session_id();
			$uqrylgntrck_mst =  "update 
										lgntrck_mst 
									set
										lgntrckm_mdfdon = '$curdt',
										lgntrckm_mdfdby = '$ses_admin'
									where 
										lgntrckm_id ='$ses_lgntrckid' and
										lgntrckm_lgnm_id ='$ses_adminid' and
										lgntrckm_sesid = '$sid'";
			mysqli_query($conn, $uqrylgntrck_mst);
?>
			<script language="javascript">
				location.href = "index.php?cp=1"
			</script>
<?php
		} else {
			$msg = "<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Please Enter the Correct Current Password</div>";
		}
	} else {
		$msg = "<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>New Password and Confirm Password are not matched</div>";
	}
}
?>
<?php
include_once('../includes/inc_adm_header.php');
include_once('../includes/inc_adm_leftlinks.php');
?>
<div class="page">
	<div class="container">
		<div class="form-signin">
			<h3 class="text-center title">Change Password</h3>
			<form name="frmchngpwd" method="post" action="change_password.php" onSubmit="return yav.performCheck('frmchngpwd', rules,'inline');">

				<p><label for="txtopwd">Current Password</label>
					<input name="txtopwd" id="txtopwd" type="password" class="form-control">
					<span id="errorsDiv_txtopwd"></span>
				</p>

				<p> <label for="txtnpwd">New Password</label>
					<input name="txtnpwd" type="password" id="txtnpwd" class="form-control">
					<span id="errorsDiv_txtnpwd"></span>
				</p>

				<p><label for="txtcpwd">Confirm Password</label>
					<input name="txtcpwd" id="txtcpwd" type="password" class="form-control">
					<span id="errorsDiv_txtcpwd"></span>
				</p>

				<p> <input name="btnsubmit" type="submit" class="btn btn-primary" value="Submit">
					<input name="btnreset" type="reset" class="btn btn-primary" value="Reset">
					<input name="button" type="button" class="btn btn-primary" onClick="location.href='main.php'" value="Back">
				</p>
				<div class="clearfix"></div>

				<?php echo $msg; ?>

			</form>
		</div>
	</div>
</div>
<?php include_once('../includes/inc_adm_footer.php'); ?>
<script type="text/javascript">
	var rules = new Array();
	rules[0] = 'txtopwd:Old Password |required|Enter Old Password';
	rules[1] = 'txtnpwd:New Password|required|Enter New Password';
	rules[2] = 'txtcpwd:Confirm password|equal|$txtnpwd|Mismatch Password';
	rules[3] = 'txtcpwd:Confirm password|required|Enter Confirm Password';
</script>
<script type="text/javascript">
	$(document).ready(function(e) {
		$('#txtopwd').focus();
	});
</script>