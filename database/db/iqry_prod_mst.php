<?php
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session 
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
include_once "../includes/inc_fnct_fleupld.php"; // For uploading files

if(isset($_POST['btnaprod']) && ($_POST['btnaprod'] != "") && isset($_POST['txtsku']) && ($_POST['txtsku'] != "") && isset($_POST['txtname']) && ($_POST['txtname'] != "") && isset($_POST['lstprodmcat']) && ($_POST['lstprodmcat'] != "") && isset($_POST['lstprodcat']) && ($_POST['lstprodcat'] != "") && isset($_POST['txtprior']) && ($_POST['txtprior'] != ""))
{
  
	$sku = glb_func_chkvl($_POST['txtsku']);
	$hsncde = glb_func_chkvl($_POST['txtcde']);
	$name = glb_func_chkvl($_POST['txtname']);
  $prodmcat = glb_func_chkvl($_POST['lstprodmcat']);
	$prodcat = glb_func_chkvl($_POST['lstprodcat']);
  $prodscat = glb_func_chkvl($_POST['lstprodscat']);
  $prodbrnd = glb_func_chkvl($_POST['lstprodbrnd']);
  $prodmnfcr = glb_func_chkvl($_POST['txtmnfctr']);
  $mfdispl = glb_func_chkvl($_POST['mfdisp']);
  $distby = glb_func_chkvl($_POST['txtsoldby']);
  $country = glb_func_chkvl($_POST['txtcntry']);
  $vrnttyp = glb_func_chkvl($_POST['prodvar']);
  // $veh_slctd = glb_func_chkvl($_POST['slctdvrnts']);
  // $slctd_arr = explode(",",$veh_slctd);
  // $chkloc = $_POST['ckhloc'];
	/*$cstprc = glb_func_chkvl($_POST['txtcstprc']);
	$rtlprc = glb_func_chkvl($_POST['txtrtlprc']);
  $rtlofrprc = glb_func_chkvl($_POST['txtrtlofrprc']);
  $whlprc = glb_func_chkvl($_POST['txtwhlprc']);
  $whlminqty = glb_func_chkvl($_POST['txtwhlminqty']);
	$whlofrprc = glb_func_chkvl($_POST['txtwhlofrprc']);
  $weight = glb_func_chkvl($_POST['txtprodwt']);*/
  $typ = glb_func_chkvl($_POST['lstprodtyp']);
	$sdesc = addslashes(trim($_POST['txtsdesc']));
	$desc = addslashes(trim($_POST['txtdesc']));
	$seottl = glb_func_chkvl($_POST['txtseotitle']);
  $seodesc = addslashes(trim($_POST['txtseodesc']));
  $seokywrd = addslashes(trim($_POST['txtkywrd']));
  $seoh1_tle = glb_func_chkvl($_POST['txtseoh1tle']);
  $seoh1_desc = glb_func_chkvl($_POST['txtseoh1desc']);
  $seoh2_tle = glb_func_chkvl($_POST['txtseoh2tle']);
  $seoh2_desc = glb_func_chkvl($_POST['txtseoh2desc']);
  $sts = glb_func_chkvl($_POST['lststs']);
	$prty = glb_func_chkvl($_POST['txtprior']);
  $cntcntrl = glb_func_chkvl($_POST['hdntotcntrl']);
  $hdntotvar = glb_func_chkvl($_POST['hdntotvar']);
	$dt = date('Y-m-d h:i:s');
	$sqryprod_mst	= "SELECT prodm_sku from prod_mst where prodm_hsncde='$sku'";
  $srsprod_mst = mysqli_query($conn,$sqryprod_mst);
  $cntrec  = mysqli_num_rows($srsprod_mst);
  if($cntrec < 1)
  {
    
    $iqryprod_mst	="INSERT into prod_mst(prodm_sku, prodm_hsncde, prodm_name, prodm_prodmcatid, prodm_prodcatid, prodm_prodscatid, prodm_prodbrnd, prodm_prodmnfcr, prodm_prodmnfcr_disp, prodm_distby, prodm_orgncntry, prodm_vrnttyp, prodm_prodtyp, prodm_shrtdsc, prodm_dsc, prodm_st, prodm_sdsc, prodm_sky, prodm_sotl, prodm_sodsc, prodm_sttle, prodm_stdsc, prodm_sts, prodm_rnk, prodm_crton, prodm_crtby) values ('$sku','$hsncde','$name','$prodmcat','$prodcat', '$prodscat','$prodbrnd', '$prodmnfcr', '$mfdispl', '$distby','$country', '$vrnttyp', '$typ','$sdesc','$desc','$seottl','$seodesc','$seokywrd','$seoh1_tle','$seoh1_desc','$seoh2_tle','$seoh2_desc','$sts','$prty','$dt','$ses_admin')";
    $irsprod_mst = mysqli_query($conn,$iqryprod_mst);
    if($irsprod_mst==true)
    {
      $prod_id = mysqli_insert_id($conn);
      if($prod_id != "" && $hdntotvar != "")
      {
        for($i=1;$i <= $hdntotvar; $i++)
        {
          $szm_id = $_POST['hdnslct_vrnt_mst'.$i];
          $szd_id = $_POST['hdnslct_acc'.$i];
          $szdtl_id = explode(",", $szd_id);
          for ($j=0; $j < sizeof($szdtl_id); $j++)
          {
            $szdid = $szdtl_id[$j];
            $iqry_prodsz_mst = "INSERT into prodsz_mst(prodszm_prodm_id, prodszm_szm_id, prodszm_szd_id, prodszm_crton, prodszm_crtby) values ('$prod_id','$szm_id','$szdid','$dt','$ses_admin')";
            $irsprodsz_mst = mysqli_query($conn,$iqry_prodsz_mst);
          }
        }
      }
      else
      {
        $szm_id = '';
        $szdid = '';
        $iqry_prodsz_mst = "INSERT into prodsz_mst(prodszm_prodm_id, prodszm_szm_id, prodszm_szd_id, prodszm_crton, prodszm_crtby) values ('$prod_id','$szm_id','$szdid','$dt','$ses_admin')";
        $irsprodsz_mst = mysqli_query($conn,$iqry_prodsz_mst);
      }
      if($prod_id != "" && isset($_POST['hdn_var_cnt']))
      {
        $vrnt_cnt = $_POST['hdn_var_cnt'];
        for ($k=1; $k <= $vrnt_cnt ; $k++)
        {
          $vrnt_ids = $_POST['hdnprod_vrnt_id'.$k];
          $vrnt_ids_arr = explode("-", $vrnt_ids);
          $szdnm = "";
          for ($l=0; $l < sizeof($vrnt_ids_arr) ; $l++)
          {
            $sqry_szdtl_nm = "SELECT szd_id, szd_name from sz_dtl where szd_id = $vrnt_ids_arr[$l]"; 
            $srssz_dtlnm = mysqli_query($conn,$sqry_szdtl_nm) or die(mysqli_error());
            $cnt = mysqli_num_rows($srssz_dtlnm);
            $rows_dtlnm = mysqli_fetch_array($srssz_dtlnm);
            if ($l == 0)
            {
              $szdnm .= $rows_dtlnm['szd_name'];
            }
            else
            {
              $szdnm .= "/".$rows_dtlnm['szd_name'];
            }
          }
          $iqry_prodsz_vrtns_mst = "INSERT into prodsz_vrtns_mst(prodszvrtnm_prodm_id, prodszvrtnm_vrtn_ids, prodszvrtnm_vrtn_nms, prodszvrtnm_crton, prodszvrtnm_crtby) values ('$prod_id','$vrnt_ids', '$szdnm', '$dt','$ses_admin')";
            $irsprodsz_vrtns_mst = mysqli_query($conn,$iqry_prodsz_vrtns_mst);
          if($irsprodsz_vrtns_mst==true)
          {
            $vrntszd_ins_id = mysqli_insert_id($conn);
            $stl_sku = $_POST['txtsku'.$k];
            $stl_cstprc = $_POST['txtcstprc'.$k];
            $stl_sleprc = $_POST['txtsleprc'.$k];
            $stl_ofrprc = $_POST['txtofrprc'.$k];
            $stl_stkqty = $_POST['txtstkqty'.$k];
            $stl_moq = $_POST['txtmoq'.$k];
            $stl_wt = $_POST['txtwt'.$k];
            $iqry_prodprc_mst = "INSERT into prodprc_mst(prodprcm_prodm_id, prodprcm_vrtn_id, prodprcm_sku, prodprcm_cstprc, prodprcm_sleprc, prodprcm_ofrprc, prodprcm_stkqty, prodprcm_moq, prodprcm_wt, prodprcm_crton, prodprcm_crtby) values ('$prod_id','$vrntszd_ins_id','$stl_sku','$stl_cstprc','$stl_sleprc','$stl_ofrprc','$stl_stkqty','$stl_moq', '$stl_wt', '$dt','$ses_admin')";
            $irsprodprc_mst = mysqli_query($conn,$iqry_prodprc_mst);
          }
        }
      }
      else
      {
        $vrnt_ids = '';
        $szdnm = '';
        $iqry_prodsz_vrtns_mst = "INSERT into prodsz_vrtns_mst(prodszvrtnm_prodm_id, prodszvrtnm_vrtn_ids, prodszvrtnm_vrtn_nms, prodszvrtnm_crton, prodszvrtnm_crtby) values ('$prod_id','$vrnt_ids', '$szdnm', '$dt','$ses_admin')";
        $irsprodsz_vrtns_mst = mysqli_query($conn,$iqry_prodsz_vrtns_mst);
        if($irsprodsz_vrtns_mst==true)
        {
          $vrntszd_ins_id = mysqli_insert_id($conn);
          $stl_sku = $_POST['txtsku'];
          $stl_cstprc = $_POST['txtcstprc'];
          $stl_sleprc = $_POST['txtsleprc'];
          $stl_ofrprc = $_POST['txtofrprc'];
          $stl_stkqty = $_POST['txtstkqty'];
          $stl_moq = $_POST['txtmoq'];
          $stl_wt = $_POST['txtprodwt'];
          $iqry_prodprc_mst = "INSERT into prodprc_mst(prodprcm_prodm_id,prodprcm_vrtn_id, prodprcm_sku, prodprcm_cstprc, prodprcm_sleprc, prodprcm_ofrprc, prodprcm_stkqty, prodprcm_moq, prodprcm_wt, prodprcm_crton, prodprcm_crtby) values ('$prod_id','$vrntszd_ins_id','$stl_sku','$stl_cstprc','$stl_sleprc','$stl_ofrprc','$stl_stkqty','$stl_moq', '$stl_wt', '$dt','$ses_admin')";
          $irsprodprc_mst = mysqli_query($conn,$iqry_prodprc_mst);
        }
      }
      if($prod_id != "" && $cntcntrl!="")
      {
        for($i=1;$i <= $cntcntrl; $i++)
        {
          
          $prior = glb_func_chkvl("txtphtprior".$i);
          $prior = glb_func_chkvl($_POST[$prior]);
          $phtname = glb_func_chkvl("txtphtname".$i);
          $phtname = glb_func_chkvl($_POST[$phtname]);
          $phtsts = "lstphtsts".$i;
          $sts = $_POST[$phtsts];
          if($phtname !="" && $prior !="")
          {
            //****************IMAGE UPLOADING START****************//
            //FOLDER THAT WILL CONTAIN THE IMAGES
            $simg='flesimg'.$i;
            $bimg='flebimg'.$i;
            /*----------------------Update images-------------------*/
            if(isset($_FILES[$simg]['tmp_name']) || ($_FILES[$simg]['tmp_name']!=""))
            {
              $simgval = funcUpldImg($simg,'prodsimg');
              if($simgval != "")
              {
                $simgary = explode(":",$simgval,2);
                $sdest = $simgary[0];
                $ssource = $simgary[1];
              }
            }
            if(isset($_FILES[$bimg]['tmp_name']) || ($_FILES[$bimg]['tmp_name']!=""))
            {
              $bimgval = funcUpldImg($bimg,'prodbimg');
              if($bimgval != "")
              {
                $bimgary = explode(":",$bimgval,2);
                $bdest = $bimgary[0];
                $bsource = $bimgary[1];
              }
            }
            $iqryprodimg_dtl ="INSERT into prodimg_dtl (prodimgd_title,prodimgd_simg, prodimgd_bimg, prodimgd_sts, prodimgd_prty, prodimgd_prodm_id, prodimgd_crtdon, prodimgd_crtdby) values ('$phtname', '$sdest', '$bdest', '$sts', '$prior', '$prod_id', '$dt', '$ses_admin')"; 
            $rsprod_dtl   = mysqli_query($conn,$iqryprodimg_dtl);
            if($rsprod_dtl == true)
            {
              if(($ssource!='none') || ($ssource!='') || ($sdest != ""))
              {
                move_uploaded_file($ssource,$gprodsimg_upldpth.$sdest);
              }
              if(($bsource!='none') || ($bsource!='') || ($bdest != ""))
              {
                move_uploaded_file($bsource,$gprodbimg_upldpth.$bdest);
              }
            }
            
          }
        }
        $gmsg = "Record saved successfully";
      }
    }
    else
    {
      $gmsg = "Record not saved";
    }
  }
  else
  {   
    $gmsg = "Duplicate name. Record not saved";
  }
}
?>