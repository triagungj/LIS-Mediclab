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
    <div class="header bg-primary mb-4">
        <div class="container d-flex justify-content-between pt-4 pb-2">
            <h3 class="text-light"><b>MEDICLAB</b></h3>
            <div class="d-flex align-items-center">
                <h5 class="mr-4 text-light">Selamat pagi, <?= $name ?></h5>
                <div style="min-width:40px"></div>
                <a href="logout.php"><button class="btn btn-light">Logout</button></a>
            </div>
        </div>
    </div>

    <div class="add-patient-content ps-4 pe-4">
        <div class="bg-surface p-3 rounded-top border">
            <h6>Data Pasien</h6>
            <div class="d-inline">
                <button type="button" class="btn btn-primary">Hide</button>
                <button type="button" class="btn btn-primary">Show</button>
                <button type="button" class="btn btn-primary">Order</button>
                <button type="button" class="btn btn-primary">Back</button>
            </div>
        </div>
        <div class="border p-3">
            <form>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end text-end">
                                <label for="inputDatePatient" class="col-form-label">Tanggal:</label>
                            </div>
                            <div class="col-4">
                                <input type="date" id="inputDatePatient" class="form-control" aria-describedby="datePatientHelpInline" disabled>
                            </div>
                            <div class="col-2 text-end">
                                <label for="inputLabNumberPatient" class="col-form-label">No. Lab:</label>
                            </div>
                            <div class="col-4">
                                <input type="number" id="inputLabNumberPatient" class="form-control" aria-describedby="inputLabNumberPatientHelpInline" disabled>
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="inputRegNumberPatient" class="col-form-label">No. RM:</label>
                            </div>
                            <div class="col-4">
                                <input type="number" id="inputRegNumberPatient" class="form-control" aria-describedby="regNumberPatientHelpInline" disabled>
                            </div>
                            <div class="col-2 text-end">
                                <label for="inputNotaPatient" class="col-form-label">Nota:</label>
                            </div>
                            <div class="col-4">
                                <input type="number" id="inputNotaPatient" class="form-control" aria-describedby="inputNotaPatientHelpInline" disabled>
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="inputNIKPatient" class="col-form-label">NIK:</label>
                            </div>
                            <div class="col-10">
                                <input type="text" id="inputNIKPatient" class="form-control" aria-describedby="nikPatientHelpInline">
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="inputNamePatient" class="col-form-label">Nama:</label>
                            </div>
                            <div class="col-10">
                                <input type="text" id="inputNamePatient" class="form-control" aria-describedby="namePatientHelpInline">
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="inputBirthDayPatient" class="col-form-label">Tgl. Lahir:</label>
                            </div>
                            <div class="col-4">
                                <input type="date" id="inputBirthDayPatient" class="form-control" aria-describedby="birthdayPatientHelpInline">
                            </div>
                            <div class="col-2 text-end">
                                <label for="inputBirthdayPatient" class="col-form-label">Jenis Kelamin</label>
                            </div>
                            <div class="col-4">
                                <select class="form-select" aria-label="select-jk">
                                    <option selected>Jenis Kelamin</option>
                                    <option value="L">Pria</option>
                                    <option value="P">Wanita</option>
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="inputBirthDayPatient" class="col-form-label">Umur:</label>
                            </div>
                            <div class="col-3">
                                <span class="col-form-label ms-1">Tahun</span>
                                <input type="text" disabled id="inputYearAgePatient" class="form-control" aria-describedby="yearAgePatientHelpInline" value="21">
                            </div>
                            <div class="col-3">
                                <span class="col-form-label ms-1">Bulan</span>
                                <input type="text" disabled id="inputYearAgePatient" class="form-control" aria-describedby="yearAgePatientHelpInline" value="8">
                            </div>
                            <div class="col-4">
                                <span class="col-form-label ms-1">Hari</span>
                                <input type="text" disabled id="inputYearAgePatient" class="form-control" aria-describedby="yearAgePatientHelpInline" value="15">
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="inputAddressPatient" class="col-form-label">Alamat:</label>
                            </div>
                            <div class="col-10">
                                <input type="text" id="inputAddressPatient" class="form-control" aria-describedby="addressPatientHelpInline">
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="selectRoomPatient" class="col-form-label">Ruang:</label>
                            </div>
                            <div class="col-3">
                                <select class="form-select" aria-label="selectRoomPatient">
                                    <option selected>-</option>
                                    <option value="kalibiru1">KALIBIRU 1</option>
                                    <option value="kalibiru2">KALIBIRU 2</option>
                                </select>
                            </div>
                            <div class="col-4 d-flex">
                                <label for="selectClassPatient" class="col-form-label me-2">Kelas:</label>
                                <select class="form-select" aria-label="selectClassPatient">
                                    <option selected>-</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                </select>
                            </div>
                            <div class="col-3 d-flex">
                                <label for="selectStatusPatient" class="col-form-label me-2">Status:</label>
                                <select class="form-select" aria-label="selectStatusPatient">
                                    <option selected>Status</option>
                                    <option value="bpjs">BPJS</option>
                                    <option value="reguler">Reguler</option>
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="descClinicPatient" class="col-form-label">Ket Klinik:</label>
                            </div>
                            <div class="col-10">
                                <input type="text" id="descClinicPatient" class="form-control" aria-describedby="descClinicPatientHelpInline">
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-2 text-end">
                                <label for="phoneNumberPatient" class="col-form-label">No. HP:</label>
                            </div>
                            <div class="col-10">
                                <input type="text" id="phoneNumberPatient" class="form-control" aria-describedby="phoneNumberPatientHelpInline">
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="phoneNumberPatient" class="col-form-label">Dokter Pengirim:</label>
                            </div>
                            <div class="col-10">
                                <input type="text" id="phoneNumberPatient" class="form-control" aria-describedby="phoneNumberPatientHelpInline">
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="select-status" class="col-form-label">Status:</label>
                            </div>
                            <div class="col-10">
                                <select class="form-select" aria-label="selectStatusPatient">
                                    <option selected>-</option>
                                    <option value="dr1">dr. Hendrawan Nugroho, M.Sc., Sp. PK</option>
                                    <option value="dr2">dr. Maulana Ibrahim, M.Sc., Sp. PK</option>
                                    <option value="dr3">dr. Bill Gates, M.Sc., Sp. PK</option>
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="select-status" class="col-form-label">Petugas:</label>
                            </div>
                            <div class="col-10">
                                <select class="form-select" aria-label="selectStatusPatient">
                                    <option selected>-</option>
                                    <option value="petugas1">BAMBANG HARIYADI</option>
                                    <option value="petugas2">MAULANA HARIYADI</option>
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="massagePatient" class="col-form-label">Pesan:</label>
                            </div>
                            <div class="col-10">
                                <input type="text" id="massagePatient" class="form-control" aria-describedby="massagePatientHelpInline">
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="impressionPatient" class="col-form-label">Kesan:</label>
                            </div>
                            <div class="col-10">
                                <input type="text" id="impressionPatient" class="form-control" aria-describedby="impressionPatientHelpInline">
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="samplePatient" class="col-form-label">Sample:</label>
                            </div>
                            <div class="col-10 d-flex">
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio" name="radioSample" id="flexRadioSampleNormal" checked>
                                    <label class="form-check-label" for="flexRadioSampleNormal">
                                        Normal
                                    </label>
                                </div>
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio" name="radioSample" id="flexRadioSampleIkterik">
                                    <label class="form-check-label" for="flexRadioSampleIkterik">
                                        Ikterik
                                    </label>
                                </div>
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio" name="radioSample" id="flexRadioSampleLisis">
                                    <label class="form-check-label" for="flexRadioSampleLisis">
                                        Lisis
                                    </label>
                                </div>
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio" name="radioSample" id="flexRadioSampleLipemik">
                                    <label class="form-check-label" for="flexRadioSampleLipemik">
                                        Lipemik
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="select-sample" class="col-form-label">Jenis Sample:</label>
                            </div>
                            <div class="col-10">
                                <select class="form-select" aria-label="selectStatusPatient">
                                    <option selected>-</option>
                                    <option value="hematologi">Hematologi</option>
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="notePatient" class="form-label">Catatan:</label>
                            </div>
                            <div class="col-10">
                                <textarea class="form-control" id="notePatient" rows="2">-</textarea>
                            </div>
                        </div>
                        <div class="row align-items-center mb-1">
                            <div class="col-2 text-end">
                                <label for="packagePatient" class="form-label">Paket:</label>
                            </div>
                            <div class="col-10">
                                <select class="form-select" aria-label="packagePatient">
                                    <option selected>-</option>
                                    <option value="package1">Paket 1</option>
                                    <option value="package2">Paket 2</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 align-items-center mt-4 text-center">
                        <button type="button" class="btn btn-success me-2">Save</button>
                        <button type="button" class="btn btn-primary me-1 ms-1">Reset</button>
                        <button type="button" class="btn btn-danger ms-2">Hapus</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>