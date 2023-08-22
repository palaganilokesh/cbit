<?php
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session 
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
if(isset($_POST['btnaddstk']) && ($_POST['btnaddstk'] != "") && isset($_POST['txtsku']) && ($_POST['txtsku'] != ""))
{
  $prod_id = glb_func_chkvl($_POST['prodid']);
  $date = date('Y-m-d');
  $loc = glb_func_chkvl($_POST['prchsloc']);
  $ntprc = glb_func_chkvl($_POST['txtnetprc']);
  $cstprc = glb_func_chkvl($_POST['txtcstprc']);
  $qty = glb_func_chkvl($_POST['txtqty']);
  $opnbls = glb_func_chkvl($_POST['opnbls']);
  $sts = 'a';
	$curdt = date('Y-m-d h:i:s');
  // ------------------------- insert into product purchs bulk qty --------------
  $iqryprchs_mst	= "INSERT into prdprchs_inventory (prdprchs_prdid, prdprchs_dat, prdprchs_lcn, prdprchs_ntprc, prdprchs_prc, prdprchs_in, prdprchs_sts, prdprchs_crton, prdprchs_crtby) values ('$prod_id','$date','$loc','$ntprc', '$cstprc', '$qty', '$sts', '$curdt', '$ses_admin')";
    // echo $iqryprchs_mst;exit;
  $irsprchs_mst = mysqli_query($conn,$iqryprchs_mst) or die(mysqli_error());
  if($irsprchs_mst == true)
  {
    $insert_id = mysqli_insert_id($conn);
    for($i= 1; $i<=$qty;$i++)
    {
       // -------------------- insert into product purchs ind 1 qty --------------
      $insrtindsql="INSERT into prdprchsind_inventory (prdprchsind_prdprchs_id, prdprchsind_prdid, prdprchsind_dat, prdprchsind_lcn, prdprchsind_prc, prdprchsind_in, prdprchsind_sts, prdprchsind_crton, prdprchsind_crtby) values ('$insert_id', '$prod_id', '$date','$loc', '$cstprc', '1', '$sts', '$curdt', '$ses_admin')";
      $resindsql=mysqli_query($conn,$insrtindsql);
    }
      //-------------- select qry to select last clsbls--------------------
    $sqlinvdata = "SELECT prdinvt_id, prdinvt_prdprchs_in, prdinvt_prdprchs_trns_in, prdinvt_prdsle_sleqty, prdinvt_prdsle_trns_out, prdinvt_clsbls from product_inventory where date_format(prdinvt_dat,'%Y-%m-%d') = '$date' and prdinvt_prdid ='$prod_id' and prdinvt_lcn ='$loc' order by prdinvt_prdsle_id desc";
    $resinvdata = mysqli_query($conn,$sqlinvdata);
    $nmrws = mysqli_num_rows($resinvdata);
    if($nmrws > 0)
    {
      $rwsinv = mysqli_fetch_array($resinvdata);
      $invprchs_in = $rwsinv['prdinvt_prdprchs_in'];
      $sle_sleqty = $rwsinv['prdinvt_prdsle_sleqty'];
      $trns_in = $rwsinv['prdinvt_prdprchs_trns_in'];
      $trns_out = $rwsinv['prdinvt_prdsle_trns_out'];
      $strlsbls = $rwsinv['prdinvt_clsbls'];
      $invid = $rwsinv['prdinvt_id'];
      $totqty = $invprchs_in+$qty;
      $clsbls = ($opnbls)+($qty);
      $updtinv_mst = "UPDATE product_inventory set prdinvt_prdprchs_in = '$totqty', prdinvt_cstprc = '$cstprc', prdinvt_clsbls = '$clsbls', prdinvt_updton = '$curdt', prdinvt_updtby = '$ses_admin' where prdinvt_id = $invid ";
      $resinvupdtsql = mysqli_query($conn,$updtinv_mst);
      $nxtopnbls = $clsbls;
      $sqlnxtinvdata = "SELECT prdinvt_id, prdinvt_prdprchs_in, prdinvt_prdprchs_trns_in, prdinvt_prdsle_sleqty, prdinvt_prdsle_trns_out, prdinvt_clsbls,prdinvt_opnbls from product_inventory where date_format(prdinvt_dat,'%Y-%m-%d') > '$date' and prdinvt_msprid ='$prod_id' and prdinvt_lcn = '$loc' order by prdinvt_dat asc";
      $resnxtinvdata = mysqli_query($conn,$sqlnxtinvdata); 
      $nmrws = mysqli_num_rows($resnxtinvdata);
      if($nmrws > 0)
      {
        $sn= 1;
        while($rwsnxt = mysqli_fetch_array($resnxtinvdata))
        {
          $nxtprchs_in = $rwsnxt['prdinvt_prdprchs_in'];
          $nxtsle_sleqty = $rwsnxt['prdinvt_prdsle_sleqty'];
          $nxttrns_in = $rwsnxt['prdinvt_prdprchs_trns_in'];
          $nxttrns_out = $rwsnxt['prdinvt_prdsle_trns_out'];
          $nxtstrlsbls = $rwsnxt['prdinvt_clsbls'];
          $nxtinvid = $rwsnxt['prdinvt_id'];
          $nxtprdinvt_opnbls = $rwsnxt['prdinvt_opnbls'];  
          if($sn == 1)
          {
            $opnbalns = $nxtopnbls;
            $clsbalns = ($nxtopnbls+$nxtprchs_in+$nxttrns_in)-($nxtsle_sleqty+$nxttrns_out);
          }
          else
          {
            $opnbalns = $prsntopnbls;
            $clsbalns = ($prsntopnbls+$nxtprchs_in+$nxttrns_in)-($nxtsle_sleqty+$nxttrns_out);
          }
          $updtinv_mst = "UPDATE product_inventory set prdinvt_opnbls = '$opnbalns', prdinvt_clsbls = '$clsbalns', prdinvt_updton = '$curdt', prdinvt_updtby = '$ses_admin' where prdinvt_id = $nxtinvid ";
          $prsntopnbls = $clsbalns;
          $resupdtinv_mst = mysqli_query($conn,$updtinv_mst);
          $sn++;
        }
      }
    }
    else
    {
      /**********************************************************************/
      $clsbls = ($opnbls+$qty);
      $insrtinvsql ="INSERT into product_inventory (prdinvt_prdprchs_id, prdinvt_dat, prdinvt_cstprc, prdinvt_prdprchs_in, prdinvt_lcn, prdinvt_prdid, prdinvt_opnbls, prdinvt_clsbls, prdinvt_sts, prdinvt_crton, prdinvt_crtby) values ('$insert_id','$date','$cstprc','$qty','$loc','$prod_id', '$opnbls','$clsbls','$sts','$curdt','$ses_admin')";
      $resinvsql = mysqli_query($conn,$insrtinvsql);
    }
    $gmsg = "Record saved successfully";
  }
  else
  {
    $gmsg = "Record not saved";
  }
}
?>