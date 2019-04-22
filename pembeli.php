      <script type="text/javascript">
        function Add() {
          document.getElementById('action').value="insert";

          document.getElementById("id_pembeli").value="";
          document.getElementById("nama").value="";
          document.getElementById("alamat").value="";
          document.getElementById("kontak").value="";
        }

        function Edit(index){
          document.getElementById('action').value="update";

          var table = document.getElementById("table_pembeli");
          var id_pembeli = table.rows[index].cells[0].innerHTML;
          var nama = table.rows[index].cells[1].innerHTML;
          var alamat = table.rows[index].cells[2].innerHTML;
          var kontak = table.rows[index].cells[3].innerHTML;
          var username = table.rows[index].cells[4].innerHTML;
          var password = table.rows[index].cells[5].innerHTML;

          document.getElementById("id_pembeli").value =  id_pembeli;
          document.getElementById("nama").value = nama;
          document.getElementById("alamat").value = alamat;
          document.getElementById("kontak").value = kontak;
          document.getElementById("username").value = username;
          document.getElementById("password").value = password;
        }
      </script>
      <div class="card col-sm-12">
        <div class="card-header">
          <h4>Daftar Pembeli</h4>
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
          $sql = "select * from table_pembeli";
          $result = mysqli_query($koneksi,$sql);
          $count = mysqli_num_rows($result);
          ?>

          <?php if ($count == 0): ?>
          <div class="alert alert-info">
            Data belum tersedia
          </div>

        <?php else: ?>
          <table class="table" id="table_pembeli">
            <thead>
              <tr>
                <th>id_pembeli</th>
                <th>nama</th>
                <th>alamat</th>
                <th>kontak</th>
                <th>username</th>
                <th>password</th>
                <th>image</th>
                <th>Opsi</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($result as $hasil): ?>
            <tr>
              <td><?php echo $hasil ["id_pembeli"]; ?></td>
              <td><?php echo $hasil ["nama"]; ?></td>
              <td><?php echo $hasil ["alamat"]; ?></td>
              <td><?php echo $hasil ["kontak"]; ?></td>
              <td><?php echo $hasil ["username"]; ?></td>
              <td><?php echo $hasil ["password"]; ?></td>
              <td>
                <img src="<?php echo "img_pembeli/".$hasil["image"]; ?>"
                class="img" width="100" >
              </td>
              <td>
                <button type="button" class="btn btn-info"
                  data-toggle="modal" data-target="#modal"
                  onclick="Edit(this.parentElement.parentElement.rowIndex);">
                  Edit
                </button>

                <a href="db_pembeli.php?hapus=table_pembeli&id_pembeli=<?php echo $hasil['id_pembeli']; ?>"
                  onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                  <button type="button" class="btn btn-danger">
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
          <form action="db_pembeli.php" method="post" enctype="multipart/form-data">
            <div class="modal-header">
              <h4>Form Pembeli</h4>
              <span class="close" data-dismiss="modal">&times;</span>
            </div>
            <div class="modal-body">
              <input type="hidden" name="action" id="action">
              id_pembeli
              <input type="text" name="id_pembeli" id="id_pembeli" class="form-control">
              nama
              <input type="text" name="nama" id="nama" class="form-control">
              alamat
              <input type="text" name="alamat" id="alamat" class="form-control">
              kontak
              <input type="text" name="kontak" id="kontak" class="form-control">
              username
              <input type="text" name="username" id="username" class="form-control">
              password
              <input type="password" name="password" id="password" class="form-control">
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
