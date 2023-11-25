<?php
$page = 'finance';
$page2  = 'finance-nonppn';
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
      <!-- <div class="loader loader">
        <div class="loading">
          <img src="img/loading.gif" width="200px" height="auto">
        </div>
      </div> -->
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
        <div class="card p-3">
          <div class="p-2">
            <div class="row">
              <div class="col-sm-5">
                <div class="row row-cols-1 row-cols-lg-3 g-2 g-lg-3">
                  <div class="col">
                    <div class="card">
                      <button class="btn btn-secondary btn-md" id="export-button">Export Excel <i class="bi bi-file-earmark-excel"></i></button>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card" id="cs">
                      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCs">
                        Filter by Customer
                      </button>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card">
                      <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" style="min-width: 170px" data-bs-toggle="dropdown" aria-expanded="false">
                          <?php
                            // Menentukan teks yang ditampilkan berdasarkan nilai dari parameter date_range
                            $selectedOption = isset($_GET['date_range']) ? $_GET['date_range'] : 'today';
                            if ($selectedOption === "today") {
                              echo "Hari ini";
                            } elseif ($selectedOption === "weekly") {
                              echo "Minggu ini";
                            } elseif ($selectedOption === "monthly") {
                              echo "Bulan ini";
                            } elseif ($selectedOption === "lastMonth") {
                              echo "Bulan Kemarin";
                            } elseif ($selectedOption === "year") {
                              echo "Tahun ini";
                            } elseif ($selectedOption === "lastyear") {
                              echo "Tahun Lalu";
                            } else {
                              echo "Pilih Tanggal";
                            }
                          ?>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <form action="" method="GET" class="form-group newsletter-group">
                            <a class="custom-dropdown-item dropdown-item rounded <?php echo isset($_GET['date_range']) && $_GET['date_range'] === 'today' ? 'active' : ''; ?>" href="?date_range=today">Hari ini</a>
                            <a class="custom-dropdown-item dropdown-item rounded <?php echo isset($_GET['date_range']) && $_GET['date_range'] === 'weekly' ? 'active' : ''; ?>" href="?date_range=weekly">Minggu ini</a>
                            <a class="custom-dropdown-item dropdown-item rounded <?php echo isset($_GET['date_range']) && $_GET['date_range'] === 'monthly' ? 'active' : ''; ?>" href="?date_range=monthly">Bulan ini</a>
                            <a class="custom-dropdown-item dropdown-item rounded <?php echo isset($_GET['date_range']) && $_GET['date_range'] === 'lastMonth' ? 'active' : ''; ?>" href="?date_range=lastMonth">Bulan Kemarin</a>
                            <a class="custom-dropdown-item dropdown-item rounded <?php echo isset($_GET['date_range']) && $_GET['date_range'] === 'year' ? 'active' : ''; ?>" href="?date_range=year">Tahun ini</a>
                            <a class="custom-dropdown-item dropdown-item rounded <?php echo isset($_GET['date_range']) && $_GET['date_range'] === 'lastyear' ? 'active' : ''; ?>" href="?date_range=lastyear">Tahun Lalu</a>
                            <a class="custom-dropdown-item dropdown-item rounded <?php echo isset($_GET['date_range']) && $_GET['date_range'] === 'pilihTanggal' ? 'active' : ''; ?>">Pilih Tanggal</a>
                          </form>
                          <li><hr class="dropdown-divider"></li>
                          <form action="" method="GET" class="form-group newsletter-group" id="dateForm">
                            <div class="row p-2">
                              <div class="col-md-6 mb-3">
                                  <label for="start_date">From</label>
                                  <input type="date" id="startDate" class="form-control form-control-md date-picker" placeholder="dd/mm/yyyy" name="start_date">
                              </div>
                              <div class="col-md-6 mb-3">
                                  <label for="end_date">To</label>
                                  <input type="date" id="endDate" class="form-control form-control-md date-picker" placeholder="dd/mm/yyyy" name="end_date">
                              </div>
                              <input type="hidden" name="date_range" value="pilihTanggal">
                            </div>
                            
                            <!-- Add the submit button with name="tampilkan" -->
                            <a href="inv-nonppn.php?date_range=weekly" name="tampilkan" class="custom-dropdown-item dropdown-item rounded bg-danger text-white" id="resetLink">Reset</a>
                          </form>
                          

                        <script>
                          document.addEventListener('DOMContentLoaded', function() {
                              const endDateInput = document.getElementById('endDate');
                              const startDateInput = document.getElementById('startDate');
                              const dateForm = document.getElementById('dateForm');
                              const resetLink = document.getElementById('resetLink');

                              // Cek apakah data tanggal tersimpan di localStorage
                              const savedStartDate = localStorage.getItem('startDate');
                              const savedEndDate = localStorage.getItem('endDate');

                              if (savedStartDate) {
                                  startDateInput.value = savedStartDate;
                              }

                              if (savedEndDate) {
                                  endDateInput.value = savedEndDate;
                              }

                              startDateInput.addEventListener('change', () => {
                                  const startDateValue = new Date(startDateInput.value);
                                  const maxEndDateValue = new Date(startDateValue);
                                  maxEndDateValue.setDate(maxEndDateValue.getDate() + 30);

                                  endDateInput.value = ''; // Reset nilai endDate

                                  endDateInput.min = startDateValue.toISOString().split('T')[0];
                                  endDateInput.max = maxEndDateValue.toISOString().split('T')[0];

                                  endDateInput.disabled = false; // Aktifkan kembali input endDate
                              });

                              endDateInput.addEventListener('change', () => {
                                  const startDateValue = new Date(startDateInput.value);
                                  const endDateValue = new Date(endDateInput.value);

                                  const daysDifference = Math.floor((endDateValue - startDateValue) / (1000 * 60 * 60 * 24));

                                  if (daysDifference > 30) {
                                      endDateInput.value = '';
                                  }

                                  startDateInput.value = startDateValue.toISOString().split('T')[0]; // Menampilkan pada field startDate
                                  endDateInput.value = endDateValue.toISOString().split('T')[0]; // Menampilkan pada field endDate

                                  const queryParams = new URLSearchParams({
                                      start_date: startDateValue.toISOString().split('T')[0],
                                      end_date: endDateValue.toISOString().split('T')[0],
                                      date_range: 'pilihTanggal'
                                  });

                                  const newUrl = `inv-nonppn.php?${queryParams.toString()}`;

                                  dateForm.action = newUrl;
                                  dateForm.submit();

                                  // Simpan tanggal ke localStorage
                                  localStorage.setItem('startDate', startDateInput.value);
                                  localStorage.setItem('endDate', endDateInput.value);
                              });

                              resetLink.addEventListener('click', () => {
                                  // Hapus data dari localStorage
                                  localStorage.removeItem('startDate');
                                  localStorage.removeItem('endDate');

                                  // Hapus nilai dari field input
                                  startDateInput.value = '';
                                  endDateInput.value = '';
                              });
                          });
                        </script>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-7">
                <div class="row row-cols-1 row-cols-lg-3 g-2 g-lg-3">
                  <div class="col">
                    <div class="card">
                      <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping">Status</span>
                        <select class="form-select" id="filterSelect" onchange="filterStatus()">
                          <option value="all">Semua</option>
                          <option value="Belum Bayar">Belum Bayar</option>
                          <option value="Sudah Bayar">Sudah Bayar</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card">
                      <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping">Jenis Invoice</span>
                        <select class="form-select" id="filterSelectInv" onchange="filterInv()">
                          <option value="all">Semua</option>
                          <option value="NONPPN">Non PPN</option>
                          <option value="PPN">PPN</option>
                          <option value="BUM">BUM</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card">
                      <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping">Tagihan</span>
                        <select class="form-select" id="filterSelectInv" onchange="filterInv()">
                          <option value="all">Semua</option>
                          <option value="sudah">Sudah</option>
                          <option value="belum">Belum</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div> 
              </div>
            </div>
          </div>   
          <div class="row">
            <div class="col-md-12 mb-3" id="cs">
                <?php if (!empty($nama_cs)): ?>
                    <div class="d-block d-md-none">
                        <?php foreach ($nama_cs as $cs): ?>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" value="<?= htmlspecialchars($cs) ?>" readonly>
                                <button class="btn btn-outline-dark deleteButton" data-cs="<?= htmlspecialchars($cs) ?>">
                                    <span class="text-dark">X</span>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="d-none d-md-grid grid-cols-5 gap-4">
                        <?php foreach ($nama_cs as $cs): ?>
                            <div class="input-group">
                                <input type="text" class="form-control" value="<?= htmlspecialchars($cs) ?>" readonly>
                                <button class="btn btn-outline-dark deleteButton" data-cs="<?= htmlspecialchars($cs) ?>">
                                    <span class="">X</span>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                <?php endif; ?>
            </div>
          </div>

          <div class="table-responsive">
            <form id="invoiceForm" name="proses" method="POST">
              <div class="col-md-2 mb-3 mt-2">
                <input id="createBill" type="button" name="inv-nonppn" class="btn btn-primary btn-md" value="Buat Tagihan" onclick="submitForm('create-bill.php')">
              </div>
              <table id="table2" class="table table-striped nowrap" style="width:100%">
                <thead>
                  <tr class="text-white" style="background-color: navy;">
                    <td class="text-center p-3">Pilih</td>
                    <td class="text-center p-3">No</td>
                    <td class="text-center p-3">No. Invoice</td>
                    <td class="text-center p-3">Jenis Inv</td>
                    <td class="text-center p-3">Customer</td>
                    <td class="text-center p-3">Tgl. Invoice</td>
                    <td class="text-center p-3">Tgl. Tempo</td>
                    <td class="text-center p-3">Total Tagihan</td>
                    <td class="text-center p-3">Status Pembayaran</td>
                    <td class="text-center p-3">Status Tempo</td>
                    <td class="text-center p-3">Status Tagihan</td>
                    <td class="text-center p-3">Aksi</td>
                  </tr>
                </thead>
                <tbody>
                  <?php  
                    include "koneksi.php";
                    $no = 1;
                    $sort_option ="";
                    $today = date('Y-m-d');
                    $startWeek = date('Y-m-d', strtotime("-1 week"));
                    $endWeek = date('Y-m-d', strtotime("now"));
                    $thisWeekStart= date('Y-m-d',strtotime('last sunday'));
                    $thisWeekEnd= date('Y-m-d',strtotime('next sunday'));
                    $thisMonth = date('m');
                    // Kode Khusus Untuk Last Mont
                    // Dapatkan tanggal saat ini
                    $tanggalSaatIni = new DateTime();

                    // Set tanggal ke awal bulan
                    $tanggalSaatIni->setDate($tanggalSaatIni->format('Y'), $tanggalSaatIni->format('m'), 1);

                    // Kurangkan satu bulan dari tanggal saat ini
                    $tanggalSaatIni->modify('-1 month');

                    // Dapatkan bulan dalam format numerik (dengan angka nol di depan jika berlaku)
                    $lastMonth = $tanggalSaatIni->format('m');

                    // Tampilkan nilai bulan sebelumnya
                    $thisYear = date('Y');
                    $lastYear = date("Y",strtotime("-1 year"));
                    if(isset($_GET['date_range']))
                      {
                        if($_GET['date_range'] == "today")
                        {
                            $sort_option = "(tgl_inv_nonppn = '$today')
                                            OR (tgl_inv_ppn = '$today')
                                            OR (tgl_inv_bum = '$today')";
                        }

                        elseif($_GET['date_range'] == "weekly")
                        {
                            $sort_option = "(tgl_inv_nonppn BETWEEN '$thisWeekStart' AND '$thisWeekEnd')
                                            OR (tgl_inv_ppn BETWEEN '$thisWeekStart' AND '$thisWeekEnd')
                                            OR (tgl_inv_bum BETWEEN '$thisWeekStart' AND '$thisWeekEnd')";
                        }

                        elseif($_GET['date_range'] == "monthly")
                        {
                            $sort_option = "(MONTH(tgl_inv_nonppn) = '".$thisMonth."' AND YEAR(tgl_inv_nonppn) = '".$thisYear."')
                            OR (MONTH(tgl_inv_ppn) = '".$thisMonth."' AND YEAR(tgl_inv_ppn) = '".$thisYear."')
                            OR (MONTH(tgl_inv_bum) = '".$thisMonth."' AND YEAR(tgl_inv_bum) = '".$thisYear."')"; 
                        }

                        elseif($_GET['date_range'] == "lastMonth")
                        {
                            $sort_option = "(MONTH(tgl_inv_nonppn) = '".$lastMonth."' AND YEAR(tgl_inv_nonppn) = '".$thisYear."')
                            OR (MONTH(tgl_inv_ppn) = '".$lastMonth."' AND YEAR(tgl_inv_ppn) = '".$thisYear."')
                            OR (MONTH(tgl_inv_bum) = '".$lastMonth."' AND YEAR(tgl_inv_bum) = '".$thisYear."')"; ; 
                        }

                        elseif($_GET['date_range'] == "year")
                        {
                            $sort_option = "YEAR(tgl_inv_nonppn) = '".$thisYear."' OR YEAR(tgl_inv_ppn) = '".$thisYear."' OR YEAR(tgl_inv_bum) = '".$thisYear."'";
                        }

                        elseif($_GET['date_range'] == "lastyear")
                        {
                            $sort_option = "YEAR(tgl_inv_nonppn) = '".$lastYear."' OR YEAR(tgl_inv_ppn) = '".$lastYear."' OR YEAR(tgl_inv_bum) = '".$lastYear."'";
                        }
                    }
                    if (isset($_GET["start_date"]) && isset($_GET["end_date"])) {
                      $dt1 = $_GET["start_date"];
                      $dt2 = $_GET["end_date"];
                      $sort_option = "tgl_inv_nonppn BETWEEN '$dt1' AND '$dt2' OR tgl_inv_ppn BETWEEN '$dt1' AND '$dt2' OR tgl_inv_bum BETWEEN '$dt1' AND '$dt2'";
                      // Lakukan sesuatu dengan $sort_option, misalnya memproses data dari database
                    }
                    $sql = "SELECT subquery.*, tb_customer.nama_cs, tb_customer.alamat, finance_tagihan.no_tagihan,
                                COALESCE(subquery.cs_inv_nonppn, subquery.cs_inv_ppn, subquery.cs_inv_bum) AS cs_inv
                            FROM (
                                SELECT finance.*, 
                                    inv_nonppn.cs_inv AS cs_inv_nonppn, 
                                    inv_ppn.cs_inv AS cs_inv_ppn, 
                                    inv_bum.cs_inv AS cs_inv_bum,
                            
                                    inv_nonppn.no_inv AS no_inv_nonppn,
                                    inv_ppn.no_inv AS no_inv_ppn, 
                                    inv_bum.no_inv AS no_inv_bum,
                            
                                    inv_nonppn.total_inv AS total_inv_nonppn,
                                    inv_ppn.total_inv AS total_inv_ppn, 
                                    inv_bum.total_inv AS total_inv_bum,
                            
                                    STR_TO_DATE(inv_nonppn.tgl_inv, '%d/%m/%Y') AS tgl_inv_nonppn,
                                    STR_TO_DATE(inv_ppn.tgl_inv, '%d/%m/%Y') AS tgl_inv_ppn,
                                    STR_TO_DATE(inv_bum.tgl_inv, '%d/%m/%Y') AS tgl_inv_bum,
                            
                                    STR_TO_DATE(inv_nonppn.tgl_tempo, '%d/%m/%Y') AS tgl_tempo_nonppn,
                                    STR_TO_DATE(inv_ppn.tgl_tempo, '%d/%m/%Y') AS tgl_tempo_ppn,
                                    STR_TO_DATE(inv_bum.tgl_tempo, '%d/%m/%Y') AS tgl_tempo_bum,
                            
                                    inv_nonppn.status_transaksi AS status_trx_nonppn,
                                    inv_ppn.status_transaksi AS status_trx_ppn,
                                    inv_bum.status_transaksi AS status_trx_bum,
                            
                                    spk_reg.id_inv AS id_inv_spk,
                                    spk_reg.id_customer,
                                    spk_reg.tgl_pesanan
                                FROM finance 
                                LEFT JOIN inv_nonppn ON finance.id_inv = inv_nonppn.id_inv_nonppn 
                                LEFT JOIN inv_ppn ON finance.id_inv = inv_ppn.id_inv_ppn 
                                LEFT JOIN inv_bum ON finance.id_inv = inv_bum.id_inv_bum
                                LEFT JOIN spk_reg ON finance.id_inv = spk_reg.id_inv
                            ) AS subquery
                            LEFT JOIN tb_customer ON subquery.id_customer = tb_customer.id_cs
                            LEFT JOIN finance_tagihan ON subquery.id_tagihan = finance_tagihan.id_tagihan
                            WHERE $sort_option";
                
                
                  if (isset($_GET['cs'])) {
                    $nama_cs = $_GET['cs'];
                    $nama_cs = array_map(function ($cs) {
                        return "'" . $cs . "'";
                    }, $nama_cs);
                    $nama_cs = implode(",", $nama_cs);
                    $sql .= "cs_inv_nonppn IN ($nama_cs) OR cs_inv_ppn IN ($nama_cs) OR cs_inv_bum IN ($nama_cs)"; 
                  }
                  $query = mysqli_query($connect, $sql) or die(mysqli_error($connect));
                  while ($data = mysqli_fetch_array($query)) {
                    $date_now = date('Y-m-d');
                  ?>
                      <tr>
                      <td class="text-center">
                        <input type="checkbox" name="inv_id[]" id="inv" value="<?php echo $data['id_inv'] ?>" data-customer="<?php echo $data['nama_cs'] ?>">
                      </td>
                          <td class="text-center text-nowrap"><?php echo $no ?></td>
                          <td class="text-nowrap text-center">
                              <?php
                              if (!empty($data['no_inv_nonppn'])) {
                                  echo $data['no_inv_nonppn'];
                              } elseif (!empty($data['no_inv_ppn'])) {
                                  echo $data['no_inv_ppn'];
                              } elseif (!empty($data['no_inv_bum'])) {
                                  echo $data['no_inv_bum'];
                              }
                              ?>
                          </td>
                          <td class="text-center text-nowrap"><?php echo strtoupper($data['jenis_inv'])?></td>
                          <td class="text-nowrap"><?php echo $data['nama_cs'] ?></td>
                          <td class="text-nowrap text-center">
                              <?php
                              if (!empty($data['tgl_inv_nonppn'])) {
                                  echo date('d/m/Y',strtotime($data['tgl_inv_nonppn']));
                              } elseif (!empty($data['tgl_inv_ppn'])) {
                                echo date('d/m/Y',strtotime($data['tgl_inv_ppn']));
                              } elseif (!empty($data['tgl_inv_bum'])) {
                                echo date('d/m/Y',strtotime($data['tgl_inv_bum']));
                              }
                              ?>
                          </td>
                          <td class="text-nowrap text-center">
                            <?php
                              if (!empty($data['tgl_tempo_nonppn'])) {
                                  echo date('d/m/Y',strtotime($data['tgl_tempo_nonppn']));
                              } elseif (!empty($data['tgl_tempo_ppn'])) {
                                echo date('d/m/Y',strtotime($data['tgl_tempo_ppn']));
                              } elseif (!empty($data['tgl_tempo_bum'])) {
                                echo date('d/m/Y',strtotime($data['tgl_tempo_bum']));
                              }
                            ?>
                          </td>
                          <td class="text-nowrap text-end">
                              <?php
                              if (!empty($data['total_inv_nonppn'])) {
                                  echo number_format($data['total_inv_nonppn']);
                              } elseif (!empty($data['total_inv_ppn'])) {
                                  echo number_format($data['total_inv_ppn']);
                              } elseif (!empty($data['total_inv_bum'])) {
                                  echo number_format($data['total_inv_bum']);
                              }
                              ?>
                          </td>
                          <td class="text-nowrap text-center">
                            <?php
                              if($data['status_pembayaran'] == 1){
                                echo "Sudah Bayar";
                              }else{
                                echo "Belum Bayar";
                              }
                            ?>
                          </td>    
                          <?php  
                            if (!empty($data['tgl_tempo_nonppn'])) {
                              $tgl_tempo_nonppn = $data['tgl_tempo_nonppn'];
                              $timestamp_tgl_tempo_nonppn = strtotime($tgl_tempo_nonppn);
                              $timestamp_now = strtotime($date_now);

                              // Hitung selisih timestamp
                              $selisih_timestamp = $timestamp_tgl_tempo_nonppn - $timestamp_now;

                              // Konversi selisih timestamp ke dalam hari
                              $selisih_hari = floor($selisih_timestamp / (60 * 60 * 24));

                              if ($tgl_tempo_nonppn > $date_now){
                                  echo '<td class="text-end text-nowrap bg-secondary text-white">'. "Tempo < " .$selisih_hari. " Hari".'</td>';
                              } else if ($tgl_tempo_nonppn < $date_now){
                                  echo '<td class="text-end text-nowrap bg-danger text-white">'. "Tempo > " . abs($selisih_hari). " Hari".'</td>';
                              }
                                  
                            } else if(!empty($data['tgl_tempo_ppn'])) {
                              // Konversi tanggal ke timestamp
                              $tgl_tempo_ppn = $data['tgl_tempo_ppn'];
                              $timestamp_tgl_tempo_ppn = strtotime($tgl_tempo_ppn);
                              $timestamp_now = strtotime($date_now);

                              // Hitung selisih timestamp
                              $selisih_timestamp = $timestamp_tgl_tempo_ppn - $timestamp_now;

                              // Konversi selisih timestamp ke dalam hari
                              $selisih_hari = floor($selisih_timestamp / (60 * 60 * 24));
                              if ($tgl_tempo_ppn > $date_now){
                                echo '<td class="text-end text-nowrap bg-secondary text-white">'. "Tempo < " .$selisih_hari. " Hari".'</td>';
                              }else if ($tgl_tempo_ppn < $date_now){
                                echo '<td class="text-end text-nowrap bg-danger text-white">'. "Tempo > " .abs($selisih_hari). " Hari".'</td>';
                              } else {
                                echo '<td class="text-end text-nowrap">Tidak Ada Tempo</td>';
                              }
                            } else if(!empty($data['tgl_tempo_bum'])) {
                              // Konversi tanggal ke timestamp
                              $tgl_tempo_bum = $data['tgl_tempo_bum'];
                              $timestamp_tgl_tempo_bum = strtotime($tgl_tempo_bum);
                              $timestamp_now = strtotime($date_now);

                              // Hitung selisih timestamp
                              $selisih_timestamp = $timestamp_tgl_tempo_bum - $timestamp_now;

                              // Konversi selisih timestamp ke dalam hari
                              $selisih_hari = floor($selisih_timestamp / (60 * 60 * 24));
                              if ($tgl_tempo_bum > $date_now){
                                echo '<td class="text-end text-nowrap bg-secondary text-white">'. "Tempo < " .$selisih_hari. " Hari".'</td>';
                              }else if ($tgl_tempo_bum < $date_now){
                                echo '<td class="text-end text-nowrap bg-danger text-white">'. "Tempo > " .abs($selisih_hari). " Hari".'</td>';
                              } else {
                                echo '<td class="text-end text-nowrap">Tidak Ada Tempo</td>';
                              }
                            } else {
                              echo '<td class="text-end text-nowrap">Tidak Ada Tempo</td>';
                            }
                          ?> 
                          <td class="text-center">
                            <?php
                              if ($data['id_tagihan'] == '') {
                                echo "Tagihan Belum Dibuat";
                              } else {
                                echo $data['no_tagihan'];
                              }
                            ?>
                          </td>
                          <td class="text-center text-nowrap">
                              <?php
                              if ($data['jenis_inv'] == 'nonppn') {
                                  echo '<a href="tampil-isi-list-inv-nonppn.php?id=' . base64_encode($data['id_inv']) . '" class="btn btn-primary btn-sm"><i class="bi bi-eye"></i> Lihat Data</a>';
                              } elseif ($data['jenis_inv'] == 'ppn') {
                                  echo '<a href="tampil-isi-list-inv-ppn.php?id=' . base64_encode($data['id_inv']) . '" class="btn btn-primary btn-sm"><i class="bi bi-eye"></i> Lihat Data</a>';
                              } elseif ($data['jenis_inv'] == 'bum') {
                                  echo '<a href="tampil-isi-list-inv-bum.php?id=' . base64_encode($data['id_inv']) . '" class="btn btn-primary btn-sm"><i class="bi bi-eye"></i> Lihat Data</a>';
                              }
                              ?>
                          </td>
                      </tr>
                  <?php $no++ ?>
                  <?php } ?>
                </tbody>
                <tr id="messageRow" style="display:none;">
                  <!-- <td colspan="10" class="text-center">Data Tidak Ditemukan</td> -->
                  <p id="total-count" style="display: none;">Jumlah data yang ditampilkan: 0</p>
                </tr>
              </table>
            </form>       

            <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
            <script>
                document.getElementById("export-button").addEventListener("click", function () {
                    // Ambil data dari tabel HTML
                    var data = [];
                    var table = document.getElementById('table2');
                    var rows = table.getElementsByTagName('tr');
                    for (var i = 0; i < rows.length; i++) {
                        var row = [], cols = rows[i].getElementsByTagName('td');
                        for (var j = 0; j < cols.length; j++) {
                            row.push(cols[j].innerText);
                        }
                        data.push(row);
                    }

                    // Membuat worksheet baru
                    var worksheet = XLSX.utils.aoa_to_sheet(data);

                    // Membuat workbook dan menambahkan worksheet ke dalamnya
                    var workbook = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(workbook, worksheet, 'Data');

                    // Mengkonversi workbook ke dalam bentuk blob
                    var excelBuffer = XLSX.write(workbook, { bookType: 'xlsx', type: 'array' });
                    var blob = new Blob([excelBuffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });

                    // Buat object URL untuk mengunduh file Excel
                    var url = URL.createObjectURL(blob);

                    // Buat elemen anchor untuk mengunduh file dan klik secara otomatis
                    var a = document.createElement("a");
                    a.href = url;
                    a.download = "data-invoice-nonppn.xlsx";
                    a.click();

                    // Hapus object URL untuk membersihkan sumber daya
                    window.URL.revokeObjectURL(url);
                });
            </script>
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
<!-- Modal -->
<div class="modal fade" id="modalCs" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger mt-2" id="errorNotification" style="display: none;"></div> <!-- Notifikasi kesalahan -->
          <form action="" method="GET">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="table3">
                    <thead>
                        <tr>
                            <th class="text-center col-1">Pilih</th>
                            <th class="text-center col-1">No</th>
                            <th class="text-center col-10">Nama Customer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  
                        include "koneksi.php";
                        $no = 1;
                        $sql_cs_nonppn = "SELECT subquery.*,
                                                  tb_customer.nama_cs,
                                                  tb_customer.alamat
                                          FROM (
                                              SELECT DISTINCT finance.*,
                                                      inv_nonppn.cs_inv AS cs_inv_nonppn,
                                                      inv_ppn.cs_inv AS cs_inv_ppn, 
                                                      inv_bum.cs_inv AS cs_inv_bum,
                                                      inv_nonppn.status_transaksi AS status_trx_nonppn,
                                                      inv_ppn.status_transaksi AS status_trx_ppn,
                                                      inv_bum.status_transaksi AS status_trx_bum,
                                                      spk_reg.id_inv AS id_inv_spk,
                                                      spk_reg.id_customer,
                                                      spk_reg.tgl_pesanan
                                              FROM finance 
                                              LEFT JOIN inv_nonppn ON finance.id_inv = inv_nonppn.id_inv_nonppn 
                                              LEFT JOIN inv_ppn ON finance.id_inv = inv_ppn.id_inv_ppn 
                                              LEFT JOIN inv_bum ON finance.id_inv = inv_bum.id_inv_bum
                                              LEFT JOIN spk_reg ON finance.id_inv = spk_reg.id_inv
                                          ) AS subquery
                                          LEFT JOIN tb_customer ON subquery.id_customer = tb_customer.id_cs
                                          GROUP BY tb_customer.nama_cs";
                        $query_cs_nonppn = mysqli_query($connect, $sql_cs_nonppn);
                        while($data_cs = mysqli_fetch_array($query_cs_nonppn)){
                        ?>
                        <tr>
                            <td class="text-center"><input type="checkbox" name="cs[]" id="checkboxCs" value="<?php echo $data_cs['nama_cs']; ?>"></td>
                            <td class="text-center"><?php echo $no; ?></td>
                            <td><?php echo $data_cs['nama_cs']; ?></td>
                        </tr>
                        <?php $no++ ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div> <!-- Tutup div modal-body -->
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Oke</button>
          </div>
          </form>
      </div>
    </div>
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('input[name="cs[]"]');
        const maxSelection = 3;
        const submitButton = document.querySelector('.modal-footer button[type="submit"]');
        const errorNotification = document.createElement('div');
        errorNotification.className = 'alert alert-danger mt-2';
        errorNotification.style.display = 'none';
        errorNotification.innerHTML = `Anda hanya dapat memilih ${maxSelection} customer.`;

        // Sisipkan notifikasi kesalahan ke dalam modal body
        const modalBody = document.querySelector('.modal-body');
        modalBody.appendChild(errorNotification);

        // Inisiasi status tombol "Oke" saat halaman dimuat
        submitButton.setAttribute('disabled', 'disabled');

        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const selectedCheckboxes = document.querySelectorAll('input[name="cs[]"]:checked');

                // Aktifkan tombol "Oke" jika minimal satu kotak centang dipilih
                if (selectedCheckboxes.length >= 1) {
                    submitButton.removeAttribute('disabled');
                    errorNotification.style.display = 'none'; // Sembunyikan notifikasi kesalahan jika ada
                } else {
                    submitButton.setAttribute('disabled', 'disabled');
                }

                // Nonaktifkan kotak centang yang tidak dipilih setelah 3 dipilih
                if (selectedCheckboxes.length > maxSelection) {
                    this.checked = false;
                    errorNotification.style.display = 'block'; // Tampilkan notifikasi kesalahan
                } else {
                    checkboxes.forEach(function(checkbox) {
                        checkbox.disabled = false;
                    });
                }
            });
        });
    });
</script>
<script>
    // Add event listener to each button with class "deleteButton"
    var buttons = document.querySelectorAll('.deleteButton');
    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            var dataToDelete = this.getAttribute('data-cs');
            console.log("Data yang akan dihapus:", dataToDelete);
            deleteData(dataToDelete);
        });
    });

    function deleteData(dataToDelete) {
        // Get the current URL parameters
        var urlParams = new URLSearchParams(window.location.search);

        // Remove the dataToDelete from the URL parameters
        var newCSParams = [];
        urlParams.getAll('cs[]').forEach(function(value) {
            if (value !== dataToDelete) {
                newCSParams.push(value);
            }
        });

        // Set the new 'cs' parameter in the URL
        urlParams.delete('cs[]');
        newCSParams.forEach(function(value) {
            urlParams.append('cs[]', value);
        });

        // Check if all customer buttons are deleted and update the URL accordingly
        if (newCSParams.length === 0) {
            urlParams.set('date_range', 'weekly');
        }

        // Get the current page URL without the query string
        var currentURL = window.location.href.split('?')[0];

        // Build the new URL with the updated query string
        var newURL = currentURL + (urlParams.toString() ? '?' + urlParams.toString() : '');

        // Update the URL without refreshing the page
        window.history.replaceState({}, document.title, newURL);

        // Reload the page
        window.location.reload();
    }
</script>

<script>
  function filterStatus() {
    const filterSelect = document.getElementById("filterSelect");
    const filterValue = filterSelect.value.toLowerCase().trim();

    const rows = document.querySelectorAll("#table2 tbody tr");
    let dataFound = false; // Gunakan variabel untuk mengecek apakah data sesuai dengan filter ditemukan

    for (const row of rows) {
      const statusPembayaranCell = row.getElementsByTagName("td")[7];
      if (statusPembayaranCell) {
        const statusPembayaran = statusPembayaranCell.innerText.toLowerCase().trim();

        if (filterValue === "all" || statusPembayaran === filterValue) {
          row.style.display = "table-row";
          dataFound = true; // Set dataFound menjadi true jika ada data yang sesuai dengan filter
        } else {
          row.style.display = "none";
        }
      }
    }

    // Tampilkan pesan "Data Tidak Ditemukan" jika tidak ada data yang sesuai dengan filter
    const messageRow = document.getElementById("messageRow");
    if (!dataFound) {
      messageRow.style.display = "table-row";
    } else {
      messageRow.style.display = "none";
    }
  }

  // Panggil fungsi filterStatus() saat halaman dimuat dan atur opsi select ke "all" secara default.
  filterStatus();
  document.getElementById("filterSelect").value = "all";

  // Tambahkan event listener untuk elemen select
  document.getElementById("filterSelect").addEventListener("change", filterStatus);
</script>

<script>
  function filterInv() {
    const filterSelect = document.getElementById("filterSelectInv");
    const filterValue = filterSelect.value.toLowerCase().trim();
  
    const rows = document.querySelectorAll("#table2 tbody tr");
    let dataFound = false; // Gunakan variabel untuk mengecek apakah data sesuai dengan filter ditemukan

    for (const row of rows) {
      const statusInvCell = row.getElementsByTagName("td")[2];
      if (statusInvCell) {
        const statusInv = statusInvCell.innerText.toLowerCase().trim();

        if (filterValue === "all" || statusInv === filterValue) {
          row.style.display = "table-row";
          dataFound = true; // Set dataFound menjadi true jika ada data yang sesuai dengan filter
        } else {
          row.style.display = "none";
        }
      }
    }

    // Tampilkan pesan "Data Tidak Ditemukan" jika tidak ada data yang sesuai dengan filter
    const messageRow = document.getElementById("messageRow");
    if (!dataFound) {
      messageRow.style.display = "table-row";
    } else {
      messageRow.style.display = "none";
    }
  }

  // Panggil fungsi filterStatus() saat halaman dimuat dan atur opsi select ke "all" secara default.
  filterInv();
  document.getElementById("filterSelectInv").value = "all";

  // Tambahkan event listener untuk elemen select
  document.getElementById("filterSelectInv").addEventListener("change", filterInv);
</script>



<script>
  function submitForm(action) {
      document.getElementById("invoiceForm").action = action;
      document.getElementById("invoiceForm").submit();
  }
</script>


<!-- HTML: Letakkan kode script di dalam elemen <script> -->
<script>
  // Mendapatkan URL dari halaman web saat ini
  const url = new URL(window.location.href);
  console.log(url);
</script>

<!-- Checkbox saat buat Bill -->
<script>
  const form = document.getElementById("invoiceForm");
  const checkboxes = document.querySelectorAll('input[type="checkbox"][id^="inv"]');
  const createBill = document.getElementById("createBill");

  form.addEventListener("submit", function(event) {
      event.preventDefault();

      // Jika Inv yang dipilih sesuai dengan pelanggan yang dipilih, lanjutkan proses invoice
      if (selectedInv) {
          console.log("Data Pelanggan:");
          console.log("Nama Customer:", selectedCustomer);
          console.log("Invoice yang Dipilih:");
          checkboxes.forEach(function(checkbox) {
              if (checkbox.checked && checkbox.getAttribute("data-customer") === selectedCustomer) {
                  console.log("ID Inv:", checkbox.value);
              }
          });
          // Lakukan tindakan selanjutnya, seperti mengirim data ke server atau melakukan tindakan lainnya
      }
  });

  function updateButtonState() {
      let selectedCustomer = null;
      let checkedCustomers = new Set(); // Menyimpan nama pelanggan yang dipilih

      checkboxes.forEach(function(checkbox) {
          if (checkbox.checked) {
              checkedCustomers.add(checkbox.getAttribute(
                  "data-customer")); // Tambahkan nama pelanggan yang dipilih ke dalam Set
          }
      });

      if (checkedCustomers.size <= 5) { // Cek apakah jumlah data yang dicentang tidak melebihi 5
          if (checkedCustomers.size === 1) {
              selectedCustomer = checkedCustomers.values().next().value; // Ambil nama pelanggan dari Set

              createBill.disabled = false;
          } else {
              createBill.disabled = true;
          }
      } else {
          // Jika jumlah data yang dicentang melebihi 5, nonaktifkan tombol dan tampilkan peringatan
          createBill.disabled = true;

          Swal.fire({
              title: '<strong>HTML <u>example</u></strong>',
              icon: 'info',
              html: 'You can use <b>bold text</b>, ' +
                  '<a href="//sweetalert2.github.io">links</a> ' +
                  'and other HTML tags',
              showCloseButton: true,
              showCancelButton: true,
              focusConfirm: false,
              confirmButtonText: '<i class="fa fa-thumbs-up"></i> Great!',
              confirmButtonAriaLabel: 'Thumbs up, great!',
              cancelButtonText: '<i class="fa fa-thumbs-down"></i>',
              cancelButtonAriaLabel: 'Thumbs down'
          })
      }
  }

  checkboxes.forEach(function(checkbox) {
      checkbox.addEventListener("change", function(event) {
          updateButtonState();

          // Membatasi pemilihan data hingga maksimal 5
          let checkedCount = 0;
          checkboxes.forEach(function(checkbox) {
              if (checkbox.checked) {
                  checkedCount++;
                  if (checkedCount > 5) {
                      checkbox.checked = false;
                      Swal.fire({
                          title: '<strong>Batas Maksimum Pemilihan</strong>',
                          icon: 'info',
                          html: 'Anda hanya dapat memilih maksimal 5 data.',
                          confirmButtonText: 'OK'
                      })
                  }
              }
          });

          updateButtonState();
      });
  });




  function checkInitialCheckbox() {
      checkboxes.forEach(function(checkbox) {
          if (checkbox.getAttribute("data-customer") === "agung") {
              checkbox.checked = true;
          }
      });
      updateButtonState();
  }

  checkboxes.forEach(function(checkbox) {
      checkbox.addEventListener("change", updateButtonState);
  });

  checkInitialCheckbox();
</script>
<!-- End Checkbox Create Bill -->






