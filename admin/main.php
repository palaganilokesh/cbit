<?php
include_once '../includes/inc_adm_session.php'; //Check whether the session is created or not
include_once '../includes/inc_nocache.php'; // Clearing the cache information		
include_once '../includes/inc_connection.php'; //Make connection with the database
include_once '../includes/inc_config.php'; //Use function for validation and more	
include_once '../includes/inc_usr_functions.php'; //Use function for validation and more		
//*****************************************//
//Program      : main.php
//Company      : Adroit 	 
//*****************************************//
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title><?php echo $pgtl; ?></title>
    <?php include_once 'script.php'; ?>
</head>

<body>
    <?php
    include_once '../includes/inc_adm_header.php';

    ?>


    <section class="content mt-5">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">

                <h1 class="mt-5 h1 p-5 text-center text-primary">Welcome To <?php echo $pgtl; ?></h1>

            </div>
        </div>
    </section>

    <?php include_once('../includes/inc_adm_footer.php'); ?>
</body>

</html>