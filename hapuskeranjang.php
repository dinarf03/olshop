<?php
session_start();
$kode_barang = $_GET["id"];
unset($_SESSION["keranjang"]["$kode_barang"]);

echo "<script>alert('produk dihapus dari keranjang');</script>";
echo "<script>location='keranjang.php';</script>";
?>
