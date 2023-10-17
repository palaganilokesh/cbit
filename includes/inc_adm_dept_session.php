<?php
	session_start();
  if( $ses_admtyp=='d'){
    ?>
      <script language="javascript">
        location.href = "../admin/index.php";
      </script>
    <?php
      exit();
  }