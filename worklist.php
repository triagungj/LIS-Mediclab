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
    <div class="header bg-primary">
        <div class="container d-flex justify-content-between pt-4 pb-2">
            <h3 class="text-light"><b>MEDICLAB</b></h3>
            <div class="d-flex align-items-center">
                <h5 class="mr-4 text-light">Selamat pagi, <?= $name ?></h5>
                <div style="min-width:40px"></div>
                <a href="logout.php"><button class="btn btn-light">Logout</button></a>
            </div>
        </div>
    </div>

    <form class="row row-cols-lg-auto g-3 align-items-center mt-2 mb-4 ms-2 me-2">
        <div class="col-2 col-lg-2">
            <label class="visually-hidden ml-4" for="inlineFormInputGroupDate">Tanggal</label>
            <div class="input-group">
                <input type="text" class="form-control" id="inlineFormInputGroupDate" placeholder="Tanggal">
            </div>
        </div>
        <div class="col-2 col-lg-2">
            <label class="visually-hidden ml-4" for="inlineFormInputGroupRegistNumber">No. RM</label>
            <div class="input-group">
                <input type="text" class="form-control" id="inlineFormInputGroupRegistNumber" placeholder="No. RM">
            </div>
        </div>
        <div class="col-2 col-lg-2">
            <label class="visually-hidden ml-4" for="inlineFormInputGroupName">Nama</label>
            <div class="input-group">
                <input type="text" class="form-control" id="inlineFormInputGroupName" placeholder="Nama">
            </div>
        </div>
        <div class="col-2 col-lg-2">
            <label class="visually-hidden ml-4" for="inlineFormInputGroupRoom">Ruang</label>
            <div class="input-group">
                <input type="text" class="form-control" id="inlineFormInputGroupRoom" placeholder="Ruang">
            </div>
        </div>

        <div class="col-4 col-lg-3">
            <button type="submit" class="btn btn-primary">Cari</button>
            <a href="./add_patient.php" class="btn btn-primary" type="submit" class="btn btn-primary">Tambah</a class="btn btn-primary">
        </div>

    </form>

    <div class="ms-3 me-3 table-responsive-lg">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">No Lab</th>
                    <th scope="col">No RM</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Ruang</th>
                    <th scope="col">No Trans</th>
                    <th scope="col">Status</th>
                    <th scope="col">Transmit</th>
                    <th scope="col">Barcode</th>
                    <th scope="col">Print</th>
                    <th scope="col">Diagnosa</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Data</td>
                    <td>Data</td>
                    <td>Data</td>
                    <td>Data</td>
                    <td>Data</td>
                    <td>Data</td>
                    <td class="text-center"><button class="btn btn-primary">Barcode</button></td>
                    <td class="text-center"><button class="btn btn-primary">Print</button></td>
                    <td class="text-center"><button class="btn btn-primary">Diagnosa</button></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Data</td>
                    <td>Data</td>
                    <td>Data</td>
                    <td>Data</td>
                    <td>Data</td>
                    <td>Data</td>
                    <td class="text-center"><button class="btn btn-primary">Barcode</button></td>
                    <td class="text-center"><button class="btn btn-primary">Print</button></td>
                    <td class="text-center"><button class="btn btn-primary">Diagnosa</button></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Data</td>
                    <td>Data</td>
                    <td>Data</td>
                    <td>Data</td>
                    <td>Data</td>
                    <td>Data</td>
                    <td class="text-center"><button class="btn btn-primary">Barcode</button></td>
                    <td class="text-center"><button class="btn btn-primary">Print</button></td>
                    <td class="text-center"><button class="btn btn-primary">Diagnosa</button></td>
                </tr>
            </tbody>
        </table>
    </div>


</body>

</html>