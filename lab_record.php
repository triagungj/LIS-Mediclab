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

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style-main.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <title>Mediclab - History</title>
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
            </div>

        </form>
    </div>
    <div class="row ms-2 me-2 mt-2">
        <div class="col-md-6">
            <div class="table-responsive-md border rounded-top">
                <div class="bg-surface p-2">
                    <span>Daftar Pasien</span>
                </div>
                <div class="ms-2 me-2 mt-2">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" width="10%">No</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Nama</th>
                                <th scope="col">No. RM</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Data</td>
                                <td>Data</td>
                                <td>Data</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Data</td>
                                <td>Data</td>
                                <td>Data</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Data</td>
                                <td>Data</td>
                                <td>Data</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div class="col-md-6 pe-2 ps-2">
            <div class="rounded-top border">
                <div class="bg-surface p-2 justify-content-between d-flex align-items-center">
                    <span>Daftar Pasien</span>
                    <button class="btn btn-primary me-4">PRINT</button>
                </div>
                <div class="mt-2 ps-2 row table-responsive-md ">
                    <div class="col-xl-6 col-sm-12 col-md-12">
                        <div class="row">
                            <div class="col-2">Nama</div>
                            <div class="col-1">:</div>
                            <div class="col-9">Bambang</div>
                        </div>
                        <div class="row">
                            <div class="col-2">Umur</div>
                            <div class="col-1">:</div>
                            <div class="col-9">1990-03-22 / 31 Tahun</div>
                        </div>
                        <div class="row">
                            <div class="col-2">Ruang</div>
                            <div class="col-1">:</div>
                            <div class="col-9">KALIBIRU 1 Umum / -</div>
                        </div>
                        <div class="row">
                            <div class="col-2">Status</div>
                            <div class="col-1">:</div>
                            <div class="col-9">-</div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-sm-12 col-md-12">
                        <div class="row">
                            <div class="col-2">No. Lab</div>
                            <div class="col-1">:</div>
                            <div class="col-9">203203809138 (203291)</div>
                        </div>
                        <div class="row">
                            <div class="col-2">Terima</div>
                            <div class="col-1">:</div>
                            <div class="col-9">07:16</div>
                        </div>
                        <div class="row">
                            <div class="col-2">Selesai</div>
                            <div class="col-1">:</div>
                            <div class="col-9">07:34</div>
                        </div>
                        <div class="row">
                            <div class="col-2">Alamat</div>
                            <div class="col-1">:</div>
                            <div class="col-9">Jl. Wates No. 32 RT 3/5, Kulonprogo, DIY</div>
                        </div>
                    </div>

                    <div style="min-height: 200px;"></div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>