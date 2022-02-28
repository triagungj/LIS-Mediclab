<?php

$server = "localhost";
$user = "phpadmin";
$pass = "root";
$database = "mediclab";

$conn = mysqli_connect($server, $user, $pass, $database);

if (!$conn) {
    die("<script>alert('Gagal tersambung dengan database.')</script>");
}
