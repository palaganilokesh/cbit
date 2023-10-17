<?php
	session_start();
	if(!isset($_SESSION['sesadminid']) || (trim($_SESSION['sesadminid']) == "") ||
	   !isset($_SESSION['sesadmin']) || (trim($_SESSION['sesadmin']) == "") ||
	   !isset($_SESSION['seslgntrckid']) || (trim($_SESSION['seslgntrckid']) == "") ||
	   !isset($_SESSION['sesadmtyp']) || ((trim($_SESSION['sesadmtyp'])!= 'a') && (trim($_SESSION['sesadmtyp'])!= 'd') && (trim($_SESSION['sesadmtyp'])!= 'wm'))){
	?>
		<script language="javascript">
			location.href = "../admin/index.php";
		</script>
	<?php
		exit();
	}
	else{
		$ses_adminid 	= $_SESSION['sesadminid'];
		$ses_admin 		= $_SESSION['sesadmin'];
		$ses_admtyp 	= $_SESSION['sesadmtyp'];
		$ses_lgntrckid	= $_SESSION['seslgntrckid'];
		$ses_deptid  = $_SESSION['sesdeptid'];

		$curflnm		= basename($_SERVER['PHP_SELF']);
	}
?>