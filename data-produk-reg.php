<?php
$page = 'data';
$page2 = 'data-produk';
include "akses.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Inventory KMA</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <?php include "page/head.php"; ?>
  <style>
    #gambarProduk {
      width: 500px;
      height: 600px;
      object-fit: contain;
      object-position: top;
    }
  </style>
</head>

<body>
  <!-- nav header -->
  <?php include "page/nav-header.php" ?>
  <!-- end nav header -->

  <!-- sidebar  -->
  <?php include "page/sidebar.php"; ?>
  <!-- end sidebar -->


  <main id="main" class="main">
    <!-- Loading -->
    <div class="loader loader">
      <div class="loading">
        <img src="img/loading.gif" width="200px" height="auto">
      </div>
    </div>
    <!-- ENd Loading -->
    <div class="pagetitle">
      <h1>Data Produk Reguler</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Data Produk</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section>
      <!-- SWEET ALERT -->
      <div class="info-data" data-infodata="<?php if (isset($_SESSION['info'])) {
                                              echo $_SESSION['info'];
                                            }
                                            unset($_SESSION['info']); ?>"></div>
      <!-- END SWEET ALERT -->
      <div class="container-fluid">
        <div class="card">
          <div class="card-body p-3">
            <a href="tambah-data-produk-reg.php" class="btn btn-primary btn-md"><i class="bi bi-plus-circle"></i> Tambah data produk</a>
            <div class="table-responsive mt-3">
              <table class="table table-striped table-bordered" id="table1">
                <thead>
                  <tr class="text-white" style="background-color: #051683;">
                    <td class="text-center p-3" style="width: 50px">No</td>
                    <td class="text-center p-3" style="width: 450px">Nama Produk</td>
                    <td class="text-center p-3" style="width: 100px">Merk</td>
                    <td class="text-center p-3" style="width: 100px">Harga</td>
                    <td class="text-center p-3" style="width: 80px">Stock</td>
                    <td class="text-center p-3" style="width: 80px">Level</td>
                    <td class="text-center p-3" style="width: 50px">Aksi</td>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  date_default_timezone_set('Asia/Jakarta');

                  include "koneksi.php";
                  $no = 1;
                  $sql = "SELECT pr.*,
                            pr.created_date as 'produk_created',
                            pr.created_date as 'produk_updated',
                            pr.id_produk_reg as 'produk_id',    
                            uc.nama_user as user_created, 
                            uu.nama_user as user_updated,
                            mr.*,
                            kp.*,
                            kj.*,
                            kp.nama_kategori as kat_prod,
                            kj.nama_kategori as kat_penj,
                            gr.*,
                            lok.*,
                            spr.*
                            FROM tb_produk_reguler as pr
                            LEFT JOIN user uc ON (pr.id_user = uc.id_user)
                            LEFT JOIN user uu ON (pr.user_updated = uu.id_user)
                            LEFT JOIN tb_merk mr ON (pr.id_merk = mr.id_merk)
                            LEFT JOIN tb_kat_produk kp ON (pr.id_kat_produk = kp.id_kat_produk)
                            LEFT JOIN tb_kat_penjualan kj ON (pr.id_kat_penjualan = kj.id_kat_penjualan)
                            LEFT JOIN tb_produk_grade gr ON (pr.id_grade = gr.id_grade)
                            LEFT JOIN tb_lokasi_produk lok ON (pr.id_lokasi = lok.id_lokasi)
                            LEFT JOIN stock_produk_reguler spr ON (pr.id_produk_reg = spr.id_produk_reg)
                            ORDER BY nama_produk ASC";
                  $query = mysqli_query($connect, $sql);
                  while ($data = mysqli_fetch_array($query)) {
                    $id_produk = base64_encode($data['produk_id']);
                    $stock = $data['stock'];
                    $min_stock = $data['min_stock'];
                    $max_stock = $data['max_stock'];
                    $low = $min_stock * 0.25;
                    $low_lev = $min_stock - $low;
                    $med_lev = $min_stock + $low;
                    $high = $max_stock * 0.25;
                    $high_lev = $max_stock - $high;
                    $stock_status = '';
                    $tampil_stock = number_format($data['stock']);
                  ?>
                    <tr>
                      <td class="text-center"><?php echo $no; ?></td>
                      <td><?php echo $data['nama_produk']; ?></td>
                      <td class="text-center"><?php echo $data['nama_merk']; ?></td>
                      <td class="text-end">
                        <a style="float:left; color:black;">Rp</a>
                        <a style="float:right; color:black;"> <?php echo number_format($data['harga_produk']); ?> </a>
                      </td>
                      <?php
                      if ($stock <= $low_lev) {
                        echo "<td class='text-end text-white' style='background-color: #cc0000'>" . ($tampil_stock) . "</td>";
                      } else if ($stock >= $low_lev && $stock <= $min_stock) {
                        echo "<td class='text-end' style='background-color: #ff4500'>" . ($tampil_stock) . "</td>";
                      } else if ($stock >= $min_stock && $stock <= $high_lev) {
                        echo "<td class='text-end' style='background-color: #ffff00'>" . ($tampil_stock) . "</td>";
                      } else if ($stock >= $high_lev && $stock <= $max_stock) {
                        echo "<td class='text-end text-white' style='background-color: #469536'>" . ($tampil_stock) . "</td>";
                      } else if ($stock > $max_stock) {
                        echo "<td class='text-end text-white' style='background-color: #006600'>" . ($tampil_stock) . "</td>";
                      }
                      ?>
                      <?php
                      if ($stock < 1) {
                        echo "<td class='text-end'>" . ($stock_status = 'Habis') . "</td>";
                      } else if ($stock <= $low_lev) {
                        echo "<td class='text-end'>" . ($stock_status = 'Very Low') . "</td>";
                      } else if ($stock >= $low_lev && $stock <= $min_stock) {
                        echo "<td class='text-end'>" . ($stock_status = 'Low') . "</td>";
                      } else if ($stock >= $min_stock && $stock <= $high_lev) {
                        echo "<td class='text-end'>" . ($stock_status = 'Medium') . "</td>";
                      } else if ($stock >= $high_lev && $stock <= $max_stock) {
                        echo "<td class='text-end'>" . ($stock_status = 'High') . "</td>";
                      } else if ($stock > $max_stock) {
                        echo "<td class='text-end'>" . ($stock_status = 'Very High') . "</td>";
                      }
                      ?>
                      <td class="text-center">
                        <div class="dropdown">
                          <a class="btn btn-secondary btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            Pilih
                          </a>
                          <ul class="dropdown-menu mb-3" aria-labelledby="dropdownMenuLink">
                            <li>
                              <a class="dropdown-item btn-detail" href="#" data-kode-produk="<?php echo $data['kode_produk'] ?>" data-nama-produk="<?php echo $data['nama_produk']; ?>" data-merk-produk="<?php echo $data['nama_merk']; ?>" data-harga-produk="<?php echo format_rupiah($data['harga_produk']) ?>" data-stock-produk="<?php echo $data['stock'] ?>" data-kategori-produk="<?php echo $data['kat_prod'] ?>" data-izin-edar="<?php echo $data['no_izin_edar'] ?>" data-kategori-penjualan="<?php echo $data['kat_penj'] ?>" data-grade-produk="<?php echo $data['nama_grade'] ?>" data-lokasi-produk="<?php echo $data['nama_lokasi'] ?>" data-lantai-produk="<?php echo $data['no_lantai'] ?>" data-area-produk="<?php echo $data['nama_area'] ?>" data-rak-produk="<?php echo $data['no_rak'] ?>" data-created-produk="<?php echo $data['produk_created'] ?>" data-user-created="<?php echo $data['user_created'] ?>" data-update-produk="<?php echo $data['produk_updated'] ?>" data-user-update="<?php echo $data['user_updated'] ?>" data-gambar-produk="<?php echo $data['gambar']; ?>">Detail</a>
                            </li>
                            <li><a class="dropdown-item" href="edit-produk-reg.php?edit-data=<?php echo $id_produk ?>">Edit</a></li>
                            <li><a class="dropdown-item delete-data" href="proses/proses-produk-reg.php?hapus-produk-reg=<?php echo $id_produk ?>">Hapus</a></li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    <?php $no++; ?>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main><!-- End #main -->

  <!-- Modal Detail -->
  <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-body">
          <div class="card">
            <div class="card-header text-center">
              <h4><strong>Detail Produk Reguler</strong></h4>
            </div>
            <div class="card-body p-3">
              <div class="row">
                <div class="col-5">
                  <img alt="Gambar Produk" id="gambarProduk" class="img-fluid">
                </div>
                <div class="col-7">
                  <table class="table table-bordered table-striped">
                    <tr>
                      <td>Kode Produk</td>
                      <td id="kodeProduk"></td>
                    </tr>
                    <tr>
                      <td>No Izin Edar</td>
                      <td id="izinEdar"></td>
                    </tr>
                    <tr>
                      <td>Nama Produk</td>
                      <td id="namaProduk"></td>
                    </tr>
                    <tr>
                      <td>Merk Produk</td>
                      <td id="merkProduk"></td>
                    </tr>
                    <tr>
                      <td>Harga Produk</td>
                      <td id="hargaProduk"></td>
                    </tr>
                    <tr>
                      <td>Stock Produk</td>
                      <td id="stockProduk"></td>
                    </tr>
                    <tr>
                      <td>Kategori Produk</td>
                      <td id="katProduk"></td>
                    </tr>
                    <tr>
                      <td>Kategori Penjualan</td>
                      <td id="katPenjualan"></td>
                    </tr>
                    <tr>
                      <td>Kategori Penjualan</td>
                      <td id="katGrade"></td>
                    </tr>
                    <tr>
                      <td>Lokasi Produk</td>
                      <td id="katLokasi"></td>
                    </tr>
                    <tr>
                      <td>No. Lantai</td>
                      <td id="lantaiLokasi"></td>
                    </tr>
                    <tr>
                      <td>Area</td>
                      <td id="areaLokasi"></td>
                    </tr>
                    <tr>
                      <td>No. Rak</td>
                      <td id="rakLokasi"></td>
                    </tr>
                    <tr>
                      <td>Dibuat Tanggal</td>
                      <td id="created"></td>
                    </tr>
                    <tr>
                      <td>Dibuat Oleh</td>
                      <td id="userCreated"></td>
                    </tr>
                    <tr>
                      <td>Diubah Tanggal</td>
                      <td id="updated"></td>
                    </tr>
                    <tr>
                      <td>Diubah Oleh</td>
                      <td id="userUpdated"></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include "page/footer.php" ?>
  <!-- End Footer -->
  <!-- end modal detail -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include "page/script.php" ?>
</body>

</html>

<!-- Generat UUID -->
<?php
function generate_uuid()
{
  return sprintf(
    '%04x%04x%04x',
    mt_rand(0, 0xffff),
    mt_rand(0, 0xffff),
    mt_rand(0, 0xffff),
    mt_rand(0, 0x0fff) | 0x4000,
    mt_rand(0, 0x3fff) | 0x8000,
    mt_rand(0, 0xffff),
    mt_rand(0, 0xffff),
    mt_rand(0, 0xffff)
  );
}
?>
<!-- End Generate UUID -->

<?php
function format_rupiah($angka)
{
  $rupiah = "Rp " . number_format($angka, 0, ',', '.');
  return $rupiah;
}
?>

<script>
  $(document).ready(function() {
    $('.btn-detail').click(function() {
      var kodeProduk = $(this).data('kode-produk');
      var izinEdar = $(this).data('izin-edar');
      var namaProduk = $(this).data('nama-produk');
      var merkProduk = $(this).data('merk-produk');
      var hargaProduk = $(this).data('harga-produk');
      var stockProduk = $(this).data('stock-produk');
      var katProduk = $(this).data('kategori-produk');
      var katPenjualan = $(this).data('kategori-penjualan');
      var katGrade = $(this).data('grade-produk');
      var katLokasi = $(this).data('lokasi-produk');
      var lantaiLokasi = $(this).data('lantai-produk');
      var areaLokasi = $(this).data('area-produk');
      var rakLokasi = $(this).data('rak-produk');
      var gambarProduk = $(this).data('gambar-produk');
      var created = $(this).data('created-produk');
      var userCreated = $(this).data('user-created');
      var updated = $(this).data('updated-produk');
      var userUpdated = $(this).data('user-updated');

      $('#kodeProduk').html(kodeProduk);
      $('#izinEdar').html(izinEdar);
      $('#namaProduk').html(namaProduk);
      $('#merkProduk').html(merkProduk);
      $('#hargaProduk').html(hargaProduk);
      $('#stockProduk').html(stockProduk);
      $('#katProduk').html(katProduk);
      $('#katPenjualan').html(katPenjualan);
      $('#katGrade').html(katGrade);
      $('#katLokasi').html(katLokasi);
      $('#lantaiLokasi').html(lantaiLokasi);
      $('#areaLokasi').html(areaLokasi);
      $('#rakLokasi').html(rakLokasi);
      $('#gambarProduk').attr('src', 'gambar/upload-marwa/' + gambarProduk);
      $('#created').html(created);
      $('#userCreated').html(userCreated);
      $('#updated').html(updated);
      $('#userUpdated').html(userUpdated);

      $('#modalDetail').modal('show');
    });
  });
</script>