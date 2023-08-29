<?php
error_reporting(0);
// include_once "includes/inc_usr_sessions.php";
include_once 'includes/inc_connection.php';
include_once 'includes/inc_usr_functions.php'; //Use function for validation and more
include_once "includes/inc_folder_path.php";
$page_title = "Thankyou | Chaitanya Bharathi Institute of Technology";
$page_seo_title = "Thankyou | Chaitanya Bharathi Institute of Technology";
$db_seokywrd = "";
$db_seodesc = "";
$current_page = "home";
$body_class = "homepage";
include('header.php');

?>

<div class="page-banner-area bg-2">
</div>
<section class="page-bread">
	<div class="container-fluid px-lg-3 px-md-3 px-2 py-2">
		<div class="page-banner-content">
        <h3 class="page__title mt-20">Thankyou</h3>
			<ul>
				<li><a href="<?php echo $rtpth; ?>home">Home</a></li>
                <li><span>Thankyou</span></li>
			</ul>
		</div>
       
	</div>
</section>
<br>
<br>

<!-- about__area start -->
<section class="about__area-2 pt-90 pb-90">
    <div class="container">
        <div class="row align-items-center justify-content-center">



            <div class="col-xl-6 col-lg-6 col-md-6 col-11">
                <div class="text-center py-4 px-2" style="background-color: rgba(62, 182, 85, 0.18);">
                    <img src="<?php echo $rtpth;?>assets/images/icon/thankyou.png" width="60px" class="mb-2" alt="">
                    <div class="section__wrapper mb-2">
                        <h4 class="section__title ms-0">Thankyou for Enquiry</h4>
                    </div>
                    <p  style="text-align:center ;">Your enquiry has been sent successfully. We will get back to you soon.</p>

                    <div class="ab-button mb-0">
                        <a href="<?php echo $rtpth; ?>home" class="tp-btn">Go to Homepage</a>
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>
<br>
<br>
<!-- about__area end -->






<?php include_once('footer.php'); ?>