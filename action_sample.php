<?php

include 'config.php';

if (isset($_GET['nota'])) {
    $nota = $_GET['nota'];
    $resultSampleSql = "SELECT * FROM sample WHERE nota='$nota'";
    $resultSample = mysqli_query($conn, $resultSampleSql);
    $row = mysqli_fetch_assoc($resultSample);
    $kd_sample = $row['kd_sample'];

    if (isset($_POST['save_sample'])) {
        $sub_sample_sql = "SELECT * FROM sub_sample WHERE kd_sample = '$kd_sample'";
        $row_sub_sample = mysqli_query($conn, $sub_sample_sql);
        foreach ($row_sub_sample as $data) :
            $input = 'input' . $data['kd_sub_category_sample'];
            $update_sub_sample_sql = "UPDATE sub_sample SET value='$_POST[$input]' 
                WHERE kd_sub_category_sample='$data[kd_sub_category_sample]' AND kd_sample = '$kd_sample'";
            mysqli_query($conn, $update_sub_sample_sql);
        endforeach;
        header("Location: ./add_patient.php?nota=$nota");
    } else if (isset($_POST['finish_sample'])) {
        $dateNow = date("Y-m-d H:i:s");
        $resultReportSql = "UPDATE report SET date_finish='$dateNow' WHERE nota='$nota'";
        if (mysqli_query($conn, $resultReportSql)) {
            header("Location: ./add_patient.php?nota=$nota");
        }
    } else if (isset($_POST['transmit_sample'])) {
        $transmitReportSql = "UPDATE report SET transmit='1' WHERE nota='$nota'";
        if (mysqli_query($conn, $transmitReportSql)) {
            header("Location: ./add_patient.php?nota=$nota");
        }
    }
}
