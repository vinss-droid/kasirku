<?php
require 'function.php';


if (isset($_POST["submit"])) {
  if (tambah($_POST) > 0) {
    echo "
                <script>
                    alert('Congratulation, Welcome To Our Family');
                    window.location = 'index.php'
                </script>
            ";
  } else {
    echo "
                <script>
                    alert('data failed to add');
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
  <title>KASIRKU</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <?php include 'template/header.php'; ?>
  <?php $barang = mysqli_query($conn, "SELECT * FROM barang");
  $jsArray = "var harga_barang = new Array();";
  $jsArray1 = "var nama_barang = new Array();";
  ?>
  <div class="col-md-9 mb-2">
    <div class="row">

      <!-- kasir -->
      <div class="col-md-6 mb-3">
        <div class="card">
          <div class="card-body py-4">
            <form method="POST"  name="autoSumForm">
              <div class="form-group row mb-0">
                <label class="col-sm-4 col-form-label col-form-label-sm"><b>Tgl. Transaksi</b></label>
                <div class="col-sm-8 mb-2">
                  <input type="text" class="form-control form-control-sm" name="tgl_input" value="<?php echo  date("j F Y"); ?>" readonly>
                </div>
                <label class="col-sm-4 col-form-label col-form-label-sm"><b>Kode Barang</b></label>
                <div class="col-sm-8 mb-2">

                  <select onchange="cek_database()" id="id_barang" class="form-control" name="id_barang">
                    <option value='' selected>- Pilih Kode Barang -</option>
                    <?php
                    include "config.php";
                    $barang = mysqli_query($config, "SELECT * FROM barang");
                    while ($row = mysqli_fetch_array($barang)) { ?>
                      <option value="<?= $row['id_barang'] ?>"><?= $row['id_barang'] ?></option>
                    <?php
                    }
                    ?>
                  </select>

                </div>
                <label class="col-sm-4 col-form-label col-form-label-sm"><b>Nama Barang</b></label>
                <div class="col-sm-8 mb-2">
                  <input type="text" class="form-control form-control-sm" name="nama_barang" id="nama_barang" readonly>
                </div>
                <label class="col-sm-4 col-form-label col-form-label-sm"><b>Harga</b></label>
                <div class="col-sm-8 mb-2">
                  <input type='number' class="form-control" name='harga_barang' id="harga_barang" onchange="total()" value="<?php echo $row['harga_barang']; ?>" onFocus="startCalc();" onBlur="stopCalc();" readonly/>
                  <!-- <input type="number" class="form-control form-control-sm" id="harga_barang" onchange="total()" value="<?php echo $row['harga_barang']; ?>" name="harga_barang" readonly> -->
                </div>
                <label class="col-sm-4 col-form-label col-form-label-sm"><b>Quantity</b></label>
                <div class="col-sm-8 mb-2">
                  <input type='number' class="form-control" name='quantity' id="quantity" onFocus="startCalc();" onBlur="stopCalc();" />
                  <!-- <input type="number" class="form-control form-control-sm" id="quantity" onchange="total()" name="quantity" placeholder="0" required> -->
                </div>
                <label class="col-sm-4 col-form-label col-form-label-sm"><b>Sub-Total</b></label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="text" name="subtotal" class="form-control" id="subtotal" value="0" readonly>
                    <!-- <input type="text" class="form-control form-control-sm" id="subtotal" name="subtotal" onchange="total()" name="sub_total" readonly> -->
                    <div class="input-group-append">
                      <!-- <button class="btn btn-purple btn-sm" name="save" value="simpan" type="submit"> -->
                      <button class="btn btn-purple btn-sm" name="submit" value="submit" type="submit">
                        <i class="fa fa-plus mr-2"></i>Tambah</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
            <script>
              function startCalc() {
                interval = setInterval("calc()", 1);
              }

              function calc() {
                one = document.autoSumForm.harga_barang.value;
                two = document.autoSumForm.quantity.value;
                document.autoSumForm.subtotal.value = (one * 1) * (two * 1);
              }

              function stopCalc() {
                clearInterval(interval);
              }
            </script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.0/axios.min.js" integrity="sha512-OdkysyYNjK4CZHgB+dkw9xQp66hZ9TLqmS2vXaBrftfyJeduVhyy1cOfoxiKdi4/bfgpco6REu6Rb+V2oVIRWg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script type="text/javascript">
              function cek_database() {
                
                var id_barang = $("#id_barang").val();

                  axios
                    .get(`ajax.php?id_barang=${id_barang}`)
                    .then((res) => {

                      var json = res.data;
                      $('#nama_barang').val(json.nama_barang);
                      $('#harga_barang').val(json.harga_barang);

                    })
                    .catch(err => console.error(err));

              }
            </script>
            <?php
            if (isset($_POST['save'])) {
              $idb = $_POST['id_barang'];
              $nama = $_POST['nama_barang'];
              $harga = $_POST['harga_barang'];
              $qty = $_POST['quantity'];
              $total = $_POST['subtotal'];
              $tgl = $_POST['tgl_input'];

              $sql = "INSERT INTO keranjang (kode_barang, nama_barang, harga_barang, quantity, subtotal, tgl_input)
                 VALUES('$idb','$nama','$harga','$qty','$total','$tgl')";
              $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

              if ($query) {
                echo '<script>window.location=""</script>';
              } else {
                echo "Error :" . $sql . "<br>" . mysqli_error($conn);
              }

              mysqli_close($conn);
            } ?>
            <hr>
            <?php

            function format_ribuan($nilai)
            {
              return number_format($nilai, 0, ',', '.');
            }
            $tgl = date("jmYGi");
            $huruf = "AD";
            $kodeCart = $huruf . $tgl;
            ?>
            <?php
            $query = mysqli_query($conn, "SELECT * FROM keranjang");
            $total = 0;
            $tot_bayar = 0;
            $no = 1;
            while ($r = $query->fetch_assoc()) {
              $total = $r['harga_barang'] * $r['quantity'];
              // $tot_bayar += $total;
              $tot_bayar = $total;
              $bayar = $r['bayar'];
              $kembalian = $r['kembalian'];
            }
            error_reporting(0);
            ?>
            <form method="POST">
              <div class="form-group row mb-0">
                <input type="hidden" class="form-control" name="no_transaksi" value="<?php echo $kodeCart; ?>" readonly>
                <input type="hidden" class="form-control" value="<?php echo $tot_bayar; ?>" id="hargatotal" readonly>
                <label class="col-sm-4 col-form-label col-form-label-sm"><b>Bayar</b></label>
                <div class="col-sm-8 mb-2">
                  <input type="number" class="form-control form-control-sm" name="bayar" id="bayarnya" onchange="totalnya()">
                </div>
                <label class="col-sm-4 col-form-label col-form-label-sm"><b>Kembali</b></label>
                <div class="col-sm-8 mb-2">
                  <input type="number" class="form-control form-control-sm" name="kembalian" id="total1" readonly>
                </div>
              </div>
              <div class="text-right">
                <button class="btn btn-purple btn-sm" name="save1" value="simpan" type="submit">
                  <i class="fa fa-shopping-cart mr-2"></i>Bayar</button>
              </div>
            </form>
            <?php
            if (isset($_POST['save1'])) {
              $notrans = $_POST['no_transaksi'];
              $bayar = $_POST['bayar'];
              $kembalian = $_POST['kembalian'];

              $sql = "UPDATE keranjang SET no_transaksi='$notrans',bayar='$bayar',kembalian='$kembalian' ";
              $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
              echo '<script>window.location="index.php"</script>';
            } ?>
          </div>
        </div>
      </div>
      <!-- end kasir -->

      <!-- tes -->
      <div class="col-md-6 mb-3">
        <div class="card" id="print">
          <div class="card-header bg-white border-0 pb-0 pt-4">
            <?php
            $toko = mysqli_query($conn, "SELECT * FROM login ORDER BY nama_toko ASC");
            while ($dat = mysqli_fetch_array($toko)) {
              $user = $dat['user'];
              $nama_toko = $dat['nama_toko'];
              $alamat = $dat['alamat'];
              $telp = $dat['telp'];
              echo "<h5 class='card-tittle mb-0 text-center'><b>$nama_toko</b></h5>
        <p class='m-0 small text-center'>$alamat</p>
          <p class='small text-center'>Telp. $telp</p>";
            }
            ?>
            <div class="row">
              <div class="col-8 col-sm-9 pr-0">
                <ul class="pl-0 small" style="list-style: none;text-transform: uppercase;">
                  <li>NOTA : <?php
                              $notrans = mysqli_query($conn, "SELECT * FROM keranjang ORDER BY no_transaksi ASC LIMIT 1");
                              while ($dat2 = mysqli_fetch_array($notrans)) {
                                $notransaksi = $dat2['no_transaksi'];
                                echo "$notransaksi";
                              }
                              ?></li>
                  <li>KASIR : <?php echo $user ?></li>
                </ul>
              </div>
              <div class="col-4 col-sm-3 pl-0">
                <ul class="pl-0 small" style="list-style: none;">
                  <li>TGL : <?php echo  date("j-m-Y"); ?></li>
                  <li>JAM : <?php echo  date("G:i:s"); ?></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="card-body small pt-0">
            <hr class="mt-0">
            <div class="row">
              <div class="col-5 pr-0">
                <span><b>Nama Barang</b></span>
              </div>
              <div class="col-1 px-0 text-center">
                <span><b>Qty</b></span>
              </div>
              <div class="col-3 px-0 text-right">
                <span><b>Harga</b></span>
              </div>
              <div class="col-3 pl-0 text-right">
                <span><b>Subtotal</b></span>
              </div>
              <div class="col-12">
                <hr class="mt-2">
              </div>
              <?php
              $data_barang = mysqli_query($conn, "SELECT * FROM keranjang");
              while ($d = mysqli_fetch_array($data_barang)) {
              ?>
                <div class="col-5 pr-0">
                  <a href="hapus.php?id=<?php echo $d['id_cart']; ?>" onclick="javascript:return confirm('Hapus Data Barang ?');" style="text-decoration:none;">
                    <i class="fa fa-times fa-xs text-danger mr-1"></i>
                    <span class="text-dark"><?php echo $d['nama_barang']; ?></span>
                  </a>
                </div>
                <div class="col-1 px-0 text-center">
                  <span><?php echo $d['quantity']; ?></span>
                </div>
                <div class="col-3 px-0 text-right">
                  <span><?php echo format_ribuan($d['harga_barang']); ?></span>
                </div>
                <div class="col-3 pl-0 text-right">
                  <span><?php echo format_ribuan($d['subtotal']); ?></span>
                </div>
              <?php } ?>
              <div class="col-12">
                <hr class="mt-2">
                <ul class="list-group border-0">
                  <li class="list-group-item p-0 border-0 d-flex justify-content-between align-items-center">
                    <b>Total</b>
                    <span><b><?php echo format_ribuan($tot_bayar); ?></b></span>
                  </li>
                  <li class="list-group-item p-0 border-0 d-flex justify-content-between align-items-center">
                    <b>Bayar</b>
                    <span><b><?php echo format_ribuan($bayar); ?></b></span>
                  </li>
                  <li class="list-group-item p-0 border-0 d-flex justify-content-between align-items-center">
                    <b>Kembalian</b>
                    <span><b><?php echo format_ribuan($kembalian); ?></b></span>
                  </li>
                </ul>
              </div>
              <div class="col-sm-12 mt-3 text-center">
                <p>* TERIMA KASIH TELAH BERBELANJA*</p>
              </div>
            </div>
          </div>
        </div>
        <div class="text-right mt-3">
          <form method="POST">
            <button class="btn btn-purple-light btn-sm mr-2" onclick="printContent('print')"><i class="fa fa-print mr-1"></i> Print</button>
            <button class="btn btn-purple btn-sm" name="selesai" type="submit"><i class="fa fa-check mr-1"></i> Selesai</button>
          </form>
        </div>
        <?php
        if (isset($_POST['selesai'])) {
          $ambildata = mysqli_query($conn, "INSERT INTO laporanku (no_transaksi,bayar,kembalian,id_Cart,kode_barang, nama_barang, harga_barang, quantity, subtotal, tgl_input)
                SELECT no_transaksi,bayar,kembalian,id_Cart,kode_barang, nama_barang, harga_barang, quantity, subtotal, tgl_input
                FROM keranjang ") or die(mysqli_connect_error());
          $hapusdata = mysqli_query($conn, "DELETE FROM keranjang");
          echo '<script>window.location="index.php"</script>';
        }
        ?>
      </div>
      <!-- end tes -->

      <?php
      include 'config.php';
      if (!empty($_GET['id'])) {
        $id = $_GET['id'];
        $hapus_data = mysqli_query($conn, "DELETE FROM keranjang WHERE id_cart ='$id'");
        echo '<script>window.location="index.php"</script>';
      }

      ?>
    </div><!-- end row col-md-9 -->
  </div>
  <script type="text/javascript">
    <?php echo $jsArray; ?>
    <?php echo $jsArray1; ?>

    function changeValue(id_barang) {
      document.getElementById("nama_barang").value = nama_barang[id_barang].nama_barang;
      document.getElementById("harga_barang").value = harga_barang[id_barang].harga_barang;
    };

    function total() {
      var harga = parseInt(document.getElementById('harga_barang').value);
      var jumlah_beli = parseInt(document.getElementById('quantity').value);
      var jumlah_harga = harga * jumlah_beli;
      document.getElementById('subtotal').value = jumlah_harga;
    }

    function totalnya() {
      var harga = parseInt(document.getElementById('subtotal').value);
      var pembayaran = parseInt(document.getElementById('bayarnya').value);
      var kembali = pembayaran - harga;
      document.getElementById('total1').value = kembali;
    }

    function printContent(print) {
      var restorepage = document.body.innerHTML;
      var printcontent = document.getElementById(print).innerHTML;
      document.body.innerHTML = printcontent;
      window.print();
      document.body.innerHTML = restorepage;
    }
  </script>
  <?php include 'template/footer.php'; ?>
</body>

</html>