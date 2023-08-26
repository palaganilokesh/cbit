<div class="footer-area section-pad-y pb-0" style="background-color: rgba(56, 87, 40, 0.2);">
  <div class="container ">


    <div class="row justify-content-between">
      <?php
      $sqryqklnk_mst = "SELECT prodmnlnksm_id,prodmnlnksm_name,prodcatm_prodmnlnksm_id,prodcatm_id,prodcatm_name,prodcatm_prty,prodcatm_typ,prodmnlnksm_typ,prodmnlnksm_dsplytyp from prodcat_mst
            inner join prodmnlnks_mst on prodmnlnksm_id=prodcatm_prodmnlnksm_id where prodmnlnksm_sts='a' and prodmnlnksm_typ='f'  and prodcatm_sts='a' group by prodmnlnksm_id order by prodmnlnksm_prty asc";

      $srsqklnk_mst = mysqli_query($conn, $sqryqklnk_mst);
      $cntqklnk        = mysqli_num_rows($srsqklnk_mst);
      if ($cntqklnk > 0) {
      ?>

        <div class="col-lg-12 col-md-12 col-12 mt-3 footer-widjet">
          <h3 class="text-capitalize">Quick Links</h3>

          <div class="list ">
            <div class="row">
              <div class="col-lg-12 col-md-12 col-12">
                <ul class="row">
                  <?php
                  while ($srowpqklnk_mst = mysqli_fetch_assoc($srsqklnk_mst)) {
                    $qklnk_name    = $srowpqklnk_mst['prodmnlnksm_name'];
                    $ft_mn_url=funcStrRplc($qklnk_name);
                    $qklnk_id     = $srowpqklnk_mst['prodmnlnksm_id'];
                    $qklnk_typ  = $srowpqklnk_mst['prodmnlnksm_typ'];
                    $qklnk_cattyp = $srowpqklnk_mst['prodcatm_typ'];
                    $qklnk_catid     = $srowpqklnk_mst['prodcatm_id'];
                    $qklnk_catnm     = $srowpqklnk_mst['prodcatm_name'];
                    $ft_cat_url=funcStrRplc($qklnk_catnm);
                    $qklnk_disptype     = $srowpqklnk_mst['prodmnlnksm_dsplytyp'];
                  ?>
                    <li class="col-lg-4 col-md-4 col-6">
                   
                      <a target="_blank" href="<?php echo $rtpth . $ft_mn_url . '/' . $ft_cat_url;?>"><?php echo $qklnk_name; ?></a>
                    </li>


                  <?php } ?>
                </ul>
              </div>


            </div>



          </div>
        </div>
      <?php } ?>


      <div class="col-lg-4 col-12 ">
        <div class="footer-widjet footer-logo-area ">
          <h3>CBIT</h3>
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

          <div class="copyright pt-3 mb-3">
            <div class="row justify-content-center">
              <div class="">
                <div class="social-content ">
                  <ul>
                    <!-- <li><span>Follow Us On</span></li> -->
                    <li>
                      <a href="https://www.facebook.com/CBIThyderabad/" target="_blank"><i class="ri-facebook-fill"></i></a>
                    </li>
                    <li>
                      <a href="https://www.instagram.com/cbithyderabad/" target="_blank"><i class="ri-instagram-line"></i></a>
                    </li>
                    <li>
                      <a href="https://twitter.com/CBIThyd" target="_blank"><i class="ri-twitter-fill"></i></a>
                    </li>

                    <li>
                      <a href="https://www.youtube.com/channel/UCUW8oQB8Fl6j-pg2g_sf1tw" target="_blank"><i class="ri-youtube-fill"></i></a>
                    </li>
                  </ul>
                </div>
              </div>

            </div>
          </div>


          <div class="contact-list">
            <ul>
              <li><a target="_blank" href="https://www.cbit.ac.in/"><strong>Old Website:</strong>
                  https://www.cbit.ac.in/ </a></li>
            </ul>
          </div>




        </div>
      </div>


      <div class="col-lg-8 col-12">
        <div class="footer-widjet">
          <div class="row">


            <div class="col-lg-6 col-md-6 col-6">
              <h3 class="text-capitalize">Student Corner</h3>
              <div class="list ">
                <ul>
                  <li><a target="_blank" href="https://www.cbit.ac.in/current_students/aec_coe/">Academic and
                      Examination Cell</a></li>
                  <li><a target="_blank" href="https://www.aicte-india.org/feedback/students.php">AICTE Feedback
                      Portal (Student)</a></li>
                  <li><a target="_blank" href="https://www.cbit.ac.in/about_post/anti-sexual-harassment-committee/">Anti-Sexual
                      Harassment Committee</a></li>
                  <li><a target="_blank" href="https://www.mycamu.co.in/#/">CAMU Portal for
                      Student</a></li>
                  <li><a target="_blank" href="https://d2n36fr2627nzy.cloudfront.net/">CBIT Course
                      Repository</a></li>
                  <li><a target="_blank" href="https://www.cbit.ac.in/about_post/grievance-redressal-committee-for-students/">Grievance
                      Redressal Committee</a></li>
                  <li><a target="_blank" href="https://www.osmania.ac.in/">Osmania University</a></li>
                  <li><a target="_blank" href="https://swayam.gov.in/">Swayam Education Portal</a>
                  </li>

                </ul>
              </div>
            </div>



            <div class="col-lg-6 col-md-6 col-6">
              <h3 class="text-capitalize">Faculty Corner</h3>
              <div class="list ">
                <ul>
                  <li><a target="_blank" href="https://www.aicte-india.org/feedback/faculty.php">AICTE
                      Feedback Portal (Faculty)</a></li>
                  <li><a target="_blank" href="https://www.aicte-india.org/sites/default/files/list-suggested-books-indian-authors-publishers.pdf">AICTE
                      Recommended Books for Engg</a></li>
                  <li><a target="_blank" href="https://www.camu.in/">CAMU Portal for Faculty</a></li>
                  <li><a target="_blank" href="https://accounts.google.com/signin/v2/identifier?continue=https%3A%2F%2Fmail.google.com%2Fmail%2F&service=mail&hd=cbit.ac.in&sacu=1&flowName=GlifWebSignIn&flowEntry=AddSession">CBIT
                      Faculty Webmail</a></li>
                  <li><a target="_blank" href="https://www.cbit.ac.in/about_post/grievance-redressal-committee-for-staff/">Grievance
                      Redressal Committee for Staff</a></li>
                  <li><a target="_blank" href="https://cbit.hrapp.co/auth">HR App Portal for
                      Faculty</a></li>
                  <li><a target="_blank" href="https://cbit.ac.in/wp-content/uploads/2019/04/Human-Resources-Policy-Manual-2.pdf">HR
                      Policy Manual</a></li>
                  <li><a target="_blank" href="https://www.education.gov.in/ict-initiatives">ICT
                      Initiatives of MoE</a></li>

                </ul>


              </div>
            </div>
          </div>
        </div>
      </div>




    </div>



    <div class="shape ">
      <img src="<?php echo $rtpth; ?>assets/images/shape-1.png " alt="Image ">
    </div>
  </div>
</div>


<div class="copyright-area ">
  <div class="container ">
    <div class="copyright ">
      <div class="row justify-content-center">
        <!-- <div class="col-lg-6 col-md-4 ">
                    <div class="social-content ">
                        <ul>
                            <li><span>Follow Us On</span></li>
                            <li>
                                <a href="https://www.facebook.com/CBIThyderabad/" target="_blank"><i
                                        class="ri-facebook-fill"></i></a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/cbithyderabad/" target="_blank"><i
                                        class="ri-instagram-line"></i></a>
                            </li>
                            <li>
                                <a href="https://twitter.com/CBIThyd" target="_blank"><i
                                        class="ri-twitter-fill"></i></a>
                            </li>

                            <li>
                                <a href="https://www.youtube.com/channel/UCUW8oQB8Fl6j-pg2g_sf1tw" target="_blank"><i
                                        class="ri-youtube-fill"></i></a>
                            </li>
                        </ul>
                    </div>
                </div> -->
        <div class="col-lg-6 col-md-8 ">
          <div class="copy text-center">
            <p class="text-center">©2023 CBIT All rights reserved.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="sticky-icons-1 d-none">
  <div class="social-medias soci-icons">
    <a href="https://www.facebook.com/CBIThyderabad/" target="_blank">
      <img src="assets/images/icon/facebook.png" alt="">
      <p class="socio-name">facebook</p>
    </a>
    <a href="https://www.instagram.com/cbithyderabad/" target="_blank"><img src="<?php echo $rtpth;?>assets/images/icon/instagram.png" alt=""></a>
    <a href="https://twitter.com/CBIThyd" target="_blank"><img src="<?php echo $rtpth;?>assets/images/icon/twitter.png" alt=""></a>

    <a href="https://www.youtube.com/channel/UCUW8oQB8Fl6j-pg2g_sf1tw" target="_blank"><img src="<?php echo $rtpth;?>assets/images/icon/youtube.png" alt=""></a>
    <!-- <a href="#" target="_blank"><img src="assets/images/icon/whatsapp.png" alt=""></a> -->

  </div>

</div>




<div id="fixed-social">
  <div class="social-holder">

    <div class="social-close">
      <button>&#x2715;</button>
    </div>

    <div class="social-link">
      <a href="#" class="fixed-facebook" target="_blank">
        <!-- <span>Facebook</span> -->
        <i class="ri-facebook-fill"></i>
      </a>
    </div>
    <div class="social-link">
      <a href="#" class="fixed-instagrem" target="_blank">
        <!-- <span>Instagram</span> -->
        <i class="ri-instagram-line"></i>
      </a>
    </div>
    <div class="social-link">
      <a href="#" class="fixed-twitter" target="_blank">
        <!-- <span>Twitter</span> -->
        <i class="ri-twitter-fill"></i>
      </a>
    </div>
    <div class="social-link">
      <a href="#" class="fixed-youtube" target="_blank">
        <!-- <span>Youtube</span> -->
        <i class="ri-youtube-fill"></i>
      </a>
    </div>
  </div>

</div>


<div class="go-top ">
  <i class="ri-arrow-up-s-line "></i>
  <i class="ri-arrow-up-s-line "></i>
</div>





<script src="<?php echo $rtpth; ?>assets/js/jquery.min.js "></script>
<script src="<?php echo $rtpth; ?>assets/js/bootstrap.bundle.min.js "></script>
<script src="<?php echo $rtpth; ?>assets/js/jquery.meanmenu.js "></script>
<script src="<?php echo $rtpth; ?>assets/js/owl.carousel.min.js "></script>
<script src="<?php echo $rtpth; ?>assets/js/carousel-thumbs.min.js "></script>
<script src="<?php echo $rtpth; ?>assets/js/jquery.magnific-popup.js "></script>
<script src="<?php echo $rtpth; ?>assets/js/aos.js "></script>
<script src="<?php echo $rtpth; ?>assets/js/odometer.min.js "></script>
<script src="<?php echo $rtpth; ?>assets/js/appear.min.js "></script>
<script src="<?php echo $rtpth; ?>assets/js/form-validator.min.js "></script>
<script src="<?php echo $rtpth; ?>assets/js/contact-form-script.js "></script>
<script src="<?php echo $rtpth; ?>assets/js/ajaxchimp.min.js "></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js " integrity="sha512-2bMhOkE/ACz21dJT8zBOMgMecNxx0d37NND803ExktKiKdSzdwn+L7i9fdccw/3V06gM/DBWKbYmQvKMdAA9Nw==" crossorigin=" anonymous " referrerpolicy="no-referrer "></script>

<script src="https://cdn.rawgit.com/sachinchoolur/lightgallery.js/master/dist/js/lightgallery.js"></script>
<script src="https://cdn.rawgit.com/sachinchoolur/lg-pager.js/master/dist/lg-pager.js"></script>
<script src="https://cdn.rawgit.com/sachinchoolur/lg-autoplay.js/master/dist/lg-autoplay.js"></script>
<script src="https://cdn.rawgit.com/sachinchoolur/lg-share.js/master/dist/lg-share.js"></script>
<script src="https://cdn.rawgit.com/sachinchoolur/lg-fullscreen.js/master/dist/lg-fullscreen.js"></script>
<script src="https://cdn.rawgit.com/sachinchoolur/lg-zoom.js/master/dist/lg-zoom.js"></script>
<script src="https://cdn.rawgit.com/sachinchoolur/lg-hash.js/master/dist/lg-hash.js"></script>
<script src="https://cdn.jsdelivr.net/picturefill/2.3.1/picturefill.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.3.0/plugins/thumbnail/lg-thumbnail.min.js" integrity="sha512-vqSdeetXQGiX1vqQZ+/7J+M1y0JoizcnyVSj0BZ2kZVwmSTFCWxb7QPnILROd/SWUoTrq76XlzvOJFPn49oSlA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="<?php echo $rtpth;?>mega-menu.js"></script>
<script src="<?php echo $rtpth; ?>assets/js/custom.js "></script>

<script>
  $.fn.isInViewport = function() {
    var elementTop = $(this).offset().top;
    var elementBottom = elementTop + $(this).outerHeight();
    var viewportTop = $(window).scrollTop();
    var viewportBottom = viewportTop + $(window).height();
    return elementBottom > viewportTop && elementTop < viewportBottom;
  };
</script>
<script>
function srch() {
  
    txtsrchval2 = document.frmsearch.txtsrchval2.value;
    if (txtsrchval2 == "") {
      alert("Please Enter Search criteria");
      document.frmsearch.txtsrchval2.focus();
      return false;
    }
    if (txtsrchval2 != "") {
      
      var srchid2 = document.frmsearch.txtsrchval2.value;
      var srch2 = srchid2.replaceAll(' ', '-');
      document.frmsearch.action = "<?php echo $rtpth; ?>search-results.php?txtsrchval2=" + srchid2;
      // document.frmsearch.action = "<?php echo $rtpth; ?>search/" + srch ;
      document.frmsearch.submit();
    }
  }
</script>
<script>
  $(window).on('load', function() {
    $("#autoPopupModal").modal('show'); //un comment above 2 lines for popup
  });


</script>


<script>
  $(window).on('load', function() {
    $('.autoPopup-slider').owlCarousel({
      loop: true,
      margin: 10,
      nav: true,
      dots: true,
      thumbs: false,
      autoplay: true,
      smartSpeed: 1000,
      autoplayHoverPause: true,
      navText: ['<i class="fa-solid fa-chevron-left"></i>',
        '<i class="fa-solid fa-chevron-right"></i>',
      ],
      responsive: {
        0: {
          items: 1,
        },
        768: {
          items: 1,
        },
        992: {
          items: 1,
        },
        1200: {
          items: 1,
        },
        1900: {
          items: 1,
        },
      }
    });

  });
</script>

<script>
  $(function() {
    $(".social-close button").click(function() {
      // $("#fixed-social").css({"transform":"translateX(-100%);"}); 
      $("#fixed-social").css('transform', 'translateX(' + -100 + '%)');
    });
  });
</script>



<div class="modal fade" id="searchPopupModal" tabindex="-1" aria-labelledby="searchPopupModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="searchPopupModalLabel">What are you looking for?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          &#x2715;
        </button>
      </div>
      <div class="modal-body">
        <div class="serch-pop">
        <form method="post" name="frmsearch" id="frmsearch" >
            <div class="input-group mb-0">
              <input type="text" class="form-control"name="txtsrchval2" id="txtsrchval2" placeholder="Search here.." aria-label="Recipient's username" aria-describedby="basic-addon2" value="<?php echo $txtsrchval2; ?>"/>
              <span class="input-group-text" id="basic-addon2" onclick="srch()">Go</span>
            </div>
          </form>

        </div>

      </div>
      
    </div>
  </div>
</div>
<!-- <div id='facultyDetailsModal' class='modal fade' role='dialog'>
</div> -->

<?php
$i = 0;
while ($i < sizeof($alm_arr)) {
  $almid = $alm_arr[$i];
  // select query
  $sqryalumni1 = "SELECT alumnim_id,alumnim_name,alumnim_desc,alumnim_imgnm,alumnim_lnk,alumnim_batch,alumnim_job,alumnim_prty,alumnim_sts from  alumni_mst where alumnim_sts='a' and alumnim_id ='$almid'";
  $sqry_alumni_mst1 = mysqli_query($conn, $sqryalumni1);
  $srowalumni_mst1 = mysqli_fetch_assoc($sqry_alumni_mst1);
  $alumniid1 = $srowalumni_mst1['alumnim_id'];
  $alumnittl1 = $srowalumni_mst1['alumnim_name'];
  $alumnidesc1 = $srowalumni_mst1['alumnim_desc'];
  ?>
  <div class="modal fade" id="alumni-<?php echo $alumniid1; ?>PopupModal" tabindex="-1" aria-labelledby="alumni-<?php echo $alumniid1; ?>PopupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="alumni-<?php echo $alumniid1; ?>PopupModalLabel"><?php echo $alumnittl1; ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            &#x2715;
          </button>
        </div>
        <div class="modal-body">
          <div class="alumni-content">
            <p><?php echo $alumnidesc1; ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
  $i++;
}
?>
<?php
$i = 0;
while ($i < sizeof($faclty_arr)) {
  $facid = $faclty_arr[$i];
  // select query
	$sqryfaculty_mst1 = "SELECT faculty_simg,faculty_dtl_id,faculty_dtl_sts,faculty_file,faculty_simgnm,faculty_desc from faculty_dtl where faculty_dtl_id='$facid' ";
	$srsfaclty1 = mysqli_query($conn,$sqryfaculty_mst1) or die(mysqli_error($conn));
	$srowfaclty1 = mysqli_fetch_assoc($srsfaclty1);
	$facid1 = $srowfaclty1['faculty_dtl_id'];
	$facnm1 = $srowfaclty1['faculty_simgnm'];
  $facdesc1 = $srowfaclty1['faculty_desc'];
  
	$faclty_file1    = $srowfaclty1['faculty_file'];
	 $fact_fle_path1      = $u_phtgalfaculty . $faclty_file1;
	if (($faclty_file1 != "") && file_exists($fact_fle_path1)) {
		$facty_file1 = $rtpth . $fact_fle_path1;
	} else {
		$facty_file1   = "no-files found";
	}
  ?>
 <div id="facultyDetailsModal<?php echo $facid1; ?>" class="modal fade" role="dialog">
											<div class="modal-dialog modal-lg">
												
												<div class="modal-content">
													<div class="modal-header">
                          <h4 class="modal-title">
															<?php echo $facnm1; ?>
														</h4>
														<button type="button" class="close" data-bs-dismiss="modal">&times;</button>
														
													</div>
													<div class="modal-body">
                            <p><?php echo $facdesc1;?></p>
                            <?php 
                            if($faclty_file1!=''){
                              ?>
                               <p>	<a href='<?php echo $facty_file1;?>'  target='_blank' >View File</a></p>
                              <?php
                            }
                           ?>
														<!-- <embed src="<?php echo $facty_file1; ?>" frameborder="0" width="100%" height="400px"> -->
													</div>
												</div>
											</div>
										</div>
  <?php
  $i++;
}
?>

<!-- <script>
function facltymodel(facid) {
  
  debugger
  var facid=facid;

  $.ajax({
  		type: "POST",
  		url: "includes/inc_getStsk.php",
  		data:'facmdlid='+facid,
  		success: function(data){
  			// alert(data);
  			$("#faculty").html(data);
        $("#facultyDetailsModal").css("display", "block");
        $("#facultyDetailsModal").addClass( " show" );
  		}
  	});
}


</script>

<div id="faculty"></div> -->











<!-- <script>
$(window).on('load', function() {
    $("#autoPopupModal").modal('show');
});
</script> -->

<script>
  $(".imp-links-text").hover(function() {
    $("#sidebarModal").modal('show');

  });
</script>


</body>

</html>