<?php
$page = 'data';
$page2 = 'data-stock-reg';
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
      <h1>Stock Produk Reguler</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Stock Produk Reguler</li>
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
            <a href="tambah-stock-produk-reg.php" class="btn btn-primary btn-md"><i class="bi bi-plus-circle"></i> Tambah data stock produk</a>
            <div class="table-responsive mt-3">
              <table class="table table-striped table-bordered" id="table1">
                <thead>
                  <tr class="text-white" style="background-color: #051683;">
                    <td class="text-center p-3" style="width: 50px">No</td>
                    <td class="text-center p-3" style="width: 450px">Nama Produk</td>
                    <td class="text-center p-3" style="width: 100px">Merk</td>
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
                  $sql = "SELECT * FROM stock_produk_reguler AS spr
                            LEFT JOIN tb_produk_reguler AS tpr ON (spr.id_produk_reg = tpr.id_produk_reg)
                            LEFT JOIN tb_merk AS tm ON (tm.id_merk = tpr.id_merk)
                            LEFT JOIN tb_kat_penjualan tkp ON (tkp.id_kat_penjualan = tpr.id_kat_penjualan)
                            ORDER BY nama_produk ASC ";
                  $query = mysqli_query($connect, $sql);
                  while ($data = mysqli_fetch_array($query)) {
                    $id_stock = base64_encode($data['id_stock_prod_reg']);
                    $id_produk = base64_encode($data['id_produk_reg']);
                    $stock = $data['stock'];
                    $min_stock = $data['min_stock'];
                    $max_stock = $data['max_stock'];
                    $low = $min_stock * 0.25;
                    $low_lev = $min_stock - $low;
                    $med_lev = $min_stock + $low;
                    $high = $max_stock * 0.25;
                    $high_lev = $max_stock - $high;
                    $stock_status = '';
                    $tampil_stock = number_format($data['stock'], 0, '.', '.');
                  ?>
                    <tr>
                      <td class="text-center"><?php echo $no; ?></td>
                      <td><?php echo $data['nama_produk']; ?></td>
                      <td class="text-center"><?php echo $data['nama_merk']; ?></td>
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
                      if ($stock <= $low_lev) {
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
                        <a href="proses/proses-stock-reg.php?hapus-stock-reg=<?php echo $id_stock ?>&id_produk=<?php echo $id_produk ?>" class="btn btn-sm btn-danger delete-data"><i class="bi bi-trash"></i></a>
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

  <!-- Footer -->
  <?php include "page/footer.php" ?>
  <!-- End Footer -->
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