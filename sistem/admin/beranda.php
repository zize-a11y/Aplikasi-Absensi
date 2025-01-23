<?php
include '../Connect.php';
session_start();

if (!isset($_SESSION['id'])) {
    die("<script>alert('Silahkan Login Terlebih Dahulu');document.location.href = 'index.php';</script>");
}

class Beranda
{
    private $link;
    private $namaAdmin;

    public function __construct($dbLink)
    {
        $this->link = $dbLink;
        $this->getAdminName();
    }

    private function getAdminName()
    {
        $query = mysqli_query($this->link, "SELECT * FROM admin WHERE id = '" . $_SESSION['id'] . "'");
        $adminData = mysqli_fetch_array($query);
        $this->namaAdmin = $adminData['nama'];
    }

    public function render()
    {
        ?>
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>TK TADIKA MESRA</title>
            <link rel="shortcut icon" href="../img/IP.png">
            <link rel="stylesheet" href="../assets/css/beranda.css"> <!-- Path ke file CSS -->
        </head>
        <body>
        <nav>
            <div class="brand">
                <img src="../img/IP.png" alt="TK TADIKA MESRA">
                <span>TK TADIKA MESRA</span>
            </div>
            <ul>
                <li><a href="beranda.php">Home</a></li>
                <li><a href="murid.php">Data Siswa</a></li>
                <li><a href="Kehadiran.php">Kehadiran</a></li>
                <li><a href="Tampilanizin.php">Tidak Hadir</a></li>
            </ul>
            <ul>
                <li><a href="#"><?= $this->namaAdmin; ?></a></li>
                <li><a href="ProsesLogoutAdmin.php">Logout</a></li>
            </ul>
        </nav>

        <div class="container">
            <div class="carousel">
                <img src="../img/upin.webp" alt="Image 1">
                <img src="../img/FT.jpg" alt="Image 2">
                <img src="../img/FOT.jpeg" alt="Image 3">
            </div>
        </div>

        <footer>
            <div class="footer-container">
                <h4>&copy; 2024 TK TADIKA MESRA</h4>
                <div>
                    <a href="#">Facebook</a> | 
                    <a href="#">Twitter</a> | 
                    <a href="#">Instagram</a>
                </div>
            </div>
        </footer>

        <script>
            // Simple carousel functionality
            const carouselImages = document.querySelectorAll('.carousel img');
            let currentImageIndex = 0;

            function showImage(index) {
                carouselImages.forEach((img, i) => {
                    img.style.display = i === index ? 'block' : 'none';
                });
            }

            function nextImage() {
                currentImageIndex = (currentImageIndex + 1) % carouselImages.length;
                showImage(currentImageIndex);
            }

            setInterval(nextImage, 3000);
            showImage(currentImageIndex);
        </script>
        </body>
        </html>
        <?php
    }
}

// Inisialisasi halaman
$beranda = new Beranda($link);
$beranda->render();
?>
