<?php
include 'includes/session.php';

if(isset($_POST['total'])){
    $_SESSION['total'] = $_POST['total'];
}
?>
