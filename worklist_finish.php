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


if (isset($_GET['date']) && isset($_GET['norm']) && isset($_GET['name_patient']) && isset($_GET['room'])) {
    $date = $_GET['date'];
    $norm = $_GET['norm'];
    $name_patient = $_GET['name_patient'];
    $room = $_GET['room'];
    $sqlReport = "SELECT * FROM report LEFT JOIN room ON report.room=room.room_kd 
        WHERE name_patient LIKE '%$name_patient%' AND date_report LIKE '$date%'
        AND norm LIKE '%$norm%' AND room LIKE '%$room%' ORDER BY nota DESC";
    $resultReport = mysqli_query($conn, $sqlReport);
} else {
    $sqlReport = "SELECT * FROM report LEFT JOIN room ON report.room=room.room_kd WHERE date_finish IS NOT NULL ORDER BY nota DESC";
    $resultReport = mysqli_query($conn, $sqlReport);
}


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="css/style-main.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <title>Mediclab - Validator Worklist</title>
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

    <div class="ps-3 px-4">
        <form method="GET" action="worklist_finish.php" class="row mt-2 mb-4 ">
            <div class="col-11 row pt-3">
                <div class="col-6 col-lg-3">
                    <div class="input-group input-group-default mb-3">
                        <span class="input-group-text">Tanggal</span>
                        <input value="<?= $_GET['date']; ?>" name="date" type="date" class="form-control" id="inlineFormInputGroupDate" placeholder="Tanggal">
                    </div>
                </div>

                <div class="col-6 col-lg-3">
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

            <div class="col-1 col">
                <input value="Cari" type="submit" class="btn btn-primary mt-3" />
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
                    <th scope="col" class="text-center" width="7%">ACC</th>
                    <th scope="col" class="text-center" width="7%">Print</th>
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
                        <td class="text-center">
                            <?php if ($dataReport['date_finish'] != null && $dataReport['date_acc'] == null) {
                                echo "<b>FINISH</b>";
                            } else if ($dataReport['date_acc'] != null) {
                                echo "<b class='text-succes'>ACC</b>";
                            } else {
                                echo 'PROCESS';
                            } ?>
                        </td>
                        <td class="text-center">
                            <?php if ($dataReport['date_acc'] == null) { ?>
                                <form action="acc_report.php?nota=<?= $dataReport['nota']; ?>" method="POST">
                                    <input type="submit" name="acc_report" class="btn btn-success" value="ACC">
                                </form>
                            <?php } ?>

                        </td>

                        <td class="text-center">
                            <?php if ($dataReport['date_acc'] != null) { ?>
                                <button class="btn btn-primary">Print</button>
                            <?php } ?>
                        </td>

                    </tr>
                    <?php $number++; ?>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</body>

<script>
    function onClickTable(nota) {
        let getPatientUrl = 'validate_report.php?nota='
        let url = getPatientUrl.concat(nota);
        window.location.replace(url);
    }
</script>

</html>