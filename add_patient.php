<?php

// Starter
include 'config.php';
error_reporting(0);
session_start();
$edit = false;

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
    }
    $resultValidatorSql = "SELECT * FROM users WHERE jabatan='validator'";
    $resultValidator = mysqli_query($conn, $resultValidatorSql);

    $resultPetugasSql = "SELECT * FROM users WHERE jabatan='petugas'";
    $resultPetugas = mysqli_query($conn, $resultPetugasSql);
} else {
    header("Location: ./");
}

// GET EDIT
if (isset($_GET['nota'])) {
    $edit = true;
    $nota = $_GET['nota'];
    $resultEditSql = "SELECT * FROM report WHERE nota='$nota'";
    $resultEditArray = mysqli_query($conn, $resultEditSql);

    if ($resultEditArray->num_rows > 0) {
        $resultEdit = mysqli_fetch_assoc($resultEditArray);
    } else {
        header("Location: add_patient.php");
    }
}

if ($edit) {
    $subSampleSql = "SELECT * FROM sub_sample 
    LEFT JOIN sample on sub_sample.kd_sample = sample.kd_sample
    LEFT JOIN sub_category_sample on sub_sample.kd_sub_category_sample = sub_category_sample.kd_sub_category
    WHERE nota = '$_GET[nota]'";

    $resultSample = mysqli_query($conn, $subSampleSql);
}

$roomSql = "SELECT * FROM room";
$resultRoom = mysqli_query($conn, $roomSql);

// Get Cat Sample 
$catSampleSql = "SELECT * FROM  category_sample";
$catSampleResult = mysqli_query($conn, $catSampleSql);


// Random Lab Number
function generateLabNumber($conn)
{
    $dateNow = date('Y-m-d');
    $resultCountSql = "SELECT COUNT(nota) as total FROM report WHERE date_report like '$dateNow%'";
    $resultCountArray = mysqli_query($conn, $resultCountSql);
    $resultCount = mysqli_fetch_assoc($resultCountArray);

    $count = str_pad($resultCount['total'] + 1, 3, '0', STR_PAD_LEFT); // Must be resolve
    $newLabNumber = date('Ymd') . $count;
    echo $newLabNumber;
}

// Random Trans Number
function generateTransNumber()
{
    echo strtoupper(uniqid());
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style-main.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <title>Mediclab - Add Patient</title>
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

    <!-- Add Patient Form -->
    <div class="ps-4 pe-4 mt-4">
        <div class="bg-surface p-3 rounded-top border">
            <div class="row align-items-center">
                <div class="col-6 col-lg-9">
                    <h6>Data Pasien</h6>
                    <div class="d-inline">
                        <a href="./worklist.php"><button type="button" class="btn btn-primary mt-2">Back</button></a>
                        <button type="button" class="btn btn-primary mt-2" onclick="onHide()">Hide</button>
                        <button type="button" class="btn btn-primary mt-2" onclick="onShow()">Show</button>
                        <!-- <button type="button" class="btn btn-primary mt-2">Order</button> -->
                    </div>
                </div>
                <?php if ($resultEdit['date_finish'] != null && $resultEdit['date_acc'] == null) { ?>
                    <div class="col-6 col-lg-3 align-items-center d-flex">
                        <div class="me-2">
                            <img src="assets/check_circle_black_24dp.svg" alt="check" class="icon-check">
                        </div>
                        <div>
                            <h4 class="text-success"><u>FINISH</u></h4>
                            <p class="text-success">
                                <b><?= $resultEdit['date_finish']; ?></b>
                                <?php if ($resultEdit['transmit'] == 1) echo 'TRANSMITTED' ?> <br />
                            </p>
                        </div>
                    </div>
                <?php } else if ($resultEdit['date_acc'] != null) { ?>
                    <div class="col-6 col-lg-3 align-items-center d-flex">
                        <div class="me-2">
                            <img src="assets/check_circle_black_24dp.svg" alt="check" class="icon-check">
                        </div>
                        <div>
                            <h2 class="text-success"><u>ACC</u></h2>
                            <p class="text-success"><b><?= $resultEdit['date_acc']; ?></b></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="border p-3" id="patientSection">
            <form method="POST" action="<?php if ($edit) {
                                            echo 'insert_report.php?nota=' . $_GET['nota'];
                                        } else {
                                            echo 'insert_report.php';
                                        } ?>">
                <div class="row table-responsive">
                    <div class="col-12 col-md-6">
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end text-end">
                                <label for="inputDateReport" class="col-form-label">Tanggal :</label>
                            </div>
                            <div class="col-4">
                                <input value="<?php if ($edit) {
                                                    echo $resultEdit['date_report'];
                                                } else {
                                                    echo date("Y-m-d H:i:s");
                                                } ?>" required name="inputDateReport" readonly class="form-control" aria-describedby="dateHelpInline">
                            </div>
                            <div class="col-2 text-end">
                                <label for="inputLabNumberReport" class="col-form-label">No. Lab :</label>
                            </div>
                            <div class="col-4">
                                <input value="<?php if ($edit) {
                                                    echo $resultEdit['nolab'];
                                                } else echo generateLabNumber($conn); ?>" required type="number" name="inputLabNumberReport" class="form-control" aria-describedby="inputLabNumberHelpInline" readonly>
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="inputRegNumberReport" class="col-form-label">No. RM :</label>
                            </div>
                            <div class="col-4">
                                <input value="<?php if ($edit) {
                                                    echo $resultEdit['norm'];
                                                } ?>" maxlength="6" required type="text" name="inputRegNumberReport" id="inputRegNumberReport" class="form-control" aria-describedby="regNumberHelpInline">
                            </div>
                            <div class="col-2 text-end">
                                <label for="inputNotaReport" class="col-form-label">Nota :</label>
                            </div>
                            <div class="col-4">
                                <input value="<?php if ($edit) {
                                                    echo $resultEdit['nota'];
                                                } else {
                                                    echo generateTransNumber();
                                                } ?>" required type="text" name="inputNotaReport" class="form-control" aria-describedby="inputNotaHelpInline" readonly>
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="inputNikReport" class="col-form-label">NIK :</label>
                            </div>
                            <div class="col-10">
                                <input value="<?php if ($edit) echo $resultEdit['nik']; ?>" required type="text" id="inputNikReport" name="inputNikReport" class="form-control" aria-describedby="nikHelpInline">
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="inputNameReport" class="col-form-label">Nama :</label>
                            </div>
                            <div class="col-10">
                                <input value="<?php if ($edit) echo $resultEdit['name_patient']; ?>" required type="text" id="inputNameReport" name="inputNameReport" class="form-control" aria-describedby="nameHelpInline">
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="birthDayReport" class="col-form-label">Tgl. Lahir :</label>
                            </div>
                            <div class="col-4">
                                <input value="<?php if ($edit) echo $resultEdit['birthdate']; ?>" required id="birthdayReport" name="inputBirthdayReport" type="date" class="form-control" aria-describedby="birthdayHelpInline" onchange="getAgeBirthday()">
                            </div>
                            <div class="col-2 text-end">
                                <label for="selectGenderReport" class="col-form-label">Jenis Kelamin</label>
                            </div>
                            <div class="col-4">
                                <select required name="selectGenderReport" class="form-select" aria-label="select-jk">
                                    <option disabled selected hidden value="">-</option>
                                    <option value="L" <?php if ($edit) {
                                                            if ($resultEdit['gender'] == 'L') echo 'selected';
                                                        } ?>>Laki-laki</option>
                                    <option value="P" <?php if ($edit) {
                                                            if ($resultEdit['gender'] == 'P') echo 'selected';
                                                        } ?>>Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label class="col-form-label">Umur :</label>
                            </div>
                            <div class="col-3">
                                <span class="col-form-label ms-1">Tahun</span>
                                <input id="inputAgeYear" type="text" disabled class="form-control">
                            </div>
                            <div class="col-3">
                                <span class="col-form-label ms-1">Bulan</span>
                                <input id="inputAgeMonth" type="text" disabled class="form-control">
                            </div>
                            <div class="col-4">
                                <span class="col-form-label ms-1">Hari</span>
                                <input id="inputAgeDate" type="text" disabled class="form-control">
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="inputAddressReport" class="col-form-label">Alamat :</label>
                            </div>
                            <div class="col-10">
                                <input value="<?php if ($edit) echo $resultEdit['address']; ?>" required type="text" name="inputAddressReport" class="form-control" aria-describedby="addressHelpInline">
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="selectRoomReport" class="col-form-label">Ruang :</label>
                            </div>
                            <div class="col-3">
                                <select name="selectRoomReport" class="form-select" aria-label="selectRoom" required>
                                    <option disabled selected hidden value="">-</option>
                                    <?php foreach ($resultRoom as $dataRoom) : ?>
                                        <option <?php if ($edit) {
                                                    if ($resultEdit['room'] == $dataRoom['room_kd']) echo 'selected';
                                                } ?> value="<?= $dataRoom['room_kd']; ?>">
                                            <?= $dataRoom['room_name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-3 d-flex">
                                <label for="selectClassReport" class="col-form-label me-2">Kelas:</label>
                                <select required name="selectClassReport" class="form-select" aria-label="selectClass">
                                    <option disabled selected hidden value="">-</option>
                                    <option <?php if ($edit) {
                                                if ($resultEdit['class'] == 'A') echo 'selected';
                                            } ?> value="A">A</option>
                                    <option <?php if ($edit) {
                                                if ($resultEdit['class'] == 'B') echo 'selected';
                                            } ?> value="B">B</option>
                                    <option <?php if ($edit) {
                                                if ($resultEdit['class'] == 'C') echo 'selected';
                                            } ?> value="C">C</option>
                                </select>
                            </div>
                            <div class="col-4 d-flex">
                                <label for="selectStatusReport" class="col-form-label me-2">Status:</label>
                                <select required name="selectStatusReport" class="form-select" aria-label="selectStatus">
                                    <option disabled selected hidden value="">-</option>
                                    <option <?php if ($edit) {
                                                if ($resultEdit['status'] == 'bpjs') echo 'selected';
                                            } ?> value="bpjs">BPJS</option>
                                    <option <?php if ($edit) {
                                                if ($resultEdit['status'] == 'reguler') echo 'selected';
                                            } ?> value="reguler">Reguler</option>
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="inputDescClinicReport" class="col-form-label">Ket Klinik :</label>
                            </div>
                            <div class="col-10">
                                <input value="<?php if ($edit) echo $resultEdit['desc_clinic']; ?>" required type="text" name="inputDescClinicReport" class="form-control" aria-describedby="descClinicHelpInline">
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-2 text-end">
                                <label for="inputPhoneNumberReport" class="col-form-label">No. HP :</label>
                            </div>
                            <div class="col-10">
                                <input value="<?php if ($edit) echo $resultEdit['phone']; ?>" required type="text" name="inputPhoneNumberReport" class="form-control" aria-describedby="phoneNumberHelpInline">
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="inputRequestDoctorReport" class="col-form-label">Dokter Pengirim :</label>
                            </div>
                            <div class="col-10">
                                <input value="<?php if ($edit) echo $resultEdit['reqdoc']; ?>" required type="text" name="inputRequestDoctorReport" class="form-control" aria-describedby="requestDoctorHelpInline">
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="selectAccDoctorReport" class="col-form-label">Dokter ACC :</label>
                            </div>
                            <div class="col-10">
                                <select required name="selectAccDoctorReport" class="form-select" aria-label="selectStatus">
                                    <option disabled selected hidden value="">-</option>
                                    <?php foreach ($resultValidator as $value) : ?>
                                        <option value="<?= $value['username']; ?>" <?php if ($value['username'] == $resultEdit['accdoc']) echo 'selected' ?>><?= $value['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="selectPetugasReport" class="col-form-label">Petugas :</label>
                            </div>
                            <div class="col-10">
                                <select required name="selectPetugasReport" class="form-select" aria-label="selectStatus">
                                    <option disabled selected hidden value="">-</option>
                                    <?php foreach ($resultPetugas as $value) : ?>
                                        <option value="<?= $value['username']; ?>" <?php if ($value['username'] == $resultEdit['petugas']) echo 'selected' ?>><?= $value['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="inputPesanReport" class="col-form-label">Pesan :</label>
                            </div>
                            <div class="col-10">
                                <input value="<?php if ($edit) echo $resultEdit['pesan']; ?>" required name="inputPesanReport" type="text" class="form-control" aria-describedby="massagePatientHelpInline">
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="inputKesanReport" class="col-form-label">Kesan :</label>
                            </div>
                            <div class="col-10">
                                <input value="<?php if ($edit) echo $resultEdit['kesan']; ?>" required type="text" name="inputKesanReport" class="form-control" aria-describedby="impressionPatientHelpInline">
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="samplePatient" class="col-form-label">Sample :</label>
                            </div>
                            <div class="col-10 d-flex">
                                <div class="form-check me-2">
                                    <input <?php if ($edit) if ($resultEdit['sample'] == 'normal') echo 'checked'; ?> required value="normal" class="form-check-input" type="radio" name="radioSampleReport" id="flexRadioSampleNormal">
                                    <label class="form-check-label" for="flexRadioSampleNormal">
                                        Normal
                                    </label>
                                </div>
                                <div class="form-check me-2">
                                    <input <?php if ($edit) if ($resultEdit['sample'] == 'ikterik') echo 'checked'; ?> value="ikterik" class="form-check-input" type="radio" name="radioSampleReport" id="flexRadioSampleIkterik">
                                    <label class="form-check-label" for="flexRadioSampleIkterik">
                                        Ikterik
                                    </label>
                                </div>
                                <div class="form-check me-2">
                                    <input <?php if ($edit) if ($resultEdit['sample'] == 'lisis') echo 'checked'; ?> value="lisis" class="form-check-input" type="radio" name="radioSampleReport" id="flexRadioSampleLisis">
                                    <label class="form-check-label" for="flexRadioSampleLisis">
                                        Lisis
                                    </label>
                                </div>
                                <div class="form-check me-2">
                                    <input <?php if ($edit) if ($resultEdit['sample'] == 'lipemik') echo 'checked'; ?> value="lipemik" class="form-check-input" type="radio" name="radioSampleReport" id="flexRadioSampleLipemik">
                                    <label class="form-check-label" for="flexRadioSampleLipemik">
                                        Lipemik
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="selectSampleCategoryReport" class="col-form-label">Jenis Sample :</label>
                            </div>
                            <div class="col-10">
                                <select name="selectSampleCategoryReport" class="form-select" aria-label="selectStatusPatient">
                                    <option disabled selected hidden value="">-</option>
                                    <?php foreach ($catSampleResult as $dataCatSample) : ?>
                                        <option value="<?= $dataCatSample['kd_category']; ?>" <?php if ($edit) if ($resultEdit['sample_category'] == $dataCatSample['kd_category']) echo 'selected'; ?>>
                                            <?= $dataCatSample['name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="inputNotesReport" class="form-label">Catatan :</label>
                            </div>
                            <div class="col-10">
                                <textarea class="form-control" name="inputNotesReport" rows="2"><?php if ($edit) echo $resultEdit['notes']; ?></textarea>
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="selectPackageReport" class="form-label">Paket :</label>
                            </div>
                            <div class="col-10">
                                <select required name="selectPackageReport" class="form-select" aria-label="packagePatient">
                                    <option disabled selected hidden value="">-</option>
                                    <option value="Paket 1" <?php if ($edit) if ($resultEdit['paket'] == 'Paket 1') echo 'selected'; ?>>Paket 1</option>
                                    <option value="Paket 2" <?php if ($edit) if ($resultEdit['paket'] == 'Paket 2') echo 'selected'; ?>>Paket 2</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 align-items-center mt-4 mb-4 text-center">
                        <input name="submit_report" type="submit" class="btn btn-success me-2 ps-4 pe-4" value="Simpan" />
                        <?php if ($edit) { ?>
                            <a href="./delete_report.php?nota=<?= $resultEdit['nota']; ?>" onclick="return confirm('Hapus Data Pasien?');" class="btn btn-danger ps-4 pe-4">Hapus</a>
                        <?php }  ?>
                    </div>
                </div>
            </form>
        </div>
        <?php if ($edit) { ?>
            <form method="POST" action="action_sample.php?nota=<?= $nota; ?>" id="formSample">
                <div class="bg-surface p-3 border d-flex align-items-center">
                    <h6 class="me-4 ">Hasil Pemeriksaan</h6>
                    <div class="d-inline">
                        <?php if ($resultEdit['date_acc'] == null) { ?>
                            <input type="submit" name="save_sample" class="btn btn-success" value="Simpan" />
                            <input type="submit" name="finish_sample" class="btn btn-primary" value="Selesai" />

                            <?php if ($resultEdit['date_finish'] != null) { ?>
                                <input type="submit" name="transmit_sample" class="btn btn-warning" value="Kirim" />
                            <?php } ?>
                        <?php } ?>
                        <?php if ($resultEdit['date_acc'] != null) { ?>
                            <a href="print.php?nota=<?= $resultEdit['nota']; ?>" target="_blank" class="btn btn-info">
                                Print
                            </a>
                        <?php } ?>
                    </div>
                </div>

                <div class="table-responsive-lg">
                    <table class="table table-bordered border-dark table-input-sample">
                        <thead>
                            <tr>
                                <th scope="col" width="4%"></th>
                                <th scope="col" width="32%" class="text-center">Pemeriksaan</th>
                                <th scope="col" width="12%" class="text-center">Hasil</th>
                                <th scope="col" width="14%" class="text-center">Flag</th>
                                <th scope="col" class="text-center">Rujukan</th>
                                <th scope="col" class="text-center">Satuan</th>
                                <th scope="col" class="text-center">Metode</th>
                            </tr>
                        </thead>
                        <?php $count = 1; ?>
                        <?php foreach ($resultSample as $sampleData) : ?>
                            <tbody>
                                <td class="text-center"><?= $count; ?></td>
                                <td><?= $sampleData['name']; ?></td>
                                <td class="text-center">
                                    <?php if ($resultEdit['date_acc'] == null) { ?>
                                        <input id="input<?= $sampleData['kd_sub_category_sample']; ?>" onchange="setFlag(<?= $sampleData['min_value']; ?>, <?= $sampleData['max_value']; ?>, '<?= $sampleData['kd_sub_category_sample']; ?>')" value="<?= $sampleData['value']; ?>" name="input<?= $sampleData['kd_sub_category_sample']; ?>" placeholder="<?= $sampleData['name']; ?>" class="form-control" type="number" step='0.01'>
                                    <?php } else { ?>
                                        <span>
                                            <?= $sampleData['value']; ?>
                                        </span>
                                    <?php } ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($resultEdit['date_acc'] == null) { ?>
                                        <span id="flag<?= $sampleData['kd_sub_category_sample']; ?>"></span>
                                        <input type="text" id="flagInput<?= $sampleData['kd_sub_category_sample']; ?>" name="flagInput<?= $sampleData['kd_sub_category_sample']; ?>" class="d-none">
                                    <?php } else { ?>
                                        <span class="<?php if ($sampleData['flag'] != 'normal') echo 'text-danger text-bold' ?>">
                                            <?= strtoupper($sampleData['flag']); ?>
                                        </span>
                                    <?php } ?>
                                </td>
                                <td class="text-center"><?php echo $sampleData['min_value'] . ' - ' . $sampleData['max_value']; ?></td>
                                <td class="text-center"><?= $sampleData['satuan']; ?></td>
                                <td class="text-center"><?php if ($sampleData['metode'] == null) {
                                                            echo '-';
                                                        } else {
                                                            echo $sampleData['metode'];
                                                        } ?></td>

                            </tbody>
                            <?php $count++; ?>
                        <?php endforeach; ?>
                    </table>
                </div>
            </form>
        <?php } ?>
    </div>
</body>

<script>
    <?php if ($resultEdit['date_acc'] == null) { ?>
        <?php foreach ($resultSample as $dataSample) : ?>
            var flagSpan = 'flag' + '<?= $dataSample['kd_sub_category_sample']; ?>';
            var flagInput = 'flagInput' + '<?= $dataSample['kd_sub_category_sample']; ?>';
            var inputId = 'input' + '<?= $dataSample['kd_sub_category_sample']; ?>';
            var min = <?= $dataSample['min_value']; ?>;
            var max = <?= $dataSample['max_value']; ?>;
            var value = document.getElementById(inputId).value;
            if (value != '') {
                if (value < min) {
                    document.getElementById(flagSpan).innerHTML = 'LOW';
                    document.getElementById(flagInput).value = 'low';
                    document.getElementById(flagSpan).classList.add('text-danger', 'text-bold');
                } else if (value > max) {
                    document.getElementById(flagSpan).innerHTML = 'HIGH';
                    document.getElementById(flagInput).value = 'high';
                    document.getElementById(flagSpan).classList.add('text-danger', 'text-bold');
                } else {
                    document.getElementById(flagSpan).innerHTML = 'NORMAL';
                    document.getElementById(flagInput).value = 'normal';
                    document.getElementById(flagSpan).classList.remove('text-danger', 'text-bold');
                }
            }
        <?php endforeach; ?>
    <?php } ?>

    if (document.getElementById("birthdayReport").value != '') {
        getAgeBirthday();
    }
    // kalkulasi umur
    function getAgeBirthday() {
        var today = new Date();
        var birthday = new Date(document.getElementById("birthdayReport").value);

        var yearNow = today.getFullYear();
        var monthNow = today.getMonth();
        var dateNow = today.getDate();

        var yearBirth = birthday.getFullYear();
        var monthBirth = birthday.getMonth();
        var dateBirth = birthday.getDate();

        if (dateNow >= dateBirth) {
            document.getElementById("inputAgeDate").value = (dateNow - dateBirth);
        } else {
            monthBirth--;

            document.getElementById("inputAgeDate").value = 31 + dateNow - dateBirth;

            if (monthBirth < 0) {
                monthBirth = 11;
                yearBirth--;
            }
            document.getElementById("inputAgeDate").value = (dateNow - dateBirth + 30);

        }
        if (monthNow >= monthBirth) {
            document.getElementById("inputAgeMonth").value = (monthNow - monthBirth);
        } else {
            yearNow = yearNow - 1;
            document.getElementById("inputAgeMonth").value = (monthNow - monthBirth + 12);
        }

        document.getElementById("inputAgeYear").value = yearNow - yearBirth;
    }

    function setFlag(min, max, kode) {
        var flagSpan = 'flag' + kode;
        var flagInput = 'flagInput' + kode;
        var inputId = 'input' + kode;
        var value = document.getElementById(inputId).value;
        if (value < min) {
            document.getElementById(flagSpan).innerHTML = 'LOW';
            document.getElementById(flagInput).value = 'low';
            document.getElementById(flagSpan).classList.add('text-danger', 'text-bold');
        } else if (value > max) {
            document.getElementById(flagSpan).innerHTML = 'HIGH';
            document.getElementById(flagInput).value = 'high';
            document.getElementById(flagSpan).classList.add('text-danger', 'text-bold');
        } else {
            document.getElementById(flagSpan).innerHTML = 'NORMAL';
            document.getElementById(flagInput).value = 'normal';
            document.getElementById(flagSpan).classList.remove('text-danger', 'text-bold');
        }

    }

    function onHide() {
        document.getElementById('patientSection').classList.add('d-none');
    }

    function onShow() {
        document.getElementById('patientSection').classList.remove('d-none');
    }
</script>

</html>