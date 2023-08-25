<?php
error_reporting(0);
session_start();
include_once 'includes/inc_config.php'; //Making paging validation	
include_once 'includes/inc_connection.php'; //Making database Connection
include_once 'includes/inc_usr_functions.php'; //checking for session	
//include_once 'includes/inc_usr_sessions.php';
include_once 'includes/inc_folder_path.php';
$page_title = "Departments | Chaitanya Bharathi Institute of Technology";
$page_seo_title = "Departments | Chaitanya Bharathi Institute of Technology";
$db_seokywrd = "";
$db_seodesc = "";
$current_page = "home";
$body_class = "homepage";
include('header.php');
?>

<style>
	.filter-button {
		padding-bottom: 10px;
		padding: 11px 25px;
		font-weight: 600;
		border: none;
		border-radius: 0;
		font-size: 15px;
		line-height: 1.3;
		margin-bottom: 0px;
		-webkit-transition: all ease .5s;
		transition: all ease .5s;
		letter-spacing: 2px;
		font-family: 'helvetica_neue_lt_std55_roman';
		text-transform: uppercase;
		font-weight: 600;
		background-color: rgba(153, 30, 32, 0.1);
		color: rgba(153, 30, 32, 1);
		margin-right: 8px;



	}

	.filter-button:hover {
		color: #fff !important;
		background-color: rgba(153, 30, 32, 1) !important;
	}

	.filt-buttons a.active {
		color: #fff !important;
		background-color: rgba(153, 30, 32, 1) !important;
	}
</style>

<div class="page-banner-area bg-2">
</div>
<section class="page-bread">
	<div class="container-fluid px-lg-3 px-md-3 px-2">
		<div class="page-banner-content">
			<h1>Departments</h1>
			<ul>
				<li><a href="<?php echo $rtpth; ?>home">Home</a></li>
				<li>Departments</li>
			</ul>
		</div>
	</div>
</section>
<?php
$sqry_dept = "SELECT prodmnlnksm_id,prodmnlnksm_name,prodmnlnksm_desc,prodmnlnksm_bnrimg,prodmnlnksm_typ,prodmnlnksm_dsplytyp,prodmnlnksm_prty,prodmnlnksm_sts,prodcatm_id,prodcatm_admtyp,prodcatm_prodmnlnksm_id,prodcatm_id,prodcatm_name,prodcatm_desc,prodcatm_bnrimg,prodcatm_icn,prodcatm_dsplytyp,prodcatm_typ,prodcatm_sts,prodcatm_prty,prodscatm_id,prodscatm_name
 from  prodmnlnks_mst
 inner join  prodcat_mst on prodcatm_prodmnlnksm_id = prodmnlnksm_id
 inner join prodscat_mst on prodscatm_prodcatm_id = prodcatm_id
 where prodmnlnksm_id !='' and prodmnlnksm_sts ='a' and prodmnlnksm_sts = 'a' and prodcatm_sts='a'  and prodmnlnksm_name='Departments' group by prodcatm_id";

//  ,prodscatm_id,prodscatm_name,prodscatm_desc,prodscatm_bnrimg,prodscatm_dpttitle,prodscatm_dpthead,prodscatm_dptname,prodscatm_sts,prodscatm_prodcatm_id,prodscatm_prodmnlnksm_id,prodscatm_prty
//  left join prodscat_mst on prodscatm_prodcatm_id = prodcatm_id
//  and prodscatm_sts='a'
// group by prodcatm_id
$sqry_dept_mst = mysqli_query($conn, $sqry_dept);
$dept_cnt = mysqli_num_rows($sqry_dept_mst);
if ($dept_cnt > 0) {
?>
	<div class="academic-area section-pad-y">
		<div class="container-fluid px-lg-3 px-md-3 px-2">
			<div class="">

				<div class="mb-2 filt-buttons">
					<a class="btn btn-default filter-button active" data-filter="all">All</a>
					<a class="btn btn-default filter-button" data-filter="UG">UG</a>
					<a class="btn btn-default filter-button" data-filter="PG">PG</a>

				</div>
				<br />

				<div class="row">
					<?php
					while ($srowdept_mst = mysqli_fetch_assoc($sqry_dept_mst)) {
						$deptid = $srowdept_mst['prodmnlnksm_id'];
						$deptmnnm = $srowdept_mst['prodmnlnksm_name'];
						$d_mnl_url=funcStrRplc($deptmnnm);
						$d_catid= $srowdept_mst['prodcatm_id'];
						$d_scatid = $srowdept_mst['prodscatm_id'];
						$deptnm = $srowdept_mst['prodcatm_name']; //sub category department title 
						$d_cat_url=funcStrRplc($deptnm);
						$depttyp = $srowdept_mst['prodcatm_admtyp'];
						$d_sctnm= $srowdept_mst['prodscatm_name'];
						$d_scat_url=funcStrRplc($d_sctnm);
						$deptimgnm = $srowdept_mst['prodcatm_icn'];
						$deptimg = $u_cat_icnfldnm . $deptimgnm;
						// $imgpath = $gusrbrnd_upldpth . $imgnm;
						if (($deptimgnm != "")) {
							
							$deptimgpth = $rtpth . $deptimg;
						} else {
							$deptimgpth   = $rtpth.$u_cat_bnrfldnm.'default.jpg';
						}
					?>

						<div class="col-lg-3 col-md-4 col-6 filter <?php echo $depttyp; ?>">
							<div class="single-courses-card style2 ">
								<div class="courses-img ">
									<a href="<?php echo $rtpth . $d_mnl_url . '/' . $d_cat_url.'/'.$d_scat_url; ?>"><img src="<?php echo 	$deptimgpth; ?>" alt="Image "></a>
								</div>
								<div class="courses-content ">
									<a href="<?php echo $rtpth . $d_mnl_url . '/' . $d_cat_url.'/'.$d_scat_url; ?>">
										<h3><?php echo  $deptnm; ?></h3>
									</a>
									
									<a href="<?php echo $rtpth . $d_mnl_url . '/' . $d_cat_url.'/'.$d_scat_url; ?>" class="read-more-btn ">Read more<i class="flaticon-next "></i></a>
								</div>
							</div>
						</div>
					<?php } ?>

				</div>



			</div>
		</div>
	</div>

<?php } ?>


<?php include_once('footer.php'); ?>

<script>
	$(document).ready(function() {

		$(".filter-button").click(function() {
			var value = $(this).attr('data-filter');

			if (value == "all") {

				$('.filter').show('1000');
			} else {

				$(".filter").not('.' + value).hide('1000');
				$('.filter').filter('.' + value).show('1000');

			}
		});



	});
</script>

<script>
	$(".filter-button").click(function() {
		$(this).toggleClass("active");
		$(this).siblings().removeClass('active');
	});
</script>