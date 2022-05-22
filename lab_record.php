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

$range = 15;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$first_page = ($page > 1) ? ($page * $range) - $range : 0;

$previous = $page - 1;
$next = $page + 1;

if (isset($_GET['date']) && isset($_GET['norm']) && isset($_GET['name_patient']) && isset($_GET['room'])) {
    $date = $_GET['date'];
    $norm = $_GET['norm'];
    $name_patient = $_GET['name_patient'];
    $room = $_GET['room'];
    $sqlReport = "SELECT * FROM report LEFT JOIN room ON report.room=room.room_kd 
        WHERE name_patient LIKE '%$name_patient%' AND date_report LIKE '$date%'
        AND norm LIKE '%$norm%' AND room LIKE '%$room%' ORDER BY nota DESC limit $first_page, $range";
    $resultReport = mysqli_query($conn, $sqlReport);
    $totalDataSql = "SELECT * FROM report LEFT JOIN room ON report.room=room.room_kd 
        WHERE name_patient LIKE '%$name_patient%' AND date_report LIKE '$date%'
        AND norm LIKE '%$norm%' AND room LIKE '%$room%' ORDER BY nota DESC";
    $totalDataQuery = mysqli_query($conn, $totalDataSql);
    $total_data = mysqli_num_rows($totalDataQuery);
    $total_page = ceil($total_data / $range);
} else {
    $sqlReport = "SELECT * FROM report LEFT JOIN room ON report.room=room.room_kd ORDER BY nota DESC limit $first_page, $range";
    $resultReport = mysqli_query($conn, $sqlReport);
    $totalDataSql = "SELECT nota FROM report";
    $totalDataQuery = mysqli_query($conn, $totalDataSql);
    $total_data = mysqli_num_rows($totalDataQuery);
    $total_page = ceil($total_data / $range);
}

if (isset($_GET['selected'])) {
    $selected = $_GET['selected'];
    $selectedSql = "SELECT * FROM report LEFT JOIN room ON report.room=room.room_kd WHERE nolab = '$selected'";
    $selectedResult = mysqli_query($conn, $selectedSql);
    $selectedRow = mysqli_fetch_assoc($selectedResult);
    $selectedNota = $selectedRow['nota'];
} else {
    $selectedRow = mysqli_fetch_assoc($resultReport);
    $selectedNota = $selectedRow['nota'];
}

$subSampleSql = "SELECT * FROM sub_sample 
    LEFT JOIN sample on sub_sample.kd_sample = sample.kd_sample
    LEFT JOIN sub_category_sample on sub_sample.kd_sub_category_sample = sub_category_sample.kd_sub_category
    WHERE nota = '$selectedNota'";

$resultSample = mysqli_query($conn, $subSampleSql);

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style-main.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <title>Lab Record - Mediclab</title>
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
    <div class="ps-3 px-4">
        <form method="GET" class="row mt-2 ">
            <div class="col-10 row pt-3">
                <div class="col-6 col-lg-4">
                    <div class="input-group input-group-default mb-3">
                        <span class="input-group-text">Tanggal</span>
                        <input value="<?= $_GET['date']; ?>" name="date" type="date" class="form-control" id="inlineFormInputGroupDate" placeholder="Tanggal">
                    </div>
                </div>

                <div class="col-6 col-lg-2">
                    <div class="input-group input-group-default mb-3">
                        <span class="input-group-text">No. RM</span>
                        <input value="<?= $_GET['norm']; ?>" name="norm" type="text" class="form-control" id="inlineFormInputGroupRegistNumber" placeholder="No. RM">
                    </div>
                </div>

                <div class="col-6 col-lg-3">
                    <div class="input-group input-group-default mb-3">
                        <span class="input-group-text">Nama</span>
                        <input value="<?= $_GET['name_patient']; ?>" name="name_patient" type="text" class="form-control" id="inlineFormInputGroupName" placeholder="Nama">
                    </div>
                </div>

                <div class="col-6 col-lg-3">
                    <div class="input-group input-group-default mb-3">
                        <span class="input-group-text">Ruang</span>
                        <input value="<?= $_GET['room']; ?>" name="room" type="text" class="form-control" id="inlineFormInputGroupRoom" placeholder="Ruang">
                    </div>
                </div>
            </div>
            <input value="<?= isset($_GET['search']) ? $_GET['page'] : 1; ?>" name="page" type="text" class="form-control d-none" id="inlineFormInputGroupRoom">

            <div class="col-2 col">
                <input type="submit" value="Cari" class="btn btn-primary mt-3" />
            </div>

        </form>
    </div>
    <hr>
    <?php if ($total_data == 0) { ?>
        <div class="d-flex align-items-center ps-3 pe-3" style="min-height:300px">
            <div class="box w-100 text-center">
                <img src="assets/folder_off_black_24dp.svg" alt="empty" class="img-empty">
                <h3 class="mt-2">Data tidak ditemukan</h3>
            </div>
        </div>

    <?php } else { ?>
        <div class="row ms-2 me-2 mt-2">
            <div class="col-md-6">
                <div class="table-responsive-md border rounded-top">
                    <div class="bg-surface p-2">
                        <span>Daftar Pasien</span>
                    </div>
                    <div class="ms-2 me-2 mt-2" style="min-height: 400px;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" scope="col" width="10%">No</th>
                                    <th class="text-center" scope="col">Tanggal</th>
                                    <th class="text-center" scope="col">Nama</th>
                                    <th class="text-center" scope="col">No. RM</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 1 + $first_page; ?>
                                <?php foreach ($resultReport as $dataReport) : ?>
                                    <tr class="<?= ($selectedRow['nolab'] == $dataReport['nolab']) ? "bg-surface" : ''; ?>" onclick="onClickTable(<?= $dataReport['nolab']; ?>)">
                                        <td class="text-center"><?= $number ?></td>
                                        <td class="text-center"><?= date('Y-m-d', strtotime($dataReport['date_report'])); ?></td>
                                        <td><?= $dataReport['name_patient']; ?></td>
                                        <td class="text-center"><?= $dataReport['norm']; ?> (<?= $dataReport['nolab']; ?>)</td>
                                    </tr>
                                    <?php $number++ ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <ul class="pagination justify-content-center mt-2">
                        <li class="page-item me-2">
                            <a class="btn btn-info" <?php if ($page > 1) {
                                                        echo "href='?date=$_GET[date]&norm=$_GET[norm]&name_patient=$_GET[name_patient]&room=$_GET[room]&page=$previous'";
                                                    } ?>>
                                Previous
                            </a>
                        </li>
                        <?php
                        for ($x = 1; $x <= $total_page; $x++) {
                        ?>
                            <li class="page-item me-2 ms-2"><a class="btn <?php if ($x != $page) {
                                                                                echo 'btn-primary';
                                                                            } else {
                                                                                echo 'btn-danger';
                                                                            } ?>" href="<?php echo "?date=$_GET[date]&norm=$_GET[norm]&name_patient=$_GET[name_patient]&room=$_GET[room]&page=$x"; ?>">
                                    <?php echo $x; ?>
                                </a></li>
                        <?php
                        }
                        ?>
                        <li class="page-item ms-2">
                            <a class="btn btn-info" <?php if ($page < $total_page) {
                                                        echo "href='?date=$_GET[date]&norm=$_GET[norm]&name_patient=$_GET[name_patient]&room=$_GET[room]&page=$next'";
                                                    } ?>>Next</a>
                        </li>
                    </ul>

                </div>
            </div>
            <div class="col-md-6 pe-2 ps-2">
                <div id="tableRecord" class="rounded-top border">
                    <div class="bg-surface p-2 justify-content-between d-flex align-items-center">
                        <span>Daftar Pasien</span>
                        <?php if ($selectedRow['date_acc'] != null) { ?>
                            <a href="print.php?nota=<?= $selectedRow['nota']; ?>" target="_blank" class="btn btn-primary me-4">PRINT</a>
                        <?php } ?>
                    </div>
                    <div class="mt-2 ps-2 row table-responsive-md ">
                        <div class="col-xl-6 col-sm-12 col-md-12">
                            <div class="row">
                                <div class="col-2">Nama</div>
                                <div class="col-1">:</div>
                                <div class="col-9"><?= $selectedRow['name_patient'] ?></div>
                            </div>
                            <div class="row">
                                <div class="col-2">Umur</div>
                                <div class="col-1">:</div>
                                <div class="col-9"><?= $selectedRow['birthdate'] ?> / 31 Tahun</div>
                            </div>
                            <div class="row">
                                <div class="col-2">Ruang</div>
                                <div class="col-1">:</div>
                                <div class="col-9"><?= $selectedRow['room_name'] ?> / <?= strtoupper($selectedRow['status']) ?></div>
                            </div>
                            <div class="row">
                                <div class="col-2">Status</div>
                                <div class="col-1">:</div>
                                <div class="col-9"><b>
                                        <?php if ($selectedRow['date_acc'] != null) {
                                            echo 'ACC';
                                        } else if ($selectedRow['date_finish'] != null) {
                                            echo 'FINISH';
                                        } else {
                                            echo 'PROCCESS';
                                        }
                                        ?>
                                    </b>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-sm-12 col-md-12">
                            <div class="row">
                                <div class="col-2">No. Lab</div>
                                <div class="col-1">:</div>
                                <div class="col-9"><?= $selectedRow['nolab']; ?> (<?= $selectedRow['norm']; ?>)</div>
                            </div>
                            <div class="row">
                                <div class="col-2">Terima</div>
                                <div class="col-1">:</div>
                                <div class="col-9">
                                    <?= date('H:i', strtotime($selectedRow['date_report'])); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">Selesai</div>
                                <div class="col-1">:</div>
                                <div class="col-9">
                                    <?= ($selectedRow['date_finish'] != null) ? date('H:i', strtotime($selectedRow['date_finish'])) : '-'; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">Alamat</div>
                                <div class="col-1">:</div>
                                <div class="col-9">
                                    <?= $selectedRow['address']; ?>
                                </div>
                            </div>
                        </div>
                        <div class="ps-2 pe-3 ">
                            <hr>
                        </div>
                        <div class="table-responsive-lg">
                            Sample: <b><?= strtoupper($selectedRow['sample_category']); ?></b>
                            <table class="table table-bordered border-dark table-record mt-2">
                                <thead>
                                    <tr>
                                        <th scope="col" width="36%" class="text-center">Pemeriksaan</th>
                                        <th scope="col" width="21%" class="text-center">Hasil</th>
                                        <th scope="col" width="14%" class="text-center">Satuan</th>
                                        <th scope="col" class="text-center">Rujukan</th>
                                        <th scope="col" class="text-center">Flag</th>
                                    </tr>
                                </thead>
                                <?php foreach ($resultSample as $sampleData) : ?>
                                    <tr>
                                        <td><?= $sampleData['name']; ?></td>
                                        <td class="text-center">
                                            <span>
                                                <?= $sampleData['value']; ?>
                                            </span>
                                        </td>
                                        <td class="text-center"><?= $sampleData['satuan']; ?></td>
                                        <td class="text-center"><?php echo $sampleData['min_value'] . ' - ' . $sampleData['max_value']; ?></td>
                                        <td class="text-center">
                                            <span class="<?php if ($sampleData['flag'] != 'normal') echo 'text-danger text-bold' ?>">
                                                <?= strtoupper($sampleData['flag']); ?>
                                            </span>
                                        </td>

                                    </tr>

                                    <?php $count++; ?>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    <?php } ?>

    <div class="mt-4"></div>
</body>
<script>
    function onClickTable(nolab) {
        let getPatientUrl = '?<?= "date=$_GET[date]&norm=$_GET[norm]&name_patient=$_GET[name_patient]&room=$_GET[room]&page=$page"; ?>' +
            '&selected=';
        let url = getPatientUrl.concat(nolab);
        window.location.replace(url + '#tableRecord');
    }
</script>

</html>