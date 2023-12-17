<?php 

session_start();

if (!isset($_SESSION["ssLogin"])){
    header("Location:../auth/login.php");
    exit;
}

require_once "../config.php";

// jika tombol simpan ditekan
if (isset($_POST['simpan'])) {
    //ambil value yang diposting
    $id             = isset($_POST['id']) ? $_POST['id'] : null;
    $nama           = trim(htmlspecialchars($_POST['nama']));
    $email          = trim(htmlspecialchars($_POST['email']));
    $status         = $_POST['status'];
    $akreditasi     = $_POST['akreditasi'];
    $alamat         = trim(htmlspecialchars($_POST['alamat']));
    $visimisi       = trim(htmlspecialchars($_POST['visimisi']));
    $gbr            = trim(htmlspecialchars($_POST['gbrlama']));

    // Cek apakah gambar user
    if($_FILES['image']['error'] === 4) {
        $gbrSekolah = $gbr;
    } else {
        $url = 'profile-sekolah.php';
        $gbrSekolah = uploadimg($url);
        @unlink('../asset/image/' . $gbr);
    }

    // update data
    mysqli_query($koneksi, "UPDATE tbl_sekolah SET 
                                    nama = '$nama', 
                                    email = '$email',
                                    status = '$status',
                                    akreditasi = '$akreditasi',
                                    alamat = '$alamat',
                                    visimisi = '$visimisi',
                                    gambar = '$gbrSekolah'
                                    WHERE id = 1");
    header("location:profile-sekolah.php?msg=updated");
} else {
    echo "ID not set"; // Handle the case where 'id' is not set
}
?>