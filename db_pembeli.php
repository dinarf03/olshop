<?php
session_start();
$koneksi = mysqli_connect("localhost","root","","olshop");

if (isset($_POST["action"])) {
  $id_pembeli = $_POST["id_pembeli"];
  $nama = $_POST["nama"];
  $alamat = $_POST["alamat"];
  $kontak = $_POST["kontak"];
  $username = $_POST["username"];
  $password = md5($_POST["password"]);
  $action = $_POST["action"];

  if ($_POST["action"] == "insert") {
    // kita tampung deskripsi file gambarnya
    $path = pathinfo($_FILES["image"]["name"]);
    // ambil ekstensi gambarnya
    $ekstensi = $path["extension"];
    // rangkai nama file yang akan disimpan
    $filename = $id_pembeli."-".rand(1.1000).".".$ekstensi;
    // rand = untuk mengambil nilai random antara 1 sampai 1000

    $sql = "insert into table_pembeli values('$id_pembeli','$nama','$alamat',
    '$kontak','$username','$password','$filename')";

    if (mysqli_query($koneksi,$sql)) {
      // jika eksekusi berhasil
      move_uploaded_file($_FILES["image"]["tmp_name"],"img_pembeli/$filename");
      $_SESSION["message"] = array(
        "type" => "success",
        "message" => "Insert data has been success"
      );
    }else {
      // jika eksekusi gagal
      $_SESSION["message"] = array(
        "type" => "danger",
        "message" =>mysqli_error($koneksi)
      );
    }
    header("location:template.php?page=pembeli");

  } else if($_POST["action"] == "update") {
    if (!empty($_FILES["image"]["name"])) {
      // jika gambar diedit
      // ambil data dari database
      $sql = "select * from where id_pembeli='$id_pembeli'";
      $result = mysqli_query($koneksi,$sql);
      $hasil = mysqli_fetch_array($result);
      // untuk mengkonversi menjadi array
      if (file_exists("img_pembeli/".$hasil["image"])) {
        // jika file nya tersedia
        unlink("img_pembeli/".$hasil["image"]);
        // menghapus file
      }
      $path = pathinfo($_FILES["image"]["name"]);
      // ambil ekstensi gambarnya
      $extensi = $path["extension"];
      // rangkai nama file yang akan disimpan
      $filename = $id_pembeli."-".rand(1,1000).".".$extensi;
      // rand = untuk mengambil nilai random antara 1 sampai 1000

      // simpan file gambar
      $sql = "update table_pembeli set nama='$nama',alamat='$alamat',
      kontak='$kontak',username='$username',password='$password',
      image='$filename' where id_pembeli='$id_pembeli'";

      if (mysqli_query($koneksi,$sql)) {
        // jika query sukses
        move_uploaded_file($_FILES["image"]["tmp_name"],"img_pembeli/$filename");
        $sql = "update table_pembeli set nama='$nama',alamat='$alamat',
        kontak='$kontak',username='$username',password='$password'
        where id_pembeli='$id_pembeli'";
        $_SESSION["message"] = array(
          "type" => "success",
          "message" => "Update data has been success"
        );
    } else {
      // jika query gagal
      $_SESSION["message"] = array(
        "type" => "danger",
        "message" => mysqli_error($koneksi)
      );
    }


  }else {
    // jika gambar tidak diedit
    $sql = "update table_pembeli set nama='$nama',alamat='$alamat',
    kontak='$kontak',username='$username',password='$password'
    where id_pembeli='$id_pembeli'";
    if (mysqli_query($koneksi,$sql)) {
      // jika query sukses
      $_SESSION["message"] = array(
        "type" => "success",
        "message" => "Update data has been success"
      );
    }else {
      // jika query gagal
      $_SESSION["message"] = array(
        "type" => "danger",
        "message" => mysqli_error($koneksi)
      );
    }
  }
  header("location:template.php?page=pembeli");
}
}




if (isset($_GET["hapus"])) {
  // jika yang dikirim adalah variabel GET hapus
  $id_pembeli = $_GET["id_pembeli"];
  $sql = "select * from table_pembeli where id_pembeli='$id_pembeli'";
  // eksekusi query
  $result = mysqli_query($koneksi,$sql);
  // konversi ke array
  $hasil = mysqli_fetch_array($result);
  if (file_exists("img_pembeli/".$hasil["image"])) {
    unlink("img_pembeli/".$hasil["image"]);
    // menghapus file
  }
  $sql = "delete from table_pembeli where id_pembeli='$id_pembeli'";
  if (mysqli_query($koneksi,$sql)) {
    // jika query sukses
    $_SESSION["message"] = array(
      "type" => "success",
      "message" => "Delete data has been success"
    );
  }else {
    // jika query gagal
    $_SESSION["message"] = array(
      "type" => "danger",
      "message" => mysqli_error($koneksi)
    );
  }
  header("location:template.php?page=pembeli");
}
?>
