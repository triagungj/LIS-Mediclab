<?php
include '../config.php';

error_reporting(0);

session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $rowUser['jabatan'] = mysqli_fetch_assoc($result);
        $name = $rowUser['jabatan']['name'];
    }
} else {
    header("Location: ./");
}

$catSampleSql = "SELECT * FROM  category_sample";
$catSampleResult = mysqli_query($conn, $catSampleSql);

$roomSql = "SELECT * FROM room";
$resultRoom = mysqli_query($conn, $roomSql);

$diffInSeconds = 0;
if (isset($_POST['date_from']) && isset($_POST['date_to']) && isset($_POST['cat_sample']) && isset($_POST['room']) && isset($_POST['range'])) {
    $dateFrom = $_POST['date_from'];
    $dateTo = $_POST['date_to'];
    $catSample = $_POST['cat_sample'];
    $room = $_POST['room'];
    $range = $_POST['range'];

    $dateToTime = dayIncrement($dateTo);

    $sqlReport = "SELECT * FROM report WHERE 
        sample_category='$catSample' AND room LIKE '%$room%' 
        AND date_report >= '$dateFrom' AND date_report <= '$dateToTime'
        AND date_acc IS NOT NULL
        ORDER BY nota DESC limit $range";
    $resultReport = mysqli_query($conn, $sqlReport);
} else {
    $dateFrom = date('Y-m-d');
    $dateTo = date('Y-m-d');
    $sqlReport = "SELECT * FROM report LEFT JOIN room ON report.room=room.room_kd 
        WHERE date_acc IS NOT NULL ORDER BY nota DESC";
    $resultReport = mysqli_query($conn, $sqlReport);
}
$totalData = mysqli_num_rows($resultReport);
foreach ($resultReport as $dataReport) {
    $reportDate = strtotime($dataReport['date_report']);
    $finishDate = strtotime($dataReport['date_finish']);
    $dateTimeObject1 = date_create($dataReport['date_report']);
    $dateTimeObject2 = date_create($dataReport['date_finish']);

    $diffInSeconds += $dateTimeObject2->getTimestamp() - $dateTimeObject1->getTimestamp();
}
$averageSeconds = $diffInSeconds / $totalData;
$averageTime =
    sprintf('%02d:%02d:%02d', ($averageSeconds / 3600), ($averageSeconds / 60 % 60), $averageSeconds % 60);

function dayIncrement($date)
{
    $date1 = str_replace('-', '/', $date);
    $tomorrow = date('Y-m-d', strtotime($date1 . "+1 days"));
    return $tomorrow;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/style-main.css" rel="stylesheet">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <title>Report TAT - Mediclab</title>
</head>

<body>
    <div class="header bg-primary pb-2">
        <marquee>
            <h6 class="mt-2 text-light text-name-responsive">Selamat datang, <?= $name ?>.</h6>
        </marquee>
        <div class="container d-flex justify-content-between">
            <a href="../">
                <h3 class="text-light"><b>MEDICLAB</b></h3>
            </a>
            <div class="d-flex align-items-center">
                <a href="logout.php"><button class="btn btn-light">Logout</button></a>
            </div>
        </div>
    </div>


    <div class="row ms-2 me-2">
        <div class="col-md-3 mt-4">
            <div class="rounded-top border">
                <div class="bg-surface p-2 mb-2">
                    Jenis Laporan
                </div>
                <div class="d-inline">
                    <a href="./report-tat.php" class="decoration-none">
                        <div class="p-4 d-flex report-selected">
                            <img src="../assets/bar_chart_black_24dp.svg" alt="configuration">
                            <span class="align-middle ms-2">Laporan TAT</span>
                        </div>
                    </a>
                    <a href="./report-kritis.php" class="decoration-none">
                        <div class="p-4 d-flex">
                            <img src="../assets/bar_chart_black_24dp.svg" alt="configuration">
                            <span class="align-middle ms-2">Laporan Kritis</span>
                        </div>
                    </a>
                    <a href="./report-pemeriksaan.php" class="decoration-none">
                        <div class="p-4 d-flex">
                            <img src="../assets/bar_chart_black_24dp.svg" alt="configuration">
                            <span class="align-middle ms-2">Jumlah Pemeriksaan</span>
                        </div>
                    </a>
                </div>
            </div>

        </div>
        <div class="col-md-9 mt-4 mb-4">
            <div class="rounded-top border m-0">
                <div class="bg-surface p-2 text-center">
                    Laporan TAT
                </div>
            </div>
            <div class="border">
                <form method="POST" action="report-tat.php" class="mb-2">
                    <div class="row ps-2 pe-2">
                        <div class="col-6 col-lg-3 mt-3 d-flex align-items-center">
                            <div class="input-group input-group-default">
                                <span class="input-group-text">Dari</span>
                                <input required value="<?= $_POST['date_from']; ?>" name="date_from" type="date" class="form-control" id="inlineFormInputGroupDate" placeholder="Tanggal">
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 mt-3">
                            <div class="input-group input-group-default">
                                <span class="input-group-text">Sampai</span>
                                <input required value="<?= $_POST['date_to']; ?>" name="date_to" type="date" class="form-control" id="inlineFormInputGroupDate" placeholder="Tanggal">
                            </div>
                        </div>

                        <div class="col-6 col-lg-2 mt-3">
                            <select name="cat_sample" id="catSample" class="form-select" required>
                                <option hidden value="">Category</option>
                                <?php foreach ($catSampleResult as $dataCatSample) : ?>
                                    <option value="<?= $dataCatSample['kd_category']; ?>" <?php if ($_POST['cat_sample'] == $dataCatSample['kd_category']) echo 'selected' ?>>
                                        <?= $dataCatSample['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-6 col-lg-2 mt-3">
                            <input value="<?= $_POST['room']; ?>" name="room" type="text" class="form-control" id="inlineFormInputGroupRoom" placeholder="Ruang">
                        </div>
                        <div class="col-6 col-lg-1 mt-3">
                            <input required value="<?= $_POST['range']; ?>" name="range" type="text" class="form-control" id="inlineFormInputGroupRoom" placeholder="Jumlah">
                        </div>
                        <div class="col-6 col-lg-1 mt-3">
                            <input required value="Cari" type="submit" name="search" class="btn btn-primary w-100" />
                        </div>
                    </div>

                </form>

                <?php if ($totalData == 0) { ?>
                    <div class="d-flex align-items-center ps-3 pe-3" style="min-height:300px">
                        <div class="box w-100 text-center">
                            <img src="../assets/folder_off_black_24dp.svg" alt="empty" class="img-empty">
                            <h3 class="mt-2">Data tidak ditemukan</h3>
                        </div>
                    </div>

                <?php } else { ?>
                    <div class="ms-4 mt-4">
                        <p>
                            <?php if (isset($_POST['search'])) { ?>
                                Index tanggal: <b><?= $dateFrom; ?></b> s/d <b><?= $dateTo; ?></b>
                            <?php } ?>
                            Total Pasien: <b><?= $totalData; ?></b> Pasien (Rata-rata Pemeriksaan <b><?= $averageTime; ?></b>)
                        </p>
                    </div>
                    <div class="ms-3 me-3 table-responsive-lg">
                        <div style="min-height: 400px;">
                            <table class=" table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center" width="5%">No</th>
                                        <th scope="col" class="text-center" width="14%">Tanggal</th>
                                        <th scope="col" class="text-center" width="20%">Nama</th>
                                        <th scope="col" class="text-center" width="7%">No RM</th>
                                        <th scope="col" class="text-center" width="7%">Daftar</th>
                                        <th scope="col" class="text-center" width="7%">Selesai</th>
                                        <th scope="col" class="text-center" width="7%">TAT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $number = 1; ?>
                                    <?php foreach ($resultReport as $dataReport) : ?>
                                        <tr onclick="onClickTable('<?= $dataReport['nota']; ?>')">
                                            <?php
                                            $reportDate = strtotime($dataReport['date_report']);
                                            $finishDate = strtotime($dataReport['date_finish']);
                                            $dateTimeObject1 = date_create($dataReport['date_report']);
                                            $dateTimeObject2 = date_create($dataReport['date_finish']);

                                            $difference = date_diff($dateTimeObject1, $dateTimeObject2);
                                            ?>
                                            <td class="text-center"><?= $number ?></td>
                                            <td class="text-center"><?= date('Y-m-d', $reportDate); ?></td>
                                            <td><?= $dataReport['name_patient']; ?></td>
                                            <td class="text-center"><?= $dataReport['norm']; ?></td>
                                            <td class="text-center"><?= date('H:i:s', $reportDate); ?></td>
                                            <td class="text-center"><?= date('H:i:s', $finishDate); ?></td>
                                            <td class="text-center"><?= $difference->format('%H:%I:%S'); ?></td>
                                        </tr>
                                        <?php $number++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
</body>
<script>
    function onClickTable(nota) {
        var jabatan = '<?= $rowUser['jabatan']; ?>';

        if (jabatan == 'validator') {
            window.location.href = '../validate_report.php?nota=' + nota;
        } else {
            window.location.href = '../add_patient.php?nota=' + nota;
        }
    }
</script>

</html>