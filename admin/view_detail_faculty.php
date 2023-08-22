<?php
error_reporting(0);
include_once '../includes/inc_config.php'; //Making paging validation	
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session	
include_once $inc_fldr_pth; //Floder Path	
/***************************************************************/
//Programm 	  : view_photos.php
//Company 	  : Adroit
/************************************************************/
/*****header link********/
$pagemncat = "Setup";
$pagecat = "Faculty";
$pagenm = "Faculty";
/*****header link********/
global $id, $pg, $cntstart, $msg, $loc, $rd_crntpgnm, $rd_edtpgnm, $clspn_val, $srowsprod_mst, $fldnm;
$fldnm = '../phtglry/';
$rd_crntpgnm = "view_detail_faculty.php";
$rd_edtpgnm = "edit_faculty.php";
$clspn_val = "3";
if (isset($_REQUEST['vw']) && trim($_REQUEST['vw']) != "") {
  $id = glb_func_chkvl($_REQUEST['vw']);
  $pg = glb_func_chkvl($_REQUEST['pg']);
  $cntstart = glb_func_chkvl($_REQUEST['countstart']);
  $val = glb_func_chkvl($_REQUEST['lstfaculty']);
  if ($val != '') {
    $loc .= "&lstfaculty=$val";
  }
  $chk = glb_func_chkvl($_REQUEST['chkexact']);
  if ($chk != "") {
    $loc .= "&chkexact=$chk";
  }
  $sqryprod_mst = "SELECT faculty_id,faculty_dept_id,faculty_sts,faculty_mst_id,faculty_dtl_dept_id,faculty_dtl_sts,faculty_rank,prodcatm_id,prodcatm_name,faculty_typ
  from 
   faculty_mst
    inner join  faculty_dtl on faculty_mst_id=faculty_id
    inner join  prodcat_mst on prodcatm_id= faculty_dept_id
						   where  
                           faculty_id = $id";
  $srsprod_mst = mysqli_query($conn, $sqryprod_mst);
  $cntrec = mysqli_num_rows($srsprod_mst);
  if ($cntrec > 0) {
    $srowsprod_mst = mysqli_fetch_assoc($srsprod_mst);
  } else {
    header("Location:$rd_crntpgnm");
    exit();
  }
}

if (isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) != '')) {
  if ($_REQUEST['sts'] == 'y') {
    $msg = "<font color=red>Record updated successfully</font>";
  } elseif ($_REQUEST['sts'] == 'n') {
    $msg = "<font color=red>Record not updated</font>";
  } elseif ($_REQUEST['sts'] == 'd') {
    $msg = "<font color=red>Duplicate Record Exists & Record Not updated</font>";
  }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>
    <?php echo $pgtl ?>
  </title>
  <?php include_once $adm_scrpt; ?>
  <script language="javascript" type="text/javascript">
    function doEdit() {
      frmproddtl.action = "<?php echo $rd_edtpgnm; ?>?vw=<?php echo $id; ?>&pg=<?php echo $pg; ?>";
      frmproddtl.submit();
    }
  </script>
</head>

<body>
  <?php
  include_once $inc_adm_hdr;
  include_once $inc_adm_lftlnk;
  ?>
  <section class="content">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">View Faculty Deatails</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">View Faculty Deatails</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <form name="frmproddtl" ID="frmproddtl" action="<?php $_SERVER['SCRIPT_FILENAME']; ?>" method="post">
      <input type="hidden" name="vw" id="vw" value="<?php echo $id; ?>">
      <input type="hidden" name="pg" id="pg" value="<?php echo $pg; ?>">
      <input type="hidden" name="countstart" id="countstart" value="<?php echo $cntstart ?>">
      <input type="hidden" name="lstfaculty" id="lstfaculty" value="<?php echo $val; ?>">
      <input type="hidden" name="chkexct" id="chkexct" value="<?php echo $chk; ?>">

      <?php
      if ($msg != "") {
        echo " <tr bgcolor='#FFFFFF'>
							<td align='center' colspan='$clspn_val'><font color='red'>$msg</font></td></tr>";
      }
      ?>
      <div class="card">
        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-12">
              <div class="form-group row">
                <label for="txtname" class="col-sm-2 col-md-2 col-form-label">Department Name </label>
                <div class="col-sm-8">
                  <?php echo $srowsprod_mst['prodcatm_name']; ?>
                </div>
              </div>

              <div class="form-group row">
                <label for="txtname" class="col-sm-2 col-md-2 col-form-label">Rank</label>
                <div class="col-sm-8">
                  <?php echo $srowsprod_mst['faculty_rank']; ?>
                </div>
              </div>
              <div class="form-group row">
                <label for="txtname" class="col-sm-2 col-md-2 col-form-label">Status</label>
                <div class="col-sm-8">
                  <?php echo funcDispSts($srowsprod_mst['faculty_sts']); ?>
                </div>
              </div>
              <div class="table-responsive">
                <table width="100%" border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered">
                  <tr bgcolor="#FFFFFF">
                    <td width="5%" align="center"><strong>SL.No.</strong></td>
                    <td width="15%" align="center"><strong>Name</strong></td>
                    <td width="15%" align="center"><strong>Designation</strong></td>
                    <td width="10%" align="center"><strong>Type</strong></td>
                    <td width="15%" align="center"><strong>Description</strong></td>
                    <td width="15%" align="center"><strong>Image</strong></td>
                    <td width="15%" align="center"><strong>File</strong></td>
                    <td width="5%" align="center"><strong>Rank</strong></td>
                    <td width="10%" align="center"><strong>Status</strong></td>
                  </tr>
                </table>
              </div>

              <?php
              $sqryimg_dtl = "SELECT 	faculty_dtl_id,faculty_mst_id,faculty_dtl_dept_id,	faculty_simgnm,faculty_desgn,faculty_simg,faculty_file,faculty_dtl_sts,faculty_prty,faculty_typ,faculty_desc
							  from   faculty_dtl  where faculty_mst_id  ='$id'   order by faculty_dtl_id";
              $srsimg_dtl = mysqli_query($conn, $sqryimg_dtl);
              $cntphtimg_dtl = mysqli_num_rows($srsimg_dtl);
              $cnt = 0;
              if ($cntphtimg_dtl > 0) {
                while ($rowphtimg_dtl = mysqli_fetch_assoc($srsimg_dtl)) {
                  $cnt += 1;
              ?>
                  <!-- <tr <?php if ($cnt % 2 == 0) {
                              echo "bgcolor='#F2F1F1'";
                            } else {
                              echo "bgcolor='#F9F8F8'";
                            } ?>> -->
                  <table width="100%" border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered">
                    <tr bgcolor="#FFFFFF">
                      <td width="5%" align="center"><?php echo $cnt ?></td>
                      <td width="15%" align="center"> <?php echo $rowphtimg_dtl['faculty_simgnm']; ?></td>
                      <td width="15%" align="center"> <?php echo $rowphtimg_dtl['faculty_desgn']; ?></td>
                      <td width="10%" align="center">
                        <?php if ($rowphtimg_dtl['faculty_typ'] == 'A') echo 'Admin Staff'; ?>
                        <?php if ($rowphtimg_dtl['faculty_typ'] == 'F') echo 'Facuty'; ?>
                        <?php if ($rowphtimg_dtl['faculty_typ'] == 'T') echo 'Technical Staff'; ?>
                      </td>
                      <td width="15%" align="center"> <?php echo $rowphtimg_dtl['faculty_desc']; ?></td>
                      <td width="15%" align="center">

                        <?php
                        $bgimgnm = $rowphtimg_dtl['faculty_simg'];
                        $bgimgpath = $a_phtgalfaculty . $bgimgnm;
                        if (($bgimgnm != "") && file_exists($bgimgpath)) {
                          echo "<img src='$bgimgpath' width='50pixel' height='50pixel'>";
                        } else {
                          echo "Image not available";
                        }
                        ?>
                      </td>
                      <td width="15%" align="center">

                        <?php
                        $fle = $rowphtimg_dtl['faculty_file'];
                        $flepath = $a_phtgalfaculty . $fle;
                        if (($fle != "")) {

                          echo "<a href='$flepath'  target='_blank' >View</a>";
                        } else {
                          echo "file not available";
                        }
                        ?>
                      </td>
                      <td width="5%" align="center"> <?php echo $rowphtimg_dtl['faculty_prty']; ?></td>
                      <td width="10%" align="center"> <?php echo funcDispSts($rowphtimg_dtl['faculty_dtl_sts']); ?></td>

                    </tr>
                  </table>
              <?php
                }
              } else {
                echo "<tr bgcolor='#F2F1F1'>
								<td colspan='6' align='center'>Image not available</td>
							</tr>";
              }
              ?>
              <p class="text-center">
                <input type="Submit" class="btn btn-primary btn-cst" name="btnadprodsbmt" id="btnadprodsbmt" value="Edit" onclick="doEdit()">
                &nbsp;&nbsp;&nbsp;

                <input type="button" name="btnBack" value="Back" class="btn btn-primary btn-cst" onclick="location.href='view_faculty.php?pg=<?php echo $pg . "&countstart=" . $cntstart . $loc; ?>'">
              </p>
            </div>
          </div>
        </div>
      </div>
    </form>
  </section>
  <?php include_once "../includes/inc_adm_footer.php"; ?>




</body>

</html>