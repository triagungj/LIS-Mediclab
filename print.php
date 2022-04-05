<?php
include 'config.php';
if (isset($_GET['nota'])) {
    $sampleSql = "SELECT * FROM sub_sample 
    LEFT JOIN sample on sub_sample.kd_sample = sample.kd_sample
    LEFT JOIN sub_category_sample on sub_sample.kd_sub_category_sample = sub_category_sample.kd_sub_category
    WHERE nota = '$_GET[nota]'";

    $patientSql = "SELECT * FROM report WHERE nota ='$_GET[nota]'";

    $resultSample = mysqli_query($conn, $sampleSql);
    $resultPatient = mysqli_query($conn, $patientSql);
    $dataPatient = mysqli_fetch_assoc($resultPatient);
    if ($dataPatient['date_acc'] == null) {
        header("Location: ./");
    }
}
