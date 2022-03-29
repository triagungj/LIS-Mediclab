<?php
include 'config.php';

error_reporting(0);
session_start();

if (isset($_GET['nota'])) {
    $nota = $_GET['nota'];
    $sqlDelete = "DELETE FROM report WHERE nota = '$nota'";
    if (mysqli_query($conn, $sqlDelete)) {
        echo "<script>alert('Success')</script>";
        header("Location: ./worklist.php");
    } else {
        die("<script>alert(" . mysqli_error($conn) . ")</script>");
        echo "Error: " . $insertSql . ":-" . mysqli_error($conn);
    }
}
