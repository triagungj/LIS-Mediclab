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
    }
}
