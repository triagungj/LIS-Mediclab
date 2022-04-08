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
    $resultReport = "SELECT * FROM report LEFT JOIN room ON report.room = room.room_kd WHERE nota='$nota'";
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

    $subSampleSql = "SELECT * FROM sub_sample 
    LEFT JOIN sample on sub_sample.kd_sample = sample.kd_sample
    LEFT JOIN sub_category_sample on sub_sample.kd_sub_category_sample = sub_category_sample.kd_sub_category
    WHERE nota = '$nota'";

    $resultSample = mysqli_query($conn, $subSampleSql);
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
    <div class="header bg-primary pb-2">
        <marquee>
            <h6 class="mt-2 text-light text-name-responsive">Selamat datang, <?= $name ?>.</h6>
        </marquee>
        <div class="container d-flex justify-content-between">
            <a href="./">
                <h3 class="text-light"><b>MEDICLAB</b></h3>
            </a>
            <div class="d-flex align-items-center">
                <div class="mr-4 text-light text-name text-end">
                    <h6 class="m-0">Selamat datang,</h6>
                    <h5><?= $name ?></h5>
                </div>
                <div style="min-width:20px"></div>
                <a href="logout.php"><button class="btn btn-light">Logout</button></a>
            </div>
        </div>
    </div>

    <div class="ps-4 pe-4 mt-2">
        <div class="bg-surface p-3 rounded-top border">
            <div class="row align-items-center">
                <div class="col-12 col-md-5 ">
                    <h6>Data Pasien</h6>
                    <div class="d-flex align-middle">
                        <a href="./worklist_finish.php" class="btn btn-primary mt-2">Back</a>
                        <button type="button" class="btn btn-primary mt-2 ms-2" onclick="onHide()">Hide</button>
                        <button type="button" class="btn btn-primary mt-2 ms-2" onclick="onShow()">Show</button>
                        <?php if ($resultReport['date_acc'] == null) { ?>
                            <form method="POST" action="acc_report.php?nota=<?= $nota; ?>">
                                <button type="submit" name="acc_report" class="btn btn-success align-items-center mt-2 ms-2">
                                    <img src="assets/check_circle_black_24dp.svg" alt="check" class="filter-white">
                                    <span class="align-middle">ACC</span>
                                </button>
                            </form>
                        <?php } ?>
                        <?php if ($resultReport['date_acc'] != null) { ?>
                            <a href="print.php?nota=<?= $resultReport['nota']; ?>" target="_blank" class="btn btn-info mt-2 ms-2">
                                Print
                            </a>
                        <?php } ?>
                    </div>


                </div>
                <?php if ($resultReport['date_finish'] != null && $resultReport['date_acc'] == null) { ?>
                    <div class="col-12 col-md-7 d-flex justify-content-end mt-2">
                        <div class="me-2">
                            <img src="assets/check_circle_black_24dp.svg" alt="check" class="icon-check">
                        </div>
                        <div>
                            <h4 class="text-success"><u>FINISH</u></h4>
                            <p class="text-success">
                                <b><?= $resultReport['date_finish']; ?></b><br>
                                <?php if ($resultReport['transmit'] == 1) echo 'TRANSMITTED' ?> <br />
                            </p>
                        </div>
                    </div>
                <?php } else if ($resultReport['date_acc'] != null) { ?>
                    <div class="col-12 col-md-7 d-flex justify-content-end mt-2">
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
        <div class="border p-3" id="patientSection">
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
                            <span class="col-form-label ms-1 text-bold"><span id="yearAge"></span> Tahun</span>
                        </div>
                        <div class="col-3">
                            <span class="col-form-label ms-1 text-bold"><span id="monthAge"></span> Bulan</span>

                        </div>
                        <div class="col-4">
                            <span class="col-form-label ms-1 text-bold"><span id="dayAge"></span> Hari</span>

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
                            <b><?= $resultReport['room_name']; ?></b>
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
            </div>
        </div>
        <div class="bg-surface p-4 border d-flex">
            <h5 class="me-auto ms-auto text-bold">Hasil Pemeriksaan</h5>
        </div>
        <div class="table-responsive-lg">
            <table class="table table-bordered border-dark table-input-sample">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col" class="text-center">Pemeriksaan</th>
                        <th scope="col" class="text-center">Hasil</th>
                        <th scope="col" class="text-center">Flag</th>
                        <th scope="col" class="text-center">Rujukan</th>
                        <th scope="col" class="text-center">Satuan</th>
                        <th scope="col" class="text-center">Metode</th>
                    </tr>
                </thead>
                <?php $count = 1; ?>
                <?php foreach ($resultSample as $sampleData) : ?>
                    <tbody>
                        <td class="text-center"><?= $count; ?></td>
                        <td><?= $sampleData['name']; ?></td>
                        <td class="text-center">
                            <?= $sampleData['value']; ?>
                        </td>
                        <td class="text-center">
                            <span class="<?php if ($sampleData['flag'] != 'normal') echo 'text-danger text-bold'; ?>">
                                <?= strtoupper($sampleData['flag']) ?>
                            </span>
                        </td>
                        <td class="text-center"><?php echo $sampleData['min_value'] . ' - ' . $sampleData['max_value']; ?></td>
                        <td class="text-center"><?= $sampleData['satuan']; ?></td>
                        <td class="text-center"><?php if ($sampleData['metode'] == null) {
                                                    echo '-';
                                                } else {
                                                    echo $sampleData['metode'];
                                                } ?> </td>
                    </tbody>
                    <?php $count++; ?>
                <?php endforeach; ?>
            </table>
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

    function onHide() {
        document.getElementById('patientSection').classList.add('d-none');
    }

    function onShow() {
        document.getElementById('patientSection').classList.remove('d-none');
    }
</script>

</html>