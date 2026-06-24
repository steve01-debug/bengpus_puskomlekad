<?php
session_start();
session_destroy();
header('Location: ../entering.php');
exit;
?>
