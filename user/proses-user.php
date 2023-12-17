<?php

session_start();

if (!isset($_SESSION["ssLogin"])){
    header("Location:../auth/login.php");
    exit;
}

require_once "../config.php";

//jika tombol simpan ditekan
if(isset($_POST['simpan'])) {
    //ambil value elemen yang diposting
    $username = trim(htmlspecialchars($_POST['username']));
    $nama = trim(htmlspecialchars($_POST['nama']));
    $jabatan = $_POST['jabatan'];
    $alamat = trim(htmlspecialchars($_POST['alamat']));
    $gambar = trim(htmlspecialchars($_POST['image']['name']));
    $password = 1234;
    $pass = password_hash($password, PASSWORD_DEFAULT);

    //CEK USERNAME AGAR TIDAK ADA YANG SAMA
    $cekusername = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE username = '$username'");
    if(mysqli_num_rows($cekusername)) {
        header("location:add-user.php?msg=cancel");
        return;
    }

    //upload gambar
    if ($gambar != null) {
        $url = 'add_user.php';
        $gambar = uploadimg($url);
    } else {
        $gambar = 'default.png';
    }

    mysqli_query($koneksi, "INSERT INTO tbl_user VALUES(null, '$username', '$pass', '$nama', '$alamat', '$jabatan', '$gambar')");

    header("location: add-user.php?msg=added");
    return;
}   


?>