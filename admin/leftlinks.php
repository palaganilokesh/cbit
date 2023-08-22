
<?php
	include_once ("../includes/inc_adm_session.php");//checking for session	
	include_once ("../includes/inc_usr_functions.php");
	include_once ("../includes/inc_fnct_ajax_validation.php");
?>
<table width="977" border="0" align="center" cellpadding="8" cellspacing="0">
<tr>
 <td >
<link rel="stylesheet" type="text/css" href="docstyle.css">
<script type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<script type="text/javascript" src="jquery-min.js"></script>
<script type="text/javascript" language="javascript">

//=====navigation 1-level or 2-level or 3-level
$(function() {
          if ($.browser.msie && $.browser.version.substr(0,1)<7)
          {
			$('li').has('ul').mouseover(function(){
				$(this).children('ul').show();
				}).mouseout(function(){
				$(this).children('ul').hide();
				})
          }
        });
//=====navigation 1-level or 2-level or 3-level
</script>

<link href="../css/admin_menu.css" rel="stylesheet" type="text/css">
<table width="977"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="35" class="header_bg">
	<ul id="nav">
	<li><a href="main.php">Home</a></li>
	<li><a href="#">Set Up</a>
		<ul>
			<li><a href="view_all_country.php">Country</a></li>
			<li><a href="view_all_county.php">County</a></li>
			<li><a href="view_all_city.php">City</a></li>
  			<li><a href='view_all_ordsts.php'>Order Status</a></li>
			<li><a href='view_all_zone.php'>Zone</a></li>
			<li><a href='view_all_shpchrg.php'>Shipping Charge</a></li>            
		</ul>		
	</li>	
	<li><a href="#">Products</a>
		<ul>
			<li><a href="view_product_category.php">Categories</a></li>
			<li><a href="view_product_subcategory.php">Subcategories </a></li>
			<li><a href="vw_all_banners.php">Banner</a></li>
			<li><a href="view_all_size.php">Size Master</a></li>
			<li><a href="view_all_sizedetails.php">Size Detail</a></li>
			<li><a href='view_all_facility.php'>Facility </a></li>
			<li><a href='view_all_products.php'>Products</a></li>
		</ul>
	</li>	
	<li> <a href='view_all_members.php'>Members</a> </li>
	<!--<li> <a href='view_all_staffs.php'>Staff</a> </li>-->
	<li><a href="#">ORDER MANAGEMENT</a>
		  <?php
			$sqryordsts_mst="select 
			ordstsm_id,ordstsm_name
			from
			ordsts_mst
			where
			ordstsm_sts='a'
			order by ordstsm_prty";
			$srsordsts_mst		= mysqli_query($conn,$sqryordsts_mst);
			$cntrecordsts_mst	= mysqli_num_rows($srsordsts_mst);
			if($cntrecordsts_mst > 0){
				echo "<ul>";
				while($rowordsts_mst=mysqli_fetch_assoc($srsordsts_mst)){
				 $ordstsm_id	= $rowordsts_mst['ordstsm_id'];
				$ordstsm_name	= $rowordsts_mst['ordstsm_name'];
				?>
				  <li><a href='vw_all_orders.php?ststyp=<?php echo $ordstsm_id; ?>'><?php echo $ordstsm_name; ?></a></li>
				  <?php
				}
				echo "</ul>";
			}
			?>
	<li>
		<a href="#">My&nbsp;Account</a>
		<ul>
			<li> <a href="change_password.php">Change Password</a></li>
  			<li> <a href="logout.php">Logout</a></li>
		</ul>
	</li>		
</ul>
</td>
  </tr>
</table>
</td>
  </tr>
</table>
