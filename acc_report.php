<?php
include 'config.php';
if (isset($_POST['acc_report']) && isset($_GET['nota'])) {
    $nota = $_GET['nota'];
    $dateNow = date("Y-m-d H:i:s");
    $accReportSql = "UPDATE report SET date_acc='$dateNow' WHERE nota='$nota'";
    if (mysqli_query($conn, $accReportSql)) {
        header("Location: ./worklist_finish.php");
    }
}
