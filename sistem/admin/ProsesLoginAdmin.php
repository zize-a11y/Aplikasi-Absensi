<?php
include "../connect.php";

class ProsesLoginAdmin {
    private $link;

    public function __construct($dbLink) {
        $this->link = $dbLink;
    }

    public function login($username, $password) {
        $pass = md5($password);
        $query = "SELECT * FROM admin WHERE Id = '$username' AND Password = '$pass'";
        $result = mysqli_query($this->link, $query);

        if (mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_array($result);
            session_start();
            $_SESSION['id'] = $data['id'];
            echo "<script language=\"Javascript\">alert(\"Selamat Datang\");document.location.href = 'beranda.php'; </script>";
        } else {
            echo "<script language=\"Javascript\">alert(\"Username atau Password Salah!!!!\");document.location.href = '../admin/index.php'; </script>";
        }
    }
}
?>
