<?php
include 'config.php';

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

$range = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$first_page = ($page > 1) ? ($page * $range) - $range : 0;

$previous = $page - 1;
$next = $page + 1;

$sqlReport = "SELECT * FROM report LEFT JOIN room ON report.room=room.room_kd 
        WHERE date_acc IS NOT NULL
        ORDER BY nolab DESC limit $first_page, $range";
$resultReport = mysqli_query($conn, $sqlReport);

$sqlTotal = "SELECT nota FROM report WHERE date_acc IS NOT NULL";
$reportTotal = mysqli_query($conn, $sqlTotal);
$totalData = mysqli_num_rows($reportTotal);
$total_page = ceil($totalData / $range);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style-main.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <title>Print - Mediclab</title>
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

    <div class="border pt-3">
        <div class="text-center">
            <h3><b>LIST PRINT</b></h3>
        </div>
        <hr>
        <div class="table-responsive-lg mx-4">
            <div style="min-height: 400px;">
                <table class=" table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center" width="5%">No</th>
                            <th scope="col" class="text-center" width="7%">No RM</th>
                            <th scope="col" class="text-center" width="7%">No Lab</th>
                            <th scope="col" class="text-center" width="12%">Nama</th>
                            <th scope="col" class="text-center" width="8%">Ruang</th>
                            <th scope="col" class="text-center" width="7%">Tanggal</th>
                            <th scope="col" class="text-center" width="7%">Daftar</th>
                            <th scope="col" class="text-center" width="7%">Selesai</th>
                            <th scope="col" class="text-center" width="7%">PRINT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $number = 1; ?>
                        <?php foreach ($resultReport as $dataReport) : ?>
                            <tr>
                                <?php
                                $reportDate = strtotime($dataReport['date_report']);
                                $finishDate = strtotime($dataReport['date_finish']);
                                $dateTimeObject1 = date_create($dataReport['date_report']);
                                $dateTimeObject2 = date_create($dataReport['date_finish']);

                                $difference = date_diff($dateTimeObject1, $dateTimeObject2);
                                ?>
                                <td onclick="onClickTable('<?= $dataReport['nota']; ?>')" class="text-center"><?= $number ?></td>
                                <td onclick="onClickTable('<?= $dataReport['nota']; ?>')" class="text-center"><?= $dataReport['norm']; ?></td>
                                <td onclick="onClickTable('<?= $dataReport['nota']; ?>')" class="text-center"><?= $dataReport['nolab']; ?></td>
                                <td onclick="onClickTable('<?= $dataReport['nota']; ?>')"><?= $dataReport['name_patient']; ?></td>
                                <td onclick="onClickTable('<?= $dataReport['nota']; ?>')" class="text-center"><?= $dataReport['room_name']; ?></td>
                                <td onclick="onClickTable('<?= $dataReport['nota']; ?>')" class="text-center"><?= date('Y-m-d', $reportDate); ?></td>
                                <td onclick="onClickTable('<?= $dataReport['nota']; ?>')" class="text-center"><?= date('H:i:s', $reportDate); ?></td>
                                <td onclick="onClickTable('<?= $dataReport['nota']; ?>')" class="text-center"><?= date('H:i:s', $finishDate); ?></td>
                                <td class="text-center">
                                    <a href="print.php?nota=<?= $dataReport['nota']; ?>" target="_blank" class="btn btn-info">
                                        Print
                                    </a>
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
                                                echo "href='?page=$previous'";
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
                                                                    } ?>" href="<?php echo "?page=$x"; ?>">
                            <?php echo $x; ?>
                        </a></li>
                <?php
                }
                ?>
                <li class="page-item ms-2">
                    <a class="btn btn-info" <?php if ($page < $total_page) {
                                                echo "href='?page=$next'";
                                            } ?>>Next</a>
                </li>
            </ul>
        </div>
    </div>
</body>
<script>
    function onClickTable(nota) {
        var jabatan = '<?= $rowUser['jabatan']; ?>';

        if (jabatan == 'validator') {
            window.location.href = 'validate_report.php?nota=' + nota;
        } else {
            window.location.href = 'add_patient.php?nota=' + nota;
        }
    }
</script>

</html>