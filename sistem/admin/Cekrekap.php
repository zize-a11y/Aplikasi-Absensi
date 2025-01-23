<?php
require_once "../connect.php";
session_start();

// Autentikasi pengguna
if (!isset($_SESSION['id'])) {
    die("<script>alert('Silahkan Login Terlebih Dahulu');document.location.href = 'index.php';</script>");
}

// Kelas untuk pengelolaan data siswa
class Siswa
{
    private $db;

    public function __construct($link)
    {
        $this->db = $link;
    }

    public function getSiswaData($nis)
    {
        $query = $this->db->prepare("SELECT * FROM murid WHERE NIS = ?");
        $query->bind_param("s", $nis);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function getKehadiran($nis)
    {
        $result = [];
        $types = ['hadir', 'telat', 'sakit', 'izin'];
        foreach ($types as $type) {
            $query = $this->db->prepare("SELECT SUM($type) as total FROM jmlkehadiran WHERE NIS = ? AND Verifikasi = '1'");
            $query->bind_param("s", $nis);
            $query->execute();
            $result[$type] = $query->get_result()->fetch_assoc()['total'] ?? 0;
        }
        return $result;
    }
}

// Inisialisasi
$siswa = new Siswa($link);
$id = $_GET['NIS'];
$data = $siswa->getSiswaData($id);
$kehadiran = $siswa->getKehadiran($id);

// Ambil nama admin
$query = $link->prepare("SELECT * FROM admin WHERE Id = ?");
$query->bind_param("s", $_SESSION['id']);
$query->execute();
$namaAdmin = $query->get_result()->fetch_assoc()['nama'];

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TK TADIKA MESRA</title>
    <link rel="shortcut icon" href="../img/IP .png" />
    <link rel="stylesheet" href="../assets/css/Cekrekap.css"> <!-- Path CSS -->
<body>
<div class="navbar">
        <a href="beranda.php">Home</a>
        <a href="murid.php">Data Siswa</a>
        <a href="Kehadiran.php">Kehadiran</a>
        <a href="TampilanIzin.php">Tidak Hadir</a>
        <div class="right">
            <a>
                <?php
                $queri1 = mysqli_query($link, "SELECT * FROM admin WHERE Id LIKE '" . $_SESSION['id'] . "'");
                $nama = mysqli_fetch_array($queri1);
                echo $nama['nama'];
                ?>
            </a>
            <a href="ProsesLogoutAdmin.php">Logout</a>
        </div>
    </div>
    <div class="container">
        <div class="title-container">
            <h1>Data Rekap Absen Siswa</h1>
        </div>
        <form method="POST" action="CETAK.php">
            <table>
                <tr>
                    <td><h3>NIS</h3></td>
                    <td><input type="text" name="NIS" value="<?= htmlspecialchars($data['NIS'] ?? '') ?>" readonly></td>
                </tr>
                <tr>
                    <td><h3>Nama Lengkap</h3></td>
                    <td><input type="text" name="nama" value="<?= htmlspecialchars($data['Namalengkap'] ?? '') ?>" readonly></td>
                </tr>
                <tr>
                    <td><h3>Kelas</h3></td>
                    <td><input type="text" name="kls" value="<?= htmlspecialchars($data['Kelas'] ?? '') ?>" readonly></td>
                </tr>
                <tr>
                    <td><h3>Jumlah Hari Masuk Semester</h3></td>
                    <td><input type="text" name="jml" value=""></td>
                </tr>
                <tr>
                    <td><h3>Hadir</h3></td>
                    <td><input type="text" name="hadir" value="<?= htmlspecialchars($kehadiran['hadir'] ?? 0) ?>" readonly></td>
                </tr>
                <tr>
                    <td><h3>Terlambat</h3></td>
                    <td><input type="text" name="telat" value="<?= htmlspecialchars($kehadiran['telat'] ?? 0) ?>" readonly></td>
                </tr>
                <tr>
                    <td><h3>Sakit</h3></td>
                    <td><input type="text" name="sakit" value="<?= htmlspecialchars($kehadiran['sakit'] ?? 0) ?>" readonly></td>
                </tr>
                <tr>
                    <td><h3>Izin</h3></td>
                    <td><input type="text" name="izin" value="<?= htmlspecialchars($kehadiran['izin'] ?? 0) ?>" readonly></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:right">
                        <button type="submit" name="Cetak">Cetak</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
