<?php

$server = "localhost";
$user = "phpadmin";
$pass = "root";
$database = "mediclab";

// $user = "lismedic_root";
// $pass = "l1smedicLab";
// $database = "lismedic_mediclab";

$conn = mysqli_connect($server, $user, $pass, $database);

if (!$conn) {
    die("<script>alert('Gagal tersambung dengan database.')</script>");
}
