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
                        <div class="row align-items-center">
                            <div class="col-2">
                                <label for="inputDatePatient" class="col-form-label">Tanggal</label>
                            </div>
                            <div class="col-4">
                                <input type="date" id="inputDatePatient" class="form-control" aria-describedby="datePatientHelpInline">
                            </div>
                            <div class="col-2">
                                <label for="inputLabNumberPatient" class="col-form-label">No. Lab</label>
                            </div>
                            <div class="col-4">
                                <input type="number" id="inputLabNumberPatient" class="form-control" aria-describedby="inputLabNumberPatientHelpInline">
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-2">
                                <label for="inputRegNumberPatient" class="col-form-label">No. RM</label>
                            </div>
                            <div class="col-4">
                                <input type="number" id="inputRegNumberPatient" class="form-control" aria-describedby="regNumberPatientHelpInline">
                            </div>
                            <div class="col-2">
                                <label for="inputNotaPatient" class="col-form-label">Nota</label>
                            </div>
                            <div class="col-4">
                                <input type="number" id="inputNotaPatient" class="form-control" aria-describedby="inputNotaPatientHelpInline">
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-2">
                                <label for="inputRegNumberPatient" class="col-form-label">Nama</label>
                            </div>
                            <div class="col-10">
                                <input type="text" id="inputRegNumberPatient" class="form-control" aria-describedby="regNumberPatientHelpInline">
                            </div>
                        </div>


                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="inputPassword6" class="col-form-label">Password</label>
                            </div>
                            <div class="col-auto">
                                <input type="password" id="inputPassword6" class="form-control" aria-describedby="passwordHelpInline">
                            </div>
                            <div class="col-auto">
                                <span id="passwordHelpInline" class="form-text">
                                    Must be 8-20 characters long.
                                </span>
                            </div>
                        </div>
                    </div>


                </div>
            </form>
        </div>
    </div>
</body>

</html>