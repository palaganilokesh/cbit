<?php
error_reporting(0);
// include_once "includes/inc_usr_sessions.php";
include_once 'includes/inc_connection.php';
include_once 'includes/inc_usr_functions.php'; //Use function for validation and more
include_once "includes/inc_folder_path.php";
include_once 'includes/inc_paging_functions.php'; //Making paging validation
$page_title = "Contact Us | Chaitanya Bharathi Institute of Technology";
$page_seo_title = "Contact Us | Chaitanya Bharathi Institute of Technology";
$db_seokywrd = "";
$db_seodesc = "";
$current_page = "home";
$body_class = "homepage";
include('header.php');
if (isset($_POST['btnenq']) && ($_POST['btnenq'] != "") && isset($_POST['txtname']) && ($_POST['txtname'] != "") &&
	isset($_POST['txtemail']) && ($_POST['txtemail'] != "")
) {
	 include_once "database/iqry_enqry_mst.php";
}
?>
<script language="javascript" src="includes/yav.js"></script>
<script language="javascript" src="includes/yav-config.js"></script>
<script language="javascript" type="text/javascript">
var rules_1 = new Array();

rules_1[0] = 'txtname:Name|required|Enter Name';
rules_1[1] = 'txtemail:Email|required|Enter email id';
rules_1[2] = 'txtphone:Phone|required|Enter Phone Number';
rules_1[3] = 'txtphone:Phone|numeric|Enter Only Numbers';
rules_1[4] = 'txtsubject:subject|required|Enter Subject Name';
rules_1[5] = 'txtemail:Email|email|Enter  valid email id';
rules_1[6] = 'txtmessage:message|required|Enter Message';
function setfocus() {
    document.getElementById('txtname').focus();
}
function frmenq(){
	debugger
	document.getElementById("frmenqstd").submit();
}
</script>
?>


<div class="page-banner-area bg-2">

</div>

<section class="page-bread">
	<div class="container-fluid px-lg-3 px-md-3 px-2 py-2">
		<div class="page-banner-content">
			<h1>Contact Us</h1>
			<ul>
				<li><a href="<?php echo $rtpth; ?>home">Home</a></li>
				<li>Contact Us</li>
			</ul>
		</div>
	</div>
</section>


<div class="contact-us-area section-pad-y pb-0">
	<div class="container-fluid px-lg-3 px-md-3 px-2">

		<div class="row justify-content-between">

			<div class="col-lg-4 col-12 ">
				<div class="footer-widjet mb-0 footer-logo-area ">
					<h3>Contact Us</h3>
					<div class="contact-list ">
						<ul>
							<li><a href="#">Chaitanya Bharathi Institute of Technology, Gandipet, Hyderabad, Telangana -
									500075</a></li>
							<li><a href="tel:040-24193276"><strong>Phone:</strong> 040-24193276 </a></li>
							<li><a href="tel:8466997201"><strong>Mobile:</strong> 8466997201</a></li>
							<li><a href="tel:8466997216"><strong>For Admissions Enquiry:</strong> 8466997216</a>
							</li>
							<li><a href="mailto:principal@cbit.ac.in"><strong>Email:</strong>
									principal@cbit.ac.in</a></li>
						</ul>
					</div>


				</div>
			</div>


			<div class="col-lg-8 col-12">
				<div class="footer-widjet mb-0">
					<h3>Locate Us</h3>
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d121837.20479863774!2d78.17936111640623!3d17.391973500000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bcb94eba8ad7c87%3A0xb78f51ed556f7cc5!2sChaitanya%20Bharathi%20Institute%20of%20Technology!5e0!3m2!1sen!2sin!4v1681294800433!5m2!1sen!2sin" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

				</div>
			</div>



		</div>

		<!-- <div class="contact-and-address">
            <div class="contact-and-address-content">
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <div class="contact-card">
                            <div class="icon">
                                <i class="ri-map-pin-line"></i>
                            </div>
                            <h4>Address</h4>
                            <p>Chaitanya Bharathi Institute of Technology, Gandipet, Hyderabad, T.S India, PIN-500075
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="contact-card">
                            <div class="icon">
                                <i class="ri-phone-line"></i>
                            </div>
                            <h4>Call Us</h4>
                            <p>Phone: <a href="tel:+91-040-24193276">+91-040-24193276</a></p>
                            <p>Principal: <a href="tel:040-24193276">040-24193276</a></p>
                            <p>For Admissions Enquiry: <a href="tel:8466997216">8466997216</a></p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="contact-card">
                            <div class="icon">
                                <i class="ri-mail-line"></i>
                            </div>
                            <h4>Mail Us</h4>
                            <p>Email: <a href="mailto:principal@cbit.ac.in">principal@cbit.ac.in</a></p>

                        </div>
                    </div>

                </div>
            </div>


        </div> -->


	</div>
</div>

<div class="contact-us-area section-pad-y ">
	<div class="container-fluid px-lg-3 px-md-3 px-2">
		<div class="row align-items-stretch">
			<div class="col-lg-4">

				<div class="contact-and-address mt-lg-0 mt-md-0 mt-3 h-100">
					<img src="assets/images/contact-us-form.jpg" class="w-100 h-100" alt="">
				</div>
			</div>
			<div class="col-lg-8">
				<div class="contacts-form h-100">
					<div class="footer-widjet mb-0">
						<h3>Enquire</h3>
					</div>

					<form name="frmenqstd" id="frmenqstd" method="post" action="" onSubmit="return performCheck('frmenqstd', rules_1, 'inline');">
						<div class="row">
							<div class="col-lg-6 col-sm-6">
								<div class="form-group">
									<input type="text" name="txtname" id="txtname" class="form-control" placeholder="Name">
									<span id="errorsDiv_txtname" style="color:red"></span>
								</div>
							</div>
							<div class="col-lg-6 col-sm-6">
								<div class="form-group">
									<input type="text" name="txtemail" id="txtemail" class="form-control" placeholder="Email" >
									<span id="errorsDiv_txtemail" style="color:red"></span>
								</div>
							</div>
							<div class="col-lg-6 col-sm-6">
								<div class="form-group">
									<input type="text" name="txtphone" id="txtphone"  placeholder="Phone Number" class="form-control">
									<span id="errorsDiv_txtphone" style="color:red"></span>
								</div>
							</div>
							<div class="col-lg-6 col-sm-6">
								<div class="form-group">
									<input type="text" name="txtsubject" id="txtsubject" class="form-control"  placeholder="Subject">
									<span id="errorsDiv_txtsubject" style="color:red"></span>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group">
									<textarea name="txtmessage" class="form-control" id="txtmessage" rows="4" placeholder="Message"></textarea>
									<span id="errorsDiv_txtmessage" style="color:red"></span>
								</div>
							</div>

							<div class="red-btn mb-lg-0 mb-md-0 mb-2 ">
								<!-- <a href="#" class="default-btn btn w-100 "  name="btnenq" id="btnenq" onclick="frmenq()" >Send <i class="flaticon-paper-plane"></i></a> -->
						<input type="submit" class="default-btn btn w-100 "	name="btnenq" id="btnenq" value="Send">
								<!-- <button class="default-btn btn w-100 "	name="btnenq" id="btnenq">Send <i class="flaticon-paper-plane"></i></button> -->
                                                </div>
								<!-- onclick="document.getElementById('frmenq').submit(); return false;" -->
								<!-- javascript:$('frmenqstd').submit(); -->
							</div>
						</div>
					</form>
				</div>
			</div>

		</div>
	</div>
</div>



<?php include_once('footer.php'); ?>