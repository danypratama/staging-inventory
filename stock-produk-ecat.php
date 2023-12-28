<?php
$page = 'produk';
$page2 = 'data-stock-ecat';
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
          <li class="breadcrumb-item active">Stock Produk Ecat</li>
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
            <?php  
               include "koneksi.php";
               $id_role = $_SESSION['tiket_role'];
               $sql_role = "SELECT * FROM user_role WHERE id_user_role='$id_role'";
               $query_role = mysqli_query($connect, $sql_role) or die(mysqli_error($connect));
               $data_role = mysqli_fetch_array($query_role);
               if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Manager Gudang") { 
                 ?>
                   <a href="tambah-stock-produk-ecat.php" class="btn btn-primary btn-md"><i class="bi bi-plus-circle"></i> Tambah data stock produk ecat</a>
                 <?php 
               }
            ?>
            <!-- Pills Tabs -->
            <ul class="nav nav-pills mb-3 mt-3" id="pills-tab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Produk Satuan</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Produk Set</button>
              </li>
            </ul>
            <div class="tab-content pt-2" id="myTabContent">
              <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="home-tab">
                <div class="table-responsive mt-3">
                  <table class="table table-striped table-bordered" id="table1">
                    <thead>
                      <tr class="text-white" style="background-color: #051683;">
                        <td class="text-center p-3" style="width: 50px">No</td>
                        <td class="text-center p-3" style="width: 450px">Nama Produk</td>
                        <td class="text-center p-3" style="width: 100px">Merk</td>
                        <td class="text-center p-3" style="width: 80px">Stock</td>
                        <td class="text-center p-3" style="width: 80px">Level</td>
                        <?php  
                          if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Manager Gudang") { 
                            ?>
                              <td class="text-center p-3" style="width: 50px">Aksi</td>
                            <?php 
                          }
                        ?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      date_default_timezone_set('Asia/Jakarta');
                      include "koneksi.php";
                      include "function/class-function.php";
                      $no = 1;
                      $sql = "SELECT 
                                  COALESCE(tpr.id_produk_ecat, tpsm.id_set_ecat) AS id_produk,
                                  COALESCE(tpr.nama_produk, tpsm.nama_set_ecat) AS nama_produk,
                                  COALESCE(mr_tpr.nama_merk, mr_tpsm.nama_merk) AS nama_merk,
                                  spr.id_stock_prod_ecat,
                                  spr.stock,
                                  tkp.min_stock, 
                                  tkp.max_stock,
                                  SUBSTRING(COALESCE(tpr.id_produk_ecat, tpsm.id_set_ecat), 1, 2) AS substr_id_produk
                              FROM stock_produk_ecat AS spr
                              LEFT JOIN tb_produk_ecat AS tpr ON (tpr.id_produk_ecat = spr.id_produk_ecat)
                              LEFT JOIN tb_kat_penjualan AS tkp ON (tkp.id_kat_penjualan = spr.id_kat_penjualan)
                              LEFT JOIN tb_produk_set_ecat AS tpsm ON (tpsm.id_set_ecat = spr.id_produk_ecat)
                              LEFT JOIN tb_merk AS mr_tpr ON (tpr.id_merk = mr_tpr.id_merk)
                              LEFT JOIN tb_merk AS mr_tpsm ON (tpsm.id_merk = mr_tpsm.id_merk)
                              WHERE SUBSTRING(COALESCE(tpr.id_produk_ecat, tpsm.id_set_ecat), 1, 2) = 'BR'
                              ORDER BY nama_produk ASC";

                      $query = mysqli_query($connect, $sql);
                      while ($data = mysqli_fetch_array($query)) {
                        $id_stock = base64_encode($data['id_stock_prod_ecat']);
                        $id_produk = base64_encode($data['id_produk']);
                        $id_produk_substr = substr($id_produk, 0, 2);
                        $stockData = StockStatus::getStatus($data['stock'], $data['min_stock'], $data['max_stock']);
                      ?>
                        <tr>
                          <td class="text-center"><?php echo $no; ?></td>
                          <td><?php echo $data['nama_produk'] ?></td>
                          <td class="text-center"> <?php echo $data['nama_merk'] ?> </td>
                          <?php echo "<td class='text-end " . $stockData['textColor'] . "' style='background-color: " . $stockData['backgroundColor'] . "'>" . $stockData['formattedStock'] . "</td>";  ?>
                          <?php echo "<td class='text-end'>" . $stockData['status'] . "</td>"; ?>
                          <?php  
                            if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Manager Gudang") { 
                              ?>
                                <td class="text-center">
                                  <a href="proses/proses-stock-ecat.php?hapus-stock-ecat=<?php echo $id_stock ?>&id_produk=<?php echo $id_produk ?>" class="btn btn-sm btn-danger delete-data"><i class="bi bi-trash"></i></a>
                                </td>
                              <?php 
                            }
                          ?>
                        </tr>
                        <?php $no++; ?>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="table-responsive mt-3">
                  <table class="table table-striped table-bordered" id="tableKu">
                    <thead>
                      <tr class="text-white" style="background-color: #051683;">
                        <td class="text-center p-3" style="width: 50px">No</td>
                        <td class="text-center p-3" style="width: 450px">Nama Produk</td>
                        <td class="text-center p-3" style="width: 100px">Merk</td>
                        <td class="text-center p-3" style="width: 80px">Stock</td>
                        <td class="text-center p-3" style="width: 80px">Level</td>
                        <?php  
                          if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Manager Gudang") { 
                            ?>
                              <td class="text-center p-3" style="width: 50px">Aksi</td>
                            <?php 
                          }
                        ?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      date_default_timezone_set('Asia/Jakarta');
                      include "koneksi.php";
                      include "function/class-function-set.php";
                      $no = 1;
                      $sql_set = "SELECT 
                                      COALESCE(tpr.id_produk_ecat, tpsm.id_set_ecat) AS id_produk,
                                      COALESCE(tpr.nama_produk, tpsm.nama_set_ecat) AS nama_produk,
                                      COALESCE(mr_tpr.nama_merk, mr_tpsm.nama_merk) AS nama_merk,
                                      spr.id_stock_prod_ecat,
                                      spr.stock,
                                      tkp.min_stock, 
                                      tkp.max_stock,
                                      SUBSTRING(COALESCE(tpr.id_produk_ecat, tpsm.id_set_ecat), 1, 2) AS substr_id_produk
                                  FROM stock_produk_ecat AS spr
                                  LEFT JOIN tb_produk_ecat AS tpr ON (tpr.id_produk_ecat = spr.id_produk_ecat)
                                  LEFT JOIN tb_kat_penjualan AS tkp ON (tkp.id_kat_penjualan = spr.id_kat_penjualan)
                                  LEFT JOIN tb_produk_set_ecat AS tpsm ON (tpsm.id_set_ecat = spr.id_produk_ecat)
                                  LEFT JOIN tb_merk AS mr_tpr ON (tpr.id_merk = mr_tpr.id_merk)
                                  LEFT JOIN tb_merk AS mr_tpsm ON (tpsm.id_merk = mr_tpsm.id_merk)
                                  WHERE SUBSTRING(COALESCE(tpr.id_produk_ecat, tpsm.id_set_ecat), 1, 2) = 'SE'
                                  ORDER BY nama_produk ASC";
                      $query_set = mysqli_query($connect, $sql_set);
                      while ($data_set = mysqli_fetch_array($query_set)) {
                        $id_stock = base64_encode($data_set['id_stock_prod_ecat']);
                        $id_produk = base64_encode($data_set['id_produk']);
                        $stockDataSet = StockStatusSet::getStatusSet($data_set['stock'], $data_set['min_stock'], $data_set['max_stock']);
                      ?>
                        <tr>
                          <td class="text-center"><?php echo $no; ?></td>
                          <td><?php echo $data_set['nama_produk'] ?></td>
                          <td class="text-center"> <?php echo $data_set['nama_merk'] ?> </td>
                          <?php echo "<td class='text-end " . $stockDataSet['textColor'] . "' style='background-color: " . $stockDataSet['backgroundColor'] . "'>" . $stockDataSet['formattedStock'] . "</td>";  ?>
                          <?php echo "<td class='text-end'>" . $stockDataSet['status'] . "</td>"; ?>
                          <?php  
                          if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Manager Gudang") { 
                              ?>
                                <td class="text-center">
                                  <a href="proses/proses-stock-ecat.php?hapus-stock-ecat=<?php echo $id_stock ?>&id_produk=<?php echo $id_produk ?>" class="btn btn-sm btn-danger delete-data"><i class="bi bi-trash"></i></a>
                                </td>
                              <?php 
                            }
                          ?>
                        </tr>
                        <?php $no++; ?>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div><!-- End Pills Tabs -->
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