<?php
session_start();
$koneksi = mysqli_connect("localhost","root","","olshop");
if (isset($_GET["kode_barang"])) {
  $kode_barang = $_GET["kode_barang"];
  $sql = "select * from table_barang where kode_barang = '$kode_barang'";
  $result = mysqli_query($koneksi,$sql);
  $hasil = mysqli_fetch_array($result);

  // masukkan ke keranjang
  if (!in_array($hasil, $_SESSION["session_transaksi"])) {
    array_push($_SESSION["session_transaksi"],$hasil);
  }
  header("location:template_pembeli.php?page=list_barang");
}
if (isset($_GET["checkout"])) {
  $id_transaksi = rand(1,1000).date("dmY");
  $id_pembeli = $_SESSION["session_pembeli"]["id_pembeli"];
  $tgl = date("Y-m-d");
  $sql = "insert into table_transaksi values('$id_transaksi','$id_pembeli','$tgl')";
  if (mysqli_query($koneksi,$sql)) {
    foreach ($_SESSION["session_transaksi"] as $hasil) {
      $kode_barang = $hasil["kode_barang"];
      $jumlah = $_POST['jumlah_barang'.$hasil["kode_barang"]];
      $harga_beli = $hasil["harga"];
      $sql = "insert into detail_transaksi values('$id_transaksi','$kode_barang','$jumlah','$harga_beli')";
      mysqli_query($koneksi,$sql);
    }
    // kosongkan Keranjang
    $_SESSION["session_transaksi"] = array();
    header("location: template_pembeli.php?page=nota&kode_transaksi=$id_transaksi");
  }
}
 ?>
