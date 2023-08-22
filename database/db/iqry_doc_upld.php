<?php
session_start();
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session 
include_once $inc_fldr_pth; //Making paging validation
include_once "../includes/inc_membr_session.php"; // checking for session
include_once $inc_fnct_fleupld;
// include_once "includes/inc_usr_functions.php"; // Including user function value
$usrid = $_SESSION['sesmbrid'];
if (isset($_POST['btnedtdoc']) && (trim($_POST['btnedtdoc']) != "") && isset($_POST['txtename']) && (trim($_POST['txtename']) != "") && isset($_POST['txtegst']) && (trim($_POST['txtegst']) != ""))
{
  $updqry_docs = "UPDATE mbrd_docs SET mbrdoc_sts = 'i' where mbrdoc_mbr_id = '$usrid'";
  $ursmbr_docs = mysqli_query($conn, $updqry_docs) or die(mysql_error());
  $name = $_POST['txtename'];
	$gst = $_POST['txtegst'];
	if (isset($_FILES['doceform']['tmp_name']) && ($_FILES['doceform']['tmp_name'] != ""))
	{
		$doc1imgval = funcUpldImg('doceform', 'mbrdoc');
		if ($doc1imgval != "")
		{
			$doc1imgary = explode(":", $doc1imgval, 2);
			$img1dest = $doc1imgary[0];
			$img1source = $doc1imgary[1];
		}
	}
	if (isset($_FILES['doceform1']['tmp_name']) && ($_FILES['doceform1']['tmp_name'] != ""))
	{
		$doc2imgval = funcUpldImg('doceform1', 'mbrdoc1');
		if ($doc2imgval != "")
		{
			$doc1imgary = explode(":", $doc2imgval, 2);
			$img2dest = $doc1imgary[0];
			$img2source = $doc1imgary[1];
		}
	}
	$usrmail = $_SESSION['sesmbremail'];
	$curdt = date('Y-m-d h:i:s');
	$uqrymbr_mst = "INSERT INTO mbrd_docs(mbrdoc_mbr_id, mbrdoc_name, mbrdoc_gst, mbrdoc_20b, mbrdoc_21b, mbrdoc_crtdon, mbrdoc_crtdby,mbrdoc_sts) VALUES ('$usrid','$name','$gst','$img1dest','$img2dest','$curdt','$usrmail','a') ";
	$ursmbr_mst = mysqli_query($conn, $uqrymbr_mst);
	$cntrec = mysqli_affected_rows($conn);
	if ($cntrec == true)
	{
		if (($img1source != 'none') && ($img1source != '') && ($img1dest != ""))
		{
			move_uploaded_file($img1source, $gdocbimg_upldpth . $img1dest);
		}
		if (($img2source != 'none') && ($img2source != '') && ($img2dest != ""))
		{
			move_uploaded_file($img2source, $gdocbimg_upldpth . $img2dest);
		}
		?>
		<script language="javascript" type="text/javascript">
			location.href = "<?php echo $rtpth . 'checkout#parentHorizontalTab2' ?>";
		</script>
		<?php
		// echo "Updated successfully.";
	}
}
if (isset($_POST['btndocsbmt']) && (trim($_POST['btndocsbmt']) != "") && isset($_POST['txtshpname']) && (trim($_POST['txtshpname']) != "") && isset($_POST['txtgst']) && (trim($_POST['txtgst']) != ""))
{
	$name = $_POST['txtshpname'];
	$gst = $_POST['txtgst'];
	if (isset($_FILES['doc20b']['tmp_name']) && ($_FILES['doc20b']['tmp_name'] != ""))
	{
		$doc1imgval = funcUpldImg('doc20b', 'mbrdoc');
		if ($doc1imgval != "")
		{
			$doc1imgary = explode(":", $doc1imgval, 2);
			$img1dest = $doc1imgary[0];
			$img1source = $doc1imgary[1];
		}
	}
	if (isset($_FILES['doc21b']['tmp_name']) && ($_FILES['doc21b']['tmp_name'] != ""))
	{
		$doc2imgval = funcUpldImg('doc21b', 'mbrdoc1');
		if ($doc2imgval != "")
		{
			$doc1imgary = explode(":", $doc2imgval, 2);
			$img2dest = $doc1imgary[0];
			$img2source = $doc1imgary[1];
		}
	}
	$usrmail = $_SESSION['sesmbremail'];
	$curdt = date('Y-m-d h:i:s');
	$uqrymbr_mst = "INSERT INTO mbrd_docs(mbrdoc_mbr_id, mbrdoc_name, mbrdoc_gst, mbrdoc_20b, mbrdoc_21b, mbrdoc_crtdon, mbrdoc_crtdby,mbrdoc_sts) VALUES ('$usrid','$name','$gst','$img1dest','$img2dest','$curdt','$usrmail','a') ";
	$ursmbr_mst = mysqli_query($conn, $uqrymbr_mst);
	$cntrec = mysqli_affected_rows($conn);
	if ($cntrec == true)
	{
		if (($img1source != 'none') && ($img1source != '') && ($img1dest != ""))
		{
			move_uploaded_file($img1source, $gdocbimg_upldpth . $img1dest);
		}
		if (($img2source != 'none') && ($img2source != '') && ($img2dest != ""))
		{
			move_uploaded_file($img2source, $gdocbimg_upldpth . $img2dest);
		}
		?>
		<script language="javascript" type="text/javascript">
			location.href = "<?php echo $rtpth . 'checkout#parentHorizontalTab2' ?>";
		</script>
		<?php
		// echo "Updated successfully.";
	}
}
?>