<?php
class HalamanKehadiran {
    public function render() {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>TK TADIKA MESRA</title>
            <link rel="shortcut icon" href="../img/IP.png">
            <link rel="stylesheet" href="../assets/css/Tampilankehadiran.css"> <!-- Path CSS -->
        </head>
        <body>
            <div class="container">
                <div class="panel-heading">
                    <table border="0">
                        <tr>
                            <td style="text-align: center;">
                                <img src="../img/IP.png" alt="IP" class="logo">
                            </td>
                            <td>
                                <h1>TK TADIKA MESRA</h1>
                                <p>Kampung Durian Runtuh,Dusun Pempioang, Desa Tampalang, Kecamatan Tapalang.Johor Malaysia<br>
                                    Email: serial@upinipin.sch.id<br>
                                    Website: www.upinipin.sch.id<br>
                                    Telepon: 021-5725610<br>
                                    Durian Runtuh - 9999
                                </p>
                            </td>
                            <td style="text-align: center;">
                                <img src="../img/GO.jpeg" alt="GO" class="logo">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="panel-body">
                    <form method="POST" action="ProsesKehadiran.php">
                        <div class="input-group">
                            <span>
                                <i class="glyphicon glyphicon-user"></i>
                            </span>
                            <input type="text" name="NIS" placeholder="Masukan Nomor Induk Siswa" required>
                            <button type="submit" name="Hadir" value="Masuk" class="btn btn-secondary">Absen</button>
                        </div>
                       
                    </form>
                </div>
                <div class="panel-footer" >
                    <a href="../index.php" class="btn" style="width:100%">Kembali</a>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
}

$page = new HalamanKehadiran();
$page->render();
?>
