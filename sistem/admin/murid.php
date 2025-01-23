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
    <link rel="stylesheet" href="../assets/css/murid.css"> <!-- Path CSS -->
</head>

<body>

<!-- Navbar -->
<nav>
  <a class="navbar-brand" href="#">TK TADIKA MESRA</a>
  <ul>
    <li><a href="beranda.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
    <li class="active"><a><span class="glyphicon glyphicon-list"></span> Data Siswa</a></li>
    <li><a href="Kehadiran.php"><span class="glyphicon glyphicon-list-alt"></span> Kehadiran</a></li>
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
    <ul>
        </ul>
      <h1>Data Siswa <a href="siswabaru.php" class="round-button">+</a></h1> 


    </div>

    <div class="panel-body">
      <!-- Menu Navigation and Search Form -->
      <div class="navbar-top">


        <!-- Search Form -->
        <form name="cari" method="GET" action="" class="input-group">
          <input type="text" name="search" class="form-control" placeholder="Cari Nama">
          <input type="text" name="tgl" class="form-control" placeholder="Cari Kelas">
          <button type="submit" name="cr" class="btn btn-info"><i class="glyphicon glyphicon-search"></i> Cari</button>
        </form>
      </div>

      <!-- Data Table -->
      <div class="table-responsive">
        <table name="murid" class="table table-bordered table-striped">
          <thead>
            <tr class="info">
              <th>No</th>
              <th>NIS</th>
              <th>Nama Lengkap</th>
              <th>Kelas</th>
              <th colspan="2">Aksi</th>
              <th>Rekap Absen</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $halaman = 10;
            $page = isset($_GET["halaman"]) ? (int)$_GET["halaman"] : 1;
            $mulai = ($page > 1) ? ($page * $halaman) - $halaman : 0;
            $hasil = mysqli_query($link,"SELECT * FROM murid");
            $result = mysqli_num_rows($hasil);
            $pages = ceil($result / $halaman);
            $query = mysqli_query($link,"SELECT * FROM murid LIMIT $mulai, $halaman");

            if(isset($_GET['cr'])){
                $cari = $_GET['search'];
                $kls = $_GET['tgl'];
                $query = mysqli_query($link,"SELECT * FROM murid WHERE Namalengkap LIKE '%$cari%' AND Kelas LIKE '%$kls%' ORDER BY NIS ASC LIMIT $mulai, $halaman");
            }

            $no = $mulai + 1;
            while ($data = mysqli_fetch_array($query)) {
                echo "<tr>
                        <td>".$no++."</td>
                        <td>".$data['NIS']."</td>
                        <td>".$data['Namalengkap']."</td>
                        <td>".$data['Kelas']."</td>
                        <td><a href='Editsiswa.php?NIS=".$data['NIS']."' class='btn btn-success btn-sm'><span class='glyphicon glyphicon-edit'></span> Edit</a></td>
                        <td><a href='hapussiswa.php?NIS=".$data['NIS']."' class='btn btn-danger btn-sm' onClick='return confirm(\"Apakah anda yakin menghapusnya?\")'><i class='glyphicon glyphicon-erase'></i> Hapus</a></td>
                        <td><a href='Cekrekap.php?NIS=".$data['NIS']."' class='btn btn-info btn-sm'><span class='glyphicon glyphicon-print'></span> Cetak</a></td>
                      </tr>";
            }
            ?>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="pagination">
        <?php for ($i = 1; $i <= $pages; $i++) { ?>
          <li class="<?php if($page == $i) echo 'active'; ?>"><a href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a></li>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

</body>
</html>
