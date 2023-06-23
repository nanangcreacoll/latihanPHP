<?php
require '../function.php';

$keyword = $_GET["keyword"];
$query = "SELECT * FROM mahasiswa WHERE nama LIKE '%$keyword%' OR nrp LIKE '%$keyword%' OR email LIKE '%$keyword%' OR jurusan LIKE '%$keyword%'";
$mahasiswa = query($query);

?>

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