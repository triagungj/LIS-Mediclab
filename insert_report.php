<?php
include 'config.php';

error_reporting(0);
session_start();

if (isset($_POST['submit'])) {
    $dateReport = $_POST['inputDateReport'];
    $labNumberReport = $_POST['inputLabNumberReport'];
    $regNumberReport = $_POST['inputRegNumberReport'];
    $notaReport = $_POST['inputNotaReport'];
    $nikReport = $_POST['inputNikReport'];
    $nameReport = $_POST['inputNameReport'];
    $birthDayReport = $_POST['inputBirthdayReport'];
    $selectGenderReport = $_POST['selectGenderReport'];
    $addressReport = $_POST['inputAddressReport'];
    $roomReport = $_POST['selectRoomReport'];
    $classReport = $_POST['selectClassReport'];
    $statusReport = $_POST['selectStatusReport'];
    $descClinicReport = $_POST['inputDescClinicReport'];
    $phoneNumberReport = $_POST['inputPhoneNumberReport'];
    $requestDoctorReport = $_POST['inputRequestDoctorReport'];
    $accDoctorReport = $_POST['selectAccDoctorReport'];
    $petugasReport = $_POST['selectPetugasReport'];
    $pesanReport = $_POST['inputPesanReport'];
    $kesanReport = $_POST['inputKesanReport'];
    $sampleReport = $_POST['radioSampleReport'];
    $sampleCategoryReport = $_POST['selectSampleCategoryReport'];
    $notesReport = $_POST['inputNotesReport'];
    $packageReport = $_POST['selectPackageReport'];
    $progressReport = 'process';

    $insertSql = "INSERT INTO report(
        nota, nolab, norm, date_report, nik, name_patient, birthdate, gender,
        address, room, class, status, desc_clinic, phone, reqdoc, accdoc,
        petugas, kesan, pesan, sample, sample_category, notes, paket, progress
    ) VALUES (
        '$notaReport', '$labNumberReport', '$regNumberReport', '$dateReport', '$nikReport', '$nameReport',
        '$birthDayReport', '$selectGenderReport', '$addressReport', '$roomReport', '$classReport', '$statusReport',
        '$descClinicReport', '$phoneNumberReport', '$requestDoctorReport', '$accDoctorReport', '$petugasReport', '$kesanReport',
        '$pesanReport', '$sampleReport', '$sampleCategoryReport', '$notesReport', '$packageReport', '$progressReport'
    )";

    echo " '$notaReport', '$labNumberReport', '$regNumberReport', '$dateReport', '$nikReport', '$nameReport',
        '$birthDayReport', '$selectGenderReport', '$addressReport', '$roomReport', '$classReport', '$statusReport',
        '$descClinicReport', '$phoneNumberReport', '$requestDoctorReport', '$accDoctorReport', '$petugasReport', '$kesanReport',
        '$pesanReport', '$sampleReport', '$sampleCategoryReport', '$notesReport', '$packageReport', '$progressReport'";

    if (mysqli_query($conn, $insertSql)) {
        echo "<script>alert('Success')</script>";
        header("Location: ./add_patient.php");
    } else {
        die("<script>alert(" . mysqli_error($conn) . ")</script>");
        echo "Error: " . $sql . ":-" . mysqli_error($conn);
    }
}
