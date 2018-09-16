<?php

session_start();
unset($_SESSION['email']);
unset($_SESSION['group_id']);
session_destroy();
header("location: index.php");

?>
<footer>
    <?php include('includes/footer.php')?>
</footer>