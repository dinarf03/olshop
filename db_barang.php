<?php
session_start();
$koneksi = mysqli_connect("localhost","root","","olshop");
if (isset($_POST["action"])) {
  $kode_barang = $_POST["kode_barang"];
  $nama = $_POST["nama"];
  $ukuran = $_POST["ukuran"];
  $warna = $_POST["warna"];
  $harga = $_POST["harga"];
  $stok = $_POST["stok"];
  $deskripsi = $_POST["deskripsi"];
  $action = $_POST["action"];
  if ($_POST["action"] == "insert") {
    // kita tampung deskripsi file gambarnya
    $path = pathinfo($_FILES["image"]["name"]);
    // ambil ekstensi gambarnya
    $extensi = $path["extension"];
    // rangkai nama file yang akan disimpan
    $filename = $kode_barang."-".rand(1,1000).".".$extensi;
    // rand = untuk mengambil nilai random antara 1 sampai 1000

    $sql = "insert into table_barang values('$kode_barang','$nama','$ukuran',
    '$warna', '$harga', '$stok', '$deskripsi', '$filename')";

    if (mysqli_query($koneksi,$sql)) {
      // jika eksekusi berhasil
      move_uploaded_file($_FILES["image"]["tmp_name"],"img_barang/$filename");
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
    header("location:template.php?page=barang");
  }else if($_POST["action"] == "update"){
    if (!empty($_FILES["image"]["name"])) {
      // jika gambar di edit
      $sql = "select * from where kode_barang='$kode_barang'";
      $result = mysqli_query($koneksi,$sql);
      $hasil = mysqli_fetch_array($result);
      // hapus file lama
      if (file_exists("img_barang/".$hasil["image"])) {
        // jika file nya tersedia
        unlink("img_barang/".$hasil["image"]);
        // menghapus file
      }

      // membuat nama file yang baru
      $path = pathinfo($_FILES["image"]["name"]);
      // ambil ekstensi gambarnya
      $extensi = $path["extension"];
      // rangkai nama file yang akan disimpan
      $filename = $kode_barang."-".rand(1,1000).".".$extensi;
      // rand = untuk mengambil nilai random antara 1 sampai 1000

      // membuat perintah update
      $sql = "update table_barang set nama='$nama',ukuran='$ukuran',
      warna='$warna',harga='$harga',stok='$stok', deskripsi='$deskripsi', image='$filename' where kode_barang='$kode_barang'";

      if (mysqli_query($koneksi,$sql)) {
        // jika query sukses
        move_uploaded_file($_FILES["image"]["tmp_name"],"img_barang/$filename");
        $sql = "update table_barang set nama='$nama',ukuran='$ukuran',
        warna='$warna',harga='$harga',stok='$stok', deskripsi='$deskripsi', image='$filename' where kode_barang='$kode_barang'";
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


    }else {
      // jika gambar tidak di edit
      $sql = "update table_barang set nama='$nama',ukuran='$ukuran',
      warna='$warna',harga='$harga',stok='$stok', deskripsi='$deskripsi' where kode_barang='$kode_barang'";
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
    header("location:template.php?page=barang");
  }
}



if (isset($_GET["hapus"])) {
  // jika yang dikirim adalah variabel GET hapus
  $kode_barang = $_GET["kode_barang"];
  $sql = "select * from table_barang where kode_barang='$kode_barang'";
  // eksekusi query
  $result = mysqli_query($koneksi,$sql);
  // konversi ke array
  $hasil = mysqli_fetch_array($result);
  if (file_exists("img_barang/".$hasil["image"])) {
    unlink("img_barang/".$hasil["image"]);
    // menghapus file
  }
  $sql = "delete from table_barang where kode_barang='$kode_barang'";
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
  header("location:template.php?page=barang");
}
?>
