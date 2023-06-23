<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'function.php';

$jumlahDataPerHalaman = 2;
$jumlahData = count(query("SELECT * FROM mahasiswa"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$mahasiswa = query("SELECT * FROM mahasiswa LIMIT $awalData, $jumlahDataPerHalaman");

if(isset($_POST["cari"])){
    $mahasiswa = cari($_POST["keyword"]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
</head>
<body>
    <a href="logout.php">Logout</a>

    <h1>Daftar Mahasiswa</h1>

    <a href="tambah.php">Tambah data mahasiswa</a>
    <br><br>

    <form action="" method="post">
        <input type="text" name="keyword" size="40" autofocus placeholder="masukkan keyword pencarian ..." autocomplete="off" id="keyword">
        <button type="submit" name="cari" id="tombol-cari">Cari!</button>
    </form>

    <br>

    <div id="container">
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <td>No.</td>
                <td>Aksi</td>
                <td>Gambar</td>
                <td>Nama</td>
                <td>NRP</td>
                <td>Email</td>
                <td>Jurusan</td>
            </tr>

            <?php $i = 1;?>
            <?php foreach( $mahasiswa as $mhs ): ?>
            <tr>
                <td><?= $i?></td>
                <td>
                    <a href="ubah.php?id=<?= $mhs["id"];?>">ubah</a>
                    <a href="hapus.php?id=<?= $mhs["id"];?>" onclick = "return confirm ('yakin?');">hapus</a>
                </td>
                <td><img src="img/<?= $mhs["gambar"];?>" width="100"></td>
                <td><?= $mhs["nama"];?></td>
                <td><?= $mhs["nrp"];?></td>
                <td><?= $mhs["email"];?></td>
                <td><?= $mhs["jurusan"];?></td>
            </tr>
            <?php $i++; ?>
            <?php endforeach;?>
        </table>
    </div>
    <script src="js/jquery-3.7.0.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>