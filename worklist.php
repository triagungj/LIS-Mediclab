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


$range = 10;
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


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="css/style-main.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <title>Mediclab - Dashboard</title>
</head>

<body>
    <div class="header bg-primary pb-2">
        <marquee>
            <h6 class="mt-2 text-light text-name-responsive">Selamat datang, <?= $name ?>.</h6>
        </marquee>
        <div class="container d-flex justify-content-between pt-2">
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
        <form method="GET" action="worklist.php" class="row mt-2 mb-4 ">
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
                <a href="./add_patient.php" class="btn btn-primary mt-3" type="submit" class="btn btn-primary">Tambah</a class="btn btn-primary">
            </div>

        </form>
    </div>

    <div class="ms-3 me-3 table-responsive-lg">

        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th scope="col" class="text-center" width="7%">No Lab</th>
                    <th scope="col" class="text-center" width="7%">No RM</th>
                    <th scope="col" class="text-center" width="20%">Nama</th>
                    <th scope="col" class="text-center" width="7%">Ruang</th>
                    <th scope="col" class="text-center" width="14%">No Trans</th>
                    <th scope="col" class="text-center" width="7%">Status</th>
                    <th scope="col" class="text-center" width="17%">Transmit</th>
                    <th scope="col" class="text-center" width="7%">Print</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultReport as $dataReport) : ?>
                    <tr>
                        <td onclick="onClickTable('<?= $dataReport['nota']; ?>')"><?= $dataReport['nolab'] ?></td>
                        <td onclick="onClickTable('<?= $dataReport['nota']; ?>')"><?= $dataReport['norm']; ?></td>
                        <td onclick="onClickTable('<?= $dataReport['nota']; ?>')"><?= $dataReport['name_patient']; ?></td>
                        <td onclick="onClickTable('<?= $dataReport['nota']; ?>')"><?= $dataReport['room_name']; ?></td>
                        <td onclick="onClickTable('<?= $dataReport['nota']; ?>')"><?= $dataReport['nota']; ?></td>
                        <td onclick="onClickTable('<?= $dataReport['nota']; ?>')" class="text-center">
                            <?php if ($dataReport['date_finish'] != null && $dataReport['date_acc'] == null) {
                                echo "<b>FINISH</b>";
                            } else if ($dataReport['date_acc'] != null) {
                                echo "<b class='text-succes'>ACC</b>";
                            } else {
                                echo 'PROCESS';
                            } ?>
                        </td>
                        <td onclick="onClickTable('<?= $dataReport['nota']; ?>')" class="text-center">
                            <?php if ($dataReport['transmit'] == 1) {
                                echo 'TRANSMITTED';
                            } else {
                                echo 'NOT TRANSMITTED';
                            } ?>
                        </td>
                        <td class="text-center">
                            <?php if ($dataReport['date_acc'] != null) { ?>
                                <a href="print.php?nota=<?= $dataReport['nota']; ?>" target="_blank" class="btn btn-info">
                                    Print
                                </a>
                            <?php } ?>
                        </td>

                    </tr>
                    <?php $number++; ?>
                <?php endforeach; ?>

            </tbody>
        </table>
        <ul class="pagination justify-content-center">
            <li class="page-item ">
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
            <li class="page-item ">
                <a class="btn btn-info" <?php if ($page < $total_page) {
                                            echo "href='?date=$_GET[date]&norm=$_GET[norm]&name_patient=$_GET[name_patient]&room=$_GET[room]&page=$next'";
                                        } ?>>Next</a>
            </li>
        </ul>
    </div>


</body>

<script>
    function onClickTable(nota) {
        let getPatientUrl = 'add_patient.php?nota='
        let url = getPatientUrl.concat(nota);
        window.location.replace(url);
    }
</script>

</html>