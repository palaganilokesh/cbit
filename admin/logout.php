<?php
include_once '../includes/inc_nocache.php'; // Clearing the cache information
include_once '../includes/inc_adm_session.php';//Check whether the session is created or not
include_once '../includes/inc_connection.php';//Make connection with the database
include_once '../includes/inc_config.php';//Make connection with the database	
$sid =  session_id();
$curdt = date('Y-m-d h:i:s');	
$uqrylgntrck_mst = "UPDATE lgntrck_mst set lgntrckm_mdfdon = '$curdt', lgntrckm_mdfdby = '$ses_admin' where  lgntrckm_id = $ses_lgntrckid and lgntrckm_sesid = '$sid' and lgntrckm_lgnm_id = $ses_adminid";
mysqli_query($conn,$uqrylgntrck_mst);
session_unset();
?>
<?php include_once ('../includes/inc_adm_header.php')?>
<div class="page">
	<div class="container"> 
		<div class="welcome">
			<h3 class="text-primary">You have successfully logged out.</h3>
			<p><strong>Return to the </strong></p>
			<p><a href="index.php" class="btn btn-lg btn-primary">Admin Section</a></p>
		 <script>
		     location.href='index.php';
		     
		 </script>
         
        
  
  
</div>
</div>

</div>

<?php include_once ('../includes/inc_adm_footer.php');?>
