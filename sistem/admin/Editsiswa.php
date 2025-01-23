<!DOCTYPE html>
<html lang="en">
<head>
    <title>TK TADIKA MESRA</title>
    <link rel="shortcut icon" href="../img/IP.png">
    <link rel="stylesheet" href="../assets/css/Editsiswa.css"> <!-- Path CSS -->
    <meta charset="UTF-8">
</head>
<body>
    <div class="navbar">
        <a href="beranda.php">Home</a>
        <a href="murid.php">Data Siswa</a>
        <a href="Kehadiran.php">Kehadiran</a>
        <a href="TampilanIzin.php">Tidak Hadir</a>
        <div class="right">
            <a href="ProsesLogoutAdmin.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="panel">
            <div class="panel-heading">
                <h1>EDIT DATA SISWA BARU</h1>
            </div>
            <div class="panel-body">
                <form method="POST" action="prosessiswabaru.php">
                    <table>
                        <tr>
                            <td><h3>NIS</h3></td>
                            <td><h3>:</h3></td>
                            <td><input type="text" name="NIS" required></td>
                        </tr>
                        <tr>
                            <td><h3>Nama Lengkap</h3></td>
                            <td><h3>:</h3></td>
                            <td><input type="text" name="nama" required></td>
                        </tr>
                        <tr>
                            <td><h3>Kelas</h3></td>
                            <td><h3>:</h3></td>
                            <td>
                            <select name="kls" required>
                                <option value="I-A">I-A</option>
                                    <option value="I-B">I-B</option>
                                    <option value="I-C">I-C</option>
                                    <option value="II-A">II-A</option>
                                    <option value="II-B">II-B</option>
                                    <option value="II-C">II-C</option>
                                    <option value="III-A">III-A</option>
                                    <option value="III-B">III-B</option>
                                    <option value="III-C">III-C</option>
                                    <option value="IV-A">IV-A</option>
                                    <option value="IV-B">IV-B</option>
                                    <option value="IV-C">IV-C</option>
                                    <option value="V-A">V-A</option>
                                    <option value="V-B">V-B</option>
                                    <option value="V-C">V-C</option>
                                    <option value="VI-A">VI-A</option>
                                    <option value="VI-B">VI-B</option>
                                    <option value="VI-C">VI-C</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align:right">
                                <button type="submit" name="tambah">Simpan</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<?php
class SessionManager
{
    public static function startSession()
    {
        session_start();
    }

    public static function isLoggedIn()
    {
        return isset($_SESSION['id']);
    }

    public static function getUserId()
    {
        return $_SESSION['id'] ?? null;
    }

    public static function redirectWithMessage($url, $message)
    {
        echo "<script>alert('$message');document.location.href='$url';</script>";
        exit;
    }
}

// File: classes/Database.php
class Database
{
    private $link;

    public function __construct()
    {
        $this->link = new mysqli('localhost', 'username', 'password', 'database');
        if ($this->link->connect_error) {
            die('Connection failed: ' . $this->link->connect_error);
        }
    }

    public function getMaxNIS()
    {
        $result = $this->link->query("SELECT max(NIS) as maxNIS FROM murid");
        $row = $result->fetch_assoc();
        return $row['maxNIS'] ?? 0;
    }

    public function getAdminName($id)
    {
        $stmt = $this->link->prepare("SELECT nama FROM admin WHERE Id = ?");
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['nama'] ?? '';
    }

    public function getClasses()
    {
        return ["I-A", "I-B", "I-C", "II-A", "II-B", "II-C", "III-A", "III-B", "III-C", "IV-A", "IV-B", "IV-C", "V-A", "V-B", "V-C", "VI-A", "VI-B", "VI-C"];
    }
}
