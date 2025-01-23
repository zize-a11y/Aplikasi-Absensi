<html>
<?php
include "../connect.php";
session_start();
//cek apakah user sudah login
if(!isset($_SESSION['id'])){
    die("<script language=\"Javascript\">alert(\"Silahkan Login Terlebih Dahulu\");document.location.href = 'index.php' </script>");
}
?>
<head>
    <title>TK TADIKA MESRA</title>
    <link rel="shortcut icon" href="../img/IP.png"/>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../assets/css/Kehadiran.css"> <!-- Path CSS -->
</head>

<body>

<!-- Navbar -->
<nav>
  <a class="navbar-brand" href="#">TK TADIKA MESRA</a>
  <ul>
    <li><a href="beranda.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
    <li><a href="murid.php"><span class="glyphicon glyphicon-list"></span> Data Siswa</a></li>
    <li class="active"><a><span class="glyphicon glyphicon-list-alt"></span> Kehadiran</a></li>
    <li><a href="TampilanIzin.php"><span class="glyphicon glyphicon-tasks"></span> Tidak Hadir</a></li>
    <li class="navbar-right"><a><span class="glyphicon glyphicon-user"></span>
        <?php
        $queri1 = mysqli_query($link,"SELECT *FROM admin WHERE Id LIKE '".$_SESSION['id']."' ");
        $nama = mysqli_fetch_array($queri1);
        echo $nama['nama']; ?>
    </a></li>
    <li><a href="ProsesLogoutAdmin.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
  </ul>
</nav>

<div class="container">
  <div class="panel panel-info">
    <div class="panel-heading">
      <h1>Kehadiran Siswa</h1>
    </div>

    <div class="panel-body">
      
        <!-- Search Form -->
        <form name="cari" method="GET" action="" class="input-group">
          <input type="text" name="search" class="form-control" placeholder="Cari Nama">
          <input type="date" name="tgl" class="form-control" placeholder="Masukkan Tanggal">
          <button type="submit" name="cr" class="btn btn-info"><i class="glyphicon glyphicon-search"></i> Cari</button>
        </form>

      <!-- Data Table -->
      <div class="table-responsive">
        <table name="kehadiran" class="table table-bordered table-striped">
          <thead>
            <tr class="info">
              <th>No</th>
              <th>NIS</th>
              <th>Nama Lengkap</th>
              <th>Kelas</th>
              <th>Tanggal & Waktu</th>
              <th>Hadir</th>
              <th>Telat</th>
              <th>Izin</th>
              <th>Sakit</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $halaman = 10;
            $page = isset($_GET["halaman"]) ? (int)$_GET["halaman"] : 1;
            $mulai = ($page > 1) ? ($page * $halaman) - $halaman : 0;
            $hasil = mysqli_query($link,"SELECT * FROM jmlkehadiran");
            $result = mysqli_num_rows($hasil);
            $pages = ceil($result / $halaman);
            $query = mysqli_query($link,"SELECT * FROM jmlkehadiran LIMIT $mulai, $halaman");

            if(isset($_GET['cr'])){
                $cari = $_GET['search'];
                $hari = $_GET['tgl'];
                $query = mysqli_query($link,"SELECT * FROM jmlkehadiran WHERE Namalengkap LIKE '%$cari%' AND Tanggal LIKE '%$hari%' ORDER BY Tanggal DESC LIMIT $mulai, $halaman");
            }

            $no = $mulai + 1;
            while ($data = mysqli_fetch_array($query)) {
                // Handling attendance status
                $hadir = $telat = $sakit = $izin = $ver = '';
                if ($data['Hadir'] == 1) {
                    $hadir = "<span class='glyphicon glyphicon-ok'></span>";
                } elseif ($data['Telat'] == 1) {
                    $telat = "<span class='glyphicon glyphicon-ok'></span>";
                } elseif ($data['Izin'] == 1) {
                    $izin = "<span class='glyphicon glyphicon-ok'></span>";
                    $ver = ($data['Verifikasi'] == 0) ? "<a href='verifikasi.php?NIS=".$data['NIS']."&tanggal=".$data['Tanggal']."' class='btn btn-success btn-sm'> Verifikasi </a>" : "Sudah Di verifikasi";
                } elseif ($data['Sakit'] == 1) {
                    $sakit = "<span class='glyphicon glyphicon-ok'></span>";
                    $ver = ($data['Verifikasi'] == 0) ? "<a href='verifikasi.php?NIS=".$data['NIS']."&tanggal=".$data['Tanggal']."' class='btn btn-success btn-sm'> Verifikasi </a>" : "Sudah Di verifikasi";
                }

                echo "<tr>
                        <td>".$no++."</td>
                        <td>".$data['NIS']."</td>
                        <td>".$data['Namalengkap']."</td>
                        <td>".$data['Kelas']."</td>
                        <td>".$data['Tanggal']."</td>
                        <td>".$hadir."</td>
                        <td>".$telat."</td>
                        <td>".$izin."</td>
                        <td>".$sakit."</td>
                        <td>".$ver."</td>
                        <td><a href='hapusdata.php?NIS=".$data['NIS']."&Tanggal=".$data['Tanggal']."' class='btn btn-danger btn-sm' onClick='return confirm(\"Apakah anda yakin menghapusnya?\")'><span class='glyphicon glyphicon-erase'></span> Hapus Data</a></td>
                    </tr>";
            }
            ?>
          </tbody>
        </table>

        <!-- Pagination -->
        <div class="panel-footer">
          <ul class="pagination">
            <?php for ($i = 1; $i <= $pages; $i++) { ?>
              <li><a href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
