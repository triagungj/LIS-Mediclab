<!DOCTYPE html>
<?php
include 'config.php';

error_reporting(0);

session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
} else {
    header("Location: ./");
}

$sampleTotalSql = "SELECT category_sample.name as 'nama', COUNT(nota) as 'total'
    FROM report 
    LEFT JOIN category_sample ON report.sample_category=category_sample.kd_category
    GROUP BY category_sample.name";
$sampleTotalArray = mysqli_query($conn, $sampleTotalSql);

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style-main.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <title>Dashboard - Mediclab </title>
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

    <div class="content-dashboard pt-3" style="background-image: url('assets/hospital.jpg');">
        <div class="dashboard-menu container pt-4">
            <h3 class="text-center"><b>RUMAH SAKIT ALIH JENJANG</b></h3>
            <div class="row menu-items">
                <div class="col-lg-6 col-12 chart mt-2">
                    <div class="p-3 text-center">
                        <canvas id="myChart" style="width:400%;max-width:800px;height:600px"></canvas>
                    </div>
                </div>
                <div class="col-lg-6 col-12 container menus ">
                    <div class="row">
                        <div class="col-lg-6 col-12 text-center p-4">
                            <a href="<?php if ($row['jabatan'] == 'validator') {
                                            echo 'worklist_finish.php';
                                        } else {
                                            echo 'worklist.php';
                                        } ?>" class="decoration-none">
                                <div class="bg-danger pt-2 pb-2 border-radius-4">
                                    <img src="assets/fact_check_black_24dp.svg" alt="image" class="filter-white">
                                    <div style="min-height: 30px;"></div>
                                    <h5 class="text-light text-bold">WORKLIST</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-6 col-12 text-center  p-4">
                            <a href="./report/report-tat.php" class="decoration-none">
                                <div class="bg-primary pt-2 pb-2 border-radius-4">
                                    <img src="assets/summarize_black_24dp.svg" alt="image" class="filter-white">
                                    <div style="min-height: 30px;"></div>
                                    <h5 class="text-light text-bold">REPORT</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-12 text-center p-4">
                            <a href="./lab_record.php" class="decoration-none">
                                <div class="bg-warning pt-2 pb-2 border-radius-4">
                                    <img src="assets/history_black_24dp.svg" alt="image" class="filter-white">
                                    <div style="min-height: 30px;"></div>
                                    <h5 class="text-light text-bold">HISTORY</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-6 col-12 text-center p-4">
                            <a href="./list_print.php" class="decoration-none">
                                <div class="bg-success pt-2 pb-2 border-radius-4">
                                    <img src="assets/print_black_24dp.svg" alt="image" class="filter-white">
                                    <div style="min-height: 30px;"></div>
                                    <h5 class="text-light text-bold">LIST PRINT</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    sampleTotalName = [];
    sampleTotalValue = [];
    <?php foreach ($sampleTotalArray as $data) : ?>
        sampleTotalName.push('<?= $data['nama']; ?>');
        sampleTotalValue.push(<?= $data['total']; ?>);
    <?php endforeach; ?>

    var xValues = sampleTotalName;
    var yValues = sampleTotalValue;
    var barColors = [
        "#b91d47",
        "#00aba9",
        "#2b5797",
        "#e8c3b9",
        "#1e7145"
    ];

    new Chart("myChart", {
        type: "pie",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        },
        options: {
            title: {
                display: true,
                text: "Total Laporan Pasien"
            }
        }
    });
</script>
<script src="js/bootstrap.bundle.min.js"></script>

</html>