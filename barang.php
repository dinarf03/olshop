<script type="text/javascript">
  function Add() {
    document.getElementById('action').value="insert";

    document.getElementById("kode_barang").value="";
    document.getElementById("nama").value="";
    document.getElementById("ukuran").value="";
    document.getElementById("warna").value="";
    document.getElementById("harga").value="";
    document.getElementById("deskripsi").value="";
  }

  function Edit(index){
    document.getElementById('action').value="update";

    var table = document.getElementById("table_barang");
    var kode_barang = table.rows[index].cells[0].innerHTML;
    var nama = table.rows[index].cells[1].innerHTML;
    var ukuran = table.rows[index].cells[2].innerHTML;
    var warna = table.rows[index].cells[3].innerHTML;
    var harga = table.rows[index].cells[4].innerHTML;
    var stok = table.rows[index].cells[5].innerHTML;
    var deskripsi = table.rows[index].cells[6].innerHTML;

    document.getElementById("kode_barang").value = kode_barang;
    document.getElementById("nama").value = nama;
    document.getElementById("ukuran").value = ukuran;
    document.getElementById("warna").value = warna;
    document.getElementById("harga").value = harga;
    document.getElementById("stok").value = stok;
    document.getElementById("deskripsi").value = deskripsi;
  }
</script>
<div class="card col-sm-12">
  <div class="card-header">
    <h4>Daftar Barang</h4>
  </div>
  <div class="card-body">
    <?php
    if (isset($_SESSION["message"])): ?>
      <div class="alert alert-<?=($_SESSION["message"]["type"])?>">
        <?php echo $_SESSION["message"]["message"]; ?>
        <?php unset($_SESSION["message"]); ?>
      </div>
    <?php endif; ?>
    <?php
    $koneksi = mysqli_connect("localhost","root","","olshop");
    $sql = "select * from table_barang";
    $result = mysqli_query($koneksi,$sql);
    $count = mysqli_num_rows($result);
    ?>

    <?php if ($count == 0): ?>
    <div class="alert alert-info">
      Data belum tersedia
    </div>

  <?php else: ?>
      <table class="table" id="table_barang">
        <thead>
          <tr>
            <th>kode_barang</th>
            <th>nama</th>
            <th>ukuran</th>
            <th>warna</th>
            <th>harga</th>
            <th>stok</th>
            <th>deskripsi</th>
            <th>image</th>
            <th>Opsi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($result as $hasil): ?>
            <tr>
              <td><?php echo $hasil ["kode_barang"]; ?></td>
              <td><?php echo $hasil ["nama"]; ?></td>
              <td><?php echo $hasil ["ukuran"]; ?></td>
              <td><?php echo $hasil ["warna"]; ?></td>
              <td><?php echo $hasil ["harga"]; ?></td>
              <td><?php echo $hasil ["stok"]; ?></td>
              <td><?php echo $hasil ["deskripsi"]; ?></td>
              <td>
                <img src="<?php echo "img_barang/".$hasil["image"]; ?>"
                class="img" width="100">
              </td>
              <td>
                <button type="button" class="btn btn-info"
                  data-toggle="modal" data-target="#modal"
                  onclick="Edit(this.parentElement.parentElement.rowIndex);">
                  Edit
                </button>

                <a href="db_barang.php?hapus=table_barang&kode_barang=<?php echo $hasil['kode_barang']; ?>"
                  onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                  <button type="button" class="btn btn-warning">
                    Hapus
                  </button>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

  <?php endif; ?>
  </div>
  <div class="card-footer">
    <button type="button" class="btn btn-success"
      data-toggle="modal" data-target="#modal" onclick = "Add()">
      Tambah
    </button>
  </div>
</div>
</div>

<div class="modal fade" id="modal">
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <form action="db_barang.php" method="post" enctype="multipart/form-data">
      <div class="modal-header">
        <h4>Form Barang</h4>
        <span class="close" data-dismiss="modal">&times;</span>
      </div>
      <div class="modal-body">
        <input type="hidden" name="action" id="action">
        kode_barang
        <input type="text" name="kode_barang" id="kode_barang" class="form-control">
        nama
        <input type="text" name="nama" id="nama" class="form-control">
        ukuran
        <input type="text" name="ukuran" id="ukuran" class="form-control">
        warna
        <input type="text" name="warna" id="warna" class="form-control">
        harga
        <input type="number" name="harga" id="harga" class="form-control">
        stok
        <input type="number" name="stok" id="stok" class="form-control">
        deskripsi
        <input type="text" name="deskripsi" id="deskripsi" class="form-control">
        image
        <input type="file" name="image" id="image" class="form-control">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">
          Simpan
        </button>
      </div>
    </form>
  </div>
</div>
</div>
