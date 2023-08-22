<?php
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session	
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
if(isset($_POST['btneprod']) && ($_POST['btneprod'] != "") && isset($_POST['txtsku']) && ($_POST['txtsku'] != "") && isset($_POST['txtname']) && ($_POST['txtname'] != "") && isset($_POST['lstprodmcat']) && ($_POST['lstprodmcat'] != "") && isset($_POST['lstprodcat']) && ($_POST['lstprodcat'] != "") && isset($_POST['txtprior']) && ($_POST['txtprior'] != ""))
{
	
	$id = glb_func_chkvl($_POST['hdnprodid']);
	$sku = glb_func_chkvl($_POST['txtsku']);
	$code = glb_func_chkvl($_POST['txtcde']);
	$name = glb_func_chkvl($_POST['txtname']);
	$prodmncat = glb_func_chkvl($_POST['lstprodmcat']);
	$prodcat = glb_func_chkvl($_POST['lstprodcat']);
  $prodscat = glb_func_chkvl($_POST['lstprodscat']);
  $prodbrnd = glb_func_chkvl($_POST['lstprodbrnd']);
  $prodmnfcr = glb_func_chkvl($_POST['lstprodmf']);
  $mfdispl = glb_func_chkvl($_POST['mfdisp']);
  $distby = glb_func_chkvl($_POST['txtsoldby']);
  $slctd_arr = explode(",",$veh_slctd);
  $chkloc = $_POST['ckhloc'];
	$cstprc = glb_func_chkvl($_POST['txtcstprc']);
	$rtlprc = glb_func_chkvl($_POST['txtrtlprc']);
	$rtlofrprc = glb_func_chkvl($_POST['txtrtlofrprc']);
	$whlprc = glb_func_chkvl($_POST['txtwhlprc']);
	$whlminqty = glb_func_chkvl($_POST['txtwhlminqty']);
	$whlofrprc = glb_func_chkvl($_POST['txtwhlofrprc']);
	$typ = glb_func_chkvl($_POST['lstprodtyp']);
	$weight = glb_func_chkvl($_POST['txtprodwt']);
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
	$pg = glb_func_chkvl($_REQUEST['hdnpage']);
	$countstart = glb_func_chkvl($_REQUEST['hdncnt']);
	$hdnbrndimg = glb_func_chkvl($_REQUEST['hdnbrndimg']);
	$cntcntrl = glb_func_chkvl($_POST['hdntotcntrl']);
	$srchval = addslashes(trim($_POST['hdnloc']));
	$country = glb_func_chkvl($_POST['txtcntry']);
  $vrnttyp = glb_func_chkvl($_POST['prodvar']);
	$prodmnfcr = glb_func_chkvl($_POST['txtmnfctr']);
	$hdntotvar = glb_func_chkvl($_POST['hdntotvar']);
	$prodvar = glb_func_chkvl($_POST['prodvar']);
	$prodvariant = glb_func_chkvl($_POST['prodvariant']);
	if($prodvar == 'no' && $prodvariant == 'no'){
		$prodvariant_ip = 'no';
	}else{
		$prodvariant_ip = 'yes';
	}
	$curdt = date('Y-m-d h:i:s');
	$dt = date('Y-m-d h:i:s');
	$sqryprod_mst = "SELECT prodm_sku from prod_mst where prodm_sku='$sku' and prodm_id != $id";
	$srsprod_mst = mysqli_query($conn,$sqryprod_mst);
	$cntprodm = mysqli_num_rows($srsprod_mst);
	$prcids 				= explode("<->",$_SESSION['sesedtprc']);
	if($cntprodm < 1)
	{	
    $uqryprod_mst="UPDATE prod_mst SET prodm_sku='$sku',prodm_hsncde= '$code',prodm_name= '$name' ,prodm_prodmcatid= '$prodmncat',prodm_prodcatid= '$prodcat',prodm_prodscatid='$prodscat',prodm_prodbrnd= '$prodbrnd',prodm_prodmnfcr= '$prodmnfcr',prodm_prodmnfcr_disp= '$mfdispl',prodm_distby= '$distby',prodm_orgncntry='$country',prodm_vrnttyp = '$prodvariant_ip' ,prodm_prodtyp= '$typ',prodm_dsc= '$desc', prodm_st = '$seottl', prodm_sdsc = '$seodesc', prodm_sky = '$seokywrd', prodm_sotl = '$seoh1_tle', prodm_sodsc = '$seoh1_desc', prodm_sttle = '$seoh2_tle', prodm_stdsc = '$seoh2_desc', prodm_sts = '$sts', prodm_rnk = '$prty', prodm_mdyon = '$curdt', prodm_mdfyby = '$ses_admin' where prodm_id = '$id' ";
		//echo $uqryprod_mst; exit;
		$ursprod_mst = mysqli_query($conn,$uqryprod_mst);
		if($ursprod_mst == true && $prodvar == 'yes')
		{
			$k = 1;
			if($hdntotvar != '')
			{
				if($id != "" && $hdntotvar != "")
				{
					$prodsz_qry  = "DELETE from prodsz_mst WHERE prodszm_prodm_id = $id"; 
					$prodszdlt = mysqli_query($conn,$prodsz_qry);
					if($prodszdlt == true)
					{
						for($i=1;$i <= $hdntotvar; $i++)
						{
							
							$szm_id = $_POST['hdnslct_vrnt_mst'.$i];
							$szd_id = $_POST['hdnslct_acc'.$i];
							$szdtl_id = explode(",", $szd_id);
							for ($j=0; $j < sizeof($szdtl_id); $j++)
							{
								$szdid = $szdtl_id[$j];
								$iqry_prodsz_mst = "INSERT into prodsz_mst(prodszm_prodm_id, prodszm_szm_id, prodszm_szd_id, prodszm_crton, prodszm_crtby) values ('$id','$szm_id','$szdid','$dt','$ses_admin')"; 
								$irsprodsz_mst = mysqli_query($conn,$iqry_prodsz_mst);
							}
						}
					}
				}
				else
				{
					$prodsz_qry  = "DELETE from prodsz_mst WHERE prodszm_prodm_id = $id";
					$prodszdlt = mysqli_query($conn,$prodsz_qry);
					if($prodszdlt == true){
					$szm_id = '';
					$szdid = '';
					$iqry_prodsz_mst = "INSERT into prodsz_mst(prodszm_prodm_id, prodszm_szm_id, prodszm_szd_id, prodszm_crton, prodszm_crtby) values ('$id','$szm_id','$szdid','$dt','$ses_admin')";
					$irsprodsz_mst = mysqli_query($conn,$iqry_prodsz_mst);
					}
				}
				if($id != "" && isset($_POST['hdn_var_cnt']))
				{
					$prodprc_qry  = "DELETE from prodprc_mst WHERE prodprcm_prodm_id = $id";
					$prodprcdlt = mysqli_query($conn,$prodprc_qry);
					if($prodprcdlt == true)
					{
						$prodvrnt_qry  = "DELETE from prodsz_vrtns_mst WHERE prodszvrtnm_prodm_id = $id";
						$prodvrntdlt = mysqli_query($conn,$prodvrnt_qry);
						if($prodvrntdlt == true)
						{
							$prodprc_qry  = "DELETE from prodprc_mst WHERE prodprcm_prodm_id = $id";
						$prodprcdlt = mysqli_query($conn,$prodprc_qry);
						if($prodprcdlt == true)
						{
							$vrnt_cnt = $_POST['hdn_var_cnt'];
							for ($k=1; $k <= $vrnt_cnt ; $k++)
							{
								$vrnt_ids = $_POST['edthdnprod_vrnt_id'.$k];
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
								$iqry_prodsz_vrtns_mst = "INSERT into prodsz_vrtns_mst(prodszvrtnm_prodm_id, prodszvrtnm_vrtn_ids, prodszvrtnm_vrtn_nms, prodszvrtnm_crton, prodszvrtnm_crtby) values ('$id','$vrnt_ids', '$szdnm', '$dt','$ses_admin')";
								$irsprodsz_vrtns_mst = mysqli_query($conn,$iqry_prodsz_vrtns_mst);
							
					if($irsprodsz_vrtns_mst==true)
					{
						$vrntszd_ins_id = mysqli_insert_id($conn);
						
						echo "sku - ".$stl_sku = $_POST['txtsku'.$k];
						$stl_cstprc = $_POST['txtcstprc'.$k];
						$stl_sleprc = $_POST['txtsleprc'.$k];
						$stl_ofrprc = $_POST['txtofrprc'.$k];
						$stl_stkqty = $_POST['txtstkqty'.$k];
						$stl_moq = $_POST['txtmoq'.$k];
						$stl_wt = $_POST['txtwt'.$k];
						
						
						$iqry_prodprc_mst = "INSERT into prodprc_mst(prodprcm_prodm_id, prodprcm_vrtn_id, prodprcm_sku, prodprcm_cstprc, prodprcm_sleprc, prodprcm_ofrprc, prodprcm_stkqty, prodprcm_moq, prodprcm_wt, prodprcm_crton, prodprcm_crtby) values ('$id','$vrntszd_ins_id','$stl_sku','$stl_cstprc','$stl_sleprc','$stl_ofrprc','$stl_stkqty','$stl_moq', '$stl_wt', '$dt','$ses_admin')"; 
						$irsprodprc_mst = mysqli_query($conn,$iqry_prodprc_mst);
						}
					}
				}
			}
		}
				}
			}
			else
			{
				$vrnt_ids = '';
				$szdnm = '';
				$prodvrnt_qry  = "DELETE from prodsz_vrtns_mst WHERE prodszvrtnm_prodm_id = $id";
				$prodvrntdlt = mysqli_query($conn,$prodvrnt_qry);
				if($prodvrntdlt == true){
				$iqry_prodsz_vrtns_mst = "INSERT into prodsz_vrtns_mst(prodszvrtnm_prodm_id, prodszvrtnm_vrtn_ids, prodszvrtnm_vrtn_nms, prodszvrtnm_crton, prodszvrtnm_crtby) values ('$id','$vrnt_ids', '$szdnm', '$dt','$ses_admin')";
				$irsprodsz_vrtns_mst = mysqli_query($conn,$iqry_prodsz_vrtns_mst);
				}
				if($irsprodsz_vrtns_mst==true)
				{
					
					$vrntszd_ins_id = mysqli_insert_id($conn);
					$prodprc_qry  = "DELETE from prodprc_mst WHERE prodprcm_prodm_id = $id";
					$prodprcdlt = mysqli_query($conn,$prodprc_qry);
					if($prodprcdlt == true)
					{
				
					$stl_sku = $_POST['txtsku'];
					$stl_cstprc = $_POST['txtcstprc'];
					$stl_sleprc = $_POST['txtsleprc'];
					$stl_ofrprc = $_POST['txtofrprc'];
					$stl_stkqty = $_POST['txtstkqty'];
					$stl_moq = $_POST['txtmoq'];
					$stl_wt = $_POST['txtprodwt'];
					
						$iqry_prodprc_mst = "INSERT into prodprc_mst(prodprcm_prodm_id,prodprcm_vrtn_id, prodprcm_sku, prodprcm_cstprc, prodprcm_sleprc, prodprcm_ofrprc, prodprcm_stkqty, prodprcm_moq, prodprcm_wt, prodprcm_crton, prodprcm_crtby) values ('$id','$vrntszd_ins_id','$stl_sku','$stl_cstprc','$stl_sleprc','$stl_ofrprc','$stl_stkqty','$stl_moq', '$stl_wt', '$dt','$ses_admin')"; 
						$irsprodprc_mst = mysqli_query($conn,$iqry_prodprc_mst); 
					}
				}
			}
		}
		if($id != "" && $cntcntrl != "")
		{
			for($i=1;$i<=$cntcntrl;$i++)
			{
					$cntrlid = glb_func_chkvl("hdnproddid".$i);
					$prodid = glb_func_chkvl($_POST[$cntrlid]);
					$cntsmlimg = glb_func_chkvl("hdnsmlimg".$i);
					$hdnsmlimg = glb_func_chkvl($_POST[$cntsmlimg]);
					$cntbgimg = glb_func_chkvl("hdnbgimg".$i);
					$hdnbgimg = glb_func_chkvl($_POST[$cntbgimg]);
					$phtcntrl_nm= glb_func_chkvl("txtphtname".$i);
					$phtval = glb_func_chkvl($_POST[$phtcntrl_nm]);
          $phtname = glb_func_chkvl("txtphtname".$i);
          $phtname = glb_func_chkvl($_POST[$phtname]);
          $phtsts = "lstphtsts".$i;
          $sts = $_POST[$phtsts];
          $prior = glb_func_chkvl("txtphtprior".$i);
          $prtyval = glb_func_chkvl($_POST[$prior]);
          if($phtname !="" && $prior !="")
          {
            //****************IMAGE UPLOADING START****************//
            //FOLDER THAT WILL CONTAIN THE IMAGES
            $simg='flesimg'.$i;
            $bimg='flebimg'.$i;
            if(isset($_FILES[$simg]['tmp_name']) && ($_FILES[$simg]['tmp_name']!=""))
            {	
							$simgval = funcUpldImg($simg,'prodsimg');
							if($simgval != "")
							{
								$simgary = explode(":",$simgval,2);
								$sdest = $simgary[0];
								$ssource = $simgary[1];
							}
						}
						if(isset($_FILES[$bimg]['tmp_name']) && ($_FILES[$bimg]['tmp_name']!=""))
						{
							$bimgval = funcUpldImg($bimg,'prodbimg');
							if($bimgval != "")
							{
								$bimgary = explode(":",$bimgval,2);
								$bdest = $bimgary[0];					
								$bsource = $bimgary[1];					
							}
						}
						if($prodid != '')
						{
							$uqryprodimgd_dtl = "UPDATE prodimg_dtl set prodimgd_title = '$phtname', prodimgd_sts = '$sts',prodimgd_prty = '$prtyval', prodimgd_mdfdon= '$curdt',prodimgd_mdfdby = '$ses_admin'";
							if(($ssource!='none') && ($ssource!='') && ($sdest != ""))
							{ 
								if(isset($_FILES[$simg]['tmp_name']) && ($_FILES[$simg]['tmp_name']!=""))
								{
									$smlimgpth = $gprodsimg_upldpth.$hdnsmlimg;
									if(($hdnsmlimg != '') && file_exists($smlimgpth))
									{
										unlink($smlimgpth);
									}
									$uqryprodimgd_dtl .= ", prodimgd_simg = '$sdest'";
								}
								move_uploaded_file($ssource,$gprodsimg_upldpth.$sdest);
							}
							if(($bsource!='none') && ($bsource!='') && ($bdest != ""))
							{
								if(isset($_FILES[$bimg]['tmp_name']) && ($_FILES[$bimg]['tmp_name']!=""))
								{
									$bgimgpth = $gprodbimg_upldpth.$hdnbgimg;
									if(($hdnbgimg != '') && file_exists($bgimgpth))
									{
										unlink($bgimgpth);
									}
									$uqryprodimgd_dtl .= ",prodimgd_bimg='$bdest'";
								}
								move_uploaded_file($bsource,$gprodbimg_upldpth.$bdest);
							}
							$uqryprodimgd_dtl .= " where prodimgd_prodm_id = '$id' and prodimgd_id = '$prodid'";
							$srprodimgd_dtl = mysqli_query($conn,$uqryprodimgd_dtl);
						}
						else
						{
							$iqryprod_dtl = "INSERT into prodimg_dtl(prodimgd_title, prodimgd_simg, prodimgd_bimg, prodimgd_sts, prodimgd_prty,prodimgd_prodm_id, prodimgd_crtdon, prodimgd_crtdby) values ('$phtname', '$sdest', '$bdest', '$sts', '$prtyval', $id, '$curdt', '$ses_admin')";
							$srprodimgd_dtl = mysqli_query($conn,$iqryprod_dtl) or die(mysqli_error());
						}
						if($srprodimgd_dtl)
						{
							if(($ssource!='none') && ($ssource!='') && ($sdest != ""))
							{
								move_uploaded_file($ssource,$gprodsimg_upldpth.$sdest);
								//$wtrmrkimgnm = funcWtrMrkSml($gprodsimg_upldpth,$sdest);
							}
							if(($bsource!='none') && ($bsource!='') && ($bdest != ""))
							{
								move_uploaded_file($bsource,$gprodbimg_upldpth.$bdest);
								// $wtrmrkimgnm = funcWtrMrkBg($gprodbimg_upldpth,$bdest);
							}
						}	
					}//End of For Loop
				}
			}															
			?>
			<script>location.href="view_detail_prod.php?vw=<?php echo $id;?>&sts=y&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>";</script>
			<?php
		}
		else
		{ ?>
			<script>location.href="view_detail_prod.php?vw=<?php echo $id;?>&sts=n&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>";</script>
			<?php
		}
}
else
{ ?>
	<script>location.href="view_detail_prod.php?vw=<?php echo $id;?>&sts=d&pg=<?php echo $pg;?>&countstart=<?php echo $countstart;?>";
	</script>
	<?php
}

?>