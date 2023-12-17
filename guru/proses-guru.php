<?=

session_start();


if (!isset($_SESSION["ssLogin"])) {
    header("location: ../auth/login.php");
    exit();
}

require_once "../config.php";

if (isset($_POST['simpan'])) {
    $nip = htmlspecialchars($_POST['nip']);
    $nama = htmlspecialchars($_POST['nama']);
    $telpon = htmlspecialchars($_POST['telpon']);
    $agama = $_POST['agama'];
    $alamat = htmlspecialchars($_POST['alamat']);
    $foto = htmlspecialchars($_FILES['image']['name']);

    $cekNip = mysqli_query($koneksi, "SELECT nip FROM tbl_guru WHERE nip = '$nip'");
    if (mysqli_num_rows($cekNip) > 0) {
        header('location:add-guru.php?msg=cancel');
        return;
    }

    if ($foto != null) {
        $url = "add-guru.php";
        $fotoGuru = uploadimg($url);
    } else {
        $fotoGuru = 'default.png';
    }

    mysqli_query($koneksi, "INSERT INTO tbl_guru VALUES (null,'$nip','$nama','$alamat','$telpon','$agama','$foto')");

    header("location:add-guru.php?msg=added");
    return;
} else if (isset($_POST['update'])) {
    $nip = $_POST['nip'];
    $nama = htmlspecialchars($_POST['nama']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $telpon = $_POST["telpon"];
    $agama = $_POST["agama"];
    $foto = htmlspecialchars($_POST['fotoLama']);

    if ($_FILES['image']['error'] === 4) {
        $fotoGuru = $foto;
    } else {
        $url = "guru.php";
        $fotoGuru = uploadimg($url);
        if ($foto != 'default.png') {
            @unlink('../asset/image/' . $foto);
        }
    }
    mysqli_query($koneksi, "UPDATE tbl_guru SET
                        nip = '$nip',
                        nama = '$nama',
                        alamat = '$alamat',
                        telpon = '$telpon',
                        agama = '$agama',
                        foto = '$fotoGuru'
                        WHERE nip = '$nip'
                        ");

    echo "<script>
        alert('Data guru berhasil diupdate');
        document.location.href = 'guru.php';
    </script>";
    return;
}
?>