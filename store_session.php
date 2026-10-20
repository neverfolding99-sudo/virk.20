<?php
session_start();
if (isset($_POST['cvr']) && isset($_POST['company'])) {
    $_SESSION['cvr_number'] = $_POST['cvr'];
    $_SESSION['company_name'] = $_POST['company'];
}
?>
