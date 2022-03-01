<!DOCTYPE html>
<?php
include 'config.php';

error_reporting(0);

session_start();

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['username'];
        header("Location: dashboard.php");
    } else {
        echo "<script>alert('Username atau password Anda salah. Silahkan coba lagi!')</script>";
    }
} ?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="css/style-main.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <title>Mediclab - Login</title>
</head>

<body class="bg-primary body-login">

    <div>
        <div class="container pt-4 pb-2">
            <h4><b class="text-white">MEDICLAB</b></h4>
        </div>
        <div class="form-login align-center bg-light">
            <form action="" method="POST">
                <h4 class="text-primary"><b>Login</b></h4>
                <div class="mt-4">
                    <input type="username" name="username" class="form-control" id="inputUsername" placeholder="Username" required>
                </div>
                <div class="mt-2">
                    <input type="password" name="password" class=" form-control" id="inputPassword" placeholder="Password" required>
                </div>
                <div class="mt-4 text-end">
                    <button name="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>


    <script src="js/bootstrap.bundle.min.js"></script>

</body>

</html>