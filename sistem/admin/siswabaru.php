<?php
include "../connect.php";
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['id'])) {
    die("<script language=\"Javascript\">alert(\"Silahkan Login Terlebih Dahulu\");document.location.href = 'index.php' </script>");
}
$queri2 = mysqli_query($link, "SELECT max(NIS) as maxNIS FROM murid");
$code = mysqli_fetch_array($queri2);
$codeR = $code['maxNIS'];
$codeR++;
?>
<!DOCTYPE html>
<head>
    <title>TK TADIKA MESRA</title>
    <link rel="shortcut icon" href="../img/IP.png"/>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../assets/css/siswabaru.css"> <!-- Path CSS -->
</head>
<body>
    <!-- Navbar -->
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
        <div class="panel">
            <div class="panel-heading">
                <h1>DATA SISWA BARU</h1>
            </div>
            <div class="panel-body">
                <form method="POST" action="prosessiswabaru.php">
                    <table>
                        <tr>
                            <td><h3>NIS</h3></td>
                            <td><h3>:</h3></td>
                            <td><input type="text" name="NIS" value="<?php echo $codeR; ?>" required readonly></td>
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
