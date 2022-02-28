<!DOCTYPE html>
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
            <h3 class="text-light"><b>MEDICLAB</b></h3>
            <div class="d-flex align-items-start">
                <h5 class="mr-4 text-light">Selamat pagi, <?= $name ?></h5>
                <div style="min-width:40px"></div>
                <a href="logout.php"><button class="btn btn-light">Logout</button></a>
            </div>
        </div>
    </div>

    <div class="content-dashboard container mt-4">
        <div class="row menu-items g-2">
            <div class="col-lg-6 col-12 chart">
                <div class="p-3 bg-light text-center">
                    <img src="assets/bar_chart_black_24dp.svg" style="height: 280px; width: 280px;" alt="">
                    <h2>CHART</h2>
                </div>
            </div>
            <div class="col-lg-6 col-12 container menus">
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-5 col-12 text-center">
                        <a href="#" class="decoration-none">
                            <div class="bg-danger pt-2 pb-2 border-radius-4">
                                <img src="assets/fact_check_black_24dp.svg" alt="image" class="filter-white">
                                <div style="min-height: 15px;"></div>
                                <h6 class="text-light">WORKLIST</h6>
                            </div>
                        </a>
                    </div>
                    <div class=" col-lg-1">
                    </div>
                    <div class="col-lg-5 col-12 text-center">
                        <a href="#" class="decoration-none">
                            <div class="bg-primary pt-2 pb-2 border-radius-4">
                                <img src="assets/summarize_black_24dp.svg" alt="image" class="filter-white">
                                <div style="min-height: 15px;"></div>
                                <h6 class="text-light">REPORT</h6>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="spacer" style="min-height: 50px;"></div>
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-5 col-12 text-center">
                        <a href="#" class="decoration-none">
                            <div class="bg-warning pt-2 pb-2 border-radius-4">
                                <img src="assets/history_black_24dp.svg" alt="image" class="filter-white">
                                <div style="min-height: 15px;"></div>
                                <h6 class="text-light">HISTORY</h6>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-1"></div>
                    <div class="col-lg-5 col-12 text-center">
                        <a href="#" class="decoration-none">
                            <div class="bg-success pt-2 pb-2 border-radius-4">
                                <img src="assets/print_black_24dp.svg" alt="image" class="filter-white">
                                <div style="min-height: 15px;"></div>
                                <h6 class="text-light">LIST PRINT</h6>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

<script src="js/bootstrap.bundle.min.js"></script>

</html>