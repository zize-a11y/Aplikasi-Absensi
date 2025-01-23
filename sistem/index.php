<?php
class Page {
    private $title;
    private $favicon;

    public function __construct($title, $favicon) {
        $this->title = $title;
        $this->favicon = $favicon;
    }

    public function renderHeader() {
        echo "<head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>{$this->title}</title>
                <link rel='shortcut icon' href='{$this->favicon}'/>
                <style>" . $this->getStyles() . "</style>
              </head>";
    }

    private function getStyles() {
        return "body {
                    font-family: Arial, sans-serif;
                    background-color: #FFDD4A;
                    margin: 0;
                    padding: 0;
                }
    
                .header {
                    text-align: center;
                    padding: 20px;
                    background-color: #FFF5C3;
                    color: #008CBA /* Biru tua */
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                    border-bottom: 4px solid #000000;
                }
    
                .header img {
                    max-height: 120px;
                }
    
                .header h1 {
                    margin: 10px 0 5px;
                    font-size: 32px;
                    font-weight: bold;
                }
    
                .header p {
                    margin: 5px 0;
                    font-size: 18px;
                    color: #000000;
                }
    
                .container {
                    max-width: 900px;
                    margin: 40px auto;
                    background-color: #000000;
                    border-radius: 12px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                    overflow: hidden;
                    border: 2px solid #FFDD4A;
                }
    
                .panel {
                    padding: 20px;
                }
    
                .panel-body {
                    display: flex;
                    justify-content: space-between;
                    gap: 20px;
                    flex-wrap: wrap;
                }
    
                .panel-box {
                    flex: 1;
                    background-color: #F9F9F9;
                    border: 2px solid #FFFFFF;
                    border-radius: 12px;
                    overflow: hidden;
                    transition: transform 0.3s, background-color 0.3s;
                    text-decoration: none;
                }
    
                .panel-box:hover {
                    transform: scale(1.05);
                    background-color: #E7F7FF; /* Biru muda */
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                }
    
                .panel-box .panel-heading {
                    background-color:rgb(253, 207, 3);
                    color: white;
                    padding: 15px;
                    text-align: center;
                    font-size: 20px;
                    font-weight: bold;
                    text-transform: uppercase;
                }
    
                .panel-box .panel-body {
                    padding: 15px;
                    font-size: 16px;
                    color: #333;
                    text-align: center;
                }
    
                .footer {
                    text-align: center;
                    padding: 10px;
                    font-size: 16px;
                    background-color: #000000;
                    color: white;
                    border-top: 4px solid #FFDD4A;
                }
    
                @media (max-width: 768px) {
                    .panel-body {
                        flex-direction: column;
                        gap: 10px;
                    }
                }";
    }
    

    public function renderFooter() {
        echo "<div class='footer'>
                &copy; 2024 TK MESRA | All Rights Reserved
              </div>";
    }
}

class Content {
    public function renderHeaderSection() {
        echo "<div class='header'>
                <img src='img/IP.png' alt='Logo TK TADIKA MESRA'>
                <h1>TK TADIKA MESRA</h1>
                <p> Kampung Durian Runtuh,Dusun Pempioang, Desa Tampalang, Kecamatan Tapalang.Johor Malaysia</p>
                <p>Email: serial@upinipin.sch.id | Telepon: 021-5725610</p>
              </div>";
    }

    public function renderMainContent() {
        echo "<div class='container'>
                <div class='panel'>
                    <div class='panel-body'>
                        <a href='absen/TampilanKehadiran.php' class='panel-box'>
                            <div class='panel-heading'>
                                <span class='glyphicon glyphicon-list-alt'></span> Kehadiran
                            </div>
                            <div class='panel-body'>
                                <p>Menu untuk siswa/i melakukan absen dengan memasukan NIS dari setiap siswa tersebut.</p>
                            </div>
                        </a>
                        <a href='admin/index.php' class='panel-box'>
                            <div class='panel-heading' style='background-color: rgb(253, 207, 3);'>
                                <span class='glyphicon glyphicon-user'></span> Administrator
                            </div>
                            <div class='panel-body'>
                                <p>Menu untuk admin atau karyawan tata usaha yang mengurus perihal absensi para siswa/i.</p>
                            </div>
                        </a>
                    </div>
                </div>
              </div>";
    }
}

// Instantiate the classes
$page = new Page("TK TADIKA MESRA", "img/IP.png ");
$content = new Content();

?>
<!DOCTYPE html>
<html lang="en">
<?php $page->renderHeader(); ?>
<body>
    <?php
    $content->renderHeaderSection();
    $content->renderMainContent();
    $page->renderFooter();
    ?>
</body>
</html>
