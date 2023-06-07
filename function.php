<?php
$connect = mysqli_connect("localhost","root","","latihanphp");

function query($query) {
    global $connect;
    $result = mysqli_query($connect,$query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data){
    global $connect;
    
    $nama = htmlspecialchars($data["nama"]);
    $nrp = htmlspecialchars($data["nrp"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);

    $gambar = upload();
    if(!$gambar){
        return false;
    }

    $query = "INSERT INTO mahasiswa VALUES ('','$nama','$nrp','$email','$jurusan','$gambar')";

    mysqli_query($connect, $query);

    return mysqli_affected_rows($connect);
}

function upload()
{
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    if($error === 4){
        echo "
        <script>
            alert('pilih gambar terlebih dahulu!');
        </script>
        ";
        return false;
    }

    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if( !in_array($ekstensiGambar, $ekstensiGambarValid)){
        echo "
        <script>
            alert('yang anda upload bukan gambar!');
        </script>
        ";
        return false;
    }
    if ($ukuranFile>(5*1048576)){
        echo "
        <script>
            alert('ukuran gambar terlalu besar!');
        </script>
        ";
        return false;
    }
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;
    move_uploaded_file($tmpName,'img/'.$namaFileBaru);
    return $namaFileBaru;
}

function hapus($id){
    global $connect;

    mysqli_query($connect, "DELETE FROM mahasiswa WHERE id = $id");

    return mysqli_affected_rows($connect);
}

function ubah($data){
    global $connect;
    
    $id = $data["id"];
    $nama = htmlspecialchars($data["nama"]);
    $nrp = htmlspecialchars($data["nrp"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);
    if($_FILES['gambar']['error'] === 4){
        $gambar = $gambarLama;
    }else{
        $gambar = upload();
        if(upload()){
            unlink("img/"."$gambarLama");
        }
    }

    $query = "UPDATE mahasiswa SET nrp = '$nrp', nama = '$nama', email = '$email', jurusan = '$jurusan', gambar = '$gambar' WHERE id = $id";

    mysqli_query($connect, $query);

    return mysqli_affected_rows($connect);
}

function cari($keyword)
{
    $query = "SELECT * FROM mahasiswa WHERE nama LIKE '%$keyword%' OR nrp LIKE '%$keyword%' OR email LIKE '%$keyword%' OR jurusan LIKE '%$keyword%'";
    return query($query);
}

function registrasi($data)
{
    global $connect;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($connect, $data["password"]);
    $password2 = mysqli_real_escape_string($connect, $data["password2"]);

    $result = mysqli_query($connect, "SELECT username FROM users WHERE username = '$username'");
    if(mysqli_fetch_assoc($result)){
        echo "
        <script>
            alert('username sudah terdaftar!');
        </script>
        ";
        return false;
    }

    if($password !== $password2){
        echo "
        <script>
            alert('konfirmasi password tidak sesuai!');
        </script>
        ";
        return false;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
    mysqli_query($connect, "INSERT INTO users VALUES('', '$username', '$password')");

    return  mysqli_affected_rows($connect);
}

?>