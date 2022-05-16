<?php
include '../config.php';

error_reporting(0);

session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $rowUser = mysqli_fetch_assoc($result);
        $name = $rowUser['name'];
    }
} else {
    header("Location: ./");
}

$range = 15;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$first_page = ($page > 1) ? ($page * $range) - $range : 0;

$previous = $page - 1;
$next = $page + 1;


if (
    isset($_GET['date_from']) && isset($_GET['date_to']) && $_GET['date_from'] != null
    && $_GET['date_to'] != null
) {
    $dateFrom = $_GET['date_from'];
    $dateTo = $_GET['date_to'];

    $dateToTime = dayIncrement($dateTo);

    $resultReportKritisSql = "SELECT * FROM sub_sample 
    LEFT JOIN sample on sub_sample.kd_sample = sample.kd_sample
    LEFT JOIN sub_category_sample on sub_sample.kd_sub_category_sample = sub_category_sample.kd_sub_category
    LEFT JOIN report on sample.nota = report.nota
    LEFT JOIN room on report.room = room.room_kd
    WHERE date_report >= '$dateFrom' AND date_report <= '$dateToTime'
    AND NOT flag = 'normal' AND NOT date_acc IS NULL 
    ORDER BY report.date_acc DESC 
    limit $first_page, $range";
    $resultReportKritis = mysqli_query($conn, $resultReportKritisSql);

    $totalDataSql = "SELECT * FROM sub_sample 
    LEFT JOIN sample on sub_sample.kd_sample = sample.kd_sample
    LEFT JOIN sub_category_sample on sub_sample.kd_sub_category_sample = sub_category_sample.kd_sub_category
    LEFT JOIN report on sample.nota = report.nota
    LEFT JOIN room on report.room = room.room_kd
    WHERE date_report >= '$dateFrom' AND date_report <= '$dateToTime'
    AND NOT flag = 'normal' AND NOT date_acc IS NULL 
    ORDER BY report.date_acc DESC";

    $totalDataQuery = mysqli_query($conn, $totalDataSql);
    $total_data = mysqli_num_rows($totalDataQuery);
    $total_page = ceil($total_data / $range);
} else {
    $resultReportKritisSql = "SELECT * FROM sub_sample 
    LEFT JOIN sample on sub_sample.kd_sample = sample.kd_sample
    LEFT JOIN sub_category_sample on sub_sample.kd_sub_category_sample = sub_category_sample.kd_sub_category
    LEFT JOIN report on sample.nota = report.nota
    LEFT JOIN room on report.room = room.room_kd
    WHERE NOT flag = 'normal' AND NOT date_acc IS NULL 
    ORDER BY report.date_acc DESC 
    limit $first_page, $range";
    $resultReportKritis = mysqli_query($conn, $resultReportKritisSql);

    $totalDataSql = "SELECT * FROM sub_sample 
    LEFT JOIN sample on sub_sample.kd_sample = sample.kd_sample
    LEFT JOIN sub_category_sample on sub_sample.kd_sub_category_sample = sub_category_sample.kd_sub_category
    LEFT JOIN report on sample.nota = report.nota
    LEFT JOIN room on report.room = room.room_kd
    WHERE NOT flag = 'normal' AND NOT date_acc IS NULL 
    ORDER BY report.date_acc DESC";

    $totalDataQuery = mysqli_query($conn, $totalDataSql);
    $total_data = mysqli_num_rows($totalDataQuery);
    $total_page = ceil($total_data / $range);
}
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
    <title>Mediclab - Report</title>
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
                <div class="mr-4 text-light text-name text-end">
                    <h6 class="m-0">Selamat datang,</h6>
                    <h5><?= $name ?></h5>
                </div>
                <div style="min-width:20px"></div>
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
                        <div class="p-4 d-flex">
                            <img src="../assets/bar_chart_black_24dp.svg" alt="configuration">
                            <span class="align-middle ms-2">Laporan TAT</span>
                        </div>
                    </a>
                    <a href="./report-kritis.php" class="decoration-none">
                        <div class="p-4 d-flex report-selected">
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
                    <a href="./report-stock.php" class="decoration-none">
                        <div class="p-4 d-flex">
                            <img src="../assets/bar_chart_black_24dp.svg" alt="configuration">
                            <span class="align-middle ms-2">Stock Opname Reagen</span>
                        </div>
                    </a>
                </div>
            </div>

        </div>
        <div class="col-md-9 mt-4 mb-4">
            <div class="rounded-top border m-0">
                <div class="bg-surface p-2 text-center">
                    Laporan Kritis
                </div>
            </div>
            <div class="border">
                <form method="GET" action="report-kritis.php" class="mb-2">
                    <div class="row ps-2 pe-2">
                        <div class="col-6 col-lg-3 mt-3 d-flex align-items-center">
                            <div class="input-group input-group-default">
                                <span class="input-group-text">Dari</span>
                                <input required value="<?= $_GET['date_from']; ?>" name="date_from" type="date" class="form-control" id="inlineFormInputGroupDate" placeholder="Tanggal">
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 mt-3">
                            <div class="input-group input-group-default">
                                <span class="input-group-text">Sampai</span>
                                <input required value="<?= $_GET['date_to']; ?>" name="date_to" type="date" class="form-control" id="inlineFormInputGroupDate" placeholder="Tanggal">
                            </div>
                        </div>
                        <div class="col-6 col-lg-1 mt-3">
                            <input required name='search' value="Cari" type="submit" class="btn btn-primary w-100" />
                        </div>
                    </div>
                    <input value="<?= isset($_GET['search']) ? $_GET['page'] : 1; ?>" name="page" type="text" class="form-control d-none" id="inlineFormInputGroupRoom">
                </form>
                <div class="ms-4 mt-4">
                    <p>
                        <?php if (isset($_GET['search'])) { ?>
                            Index tanggal: <b><?= $dateFrom; ?></b> s/d <b><?= $dateTo; ?>.</b> Total Laporan Kritis: <b><?= $total_data; ?></b>
                        <?php } ?>
                    </p>
                </div>
                <div class="ms-3 me-3 table-responsive-lg">
                    <div style="min-height: 400px;">
                        <table class=" table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center" width="5%">No</th>
                                    <th scope="col" class="text-center" width="14%">Tanggal</th>
                                    <th scope="col" class="text-center" width="8%">No. RM</th>
                                    <th scope="col" class="text-center" width="18%">Nama</th>
                                    <th scope="col" class="text-center" width="9%">ACC</th>
                                    <th scope="col" class="text-center" width="7%">Ruang</th>
                                    <th scope="col" class="text-center" width="7%">Pemeriksaan</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 1 + $first_page; ?>
                                <?php foreach ($resultReportKritis as $dataReport) : ?>
                                    <tr onclick="onClickTable('<?= $dataReport['nota']; ?>')">
                                        <?php
                                        $reportDate = strtotime($dataReport['date_report']);
                                        $accDate = strtotime($dataReport['date_acc']);

                                        ?>
                                        <td class="text-center"><?= $number ?></td>
                                        <td class="text-center"><?= date('Y-m-d', $reportDate); ?></td>
                                        <td class="text-center"><?= $dataReport['norm']; ?></td>
                                        <td><?= $dataReport['name_patient']; ?></td>
                                        <td class="text-center"><?= $dataReport['date_acc'] ?></td>
                                        <td class="text-center"><?= $dataReport['room_name'] ?></td>
                                        <td class="">
                                            <table class="table border">
                                                <tr>
                                                    <td><b>PARAMETER</b></td>
                                                    <td><b>HASIL</b></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center"><?= $dataReport['name']; ?></td>
                                                    <td class="text-center"><?= $dataReport['value']; ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <?php $number++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <ul class="pagination justify-content-center mt-2">
                        <li class="page-item me-2">
                            <a class="btn btn-info" <?php if ($page > 1) {
                                                        echo "href='?date_from=$_GET[date_from]&date_to=$_GET[date_to]&page=$previous'";
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
                                                                            } ?>" href="<?php echo "?date_from=$_GET[date_from]&date_to=$_GET[date_to]&page=$x"; ?>">
                                    <?php echo $x; ?>
                                </a></li>
                        <?php
                        }
                        ?>
                        <li class="page-item ms-2">
                            <a class="btn btn-info" <?php if ($page < $total_page) {
                                                        echo "href='?date_from=$_GET[date_from]&date_to=$_GET[date_to]&page=$next'";
                                                    } ?>>Next</a>
                        </li>
                    </ul>
                </div>
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