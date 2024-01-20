<?php
$page = 'produk';
$page2 = 'data-produk-set-ecat';
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
</head>

<body>
  <!-- nav header -->
  <?php include "page/nav-header.php" ?>
  <!-- end nav header -->

  <!-- sidebar  -->
  <?php include "page/sidebar.php"; ?>
  <!-- end sidebar -->

  <main id="main" class="main">
    <div class="loader loader">
        <div class="loading">
            <img src="img/loading.gif" width="200px" height="auto">
        </div>
    </div>
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
            $id = base64_decode($_GET['detail-id']);
            $sql = "SELECT * FROM tb_produk_set_ecat AS tbsm 
                      LEFT JOIN tb_lokasi_produk AS lk ON (tbsm.id_lokasi = lk.id_lokasi)
                      WHERE id_set_ecat = '$id'";
            $query = mysqli_query($connect, $sql) or die(mysqli_error($connect, $sql));
            $data = mysqli_fetch_array($query);
            ?>
            <div class="row">
              <div class="col-sm-8">
                <p>Kode set : <?php echo $data['kode_set_ecat']; ?></p>
                <p>Nama set : <?php echo $data['nama_set_ecat']; ?></p>
                <?php
                include "koneksi.php";
                $grand_total = 0;
                $id = base64_decode($_GET['detail-id']);
                $sql_data = "SELECT ipsm.id_isi_set_ecat, ipsm.id_set_ecat, ipsm.id_produk, ipsm.qty, tpr.nama_produk, tpr.harga_produk FROM isi_produk_set_ecat ipsm
                              LEFT JOIN tb_produk_ecat tpr ON (ipsm.id_produk = tpr.id_produk_ecat)
                              LEFT JOIN tb_produk_set_ecat tpsm ON (ipsm.id_set_ecat = tpsm.id_set_ecat)
                              WHERE tpsm.id_set_ecat = '$id'";
                $query_data = mysqli_query($connect, $sql_data) or die(mysqli_error($connect, $sql_data));
                while ($row = mysqli_fetch_array($query_data)) {
                  $id_isi_set = $row['id_isi_set_ecat'];
                  $id_set_ecat = $row['id_set_ecat'];
                  $harga = $row['harga_produk'];
                  $qty = $row['qty'];
                  $jumlah = $qty * $harga;
                  $grand_total += $jumlah;
                ?>
                <?php } ?>
                <p>Harga Modal : <?php echo number_format($grand_total, 0, '.', '.'); ?></p>
                <p>Harga Jual : <?php echo number_format($data['harga_set_ecat'], 0, '.', '.'); ?></p>
                <p>Lokasi : <?php echo $data['nama_lokasi']; ?> / <?php echo $data['no_lantai']; ?> / <?php echo $data['nama_area']; ?> / <?php echo $data['no_rak']; ?></p>
              </div>
              <div class="col-sm-4 text-end">
                <a href="tambah-isi-produk-set-ecat.php?id-set=<?php echo base64_encode($data['id_set_ecat']) ?>" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah produk</a>
                <a href="data-produk-set-ecat.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr class="text-white" style="background-color: #051683;">
                    <th class="text-center p-3 text-nowrap" style="width: 50px">No</th>
                    <th class="text-center p-3 text-nowrap" style="width: 100px">Kode Produk</th>
                    <th class="text-center p-3 text-nowrap" style="width: 450px">Nama Produk</th>
                    <th class="text-center p-3 text-nowrap" style="width: 100px">Harga Satuan</th>
                    <th class="text-center p-3 text-nowrap" style="width: 50px">Qty</th>
                    <th class="text-center p-3 text-nowrap" style="width: 80px">Aksi</th>
                  </tr>
                </thead>
                <tbody>   
                  <?php  
                      $no = 1;
                      $sql_isi =  " SELECT 
                                      ipsm.id_isi_set_ecat, 
                                      ipsm.id_set_ecat, 
                                      ipsm.id_produk, 
                                      ipsm.qty, 
                                      COALESCE(tpr.kode_produk, tpe.kode_produk) AS kode_produk, 
                                      COALESCE(tpr.nama_produk, tpe.nama_produk) AS nama_produk, 
                                      COALESCE(tpr.harga_produk, tpe.harga_produk) AS harga_produk
                                    FROM isi_produk_set_ecat ipsm
                                    LEFT JOIN tb_produk_ecat tpe ON (ipsm.id_produk = tpe.id_produk_ecat)
                                    LEFT JOIN tb_produk_set_ecat tpse ON (ipsm.id_set_ecat = tpse.id_set_ecat)
                                    LEFT JOIN tb_produk_reguler tpr ON (ipsm.id_produk = tpr.id_produk_reg)
                                    LEFT JOIN tb_produk_set_marwa tpsm ON (ipsm.id_set_ecat = tpsm.id_set_marwa)
                                    WHERE ipsm.id_set_ecat = '$id'";
                      $query_isi = mysqli_query($connect, $sql_isi) or die(mysqli_error($connect, $sql_isi));
                      while($data = mysqli_fetch_array($query_isi)){
                        $harga = $data['harga_produk'];
                        $qty = $data['qty'];
                        $kode_produk = $data['kode_produk'];    
                        $nama_produk = $data['nama_produk'];    
                        $id_isi_set_ecat = $data['id_isi_set_ecat'];        
                  ?>
                  <tr>
                    <td class="text-center text-nowrap"><?php echo $no; ?></td>
                    <td class="text-nowrap"><?php echo $kode_produk; ?></td>
                    <td class="text-nowrap"><?php echo $nama_produk; ?></td>
                    <td class="text-end text-nowrap"><?php echo number_format($harga) ?></td>
                    <td class="text-end text-nowrap"><?php echo $qty; ?></td>
                    <td class="text-center text-nowrap">
                      <a href="edit-isi-produk-set-ecat.php?edit-id=<?php echo base64_encode($id_isi_set_ecat) ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                      <a href="proses/proses-produk-set-ecat.php?hapus-isi-set=<?php echo base64_encode($id_isi_set_ecat) ?>&kode=<?php echo base64_encode($id_set_ecat) ?>" class="btn btn-danger btn-sm delete-data"><i class="bi bi-trash"></i></a>
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