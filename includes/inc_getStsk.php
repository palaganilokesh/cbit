<?php
session_start();
include_once '../includes/inc_config.php';
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn;
// ------------------------- To get related categories-------------------
if(isset($_REQUEST['mncatval']) && (trim($_REQUEST['mncatval']) != ""))
{
	// creating Drop Down for sub category
	$result = "";
	$prodmncatid = glb_func_chkvl($_REQUEST['mncatval']);
	$sqryprodcat_mst = "SELECT prodcatm_id,prodcatm_name,prodcatm_typ from prodcat_mst where prodcatm_sts = 'a' and prodcatm_prodmnlnksm_id = $prodmncatid ";
		if ($ses_admtyp == 'u') {
					$sqryprodcat_mst .= " and prodcatm_typ='d'";
										}
										$sqryprodcat_mst .=" group by prodcatm_id order by prodcatm_name";
	// echo $sqryprodcat_mst; exit;
	$srsprodcat_mst = mysqli_query($conn,$sqryprodcat_mst);
	$cntprodcat_inc = mysqli_num_rows($srsprodcat_mst);
	$dispstr = "";
	?>
	<option value disabled selected>Select Category</option>
	<?php
	while ($prg = mysqli_fetch_array($srsprodcat_mst))
	{ ?>
		<option value="<?php echo $prg["prodcatm_id"]; ?>"><?php echo $prg["prodcatm_name"]; ?></option>
		<?php
	}
}
// --------------------------------------------------------------------------


// ------------------------- To get related sub categories-------------------
if(isset($_REQUEST['lstcatone']) && (trim($_REQUEST['lstcatone']) != ""))
{
	// creating Drop Down for sub category
	$result = "";
	$pg_catid = glb_func_chkvl($_REQUEST['lstcatone']);
	$pg_mnid = glb_func_chkvl($_REQUEST['mcatid']);
	$sqry_pg_prodscat_mst = "SELECT prodscatm_id,prodscatm_name from prodscat_mst 
	where prodscatm_sts = 'a' and prodscatm_prodcatm_id ='$pg_catid'  and prodscatm_prodmnlnksm_id='$pg_mnid' group by prodscatm_id order by prodscatm_name";
	// echo $sqry_pg_prodscat_mst; 
	$srsprod_pg_scat_mst = mysqli_query($conn,$sqry_pg_prodscat_mst);
	$cntprod_pg_scat_inc = mysqli_num_rows($srsprod_pg_scat_mst);
	$dispstr = "";
	?>
	<option value disabled selected>Select Sub Category</option>
	<?php
	while ($pg_sub = mysqli_fetch_array($srsprod_pg_scat_mst))
	{ ?>
		<option value="<?php echo $pg_sub["prodscatm_id"]; ?>"><?php echo $pg_sub["prodscatm_name"]; ?></option>
		<?php
	}
}
// --------------------------------------------------------------------------






if(isset($_REQUEST['ptstyp']) && (trim($_REQUEST['ptstyp']) != ""))
{
	// creating Drop Down for sub category
	$result = "";
	$pht_typ = glb_func_chkvl($_REQUEST['ptstyp']);
	$sqrypht_mst = "SELECT phtcatm_id,phtcatm_name,phtcatm_typ from phtcat_mst
	 where phtcatm_sts = 'a' and phtcatm_typ = '$pht_typ' group by phtcatm_id order by phtcatm_name asc";
	// echo $sqryprodcat_mst; exit;
	 $srspht_mst = mysqli_query($conn,$sqrypht_mst);
	$cntpht_inc = mysqli_num_rows($srspht_mst);
	$dispstr1 = "";
	?>
	<option value disabled selected>Select Category</option>
	<?php
	while ($pht = mysqli_fetch_array($srspht_mst))
	{ ?>
		<option value="<?php echo $pht["phtcatm_id"]; ?>"><?php echo $pht["phtcatm_name"]; ?></option>
		<?php
	}
}


// ------------------------- To get related sub categories-------------------
if(isset($_REQUEST['prodcat']) && (trim($_REQUEST['prodcat']) != ""))
{
	// creating Drop Down for sub category
	$result = "";
	$prodcatid = glb_func_chkvl($_REQUEST['prodcat']);
	$sqryprodscat_mst = "SELECT prodscatm_id, prodscatm_name from prodscat_mst where prodscatm_sts = 'a' and prodscatm_prodcatm_id = $prodcatid group by prodscatm_id order by prodscatm_prty";
	// echo $sqryprodscat_mst; exit;
	$srsprodscat_mst = mysqli_query($conn,$sqryprodscat_mst);
	$cntprodscat_inc = mysqli_num_rows($srsprodscat_mst);
	$dispstr = "";
	?>
	<option value disabled selected>Select Sub Category</option>
	<?php
	while ($prg = mysqli_fetch_array($srsprodscat_mst))
	{ ?>
		<option value="<?php echo $prg["prodscatm_id"]; ?>"><?php echo $prg["prodscatm_name"]; ?></option>
		<?php
	}
}
if(isset($_REQUEST['del_id']) && (trim($_REQUEST['del_id']) != ""))
{
	$result ="";
	$del_id = $_REQUEST['del_id'];
	$sqrydel = "DELETE FROM pgqns_dtl WHERE pgqnsd_id = $del_id";
	//echo $sqrydel;exit;
	$srsdel = mysqli_query($conn,$sqrydel);
	//echo $srsdel;
	

	
	echo $result;
}
// ---------------------- get radio tyr tpe ------------------
if(isset($_REQUEST['adm_typ']) && (trim($_REQUEST['adm_typ']) != ""))
{
	$result ="";
	$adm_typ_id = $_REQUEST['adm_typ'];
	$sqry_admtyp = "SELECT prodmnlnksm_id,prodmnlnksm_name from prodmnlnks_mst where prodmnlnksm_id=$adm_typ_id and  prodmnlnksm_sts = 'a'";
	
	$srsadmtyp = mysqli_query($conn,$sqry_admtyp) or die(mysqli_error($conn));
	$srowslctd = mysqli_fetch_assoc($srsadmtyp);
	$admtypid = $srowslctd['prodmnlnksm_id'];
	$admtypnm = $srowslctd['prodmnlnksm_name'];
	if ($admtypnm == "Admissions" || $admtypnm =='Departments') 
	{
		$result .= "<div class='row mb-2 mt-2'><div class='col-sm-3'><label>Type*</label></div><div class='col-sm-9'><input type='radio' id='yes' name='admtype' value='UG'> Under Graduate&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' id='no' name='admtype' value='PG' checked>  Post Graduate<span id='errorsDiv_lstprodcat'></span></div></div></div>";
	}
	else
	{
		$result .= "";
	}
	echo $result;
}
// if(isset($_REQUEST['prodmcat']) && (trim($_REQUEST['prodmcat']) != ""))
// {
// 	// creating Drop Down for sub category
// 	$result = "";
// 	$prodmcatid = glb_func_chkvl($_REQUEST['prodmcat']);
// 	$sqryprodcat_mst = "SELECT prodcatm_id, prodcatm_name from prodcat_mst where prodcatm_sts = 'a' and prodcatm_prodmnlnksm_id = $prodmcatid group by prodcatm_id order by prodcatm_prty";
// 	// echo $sqryprodscat_mst; exit;
// 	$srsprodcat_mst = mysqli_query($conn,$sqryprodcat_mst);
// 	$cntprodcat_inc = mysqli_num_rows($srsprodcat_mst);
// 	$dispstr = "";
	/* ?>
	// <option value disabled selected>Select Category</option>
	// <?php
	// while ($prg = mysqli_fetch_array($srsprodcat_mst))
	// { ?>
	// 	<option value="<?php echo $prg["prodcatm_id"]; ?>">
	// 	<?php echo $prg["prodcatm_name"]; ?>
	// </option>
	// 	<?php
	//}
//} */
if(isset($_REQUEST['crtvrnts']) && (trim($_REQUEST['crtvrnts']) != ""))
{
	// creating Drop Down for sub category
	$result = "";
	$crtvrnts = glb_func_chkvl($_REQUEST['crtvrnts']);
	$sngl_vrnt = explode(",", $crtvrnts);
	?>
	<tr>
		<td colspan="4" align="center">
			<div class="col-md-12">
				<div class="row mb-2 mt-2">
					<div class="col-sm-5">
						<label>All Prices & details to the variants are same *</label>
					</div>
					<div class="col-sm-7">
						<input type='radio' id='all_samey' name='all_same' value='yes' onchange ="all_same_values();"> Yes&nbsp;&nbsp;&nbsp;&nbsp;
						<input type='radio' id='all_samen' name='all_same' value='no' checked onchange ="all_same_values();"> No
					</div>
				</div>
			</div>
			<div class="table-responsive">
				<table width="100%" border="0" cellspacing="3" cellpadding="3" class="table-responsive table-stiped table-border">
					<tr>
						<td align="center"><strong>Name</strong></td>
						<td align="center"><strong>SKU</strong></td>
						<td align="center"><strong>Cost Price</strong></td>
						<td align="Center"><strong>Sale Price</strong></td>
						<td align="Center"><strong>Offer Price</strong></td>
						<td align="Center"><strong>Stock Quantity</strong></td>
						<td align="Center"><strong>MOQ</strong></td>
						<td align="Center"><strong>Weight</strong></td>
						<!-- <td align="Center"><strong>Status</strong></td> -->
					</tr>
					<?php
					for ($i=0; $i < sizeof($sngl_vrnt); $i++)
					{
						$ind_vrnt = explode("/", $sngl_vrnt[$i]);
						$vid = array();
						$vnm = array();
						for ($j=0; $j < sizeof($ind_vrnt); $j++)
						{
							$sqryvrnt_dtl_mst = "SELECT szd_id, szd_name from sz_dtl where szd_id = $ind_vrnt[$j]";
							// echo $sqryvrnt_dtl_mst;
							$rsvrntdtl_mst = mysqli_query($conn,$sqryvrnt_dtl_mst);
							$cntrws = mysqli_num_rows($rsvrntdtl_mst);
							$prg = mysqli_fetch_array($rsvrntdtl_mst);
							$vid[] = $prg['szd_id'];
							$vnm[] = $prg['szd_name'];
							$vid1 = implode("-", $vid);
							$vnm1 = implode("/", $vnm);
						}
						$i1= $i+1;
						?>
						<tr>
							<td align="center"><?php echo $vnm1; ?></td>
							<td align="center">
								<input type="text" name="txtsku<?php echo $i1; ?>" id="txtsku<?php echo $i1; ?>" class="form-control">
							</td>
							<td align="center">
								<input type="text" name="txtcstprc<?php echo $i1; ?>" id="txtcstprc<?php echo $i1; ?>" class="form-control">
							</td>
							<td align="center">
								<input type="text" name="txtsleprc<?php echo $i1; ?>" id="txtsleprc<?php echo $i1; ?>" class="form-control">
							</td>
							<td align="center">
								<input type="text" name="txtofrprc<?php echo $i1; ?>" id="txtofrprc<?php echo $i1; ?>" class="form-control">
							</td>
							<td align="center">
								<input type="text" name="txtstkqty<?php echo $i1; ?>" id="txtstkqty<?php echo $i1; ?>" class="form-control">
							</td>
							<td align="center">
								<input type="text" name="txtmoq<?php echo $i1; ?>" id="txtmoq<?php echo $i1; ?>" class="form-control" maxlength="6">
							</td>
							<td align="center">
								<input type="text" name="txtwt<?php echo $i1; ?>" id="txtwt<?php echo $i1; ?>" class="form-control">
							</td>
							<!-- <td align="center">
								<select name="lstvrntsts" id="lstvrntsts" class="form-control">
									<option value="a" selected>Active</option>
									<option value="i">Inactive</option>
								</select>
							</td> -->
						</tr>
						<input type="hidden" name="hdnprod_vrnt_id<?php echo $i1; ?>" id="hdnprod_vrnt_id<?php echo $i1; ?>" value="<?php echo $vid1; ?>">
						<?php
					}
					?>
				</table>
			</div>
		</td>
	</tr>
	<input type="hidden" name="hdn_var_cnt" id="hdn_var_cnt" value="<?php echo sizeof($sngl_vrnt); ?>">
	<?php
}
/* if(isset($_REQUEST['edtcrtvrnts']) && (trim($_REQUEST['edtcrtvrnts']) != ""))
{
	// creating Drop Down for sub category
	$result = "";
	$crtvrnts = glb_func_chkvl($_REQUEST['edtcrtvrnts']);
	$sngl_vrnt = explode(",", $crtvrnts);
	?>
	<tr>
		<td colspan="4" align="center">
			<div class="col-md-12">
				<!-- <div class="row mb-2 mt-2">
					<div class="col-sm-5">
						<label>All Prices & details to the variants are same *</label>
					</div>
					<div class="col-sm-7">
						<input type='radio' id='all_samey' name='all_same' value='yes' onchange ="all_same_values();"> Yes&nbsp;&nbsp;&nbsp;&nbsp;
						<input type='radio' id='all_samen' name='all_same' value='no' checked onchange ="all_same_values();"> No
					</div>
				</div> -->
			</div>
			<div class="table-responsive">
				<table width="100%" border="0" cellspacing="3" cellpadding="3" class="table-responsive table-stiped table-border">
					<tr>
						<td align="center"><strong>Name</strong></td>
						<td align="center"><strong>SKU</strong></td>
						<td align="center"><strong>Cost Price</strong></td>
						<td align="Center"><strong>Sale Price</strong></td>
						<td align="Center"><strong>Offer Price</strong></td>
						<td align="Center"><strong>Stock Quantity</strong></td>
						<td align="Center"><strong>MOQ</strong></td>
						<td align="Center"><strong>Weight</strong></td>
						<!-- <td align="Center"><strong>Status</strong></td> -->
					</tr>
					<?php
					for ($i=0; $i < sizeof($sngl_vrnt); $i++)
					{
						$ind_vrnt = explode("/", $sngl_vrnt[$i]);
						$vid = array();
						$vnm = array();
						for ($j=0; $j < sizeof($ind_vrnt); $j++)
						{
							$sqryvrnt_dtl_mst = "SELECT szd_id, szd_name from sz_dtl where szd_id = $ind_vrnt[$j]";
							// echo $sqryvrnt_dtl_mst;
							$rsvrntdtl_mst = mysqli_query($conn,$sqryvrnt_dtl_mst);
							$cntrws = mysqli_num_rows($rsvrntdtl_mst);
							$prg = mysqli_fetch_array($rsvrntdtl_mst);
							$vid[] = $prg['szd_id'];
							$vnm[] = $prg['szd_name'];
							$vid1 = implode("-", $vid);
							$vnm1 = implode("/", $vnm);
						}
						$i1= $i+1;
						?>
						<tr>
							<td align="center"><?php echo $vnm1; ?></td>
							<td align="center">
								<input type="text" name="txtsku<?php echo $i1; ?>" id="txtsku<?php echo $i1; ?>" class="form-control">
							</td>
							<td align="center">
								<input type="text" name="txtcstprc<?php echo $i1; ?>" id="txtcstprc<?php echo $i1; ?>" class="form-control">
							</td>
							<td align="center">
								<input type="text" name="txtsleprc<?php echo $i1; ?>" id="txtsleprc<?php echo $i1; ?>" class="form-control">
							</td>
							<td align="center">
								<input type="text" name="txtofrprc<?php echo $i1; ?>" id="txtofrprc<?php echo $i1; ?>" class="form-control">
							</td>
							<td align="center">
								<input type="text" name="txtstkqty<?php echo $i1; ?>" id="txtstkqty<?php echo $i1; ?>" class="form-control">
							</td>
							<td align="center">
								<input type="text" name="txtmoq<?php echo $i1; ?>" id="txtmoq<?php echo $i1; ?>" class="form-control">
							</td>
							<td align="center">
								<input type="text" name="txtwt<?php echo $i1; ?>" id="txtwt<?php echo $i1; ?>" class="form-control">
							</td>
							<!-- <td align="center">
								<select name="lstvrntsts" id="lstvrntsts" class="form-control">
									<option value="a" selected>Active</option>
									<option value="i">Inactive</option>
								</select>
							</td> -->
						</tr>
						<input type="hidden" name="edthdnprod_vrnt_id<?php echo $i1; ?>" id="edthdnprod_vrnt_id<?php echo $i1; ?>" value="<?php echo $vid1; ?>">
						<?php
					}
					?>
				</table>
			</div>
		</td>
	</tr>
	<input type="hidden" name="hdn_var_cnt" id="hdn_var_cnt" value="<?php echo sizeof($sngl_vrnt); ?>">
	<?php
} */
if(isset($_REQUEST['prodmcat']) && (trim($_REQUEST['prodmcat']) != ""))
{
	// creating Drop Down for sub category
	$result = "";
	$prodcatid = glb_func_chkvl($_REQUEST['prodmcat']);
	$sqryprodscat_mst = "SELECT prodcatm_id, prodcatm_name from prodcat_mst where prodcatm_sts = 'a' and prodcatm_prodmnlnksm_id = $prodcatid group by prodcatm_id order by prodcatm_prty";
	// echo $sqryprodscat_mst; exit;
	$srsprodscat_mst = mysqli_query($conn,$sqryprodscat_mst);
	$cntprodscat_inc = mysqli_num_rows($srsprodscat_mst);
	$dispstr = "";
	?>
	<option value disabled selected>Select Sub Category</option>
	<?php
	while ($prg = mysqli_fetch_array($srsprodscat_mst))
	{ ?>
		<option value="<?php echo $prg["prodcatm_id"]; ?>"><?php echo $prg["prodcatm_name"]; ?></option>
		<?php
	}
}
if(isset($_REQUEST['vartype']) && (trim($_REQUEST['vartype']) != ""))
{
	// creating Drop Down for sub category
	$result = "";
	$vartypeid = glb_func_chkvl($_REQUEST['vartype']);
	$rw_id = glb_func_chkvl($_REQUEST['rw_id']);
	if (in_array($vartypeid, $_SESSION['vrnt_mst_id']))
	{
		$slctd_vrntmst = implode(",", $_SESSION['vrnt_mst_id']);
		echo "1-Master Already added-".$rw_id."-".$slctd_vrntmst."-".$vartypeid;
	}
	else
	{
		array_push($_SESSION['vrnt_mst_id'], $vartypeid);
		$slctd_vrntmst = implode(",", $_SESSION['vrnt_mst_id']);
		$sqryprodscat_mst = "SELECT szd_id, szd_name from sz_dtl where szd_sts = 'a' and szd_szm_id = $vartypeid group by szd_id order by szd_id asc";
		// echo $sqryprodscat_mst; exit;
		$srsprodscat_mst = mysqli_query($conn,$sqryprodscat_mst);
		$cntprodscat_inc = mysqli_num_rows($srsprodscat_mst);
		echo "2-";
		?>
		<option value disabled selected>Select Variant Option Value</option>
		<?php
		while ($prg = mysqli_fetch_array($srsprodscat_mst))
		{ ?>
			<option value="<?php echo $prg["szd_id"]; ?>"><?php echo $prg["szd_name"]; ?></option>
			<?php
		}
		echo "-".$rw_id."-".$slctd_vrntmst."-".$vartypeid;
	}
}
if(isset($_REQUEST['edtvartype']) && (trim($_REQUEST['edtvartype']) != ""))
{
	// creating Drop Down for sub category
	$result = "";
	$vartypeid = glb_func_chkvl($_REQUEST['edtvartype']);
	$rw_id = glb_func_chkvl($_REQUEST['rw_id']);
	if (in_array($vartypeid, $_SESSION['edt_vrnt_mst_id']))
	{
		
		$slctd_vrntmst = implode(",", $_SESSION['edt_vrnt_mst_id']);
		echo "1-Master Already added-".$rw_id."-".$slctd_vrntmst."-".$vartypeid;
	}
	else
	{
		array_push($_SESSION['edt_vrnt_mst_id'], $vartypeid);
		$slctd_vrntmst = implode(",", $_SESSION['edt_vrnt_mst_id']);
		$sqryprodscat_mst = "SELECT szd_id, szd_name from sz_dtl where szd_sts = 'a' and szd_szm_id = $vartypeid group by szd_id order by szd_id asc";
		// echo $sqryprodscat_mst; exit;
		$srsprodscat_mst = mysqli_query($conn,$sqryprodscat_mst);
		$cntprodscat_inc = mysqli_num_rows($srsprodscat_mst);
		echo "2-";
		?>
		<option value disabled selected>Select Variant Option Value</option>
		<?php
		while ($prg = mysqli_fetch_array($srsprodscat_mst))
		{ ?>
			<option value="<?php echo $prg["szd_id"]; ?>"><?php echo $prg["szd_name"]; ?></option>
			<?php
		}
		echo "-".$rw_id."-".$slctd_vrntmst."-".$vartypeid;
	}
}
// ----------------------End To get related tyre widths-------------------
if(isset($_REQUEST['acc_dtlid']) && (trim($_REQUEST['acc_dtlid']) != ""))
{
	$acc_dtlid = $_REQUEST['acc_dtlid'];
	$acc_dtl_arr = explode(",", $acc_dtlid);
	$cntrws = count($acc_dtl_arr);
	$rw_id = $_REQUEST['rw_id'];
	$sn = 1 ;
	$sqryacc_dtl_mst = "SELECT szd_id, szd_name from sz_dtl where szd_id in ($acc_dtlid)";
	// echo $sqryacc_dtl_mst;
	$rsaccdtl_mst = mysqli_query($conn,$sqryacc_dtl_mst);
	$cntrws = mysqli_num_rows($rsaccdtl_mst);
	$cstnm = "";
	$cstnm = $rw_id."-";
	while($rwsaccdtl = mysqli_fetch_array($rsaccdtl_mst))
	{
		if($cntrws == $sn)
		{
			$cnct = "";
		}
		else
		{
			$cnct = ",&nbsp;";
		}
		$cstnm .= $rwsaccdtl['szd_name'].$cnct;
		$sn++;
	}
	echo $cstnm;
}
if(isset($_REQUEST['edtacc_dtlid']) && (trim($_REQUEST['edtacc_dtlid']) != ""))
{
	$acc_dtlid = $_REQUEST['edtacc_dtlid'];
	$acc_dtl_arr = explode(",", $acc_dtlid);
	$cntrws = count($acc_dtl_arr);
	$rw_id = $_REQUEST['rw_id'];
	$sn = 1 ;
	$sqryacc_dtl_mst = "SELECT szd_id, szd_name from sz_dtl where szd_id in ($acc_dtlid)";
	// echo $sqryacc_dtl_mst;
	$rsaccdtl_mst = mysqli_query($conn,$sqryacc_dtl_mst);
	$cntrws = mysqli_num_rows($rsaccdtl_mst);
	$cstnm = "";
	$cstnm = $rw_id."-";
	while($rwsaccdtl = mysqli_fetch_array($rsaccdtl_mst))
	{
		if($cntrws == $sn)
		{
			$cnct = "";
		}
		else
		{
			$cnct = ",&nbsp;";
		}
		$cstnm .= $rwsaccdtl['szd_name'].$cnct;
		$sn++;
	}
	echo $cstnm;
}
// ---------------------- get vrnt names and display section ------------------
if(isset($_REQUEST['prod_dtl_id']) && (trim($_REQUEST['prod_dtl_id']) != ""))
{
	$result ="";
	$prod_dtlid = $_REQUEST['prod_dtl_id'];
	$sqry_proddtl = "SELECT prodd_veh_brnd, prodd_veh_mdl, prodd_veh_vrnt from prod_veh_dtl where prodd_id = $prod_dtlid";
	$srsproddtl = mysqli_query($conn,$sqry_proddtl);
	$srowsproddtl = mysqli_fetch_assoc($srsproddtl);
	$prodd_veh_brnd = $srowsproddtl['prodd_veh_brnd'];
	$prodd_veh_mdl = $srowsproddtl['prodd_veh_mdl'];
	$prodd_veh_vrnt = $srowsproddtl['prodd_veh_vrnt'];
	$ids = "|".$prodd_veh_brnd."-".$prodd_veh_mdl."-".$prodd_veh_vrnt."|";
	$result .= $ids;
	/*$del_qry = "DELETE FROM `prod_veh_dtl` WHERE prodd_id = $prod_dtlid";
	// $exqry = mysqli_query($conn,$del_qry);
	if (mysqli_query($conn,$del_qry))
	{
		$result .= ":Removed Successfully.";
	}
	else
	{
		$result .= ":Not removed Please try again.";
	}*/
	echo $result;
}
// --------------------end get vrnt names and display section -----------------
// ----------------------- To get related fields for coupons-------------------
if(isset($_REQUEST['cpnapp_typ']) && (trim($_REQUEST['cpnapp_typ']) != ""))
{
	// creating Drop Down for sub category
	$result = "";
	$cpnapptyp = glb_func_chkvl($_REQUEST['cpnapp_typ']);
	if ($cpnapptyp == 1)
	{ ?>
		<div class="row mb-2 mt-2">
			<div class="col-sm-3">
				<label>Main Category *</label>
			</div>
			<div class="col-sm-9">
				<?php
				$sqryprodcat_mst = "SELECT prodmn_catm_id,prodmn_catm_name from prodmcat_mst order by prodmn_catm_name";
				$rsprodcat_mst = mysqli_query($conn,$sqryprodcat_mst);
				$cnt_prodcat = mysqli_num_rows($rsprodcat_mst);
				?>
				<select name="lstprodmcat" id="lstprodmcat" onchange="get_cat();" class="form-control">
					<option value="">--Select Main Category--</option>
					<option value="0">All</option>
					<?php
					if( $cnt_prodcat > 0)
					{
						while($rowsprodcat_mst=mysqli_fetch_assoc($rsprodcat_mst))
						{
							$mncatid = $rowsprodcat_mst['prodmn_catm_id'];
							$mncatname = $rowsprodcat_mst['prodmn_catm_name'];
							?>
								<option value="<?php echo $mncatid;?>"><?php echo $mncatname;?></option>
							<?php
						}
					}
					?>
				</select>
				<span id="errorsDiv_lstprodcat"></span>
			</div>
		</div>
		<div class="col-md-12" id="hdncat">
		</div>
		<div class="col-md-12" id="hdnsubcat">
		</div>
		<?php
	}
	elseif ($cpnapptyp == 2)
	{ ?>
		<div class="row mb-2 mt-2">
			<div class="col-sm-3">
				<label>Brand *</label>
			</div>
			<div class="col-sm-9">
				<?php
				$sqryprodbrnd_mst = "SELECT brndm_id, brndm_name from brnd_mst where brndm_sts = 'a' order by brndm_name";
				$rsprodbrnd_mst = mysqli_query($conn,$sqryprodbrnd_mst);
				$cnt_prodbrnd_mst = mysqli_num_rows($rsprodbrnd_mst);
				?>
				<select name="lstprodbrnd" id="lstprodbrnd" class="form-control">
					<option value="">--Select Brand--</option>
					<option value="0">All</option>
					<?php
					if($cnt_prodbrnd_mst > 0)
					{
						while($rowsprodcat_mst = mysqli_fetch_assoc($rsprodbrnd_mst))
						{
							$brndm_id = $rowsprodcat_mst['brndm_id'];
							$brndm_name = $rowsprodcat_mst['brndm_name'];
							?>
							<option value="<?php echo $brndm_id;?>"><?php echo $brndm_name;?></option>
							<?php
						}
					}
					?>
				</select>
				<span id="errorsDiv_lstprodbrnd"></span>
			</div>
		</div>
		<?php
	}
	else
	{
	}
}
// --------------End To get related To get related fields for coupons-----------
// ----------------- To get related sub categories for copuns-------------------
if(isset($_REQUEST['prodmncatid']) && (trim($_REQUEST['prodmncatid']) != ""))
{ ?>
	<div class="row mb-2 mt-2">
		<div class="col-sm-3">
			<label>Category *</label>
		</div>
		<div class="col-sm-9">
			<select name="lstprodcat" id="lstprodcat" class="form-control"  onchange="get_sub_cat();" >
				<option value="">--Select Category--</option>
				<option value="0">All</option>
				<?php
				$prodmncatid = glb_func_chkvl($_REQUEST['prodmncatid']);
			 $sqryprodcat_mst = "SELECT prodcatm_id, prodcatm_name from prodcat_mst where prodcatm_sts = 'a' and prodcatm_prodmnlnksm_id = $prodmncatid group by prodcatm_id order by prodcatm_prty";
				 //echo $sqryprodcat_mst; exit;
				$srsprodcat_mst = mysqli_query($conn,$sqryprodcat_mst);
				$cnt_prodcat = mysqli_num_rows($srsprodcat_mst);
				if($cnt_prodcat > 0)
				{
					while($rowsprodscat_mst=mysqli_fetch_assoc($srsprodcat_mst))
					{
						$catid = $rowsprodscat_mst['prodcatm_id'];
						$catname = $rowsprodscat_mst['prodcatm_name'];
						?>
						<option value="<?php echo $catid;?>"><?php echo $catname;?></option>
						<?php
					}
				}
				?>
			</select>
			<span id="errorsDiv_lstprodscat"></span>
		</div>
	</div>
	<?php
}
if(isset($_REQUEST['prodcatid']) && (trim($_REQUEST['prodcatid']) != ""))
{ ?>
	<div class="row mb-2 mt-2">
		<div class="col-sm-3">
			<label>Sub Category *</label>
		</div>
		<div class="col-sm-9">
			<select name="lstprodscat" id="lstprodscat" class="form-control">
				<option value="">--Select sub Category--</option>
				<option value="0">All</option>
				<?php
				$prodcatid = glb_func_chkvl($_REQUEST['prodcatid']);
			 $sqryprodscat_mst = "SELECT prodscatm_id, prodscatm_name from prodscat_mst where prodscatm_sts = 'a' and prodscatm_prodcatm_id = $prodcatid group by prodscatm_id order by prodscatm_prty"; 
				 //echo $sqryprodscat_mst; exit;
				$srsprodscat_mst = mysqli_query($conn,$sqryprodscat_mst);
				$cnt_prodcat = mysqli_num_rows($srsprodscat_mst);
				if($cnt_prodcat > 0)
				{
					while($rowsprodscat_mst=mysqli_fetch_assoc($srsprodscat_mst))
					{
						$scatid = $rowsprodscat_mst['prodscatm_id'];
						$scatname = $rowsprodscat_mst['prodscatm_name'];
						?>
						<option value="<?php echo $scatid;?>"><?php echo $scatname;?></option>
						<?php
					}
				}
				?>
			</select>
			<span id="errorsDiv_lstprodscat"></span>
		</div>
	</div>
	<?php
}
// ----------------End To get related prod sub cat for copuns-------------------
// ----------------------- To get related fields for coupons net amt -------------------
if(isset($_REQUEST['ntamt']) && (trim($_REQUEST['ntamt']) != ""))
{
	$result = "";
	$netamttyp = glb_func_chkvl($_REQUEST['ntamt']);
	if ($netamttyp == 'y')
	{ ?>
		<div class="row mb-2 mt-2">
			<div class="col-sm-3">
				<label>Net Amount *</label>
			</div>
			<div class="col-sm-9">
				<input name="txtnetamt" type="text" id="txtnetamt" class="form-control">
				<span id="errorsDiv_txtnetamt"></span>
			</div>
		</div>
		<?php
	}
	else
	{
	}
}
// --------------End To get related To get related fields for couponsnet amt-----------
// ----------------------- To get related users for coupons-------------------
if(isset($_REQUEST['usrtyp']) && (trim($_REQUEST['usrtyp']) != ""))
{
	// write conditions corrcetly after signup form done
	$result = "";
	$usrtyp = glb_func_chkvl($_REQUEST['usrtyp']);
	if ($usrtyp != 0 && $usrtyp != "")
	{ ?>
		<div class="row mb-2 mt-2">
			<div class="col-sm-3">
				<label>User Email *</label>
			</div>
			<div class="col-sm-9">
				<?php
				$sqryusr_mst = "SELECT mbrm_id, mbrm_emailid from mbr_mst  order by mbrm_emailid asc";
				// where mbrm_typ = $usrtyp
				// echo $sqryusr_mst;
				$srsusr_mst = mysqli_query($conn,$sqryusr_mst);
				$cnt_usr = mysqli_num_rows($srsusr_mst);
				?>
				<select name="lstusr" id="lstusr" class="form-control">
					<option value="">--Select User--</option>
					<option value="0">All</option>
					<?php
					if( $cnt_usr > 0)
					{
						while($rowsusr_mst=mysqli_fetch_assoc($srsusr_mst))
						{
							$id = $rowsusr_mst['mbrm_id'];
							$email = $rowsusr_mst['mbrm_emailid'];
							?>
							<option value="<?php echo $id;?>"><?php echo $email;?></option>
							<?php
						}
					}
					?>
				</select>
				<span id="errorsDiv_lstusr"></span>
			</div>
		</div>
		<?php
	}
	else
	{
	}
}

// --------------End To get related To get related users for coupons-----------

// ----------------------- To get related fields for coupons disc amt -------------------

if(isset($_REQUEST['disctyp']) && (trim($_REQUEST['disctyp']) != ""))
{
	$result = "";
	$disctyp = glb_func_chkvl($_REQUEST['disctyp']);
	if ($disctyp != "")
	{
		if ($disctyp == 'a')
		{ 
			$lbl = "Amount";
			$fldnm = "txtdiscamt";
			$err = "errorsDiv_txtdiscamt";
		}
		else
		{
			$lbl = "Percentage";
			$fldnm = "txtdiscperc";
			$err = "errorsDiv_txtdiscperc";
		}
		?>
		<div class="row mb-2 mt-2">
			<div class="col-sm-3">
				<label>Discount <?php echo $lbl; ?> *</label>
			</div>
			<div class="col-sm-9">
				<input name="<?php echo $fldnm; ?>" type="text" id="<?php echo $fldnm; ?>" class="form-control">
				<span id="<?php echo $err; ?>"></span>
			</div>
		</div>
		<?php
	}
	else
	{
	}
}
// --------------End To get related To get related fields for coupons disc amt-----------
// ----------------------- To get related fields for signup-------------------
if(isset($_REQUEST['usertyp']) && (trim($_REQUEST['usertyp']) != ""))
{
	$result = "";
	$usertyp = glb_func_chkvl($_REQUEST['usertyp']);
	if ($usertyp != "")
	{
		if ($usertyp == 'w')
		{ ?>
				<label for="txtshpnm">Shop Name:</label>
	      <input type="text" id="txtshpnm" name="txtshpnm" class="form-control">
	      <span id="errorsDiv_txtshpnm"></span>
	    </div>
	    <div class="col-12 form-group">
        <b>User Type:</b>
        <input type="radio" id="rdusrgst" name="rdusrprf" class="form-froup" value="g" onchange="get_fields1();">
        <label for="rdusrgst">GST Number</label> 
        <input type="radio" id="rdusraad" name="rdusrprf" value="a" class="form-froup" onchange="get_fields1();">
        <label for="rdusraad">Aadhar Number</label> 
        <span id="errorsDiv_rdusrprf"></span>
      </div>
      <div class="col-12 form-group" id="dynm_flds1"></div>
    <?php
		}
		else
		{
		}
	}
	else
	{
	}
}
// --------------End To get related To get related fields for signup-----------
// ----------------------- To get related fields for signup1-------------------
if(isset($_REQUEST['prftyp']) && (trim($_REQUEST['prftyp']) != ""))
{
	$result = "";
	$prftyp = glb_func_chkvl($_REQUEST['prftyp']);
	if ($prftyp != "")
	{
		if ($prftyp == 'g')
		{ ?>
				<label for="txtgstnum">GST Number:</label>
	      <input type="text" id="txtgstnum" name="txtgstnum" class="form-control">
	      <span id="errorsDiv_txtgstnum"></span>
	    </div>
	    <?php
		}
		elseif ($prftyp == 'a')
		{
			?>
				<label for="txtaadnum">Aadhar Number:</label>
	      <input type="text" id="txtaadnum" name="txtaadnum" class="form-control">
	      <span id="errorsDiv_txtaadnum"></span>
	    </div>
	    <?php
		}
		else
		{
		}
	}
	else
	{
	}
}
// --------------End To get related To get related fields for signup1-----------
	if(isset($_REQUEST['selcatid']) && (trim($_REQUEST['selcatid']) != ""))
	{
		// creating Drop Down for County
		$result = "";		
		$catid = glb_func_chkvl($_REQUEST['selcatid']);
		$sqrystsk_mst =  "select
							   		stskm_id,stskm_name
							  from
									vw_tsk_stsk_all
							  where
									stskm_sts='a' and 
									tskm_id = $catid
							  group by stskm_id
							  order by
									stskm_prty";
		$srsstsk_mst	  = mysqli_query($conn,$sqrystsk_mst);
		$cntstsk_inc	  = mysqli_num_rows($srsstsk_mst);
		$dispstr		  	  = "";
		if($cntstsk_inc > 0){
			$result ="<div class='form-group clearfix'><label class='col-sm-12 control-label'>Sub Tasks</label></div><table width=\"100%\" cellspacing=\"1\" cellpadding=\"1\" class=\"table table-condensed table-bordered table-striped\">";
			while($srowstskt_mst = mysqli_fetch_assoc($srsstsk_mst)){
				$scatid  = $srowstskt_mst['stskm_id'];
				$scatnm  = $srowstskt_mst['stskm_name'];
				$dispstr .= ","."$scatid:$scatnm";
				$result .= "<tr><td align=\"left\" width=\"30%\">
											<input type=\"checkbox\" name=\"chksize$scatid\" value=\"$scatid\"
											onclick= \"funcchkloc('$scatnm',$scatid,'edtseshdnlstscatnm','edtseshdnlstscatid')\">
												&nbsp;$scatnm
											</td></tr>";
			}
			$result .="</table>";

		}
		echo $result;
	}
	
	if(isset($_REQUEST['seledtcatid']) && (trim($_REQUEST['seledtcatid']) != ""))
	{
		// creating Drop Down for County
		$result = "";		
		$catid = glb_func_chkvl($_REQUEST['seledtcatid']);
		$rqst_tskid = glb_func_chkvl($_REQUEST['tskid']);
		$deptids=explode(',',$_SESSION['stskids']);
		$sqrystsk_mst =  "select 
							   		stskm_id,stskm_name
							  from 
									vw_tsk_stsk_all
							  where 
									stskm_sts='a' and 
									tskm_id = $catid
							  group by stskm_id
							  order by 
									stskm_prty";								
		$srsstsk_mst	  = mysqli_query($conn,$sqrystsk_mst);
		$cntstsk_inc	  = mysqli_num_rows($srsstsk_mst);		  
		$dispstr		  	  = "";		
		if($cntstsk_inc > 0){
			//<input type='hidden' name='edtseshdnlstscatid' id='edtseshdnlstscatid' value='$_SESSION[stskids]'><input type='hidden' name='edtseshdnlstscatnm' id='edtseshdnlstscatnm'  value=' $_SESSION[stsknames]'>
			$result ="
			
			<div class='form-group clearfix'><label class='col-sm-12 control-label'>Sub Tasks</label></div><table width=\"100%\" cellspacing=\"1\" cellpadding=\"1\" class=\"table table-condensed table-bordered table-striped\">";
			while($srowstskt_mst = mysqli_fetch_assoc($srsstsk_mst)){
				$scatid  = $srowstskt_mst['stskm_id'];
				$scatnm  = $srowstskt_mst['stskm_name'];			
				$dispstr .= ","."$scatid:$scatnm";	
				$result .= "<tr><td align=\"left\" width=\"30%\">
											<input type=\"checkbox\" name=\"chksize$scatid\" value=\"$scatid\" ";
											
					if($catid ==$rqst_tskid){
						for($deptcnt=0;$deptcnt<count($deptids);$deptcnt++)
						{
							if($deptids[$deptcnt]==$scatid)
							{
							   $result.="checked";
							}
						}
					}
											
					$result .= " onclick= \"funcchkloc('$scatnm',$scatid,'edtseshdnlstscatnm','edtseshdnlstscatid')\">
												&nbsp;$scatnm
											</td></tr>";		
			}
			$result .="</table>";
			
		}
		echo $result;
	}
	
	if(isset($_REQUEST['selslngcatid']) && (trim($_REQUEST['selslngcatid']) != "")){
		// creating Drop Down for County
		$result = "";		
		$catid = glb_func_chkvl($_REQUEST['selslngcatid']);
		$sqrystsk_mst =  "select 
							   		stskm_id,stskm_name
							  from 
									vw_cat_prod_mst
							  where 
									stskm_sts='a' and 
									prodcatm_id = $catid
							  group by stskm_id order by stskm_prty";								
		$srsstsk_mst	  = mysqli_query($conn,$sqrystsk_mst);
		$cntstsk_inc	  = mysqli_num_rows($srsstsk_mst);		  
		$dispstr		  	  = "";		
		if($cntstsk_inc > 0){
			while($srowstsk_mst = mysqli_fetch_assoc($srsstsk_mst)){
				$scatid  = $srowstsk_mst['stskm_id'];
				$scatnm  = $srowstsk_mst['stskm_name'];			
				$dispstr .= ","."$scatid:$scatnm";			
			}
			$result = substr($dispstr,1);		
		}
		echo $result;
	}
	
	if(isset($_REQUEST['selrslngcatid']) && (trim($_REQUEST['selrslngcatid']) != "")){
		// creating Drop Down for County
		$result = "";		
		$catid = glb_func_chkvl($_REQUEST['selrslngcatid']);
		$scatid = glb_func_chkvl($_REQUEST['selrslngscatid']);
		$sqrystsk_mst =  "select
							   		stskm_id,stskm_name
							  from
									vw_cat_prod_mst
							  where
									stskm_sts='a' and 
									prodcatm_id = $catid
							  group by stskm_id order by stskm_prty";
		$srsstsk_mst	  = mysqli_query($conn,$sqrystsk_mst);
		$cntstsk_inc	  = mysqli_num_rows($srsstsk_mst);
		$dispstr		  	  = "";
		if($cntstsk_inc > 0){
			while($srowstsk_mst = mysqli_fetch_assoc($srsstsk_mst)){
				$scatid  = $srowstsk_mst['stskm_id'];
				$scatnm  = $srowstsk_mst['stskm_name'];
				$dispstr .= ","."$scatid:$scatnm";
			}
			$result = substr($dispstr,1);
		}
		echo $result;
	}
	if(isset($_REQUEST['selclntcatid']) && (trim($_REQUEST['selclntcatid']) != "")){
		// creating Drop Down for County
		$result = "";
		$catid = glb_func_chkvl($_REQUEST['selclntcatid']);
		$sqryprfsnl_mst =  "select 
							   		prfsnlm_id,prfsnlm_name
							  from 
									vw_crtmstr_prfsnl_mst
							  where 
									prfsnlm_sts='a' and 
									crtmstrm_id = $catid
							  group by prfsnlm_id order by prfsnlm_prty";								
		$srsprfsnl_mst	  = mysqli_query($conn,$sqryprfsnl_mst);
		$cntprfsnl_inc	  = mysqli_num_rows($srsprfsnl_mst);
		$dispstr		  	  = "";
		if($cntprfsnl_inc > 0){
			while($srowprfsnl_mst = mysqli_fetch_assoc($srsprfsnl_mst)){
				$scatid  = $srowprfsnl_mst['prfsnlm_id'];
				$scatnm  = $srowprfsnl_mst['prfsnlm_name'];			
				//$dispstr .= ","."$scatid:$scatnm";
				$dispstr .= ",".$scatnm;			
			}
			$result = substr($dispstr,1);		
		}
		echo $result;
	}
	
	
	
	/*Get Customers*/
	
	
	
		if(isset($_REQUEST['selclntypid']) && (trim($_REQUEST['selclntypid']) != "")){
		// creating Drop Down for County
		$result = "";		
		$catid = glb_func_chkvl($_REQUEST['selclntypid']);
		$sqryprfsnl_mst =  "select 
							   		cstmrm_id,cstmrm_name
							  from 
									cstmr_mst
							  where 
									cstmrm_sts='a' and 
									cstmrm_typrjctm_id = $catid
							  group by cstmrm_id order by cstmrm_prty";								
	//echo $sqryprfsnl_mst;
		$srsprfsnl_mst	  = mysqli_query($conn,$sqryprfsnl_mst);
		$cntprfsnl_inc	  = mysqli_num_rows($srsprfsnl_mst);		  
		$dispstr		  	  = "";		
		if($cntprfsnl_inc > 0){
			

    
	
	while($srowprfsnl_mst = mysqli_fetch_assoc($srsprfsnl_mst)){
				$scatid  = $srowprfsnl_mst['cstmrm_id'];
				$scatnm  = $srowprfsnl_mst['cstmrm_name'];			
				//$dispstr .= ","."$scatid:$scatnm";
				$dispstr .= ",".$scatnm;			
			}
			$result = substr($dispstr,1);		
		}
		echo $result;
	}
	
    
	
			/*Get Customers*/
	
	
	
		if(isset($_REQUEST['selclntypidval']) && (trim($_REQUEST['selclntypidval']) != "")){
		// creating Drop Down for County
		$result = "";
		$catid = glb_func_chkvl($_REQUEST['selclntypidval']);
		$sqryprfsnl_mst =  "select
							   		cstmrm_id,cstmrm_name
							  from
									cstmr_mst
							  where
									cstmrm_sts='a' and
									cstmrm_typrjctm_id = $catid
							  group by cstmrm_id order by cstmrm_prty";
	//echo $sqryprfsnl_mst;
		$srsprfsnl_mst	  = mysqli_query($conn,$sqryprfsnl_mst);
		$cntprfsnl_inc	  = mysqli_num_rows($srsprfsnl_mst);
		$dispstr		  	  = "";
		if($cntprfsnl_inc > 0){
			?>
	<option value disabled selected>Select Customer</option>
<?php
    while ($prg = mysqli_fetch_array($srsprfsnl_mst)) {
        ?>
<option value="<?php echo $prg["cstmrm_id"]; ?>"><?php echo $prg["cstmrm_name"]; ?></option>
<?php
    }
	}
	
	
		}

		/*Get Roles*/	

		/*Get Roles*/
		
		
		
	if(isset($_REQUEST['dprtmnt']) && (trim($_REQUEST['dprtmnt']) != "")){
		// creating Drop Down for County
		$result = "";		
		$dprtmnt = glb_func_chkvl($_REQUEST['dprtmnt']);
		$sqryprfsnl_mst =  "select 
							   		rlsm_id,rlsm_role
							  from 
									rls_mst
							  where 
									rlsm_sts='a' and 
									rlsm_dprtmntm_id = $dprtmnt
							  group by rlsm_id order by rlsm_prty";								
	//echo $sqryprfsnl_mst;
		$srsprfsnl_mst	  = mysqli_query($conn,$sqryprfsnl_mst);
		$cntprfsnl_inc	  = mysqli_num_rows($srsprfsnl_mst);		  
		$dispstr		  	  = "";		

	?>
	
	<option value disabled selected>Select Role*</option>
<?php
    while ($prg = mysqli_fetch_array($srsprfsnl_mst)) {
        ?>
<option value="<?php echo $prg["rlsm_id"]; ?>"><?php echo $prg["rlsm_role"]; ?></option>
<?php
    }
	}

/**Primary Contact*/

if(isset($_REQUEST['primry']) && (trim($_REQUEST['primry']) != "")){
	// creating Drop Down for County
	$result = "";		
	$cstmr = glb_func_chkvl($_REQUEST['primry']);
	$sqrycst_dtl="select 
	cstmrd_cstmrm_id,cstmrd_name,cstmrd_desig,
				cstmrd_email,cstmrd_mbno,cstmrd_dob,
				cstmrd_typ,cstmrd_sts,cstmrd_prty,cstmrd_crtdon,
				cstmrd_crtdby,cstmrd_id
from 
cstmr_dtl
where 
cstmrd_cstmrm_id ='$cstmr'";
echo $sqrycst_dtl;
$srscst_dtl	= mysqli_query($conn,$sqrycst_dtl);		
$cntcst_dtl  = mysqli_num_rows($srscst_dtl);
$cnt = $offset;
?> 
<option value="">--Select--</option>
<?php
if($cntcst_dtl > 0){
while($rowcst_dtl=mysqli_fetch_assoc($srscst_dtl)){
	?>
<option value="<?php echo $rowcst_dtl["cstmrd_id"]; ?>"><?php echo $rowcst_dtl["cstmrd_name"]; ?></option>
<?php
}
}


}




/*vendor Name*/
if(isset($_REQUEST['cstidval']) && (trim($_REQUEST['cstidval']) != "")){
	$cstidval = $_REQUEST['cstidval'];


	
			 $sqrycstd_mst= "select 
			 cstmrd_cstmrm_id,cstmrd_name,cstmrd_desig,
						 cstmrd_email,cstmrd_mbno,cstmrd_dob,
						 cstmrd_typ,cstmrd_sts,cstmrd_prty,cstmrd_crtdon,
						 cstmrd_crtdby,cstmrd_id
		 from 
		 cstmr_dtl
		 where 
		 cstmrd_id  in ($cstidval)
						";
					
						
						//echo $sqrycrtmstr_mst;
						 $rscstd_mst  =  mysqli_query($conn,$sqrycstd_mst);
						 $cntrws  =  mysqli_num_rows($rscstd_mst);
							$sn =1 ;
						 while($rwscstd = mysqli_fetch_array($rscstd_mst)){
							 if($cntrws == $sn){
								 $cnct = "";
								 }else{
								 $cnct = ",";
									 }
							 
						
						echo  $vndrnm =  "&nbsp;".$sn.")".$rwscstd['cstmrd_name'].$cnct; 
						$sn++;
						}

	
	
	
	}
	


	

	/*Get Emplyee*/
	if(isset($_REQUEST['dprtmntval']) && (trim($_REQUEST['dprtmntval']) != "")&&
	isset($_REQUEST['rles']) && (trim($_REQUEST['rles']) != "")){
		// creating Drop Down for County
		$result = "";		
		$dprtmnt = glb_func_chkvl($_REQUEST['dprtmntval']);
		$rles = glb_func_chkvl($_REQUEST['rles']);

		$sqryprfsnl_mst =  "select 
							   		empm_id,empm_name
							  from 
									emp_mst
							inner join empdept_dtl on empdept_dtl.empdeptd_empm_id= empm_id		
							inner join rls_mst on rls_mst.rlsm_id= empdeptd_rlsm_id		

							  where 
									empm_sts='a' and 
									empdeptd_dprtmntm_id = $dprtmnt and
									empdeptd_rlsm_id = $rles 
							 ";	
	/*if(isset($_REQUEST['prjctemp']) && (trim($_REQUEST['prjctemp']) != "")){
		$prjctemp = glb_func_chkvl($_REQUEST['prjctemp']);
	}*/							
	//echo $sqryprfsnl_mst;
		$srsprfsnl_mst	  = mysqli_query($conn,$sqryprfsnl_mst);
		$cntprfsnl_inc	  = mysqli_num_rows($srsprfsnl_mst);		  
		$dispstr		  	  = "";		

	?>
	
	<option value disabled selected>Select Employee</option>
<?php
    while ($prg = mysqli_fetch_array($srsprfsnl_mst)) {
        ?>
<option value="<?php echo $prg["empm_id"]; ?>"><?php echo $prg["empm_name"]; ?></option>
<?php
    }
	}
	

		/*Get RFQ*/
	if(isset($_REQUEST['typrjct']) && (trim($_REQUEST['typrjct']) != "")&&
	isset($_REQUEST['cstmr']) && (trim($_REQUEST['cstmr']) != "")){
		// creating Drop Down for County
		$result = "";		
		$typrjct = glb_func_chkvl($_REQUEST['typrjct']);
		$cstmr = glb_func_chkvl($_REQUEST['cstmr']);

		$sqryprfsnl_mst =  "select 
							   		qtnm_id,qtnm_name
							  from 
									qtn_mst
							  where 
									qtnm_sts ='a' and 
									qtnm_typrjctm_id = $typrjct and 
                                    qtnm_cstmrm_id = $cstmr
							  group by qtnm_id order by qtnm_name";								
		$srsprfsnl_mst	  = mysqli_query($conn,$sqryprfsnl_mst);
		$cntprfsnl_inc	  = mysqli_num_rows($srsprfsnl_mst);		  
		$dispstr		  	  = "";		

	?>
	
	<option value disabled selected>Select RFQ</option>
<?php
    while ($prg = mysqli_fetch_array($srsprfsnl_mst)) {
        ?>
<option value="<?php echo $prg["qtnm_id"]; ?>"><?php echo $prg["qtnm_name"]; ?></option>
<?php
    }
	}
			/*Get Vendors*/
			                $resultloc = "";

	if(isset($_REQUEST['typrj']) && (trim($_REQUEST['typrj']) == "")){
		// creating Drop Down for County
		$result = "";		
		$typrjct = glb_func_chkvl($_REQUEST['typrj']);

		/*$sqryprfsnl_mst =  "select 
							   		vndrm_id,vndrm_name
							  from 
									vndr_mst
							  where 
									vndrm_sts ='a' 
									and vndrm_typrjctm_id = $typrjct
							  group by vndrm_id order by vndrm_name";*/	
		$sqryprfsnl_mst =  "select 
							   		vndrm_id,vndrm_name
							  from 
									vndr_mst
							  where 
									vndrm_sts ='a' 
							group by vndrm_id order by vndrm_name";							

		$srsprfsnl_mst	  = mysqli_query($conn,$sqryprfsnl_mst);
		$cntprfsnl_inc	  = mysqli_num_rows($srsprfsnl_mst);		  
		$dispstr		  	  = "";		



			$resultloc   = "<table width=\"100%\" cellspacing=\"1\" cellpadding=\"1\" class=\"table-condensed table-bordered table-striped\"><tr>";
			   while($prg = mysqli_fetch_assoc($srsprfsnl_mst)){
					if(($inc != 0) && ($inc % 1 == 0)){
					  $resultloc .= "</tr><tr>";
					}					
				 $crtmstrid   = $prg['vndrm_id'];
				 $crtmstrname = $prg['vndrm_name'];						
				$resultloc .= "<td align=\"left\" width=\"30%\">
							<input type=\"checkbox\" name=\"chksize$crtmstrid\" value=\"$crtmstrid\"
							onclick= \"chkroles('$crtmstrid')\">
								&nbsp;$crtmstrname
							</td>";
				 
							
				 $inc++; 
			  }
			 echo  $resultloc.="</tr></table>";

}

/*Get Customer Mail Ids*/

if(isset($_REQUEST['cstid']) && (trim($_REQUEST['cstid']) != "")){
		// creating Drop Down for County
		$result = "";		
		$cstid = glb_func_chkvl($_REQUEST['cstid']);


		$sqryprfsnl_mst =  "select 
							   		cstmrm_id,cstmrm_name,cstmrd_email,cstmrd_id,cstmrd_name
							  from 
									cstmr_mst
							inner join cstmr_dtl on cstmr_dtl.cstmrd_cstmrm_id = cstmrm_id	
							  where 
									cstmrm_sts ='a' 
									and
									cstmrm_id = $cstid
									and 
									cstmrd_typ = 'y'
							  order by cstmrd_email";							
//echo $sqryprfsnl_mst;
		$srsprfsnl_mst	  = mysqli_query($conn,$sqryprfsnl_mst);
		$cntprfsnl_inc	  = mysqli_num_rows($srsprfsnl_mst);		  
		$dispstr		  	  = "";		



			$resultloc   = "<table width=\"100%\" cellspacing=\"1\" cellpadding=\"1\" class=\"table-condensed table-bordered table-striped\"><tr>";
			   while($prg = mysqli_fetch_assoc($srsprfsnl_mst)){
					if(($inc != 0) && ($inc % 1 == 0)){
					  $resultloc .= "</tr><tr>";
					}					
				 $crtmstrid   = $prg['cstmrd_id'];
				 $crtmstrname = $prg['cstmrd_name'];						
				$resultloc .= "<td align=\"left\" width=\"30%\">
							<input type=\"checkbox\" name=\"chksize$crtmstrid\" value=\"$crtmstrid\"
							onclick= \"chkroles('$crtmstrid')\">
								&nbsp;$crtmstrname
							</td>";
				 
							
				 $inc++; 
			  }
			 echo  $resultloc.="</tr></table>";

}

/*Get Vendor Mail Ids*/

if(isset($_REQUEST['vndrid']) && (trim($_REQUEST['vndrid']) != "")){
		// creating Drop Down for County
		$result = "";		
		$vndrid = glb_func_chkvl($_REQUEST['vndrid']);


		$sqryprfsnl_mst =  "select 
							   		vndrm_id,vndrm_name,vndrd_email,vndrd_id,vndrd_name
							  from 
									vndr_mst
							inner join vndr_dtl on vndr_dtl.vndrd_vndrm_id = vndrm_id	
							  where 
									vndrm_sts ='a' 
									and
									vndrm_id = $vndrid
									and 
									vndrd_typ = 'y'
							  order by vndrd_email";							
//echo $sqryprfsnl_mst;
		$srsprfsnl_mst	  = mysqli_query($conn,$sqryprfsnl_mst);
		$cntprfsnl_inc	  = mysqli_num_rows($srsprfsnl_mst);		  
		$dispstr		  	  = "";		



			$resultloc   = "<table width=\"100%\" cellspacing=\"1\" cellpadding=\"1\" class=\"table-condensed table-bordered table-striped\"><tr>";
			   while($prg = mysqli_fetch_assoc($srsprfsnl_mst)){
					if(($inc != 0) && ($inc % 1 == 0)){
					  $resultloc .= "</tr><tr>";
					}					
				 $crtmstrid   = $prg['vndrd_id'];
				 $crtmstrname = $prg['vndrd_name'];						
				$resultloc .= "<td align=\"left\" width=\"30%\">
							<input type=\"checkbox\" name=\"chksize$crtmstrid\" value=\"$crtmstrid\"
							onclick= \"chkroles('$crtmstrid')\">
								&nbsp;$crtmstrname
							</td>";
				 
							
				 $inc++; 
			  }
			 echo  $resultloc.="</tr></table>";

}




	/*Get Authantication*/
	if(isset($_REQUEST['selathnid']) && (trim($_REQUEST['selathnid']) != "")){
		// creating Drop Down for County
		$result = "";		
		$athnid = glb_func_chkvl($_REQUEST['selathnid']);
         if($athnid == 'e'){
		$sqryprfsnl_mst =  "select 
								empm_id,concat(empm_code,' (', empm_name ,')') as empm_code						
							  from 
									emp_mst	
									where	
									empm_sts='a' 
									group by empm_id
							order by empm_name
							 ";								
		$srsprfsnl_mst	  = mysqli_query($conn,$sqryprfsnl_mst);
		$cntprfsnl_inc	  = mysqli_num_rows($srsprfsnl_mst);		  
		$dispstr		  	  = "";		
	?>
	<option value disabled selected>Select Employee</option>
<?php
    while ($prg = mysqli_fetch_array($srsprfsnl_mst)) {
        ?>
<option value="<?php echo $prg["empm_id"]; ?>"><?php echo $prg["empm_code"]; ?></option>
<?php
    }
}else{
	$sqryprfsnl_mst =  "select 
								vndrm_id,concat(vndrm_code,' (', vndrm_name ,')') as vndrm_code						
							  from 
									vndr_mst	
									where	
									vndrm_sts='a' 
									group by vndrm_id
							order by vndrm_name
							 ";								
		$srsprfsnl_mst	  = mysqli_query($conn,$sqryprfsnl_mst);
		$cntprfsnl_inc	  = mysqli_num_rows($srsprfsnl_mst);		  
		$dispstr		  	  = "";		
	?>
	<option value disabled selected>Select Vendors</option>
<?php
    while ($prg = mysqli_fetch_array($srsprfsnl_mst)) {
        ?>
<option value="<?php echo $prg["vndrm_id"]; ?>"><?php echo $prg["vndrm_code"]; ?></option>
<?php
    }
	
	
	
	
	}
	}




		/*Get Customer PO*/
	if(isset($_REQUEST['typrjctval']) && (trim($_REQUEST['typrjctval']) != "")&&
	isset($_REQUEST['cstmrpo']) && (trim($_REQUEST['cstmrpo']) != "")){
		// creating Drop Down for County
		$result = "";		
		$typrjct = glb_func_chkvl($_REQUEST['typrjctval']);
		$cstmr = glb_func_chkvl($_REQUEST['cstmrpo']);

		$sqryprfsnl_mst =  "select 
							   		qtnm_id,qtnm_name
							  from 
									qtn_mst
						inner join prerfq_mst on prerfq_mst.prerfqm_qtnm_id = qtnm_id 			
							  where 
									qtnm_sts ='q' and 
									qtnm_typrjctm_id = $typrjct and 
                                    qtnm_cstmrm_id = $cstmr
									and 
									prerfqm_stsm_id = '9'
							  group by qtnm_id order by qtnm_name";								
		$srsprfsnl_mst	  = mysqli_query($conn,$sqryprfsnl_mst);
		$cntprfsnl_inc	  = mysqli_num_rows($srsprfsnl_mst);		  
		$dispstr		  	  = "";		

	?>
	
	<option value disabled selected>Select RFQ</option>
<?php
    while ($prg = mysqli_fetch_array($srsprfsnl_mst)) {
        ?>
<option value="<?php echo $prg["qtnm_id"]; ?>"><?php echo $prg["qtnm_name"]; ?></option>
<?php
    }
	}
	
		/*Get Vendor PO*/
	if(isset($_REQUEST['typrjctidval']) && (trim($_REQUEST['typrjctidval']) != "")&&
	isset($_REQUEST['cstmridval']) && (trim($_REQUEST['cstmridval']) != "")&&
	isset($_REQUEST['rfqidval']) && (trim($_REQUEST['rfqidval']) != "")){
		// creating Drop Down for County
		$result = "";		
		$typrjct = glb_func_chkvl($_REQUEST['typrjctidval']);
		$cstmr = glb_func_chkvl($_REQUEST['cstmridval']);
		$rfqid = glb_func_chkvl($_REQUEST['rfqidval']);

		$sqryqtn_mst1="select 
		qtnm_name,qtnm_id,
		typrjctm_id,typrjctm_nm,
		vndr_qtnrplym_id,vndr_qtnrplym_prc,vndrm_id,vndrm_name,
		cstmrm_id,cstmrm_name,adm_prchsrplym_id,adm_prchsrplym_prc,adm_prchsrplym_sts
	from 
		vndr_qtnrply_mst
		inner join typrjct_mst on typrjct_mst.typrjctm_id = vndr_qtnrply_mst.vndr_qtnrplym_typrjctm_id
		
		inner join qtn_mst on qtn_mst.qtnm_id = vndr_qtnrply_mst.vndr_qtnrplym_qtnm_id
		inner join vndr_mst on vndr_mst.vndrm_id = vndr_qtnrply_mst.vndr_qtnrplym_vndrm_id
		inner join cstmr_mst on cstmr_mst.cstmrm_id = qtn_mst.qtnm_cstmrm_id
left join adm_prchsrply_mst on adm_prchsrply_mst.adm_prchsrplym_qtnrplym_id = vndr_qtnrply_mst.vndr_qtnrplym_id
		where
		vndr_qtnrplym_stsid = 2
		and 
		vndr_qtnrplym_typrjctm_id = $typrjct
		and 
		vndr_qtnrplym_qtnm_id  = $rfqid  
		and 
		cstmrm_id = $cstmr
	group by  vndrm_id order by vndrm_name	 	                  
									";								
	//echo $sqryqtn_mst1;;
		$srsprfsnl_mst	  = mysqli_query($conn,$sqryqtn_mst1);
		$cntprfsnl_inc	  = mysqli_num_rows($srsprfsnl_mst);		  
		$dispstr		  	  = "";		

	?>
	
	<option value disabled selected>Select Vendor</option>
<?php
    while ($prg = mysqli_fetch_array($srsprfsnl_mst)) {
        ?>
<option value="<?php echo $prg["vndrm_id"]; ?>"><?php echo $prg["vndrm_name"]; ?></option>
<?php
    }
	}

		/*Get Vendor PO*/
		if(isset($_REQUEST['prchstyprjctidval']) && (trim($_REQUEST['prchstyprjctidval']) != "")&&
		isset($_REQUEST['prchscstmridval']) && (trim($_REQUEST['prchscstmridval']) != "")&&
		isset($_REQUEST['prchsrfqidval']) && (trim($_REQUEST['prchsrfqidval']) != "")){
			// creating Drop Down for County
			$result = "";		
			$typrjct = glb_func_chkvl($_REQUEST['prchstyprjctidval']);
			$cstmr = glb_func_chkvl($_REQUEST['prchscstmridval']);
			$rfqid = glb_func_chkvl($_REQUEST['prchsrfqidval']);
	
		
			$sqryqtn_mst1="select 
			qtnm_name,qtnm_id,
			typrjctm_id,typrjctm_nm,
			prchs_qtnrplym_id,prchs_qtnrplym_prc,vndrm_id,vndrm_name,
			cstmrm_id,cstmrm_name,adm_prchsrplym_id,adm_prchsrplym_prc,adm_prchsrplym_sts
		from 
			prchs_qtnrply_mst
			inner join typrjct_mst on typrjct_mst.typrjctm_id = prchs_qtnrply_mst.prchs_qtnrplym_typrjctm_id
			
			inner join qtn_mst on qtn_mst.qtnm_id = prchs_qtnrply_mst.prchs_qtnrplym_qtnm_id
			inner join vndr_mst on vndr_mst.vndrm_id = prchs_qtnrply_mst.prchs_qtnrplym_vndrm_id
			inner join cstmr_mst on cstmr_mst.cstmrm_id = qtn_mst.qtnm_cstmrm_id
left join adm_prchsrply_mst on adm_prchsrply_mst.adm_prchsrplym_qtnrplym_id = prchs_qtnrply_mst.prchs_qtnrplym_id
			where
			prchs_qtnrplym_stsid = 2
			and 
			prchs_qtnrplym_typrjctm_id = $typrjct
			and 
			prchs_qtnrplym_qtnm_id  = $rfqid  
			and 
			cstmrm_id = $cstmr
		group by  vndrm_id order by vndrm_name	                  
			";	
			$srsprfsnl_mst	  = mysqli_query($conn,$sqryqtn_mst1);
			$cntprfsnl_inc	  = mysqli_num_rows($srsprfsnl_mst);		  
			$dispstr		  	  = "";		
	
		?>
		
		<option value disabled selected>Select Vendor</option>
	<?php
		while ($prg = mysqli_fetch_array($srsprfsnl_mst)) {
			?>
	<option value="<?php echo $prg["vndrm_id"]; ?>"><?php echo $prg["vndrm_name"]; ?></option>
	<?php
		}
		}






		/*Get Purchase PO*/
		if(isset($_REQUEST['prctyprjctidval']) && (trim($_REQUEST['prctyprjctidval']) != "")&&
		isset($_REQUEST['prccstmridval']) && (trim($_REQUEST['prccstmridval']) != "")&&
		isset($_REQUEST['prcrfqidval']) && (trim($_REQUEST['prcrfqidval']) != "")){
			// creating Drop Down for County
			$result = "";		
			$typrjct = glb_func_chkvl($_REQUEST['prctyprjctidval']);
			$cstmr = glb_func_chkvl($_REQUEST['prccstmridval']);
			$rfqid = glb_func_chkvl($_REQUEST['prcrfqidval']);
	
			$sqryqtn_mst1="select 
										qtnm_name,qtnm_id,
										typrjctm_id,typrjctm_nm,
										vndr_qtnrplym_id,vndr_qtnrplym_prc,vndrm_id,vndrm_name,
										cstmrm_id,cstmrm_name,adm_prchsrplym_id,adm_prchsrplym_prc,adm_prchsrplym_sts
									from 
										vndr_qtnrply_mst
										inner join typrjct_mst on typrjct_mst.typrjctm_id = vndr_qtnrply_mst.vndr_qtnrplym_typrjctm_id
										
										inner join qtn_mst on qtn_mst.qtnm_id = vndr_qtnrply_mst.vndr_qtnrplym_qtnm_id
										inner join vndr_mst on vndr_mst.vndrm_id = vndr_qtnrply_mst.vndr_qtnrplym_vndrm_id
	    	inner join cstmr_mst on cstmr_mst.cstmrm_id = qtn_mst.qtnm_cstmrm_id
		   left join adm_prchsrply_mst on adm_prchsrply_mst.adm_prchsrplym_qtnrplym_id = vndr_qtnrply_mst.vndr_qtnrplym_id
										where
										vndr_qtnrplym_stsid = 2
										and 
										vndr_qtnrplym_typrjctm_id = $typrjct
										and 
										vndr_qtnrplym_qtnm_id  = $rfqid  
										and 
										cstmrm_id = $cstmr
									group by  vndrm_id order by vndrm_name							";								
		//echo $sqryqtn_mst1;;
			$srsprfsnl_mst	  = mysqli_query($conn,$sqryqtn_mst1);
			$cntprfsnl_inc	  = mysqli_num_rows($srsprfsnl_mst);		  
			$dispstr		  	  = "";		
	
		?>
		
		<option value disabled selected>Select Vendor</option>
	<?php
		while ($prg = mysqli_fetch_array($srsprfsnl_mst)) {
			?>
	<option value="<?php echo $prg["vndrm_id"]; ?>"><?php echo $prg["vndrm_name"]; ?></option>
	<?php
		}
		}






	
/*Get Customers*/
	$resultcstmr = "";

	if(isset($_REQUEST['empcde']) && (trim($_REQUEST['empcde']) != "")){
		// creating Drop Down for County
		$result = "";		

		$sqryprfsnl_mst =  "select 
							   		cstmrm_id,cstmrm_name
							  from 
									cstmr_mst
							  where 
									cstmrm_sts ='a'
							  group by cstmrm_id order by cstmrm_name";								

		$srsprfsnl_mst	  = mysqli_query($conn,$sqryprfsnl_mst);
		$cntprfsnl_inc	  = mysqli_num_rows($srsprfsnl_mst);		  
		$dispstr		  	  = "";		



			$resultcstmr   = "<table width=\"100%\" cellspacing=\"1\" cellpadding=\"1\" class=\"table-condensed table-bordered table-striped\"><tr>";
			   while($prg = mysqli_fetch_assoc($srsprfsnl_mst)){
					if(($inc != 0) && ($inc % 3 == 0)){
					  $resultloc .= "</tr><tr>";
					}					
				 $crtmstrid   = $prg['cstmrm_id'];
				 $crtmstrname = $prg['cstmrm_name'];						
				$resultcstmr .= "<td align=\"left\" width=\"30%\">
							<input type=\"checkbox\" name=\"chksize$crtmstrid\" value=\"$crtmstrid\"
							onclick= \"chkcstmrs('$crtmstrid')\">
								&nbsp;$crtmstrname
							</td>";
				 
							
				 $inc++; 
			  }
			 echo  $resultcstmr.="</tr></table>";

}

	
/*Get Customer */
	if(isset($_REQUEST['empid']) && (trim($_REQUEST['empid']) != "")){
		// creating Drop Down for County
		$result = "";		
		$empid = glb_func_chkvl($_REQUEST['empid']);

		$sqrycst_mst =  "select 
							   		cstmrm_id,cstmrm_name
							  from 
									cstmr_mst
						inner join empcst_dtl on empcst_dtl.empcstd_cstmrm_id = cstmrm_id 			
							  where 
									cstmrm_sts ='a' and 
									empcstd_empm_id = $empid
							  group by cstmrm_id order by cstmrm_name";								
		$srscst_mstt	  = mysqli_query($conn,$sqrycst_mst);
		$cntcst_inc	  = mysqli_num_rows($srscst_mstt);		  
		$dispstr		  	  = "";		

	?>
	
	<option value disabled selected>Select Customer</option>
<?php
    while ($cstmr = mysqli_fetch_array($srscst_mstt)) {
        ?>
<option value="<?php echo $cstmr["cstmrm_id"]; ?>"><?php echo $cstmr["cstmrm_name"]; ?></option>
<?php
    }
	}

	
/*Get Details */
	if(isset($_REQUEST['rfqid']) && (trim($_REQUEST['rfqid']) != "")){
		// creating Drop Down for County
		$result = "";		
		$rfqid = glb_func_chkvl($_REQUEST['rfqid']);

		$preqtn = glb_func_chkvl($_REQUEST['preqtn']);

		$cstpoid = glb_func_chkvl($_REQUEST['cstpoid']);

		$sqrycst_mst = "SELECT 
									qtnm_name,qtnm_id,qtnm_dprtmntm_id,qtnm_rlsm_id,qtnm_empm_id,qtnm_typrjctm_id,qtnm_cstmrm_id,
									qtnm_rfqdt,dprtmntm_id,dprtmntm_name,rlsm_id,rlsm_role,empm_id,empm_name,
									typrjctm_id,typrjctm_nm,cstmrm_id,cstmrm_name,qtnm_desc_one,qtnm_desc_two,qtnm_fle,qtnm_rfqdt,
							  qtnm_stsm_id,qtnm_sts,qtnm_prty,qtnm_crtdon,qtnm_crtdby,cstpom_id,cstpom_cde,cstpom_typ,prerfqm_id
								from 
									qtn_mst
									inner join dprtmnt_mst on dprtmnt_mst.dprtmntm_id = qtn_mst.qtnm_dprtmntm_id
									inner join rls_mst on rls_mst.rlsm_id = qtn_mst.qtnm_rlsm_id
									inner join emp_mst on emp_mst.empm_id = qtn_mst.qtnm_empm_id
									inner join empdept_dtl on empdept_dtl.empdeptd_empm_id = emp_mst.empm_id
									inner join typrjct_mst on typrjct_mst.typrjctm_id = qtn_mst.qtnm_typrjctm_id
									inner join cstmr_mst on cstmr_mst.cstmrm_id = qtn_mst.qtnm_cstmrm_id
									inner join  prerfq_mst on  prerfq_mst.prerfqm_qtnm_id = qtn_mst.qtnm_id


									left join cstpo_mst on cstpo_mst.cstpom_prerfqm_id = prerfq_mst.prerfqm_id
								where
									qtnm_id ='$rfqid' ";
								
								if($preqtn !=''){
								$sqrycst_mst .= "	and
									prerfqm_id = '$preqtn' ";
									}
									if($cstpoid != "undefined"){
								$sqrycst_mst .= "	and
									cstpom_id = '$cstpoid' ";
									}

								// echo 	$sqrycst_mst;exit;
		$srscst_mstt	  = mysqli_query($conn,$sqrycst_mst);
		$cntcst_inc	  = mysqli_num_rows($srscst_mstt);		  
		$dispstr		  	  = "";		

	?>
	
<?php
   $rowscrtmstr_mst = mysqli_fetch_array($srscst_mstt);
    $dprtmnt   =     $rowscrtmstr_mst['dprtmntm_name'];
    $role      =     $rowscrtmstr_mst['rlsm_role'];
    $emp       =     $rowscrtmstr_mst['empm_name'];
    $typrjct =     $rowscrtmstr_mst['typrjctm_nm'];
    $cstmr =     $rowscrtmstr_mst['cstmrm_name'];
	$dprtmntid   =     $rowscrtmstr_mst['dprtmntm_id'];
    $roleid      =     $rowscrtmstr_mst['rlsm_id'];
    $empid       =     $rowscrtmstr_mst['empm_id'];
    $typrjctid =     $rowscrtmstr_mst['typrjctm_id'];
	$cstmrid =     $rowscrtmstr_mst['cstmrm_id'];
	$cstmrpotyp =     $rowscrtmstr_mst['cstpom_typ'];
	$cstmrpoid =     $rowscrtmstr_mst['cstpom_id'];
	$cstpom_cde =     $rowscrtmstr_mst['cstpom_cde'];
	$prerfqm_id =     $rowscrtmstr_mst['prerfqm_id'];
// echo $cstpoid; exit;
	if ($cstpoid != "undefined")
	{
		$res = $dprtmnt."|".$role."|".$emp."|".$typrjct."|".$cstmr."|".$dprtmntid."|".$roleid."|".$empid."|".$typrjctid."|".$cstmrid."|".$cstpoid."|".$cstmrpotyp."|".$prerfqm_id."|".$cstpom_cde;
	}
	else
	{
		$res = $dprtmnt."|".$role."|".$emp."|".$typrjct."|".$cstmr."|".$dprtmntid."|".$roleid."|".$empid."|".$typrjctid."|".$cstmrid."|"."|"."|".$prerfqm_id;
	}
	echo $res;
	}




	if(isset($_REQUEST['vsrfqid']) && (trim($_REQUEST['vsrfqid']) != "")){
		// creating Drop Down for County
		$result = "";		
		$rfqid = glb_func_chkvl($_REQUEST['vsrfqid']);


		
		$sqrycst_mst = "select 
									qtnm_name,qtnm_id,qtnm_dprtmntm_id,qtnm_rlsm_id,qtnm_empm_id,qtnm_typrjctm_id,qtnm_cstmrm_id,
									qtnm_rfqdt,dprtmntm_id,dprtmntm_name,rlsm_id,rlsm_role,empm_id,empm_name,
									typrjctm_id,typrjctm_nm,cstmrm_id,cstmrm_name,qtnm_desc_one,qtnm_desc_two,qtnm_fle,qtnm_rfqdt,
							  qtnm_stsm_id,qtnm_sts,qtnm_prty,qtnm_crtdon,qtnm_crtdby
								from 
									qtn_mst
									inner join dprtmnt_mst on dprtmnt_mst.dprtmntm_id = qtn_mst.qtnm_dprtmntm_id
									inner join rls_mst on rls_mst.rlsm_id = qtn_mst.qtnm_rlsm_id
									inner join emp_mst on emp_mst.empm_id = qtn_mst.qtnm_empm_id
									inner join empdept_dtl on empdept_dtl.empdeptd_empm_id = emp_mst.empm_id
									inner join typrjct_mst on typrjct_mst.typrjctm_id = qtn_mst.qtnm_typrjctm_id
									inner join cstmr_mst on cstmr_mst.cstmrm_id = qtn_mst.qtnm_cstmrm_id
									
								where
									qtnm_id ='$rfqid'
									 
									";						
								//	echo 	$sqrycst_mst;
		$srscst_mstt	  = mysqli_query($conn,$sqrycst_mst);
		$cntcst_inc	  = mysqli_num_rows($srscst_mstt);		  
		$dispstr		  	  = "";		

	?>
	
<?php
   $rowscrtmstr_mst = mysqli_fetch_array($srscst_mstt);
    $dprtmnt   =     $rowscrtmstr_mst['dprtmntm_name'];
    $role      =     $rowscrtmstr_mst['rlsm_role'];
    $emp       =     $rowscrtmstr_mst['empm_name'];
    $typrjct =     $rowscrtmstr_mst['typrjctm_nm'];
    $cstmr =     $rowscrtmstr_mst['cstmrm_name'];
	$dprtmntid   =     $rowscrtmstr_mst['dprtmntm_id'];
    $roleid      =     $rowscrtmstr_mst['rlsm_id'];
    $empid       =     $rowscrtmstr_mst['empm_id'];
    $typrjctid =     $rowscrtmstr_mst['typrjctm_id'];
	$cstmrid =     $rowscrtmstr_mst['cstmrm_id'];
	$cstmrpotyp =     $rowscrtmstr_mst['cstpom_typ'];
	$cstmrpoid =     $rowscrtmstr_mst['cstpom_id'];
	$prerfqm_id =     $rowscrtmstr_mst['prerfqm_id'];

	
	
	

 $res = $dprtmnt."-".$role."-".$emp."-".$typrjct."-".$cstmr."-".$dprtmntid."-".$roleid."-".$empid."-".$typrjctid."-".$cstmrid;
echo $res;
	}


/*Get Details */
if(isset($_REQUEST['vrfqid']) && (trim($_REQUEST['vrfqid']) != "")&&
isset($_REQUEST['vndrvalid']) && (trim($_REQUEST['vndrvalid']) != "")){
	// creating Drop Down for County
	$result = "";		
	$vrfqid = glb_func_chkvl($_REQUEST['vrfqid']);
	$vndrid = glb_func_chkvl($_REQUEST['vndrvalid']);
	$rplyid = glb_func_chkvl($_REQUEST['rplyid']);


	





								$sqryvndrpo_mst = "select 

				   qtnm_name,qtnm_id,

				   typrjctm_id,typrjctm_nm,

				   vndr_qtnrplym_id,vndr_qtnrplym_prc,vndrm_id,vndrm_name,

				   cstmrm_id,cstmrm_name,adm_qtnrplym_id,adm_qtnrplym_prc,adm_qtnrplym_sts,

				   qtnm_code,vndr_qtnrplym_rfqnm,vndr_qtstsm_name,vndr_qtnrplym_refid,vndr_qtstsm_id,
				   acsvndrm_sts,acsvndrm_id,vndr_qtnrplym_rfqdt,
				   dprtmntm_id,dprtmntm_name,rlsm_id,rlsm_role,empm_id,empm_name,prjctm_id,prjctm_cde
  			   from 
				   vndr_qtnrply_mst
				   inner join typrjct_mst on typrjct_mst.typrjctm_id = vndr_qtnrply_mst.vndr_qtnrplym_typrjctm_id
				   inner join qtn_mst on qtn_mst.qtnm_id = vndr_qtnrply_mst.vndr_qtnrplym_qtnm_id
				   inner join dprtmnt_mst on dprtmnt_mst.dprtmntm_id = qtn_mst.qtnm_dprtmntm_id
				   inner join rls_mst on rls_mst.rlsm_id = qtn_mst.qtnm_rlsm_id
				   inner join emp_mst on emp_mst.empm_id = qtn_mst.qtnm_empm_id
					left join prjct_mst on prjct_mst.prjctm_qtnm_id = qtn_mst.qtnm_id

				   inner join empdept_dtl on empdept_dtl.empdeptd_empm_id = emp_mst.empm_id
				   inner join vndr_mst on vndr_mst.vndrm_id = vndr_qtnrply_mst.vndr_qtnrplym_vndrm_id
				   inner join cstmr_mst on cstmr_mst.cstmrm_id = qtn_mst.qtnm_cstmrm_id
				   inner join  cstpo_mst on  cstpo_mst.cstpom_qtnm_id = qtn_mst.qtnm_id 
				   inner join cstmrposts_mst on cstmrposts_mst.cstmrpostsm_id = cstpo_mst.cstpom_cstmrpostsm_id
				   left join acsvndr_mst on acsvndr_mst.acsvndr_qtnrplym_id = vndr_qtnrply_mst.vndr_qtnrplym_id
				  inner join adm_qtnrply_mst on adm_qtnrply_mst.adm_vndr_qtnrplym_id = vndr_qtnrply_mst.vndr_qtnrplym_id
				  inner join vndr_qtsts_mst on vndr_qtsts_mst.vndr_qtstsm_id = vndr_qtnrply_mst.vndr_qtnrplym_stsid 

					 where
								   
								   vndr_qtnrplym_qtnm_id ='$vrfqid'
								   and
								   vndr_qtnrplym_vndrm_id = $vndrid  
									and 
									vndr_qtnrplym_id = $rplyid 

								   ";
					//	echo 		$sqryvndrpo_mst;
	$srsvndrpo_mst	  = mysqli_query($conn,$sqryvndrpo_mst);
	$cntcst_inc	  = mysqli_num_rows($srsvndrpo_mst);		  
	$dispstr		  	  = "";		

$rowsvndr_mst = mysqli_fetch_array($srsvndrpo_mst);
$qtnid   =     $rowsvndr_mst['qtnm_id'];
$vndrmid      =     $rowsvndr_mst['vndrm_id'];  
$sqrypo_mst="select 
vndrpom_id,vndrpom_rfqdt,vndrpom_typ,
vndrpom_vndrm_id,vndrpom_qtnm_id,vndrpom_prc,vndrpom_prtlprc,vndrpom_fle,vndrpom_pocde,vndrpostsm_nm 
from 
vndrpo_mst
inner join vndrposts_mst on vndrposts_mst.vndrpostsm_id = vndrpo_mst.vndrpom_vndrpostsm_id
where
vndrpom_qtnm_id = $qtnid
and 
vndrpom_vndrm_id = $vndrmid
order by vndrpom_id desc
";
$respo_mst = mysqli_query($conn,$sqrypo_mst);	
$srowpo_mst=mysqli_fetch_assoc($respo_mst);	
$vndrpomid =     $srowpo_mst['vndrpom_id'];						
$cstmrpotyp =     $srowpo_mst['vndrpom_typ'];



$dprtmnt   =     $rowsvndr_mst['dprtmntm_name'];
$role      =     $rowsvndr_mst['rlsm_role'];
$emp       =     $rowsvndr_mst['empm_name'];
$typrjct =     $rowsvndr_mst['typrjctm_nm'];
$cstmr =     $rowsvndr_mst['cstmrm_name'];
$dprtmntid   =     $rowsvndr_mst['dprtmntm_id'];
$roleid      =     $rowsvndr_mst['rlsm_id'];
$empid       =     $rowsvndr_mst['empm_id'];
$typrjctid =     $rowsvndr_mst['typrjctm_id'];
$cstmrid =     $rowsvndr_mst['cstmrm_id'];

$vndrnm =     $rowsvndr_mst['vndrm_name'];
$vndrid =     $rowsvndr_mst['vndrm_id'];
$admqtn_id =     $rowsvndr_mst['adm_qtnrplym_id'];
$prjctm_cde =     $rowsvndr_mst['prjctm_cde'];
$prjctm_id =     $rowsvndr_mst['prjctm_id'];





$vres = $dprtmnt."<->".$role."<->".$emp."<->".$typrjct."<->".$cstmr."<->".$dprtmntid."<->".$roleid."<->".$empid."<->".$typrjctid."<->".$cstmrid."<->".$vndrpomid."<->".$cstmrpotyp."<->".$vndrid."<->".$vndrnm."<->".$admqtn_id."<->".$prjctm_cde."<->".$prjctm_id;
echo $vres;
}



/*Get Shipping Details */
if(isset($_REQUEST['shpvrfqid']) && (trim($_REQUEST['shpvrfqid']) != "")&&
isset($_REQUEST['shpvndrvalid']) && (trim($_REQUEST['shpvndrvalid']) != "")){
	// creating Drop Down for County
	$result = "";		
	$shpvrfqid = glb_func_chkvl($_REQUEST['shpvrfqid']);
	$shpvndrid = glb_func_chkvl($_REQUEST['shpvndrvalid']);

				  $sqryvndrpo_mst = "
				  select 

				  qtnm_name,qtnm_id,
			  
				  typrjctm_id,typrjctm_nm,
			  
				  vndrpom_id,vndrm_id,vndrm_name,vndrpom_typ,vndrpom_plndt,
			  
				  cstmrm_id,cstmrm_name,qtnm_code,dprtmntm_id,dprtmntm_name,rlsm_id,rlsm_role,empm_id,empm_name,vndrpom_pocde
				  
			  from 
					 vndrpo_mst
				  inner join typrjct_mst on typrjct_mst.typrjctm_id = vndrpo_mst.vndrpom_typrjctm_id
				  inner join qtn_mst on qtn_mst.qtnm_id = vndrpo_mst.vndrpom_qtnm_id
				  inner join vndr_mst on vndr_mst.vndrm_id = vndrpo_mst.vndrpom_vndrm_id
				  inner join cstmr_mst on cstmr_mst.cstmrm_id = vndrpo_mst.vndrpom_cstmrm_id
				  inner join dprtmnt_mst on dprtmnt_mst.dprtmntm_id = qtn_mst.qtnm_dprtmntm_id
				  inner join rls_mst on rls_mst.rlsm_id = qtn_mst.qtnm_rlsm_id
				  inner join emp_mst on emp_mst.empm_id = qtn_mst.qtnm_empm_id
				  inner join empdept_dtl on empdept_dtl.empdeptd_empm_id = emp_mst.empm_id
			   



					 where
					 vndrpom_id !='' 
								   and
								   vndrpom_qtnm_id ='$shpvrfqid'
								   and
								   vndrpom_vndrm_id = $shpvndrid  
								   ";
								
	$srsvndrpo_mst	  = mysqli_query($conn,$sqryvndrpo_mst);
	$cntcst_inc	  = mysqli_num_rows($srsvndrpo_mst);		  
	$dispstr		  	  = "";		

$rowsvndr_mst = mysqli_fetch_array($srsvndrpo_mst);
$qtnid   =     $rowsvndr_mst['qtnm_id'];
$vndrmid      =     $rowsvndr_mst['vndrm_id'];  

$vndrpomid =     $rowsvndr_mst['vndrpom_id'];						
$vndrpom_typ =     $rowsvndr_mst['vndrpom_typ'];

$vndrpom_pocde =     $rowsvndr_mst['vndrpom_pocde'];





$dprtmnt   =     $rowsvndr_mst['dprtmntm_name'];
$role      =     $rowsvndr_mst['rlsm_role'];
$emp       =     $rowsvndr_mst['empm_name'];
$typrjct =     $rowsvndr_mst['typrjctm_nm'];
$cstmr =     $rowsvndr_mst['cstmrm_name'];
$dprtmntid   =     $rowsvndr_mst['dprtmntm_id'];
$roleid      =     $rowsvndr_mst['rlsm_id'];
$empid       =     $rowsvndr_mst['empm_id'];
$typrjctid =     $rowsvndr_mst['typrjctm_id'];
$cstmrid =     $rowsvndr_mst['cstmrm_id'];

$vndrnm =     $rowsvndr_mst['vndrm_name'];
$vndrid =     $rowsvndr_mst['vndrm_id'];

$vndrpom_plndt =     $rowsvndr_mst['vndrpom_plndt'];




$vres = $dprtmnt."|".$role."|".$emp."|".$typrjct."|".$cstmr."|".$dprtmntid."|".$roleid."|".$empid."|".$typrjctid."|".$cstmrid."|".$vndrpomid."|".$vndrpom_typ."|".$vndrid."|".$vndrnm."|".$vndrpom_plndt."|".$vndrpom_pocde;
echo $vres;
}

/*Customer PO Details*/
if(isset($_REQUEST['shpcrfqid']) && (trim($_REQUEST['shpcrfqid']) != "")&&
isset($_REQUEST['shpcvalid']) && (trim($_REQUEST['shpcvalid']) != "")){
	// creating Drop Down for County
	$result = "";		
	$shpvrfqid = glb_func_chkvl($_REQUEST['shpcrfqid']);
	$shpvndrid = glb_func_chkvl($_REQUEST['shpcvalid']);

				  $sqryvndrpo_mst = "
				  select 
									intshp_rqstm_qtnm_id ,intshp_rqstm_dprtmntm_id,intshp_rqstm_rlsm_id,intshp_rqstm_empm_id,intshp_rqstm_typrjctm_id,intshp_rqstm_id,
							 intshp_rqstm_cstmrm_id,intshp_rqstm_desc_one,intshp_rqstm_desc_two,intshp_rqstm_fle,intshp_rqstm_rfqdt,
							  intshp_rqstm_stsm_id,intshp_rqstm_sts,intshp_rqstm_prty,intshp_rqstm_crtdon,intshp_rqstm_crtdby,empm_id,empm_name,qtnm_name,qtnm_id,
									typrjctm_id,typrjctm_nm,cstmrm_id,cstmrm_name,intshp_rqstm_sts,intshp_rqstd_intshp_rqstm_id,intshp_rqstd_vndrm_id,qtnm_code,
									intshp_rqstm_rqstcode,intshp_rqstd_typsrvsm_id,vndrm_name,typsrvsm_id,
									typsrvsm_name,cstpom_cde,intshp_rqstm_rfqdt,cstpom_pocde,cstpom_id,vndrm_id
								from 
									intshp_rqst_mst
							
									inner join emp_mst on emp_mst.empm_id = intshp_rqst_mst.intshp_rqstm_empm_id
									
									inner join typrjct_mst on typrjct_mst.typrjctm_id = intshp_rqst_mst.intshp_rqstm_typrjctm_id
									inner join cstmr_mst on cstmr_mst.cstmrm_id = intshp_rqst_mst.intshp_rqstm_cstmrm_id
									
										inner join qtn_mst on qtn_mst.qtnm_id = intshp_rqst_mst.intshp_rqstm_qtnm_id 
										inner join cstpo_mst on cstpo_mst.cstpom_qtnm_id = qtn_mst.qtnm_id

									
									inner join intshp_rqst_dtl on intshp_rqst_dtl.intshp_rqstd_intshp_rqstm_id = intshp_rqst_mst.intshp_rqstm_id

									
									inner join vndr_mst on vndr_mst.vndrm_id = intshp_rqst_dtl.intshp_rqstd_vndrm_id
									inner join typsrvs_mst on typsrvs_mst.typsrvsm_id = intshp_rqst_dtl.intshp_rqstd_typsrvsm_id
									
					 where
					 
					 intshp_rqstm_qtnm_id ='$shpvrfqid'
								   and
								   intshp_rqstd_vndrm_id = $shpvndrid  
								   ";
								//echo $sqryvndrpo_mst;
	$srsvndrpo_mst	  = mysqli_query($conn,$sqryvndrpo_mst);
	$cntcst_inc	  = mysqli_num_rows($srsvndrpo_mst);		  
	$dispstr		  	  = "";		

$rowsvndr_mst = mysqli_fetch_array($srsvndrpo_mst);
$qtnid   =     $rowsvndr_mst['qtnm_id'];
$vndrmid      =     $rowsvndr_mst['vndrm_id'];  

$vndrpomid =     $rowsvndr_mst['cstpom_id'];						
$vndrpom_typ =     $rowsvndr_mst['cstpom_typ'];

$vndrpom_pocde =     $rowsvndr_mst['cstpom_cde'];





$dprtmnt   =     $rowsvndr_mst['dprtmntm_name'];
$role      =     $rowsvndr_mst['rlsm_role'];
$emp       =     $rowsvndr_mst['empm_name'];
$typrjct =     $rowsvndr_mst['typrjctm_nm'];
$cstmr =     $rowsvndr_mst['cstmrm_name'];
$dprtmntid   =     $rowsvndr_mst['dprtmntm_id'];
$roleid      =     $rowsvndr_mst['rlsm_id'];
$empid       =     $rowsvndr_mst['empm_id'];
$typrjctid =     $rowsvndr_mst['typrjctm_id'];
$cstmrid =     $rowsvndr_mst['cstmrm_id'];

$vndrnm =     $rowsvndr_mst['vndrm_name'];
$vndrid =     $rowsvndr_mst['vndrm_id'];

$vndrpom_plndt =     $rowsvndr_mst['intshp_rqstm_rfqdt'];

$typsrvsm_name =     $rowsvndr_mst['typsrvsm_name'];

$typsrvsm_id =     $rowsvndr_mst['typsrvsm_id'];




$vres = $dprtmnt."|".$role."|".$emp."|".$typrjct."|".$cstmr."|".$dprtmntid."|".$roleid."|".$empid."|".$typrjctid."|".$cstmrid."|".$vndrpomid."|".$vndrpom_typ
."|".$vndrid."|".$vndrnm."|".$vndrpom_plndt."|".$vndrpom_pocde."|".$typsrvsm_id."|".$typsrvsm_name;
echo $vres;
}

















/*Get Purchase Details */
if(isset($_REQUEST['prfqid']) && (trim($_REQUEST['prfqid']) != "")&&
isset($_REQUEST['prcvalid']) && (trim($_REQUEST['prcvalid']) != "")){
	// creating Drop Down for County
	$result = "";		
	$prfqid = glb_func_chkvl($_REQUEST['prfqid']);
	$prcvalid = glb_func_chkvl($_REQUEST['prcvalid']);




								$sqryprchspo_mst = "select 

								qtnm_name,qtnm_id,
							
								typrjctm_id,typrjctm_nm,
							
								prchs_qtnrplym_id,prchs_qtnrplym_prc,vndrm_id,vndrm_name,
							
								cstmrm_id,cstmrm_name,adm_prchsrplym_id,adm_prchsrplym_prc,adm_prchsrplym_sts,
							
								qtnm_code,prchs_qtnrplym_rfqnm,prchs_qtnrplym_refid,
								acsvndrm_sts,acsvndrm_id,prchs_qtnrplym_rfqdt,								 
								dprtmntm_id,dprtmntm_name,rlsm_id,rlsm_role,empm_id,empm_name
			 
							from 
							prchs_qtnrply_mst
								LEFT join typrjct_mst on typrjct_mst.typrjctm_id = prchs_qtnrply_mst.prchs_qtnrplym_typrjctm_id
								LEFT join qtn_mst on qtn_mst.qtnm_id = prchs_qtnrply_mst.prchs_qtnrplym_qtnm_id
								LEFT join dprtmnt_mst on dprtmnt_mst.dprtmntm_id = qtn_mst.qtnm_dprtmntm_id
								LEFT join rls_mst on rls_mst.rlsm_id = qtn_mst.qtnm_rlsm_id

								LEFT join emp_mst on emp_mst.empm_id = qtn_mst.qtnm_empm_id
								LEFT join empdept_dtl on empdept_dtl.empdeptd_empm_id = emp_mst.empm_id
								LEFT join vndr_mst on vndr_mst.vndrm_id = prchs_qtnrply_mst.prchs_qtnrplym_vndrm_id
								left join cstmr_mst on cstmr_mst.cstmrm_id = qtn_mst.qtnm_cstmrm_id
								LEFT join  cstpo_mst on  cstpo_mst.cstpom_qtnm_id = qtn_mst.qtnm_id 
								LEFT join cstmrposts_mst on cstmrposts_mst.cstmrpostsm_id = cstpo_mst.cstpom_cstmrpostsm_id
								left join acsvndr_mst on acsvndr_mst.acsvndr_qtnrplym_id = prchs_qtnrply_mst.prchs_qtnrplym_id
							   left join adm_prchsrply_mst on adm_prchsrply_mst.adm_prchsrplym_qtnrplym_id = prchs_qtnrply_mst.prchs_qtnrplym_id
			 
								  where
			 
								  prchs_qtnrplym_id !='' 
												and 
			 
								  prchs_qtnrplym_qtnm_id ='$prfqid'
								   and
								   prchs_qtnrplym_vndrm_id = $prcvalid  
								   ";
								
								

					//	echo 	$sqryprchspo_mst;exit;
	$srsprchspo_mst	  = mysqli_query($conn,$sqryprchspo_mst);
	$cntcst_inc	  = mysqli_num_rows($srsprchspo_mst);		  
	$dispstr		  	  = "";		

?>

<?php
$rowsprchs_mst = mysqli_fetch_array($srsprchspo_mst);
$qtnid   =     $rowsprchs_mst['qtnm_id'];
$vndrmid      =     $rowsprchs_mst['vndrm_id'];  
$sqrypo_mst="select 
prchspom_id,prchspom_rfqdt,prchspom_typ,
prchspom_vndrm_id,prchspom_qtnm_id,prchspom_prc,prchspom_prtlprc,prchspom_fle,prchspom_pocde,prchspostsm_nm 
from 
prchspo_mst
inner join prchsposts_mst on prchsposts_mst.prchspostsm_id = prchspo_mst.prchspom_prchspostsm_id
where
prchspom_qtnm_id = $qtnid
and 
prchspom_vndrm_id = $vndrmid
order by prchspom_id desc
";
//echo $sqrypo_mst;
$respo_mst = mysqli_query($conn,$sqrypo_mst);	
$srowpo_mst=mysqli_fetch_assoc($respo_mst);	
$vndrpomid =     $srowpo_mst['prchspom_id'];						
$cstmrpotyp =     $srowpo_mst['prchspom_typ'];

$prchs_qtnrplym_id =     $rowsprchs_mst['prchs_qtnrplym_id'];





$dprtmnt   =     $rowsprchs_mst['dprtmntm_name'];
$role      =     $rowsprchs_mst['rlsm_role'];
$emp       =     $rowsprchs_mst['empm_name'];
$typrjct =     $rowsprchs_mst['typrjctm_nm'];
$cstmr =     $rowsprchs_mst['cstmrm_name'];
$dprtmntid   =     $rowsprchs_mst['dprtmntm_id'];
$roleid      =     $rowsprchs_mst['rlsm_id'];
$empid       =     $rowsprchs_mst['empm_id'];
$typrjctid =     $rowsprchs_mst['typrjctm_id'];
$cstmrid =     $rowsprchs_mst['cstmrm_id'];
$vndrnm =     $rowsprchs_mst['vndrm_name'];
$vndrid =     $rowsprchs_mst['vndrm_id'];

$vres = $dprtmnt."-".$role."-".$emp."-".$typrjct."-".$cstmr."-".$dprtmntid."-".$roleid."-".$empid."-".$typrjctid."-".$cstmrid."-".$vndrpomid."-".$cstmrpotyp."-".$vndrid."-".$vndrnm."-".$prchs_qtnrplym_id;
echo $vres;
}




/*Get Purchase Shipping Details */
if(isset($_REQUEST['shpprcrfqid']) && (trim($_REQUEST['shpprcrfqid']) != "")&&
isset($_REQUEST['shpprcvalid']) && (trim($_REQUEST['shpprcvalid']) != "")){
	// creating Drop Down for County
	$result = "";		
	$shpvrfqid = glb_func_chkvl($_REQUEST['shpprcrfqid']);
	$shpvndrid = glb_func_chkvl($_REQUEST['shpprcvalid']);





							/*	$sqryvndrpo_mst = "select 

				   qtnm_name,qtnm_id,

				   typrjctm_id,typrjctm_nm,

				   vndr_qtnrplym_id,vndr_qtnrplym_prc,vndrm_id,vndrm_name,

				   cstmrm_id,cstmrm_name,adm_qtnrplym_id,adm_qtnrplym_prc,adm_qtnrplym_sts,

				   qtnm_code,vndr_qtnrplym_rfqnm,vndr_qtstsm_name,vndr_qtnrplym_refid,vndr_qtstsm_id,
				   acsvndrm_sts,acsvndrm_id,vndr_qtnrplym_rfqdt,
				   dprtmntm_id,dprtmntm_name,rlsm_id,rlsm_role,empm_id,empm_name
  			   from 
				   vndr_qtnrply_mst
				   inner join typrjct_mst on typrjct_mst.typrjctm_id = vndr_qtnrply_mst.vndr_qtnrplym_typrjctm_id
				   inner join qtn_mst on qtn_mst.qtnm_id = vndr_qtnrply_mst.vndr_qtnrplym_qtnm_id
				   inner join dprtmnt_mst on dprtmnt_mst.dprtmntm_id = qtn_mst.qtnm_dprtmntm_id
				   inner join rls_mst on rls_mst.rlsm_id = qtn_mst.qtnm_rlsm_id
				   inner join emp_mst on emp_mst.empm_id = qtn_mst.qtnm_empm_id
				   inner join empdept_dtl on empdept_dtl.empdeptd_empm_id = emp_mst.empm_id
				   inner join vndr_mst on vndr_mst.vndrm_id = vndr_qtnrply_mst.vndr_qtnrplym_vndrm_id
				   inner join cstmr_mst on cstmr_mst.cstmrm_id = qtn_mst.qtnm_cstmrm_id
				   inner join  cstpo_mst on  cstpo_mst.cstpom_qtnm_id = qtn_mst.qtnm_id 
				   inner join cstmrposts_mst on cstmrposts_mst.cstmrpostsm_id = cstpo_mst.cstpom_cstmrpostsm_id
				   left join acsvndr_mst on acsvndr_mst.acsvndr_qtnrplym_id = vndr_qtnrply_mst.vndr_qtnrplym_id
				  left join adm_qtnrply_mst on adm_qtnrply_mst.adm_vndr_qtnrplym_id = vndr_qtnrply_mst.vndr_qtnrplym_id
				  inner join vndr_qtsts_mst on vndr_qtsts_mst.vndr_qtstsm_id = vndr_qtnrply_mst.vndr_qtnrplym_stsid"; */

				  $sqryvndrpo_mst = "
				  select 

				  qtnm_name,qtnm_id,
			  
				  typrjctm_id,typrjctm_nm,
			  
				  prchspom_id,vndrm_id,vndrm_name,prchspom_typ,prchspom_plndt,
			  
				  cstmrm_id,cstmrm_name,qtnm_code,dprtmntm_id,dprtmntm_name,rlsm_id,rlsm_role,empm_id,empm_name,prchspom_pocde
				  
			  from 
					 prchspo_mst
				  inner join typrjct_mst on typrjct_mst.typrjctm_id = prchspo_mst.prchspom_typrjctm_id
				  inner join qtn_mst on qtn_mst.qtnm_id = prchspo_mst.prchspom_qtnm_id
				  left join vndr_mst on vndr_mst.vndrm_id = prchspo_mst.prchspom_vndrm_id
				  inner join cstmr_mst on cstmr_mst.cstmrm_id = prchspo_mst.prchspom_cstmrm_id
				  left join dprtmnt_mst on dprtmnt_mst.dprtmntm_id = qtn_mst.qtnm_dprtmntm_id
				  inner join rls_mst on rls_mst.rlsm_id = qtn_mst.qtnm_rlsm_id
				  inner join emp_mst on emp_mst.empm_id = qtn_mst.qtnm_empm_id
				  inner join empdept_dtl on empdept_dtl.empdeptd_empm_id = emp_mst.empm_id
			   



					 where
					 prchspom_id !='' 
								   and
								   prchspom_qtnm_id ='$shpvrfqid'
								   and
								   prchspom_vndrm_id = $shpvndrid  
								   ";
								
	$srsvndrpo_mst	  = mysqli_query($conn,$sqryvndrpo_mst);
	$cntcst_inc	  = mysqli_num_rows($srsvndrpo_mst);		  
	$dispstr		  	  = "";		

$rowsvndr_mst = mysqli_fetch_array($srsvndrpo_mst);
$qtnid   =     $rowsvndr_mst['qtnm_id'];
$vndrmid      =     $rowsvndr_mst['vndrm_id'];  
/*
$sqrypo_mst="select 
vndrpom_id,vndrpom_rfqdt,vndrpom_typ,
vndrpom_vndrm_id,vndrpom_qtnm_id,vndrpom_prc,vndrpom_prtlprc,vndrpom_fle,vndrpom_pocde,vndrpostsm_nm 
from 
vndrpo_mst
inner join vndrposts_mst on vndrposts_mst.vndrpostsm_id = vndrpo_mst.vndrpom_vndrpostsm_id
where
vndrpom_qtnm_id = $qtnid
and 
vndrpom_vndrm_id = $vndrmid
order by vndrpom_id desc
";
$respo_mst = mysqli_query($conn,$sqrypo_mst);	
$srowpo_mst=mysqli_fetch_assoc($respo_mst);	*/
$vndrpomid =     $rowsvndr_mst['prchspom_id'];						
$vndrpom_typ =     $rowsvndr_mst['prchspom_typ'];

$vndrpom_pocde =     $rowsvndr_mst['prchspom_pocde'];





$dprtmnt   =     $rowsvndr_mst['dprtmntm_name'];
$role      =     $rowsvndr_mst['rlsm_role'];
$emp       =     $rowsvndr_mst['empm_name'];
$typrjct =     $rowsvndr_mst['typrjctm_nm'];
$cstmr =     $rowsvndr_mst['cstmrm_name'];
$dprtmntid   =     $rowsvndr_mst['dprtmntm_id'];
$roleid      =     $rowsvndr_mst['rlsm_id'];
$empid       =     $rowsvndr_mst['empm_id'];
$typrjctid =     $rowsvndr_mst['typrjctm_id'];
$cstmrid =     $rowsvndr_mst['cstmrm_id'];

$vndrnm =     $rowsvndr_mst['vndrm_name'];
$vndrid =     $rowsvndr_mst['vndrm_id'];

$vndrpom_plndt =     $rowsvndr_mst['prchspom_plndt'];




$vres = $dprtmnt."|".$role."|".$emp."|".$typrjct."|".$cstmr."|".$dprtmntid."|".$roleid."|".$empid."|".$typrjctid."|".$cstmrid."|".$vndrpomid."|".$vndrpom_typ."|".$vndrid."|".$vndrnm."|".$vndrpom_plndt."|".$vndrpom_pocde;
echo $vres;
}



	
/*Get PO Details */
if(isset($_REQUEST['poqtnid']) && (trim($_REQUEST['poqtnid']) != "")){
	error_reporting(0);
	// creating Drop Down for County
	$result = "";		
	$poqtnid = glb_func_chkvl($_REQUEST['poqtnid']);
	$cstpom_cde = glb_func_chkvl($_REQUEST['cstpom_cde']);

	$sqrycstpo_mst = "select 
	                       cstpom_id,cstpom_cde,qtnm_id,cstpom_prc,cstpom_prtlprc,cstpom_typ 
							from 
							cstpo_mst
								inner join qtn_mst on qtn_mst.qtnm_id = cstpo_mst.cstpom_qtnm_id
							where
							cstpom_qtnm_id ='$poqtnid'
							and cstpom_cde = '$cstpom_cde' and
							cstpom_typ = 2
							order by
							cstpom_id desc
							";						
								// echo 	$sqrycst_mst; exit;
	$srscstpo_mst	  = mysqli_query($conn,$sqrycstpo_mst);
	$cntcstpo_inc	  = mysqli_num_rows($srscstpo_mst);		  
	$dispstr		  	  = "";		

?>

<?php
$rowscrtmstrpo_mst = mysqli_fetch_array($srscstpo_mst);
$cstpom_id   =     $rowscrtmstrpo_mst['cstpom_id'];
$cstpom_cde   =     $rowscrtmstrpo_mst['cstpom_cde'];
$cstpom_prc      =     $rowscrtmstrpo_mst['cstpom_prc'];
$cstpo_prtlprc       =     $rowscrtmstrpo_mst['cstpom_prtlprc'];

$cstpo_rmnprc       =     ($cstpom_prc-$cstpo_prtlprc);


$cstpom_typ =     $rowscrtmstrpo_mst['cstpom_typ'];

if($cstpom_typ ==2){
$optnval = "<option value='2'> Partial PO</option>";
}



$res = $cstpom_id."|".$cstpom_prc."|".$cstpo_rmnprc."|".$cstpom_typ."|".$optnval."|".$cstpom_cde;
echo $res;
}


/*Get Vendor PO Details */
if(isset($_REQUEST['vpoqtnid']) && (trim($_REQUEST['vpoqtnid']) != "")){
	// creating Drop Down for County
	$result = "";		
	$poqtnid = glb_func_chkvl($_REQUEST['poid']);

	$vndrpoid =  glb_func_chkvl($_REQUEST['vpoqtnid']);

	$sqrycstpo_mst = "select 
	                       vndrpom_id,qtnm_id,vndrpom_prc,vndrpom_prtlprc,vndrpom_typ 
							from 
							vndrpo_mst
								inner join qtn_mst on qtn_mst.qtnm_id = vndrpo_mst.vndrpom_qtnm_id
							where
							vndrpom_qtnm_id ='$vndrpoid'
							and
							vndrpom_id ='$poqtnid'
							and
							vndrpom_typ = 2
							order by
							vndrpom_id desc
							";						
							echo 	$sqrycstpo_mst;//exit;
	$srscstpo_mst	  = mysqli_query($conn,$sqrycstpo_mst);
	$cntcstpo_inc	  = mysqli_num_rows($srscstpo_mst);		  
	$dispstr		  	  = "";		

?>

<?php
$rowscrtmstrpo_mst = mysqli_fetch_array($srscstpo_mst);
$cstpom_id   =     $rowscrtmstrpo_mst['vndrpom_id'];
$cstpom_prc      =     $rowscrtmstrpo_mst['vndrpom_prc'];
$cstpo_prtlprc       =     $rowscrtmstrpo_mst['vndrpom_prtlprc'];

$cstpo_rmnprc       =     ($cstpom_prc-$cstpo_prtlprc);


$cstpom_typ =     $rowscrtmstrpo_mst['vndrpom_typ'];

if($cstpom_typ ==2){
$optnval = "<option value='2'> Partial PO</option>";
}



$res = $cstpom_id."-".$cstpom_prc."-".$cstpo_rmnprc."-".$cstpom_typ."-".$optnval;
echo $res;
}


/*Get Purchase PO Details */
if(isset($_REQUEST['prchspoqtnid']) && (trim($_REQUEST['prchspoqtnid']) != "")){
	// creating Drop Down for County
	$result = "";		
	$poqtnid = glb_func_chkvl($_REQUEST['prchspoqtnid']);
	$prchspoid = glb_func_chkvl($_REQUEST['prchspoid']);

	$sqrycstpo_mst = "select 
	                       prchspom_id,qtnm_id,prchspom_prc,prchspom_prtlprc,prchspom_typ 
							from 
							prchspo_mst
								inner join qtn_mst on qtn_mst.qtnm_id = prchspo_mst.prchspom_qtnm_id
							where
							prchspom_qtnm_id ='$poqtnid'
							and
							prchspom_id ='$prchspoid'
                            and
							prchspom_typ = 2
							order by
							prchspom_id desc
							";						
							//echo 	$sqrycstpo_mst;exit;
	$srscstpo_mst	  = mysqli_query($conn,$sqrycstpo_mst);
	$cntcstpo_inc	  = mysqli_num_rows($srscstpo_mst);		  
	$dispstr		  	  = "";		

?>

<?php
$rowscrtmstrpo_mst = mysqli_fetch_array($srscstpo_mst);
$cstpom_id   =     $rowscrtmstrpo_mst['prchspom_id'];
$cstpom_prc      =     $rowscrtmstrpo_mst['prchspom_prc'];
$cstpo_prtlprc       =     $rowscrtmstrpo_mst['prchspom_prtlprc'];

$cstpo_rmnprc       =     ($cstpom_prc-$cstpo_prtlprc);


$cstpom_typ =     $rowscrtmstrpo_mst['prchspom_typ'];

if($cstpom_typ ==2){
$optnval = "<option value='2'> Partial PO</option>";
}



$res = $cstpom_id."-".$cstpom_prc."-".$cstpo_rmnprc."-".$cstpom_typ."-".$optnval;
echo $res;
}
















/*Get Blanket PO Details */
if(isset($_REQUEST['cstblnkt']) && (trim($_REQUEST['cstblnkt']) != "")){
	// creating Drop Down for County
	$result = "";		
	$cstmrid = glb_func_chkvl($_REQUEST['cstblnkt']);

	$sqrycstpo_mst = "select 
	                       cstpom_id,cstpom_blnktprc,cstpom_prc
							from 
							cstpo_mst
							where
							cstpom_cstmrm_id  ='$cstmrid'
							order by
							cstpom_id desc
							";						
						//		echo 	$sqrycstpo_mst;
	$srscstpo_mst	  = mysqli_query($conn,$sqrycstpo_mst);
	$cntcstpo_inc	  = mysqli_num_rows($srscstpo_mst);		  
	$dispstr		  	  = "";		

?>

<?php
$rowscrtmstrpo_mst = mysqli_fetch_array($srscstpo_mst);
$cstpom_id   =     $rowscrtmstrpo_mst['cstpom_id'];
$cstpom_prc      =     $rowscrtmstrpo_mst['cstpom_prc'];
$cstpom_blnktprc       =     $rowscrtmstrpo_mst['cstpom_blnktprc'];

$cstpo_rmnprc       =     ($cstpom_blnktprc - $cstpom_prc);


$cstpom_typ =     $rowscrtmstrpo_mst['cstpom_typ'];

//if($cstpom_typ ==3 ){}

$optnval = "<option value='3'> Blanket PO</option>";


//echo $cstpo_rmnprc; 
$res = $cstpom_id."|".$cstpom_prc."|".$cstpo_rmnprc."|"."3"."|".$optnval;
echo $res;
}

/*Get Vendor Blanket PO Details */
if(isset($_REQUEST['vndrcstblnkt']) && (trim($_REQUEST['vndrcstblnkt']) != "")){
	// creating Drop Down for County
	$result = "";		
	$cstmrid = glb_func_chkvl($_REQUEST['vndrcstblnkt']);
	$vndrmid = glb_func_chkvl($_REQUEST['vndrmid']);

	$sqrycstpo_mst = "select 
	                       vndrpom_id,vndrpom_blnktprc,vndrpom_prc
							from 
							vndrpo_mst
							where
							vndrpom_cstmrm_id  ='$cstmrid'
							and
							vndrpom_vndrm_id  ='$vndrmid'
							order by
							vndrpom_id desc
							";						
						//		echo 	$sqrycstpo_mst;
	$srscstpo_mst	  = mysqli_query($conn,$sqrycstpo_mst);
	$cntcstpo_inc	  = mysqli_num_rows($srscstpo_mst);		  
	$dispstr		  	  = "";		

?>

<?php
$rowscrtmstrpo_mst = mysqli_fetch_array($srscstpo_mst);
$cstpom_id   =     $rowscrtmstrpo_mst['vndrpom_id'];
$cstpom_prc      =     $rowscrtmstrpo_mst['vndrpom_prc'];
$cstpom_blnktprc       =     $rowscrtmstrpo_mst['vndrpom_blnktprc'];

$cstpo_rmnprc       =     ($cstpom_blnktprc - $cstpom_prc);


$cstpom_typ =     $rowscrtmstrpo_mst['vndrpom_typ'];

//if($cstpom_typ ==3 ){}

$optnval = "<option value='3'> Blanket PO</option>";


//echo $cstpo_rmnprc; 
$res = $cstpom_id."|".$cstpom_prc."|".$cstpo_rmnprc."|"."3"."|".$optnval;
echo $res;
}





/*Get Project Details */
if(isset($_REQUEST['prjrfqid']) && (trim($_REQUEST['prjrfqid']) != ""))
{
	// creating Drop Down for County
	$result = "";		
	$prjrfqid = glb_func_chkvl($_REQUEST['prjrfqid']);
	/*		$sqrycst_mst = "select 
qtnm_name,qtnm_id,qtnm_empm_id,qtnm_typrjctm_id,qtnm_cstmrm_id,
									qtnm_rfqdt,empm_id,empm_name,
typrjctm_id,typrjctm_nm,cstmrm_id,cstmrm_name,qtnm_desc_one,qtnm_desc_two,qtnm_fle,qtnm_rfqdt,prjctm_id,
	prjctm_qtnm_id,prjctm_nm,prjctm_typrjctm_id,prjctm_cstmrm_id,qtnm_code	
								from 
									prjct_mst
						inner join qtn_mst on qtn_mst.qtnm_id = prjct_mst.prjctm_qtnm_id
						inner join emp_mst on emp_mst.empm_id = prjct_mst.prjctm_lead
						inner join typrjct_mst on typrjct_mst.typrjctm_id = prjct_mst.prjctm_typrjctm_id
						inner join cstmr_mst on cstmr_mst.cstmrm_id = prjct_mst.prjctm_cstmrm_id
								where
									prjctm_qtnm_id ='$prjrfqid'";	*/	
									
					$sqrycst_mst = "select 
									qtnm_name,qtnm_id,qtnm_dprtmntm_id,qtnm_rlsm_id,qtnm_empm_id,qtnm_typrjctm_id,qtnm_cstmrm_id,
									qtnm_rfqdt,dprtmntm_id,dprtmntm_name,rlsm_id,rlsm_role,empm_id,empm_name,
									typrjctm_id,typrjctm_nm,cstmrm_id,cstmrm_name,qtnm_desc_one,qtnm_desc_two,qtnm_fle,qtnm_rfqdt,
							  qtnm_stsm_id,qtnm_sts,qtnm_prty,qtnm_crtdon,qtnm_crtdby,cstpom_id,cstpom_typ,prjctm_id,prjctm_nm
								from 
									qtn_mst
                                     INNER JOIN prjct_mst ON prjct_mst.prjctm_qtnm_id = qtn_mst.qtnm_id

									inner join dprtmnt_mst on dprtmnt_mst.dprtmntm_id = qtn_mst.qtnm_dprtmntm_id
									inner join rls_mst on rls_mst.rlsm_id = qtn_mst.qtnm_rlsm_id
									inner join emp_mst on emp_mst.empm_id = qtn_mst.qtnm_empm_id
									inner join empdept_dtl on empdept_dtl.empdeptd_empm_id = emp_mst.empm_id
									inner join typrjct_mst on typrjct_mst.typrjctm_id = qtn_mst.qtnm_typrjctm_id
									inner join cstmr_mst on cstmr_mst.cstmrm_id = qtn_mst.qtnm_cstmrm_id
									left join cstpo_mst on cstpo_mst.cstpom_qtnm_id = qtn_mst.qtnm_id
								where
									prjctm_id ='$prjrfqid'";	
									// echo $sqrycst_mst;

		$srscst_mstt	  = mysqli_query($conn,$sqrycst_mst);
		$cntcst_inc	  = mysqli_num_rows($srscst_mstt);		  
		$dispstr		  	  = "";		
   $rowscrtmstr_mst = mysqli_fetch_array($srscst_mstt);
    $emp       =     $rowscrtmstr_mst['empm_name'];
    $typrjct =     $rowscrtmstr_mst['typrjctm_nm'];
    $cstmr =     $rowscrtmstr_mst['cstmrm_name'];
    $empid       =     $rowscrtmstr_mst['empm_id'];
    $typrjctid =     $rowscrtmstr_mst['typrjctm_id'];
    $cstmrid =     $rowscrtmstr_mst['cstmrm_id'];
    $prjctm_id =     $rowscrtmstr_mst['prjctm_id'];
    $prjctm_nm =     $rowscrtmstr_mst['prjctm_nm'];
    $qtnm_id =     $rowscrtmstr_mst['qtnm_id'];
    $qtnm_name =     $rowscrtmstr_mst['qtnm_code'];
	
	


 $res = $emp."<->".$typrjct."<->".$cstmr."<->".$empid."<->".$typrjctid."<->".$cstmrid."<->".$prjctm_id."<->".$prjctm_nm."<->".$qtnm_id."<->".$qtnm_name;
echo $res;
	}	
	
	
/*Get Project Purchase Details */
if(isset($_REQUEST['prjprchsid']) && (trim($_REQUEST['prjprchsid']) != "")){
	// creating Drop Down for County
	$result = "";		
	$prjrfqid = glb_func_chkvl($_REQUEST['prjprchsid']);
	
	
	$rqstid =  glb_func_chkvl($_REQUEST['prchid']);

//echo $rqstid;exit;
	/*$sqrycst_mst = "select 
qtnm_name,qtnm_id,qtnm_empm_id,qtnm_typrjctm_id,qtnm_cstmrm_id,
								qtnm_rfqdt,empm_id,empm_name,
        typrjctm_id,typrjctm_nm,cstmrm_id,cstmrm_name,qtnm_desc_one,qtnm_desc_two,qtnm_fle,qtnm_rfqdt,prjctm_id,
	prjctm_qtnm_id,prjctm_nm,prjctm_typrjctm_id,prjctm_cstmrm_id,qtnm_code,prchs_rqstm_id	
							from 
								prjct_mst
					inner join qtn_mst on qtn_mst.qtnm_id = prjct_mst.prjctm_qtnm_id
					inner join emp_mst on emp_mst.empm_id = prjct_mst.prjctm_lead
					inner join typrjct_mst on typrjct_mst.typrjctm_id = prjct_mst.prjctm_typrjctm_id
					inner join cstmr_mst on cstmr_mst.cstmrm_id = prjct_mst.prjctm_cstmrm_id
					left join prchs_rqst_mst  on prchs_rqst_mst.prchs_rqstm_qtnm_id = prjct_mst.prjctm_qtnm_id

					where
								prjctm_qtnm_id ='$prjrfqid'";	*/
							
							/*	$sqrycst_mst = "select 
								qtnm_name,qtnm_id,qtnm_dprtmntm_id,qtnm_rlsm_id,qtnm_empm_id,qtnm_typrjctm_id,qtnm_cstmrm_id,
								qtnm_rfqdt,empm_id,empm_name,
								typrjctm_id,typrjctm_nm,cstmrm_id,cstmrm_name,qtnm_desc_one,qtnm_desc_two,qtnm_fle,qtnm_rfqdt,
						  qtnm_stsm_id,qtnm_sts,qtnm_prty,qtnm_crtdon,qtnm_crtdby,prchs_rqstm_id,prchs_rqstm_sts,prchs_rqstm_rqstcode
							from 
								qtn_mst
								inner join emp_mst on emp_mst.empm_id = qtn_mst.qtnm_empm_id
								inner join typrjct_mst on typrjct_mst.typrjctm_id = qtn_mst.qtnm_typrjctm_id
								inner join cstmr_mst on cstmr_mst.cstmrm_id = qtn_mst.qtnm_cstmrm_id
				            left join prchs_rqst_mst  on prchs_rqst_mst.prchs_rqstm_qtnm_id = qtn_mst.qtnm_id
							where
								qtnm_id ='$prjrfqid'
								and 
                                prchs_rqstm_sts = 'a'
                                and 
                                prchs_rqstm_id = '$rqstid' 

								";		*/
								
								
								$sqrycst_mst = "select 
								qtnm_name,qtnm_id,qtnm_dprtmntm_id,qtnm_rlsm_id,qtnm_empm_id,qtnm_typrjctm_id,qtnm_cstmrm_id,
								qtnm_rfqdt,empm_id,empm_name,
								typrjctm_id,typrjctm_nm,cstmrm_id,cstmrm_name,qtnm_desc_one,qtnm_desc_two,qtnm_fle,qtnm_rfqdt,
						  qtnm_stsm_id,qtnm_sts,qtnm_prty,qtnm_crtdon,qtnm_crtdby,prchs_rqstm_id,prchs_rqstm_sts,prchs_rqstm_rqstcode,
						  prjctm_id
							from 
								prchs_rqst_mst
								inner join emp_mst on emp_mst.empm_id = prchs_rqst_mst.prchs_rqstm_empm_id
								inner join typrjct_mst on typrjct_mst.typrjctm_id = prchs_rqst_mst.prchs_rqstm_typrjctm_id
								inner join prjct_mst on prjct_mst.prjctm_id = prchs_rqst_mst.prchs_rqstm_prjctm_id

								inner join cstmr_mst on cstmr_mst.cstmrm_id = prchs_rqst_mst.prchs_rqstm_cstmrm_id
                                LEFT JOIN qtn_mst ON qtn_mst.qtnm_id = prchs_rqst_mst.prchs_rqstm_qtnm_id
							where
								prchs_rqstm_prjctm_id ='$prjrfqid'
								and 
                                prchs_rqstm_sts = 'a'
                                and 
                                prchs_rqstm_id = '$rqstid' 

								";


						//	echo $sqrycst_mst; 						
	$srscst_mstt	  = mysqli_query($conn,$sqrycst_mst);
	$cntcst_inc	  = mysqli_num_rows($srscst_mstt);		  
	$dispstr		  	  = "";		
$rowscrtmstr_mst = mysqli_fetch_array($srscst_mstt);
$emp       =     $rowscrtmstr_mst['empm_name'];
$typrjct =     $rowscrtmstr_mst['typrjctm_nm'];
$cstmr =     $rowscrtmstr_mst['cstmrm_name'];
$empid       =     $rowscrtmstr_mst['empm_id'];
$typrjctid =     $rowscrtmstr_mst['typrjctm_id'];
$cstmrid =     $rowscrtmstr_mst['cstmrm_id'];
$prjctm_id =     $rowscrtmstr_mst['prjctm_id'];
$prjctm_nm =     $rowscrtmstr_mst['prjctm_nm'];
$qtnm_id =     $rowscrtmstr_mst['prjctm_id'];
$qtnm_name =     $rowscrtmstr_mst['qtnm_code'];
$prchs_rqstm_rqstcode =     $rowscrtmstr_mst['prchs_rqstm_rqstcode'];




$prchs_rqstm_sts =     $rowscrtmstr_mst['prchs_rqstm_sts'];
if($prchs_rqstm_sts == 'a'){

$vndr_qtnm_id =     $rowscrtmstr_mst['prchs_rqstm_id'];
}



$res = $emp."<->".$typrjct."<->".$cstmr."<->".$empid."<->".$typrjctid."<->".$cstmrid."<->".$prjctm_id."<->".$prjctm_nm."<->".$qtnm_id."<->".$qtnm_name."<->".$vndr_qtnm_id."<->".$prchs_rqstm_rqstcode;
echo $res;
}	


	

/*Get Project Purchase Vendor Details */
if(isset($_REQUEST['prchsrqstidval']) && (trim($_REQUEST['prchsrqstidval']) != "")){
	// creating Drop Down for County
	$result = "";		
	$prchsrqstid = glb_func_chkvl($_REQUEST['prchsrqstidval']);
	$reslt = "<table>";
$vndrary = array();
/**/	$sqryvndr_mst = "select 
	prchs_rqstm_id,prchs_rqstm_qtnm_id,prchs_rqstm_dprtmntm_id,vndrm_id,
	                      vndrm_name,prchs_rqstm_desc_one
							from 
							prchs_rqst_mst 
					inner join prchs_rqst_dtl on prchs_rqst_dtl.prchs_rqstd_prchs_rqstm_id 
					= prchs_rqst_mst.prchs_rqstm_id
					inner join vndr_mst on vndr_mst.vndrm_id =prchs_rqst_dtl.prchs_rqstd_vndrm_id
					where
					prchs_rqstm_id ='$prchsrqstid'"
					
					/*$sqryvndr_mst = 	"select 
							   		vndrm_id,vndrm_name
							  from 
									vndr_mst

				      			inner join prchs_qtn_dtl on prchs_qtn_dtl.prchs_qtnd_vndrm_id = vndr_mst.vndrm_id
								inner join prchs_qtn_mst on prchs_qtn_mst.prchs_qtnm_id = prchs_qtn_dtl.prchs_qtnd_prchs_qtnm_id
							 where 
                        	 prchs_qtnd_prchs_qtnm_id ='$prchsrqstid' 
							group by vndrm_id  order by 

								 vndrm_id"*/
					
					
					;	
				//	echo 	$sqryvndr_mst;					
	$srsvndr_mst	  = mysqli_query($conn,$sqryvndr_mst);
	$cntcst_inc	  = mysqli_num_rows($srsvndr_mst);		  
	$dispstr		  	  = "";		
while($rowscrtmstr_mst = mysqli_fetch_array($srsvndr_mst)){
$vndrm_id       =     $rowscrtmstr_mst['vndrm_id'];
$vndrm_name =     $rowscrtmstr_mst['vndrm_name'];
$vndrary[] = $vndrm_id; 
$reslt .= "<tr><td>

<input type=\"checkbox\" name=\"chkvndr$vndrm_id\" value=\"$vndrm_id\"
onclick= \"chkprchsvndrs('$vndrm_id')\" checked></td><td>$vndrm_name</td></tr>"; 


}
 $desc =     $rowscrtmstr_mst['prchs_rqstm_desc_one'];


$vndrval = implode(',',$vndrary);
$reslt .="</table>"."<->".$vndrval."<->".$desc; 

echo $reslt;
}	


if(isset($_REQUEST['prchsrqstid']) && (trim($_REQUEST['prchsrqstid']) != "")){
	// creating Drop Down for County
	$result = "";		
	$prchsrqstid = glb_func_chkvl($_REQUEST['prchsrqstid']);
	$reslt = "<table>";
$vndrary = array();
/*	$sqryvndr_mst = "select 
	prchs_rqstm_id,prchs_rqstm_qtnm_id,prchs_rqstm_dprtmntm_id,vndrm_id,
	                      vndrm_name
							from 
							prchs_rqst_mst 
					inner join prchs_rqst_dtl on prchs_rqst_dtl.prchs_rqstd_prchs_rqstm_id 
					= prchs_rqst_mst.prchs_rqstm_id
					inner join vndr_mst on vndr_mst.vndrm_id =prchs_rqst_dtl.prchs_rqstd_vndrm_id
					where
					prchs_rqstm_id ='$prchsrqstid'"*/
					
					$sqryvndr_mst = 	"select 
							   		vndrm_id,vndrm_name
							  from 
									vndr_mst

				      			inner join prchs_qtn_dtl on prchs_qtn_dtl.prchs_qtnd_vndrm_id = vndr_mst.vndrm_id
								inner join prchs_qtn_mst on prchs_qtn_mst.prchs_qtnm_id = prchs_qtn_dtl.prchs_qtnd_prchs_qtnm_id
							 where 
                        	 prchs_qtnd_prchs_qtnm_id ='$prchsrqstid' 
							group by vndrm_id  order by 

								 vndrm_id"/**/
					
					
					;	
				//	echo 	$sqryvndr_mst;					
	$srsvndr_mst	  = mysqli_query($conn,$sqryvndr_mst);
	$cntcst_inc	  = mysqli_num_rows($srsvndr_mst);		  
	$dispstr		  	  = "";		
while($rowscrtmstr_mst = mysqli_fetch_array($srsvndr_mst)){
$vndrm_id       =     $rowscrtmstr_mst['vndrm_id'];
$vndrm_name =     $rowscrtmstr_mst['vndrm_name'];
$vndrary[] = $vndrm_id; 
$reslt .= "<tr><td>

<input type=\"checkbox\" name=\"chkvndr$vndrm_id\" value=\"$vndrm_id\"
onclick= \"chkprchsvndrs('$vndrm_id')\" checked></td><td>$vndrm_name</td></tr>"; 


}
$vndrval = implode(',',$vndrary);
$reslt .="</table>"."<->".$vndrval; 

echo $reslt;
}	

	
	
	
		
/*Get Project Details */
	if(isset($_REQUEST['rfqval']) && (trim($_REQUEST['rfqval']) != "")){
		// creating Drop Down for County
		$result = "";		
		$rfqval = glb_func_chkvl($_REQUEST['rfqval']);

		$sqrycst_mst = "select 
									qtnm_name,qtnm_id,qtnm_cstmrm_id,
									qtnm_rfqdt,									typrjctm_id,typrjctm_nm,cstmrm_id,cstmrm_name,qtnm_desc_one,qtnm_desc_two,qtnm_fle,qtnm_rfqdt,
							  qtnm_stsm_id,qtnm_sts,qtnm_prty,qtnm_crtdon,qtnm_crtdby,cstmrm_cde
								from 
									qtn_mst
									inner join typrjct_mst on typrjct_mst.typrjctm_id = qtn_mst.qtnm_typrjctm_id
									inner join cstmr_mst on cstmr_mst.cstmrm_id = qtn_mst.qtnm_cstmrm_id
						           inner join prerfq_mst on prerfq_mst.prerfqm_qtnm_id = qtn_mst.qtnm_id 			
								where
									qtnm_id ='$rfqval'
									and
									qtnm_sts ='q' and 
									prerfqm_stsm_id = '9'
									";							
		$srscst_mstt	  = mysqli_query($conn,$sqrycst_mst);
		$cntcst_inc	  = mysqli_num_rows($srscst_mstt);		  
		$dispstr		  	  = "";		

   $rowscrtmstr_mst = mysqli_fetch_array($srscst_mstt);
    $typrjct =     $rowscrtmstr_mst['typrjctm_nm'];
    $cstmr =     $rowscrtmstr_mst['cstmrm_name'];
    $typrjctid =     $rowscrtmstr_mst['typrjctm_id'];
    $cstmrid =     $rowscrtmstr_mst['cstmrm_id'];
    $cstmrcde =     $rowscrtmstr_mst['cstmrm_cde'];

 $res = $typrjct."|".$cstmr."|".$typrjctid."|".$cstmrid."|".$cstmrcde;
echo $res;
	}
	
	
	
	/*Get Feed back Rfq Details */
	if(isset($_REQUEST['fbrfqval']) && (trim($_REQUEST['fbrfqval']) != "")){
		// creating Drop Down for County
		$result = "";		
		$rfqval = glb_func_chkvl($_REQUEST['fbrfqval']);

		$sqrycst_mst = "select 
									qtnm_name,qtnm_id,qtnm_cstmrm_id,
									qtnm_rfqdt,									typrjctm_id,typrjctm_nm,cstmrm_id,cstmrm_name,qtnm_desc_one,qtnm_desc_two,qtnm_fle,qtnm_rfqdt,
							  qtnm_stsm_id,qtnm_sts,qtnm_prty,qtnm_crtdon,qtnm_crtdby
								from 
									qtn_mst
									inner join typrjct_mst on typrjct_mst.typrjctm_id = qtn_mst.qtnm_typrjctm_id
									inner join cstmr_mst on cstmr_mst.cstmrm_id = qtn_mst.qtnm_cstmrm_id
						       			
								where
									qtnm_id ='$rfqval'
									";							
		$srscst_mstt	  = mysqli_query($conn,$sqrycst_mst);
		$cntcst_inc	  = mysqli_num_rows($srscst_mstt);		  
		$dispstr		  	  = "";		

   $rowscrtmstr_mst = mysqli_fetch_array($srscst_mstt);
    $typrjct =     $rowscrtmstr_mst['typrjctm_nm'];
    $cstmr =     $rowscrtmstr_mst['cstmrm_name'];
    $typrjctid =     $rowscrtmstr_mst['typrjctm_id'];
    $cstmrid =     $rowscrtmstr_mst['cstmrm_id'];

 $res = $typrjct."-".$cstmr."-".$typrjctid."-".$cstmrid;
echo $res;
	}
	
	/*Get Clint Employee*/
	if(isset($_REQUEST['fbclntid']) && (trim($_REQUEST['fbclntid']) != "")){
		
		$clntid = $_REQUEST['fbclntid'];
		$result = "";		
		$sqryemp_mst =  "select	
	                      empm_id,empm_pmbno,empm_name,empm_sts,empm_cmbno,
		                  concat(empm_code,' (', empm_name ,')') as empm_code,empm_prty
                               from 
            emp_mst
            inner join empcst_dtl  on empcst_dtl.empcstd_empm_id = emp_mst.empm_id
        where
    		empm_sts = 'a'
			and 
			empcstd_cstmrm_id = $clntid
		group by empm_id
							order by empm_name
							 ";
	if(isset($_REQUEST['prjctemp']) && (trim($_REQUEST['prjctemp']) != "")){
		$prjctemp = $_REQUEST['prjctemp'];
	}								
	//echo $sqryemp_mst;
		$srsemp_mst	  = mysqli_query($conn,$sqryemp_mst);
		$cntprfsnl_inc	  = mysqli_num_rows($srsemp_mst);		  
		$dispstr		  	  = "";		
	?>
	<option value disabled selected>Select Employee</option>
<?php
    while ($emp = mysqli_fetch_array($srsemp_mst)) {
        ?>
<option <?php if($prjctemp==$emp['empm_id']){ echo 'selected'; } ?> value="<?php echo $emp["empm_id"]; ?>"><?php echo $emp["empm_code"]; ?></option>
<?php
    }
		
	}	
	
	
	/*Get Clint Employee*/
	if(isset($_REQUEST['clntid']) && (trim($_REQUEST['clntid']) != "")){
		
		$clntid = $_REQUEST['clntid'];
		$empid = $_REQUEST['prempid'];

		$result = "";		
		$sqryemp_mst =  "select	
	                      empm_id,empm_pmbno,empm_name,empm_sts,empm_cmbno,
		                  concat(empm_code,' (', empm_name ,')') as empm_code,empm_prty
                               from 
            emp_mst
            inner join empcst_dtl  on empcst_dtl.empcstd_empm_id = emp_mst.empm_id
        where
    		empm_sts = 'a'
			and 
			empcstd_cstmrm_id = $clntid";
			if($empid > 0){
				$sqryemp_mst .=  " and empm_id = $empid";
			
			}
			$sqryemp_mst .=  " group by empm_id
							order by empm_name
							 ";
	if(isset($_REQUEST['prjctemp']) && (trim($_REQUEST['prjctemp']) != "")){
		$prjctemp = $_REQUEST['prjctemp'];
	}								
	//echo $sqryemp_mst;
		$srsemp_mst	  = mysqli_query($conn,$sqryemp_mst);
		$cntprfsnl_inc	  = mysqli_num_rows($srsemp_mst);		  
		$dispstr		  	  = "";		
	?>
<?php
    while ($emp = mysqli_fetch_array($srsemp_mst)) {
        ?>
<option <?php if($prjctemp==$emp['empm_id']){ echo 'selected'; } ?> value="<?php echo $emp["empm_id"]; ?>"><?php echo $emp["empm_code"]; ?></option>
<?php
    }
		
	}
			/*Get Project Vendor PO*/
	if(isset($_REQUEST['prjctyp']) && (trim($_REQUEST['prjctyp']) != "")&&
	isset($_REQUEST['prjctcstmr']) && (trim($_REQUEST['prjctcstmr']) != "")&&
	isset($_REQUEST['prjctrfq']) && (trim($_REQUEST['prjctrfq']) != "")){
		// creating Drop Down for County
		$result = "";		
		$typrjct = glb_func_chkvl($_REQUEST['prjctyp']);
		$cstmr = glb_func_chkvl($_REQUEST['prjctcstmr']);
		$rfqid = glb_func_chkvl($_REQUEST['prjctrfq']);
		$prjct = glb_func_chkvl($_REQUEST['prjctid']);

              $vndrary = array();		
		
			$sqryprfsnl_mst =  "select 
								prchsprjctm_vndrm_id						
							  from 
									prchsprjct_mst	
									where	
									prchsprjctm_prjctm_id = '$prjct' 
									group by prchsprjctm_vndrm_id
							 ";								
	//	echo $sqryprfsnl_mst;// $vndrsid;

		$srsprfsnl_mst	  = mysqli_query($conn,$sqryprfsnl_mst);
		while($rwsvndrs = mysqli_fetch_array($srsprfsnl_mst)){
		                $vndrary[] = $rwsvndrs['prchsprjctm_vndrm_id']; 
		}
		  $vndrsid = implode(',',$vndrary);
		$sqryqtn_mst1="select 
									qtnm_name,qtnm_id,
									typrjctm_id,typrjctm_nm,
									vndr_qtnrplym_id,vndr_qtnrplym_prc,vndrm_id,vndrm_name,
									cstmrm_id,cstmrm_name,adm_prchsrplym_id,adm_prchsrplym_prc,adm_prchsrplym_sts
								from 
									vndr_qtnrply_mst
									inner join typrjct_mst on typrjct_mst.typrjctm_id = vndr_qtnrply_mst.vndr_qtnrplym_typrjctm_id
									
									inner join qtn_mst on qtn_mst.qtnm_id = vndr_qtnrply_mst.vndr_qtnrplym_qtnm_id
									inner join vndr_mst on vndr_mst.vndrm_id = vndr_qtnrply_mst.vndr_qtnrplym_vndrm_id
									inner join cstmr_mst on cstmr_mst.cstmrm_id = qtn_mst.qtnm_cstmrm_id
	   left join adm_prchsrply_mst on adm_prchsrply_mst.adm_vndr_qtnrplym_id = vndr_qtnrply_mst.vndr_qtnrplym_id
                                    where
									vndr_qtnrplym_stsid = 2
									and 
									vndr_qtnrplym_typrjctm_id = $typrjct
									and 
                                    vndr_qtnrplym_qtnm_id  = $rfqid  
									and 
									cstmrm_id = $cstmr";
			if($vndrsid !="" ){
			$sqryqtn_mst1.=	" and 
									vndrm_id not in($vndrsid)";
			}
					
						$sqryqtn_mst1.=	" group by  vndrm_id order by vndrm_name	                  
									";								
//	echo $sqryqtn_mst1;;
		$srsprfsnl_mst	  = mysqli_query($conn,$sqryqtn_mst1);
		$cntprfsnl_inc	  = mysqli_num_rows($srsprfsnl_mst);		  
		$resultloc		  	  = "";		
if($cntprfsnl_inc > 0){
	$vndrary = array();

			  $sno= 1;
			//   while($prg = mysqli_fetch_assoc($srsprfsnl_mst)){ }
				   ?>
				   	
	<option value disabled selected>Select Vendor</option>
<?php
    while ($prg = mysqli_fetch_array($srsprfsnl_mst)) {
        ?>
<option value="<?php echo $prg['vndrm_id']; ?>"><?php echo $prg['vndrm_name']; ?></option>
<?php
    }
				   
				   
				  
}else{
	echo "No Vendors";
	
	
	}
	}


/*Get Purchase Project Vendor PO*/
if(isset($_REQUEST['prchsprjctyp']) && (trim($_REQUEST['prchsprjctyp']) != "")&&
isset($_REQUEST['prchsprjctcstmr']) && (trim($_REQUEST['prchsprjctcstmr']) != "")&&
isset($_REQUEST['prchsprjctrfq']) && (trim($_REQUEST['prchsprjctrfq']) != "")){
	// creating Drop Down for County
	$result = "";		
	$typrjct = glb_func_chkvl($_REQUEST['prchsprjctyp']);
	$cstmr = glb_func_chkvl($_REQUEST['prchsprjctcstmr']);
	$rfqid = glb_func_chkvl($_REQUEST['prchsprjctrfq']);
	$prjct = glb_func_chkvl($_REQUEST['prchsprjctid']);

		  $vndrary = array();		
	
		$sqryprfsnl_mst =  "select 
							prchsprjctm_vndrm_id						
						  from 
								prchsprjct_mst	
								where	
								prchsprjctm_prjctm_id = '$prjct' 
								group by prchsprjctm_vndrm_id
						 ";								
//	echo $sqryprfsnl_mst;// $vndrsid;

	$srsprfsnl_mst	  = mysqli_query($conn,$sqryprfsnl_mst);
	while($rwsvndrs = mysqli_fetch_array($srsprfsnl_mst)){
					$vndrary[] = $rwsvndrs['prchsprjctm_vndrm_id']; 
	}
	  $vndrsid = implode(',',$vndrary);
	$sqryqtn_mst1="select 
								qtnm_name,qtnm_id,
								typrjctm_id,typrjctm_nm,
								vndr_qtnrplym_id,vndr_qtnrplym_prc,vndrm_id,vndrm_name,
								cstmrm_id,cstmrm_name,adm_prchsrplym_id,adm_prchsrplym_prc,adm_prchsrplym_sts
							from 
								vndr_qtnrply_mst
								inner join typrjct_mst on typrjct_mst.typrjctm_id = vndr_qtnrply_mst.vndr_qtnrplym_typrjctm_id
								
								inner join qtn_mst on qtn_mst.qtnm_id = vndr_qtnrply_mst.vndr_qtnrplym_qtnm_id
								inner join vndr_mst on vndr_mst.vndrm_id = vndr_qtnrply_mst.vndr_qtnrplym_vndrm_id
								inner join cstmr_mst on cstmr_mst.cstmrm_id = qtn_mst.qtnm_cstmrm_id
   left join adm_prchsrply_mst on adm_prchsrply_mst.adm_prchsrplym_qtnrplym_id = vndr_qtnrply_mst.vndr_qtnrplym_id
								where
								vndr_qtnrplym_stsid = 2
								and 
								vndr_qtnrplym_typrjctm_id = $typrjct
								and 
								vndr_qtnrplym_qtnm_id  = $rfqid  
								and 
								cstmrm_id = $cstmr";
		if($vndrsid !="" ){
		$sqryqtn_mst1.=	" and 
								vndrm_id not in($vndrsid)";
		}
				
					$sqryqtn_mst1.=	" group by  vndrm_id order by vndrm_name	                  
								";								
	echo $sqryqtn_mst1;;
	$srsprfsnl_mst	  = mysqli_query($conn,$sqryqtn_mst1);
	$cntprfsnl_inc	  = mysqli_num_rows($srsprfsnl_mst);		  
	$resultloc		  	  = "";		
if($cntprfsnl_inc > 0){
$vndrary = array();

		  $sno= 1;
		//   while($prg = mysqli_fetch_assoc($srsprfsnl_mst)){ }
			   ?>
				   
<option value disabled selected>Select Vendor</option>
<?php
while ($prg = mysqli_fetch_array($srsprfsnl_mst)) {
	?>
<option value="<?php echo $prg['vndrm_id']; ?>"><?php echo $prg['vndrm_name']; ?></option>
<?php
}
			   
			   
			  
}else{
echo "No Vendors";


}
}



	
				/*Get Feed back Vendor PO*/
	if(isset($_REQUEST['fbprjctyp']) && (trim($_REQUEST['fbprjctyp']) != "")&&
	isset($_REQUEST['fbprjctcstmr']) && (trim($_REQUEST['fbprjctcstmr']) != "")&&
	isset($_REQUEST['fbprjctrfq']) && (trim($_REQUEST['fbprjctrfq']) != "")){
		// creating Drop Down for County
		$result = "";		
		$typrjct = glb_func_chkvl($_REQUEST['fbprjctyp']);
		$cstmr = glb_func_chkvl($_REQUEST['fbprjctcstmr']);
		$rfqid = glb_func_chkvl($_REQUEST['fbprjctrfq']);
		$prjct = glb_func_chkvl($_REQUEST['fbprjctid']);

              $vndrary = array();		
		

		$sqryqtn_mst1="select 
									qtnm_name,qtnm_id,
									typrjctm_id,typrjctm_nm,
									vndr_qtnrplym_id,vndr_qtnrplym_prc,vndrm_id,vndrm_name,
									cstmrm_id,cstmrm_name,adm_prchsrplym_id,adm_prchsrplym_prc,adm_prchsrplym_sts
								from 
									vndr_qtnrply_mst
									inner join typrjct_mst on typrjct_mst.typrjctm_id = vndr_qtnrply_mst.vndr_qtnrplym_typrjctm_id
									
									inner join qtn_mst on qtn_mst.qtnm_id = vndr_qtnrply_mst.vndr_qtnrplym_qtnm_id
									inner join vndr_mst on vndr_mst.vndrm_id = vndr_qtnrply_mst.vndr_qtnrplym_vndrm_id
									inner join cstmr_mst on cstmr_mst.cstmrm_id = qtn_mst.qtnm_cstmrm_id
	   left join adm_prchsrply_mst on adm_prchsrply_mst.adm_vndr_qtnrplym_id = vndr_qtnrply_mst.vndr_qtnrplym_id
                                    where
									vndr_qtnrplym_stsid = 2
									and 
									vndr_qtnrplym_typrjctm_id = $typrjct
									and 
                                    vndr_qtnrplym_qtnm_id  = $rfqid  
									and 
									cstmrm_id = $cstmr";
	
					
						$sqryqtn_mst1.=	" group by  vndrm_id order by vndrm_name	                  
									";								
	//echo $sqryqtn_mst1;;
		$srsprfsnl_mst	  = mysqli_query($conn,$sqryqtn_mst1);
		$cntprfsnl_inc	  = mysqli_num_rows($srsprfsnl_mst);		  
		$resultloc		  	  = "";		
if($cntprfsnl_inc > 0){
	$vndrary = array();

			  $sno= 1;
			//   while($prg = mysqli_fetch_assoc($srsprfsnl_mst)){ }
				   ?>
				   	
	<option value disabled selected>Select Vendor</option>
<?php
    while ($prg = mysqli_fetch_array($srsprfsnl_mst)) {
        ?>
<option value="<?php echo $prg['vndrm_id']; ?>"><?php echo $prg['vndrm_name']; ?></option>
<?php
    }
				   
				   
				  
}else{
	echo "No Vendors";
	
	
	}
	}
	
	
		
/*Get Project Schdule  Details */
	if(isset($_REQUEST['prjsch']) && (trim($_REQUEST['prjsch']) != "")){
		// creating Drop Down for County
		$result = "";		
		$rfqval = glb_func_chkvl($_REQUEST['prjsch']);

		$sqrycst_mst = "select 
									qtnm_name,qtnm_id,qtnm_cstmrm_id,
									qtnm_rfqdt,								
										typrjctm_id,typrjctm_nm,cstmrm_id,cstmrm_name,qtnm_desc_one,qtnm_desc_two,qtnm_fle,qtnm_rfqdt,
							  qtnm_stsm_id,qtnm_sts,qtnm_prty,qtnm_crtdon,qtnm_crtdby,prjctm_nm,
							  prjctm_lead,empm_name,empm_code,prjctm_id,empm_id
								from 
									qtn_mst
									inner join typrjct_mst on typrjct_mst.typrjctm_id = qtn_mst.qtnm_typrjctm_id
									inner join cstmr_mst on cstmr_mst.cstmrm_id = qtn_mst.qtnm_cstmrm_id
						           inner join prerfq_mst on prerfq_mst.prerfqm_qtnm_id = qtn_mst.qtnm_id 			
						           inner join prjct_mst on prjct_mst.prjctm_qtnm_id = qtn_mst.qtnm_id 			
						           inner join emp_mst on emp_mst.empm_id = prjct_mst.prjctm_lead 			

								where
									qtnm_id ='$rfqval'
									 and 
									prerfqm_stsm_id = '9'
									";							
		//echo $sqrycst_mst;exit;
		$srscst_mstt	  = mysqli_query($conn,$sqrycst_mst);
		$cntcst_inc	  = mysqli_num_rows($srscst_mstt);		  
		$dispstr		  	  = "";		

   $rowscrtmstr_mst = mysqli_fetch_array($srscst_mstt);
    $typrjct =     $rowscrtmstr_mst['typrjctm_nm'];
    $cstmr =     $rowscrtmstr_mst['cstmrm_name'];
    $typrjctid =     $rowscrtmstr_mst['typrjctm_id'];
    $cstmrid =     $rowscrtmstr_mst['cstmrm_id'];
    $prjctm_nm =     $rowscrtmstr_mst['prjctm_nm'];
    $prjctm_id =     $rowscrtmstr_mst['prjctm_id'];
    $empm_name =     $rowscrtmstr_mst['empm_name'];
    $empm_id =     $rowscrtmstr_mst['empm_id'];

 $res = $typrjct."-".$cstmr."-".$typrjctid."-".$cstmrid."-".$prjctm_nm."-".$empm_name."-".$prjctm_id."-".$empm_id;
echo $res;
	}
	/*Customer Name*/
	if(isset($_REQUEST['cstcde']) && (trim($_REQUEST['cstcde']) != "")){
		$cstmrid = $_REQUEST['cstcde'];
		$strcstval = $_REQUEST['strcstval'];
		$sqrycrtmstr_mst=" select cstmrm_id,cstmrm_name from cstmr_mst where cstmrm_id in ($cstmrid)";
		//echo $sqrycrtmstr_mst;
		$rscrtmstr_mst  =  mysqli_query($conn,$sqrycrtmstr_mst);
		$cntrws  =  mysqli_num_rows($rscrtmstr_mst);
		$sn =1 ;
		while($rwscst = mysqli_fetch_array($rscrtmstr_mst))
		{
			if($cntrws == $sn)
			{
				$cnct = "";
			}
			else
			{
				$cnct = ",";
			}
			echo  $cstnm =  "&nbsp;".$sn.")".$rwscst['cstmrm_name'].$cnct;
			$sn++;
		}
	}
		


/*vendor Name*/
	if(isset($_REQUEST['vndrcde']) && (trim($_REQUEST['vndrcde']) != "")){
		$vndrid = $_REQUEST['vndrcde'];
		$strcstval = $_REQUEST['strcstval'];

       
		
             	$sqryvndr_mst=" select 
									vndrm_id,vndrm_name

								from 
									vndr_mst 
								where
									vndrm_id in ($vndrid)
							";
						
							
							//echo $sqrycrtmstr_mst;
							 $rsvndr_mst  =  mysqli_query($conn,$sqryvndr_mst);
							 $cntrws  =  mysqli_num_rows($rsvndr_mst);
                                $sn =1 ;
							 while($rwsvndr = mysqli_fetch_array($rsvndr_mst)){
								 if($cntrws == $sn){
									 $cnct = "";
									 }else{
									 $cnct = ",";
										 }
								 
							
							echo  $vndrnm =  "&nbsp;".$sn.")".$rwsvndr['vndrm_name'].$cnct; 
							$sn++;
							}

		
		
		
		}
		


	
	
				
/*Get Project Schdule  Details */
	if(isset($_REQUEST['fbprjsch']) && (trim($_REQUEST['fbprjsch']) != "")){
		// creating Drop Down for County
		$result = "";		
		$rfqval = glb_func_chkvl($_REQUEST['fbprjsch']);

		$sqrycst_mst = "select qtnm_name,qtnm_id,qtnm_cstmrm_id, qtnm_rfqdt, typrjctm_id,typrjctm_nm,cstmrm_id,cstmrm_name,qtnm_desc_one,qtnm_desc_two,qtnm_fle,qtnm_rfqdt, qtnm_stsm_id,qtnm_sts,qtnm_prty,qtnm_crtdon,qtnm_crtdby from
 qtn_mst
  inner join typrjct_mst on typrjct_mst.typrjctm_id = qtn_mst.qtnm_typrjctm_id 
  inner join cstmr_mst on cstmr_mst.cstmrm_id = qtn_mst.qtnm_cstmrm_id



    where qtnm_id ='$rfqval'
									 
									";							
//	echo $sqrycst_mst;exit;
		$srscst_mstt	  = mysqli_query($conn,$sqrycst_mst);
		$cntcst_inc	  = mysqli_num_rows($srscst_mstt);		  
		$dispstr		  	  = "";		

   $rowscrtmstr_mst = mysqli_fetch_array($srscst_mstt);
    $typrjct =     $rowscrtmstr_mst['typrjctm_nm'];
    $cstmr =     $rowscrtmstr_mst['cstmrm_name'];
    $typrjctid =     $rowscrtmstr_mst['typrjctm_id'];
    $cstmrid =     $rowscrtmstr_mst['cstmrm_id'];
    $prjctm_nm =     $rowscrtmstr_mst['prjctm_nm'];
    $prjctm_id =     $rowscrtmstr_mst['prjctm_id'];
    $empm_name =     $rowscrtmstr_mst['empm_name'];
    $empm_id =     $rowscrtmstr_mst['empm_id'];

 $res = $typrjct."-".$cstmr."-".$typrjctid."-".$cstmrid."-".$prjctm_nm."-".$empm_name."-".$prjctm_id."-".$empm_id;
echo $res;
	}
	
	
/*Skistaus Name*/
	if(isset($_REQUEST['typid']) && (trim($_REQUEST['typid']) != "")){
		$typid = $_REQUEST['typid'];
		
             	$sqrysts_mst="select 
							skistsm_id,skistsm_typrjctm_id,skistsm_nm,skistsm_desc,skistsm_sts,
										typrjctm_nm,skistsm_prty
								from 
									skists_mst
									inner join typrjct_mst on typrjctm_id = skistsm_typrjctm_id
								where
								skistsm_typrjctm_id = $typid
							";
						
							
							//echo $sqrycrtmstr_mst;
							 $rsts_mst  =  mysqli_query($conn,$sqrysts_mst);
							 $cntrws  =  mysqli_num_rows($rsts_mst);
                                $sn =1 ;
							 while($rwskists = mysqli_fetch_array($rsts_mst)){
							    $stsnm = $rwskists['skistsm_nm'];
							    $stsid = $rwskists['skistsm_id'];

								 ?>
							
						
						<div class='row'><div class='col-md-12'><div class='col-sm-2'> <div class='form-group clearfix'><?php echo $sn; ?></div></div><div class='col-sm-4'><div class='form-group clearfix'><input type='hidden' name='trmnm<?php echo $sn; ?>' id='trmnm<?php echo $sn; ?>' value='<?php echo $stsid; ?>' class='form-control input-sm'><?php echo $stsnm; ?></div></div><div class='col-sm-4'><div class='form-group clearfix'><input type='text' name='txtper<?php echo $sn; ?>' id='txtper<?php echo $sn; ?>' class='form-control input-sm' placeholder='Percantage'  ></div></div></div></div>
						
						
						<?php
                        	$sn++;
							}
?>
		<input type="hidden" name="lsttrms" id="lsttrms" value="<?php echo $cntrws; ?>" />
	<?php	
		
		}
		
	
	?>



<?php    	if(isset($_REQUEST['typrjctid']) && (trim($_REQUEST['typrjctid']) != "")){

		// creating Drop Down for County
		$result = "";		
		$typrjct = glb_func_chkvl($_REQUEST['typrjctid']);


		

		$sqryqtn_mst1="select 
							skistsm_id,skistsm_typrjctm_id,skistsm_nm,skistsm_desc,skistsm_sts,
										typrjctm_nm,skistsm_prty
								from 
									skists_mst
									inner join typrjct_mst on typrjctm_id = skistsm_typrjctm_id
								where
								skistsm_typrjctm_id = $typrjct	                  
									";								
		$rsts_mst	  = mysqli_query($conn,$sqryqtn_mst1);
		$cntprfsnl_inc	  = mysqli_num_rows($rsts_mst);		  
		$resultloc		  	  = "";		
if($cntprfsnl_inc > 0){
	$vndrary = array();

			  $sno= 1;
			//   while($prg = mysqli_fetch_assoc($srsprfsnl_mst)){ }
				   ?>
				   	
	<option value disabled selected>Select Ski Status</option>
<?php
		 while($rwskists = mysqli_fetch_array($rsts_mst)){
							    $stsnm = $rwskists['skistsm_nm'];
							    $stsid = $rwskists['skistsm_id'];
        ?>
<option value="<?php echo $stsid; ?>"><?php echo  $stsnm; ?></option>
<?php
    }
				   
				   
				  
}else{
	echo "No Vendors";
	
	
	}
}



	
/*Get Employees*/
	$resultemp = "";

	if(isset($_REQUEST['prjempcde']) && (trim($_REQUEST['prjempcde']) != "")&&
	isset($_REQUEST['cstmr']) && (trim($_REQUEST['cstmr']) != "")){
		// creating Drop Down for County
		$result = "";		
                    $empid =   $_REQUEST['prjempcde'];
                    $clntid =   $_REQUEST['cstmr'];

		$sqryprfsnl_mst =  "select 
							   		empm_id,empm_name
							  from 
									emp_mst
	            inner join empcst_dtl  on empcst_dtl.empcstd_empm_id = emp_mst.empm_id
							  where 
									empm_sts ='a'
									and 
									empm_id not in($empid)
								
							  group by empm_id order by empm_name";								
		$srsprfsnl_mst	  = mysqli_query($conn,$sqryprfsnl_mst);
		$cntprfsnl_inc	  = mysqli_num_rows($srsprfsnl_mst);		  
		$dispstr		  	  = "";		



			$resultemp   = "<div class='row'>";
			   while($prg = mysqli_fetch_assoc($srsprfsnl_mst)){
					if(($inc != 0) && ($inc % 3 == 0)){
					  $resultloc .= "";
					}					
				 $crtmstrid   = $prg['empm_id'];
				 $crtmstrname = $prg['empm_name'];						
			/*	$resultemp .= "<td align=\"left\" width=\"30%\">
							<input type=\"checkbox\" name=\"chksize$crtmstrid\" value=\"$crtmstrid\"
							onclick= \"chkemps('$crtmstrid')\">
								&nbsp;$crtmstrname
							</td>";*/
							
						$resultemp .= "<div class='col-sm-3'>
							<input type=\"checkbox\" name=\"chksize$crtmstrid\" value=\"$crtmstrid\"
							onclick= \"chkemps('$crtmstrid')\">
								&nbsp;$crtmstrname
							</div>";			
							
				 
							
				 $inc++; 
			  }
			 echo  $resultemp.="</div>";

}

/*Customer Po*/
	if(isset($_REQUEST['porfqid']) && (trim($_REQUEST['porfqid']) != "")){
		  
		  $porfqid = $_REQUEST['porfqid'];
		  ?>
   <div class="form-group clearfix">
                        	<label class="col-sm-2 control-label"><u>Payment Installment List</u></label>
                        </div>            <div class="row">
                        <div class="col-md-12">
                        <div class="col-sm-2"> 
                        <div class="form-group clearfix"><label class="control-label">S.no</label></div>
                        </div>
                        
                        <div class="col-sm-3">
                        <div class="form-group clearfix">
                        <label class="control-label">SKI Status </label></div></div>
                        <div class="col-sm-2">
                        <div class="form-group clearfix"> <label class="control-label">Payment (%)</label></div>
                        </div>
                        </div></div>
		<?php
		$sqryprjct_mst="select 
											   paytrmsm_id,paytrmsm_cstpom_id,paytrmsm_trm_prcntg,  
											   paytrmsm_sts,paytrmsd_sts,skistsm_nm,skistsm_id,qtnm_id,
											   cstpom_qtnm_id,cstpom_prc
										from 
											paytrms_mst 
											inner join cstpo_mst on cstpo_mst.cstpom_id = paytrmsm_cstpom_id
								inner join qtn_mst on qtn_mst.qtnm_id = cstpo_mst.cstpom_qtnm_id
	          						     inner join skists_mst on skists_mst.skistsm_id = paytrmsm_skistsm_id
									   	left join paytrms_dtl on paytrms_dtl.paytrmsd_paytrmsm_id = paytrmsm_id
		
										where
										   cstpom_qtnm_id ='$porfqid' order by paytrmsm_id
										   ";
						//echo $sqryprjct_mst;
						$srsprjct_mst  = mysqli_query($conn,$sqryprjct_mst);
						$cntprjct =mysqli_num_rows($srsprjct_mst);
						if($cntprjct > 0){
						$sno= 1;
						while($rowsprjct_mst = mysqli_fetch_assoc($srsprjct_mst)){
								$poprc =	$rowsprjct_mst['cstpom_prc'];
								$prjmdlid  =   $rowsprjct_mst['paytrmsm_cstpom_id'];		
								$mdlid  =   $rowsprjct_mst['paytrmsm_id'];		
								$mdlsts =   $rowsprjct_mst['paytrmsd_sts'];
								$trm_nm  =   $rowsprjct_mst['skistsm_nm'];		
								$trm_per  =   $rowsprjct_mst['paytrmsm_trm_prcntg'];		
								$trm_prc  =($poprc*$trm_per)/100;
							   $cpoprc += $poprc;
							 
							  ?>
                              
                        <div class="row">
                        <div class="col-md-12">
                        <div class="col-sm-2"> 
                        <div class="form-group clearfix"><?php echo $sno; ?></div>
                        </div>
                        
                        <div class="col-sm-3">
                        <div class="form-group clearfix"><?php echo  $trm_nm;?></div>
                        </div>
                        <div class="col-sm-4">
                        <div class="form-group clearfix"><?php echo round($trm_prc)." (".$trm_per.") %";?></div>
                        </div>
                        </div></div>
                    <?php
                        $sno++;
                        }
						?>
					<!-- <div class="col-sm-12">
                        <div class="form-group clearfix"><?php echo $cpoprc ;?></div>
                        </div>-->
                        <div class="row">
                        <div class="col-md-12">
                        <div class="col-sm-2"> 
                        <div class="form-group clearfix"></div>
                        </div>
                        
                        <div class="col-sm-3">
                        <div class="form-group clearfix">Coustmer PO Amout</div>
                        </div>
                        <div class="col-sm-4">
                        <div class="form-group clearfix"><?php echo  $cpoprc;?></div>
                        </div>
                        </div></div>
					 <?php
                     } 
		
		}
		
	//Customer PO Details

		if(isset($_REQUEST['cstpoblnkt']) && (trim($_REQUEST['cstpoblnkt']) != "")){
			error_reporting(0);		

			// creating Drop Down for County
			$result = "";		
			$cstpoid = glb_func_chkvl($_REQUEST['cstpoblnkt']);
		/*	$sqrycst_mst =  "select 
			cstpom_id,cstpom_blnktprc,cstpom_prc,cstpom_cde,cstpo_blkd_amnt 
			 from 
			 cstpo_mst
			 left join cstpo_blk_dtl on cstpo_blk_dtl.cstpo_blkd_ref_id = cstpom_id
			 where
			 cstpom_cstmrm_id  ='$cstpoid'
			 order by
			 cstpo_blkd_id desc
			 ";		*/

			 $sqrycst_mst =  "select 
			 cstpom_id,cstpom_blnktprc,cstpom_prc,cstpom_cde,cstpo_blkd_amnt,cstpo_blkd_sts,cstpom_pocde 
			  from 
			  cstpo_mst
			  left join cstpo_blk_dtl on cstpo_blk_dtl.cstpo_blkd_ref_id = cstpom_id
			  where
			  cstpom_cstmrm_id  ='$cstpoid'
			  and 
			  cstpom_typ  = '3'
			  order by
			  cstpo_blkd_id desc
			  ";
			// echo $sqrycst_mst;
			 

			$srscst_mst	  = mysqli_query($conn,$sqrycst_mst);
			$cntcst_inc	  = mysqli_num_rows($srscst_mst);		  
			$dispstr		  	  = "";		
			if($cntcst_inc > 0){
				$result ="<div class='form-group clearfix'><label class='col-sm-12 control-label'>Blanket PO Details</label></div><table width=\"100%\" cellspacing=\"1\" cellpadding=\"1\" style=\"color:black\" class=\"table table-condensed table-bordered table-striped\">";
				while($srowscst_mst = mysqli_fetch_assoc($srscst_mst)){
					$cstid  = $srowscst_mst['cstpom_id'];
					$cstnm  = $srowscst_mst['cstpom_pocde'];			
					$cstpom_prc      =     $srowscst_mst['cstpom_prc'];
					$cstpom_blnktprc  =     $srowscst_mst['cstpom_blnktprc'];
					$cstpo_blkd_amnt  =       $srowscst_mst['cstpo_blkd_amnt'];
					$cstpo_blkd_sts  =       $srowscst_mst['cstpo_blkd_sts'];

					
					
					$cstpo_blnkrmnprc       =     ($cstpom_blnktprc - $cstpom_prc);
					if($cstpo_blkd_amnt == ""){
						$cstpo_blkd_amnt = 	$cstpo_blnkrmnprc;  
					}else{
						$cstpo_blkd_amnt = 	$cstpo_blkd_amnt;  


					}
					$cstpo_rmnprc = $cstpo_blkd_amnt;
					if(($cstpo_rmnprc > 0)&&(($cstpo_blkd_sts =='a')||($cstpo_blkd_sts ==''))){
					$dispstr .= ","."$cstid:$cstnm";	
				$result .= "<tr><td align=\"left\" width=\"30%\">
							<input type=\"checkbox\" name=\"chksize$cstid\" id=\"chksize$cstid\" value=\"$cstid\"
							onclick= \"chkBlnkt('$cstid')\">
								&nbsp;$cstnm
							</td><td><input type=\"hidden\" name=\"hdnprc$cstid\" id=\"hdnprc$cstid\" value=\"$cstpo_rmnprc\" > 
							$cstpo_rmnprc</td><td><input type=\"text\"  id=\"chkblnkprc$cstid\" name=\"chkblnkprc$cstid\" value=\"\" ></td></tr>";
				}
			}
				$result .="</table>";
				
			}
			echo $result;
		}



	//Customer PO Blanket Edit Details

	if(isset($_REQUEST['cstedtpoblnkt']) && (trim($_REQUEST['cstedtpoblnkt']) != "")){
		error_reporting(0);		

		// creating Drop Down for County
		$result = "";		
		$cstedtpoid = glb_func_chkvl($_REQUEST['cstedtpoblnkt']);
		$cstpoid = glb_func_chkvl($_REQUEST['cstpoid']);

		 $sqrycst_mst =  "select 
		 cstpom_id,cstpom_blnktprc,cstpom_prc,cstpom_cde,cstpo_blkd_amnt,cstpo_blkd_sts,cstpom_pocde,cstpo_blkd_trmamnt,
		 cstpo_blkd_id 
		  from 
		  cstpo_mst
		  left join cstpo_blk_dtl on cstpo_blk_dtl.cstpo_blkd_ref_id = cstpom_id
		  where
		  cstpom_cstmrm_id  ='$cstedtpoid'
		  and
		  cstpom_typ  = '3'
		  order by
		  cstpo_blkd_id desc
		  ";
		// echo $sqrycst_mst;
		 

		$srscst_mst	  = mysqli_query($conn,$sqrycst_mst);
		$cntcst_inc	  = mysqli_num_rows($srscst_mst);		  
		$dispstr		  	  = "";		
		if($cntcst_inc > 0){
			$blkidary = array();
			$blkrefidary = array();
			$blktrmamtary = array();
			$blkamtary = array();
			$result ="<div class='form-group clearfix'><label class='col-sm-12 control-label'>Blanket PO Details</label></div><table width=\"100%\" cellspacing=\"1\" cellpadding=\"1\" style=\"color:black\" class=\"table table-condensed table-bordered table-striped\">";
			while($srowscst_mst = mysqli_fetch_assoc($srscst_mst)){
				$cstid  = $srowscst_mst['cstpom_id'];
				$cstnm  = $srowscst_mst['cstpom_pocde'];			
				$cstpom_prc      =     $srowscst_mst['cstpom_prc'];
				$cstpom_blnktprc  =     $srowscst_mst['cstpom_blnktprc'];
				$cstpo_blkd_amnt  =       $srowscst_mst['cstpo_blkd_amnt'];
				$cstpo_blkd_sts  =       $srowscst_mst['cstpo_blkd_sts'];

				$cstpo_blkd_trmamnt  =       $srowscst_mst['cstpo_blkd_trmamnt'];

				$cstpo_blkd_id  =       $srowscst_mst['cstpo_blkd_id'];

				if($cstpo_blkd_id !=""){
					$blkidary[] = $cstpo_blkd_id;
					$blkrefidary[] = $cstid;
					$blktrmary[] = $cstpo_blkd_trmamnt;
					$blkprcary[] = $cstpo_blkd_amnt;


					$chk = "checked";
					$dis= "readonly";

					//$chk= "";

				}else{
					$chk= "";
					$dis= "";


				}

				
                   $blkidval =  implode(',',$blkidary);
                   $blkrefval =  implode(',',$blkrefidary);
                   $blktrmval =  implode(',',$blktrmary);
                   $blkprcval =  implode(',',$blkprcary);
				
				
				$cstpo_blnkrmnprc       =     ($cstpom_blnktprc - $cstpom_prc);
				if($cstpo_blkd_amnt == ""){
					$cstpo_blkd_amnt = 	$cstpo_blnkrmnprc;  
				}else{
				//	$cstpo_blkd_amnt = 	$cstpo_blkd_amnt+$cstpo_blkd_trmamnt;  
				$cstpo_blkd_amnt = 	$cstpo_blkd_amnt;  


				}
				$cstpo_rmnprc = $cstpo_blkd_amnt;
				if(($cstpo_rmnprc > 0)&&(($cstpo_blkd_sts =='a')||($cstpo_blkd_sts ==''))){
				$dispstr .= ","."$cstid:$cstnm";	
			$result .= "<tr><td align=\"left\" width=\"30%\">
						<input type=\"checkbox\" name=\"chksize$cstid\" id=\"chksize$cstid\" value=\"$cstid\"
						onclick= \"chkBlnkt('$cstid')\" $chk>
							&nbsp;$cstnm
						</td><td><input type=\"hidden\" name=\"hdnprc$cstid\" id=\"hdnprc$cstid\" value=\"$cstpo_rmnprc\" > 
						$cstpo_rmnprc</td><td><input type=\"text\"  id=\"chkblnkprc$cstid\" name=\"chkblnkprc$cstid\" value=\"$cstpo_blkd_trmamnt\" $dis></td></tr>";
			}
		}
			$result .="</table>";
			
			 $blnktdtl =  $result ."<->".$blkidval."<->".$blkrefval."<->".$blktrmval."<->".$blkprcval;

		}
		echo $blnktdtl;
	}
//Vendor PO Blanket Edit Details

if(isset($_REQUEST['vndredtpoblnkt']) && (trim($_REQUEST['vndredtpoblnkt']) != "")){
	error_reporting(0);		

	// creating Drop Down for County
	$result = "";		
	$cstedtpoid = glb_func_chkvl($_REQUEST['vndredtpoblnkt']);
	$cstpoid = glb_func_chkvl($_REQUEST['vndrpoid']);

	 $sqrycst_mst =  "select 
	 vndrpom_id,vndrpom_blnktprc,vndrpom_prc,vndrpom_cde,vndrpo_blkd_amnt,vndrpo_blkd_sts,vndrpom_pocde,vndrpo_blkd_trmamnt,
	 vndrpo_blkd_id 
	  from 
	  vndrpo_mst
	  left join vndrpo_blk_dtl on vndrpo_blk_dtl.vndrpo_blkd_ref_id = vndrpom_id
	  where
	  vndrpom_cstmrm_id  ='$cstedtpoid'
	  and
	  vndrpom_typ  = '3'
	  order by
	  vndrpo_blkd_id desc
	  ";
	// echo $sqrycst_mst;
	 

	$srscst_mst	  = mysqli_query($conn,$sqrycst_mst);
	$cntcst_inc	  = mysqli_num_rows($srscst_mst);		  
	$dispstr		  	  = "";		
	if($cntcst_inc > 0){
		$blkidary = array();
		$blkrefidary = array();
		$blktrmamtary = array();
		$blkamtary = array();
		$result ="<div class='form-group clearfix'><label class='col-sm-12 control-label'>Blanket PO Details</label></div><table width=\"100%\" cellspacing=\"1\" cellpadding=\"1\" style=\"color:black\" class=\"table table-condensed table-bordered table-striped\">";
		while($srowscst_mst = mysqli_fetch_assoc($srscst_mst)){
			$cstid  = $srowscst_mst['vndrpom_id'];
			$cstnm  = $srowscst_mst['vndrpom_pocde'];			
			$cstpom_prc      =     $srowscst_mst['vndrpom_prc'];
			$cstpom_blnktprc  =     $srowscst_mst['vndrpom_blnktprc'];
			$cstpo_blkd_amnt  =       $srowscst_mst['vndrpo_blkd_amnt'];
			$cstpo_blkd_sts  =       $srowscst_mst['vndrpo_blkd_sts'];

			$cstpo_blkd_trmamnt  =       $srowscst_mst['vndrpo_blkd_trmamnt'];

			$cstpo_blkd_id  =       $srowscst_mst['vndrpo_blkd_id'];

			if($cstpo_blkd_id !=""){
				$blkidary[] = $cstpo_blkd_id;
				$blkrefidary[] = $cstid;
				$blktrmary[] = $cstpo_blkd_trmamnt;
				$blkprcary[] = $cstpo_blkd_amnt;


				$chk = "checked";
				$dis= "readonly";

				//$chk= "";

			}else{
				$chk= "";
				$dis= "";


			}

			
			   $blkidval =  implode(',',$blkidary);
			   $blkrefval =  implode(',',$blkrefidary);
			   $blktrmval =  implode(',',$blktrmary);
			   $blkprcval =  implode(',',$blkprcary);
			
			
			$cstpo_blnkrmnprc       =     ($cstpom_blnktprc - $cstpom_prc);
			if($cstpo_blkd_amnt == ""){
				$cstpo_blkd_amnt = 	$cstpo_blnkrmnprc;  
			}else{
			//	$cstpo_blkd_amnt = 	$cstpo_blkd_amnt+$cstpo_blkd_trmamnt;  
			$cstpo_blkd_amnt = 	$cstpo_blkd_amnt;  


			}
			$cstpo_rmnprc = $cstpo_blkd_amnt;
			if(($cstpo_rmnprc > 0)&&(($cstpo_blkd_sts =='a')||($cstpo_blkd_sts ==''))){
			$dispstr .= ","."$cstid:$cstnm";	
		$result .= "<tr><td align=\"left\" width=\"30%\">
					<input type=\"checkbox\" name=\"chksize$cstid\" id=\"chksize$cstid\" value=\"$cstid\"
					onclick= \"chkBlnkt('$cstid')\" $chk>
						&nbsp;$cstnm
					</td><td><input type=\"hidden\" name=\"hdnprc$cstid\" id=\"hdnprc$cstid\" value=\"$cstpo_rmnprc\" > 
					$cstpo_rmnprc</td><td><input type=\"text\"  id=\"chkblnkprc$cstid\" name=\"chkblnkprc$cstid\" value=\"$cstpo_blkd_trmamnt\" $dis></td></tr>";
		}
	}
		$result .="</table>";
		
		 $blnktdtl =  $result ."<->".$blkidval."<->".$blkrefval."<->".$blktrmval."<->".$blkprcval;

	}
	echo $blnktdtl;
}






		//Vendor Blanket  PO Details

		if(isset($_REQUEST['vndrpoblnkt']) && (trim($_REQUEST['vndrpoblnkt']) != "")){
			error_reporting(0);		

			// creating Drop Down for County
			$result = "";		
			$cstpoid = glb_func_chkvl($_REQUEST['vndrpoblnkt']);
			$vndrval = glb_func_chkvl($_REQUEST['vndrval']);

		/*	$sqrycst_mst =  "select 
			cstpom_id,cstpom_blnktprc,cstpom_prc,cstpom_cde,cstpo_blkd_amnt 
			 from 
			 cstpo_mst
			 left join cstpo_blk_dtl on cstpo_blk_dtl.cstpo_blkd_ref_id = cstpom_id
			 where
			 cstpom_cstmrm_id  ='$cstpoid'
			 order by
			 cstpo_blkd_id desc
			 ";		*/

			 $sqrycst_mst =  "select 
			 vndrpom_id,vndrpom_blnktprc,vndrpom_prc,vndrpom_cde,vndrpo_blkd_amnt,vndrpo_blkd_sts,vndrpom_pocde,
			 vndrpo_blkd_amnt,vndrpo_blkd_sts 
			  from 
			  vndrpo_mst
			  left join vndrpo_blk_dtl on vndrpo_blk_dtl.vndrpo_blkd_ref_id = vndrpom_id
			  where
			  vndrpom_cstmrm_id  ='$cstpoid'
			  and
			  vndrpom_vndrm_id  ='$vndrval'
			  and
			  vndrpom_typ  = '3'
			  order by
			  vndrpo_blkd_id desc
			  ";
//echo $sqrycst_mst;
			 

			$srscst_mst	  = mysqli_query($conn,$sqrycst_mst);
			$cntcst_inc	  = mysqli_num_rows($srscst_mst);		  
			$dispstr		  	  = "";		
			if($cntcst_inc > 0){
				$result ="<div class='form-group clearfix'><label class='col-sm-12 control-label'>Blanket PO Details</label></div><table width=\"100%\" cellspacing=\"1\" cellpadding=\"1\" style=\"color:black\" class=\"table table-condensed table-bordered table-striped\">";
				while($srowscst_mst = mysqli_fetch_assoc($srscst_mst)){
					$cstid  = $srowscst_mst['vndrpom_id'];
					$cstnm  = $srowscst_mst['vndrpom_pocde'];			
					$cstpom_prc      =     $srowscst_mst['vndrpom_prc'];
					$cstpom_blnktprc  =     $srowscst_mst['vndrpom_blnktprc'];
					$cstpo_blkd_amnt  =       $srowscst_mst['vndrpo_blkd_amnt'];
					$cstpo_blkd_sts  =       $srowscst_mst['vndrpo_blkd_sts'];

					
					
					$cstpo_blnkrmnprc       =     ($cstpom_blnktprc - $cstpom_prc);
					if($cstpo_blkd_amnt == ""){
						$cstpo_blkd_amnt = 	$cstpo_blnkrmnprc;  
					}else{
						$cstpo_blkd_amnt = 	$cstpo_blkd_amnt;  


					}
					$cstpo_rmnprc = $cstpo_blkd_amnt;
					if(($cstpo_rmnprc > 0)&&(($cstpo_blkd_sts =='a')||($cstpo_blkd_sts ==''))){
					$dispstr .= ","."$cstid:$cstnm";	
				$result .= "<tr><td align=\"left\" width=\"30%\">
							<input type=\"checkbox\" name=\"chksize$cstid\" id=\"chksize$cstid\" value=\"$cstid\"
							onclick= \"chkBlnkt('$cstid')\">
								&nbsp;$cstnm
							</td><td><input type=\"hidden\" name=\"hdnprc$cstid\" id=\"hdnprc$cstid\" value=\"$cstpo_rmnprc\" > 
							$cstpo_rmnprc</td><td><input type=\"text\"  id=\"chkblnkprc$cstid\" name=\"chkblnkprc$cstid\" value=\"\" ></td></tr>";
				}
			}
				$result .="</table>";
				
			}
			echo $result;
		}

/**********************************************/

  	if(isset($_REQUEST['typsrvsid']) && (trim($_REQUEST['typsrvsid']) != "")){

	// creating Drop Down for County
	$result = "";		
	$typsrvsid = glb_func_chkvl($_REQUEST['typsrvsid']);


	

	$sqryqtn_mst1="select 
	vndrtypm_id,vndrtypm_typsrvsm_id,vndrtypm_vndrm_id,vndrm_id,vndrm_name
							from 
							vndrtyp_mst
								inner join vndr_mst on vndr_mst.vndrm_id = vndrtypm_vndrm_id
								inner join typsrvs_mst on typsrvs_mst.typsrvsm_id = vndrtypm_typsrvsm_id
								where
								vndrtypm_typsrvsm_id = $typsrvsid	                  
								";								
//echo $sqryqtn_mst1;;
	$rsts_mst	  = mysqli_query($conn,$sqryqtn_mst1);
	$cntprfsnl_inc	  = mysqli_num_rows($rsts_mst);		  
	$resultloc		  	  = "";		
if($cntprfsnl_inc > 0){
$vndrary = array();
 $sno= 1;
?>
				   
<?php
	 while($rwskists = mysqli_fetch_array($rsts_mst)){
							$stsnm = $rwskists['vndrm_name'];
							$stsid = $rwskists['vndrm_id'];
	?>
<option value="<?php echo $stsid; ?>"><?php echo  $stsnm; ?></option>
<?php
}
			   
			   
			  
}else{
echo "No Vendors";


}
}

/***********Get Project List*******************/
/*Get Customers*/
if(isset($_REQUEST['prjctsts']) && (trim($_REQUEST['prjctsts']) != ""))
{
	// creating Drop Down for County
	$result = "";
	$prjctsts = glb_func_chkvl($_REQUEST['prjctsts']);
	$sqryprfsnl_mst = "select 
							   		max(`prjctm_id`) as prjctm_id,prjctm_nm,prjctm_cde
							  from 
									prjct_mst
							  where
							  prjctm_cstmrm_id = $prjctsts
							  group by prjctm_cde order by prjctm_id desc";								
	// echo $sqryprfsnl_mst;
		$srsprfsnl_mst	  = mysqli_query($conn,$sqryprfsnl_mst);
		$cntprfsnl_inc	  = mysqli_num_rows($srsprfsnl_mst);		  
		$dispstr		  	  = "";		
		if($cntprfsnl_inc > 0){
			?>
	
	<option value disabled selected>Select Project</option>
<?php
    while ($prg = mysqli_fetch_array($srsprfsnl_mst)) {
        ?>
<option value="<?php echo $prg["prjctm_id"]; ?>"><?php echo $prg["prjctm_cde"]; ?></option>
<?php
    }
	}
	
	
		}
		if(isset($_REQUEST['selprodcatid']) && (trim($_REQUEST['selprodcatid']) != "")){

			// creating Drop Down for County
	
			$result = "";		
			$cat_typ ="";
			$arycatid = glb_func_chkvl($_REQUEST['selprodcatid']);
			$catid = explode('-',$arycatid);
			 $sqryprodscat_mst1 =  "SELECT 
										   prodscatm_id,prodscatm_name
									from 
									prodscat_mst
									where 
										prodscatm_sts='a' and 
										prodscatm_prodcatm_id = $catid[0]
								  order by prodscatm_name";								
	
			$srsprodscat_mst1	  = mysqli_query($conn,$sqryprodscat_mst1) or die(mysqli_error($conn));
	
			$cntprodscat_inc	  = mysqli_num_rows($srsprodscat_mst1);		  
	
			$dispstr		  	  = "";		
	
			if($cntprodscat_inc > 0)
			{
				while($srowprodscat_mst = mysqli_fetch_assoc($srsprodscat_mst1)){
					$scatid  = $srowprodscat_mst['prodscatm_id'];
					$scatnm  = $srowprodscat_mst['prodscatm_name'];			
					$dispstr .= ","."$scatid:$scatnm";			
				}
				$result = substr($dispstr,1);		
				//$result =$cat_typ."<->".$result;			
			}
			//$result =$cat_typ."<->".$result1;
			echo $result;
		}

	?>



