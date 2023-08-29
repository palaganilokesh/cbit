<?php
error_reporting(0);
// include_once "includes/inc_usr_sessions.php";
include_once 'includes/inc_connection.php';
include_once 'includes/inc_usr_functions.php'; //Use function for validation and more
include_once "includes/inc_folder_path.php";
$page_title = "Error | Chaitanya Bharathi Institute of Technology";
$page_seo_title = "Error | Chaitanya Bharathi Institute of Technology";
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
        <h3 class="page__title mt-20">Error</h3>
			<ul>
				<li><a href="<?php echo $rtpth; ?>home">Home</a></li>
                <li><span>Error</span></li>
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
                <div class="text-center py-4 px-2" style="background-color: rgba(226, 76, 75, 0.18);">
                    <img src="<?php echo $rtpth;?>assets/images/icon/error.png" width="60px" class="mb-2" alt="">
                    <div class="section__wrapper mb-2">
                        <h4 class="section__title ms-0">Oops !</h4>
                    </div>
                    <p style="text-align:center ;">An error occurred during your submission.</p>

                    <div class="ab-button mb-0">
                        <a href="<?php echo $rtpth; ?>contact-us" class="tp-btn">Try once again</a>
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>
<!-- about__area end -->

<br>
<br>




<?php include_once('footer.php'); ?>