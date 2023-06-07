<?php
require 'function.php';

$id = $_GET["id"];

$idMahasiswa = query("SELECT * FROM mahasiswa WHERE id = $id")[0];

if( isset($_POST["submit"])) {
    if(ubah($_POST) > 0){
        echo "
            <script>
                alert('data berhasil diubah');
                document.location.href = 'index.php';
            </script>
            ";
    } else {
        echo "
        <script>
            alert('data gagal diubah');
            document.location.href = 'index.php';
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah data mahasiswa</title>
</head>
<body>
    <h1>Tambah data mahasiswa</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value=<?= $idMahasiswa["id"];?>>
        <input type="hidden" name="gambarLama" value=<?= $idMahasiswa["gambar"];?>>
        <ul>
            <li>
                <label for="nama">nama: </label>
                <input type="text" name="nama" id="nama" required value = "<?= $idMahasiswa["nama"];?>">
            </li>
            <li>
                <label for="nrp">NRP: </label>
                <input type="text" name="nrp" id="nrp" required value = "<?= $idMahasiswa["nrp"];?>">
            </li>
            <li>
                <label for="email">Email: </label>
                <input type="text" name="email" id="email" value = "<?= $idMahasiswa["email"];?>">
            </li>
            <li>
                <label for="jurusan">Jurusan: </label>
                <input type="text" name="jurusan" id="jurusan" required value = "<?= $idMahasiswa["jurusan"];?>">
            </li>
            <li>
                <label for="gambar">Gambar: </label><br>
                <img src="img/<?= $idMahasiswa['gambar'] ?>" alt="" width="100"><br>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <button type="submit" name="submit">Ubah Data!</button>
            </li>
        </ul>
    </form>
</body>
</html>