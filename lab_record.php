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
    <div class="header bg-primary mb-4">
        <div class="container d-flex justify-content-between pt-4 pb-2">
            <a href="./">
                <h3 class="text-light"><b>MEDICLAB</b></h3>
            </a>
            <div class="d-flex align-items-end">
                <h5 class="mr-4 text-light">Selamat pagi, <?= $name ?></h5>
                <div style="min-width:40px"></div>
                <a href="logout.php"><button class="btn btn-light">Logout</button></a>
            </div>
        </div>
    </div>
    <div class="d-inline container pt-4 align-middle">
        <input type="text" placeholder="Nomor RM" />
        <input type="text" placeholder="Nama Pasien">
        <input type="text" placeholder="Ruang">
        <button class="btn btn-primary">Cari</button>
    </div>
    <div class="row ms-2 me-2 mt-2">
        <div class="col-md-6 pe-2 ps-2">
            <div class="table-responsive-md">
                <div class="bg-surface p-2 rounded-top border">
                    <span>Daftar Pasien</span>
                </div>
                <div class="p3">
                    <table class="table table-bordered ">
                        <thead>
                            <tr>
                                <th scope="col">No Lab</th>
                                <th scope="col">No RM</th>
                                <th scope="col">Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Data</td>
                                <td>Data</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Data</td>
                                <td>Data</td>
                            </tr>
                            <tr>
                                <td>3</td>
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
                    <hr>

                    <div style="min-height: 200px;"></div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>