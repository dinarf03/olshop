<div class="card col-sm-12">
  <div class="card-header">
    <h3>Nota Transaksi</h3>
  </div>
  <div class="card-body">
    <?php
    $koneksi = mysqli_connect("localhost","root","","olshop");
    $kode_transaksi = $_GET["kode_transaksi"];
    // data transaksi
    $sql = "select t.kode_transaksi, p.nama, t.tgl
    from table_transaksi t inner join table_pembeli p
    on t.id_pembeli = p.id_pembeli
    where t.kode_transaksi='$kode_transaksi'";
    $result = mysqli_query($koneksi,$sql);
    $hasil = mysqli_fetch_array($result);

    // data Barang
    $sql2 = "select b.*, dt.jumlah, dt.harga_beli
    from table_barang b inner join detail_transaksi dt
    on b.kode_barang = dt.kode_barang
    where dt.kode_transaksi='$kode_transaksi'";
    $result2 = mysqli_query($koneksi,$sql2);
    ?>

    <h4>ID. Transaksi: <?php echo $hasil["kode_transaksi"]; ?></h4>
    <h4>Nama Pemesan: <?php echo $hasil["nama"]; ?></h4>
    <h4>Tgl. Transaksi: <?php echo $hasil["tgl"]; ?></h4>

    <table class="table">
      <thead>
        <tr>
          <th>Kode Barang</th>
          <th>Nama Barang</th>
          <th>Jumlah Item</th>
          <th>Harga</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php $total = 0; foreach ($result2 as $barang): ?>
          <tr>
            <td><?php echo $barang["kode_barang"]; ?></td>
            <td><?php echo $barang["nama"]; ?></td>
            <td><?php echo $barang["jumlah"]; ?></td>
            <td><?php echo "Rp ".number_format($barang["harga"]); ?></td>
            <td><?php echo "Rp ".number_format($barang["harga"]*$barang["jumlah"]); ?></td>
          </tr>
          <?php
          $total += $barang["harga"]*$barang["jumlah"];
          endforeach;
           ?>
      </tbody>
    </table>
    <h2 class="text-right text-success">
      <?php echo "Rp ".number_format($total); ?>
    </h2>
  </div>
</div>
