<?php
include '../config.php';

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
                            <input required value="Cari" type="submit" class="btn btn-primary w-100" />
                        </div>
                    </div>
                    <input value="<?= isset($_GET['search']) ? $_GET['page'] : 1; ?>" name="page" type="text" class="form-control d-none" id="inlineFormInputGroupRoom">
                </form>

            </div>
        </div>

</body>

</html>