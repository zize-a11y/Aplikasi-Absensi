<?php
class Kehadiran {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
        date_default_timezone_set("Asia/Jakarta");
    }

    public function absensi($nis) {
        $nis = $this->sanitizeInput($nis);
        $tanggal = date("Y-m-d H:i:s");
        $tgl = date("Y-m-d");

        if (!$this->cekMuridTerdaftar($nis)) {
            $this->alertRedirect('NIS tidak terdaftar. Silakan hubungi Administrator.', 'TampilanKehadiran.php');
        }

        if ($this->cekAbsensiHariIni($nis, $tgl)) {
            $this->alertRedirect('Anda sudah melakukan absensi pada hari ini.', 'TampilanKehadiran.php');
        }

        $status = $this->tentukanStatus($tanggal);

        if ($this->simpanKehadiran($nis, $tanggal, $status)) {
            $this->alertRedirect("Anda masuk pada $tanggal.", 'TampilanKehadiran.php');
        } else {
            $this->alertRedirect('Gagal melakukan absensi. Silakan coba lagi.', 'TampilanKehadiran.php');
        }
    }

    private function sanitizeInput($input) {
        return mysqli_real_escape_string($this->db, $input);
    }

    private function cekMuridTerdaftar($nis) {
        $query = "SELECT * FROM murid WHERE NIS = ?";
        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param($stmt, 's', $nis);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_num_rows($result) > 0;
    }

    private function cekAbsensiHariIni($nis, $tgl) {
        $query = "SELECT * FROM kehadiran WHERE NIS = ? AND Tanggal LIKE ?";
        $stmt = mysqli_prepare($this->db, $query);
        $like_tgl = "%$tgl%";
        mysqli_stmt_bind_param($stmt, 'ss', $nis, $like_tgl);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_num_rows($result) > 0;
    }

    private function tentukanStatus($tanggal) {
        $hadir = ($tanggal > date("Y-m-d 07:00:00")) ? 0 : 1; // 0: Telat, 1: Hadir tepat waktu
        return [
            'hadir' => $hadir,
            'telat' => ($hadir == 0) ? 1 : 0,
            'izin' => 0,
            'sakit' => 0,
            'verifikasi' => 1
        ];
    }

    private function simpanKehadiran($nis, $tanggal, $status) {
        $query = "INSERT INTO kehadiran (NIS, Tanggal, Hadir, Telat, Sakit, Izin, Verifikasi) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param(
            $stmt,
            'sssiiii',
            $nis,
            $tanggal,
            $status['hadir'],
            $status['telat'],
            $status['sakit'],
            $status['izin'],
            $status['verifikasi']
        );
        return mysqli_stmt_execute($stmt);
    }
    

    private function alertRedirect($message, $url) {
        echo "<script>alert('$message'); window.location.href = '$url';</script>";
        exit;
    }
}

// Inisialisasi koneksi database
include '../Connect.php';

if (isset($_POST['Hadir'])) {
    $kehadiran = new Kehadiran($link);
    $kehadiran->absensi($_POST['NIS']);
}
?>
