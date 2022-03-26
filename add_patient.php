<?php

// Starter
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
    $resultValidatorSql = "SELECT * FROM users WHERE jabatan='validator'";
    $resultValidator = mysqli_query($conn, $resultValidatorSql);

    $resultPetugasSql = "SELECT * FROM users WHERE jabatan='petugas'";
    $resultPetugas = mysqli_query($conn, $resultPetugasSql);
} else {
    header("Location: ./");
}


// Random Lab Number
function generateLabNumber()
{
    $invID = str_pad(1, 3, '0', STR_PAD_LEFT); // Must be resolve
    $timeNow = date('Ymd') . $invID;
    echo $timeNow;
}

// Random Trans Number
function generateTransNumber()
{
    echo strtoupper(uniqid());
}

function onPress()
{
    echo "<script>alert('Username atau password Anda salah. Silahkan coba lagi!')</script>";
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
    <div class="header bg-primary mb-4">
        <div class="container d-flex justify-content-between pt-4 pb-2">
            <a href="./">
                <h3 class="text-light"><b>MEDICLAB</b></h3>
            </a>
            <div class="d-flex align-items-center">
                <h5 class="mr-4 text-light">Selamat pagi, <?= $name ?></h5>
                <div style="min-width:40px"></div>
                <a href="logout.php"><button class="btn btn-light">Logout</button></a>
            </div>
        </div>
    </div>

    <!-- Add Patient Form -->
    <div class="ps-4 pe-4">
        <div class="bg-surface p-3 rounded-top border">
            <h6>Data Pasien</h6>
            <div class="d-inline">
                <button type="button" class="btn btn-primary">Hide</button>
                <button type="button" class="btn btn-primary">Show</button>
                <button type="button" class="btn btn-primary">Order</button>
                <a href="./worklist.php"><button type="button" class="btn btn-primary">Back</button></a>
            </div>
        </div>
        <div class="border p-3">
            <form method="POST" action="insert_report.php">
                <div class="row table-responsive">
                    <div class="col-12 col-md-6">
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end text-end">
                                <label for="inputDateReport" class="col-form-label">Tanggal :</label>
                            </div>
                            <div class="col-4">
                                <input name="inputDateReport" readonly class="form-control" aria-describedby="dateHelpInline" value="<?= date("Y-m-d H:i"); ?>">
                            </div>
                            <div class="col-2 text-end">
                                <label for="inputLabNumberReport" class="col-form-label">No. Lab :</label>
                            </div>
                            <div class="col-4">
                                <input type="number" name="inputLabNumberReport" class="form-control" aria-describedby="inputLabNumberHelpInline" readonly value="<?php generateLabNumber() ?>">
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="inputRegNumberReport" class="col-form-label">No. RM :</label>
                            </div>
                            <div class="col-4">
                                <input type="number" name="inputRegNumberReport" class="form-control" aria-describedby="regNumberHelpInline">
                            </div>
                            <div class="col-2 text-end">
                                <label for="inputNotaReport" class="col-form-label">Nota :</label>
                            </div>
                            <div class="col-4">
                                <input type="text" name="inputNotaReport" class="form-control" aria-describedby="inputNotaHelpInline" readonly value="<?php generateTransNumber() ?>">
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="inputNikReport" class="col-form-label">NIK :</label>
                            </div>
                            <div class="col-10">
                                <input type="text" name="inputNikReport" class="form-control" aria-describedby="nikHelpInline">
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="inputNameReport" class="col-form-label">Nama :</label>
                            </div>
                            <div class="col-10">
                                <input type="text" name="inputNameReport" class="form-control" aria-describedby="nameHelpInline">
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="birthDayReport" class="col-form-label">Tgl. Lahir :</label>
                            </div>
                            <div class="col-4">
                                <input id="birthdayReport" name="inputBirthdayReport" type="date" class="form-control" aria-describedby="birthdayHelpInline" onchange="getAgeBirthday()">
                            </div>
                            <div class="col-2 text-end">
                                <label for="selectGenderReport" class="col-form-label">Jenis Kelamin</label>
                            </div>
                            <div class="col-4">
                                <select name="selectGenderReport" class="form-select" aria-label="select-jk">
                                    <option disabled selected hidden>-</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
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
                                <input type="text" name="inputAddressReport" class="form-control" aria-describedby="addressHelpInline">
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="selectRoomReport" class="col-form-label">Ruang :</label>
                            </div>
                            <div class="col-3">
                                <select name="selectRoomReport" class="form-select" aria-label="selectRoom">
                                    <option disabled selected hidden>-</option>
                                    <option value="kalibiru1">KALIBIRU 1</option>
                                    <option value="kalibiru2">KALIBIRU 2</option>
                                </select>
                            </div>
                            <div class="col-3 d-flex">
                                <label for="selectClassReport" class="col-form-label me-2">Kelas:</label>
                                <select name="selectClassReport" class="form-select" aria-label="selectClass">
                                    <option disabled selected hidden>-</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                </select>
                            </div>
                            <div class="col-4 d-flex">
                                <label for="selectStatusReport" class="col-form-label me-2">Status:</label>
                                <select name="selectStatusReport" class="form-select" aria-label="selectStatus">
                                    <option disabled selected hidden>-</option>
                                    <option value="bpjs">BPJS</option>
                                    <option value="reguler">Reguler</option>
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="inputDescClinicReport" class="col-form-label">Ket Klinik :</label>
                            </div>
                            <div class="col-10">
                                <input type="text" name="inputDescClinicReport" class="form-control" aria-describedby="descClinicHelpInline">
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-2 text-end">
                                <label for="inputPhoneNumberReport" class="col-form-label">No. HP :</label>
                            </div>
                            <div class="col-10">
                                <input type="text" name="inputPhoneNumberReport" class="form-control" aria-describedby="phoneNumberHelpInline">
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="row align-items-center mb-1">
                            <div class="col-3 text-end">
                                <label for="inputRequestDoctorReport" class="col-form-label">Dokter Pengirim :</label>
                            </div>
                            <div class="col-9">
                                <input type="text" name="inputRequestDoctorReport" class="form-control" aria-describedby="requestDoctorHelpInline">
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-3 text-end">
                                <label for="selectAccDoctorReport" class="col-form-label">Dokter ACC :</label>
                            </div>
                            <div class="col-9">
                                <select name="selectAccDoctorReport" class="form-select" aria-label="selectStatus">
                                    <option selected hidden>-</option>
                                    <?php foreach ($resultValidator as $value) : ?>
                                        <option value="<?= $value['username']; ?>"><?= $value['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-3 text-end">
                                <label for="selectPetugasReport" class="col-form-label">Petugas :</label>
                            </div>
                            <div class="col-9">
                                <select name="selectPetugasReport" class="form-select" aria-label="selectStatus">
                                    <option selected hidden>-</option>
                                    <?php foreach ($resultPetugas as $value) : ?>
                                        <option value="<?= $value['username']; ?>"> <?= $value['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-3 text-end">
                                <label for="inputPesanReport" class="col-form-label">Pesan :</label>
                            </div>
                            <div class="col-9">
                                <input name="inputPesanReport" type="text" class="form-control" aria-describedby="massagePatientHelpInline">
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-3 text-end">
                                <label for="inputKesanReport" class="col-form-label">Kesan :</label>
                            </div>
                            <div class="col-9">
                                <input type="text" name="inputKesanReport" class="form-control" aria-describedby="impressionPatientHelpInline">
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-3 text-end">
                                <label for="samplePatient" class="col-form-label">Sample :</label>
                            </div>
                            <div class="col-9 d-flex">
                                <div class="form-check me-2">
                                    <input value="normal" class="form-check-input" type="radio" name="radioSampleReport" id="flexRadioSampleNormal" checked>
                                    <label class="form-check-label" for="flexRadioSampleNormal">
                                        Normal
                                    </label>
                                </div>
                                <div class="form-check me-2">
                                    <input value="ikterik" class="form-check-input" type="radio" name="radioSampleReport" id="flexRadioSampleIkterik">
                                    <label class="form-check-label" for="flexRadioSampleIkterik">
                                        Ikterik
                                    </label>
                                </div>
                                <div class="form-check me-2">
                                    <input value="lisis" class="form-check-input" type="radio" name="radioSampleReport" id="flexRadioSampleLisis">
                                    <label class="form-check-label" for="flexRadioSampleLisis">
                                        Lisis
                                    </label>
                                </div>
                                <div class="form-check me-2">
                                    <input value="lipemik" class="form-check-input" type="radio" name="radioSampleReport" id="flexRadioSampleLipemik">
                                    <label class="form-check-label" for="flexRadioSampleLipemik">
                                        Lipemik
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-3 text-end">
                                <label for="selectSampleCategoryReport" class="col-form-label">Jenis Sample :</label>
                            </div>
                            <div class="col-9">
                                <select name="selectSampleCategoryReport" class="form-select" aria-label="selectStatusPatient">
                                    <option selected>-</option>
                                    <option value="hematologi">Hematologi</option>
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-3 text-end">
                                <label for="inputNotesReport" class="form-label">Catatan :</label>
                            </div>
                            <div class="col-9">
                                <textarea class="form-control" name="inputNotesReport" rows="2">-</textarea>
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-3 text-end">
                                <label for="selectPackageReport" class="form-label">Paket :</label>
                            </div>
                            <div class="col-9">
                                <select name="selectPackageReport" class="form-select" aria-label="packagePatient">
                                    <option selected>-</option>
                                    <option value="paket1">Paket 1</option>
                                    <option value="paket2">Paket 2</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 align-items-center mt-4 mb-4 text-center">
                        <input name="submit" type="submit" class="btn btn-success me-2" value="Submit" />
                        <button type="button" class="btn btn-primary me-1 ms-1">Reset</button>
                        <button type="button" class="btn btn-danger ms-2" on>Hapus</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="bg-surface p-3 rounded-bottom border d-flex align-items-center">
            <h6 class="me-4">Hasil Pemeriksaan</h6>
            <div class="d-inline">
                <button type="button" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-primary">All</button>
                <button type="button" class="btn btn-primary">Uncheck</button>
                <button type="button" class="btn btn-primary">Hapus</button>
                <button type="button" class="btn btn-primary">Tambah</button>
                <button type="button" class="btn btn-primary">Print</button>
                <button type="button" class="btn btn-primary">Print Group</button>
                <button type="button" class="btn btn-primary">Sinc</button>
                <button type="button" class="btn btn-primary">Diagnosa</button>
                <button type="button" class="btn btn-primary">Send</button>

            </div>
        </div>
    </div>

    <div class="ps-4 pe-4 mt-4 table-responsive-lg">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Pemeriksaan</th>
                    <th scope="col">Hasil</th>
                    <th scope="col">Flag</th>
                    <th scope="col">Rujukan</th>
                    <th scope="col">ACC</th>
                    <th scope="col">Satuan</th>
                    <th scope="col">Alat</th>
                    <th scope="col">Waktu</th>
                    <th scope="col">HISTORY</th>
                </tr>
            </thead>
            <tbody>
                <td>
                    <div style="min-height: 300px;"></div>
                </td>
            </tbody>
        </table>
    </div>
</body>

<script>
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
                yearAge--;
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
</script>

</html>