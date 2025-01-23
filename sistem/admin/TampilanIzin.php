<?php
include '../Connect.php';
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['id'])) {
    die("<script language=\"Javascript\">alert(\"Silahkan Login Terlebih Dahulu\");document.location.href = 'index.php' </script>");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Tidak Hadir - TADIKA MESRA</title>
    <link rel="shortcut icon" href="../img/IP.png"/>
    <link rel="stylesheet" href="../assets/css/TampilanIzin.css"> <!-- Path CSS -->
</head>
<body>

<!-- Navbar -->
<nav>
  <a class="navbar-brand" href="#">TADIKA MESRA</a>
  <ul>
    <li><a href="beranda.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
    <li><a href="murid.php"><span class="glyphicon glyphicon-list"></span> Data Siswa</a></li>
    <li><a href="kehadiran.php"><span class="glyphicon glyphicon-list"></span> Kehadiran</a></li>
    <li class="active"><a><span class="glyphicon glyphicon-list-alt"> </span> Tidak Hadir</a></li>
    <li class="navbar-right"><a><span class="glyphicon glyphicon-user"></span>
        <?php
        $queri1 = mysqli_query($link,"SELECT *FROM admin WHERE Id LIKE '".$_SESSION['id']."' ");
        $nama = mysqli_fetch_array($queri1);
        echo $nama['nama']; ?>
    </a></li>
    <li><a href="ProsesLogoutAdmin.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
  </ul>
</nav>

<!-- Main Content -->
<div class="container">
  <div class="panel panel-info">
    <div class="panel-heading">
      <h1>Siswa Tidak Hadir</h1>
    </div>
        <div class="panel-body">
            <form method="GET" action="" class="input-group">
                <input type="text" name="search" placeholder="Cari Nama">
                <button type="submit" name="cr"><i class="glyphicon glyphicon-search"></i> Cari</button>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama Lengkap</th>
                        <th>Kelas</th>
                        <th colspan="2">Alasan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $halaman = 20;
                    $page = isset($_GET["halaman"]) ? (int)$_GET["halaman"] : 1;
                    $mulai = ($page > 1) ? ($page * $halaman) - $halaman : 0;
                    $query = "SELECT * FROM murid LIMIT $mulai, $halaman";
                    $hasil = mysqli_query($link, $query);
                    $no = $mulai + 1;

                    if (isset($_GET['cr'])) {
                        $cari = $_GET['search'];
                        $hasil = mysqli_query($link, "SELECT * FROM murid WHERE Namalengkap LIKE '%" . $cari . "%' LIMIT $mulai, $halaman");
                    }

                    $n = 1;
                    while ($data = mysqli_fetch_array($hasil)) {
                        echo "<tr>
                            <td>" . $n . "</td>
                            <td>" . $data['NIS'] . "</td>
                            <td>" . $data['Namalengkap'] . "</td>
                            <td>" . $data['Kelas'] . "</td>
                            <td><a href='prosesSakit.php?NIS=" . $data['NIS'] . "'>Sakit</a></td>
                            <td><a href='prosesIzin.php?NIS=" . $data['NIS'] . "'>Izin</a></td>
                        </tr>";
                        $n++;
                    }
                    ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination">
                <?php
                $result = mysqli_query($link, "SELECT * FROM murid");
                $total = mysqli_num_rows($result);
                $pages = ceil($total / $halaman);
                for ($i = 1; $i <= $pages; $i++) {
                    echo "<li><a href='?halaman=" . $i . "'>" . $i . "</a></li>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

</body>
</html>
