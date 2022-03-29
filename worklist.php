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

$sqlReport = "SELECT * FROM report LEFT JOIN room ON report.room=room.room_kd";
$resultReport = mysqli_query($conn, $sqlReport);


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
    <div class="header bg-primary">
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

    <form class="row row-cols-lg-auto g-3 align-items-center mt-2 mb-4 ms-2 me-2">
        <div class="col-2 col-lg-2">
            <label class="visually-hidden ml-4" for="inlineFormInputGroupDate">Tanggal</label>
            <div class="input-group">
                <input type="text" class="form-control" id="inlineFormInputGroupDate" placeholder="Tanggal">
            </div>
        </div>
        <div class="col-2 col-lg-2">
            <label class="visually-hidden ml-4" for="inlineFormInputGroupRegistNumber">No. RM</label>
            <div class="input-group">
                <input type="text" class="form-control" id="inlineFormInputGroupRegistNumber" placeholder="No. RM">
            </div>
        </div>
        <div class="col-2 col-lg-2">
            <label class="visually-hidden ml-4" for="inlineFormInputGroupName">Nama</label>
            <div class="input-group">
                <input type="text" class="form-control" id="inlineFormInputGroupName" placeholder="Nama">
            </div>
        </div>
        <div class="col-2 col-lg-2">
            <label class="visually-hidden ml-4" for="inlineFormInputGroupRoom">Ruang</label>
            <div class="input-group">
                <input type="text" class="form-control" id="inlineFormInputGroupRoom" placeholder="Ruang">
            </div>
        </div>

        <div class="col-4 col-lg-3">
            <button type="submit" class="btn btn-primary">Cari</button>
            <a href="./add_patient.php" class="btn btn-primary" type="submit" class="btn btn-primary">Tambah</a class="btn btn-primary">
        </div>

    </form>

    <div class="ms-3 me-3 table-responsive-lg">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col" class="text-center" width="7%">No Lab</th>
                    <th scope="col" class="text-center" width="7%">No RM</th>
                    <th scope="col" class="text-center" width="20%">Nama</th>
                    <th scope="col" class="text-center" width="14%">Ruang</th>
                    <th scope="col" class="text-center" width="14%">No Trans</th>
                    <th scope="col" class="text-center" width="7%">Status</th>
                    <th scope="col" class="text-center" width="10%">Transmit</th>
                    <th scope="col" class="text-center" width="7%">Barcode</th>
                    <th scope="col" class="text-center" width="7%">Print</th>
                    <th scope="col" class="text-center" width="7%">Diagnosa</th>

                </tr>
            </thead>
            <tbody>

                <?php foreach ($resultReport as $dataReport) : ?>
                    <tr onclick="onClickTable('<?= $dataReport['nota']; ?>')">
                        <td><?= $dataReport['nolab'] ?></td>
                        <td><?= $dataReport['norm']; ?></td>
                        <td><?= $dataReport['name_patient']; ?></td>
                        <td><?= $dataReport['room_name']; ?></td>
                        <td><?= $dataReport['nota']; ?></td>
                        <td><?php if ($dataReport['progress'] == 0) {
                                echo 'PROCESS';
                            } else {
                                echo 'FINISH';
                            } ?></td>
                        <td class="text-center">TRANSMITTED</td>
                        <td class="text-center"><button class="btn btn-primary">Barcode</button></td>
                        <td class="text-center"><button class="btn btn-primary">Print</button></td>
                        <td class="text-center"><button class="btn btn-primary">Diagnosa</button></td>
                    </tr>
                    <?php $number++; ?>
                <?php endforeach; ?>

            </tbody>
        </table>
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