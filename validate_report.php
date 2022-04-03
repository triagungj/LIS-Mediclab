<?php
include 'config.php';

error_reporting(0);

session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
    }
} else {
    header("Location: ./");
}

if (isset($_GET['nota'])) {
    $edit = true;
    $nota = $_GET['nota'];
    $resultReport = "SELECT * FROM report WHERE nota='$nota'";
    $resultReportArray = mysqli_query($conn, $resultReport);

    if ($resultReportArray->num_rows > 0) {
        $resultReport = mysqli_fetch_assoc($resultReportArray);

        $docString = $resultReport['accdoc'];
        $accDocSql = "SELECT * FROM users WHERE username='$docString'";
        $accDocArray = mysqli_query($conn, $accDocSql);
        $accDoc = mysqli_fetch_assoc($accDocArray);
        $accDocName = $accDoc['name'];

        $petugasString = $resultReport['petugas'];
        $petugasSql = "SELECT * FROM users WHERE username='$petugasString'";
        $petugasArray = mysqli_query($conn, $petugasSql);
        $petugas = mysqli_fetch_assoc($petugasArray);
        $petugasName = $petugas['name'];
    } else {
        header("Location: worklist_finish.php");
    }
}



?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="css/style-main.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <title>Mediclab - Validator Report</title>
</head>

<body>
    <div class="header bg-primary mb-4">
        <div class="container d-flex justify-content-between pt-4 pb-2">
            <a href="./">
                <h3 class="text-light"><b>MEDICLAB</b></h3>
            </a>
            <div class="d-flex align-items-center">
                <h5 class="mr-4 text-light text-name">Selamat datang, <?= $name ?></h5>
                <div style="min-width:40px"></div>
                <a href="logout.php"><button class="btn btn-light">Logout</button></a>
            </div>
        </div>
    </div>

    <div class="ps-4 pe-4">
        <div class="bg-surface p-3 rounded-top border">
            <div class="row align-items-center">
                <div class="col-6 col-lg-9">
                    <h6>Data Pasien</h6>
                    <div class="d-inline">
                        <button type="button" class="btn btn-primary mt-2">Hide</button>
                        <button type="button" class="btn btn-primary mt-2">Show</button>
                        <button type="button" class="btn btn-primary mt-2">Order</button>
                        <a href="./worklist_finish.php"><button type="button" class="btn btn-primary mt-2">Back</button></a>
                    </div>
                </div>
                <?php if ($resultReport['date_finish'] != null && $resultReport['date_acc'] == null) { ?>
                    <div class="col-6 col-lg-3 align-items-center d-flex">
                        <div class="me-2">
                            <img src="assets/check_circle_black_24dp.svg" alt="check" class="icon-check">
                        </div>
                        <div>
                            <h4 class="text-success"><u>FINISH</u></h4>
                            <p class="text-success">
                                <b><?= $resultReport['date_finish']; ?></b>
                                <?php if ($resultReport['transmit'] == 1) echo 'TRANSMITTED' ?> <br />
                            </p>
                        </div>
                    </div>
                <?php } else if ($resultReport['date_acc'] != null) { ?>
                    <div class="col-6 col-lg-3 align-items-center d-flex">
                        <div class="me-2">
                            <img src="assets/check_circle_black_24dp.svg" alt="check" class="icon-check">
                        </div>
                        <div>
                            <h2 class="text-success"><u>ACC</u></h2>
                            <p class="text-success"><b><?= $resultReport['date_acc']; ?></b></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="border p-3">
            <div class="row table-responsive">
                <div class="col-12 col-md-6">
                    <div class="row align-items-center mb-1">
                        <div class="col-2 text-end text-end">
                            <label for="inputDateReport" class="col-form-label">Tanggal :</label>
                        </div>
                        <div class="col-4">
                            <b><?= $resultReport['date_report']; ?></b>
                        </div>
                        <div class="col-2 text-end">
                            <label for="inputLabNumberReport" class="col-form-label">No. Lab :</label>
                        </div>
                        <div class="col-4">
                            <b><?= $resultReport['nolab']; ?></b>
                        </div>
                    </div>
                    <div class="row align-items-center mb-1">
                        <div class="col-2 text-end">
                            <label for="inputRegNumberReport" class="col-form-label">No. RM :</label>
                        </div>
                        <div class="col-4">
                            <b><?= $resultReport['norm']; ?></b>
                        </div>
                        <div class="col-2 text-end">
                            <label for="inputNotaReport" class="col-form-label">Nota :</label>
                        </div>
                        <div class="col-4">
                            <b><?= $resultReport['nota']; ?></b>
                        </div>
                    </div>
                    <div class="row align-items-center mb-1">
                        <div class="col-2 text-end">
                            <label for="inputNikReport" class="col-form-label">NIK :</label>
                        </div>
                        <div class="col-10">
                            <b><?= $resultReport['nik']; ?></b>
                        </div>
                    </div>
                    <div class="row align-items-center mb-1">
                        <div class="col-2 text-end">
                            <label for="inputNameReport" class="col-form-label">Nama :</label>
                        </div>
                        <div class="col-10">
                            <b><?= $resultReport['name_patient']; ?></b>
                        </div>
                    </div>
                    <div class="row align-items-center mb-1">
                        <div class="col-2 text-end">
                            <label for="birthDayReport" class="col-form-label">Tgl. Lahir :</label>
                        </div>
                        <div class="col-4">
                            <b id="birthdate"><?= date('j F, Y', strtotime($resultReport['birthdate'])); ?></b>
                        </div>
                        <div class="col-4 text-end">
                            <label for="selectGenderReport" class="col-form-label">Jenis Kelamin :</label>
                        </div>
                        <div class="col-2">
                            <b><?= $resultReport['gender']; ?></b>

                        </div>
                    </div>
                    <div class="row align-items-center mb-1">
                        <div class="col-2 text-end">
                            <label class="col-form-label">Umur :</label>
                        </div>
                        <div class="col-3">
                            <span class="col-form-label ms-1"><span id="yearAge"></span> Tahun</span>
                        </div>
                        <div class="col-3">
                            <span class="col-form-label ms-1"><span id="monthAge"></span> Bulan</span>

                        </div>
                        <div class="col-4">
                            <span class="col-form-label ms-1"><span id="dayAge"></span> Hari</span>

                        </div>
                    </div>
                    <div class="row align-items-center mb-1">
                        <div class="col-2 text-end">
                            <label for="inputAddressReport" class="col-form-label">Alamat :</label>
                        </div>
                        <div class="col-10">
                            <b><?= $resultReport['address']; ?></b>
                        </div>
                    </div>
                    <div class="row align-items-center mb-1">
                        <div class="col-2 text-end">
                            <label for="selectRoomReport" class="col-form-label">Ruang :</label>
                        </div>
                        <div class="col-3">
                            <b><?= $resultReport['room']; ?></b>
                        </div>
                        <div class="col-3 d-flex align-items-center">
                            <label for="selectClassReport" class="col-form-label me-2">Kelas:</label>
                            <b><?= $resultReport['class']; ?></b>
                        </div>
                        <div class="col-4 d-flex align-items-center">
                            <label for="selectStatusReport" class="col-form-label me-2">Status:</label>
                            <b><?= strtoupper($resultReport['status']); ?></b>
                        </div>
                    </div>
                    <div class="row align-items-center mb-1">
                        <div class="col-2 text-end">
                            <label for="inputDescClinicReport" class="col-form-label">Ket Klinik :</label>
                        </div>
                        <div class="col-10">
                            <b><?= $resultReport['desc_clinic']; ?></b>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-2 text-end">
                            <label for="inputPhoneNumberReport" class="col-form-label">No. HP :</label>
                        </div>
                        <div class="col-10">
                            <b><?= $resultReport['phone']; ?></b>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="row align-items-center mb-1">
                        <div class="col-4 text-end">
                            <label for="inputRequestDoctorReport" class="col-form-label">Dokter Pengirim :</label>
                        </div>
                        <div class="col-8">
                            <b><?= $resultReport['reqdoc']; ?></b>
                        </div>
                    </div>
                    <div class="row align-items-center mb-1">
                        <div class="col-4 text-end">
                            <label for="selectAccDoctorReport" class="col-form-label">Dokter ACC :</label>
                        </div>
                        <div class="col-8">
                            <b><?= $accDocName; ?></b>
                        </div>
                    </div>
                    <div class="row align-items-center mb-1">
                        <div class="col-4 text-end">
                            <label for="selectPetugasReport" class="col-form-label">Petugas :</label>
                        </div>
                        <div class="col-8">
                            <b><?= $petugasName; ?></b>
                        </div>
                    </div>
                    <div class="row align-items-center mb-1">
                        <div class="col-4 text-end">
                            <label for="inputPesanReport" class="col-form-label">Pesan :</label>
                        </div>
                        <div class="col-8">
                            <b><?= $resultReport['pesan']; ?></b>
                        </div>
                    </div>
                    <div class="row align-items-center mb-1">
                        <div class="col-4 text-end">
                            <label for="inputKesanReport" class="col-form-label">Kesan :</label>
                        </div>
                        <div class="col-8">
                            <b><?= $resultReport['kesan']; ?></b>
                        </div>
                    </div>
                    <div class="row align-items-center mb-1">
                        <div class="col-4 text-end">
                            <label for="samplePatient" class="col-form-label">Sample :</label>
                        </div>
                        <div class="col-8 d-flex">
                            <b><?= ucwords($resultReport['sample']); ?></b>
                        </div>
                    </div>
                    <div class="row align-items-center mb-1">
                        <div class="col-4 text-end">
                            <label for="selectSampleCategoryReport" class="col-form-label">Jenis Sample :</label>
                        </div>
                        <div class="col-8">
                            <b><?= ucwords($resultReport['sample_category']); ?></b>
                        </div>
                    </div>
                    <div class="row align-items-center mb-1">
                        <div class="col-4 text-end">
                            <label for="inputNotesReport" class="form-label">Catatan :</label>
                        </div>
                        <div class="col-8">
                            <b><?= $resultReport['notes']; ?></b>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-4 text-end">
                            <label for="selectPackageReport" class="form-label">Paket :</label>
                        </div>
                        <div class="col-8">
                            <b><?= $resultReport['paket']; ?></b>
                        </div>
                    </div>
                </div>
                <div class="col-12 align-items-center mt-4 mb-4 text-center">
                    <form method="POST" action="acc_report.php?nota=<?= $nota; ?>">
                        <button type="submit" name="acc_report" class="btn btn-success align-items-center p-3">
                            <img src="assets/check_circle_black_24dp.svg" alt="check" class="filter-white">
                            <span class="align-middle">ACC</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

<script>
    <?php if ($resultReport['birthdate'] != null) { ?>
        var birthdateResult = "<?= $resultReport['birthdate']; ?>";
        var today = new Date();
        var birthday = new Date(birthdateResult);

        var yearNow = today.getFullYear();
        var monthNow = today.getMonth();
        var dateNow = today.getDate();

        var yearBirth = birthday.getFullYear();
        var monthBirth = birthday.getMonth();
        var dateBirth = birthday.getDate();

        if (dateNow >= dateBirth) {
            document.getElementById("dayAge").innerHTML = (dateNow - dateBirth);
        } else {
            monthBirth--;
            document.getElementById("dayAge").innerHTML = 31 + dateNow - dateBirth;

            if (monthBirth < 0) {
                monthBirth = 11;
                yearBirth--;
                document.getElementById("dayAge").innerHTML = (dateNow - dateBirth + 30);
            }

        }
        if (monthNow > monthBirth) {
            document.getElementById("monthAge").innerHTML = (monthNow - monthBirth);
        } else if (monthNow < monthBirth) {
            yearNow = yearNow - 1;
            document.getElementById("monthAge").innerHTML = (monthNow - monthBirth + 12);
        } else {
            yearNow = yearNow - 1;
            document.getElementById("monthAge").innerHTML = (monthNow - monthBirth + 11);
        }

        document.getElementById("yearAge").innerHTML = yearNow - yearBirth;
    <?php } ?>
</script>

</html>