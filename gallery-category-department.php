<?php
$page_title = "Department of Civil Engineering | Chaitanya Bharathi Institute of Technology";
$page_seo_title = "Department of Civil Engineering | Chaitanya Bharathi Institute of Technology";
$db_seokywrd = "";
$db_seodesc = "";
$current_page = "home";
$body_class = "homepage";
include('header.php');
?>

<style>
.section-title h2 {
    font-size: 20px;
}
</style>

<div class="page-banner-area bg-2">

</div>

<section class="page-bread">
    <div class="container-fluid px-lg-3 px-md-3 px-2 py-2">
        <div class="page-banner-content">
            <h1>Department of Civil Engineering</h1>
            <ul>
                <li><a href="<?php echo $rtpth; ?>home">Home</a></li>
                <li>Academics</li>
                <li>Department of Civil Engineering</li>
                <li>Gallery</li>
            </ul>
        </div>
    </div>
</section>




<div class="campus-information-area section-pad-y">
    <!-- <div class="container-fluid px-xxl-5 px-xl-5 px-lg-5 px-md-3 px-3"> -->
    <div class="container-fluid px-lg-3 px-md-3 px-2">
        <div class="row">
            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-12 order-md-1 order-2">
                <!-- <div class="campus-image">
                    <div class="admisssion-area">
                        <div class="container-fluid px-lg-3 px-md-3 px-2">
                            <div class="admission-content">

                                <div class="admission-image">
                                    <img src="assets/images/cbit-yt-vid-thumb.jpg" alt="Image">
                                    <div class="icon">
                                        <a class="popup-youtube play-btn"
                                            href="https://www.youtube.com/watch?v=RptoHi3UxGA"><i
                                                class="ri-play-fill"></i></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div> -->


                <div class="campus-content pr-20 ">


                <?php include_once('gallery-cat-include.php'); ?>
                    

   
                </div>
            </div>

            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-12 order-md-2 order-1 ">


                <div class="about-us-sideLinks">
                    <!-- <h4 class="common-sm-heading mb-3">Departments</h4> -->
                    <div class="faq-left-content ">
                        <div class="accordion" id="academicsLinks">

                            <div class="accordion-item item-custom-1">
                                <h2 class="accordion-header " id="heading-2">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#singleDepartment" aria-expanded="false"
                                        aria-controls="singleDepartment">
                                        Department of Civil Engineering
                                    </button>
                                </h2>
                                <div id="singleDepartment" class="accordion-collapse collapse"
                                    aria-labelledby="heading-2" data-bs-parent="#academicsLinks">
                                    <div class="accordion-body py-3 ug-links">
                                        <ul class="links-lists p-0 m-0">
                                            <li>
                                                <p><a href="#">Eligibility</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">Fees & Financial Assistance</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">Facts & Figures</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">HOD Message</a></p>
                                            </li>
                                            <li>
                                                <p><a href="faculty.php">Faculty</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">Board of Studies</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">Departmental Committees</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">Announcements</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">MoUs</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">Syllabus</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">Open Electives</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">Time Tables</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">UG with Honours</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">Additional</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">Minor Engineering</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">Infrastructure</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">Internships</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">Research</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">Events</a></p>
                                            </li>
                                        </ul>

                                    </div>
                                </div>
                            </div>



                            <div class="accordion-item">
                                <h2 class="accordion-header " id="heading-2">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#allDepartment" aria-expanded="false"
                                        aria-controls="allDepartment">
                                        Other Departments
                                    </button>
                                </h2>
                                <div id="allDepartment" class="accordion-collapse collapse" aria-labelledby="heading-2"
                                    data-bs-parent="#academicsLinks">
                                    <div class="accordion-body py-3 ug-links">
                                        <ul class="links-lists p-0 m-0">
                                            <li>
                                                <p><a href="#">Department of Mechanical Engineering</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">Department of Electrical and Electronics Engineering</a>
                                                </p>
                                            </li>
                                            <li>
                                                <p><a href="#">Department of Electronics and Communications
                                                        Engineering</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">Department of Computer Science and Engineering</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">Department of Artificial Intelligence and Machine
                                                        Learning (AI&ML)</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">Department of Computer Engineering and Technology</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">Department of Information Technology</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">Department of Artificial Intelligence and Data
                                                        Science</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">Department of Chemical Engineering</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">Department of Biotechnology</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">Department of Physics</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">Department of Chemistry</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">Department of Mathematics</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">Department of English</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">Department of MCA</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">School of Management Studies</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#">Department of Physical Education</a></p>
                                            </li>
                                        </ul>

                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>


            </div>






        </div>



    </div>
</div>


<?php include_once('footer.php'); ?>