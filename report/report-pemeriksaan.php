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

$totalSql = "SELECT table_patient.sample_kd, table_patient.sample_name, table_patient.total_patient, table_param.total_parameter, table_kritis.total_kritis
	FROM 
	(SELECT category_sample.kd_category as 'sample_kd', category_sample.name as 'sample_name', COUNT(report.nota) as 'total_patient'
    FROM report 
    LEFT JOIN category_sample ON report.sample_category=category_sample.kd_category
    GROUP BY category_sample.name) table_patient
    
    LEFT JOIN 
    	(SELECT category_sample.kd_category as 'sample_kd', COUNT(sub_sample.kd_sub_sample) as 'total_parameter' 
	FROM category_sample 
    LEFT JOIN sub_category_sample ON category_sample.kd_category=sub_category_sample.kd_category 
    LEFT JOIN sub_sample ON sub_category_sample.kd_sub_category=sub_sample.kd_sub_category_sample
    LEFT JOIN sample ON sub_sample.kd_sample = sample.kd_sample
    LEFT JOIN report ON sample.nota = report.nota
    GROUP BY category_sample.kd_category) table_param
    ON table_patient.sample_kd = table_param.sample_kd
    
     LEFT JOIN 
    	(SELECT category_sample.kd_category as 'sample_kd', COUNT(sub_sample.kd_sub_sample) as 'total_kritis' 
	FROM category_sample 
    LEFT JOIN sub_category_sample ON category_sample.kd_category=sub_category_sample.kd_category 
    LEFT JOIN sub_sample ON sub_category_sample.kd_sub_category=sub_sample.kd_sub_category_sample
    LEFT JOIN sample ON sub_sample.kd_sample = sample.kd_sample
    LEFT JOIN report ON sample.nota = report.nota
    WHERE sub_sample.flag != 'normal'
    GROUP BY category_sample.kd_category) table_kritis
    ON table_patient.sample_kd = table_kritis.sample_kd
    
    GROUP BY table_patient.sample_kd";

$totalArray = mysqli_query($conn, $totalSql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/style-main.css" rel="stylesheet">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <title>Report Pemeriksaan - Mediclab</title>
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
                        <div class="p-4 d-flex">
                            <img src="../assets/bar_chart_black_24dp.svg" alt="configuration">
                            <span class="align-middle ms-2">Laporan Kritis</span>
                        </div>
                    </a>
                    <a href="./report-pemeriksaan.php" class="decoration-none">
                        <div class="p-4 d-flex report-selected">
                            <img src="../assets/bar_chart_black_24dp.svg" alt="configuration">
                            <span class="align-middle ms-2">Jumlah Pemeriksaan</span>
                        </div>
                    </a>
                </div>
            </div>

        </div>
        <div class="col-md-9 mt-4 mb-4">
            <div class="rounded-top border m-0">
                <div class="bg-surface p-2 text-center">
                    Jumlah Pemeriksaan
                </div>
            </div>
            <div class="border">
                <div class="ms-3 me-3 mt-3 table-responsive-lg">
                    <div style="min-height: 400px;">
                        <table class=" table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center" width="5%">NO</th>
                                    <th scope="col" class="text-center" width="20%">Pemeriksaan</th>
                                    <th scope="col" class="text-center" width="15%">Jumlah Laporan</th>
                                    <th scope="col" class="text-center" width="20%">Jumlah Parameter</th>
                                    <th scope="col" class="text-center" width="20%">Parameter Kritis</th>
                                    <th scope="col" class="text-center" width="20%">Presentase Kritis</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 1; ?>
                                <?php foreach ($totalArray as $dataTotal) : ?>
                                    <tr>
                                        <?php $precentage = number_format((float) $dataTotal['total_kritis'] / $dataTotal['total_parameter'] * 100, 2, '.', '') ?>
                                        <td class="text-center"><?= $number ?></td>
                                        <td class="text-center"><?= $dataTotal['sample_name']; ?></td>
                                        <td class="text-center"><?= $dataTotal['total_patient']; ?></td>
                                        <td class="text-center"><?= $dataTotal['total_parameter']; ?></td>
                                        <td class="text-center"><?= $dataTotal['total_kritis']; ?></td>
                                        <td class="text-center"><?= $precentage; ?> %</td>
                                    </tr>
                                    <?php $number++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

</body>

</html>