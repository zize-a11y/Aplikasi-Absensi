<?php
require_once "../connect.php";
session_start();

// Autentikasi pengguna
if (!isset($_SESSION['id'])) {
    die("<script>alert('Silahkan Login Terlebih Dahulu');document.location.href = 'index.php';</script>");
}

class Admin
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAdminName($id)
    {
        $query = $this->db->prepare("SELECT nama FROM admin WHERE Id = ?");
        $query->bind_param("s", $id);
        $query->execute();
        $result = $query->get_result();
        $admin = $result->fetch_assoc();
        return $admin['nama'] ?? 'Admin';
    }
}

class RekapAbsen
{
    public function calculateAbsence($jumlah, $hadir, $sakit, $izin)
    {
        $alpa = $jumlah - $hadir - $sakit - $izin;
        $persentase = $jumlah > 0 ? ($hadir / $jumlah) * 100 : 0;
        return [
            'alpa' => $alpa,
            'persentase' => $persentase
        ];
    }
}

// Inisialisasi kelas
$admin = new Admin($link);
$rekap = new RekapAbsen();

// Ambil nama admin
$adminName = $admin->getAdminName($_SESSION['id']);

// Jika data form dikirim
$NIS = $nama = $kls = $jumlah = $hadir = $telat = $sakit = $izin = null;
if (isset($_POST['Cetak'])) {
    $NIS = $_POST['NIS'];
    $nama = $_POST['nama'];
    $kls = $_POST['kls'];
    $jumlah = floatval($_POST['jml'] ?? 0);
    $hadir = floatval($_POST['hadir'] ?? 0);
    $telat = floatval($_POST['telat'] ?? 0);
    $sakit = floatval($_POST['sakit'] ?? 0);
    $izin = floatval($_POST['izin'] ?? 0);

    $absenceData = $rekap->calculateAbsence($jumlah, $hadir, $sakit, $izin);
    $alpa = $absenceData['alpa'];
    $persentase = $absenceData['persentase'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TK TADIKA MESRA</title>
    <link rel="shortcut icon" href="../img/IP.png">
    <link rel="stylesheet" href="../assets/css/CETAK.css"> <!-- Path CSS -->
    <script>
        window.onload = function () {
            window.print();
        };
    </script>
</head>
<body>

<div class="navbar">
    <div>
        <a class="navbar-brand">TK TADIKA MESRA</a>
        <ul class="nav">
            <li><a href="beranda.php">Home</a></li>
            <li class="active"><a href="murid.php">Data Siswa</a></li>
            <li><a href="Kehadiran.php">Kehadiran</a></li>
            <li><a href="TampilanIzin.php">Tidak Hadir</a></li>
        </ul>
    </div>
    <div class="nav-right">
        <span><?= htmlspecialchars($adminName) ?></span>
        <a href="ProsesLogoutAdmin.php">Logout</a>
    </div>
</div>

<div class="container">
    <?php if (isset($_POST['Cetak'])): ?>
        <table class="header-table">
            <tr>
                <td><img src="../img/IP.png" height="150" width="150"></td>
                <td>
                    <h1>TK TADIK MESRA</h1>
                    <p>Kampung Durian Runtuh,Dusun Pempioang, Desa Tampalang, Kecamatan Tapalang.Johor Malaysia<br>
                    Email: serial@upinipin.sch.id<br>
                    Website: www.upinipin.sch.id<br>
                    Telepon: 021-5725610<br>
                    Durian Runtuh - 9999
                </td>
                <td><img src="../img/GO.jpeg" height="150" width="150"></td>
            </tr>
        </table>

        <hr>

        <h1>REKAP ABSEN SISWA</h1>

        <table class="table-details">
            <tr>
                <td><h3>NIS</h3></td>
                <td><h3>: <?= htmlspecialchars($NIS) ?></h3></td>
            </tr>
            <tr>
                <td><h3>Nama Lengkap</h3></td>
                <td><h3>: <?= htmlspecialchars($nama) ?></h3></td>
            </tr>
            <tr>
                <td><h3>Kelas</h3></td>
                <td><h3>: <?= htmlspecialchars($kls) ?></h3></td>
            </tr>
            <tr>
                <td><h3>Terlambat</h3></td>
                <td><h3>: <?= htmlspecialchars($telat) ?> Hari</h3></td>
            </tr>
            <tr>
                <td><h3>Sakit</h3></td>
                <td><h3>: <?= htmlspecialchars($sakit) ?> Hari</h3></td>
            </tr>
            <tr>
                <td><h3>Izin</h3></td>
                <td><h3>: <?= htmlspecialchars($izin) ?> Hari</h3></td>
            </tr>
            <tr>
                <td><h3>Tanpa Keterangan</h3></td>
                <td><h3>: <?= htmlspecialchars($alpa) ?> Hari</h3></td>
            </tr>
            <tr>
                <td><h3>Persentase Kehadiran</h3></td>
                <td><h3>: <?= htmlspecialchars(number_format($persentase, 2)) ?> %</h3></td>
            </tr>
        </table>
    <?php endif; ?>

    <div class="footer">
    </div>

    <table class="signature">
        <tr>
            <td><h3>Orang Tua,</h3></td>
            <td><h3>Wali Kelas,</h3></td>
        </tr>
        <tr>
            <td><br><h3>_____________</h3></td>
            <td><br><h3>_____________</h3></td>
        </tr>
    </table>

    <div class="footer-sign">
        <td><h3>Mengetahui</td>
        <td>Kepala Sekolah</td>
        <br><br><br>
        <td><br><u>Sri Elyawati, S. Pd</u></td>
        <td>NIP.197104052007011037</td></h3>
    </div>
</div>

</body>
</html>
