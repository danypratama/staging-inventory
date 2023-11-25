<?php
$page = 'list-tagihan';
include 'akses.php';

// Periksa apakah tanggal telah dipilih atau belum
$dateRanges = array('today', 'weekly', 'monthly', 'lastMonth', 'year', 'lastyear');
$selectedDateRange = isset($_GET['date_range']) && in_array($_GET['date_range'], $dateRanges) ? $_GET['date_range'] : 'pilihTanggal';

// Periksa apakah customer service telah dipilih atau belum
$nama_cs = isset($_GET['cs']) ? $_GET['cs'] : array();

?>
<!DOCTYPE html>
<html lang="en">
<?php include 'page/head.php'; ?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Inventory KMA</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link rel="stylesheet" type="text/css" media="all" href="daterangepicker.css" />

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
  <script type="text/javascript" src="daterangepicker.js"></script>
  <style>
    /* Custom styling for the date inputs */
    .form-control[type="date"] {
      appearance: none;
      padding: 0.5rem;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    /* Optional: Adjust the date input height and font-size */
    .form-control[type="date"] {
      height: 38px;
      font-size: 14px;
    }

    /* Adjust the position of the dropdown */
    .dropdown {
      display: inline-block;
      position: relative;
    }

    /* Adjust the style of the dropdown menu items */
    .dropdown-menu {
      min-width: 350px;
      padding: 20px;
    }

    .dropdown-item{
      text-align: center;
      border: 1px solid #ced4da;
      margin-bottom: 10px;
    }

    .separator {
      display: inline-block;
      width: 40px; /* Atur panjang pemisah sesuai keinginan */
      font-size: 1.2rem;
      font-weight: bold;
      text-align: center;
      color: #333; /* Ubah warna sesuai keinginan */
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

  <div id="content">
    <main id="main" class="main">
      <!-- Loading -->
      <div class="loader loader">
        <div class="loading">
          <img src="img/loading.gif" width="200px" height="auto">
        </div>
      </div>
      <!-- End Loading -->
      <div class="pagetitle">
        <h1>Data Invoice Non PPN</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
            <li class="breadcrumb-item active">Invoice Non PPN</li>
          </ol>
        </nav>
      </div><!-- End Page Title -->
      <section>
        <!-- SWEET ALERT -->
        <div class="info-data" data-infodata="<?php if (isset($_SESSION['info'])) { echo $_SESSION['info']; } unset($_SESSION['info']); ?>"></div>
        <!-- END SWEET ALERT -->
        <div class="card">
          <div class="card-body p-3">
            <div class="table-responsive">
              <table class="table table-responsive table-striped" id="table2">
                <thead>
                  <tr class="text-white" style="background-color: navy;">
                    <td class="p-3 text-center text-nowrap">No</td>
                    <td class="p-3 text-center text-nowrap">No. Tagihan</td>
                    <td class="p-3 text-center text-nowrap">Tgl. Tagihan</td>
                    <td class="p-3 text-center text-nowrap">Nama Customer</td>
                    <td class="p-3 text-center text-nowrap">Total Tagihan</td>
                    <td class="p-3 text-center text-nowrap">Total Bayar</td>
                    <td class="p-3 text-center text-nowrap">Sisa Tagihan</td>
                    <td class="p-3 text-center text-nowrap">Aksi</td>
                  </tr>
                </thead>
                <tbody>
                  <?php  
                    include "koneksi.php";
                    $no = 1;
                    $sql = "SELECT tagihan.id_tagihan AS tagihan_id,
                                    tagihan.no_tagihan,
                                    tagihan.tgl_tagihan,
                                    tagihan.total_tagihan,
                                    fnc.id_tagihan AS id_tagihan_fnc,
                                    fnc.id_inv,
                                    fnc.jenis_inv,
                                    fnc.status_lunas,
                                    COALESCE(byr.total_bayar, 0) AS total_pembayaran,
                                    nonppn.id_inv_nonppn,
                                    nonppn.cs_inv AS cs_nonppn,
                                    ppn.id_inv_ppn,
                                    ppn.cs_inv AS cs_ppn,
                                    bum.id_inv_bum,
                                    bum.cs_inv AS cs_bum                                
                              FROM finance_tagihan AS tagihan
                              LEFT JOIN finance fnc ON (tagihan.id_tagihan = fnc.id_tagihan)
                              LEFT JOIN (
                                  SELECT id_tagihan, SUM(total_bayar) AS total_bayar
                                  FROM finance_bayar
                                  GROUP BY id_tagihan
                              ) byr ON (tagihan.id_tagihan = byr.id_tagihan)
                              LEFT JOIN inv_nonppn nonppn ON (fnc.id_inv = nonppn.id_inv_nonppn)
                              LEFT JOIN inv_ppn ppn ON (fnc.id_inv = ppn.id_inv_ppn)
                              LEFT JOIN inv_bum bum ON (fnc.id_inv = bum.id_inv_bum)
                              GROUP BY tagihan_id, id_tagihan_fnc -- Menambahkan id_tagihan_fnc ke dalam GROUP BY
                              ORDER BY no_tagihan ASC";
                    $query = mysqli_query($connect, $sql);
                    while ($data = mysqli_fetch_array($query)) {
                      $total_bayar = $data ['total_pembayaran'];
                      $total_tagihan = $data['total_tagihan'];
                      $total_sisa_tagihan = $total_tagihan - $total_bayar;
                      $tgl_tagihan = $data['tgl_tagihan'];
                      $no_tagihan = $data['no_tagihan']
                  ?>
                  <tr>
                    <td class="text-center"><?php echo $no; ?></td>
                    <td class="text-center text-nowrap"><?php echo $data['no_tagihan'] ?></td>
                    <td class="text-center text-nowrap"><?php echo $data['tgl_tagihan'] ?></td>
                    <td>
                      <?php
                        if (!empty($data['cs_nonppn'])) {
                            echo $data['cs_nonppn'];
                        } elseif (!empty($data['cs_ppn'])) {
                            echo $data['cs_ppn'];
                        } elseif (!empty($data['cs_bum'])) {
                            echo $data['cs_bum'];
                        }
                      ?>
                    </td>
                    <td class="text-end"><?php echo number_format($data['total_tagihan'],0,'.','.')?></td>
                    <td class="text-end"><?php echo number_format($total_bayar,0,'.','.')?></td>
                    <td class="text-end">
                      <?php
                        if($total_sisa_tagihan == 0){
                          echo '
                            <button type="button" class="btn btn-secondary btn-sm mb-2">
                                <i class="bi bi-check-circle"></i> Lunas
                            </button>';
                        }else{
                          echo number_format($total_sisa_tagihan,0,'.','.');
                        }
                      ?>
                    </td>
                    <td class="text-center">
                      <a href="detail-bill.php?id=<?php echo base64_encode($data['tagihan_id'])?>" class="btn btn-primary btn-sm"><i class="bi bi-eye"></i> Lihat Data</a>
                    </td>
                  </tr>
                  <?php $no++ ?>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </section>
    </main><!-- End #main -->
  </div>
  <!-- Footer -->
  <?php include "page/footer.php" ?>
  <!-- End Footer -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include "page/script.php" ?>
</body>
</html>