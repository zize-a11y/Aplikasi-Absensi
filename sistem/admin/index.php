<?php
include 'ProsesLoginAdmin.php';
include '../connect.php';

$login = new ProsesLoginAdmin($link);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['masuk'])) {
        $login->login($_POST['admin'], $_POST['pass']);
    } elseif (isset($_POST['kembali'])) {
        header('Location: ../index.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TK TADIKA MESRA - Login</title>
    <link rel="shortcut icon" href="../img/IP.png"/>
    <link rel="stylesheet" href="../assets/css/index.css"> <!-- Path CSS -->
</head>
<body class="background"> <!-- Tambahkan class background -->
<div class="container">
    <div class="header">
        <img src="../img/IP.png" alt="Logo TK TADIKA MESRA">
        <h1>TK TADIKA MESRA</h1>
        <p>Kampung Durian Runtuh, Dusun Pempioang, Desa Tampalang</p>
    </div>
    <form name="login" method="post" action="">
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="glyphicon glyphicon-user"></i>
                </div>
                <input type="text" name="admin" id="admin" placeholder="Masukan ID Pengguna"
                       class="form-control text-center" required>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="glyphicon glyphicon-lock"></i>
                </div>
                <input type="password" name="pass" placeholder="Masukan Kata Sandi Pengguna"
                       class="form-control text-center" required>
            </div>
        </div>
        <div class="panel-footer">
            <div class="row">
                <button type="button" name="kembali" class="btn btn-success"
                        onclick="window.location = '../index.php'"><i class="glyphicon glyphicon-home"></i> Kembali
                </button>
                <button type="submit" name="masuk" class="btn btn-primary"><i
                            class="glyphicon glyphicon-log-in"></i> Masuk
                </button>
            </div>
        </div>
    </form>
</div>
</body>
</html>
