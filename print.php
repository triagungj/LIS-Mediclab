<!DOCTYPE html>
<?php
include 'config.php';
if (isset($_GET['nota'])) {
    $sampleSql = "SELECT * FROM sub_sample 
    LEFT JOIN sample on sub_sample.kd_sample = sample.kd_sample
    LEFT JOIN sub_category_sample on sub_sample.kd_sub_category_sample = sub_category_sample.kd_sub_category
    WHERE nota = '$_GET[nota]'";

    $patientSql = "SELECT * FROM report LEFT JOIN room ON report.room=room.room_kd WHERE nota ='$_GET[nota]'";

    $resultSample = mysqli_query($conn, $sampleSql);
    $resultPatient = mysqli_query($conn, $patientSql);
    $dataPatient = mysqli_fetch_assoc($resultPatient);
    if ($dataPatient['date_acc'] == null) {
        header("Location: ./");
    }
    $docString = $dataPatient['accdoc'];
    $accDocSql = "SELECT * FROM users WHERE username='$docString'";
    $accDocArray = mysqli_query($conn, $accDocSql);
    $accDoc = mysqli_fetch_assoc($accDocArray);
    $accDocName = $accDoc['name'];

    $petugasString = $dataPatient['petugas'];
    $petugasSql = "SELECT * FROM users WHERE username='$petugasString'";
    $petugasArray = mysqli_query($conn, $petugasSql);
    $petugas = mysqli_fetch_assoc($petugasArray);
    $petugasName = $petugas['name'];
}
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style-main.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <title>Mediclab - PRINT</title>
</head>

<body>
    <div class="container print-page">
        <div class="row align-items-center header">
            <div class="col-2">
                <img src="assets/rsud.png" alt="img-rsud" class="img-fluid">
            </div>
            <div class="col-10 text-center pt-2">
                <div>
                    <h6 class="text-headline">PEMERINTAH KABUPATEN KULONPROGO</h6>
                    <h6 class="text-headline">RUMAH SAKIT DAERAH UMUM WATES</h6>
                    <h6 class="text-headline">INSTALASI LABORATORIUM PATOLOGI KLINIK</h6>
                    <div class="m-0 text-address">
                        JL. Tentara Pelajar Km. 1 No. 5 Wates Kulon Progo Yogyakarta 55651
                    </div>
                    <div class="m-0 text-address">
                        Telp. (0274) 773169 Fax. (0274) 773092, email: rsud@kulonprogokab.go.id
                    </div>
                </div>
            </div>
        </div>
        <div class="section-patient">
            <table class="patient-table">
                <tbody>
                    <tr>
                        <td class="align-top" width="50%">
                            <div class="row">
                                <div class="col-5">No. Med. Rec</div>
                                <div class="col-1">:</div>
                                <div class="col-6"><?= $dataPatient['nolab'] ?></div>
                            </div>
                            <div class="row">
                                <div class="col-5">Nama</div>
                                <div class="col-1">:</div>
                                <div class="col-6"><?= $dataPatient['name_patient'] ?></div>
                            </div>
                            <div class="row">
                                <div class="col-5">Ruang</div>
                                <div class="col-1">:</div>
                                <div class="col-6"><?= $dataPatient['room_name'] ?></div>
                            </div>
                            <div class="row">
                                <div class="col-5">Ket. Klinik</div>
                                <div class="col-1">:</div>
                                <div class="col-6"><?= $dataPatient['desc_clinic'] ?></div>
                            </div>
                            <div class="row">
                                <div class="col-5">Jenis Kelamin</div>
                                <div class="col-1">:</div>
                                <div class="col-6"><?= $dataPatient['gender'] ?></div>
                            </div>
                        </td>
                        <td class="align-top" width="50%">
                            <div class="row">
                                <div class="col-5">No. Med. Rec</div>
                                <div class="col-1">:</div>
                                <div class="col-6"><?= $dataPatient['nolab'] ?></div>
                            </div>
                            <div class="row">
                                <div class="col-5">Tanggal Lahir</div>
                                <div class="col-1">:</div>
                                <div class="col-6">
                                    <?= $dataPatient['birthdate'] ?> /
                                    <span id="yearBirth"></span> Th,
                                    <span id="monthBirth"></span> Bl,
                                    <span id="dateBirth"></span> Hr
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">Dokter</div>
                                <div class="col-1">:</div>
                                <div class="col-6"><?= $dataPatient['reqdoc'] ?></div>
                            </div>
                            <div class="row">
                                <div class="col-5">Tanggal</div>
                                <div class="col-1">:</div>
                                <div class="col-6"><?= $dataPatient['date_acc'] ?></div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="section-sample">
            <h6 class="text-headline">HASIL PEMERIKSAAN</h6>
            <span>Sample: <b class="text-primary"><?= ucwords($dataPatient['sample_category']); ?></b></span>
            <table class="table-sample">
                <thead>
                    <th>JENIS PEMERIKSAAN</th>
                    <th>HASIL</th>
                    <th>N. RUJUKAN</th>
                    <th>FLAG</th>
                    <th>SATUAN</th>
                    <th>METODE</th>
                </thead>
                <?php foreach ($resultSample as $sampleData) : ?>
                    <tbody>
                        <td class="ps-4"><?= $sampleData['name'] ?></td>
                        <td class="text-center"><?= $sampleData['value'] ?></td>
                        <td class="text-center"><?= $sampleData['min_value'] . ' - ' . $sampleData['max_value'] ?></td>
                        <td class="text-center <?php if ($sampleData['flag'] != 'normal') echo 'text-danger text-bold'; ?>">
                            <?php if ($sampleData['flag'] != 'normal') echo strtoupper($sampleData['flag']); ?>
                        </td>
                        <td class="text-center"><?= $sampleData['satuan'] ?></td>
                        <td class="text-center"><?= $sampleData['metode'] ?></td>
                    </tbody>
                <?php endforeach; ?>
            </table>
            <div class="mt-4 kesan">
                <b>Kesan :</b>
                <br>
                <span><?= $dataPatient['kesan']; ?></span>
            </div>
            <table>
                <tbody>
                    <tr>
                        <td width="50%">
                            <span class="text-nb">NB: Bila ada keraguan Hasil Pemeriksaan, Mohon menghubungi Laboratorium RSUD Wates. Telp. (0274) 773169 ext 1146</span>
                            <div class="text-center signature">
                                <p>Dokter Penanggung Jawab</p>
                                <div class="blank-section"></div>
                                <p>(<?= $accDocName; ?>)</p>
                            </div>
                        </td>
                        <td width="50%" class="align-bottom">
                            <div class="text-center signature">
                                <span>ACC:</span>
                                <p>
                                    Tanggal: <?= $dataPatient['date_acc']; ?>
                                    <br>
                                    Diperiksa Oleh,
                                </p>
                                <div class="blank-section"></div>
                                <p>(<?= $petugasName; ?>)</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</body>

<script>
    var today = new Date('<?= $dataPatient['date_acc'] ?>');
    var birthday = new Date('<?= $dataPatient['birthdate']; ?>');

    var yearNow = today.getFullYear();
    var monthNow = today.getMonth();
    var dateNow = today.getDate();

    var yearBirth = birthday.getFullYear();
    var monthBirth = birthday.getMonth();
    var dateBirth = birthday.getDate();

    if (dateNow >= dateBirth) {
        document.getElementById("dateBirth").innerHTML = (dateNow - dateBirth);
    } else {
        monthBirth--;

        document.getElementById("dateBirth").innerHTML = 31 + dateNow - dateBirth;

        if (monthBirth < 0) {
            monthBirth = 11;
            yearBirth--;
        }
        document.getElementById("dateBirth").innerHTML = (dateNow - dateBirth + 30);

    }
    if (monthNow >= monthBirth) {
        document.getElementById("monthBirth").innerHTML = (monthNow - monthBirth);
    } else {
        yearNow = yearNow - 1;
        document.getElementById("monthBirth").innerHTML = (monthNow - monthBirth + 12);
    }

    document.getElementById("yearBirth").innerHTML = yearNow - yearBirth;

    window.onload = window.print;
</script>

</html>