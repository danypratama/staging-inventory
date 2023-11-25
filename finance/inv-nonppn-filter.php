<?php
$page = 'finance';
$page2  = 'finance-nonppn';
include 'akses.php';
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
          <div class="row">
            <div class="col-md-2 mb-3">
              <button class="btn btn-secondary btn-md" id="export-button">Export Excel <i class="bi bi-file-earmark-excel"></i></button>
            </div>
          </div>
            <div class="row align-items-center">
              <div class="col-md-2 mb-3 mt-2" id="cs">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCs">
                  Filter By Customer
                </button>
              </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="start_date">Start Date:</label>
                    <input type="text" id="startDate" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="end_date">End Date:</label>
                    <input type="text" id="endDate" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                  <label>Filter By Status</label>
                  <select class="form-select" id="filterSelect" onchange="filterStatus()">
                      <option value="all">Semua</option>
                      <option value="Belum Bayar">Belum Bayar</option>
                      <option value="Sudah Bayar">Sudah Bayar</option>
                  </select>
                </div>
            </div>  
            <div class="row">
              <div class="col-md-5 mb-3" id="cs">
                  <?php
                  // Periksa apakah kunci 'cs' ada dalam array $_GET
                  if (isset($_GET['cs'])) {
                      $nama_cs = $_GET['cs'];

                      // Periksa apakah array kosong atau tidak
                      if (!empty($nama_cs)) {
                          // Loop untuk mendapatkan setiap nilai yang dipilih
                          foreach ($nama_cs as $cs) {
                              // Lakukan apa yang ingin Anda lakukan dengan nilai $cs, misalnya mencetaknya
                              echo '<button class="btn btn-outline-primary btn-md p-2 me-2" id="deleteButton" data-cs="'. $cs .'">' . $cs . ' <span class="badge text-bg-light">X</span></button>';
                          }
                      } else {
                          // Jika array kosong, tampilkan pesan atau tindakan khusus
                          echo 'Tidak ada customer yang dipilih.';
                      }
                    }
                  ?>
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
                      <!-- <td class="text-center p-3">Pilih</td> -->
                      <td class="text-center p-3">No</td>
                      <td class="text-center p-3">No. Invoice</td>
                      <td class="text-center p-3">Jenis Inv</td>
                      <td class="text-center p-3">Customer</td>
                      <td class="text-center p-3">Tgl. Invoice</td>
                      <td class="text-center p-3">Tgl. Tempo</td>
                      <td class="text-center p-3">Total Tagihan</td>
                      <td class="text-center p-3">Status Pembayaran</td>
                      <td class="text-center p-3">Status Tempo</td>
                      <td class="text-center p-3">Aksi</td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php  
                      include "koneksi.php";
                      $no = 1;
                      $sort_option ="";
                      $sql = "SELECT subquery.*,
                                          tb_customer.nama_cs,
                                          tb_customer.alamat
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
                                  LEFT JOIN tb_customer ON subquery.id_customer = tb_customer.id_cs WHERE $sort_option";
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
                                  echo $data['tgl_inv_nonppn'];
                                } elseif (!empty($data['tgl_inv_ppn'])) {
                                  echo $data['tgl_inv_ppn'];
                                } elseif (!empty($data['tgl_inv_bum'])) {
                                  echo $data['tgl_inv_bum'];
                                }
                              ?>
                            </td>
                            <td class="text-nowrap text-center">
                                <?php
                                if (!empty($data['tgl_tempo_nonppn'])) {
                                  echo $data['tgl_tempo_nonppn'];
                                } elseif (!empty($data['tgl_tempo_ppn'])) {
                                  echo $data['tgl_tempo_ppn'];
                                } elseif (!empty($data['tgl_tempo_bum'])) {
                                  echo $data['tgl_tempo_bum'];
                                } else {
                                  echo "Tidak Ada Tempo";
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
                    <td colspan="8" class="text-center">Data Tidak Ditemukan</td>
                    <p id="total-count" style="display: none;">Jumlah data yang ditampilkan: 0</p>
                  </tr>
                </table>
                <script>
                  // Kode JavaScript
                  function filterTable() {
                    const startDate = new Date(document.getElementById("startDate").value);
                    const endDate = new Date(document.getElementById("endDate").value);

                    const table = document.getElementById("table2");
                    const tbodyRows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");

                    for (let i = 0; i < tbodyRows.length; i++) {
                      const row = tbodyRows[i];
                      const tglInvoiceCell = row.cells[4]; // Sel Tgl. Invoice berada pada kolom ke-5 (indeks 4)

                      if (tglInvoiceCell) {
                        const tglInvoice = new Date(tglInvoiceCell.innerText);
                        if (tglInvoice >= startDate && tglInvoice <= endDate) {
                          row.style.display = ""; // Tampilkan baris jika tanggal sesuai dengan rentang
                        } else {
                          row.style.display = "none"; // Sembunyikan baris jika tanggal tidak sesuai dengan rentang
                        }
                      }
                    }
                  }

                  // Tambahkan event listener pada elemen endDate
                  document.getElementById("endDate").addEventListener("change", filterTable);

                  // Inisialisasi Flatpickr pada elemen startDate dan endDate
                  flatpickr("#startDate", {
                    dateFormat: "Y/m/d",
                    onChange: filterTable // Panggil fungsi filterTable setiap kali tanggal diubah
                  });

                  flatpickr("#endDate", {
                    dateFormat: "Y/m/d",
                    onChange: filterTable // Panggil fungsi filterTable setiap kali tanggal diubah
                  });
                </script>
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
                  $sql_cs_nonppn = "SELECT DISTINCT cs_inv FROM inv_nonppn";
                  $query_cs_nonppn = mysqli_query($connect, $sql_cs_nonppn);
                  while($data_cs = mysqli_fetch_array($query_cs_nonppn)){
                ?>
                <tr>
                  <td class="text-center"><input type="checkbox" name="cs[]" id="checkboxCs" value="<?php echo $data_cs['cs_inv']; ?>"></td>
                  <td class="text-center"><?php echo $no; ?></td>
                  <td><?php echo $data_cs['cs_inv']; ?></td>
                </tr>
                <?php $no++ ?>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Oke</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- <script>
  function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
  }

  document.addEventListener("DOMContentLoaded", function() {
    var startDateInput = document.getElementById("start-date");
    var endDateInput = document.getElementById("end-date");

    startDateInput.addEventListener("change", function() {
      var startDate = new Date(startDateInput.value);
      var endDate = new Date(endDateInput.value);

      // Block dates before "start-date" on "end-date" calendar
      endDateInput.min = formatDate(startDate);

      // Set max end date to 30 days from the selected start date
      var maxEndDate = new Date(startDate.getTime());
      maxEndDate.setDate(maxEndDate.getDate() + 30);
      
      endDateInput.max = formatDate(maxEndDate);

      // Display only dates in the same month as the selected "start-date"
      var startMonth = startDate.getMonth() + 1;
      var startYear = startDate.getFullYear();
      if (endDateInput.value === "" || endDateInput.value.length < 8) {
        endDateInput.value = formatDate(new Date(startYear, startMonth - 1, 1));
      }
    });

    endDateInput.addEventListener("change", function() {
      var startDate = new Date(startDateInput.value);
      var endDate = new Date(endDateInput.value);

      // Limit end date to 30 days from the selected start date
      var maxEndDate = new Date(startDate.getTime());
      maxEndDate.setDate(maxEndDate.getDate() + 30);

      if (endDate > maxEndDate) {
        endDateInput.value = formatDate(maxEndDate);
      } else if (endDate < startDate) {
        endDateInput.value = formatDate(startDate);
      }

      // Update URL with selected dates
      const startDateStr = formatDate(startDate);
      const endDateStr = formatDate(endDate);
      const url = 'inv-nonppn.php?start_date=' + startDateStr + '&end_date=' + endDateStr + '&date_range=pilihTanggal';
      window.location.href = url;
    });
  });
</script> -->

<script>
    // Add event listener to each button with class "deleteButton"
    var buttons = document.querySelectorAll('#deleteButton');
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
        urlParams.delete('cs[]', dataToDelete);

        // Get the updated query string
        var newQueryString = urlParams.toString();

        // Get the current page URL without the query string
        var currentURL = window.location.href.split('?')[0];

        // Build the new URL with the updated query string
        var newURL = currentURL + (newQueryString ? '?' + newQueryString : '');

        // Update the URL without refreshing the page
        window.history.replaceState({}, document.title, newURL);

        // Reload the page
        window.location.reload();
    }
</script>

<!-- <script>
    // Inisialisasi Flatpickr pada input tanggal
    const startDateInput = flatpickr("#start-date", {
      dateFormat: "Y/m/d",
      onChange: function (selectedDates, dateStr, instance) {
        const endDateInput = document.getElementById("end-date");
        const maxAllowedDate = new Date(selectedDates[0].getTime() + 30 * 86400000); // Tambahkan 30 hari ke tanggal awal
        endDateInput._flatpickr.setDate(null); // Reset tanggal pada input endDate
        endDateInput._flatpickr.set("minDate", selectedDates[0]); // Set tanggal minimum pada input endDate
        endDateInput._flatpickr.set("maxDate", maxAllowedDate); // Set tanggal maksimum pada input endDate

        // Panggil fungsi filterData untuk menampilkan data yang sesuai dengan rentang tanggal yang dipilih
        filterData();
      },
    });

    const endDateInput = flatpickr("#end-date", {
      dateFormat: "Y/m/d",
      minDate: "today", // Tanggal minimum yang dapat dipilih adalah hari ini
      onChange: filterData, // Panggil fungsi filterData setiap kali input berubah
    });

    function filterData() {
    const startDate = startDateInput.selectedDates[0];
    let endDate = endDateInput.selectedDates[0];

    // Mengubah tanggal akhir menjadi akhir hari tanggal terpilih
    if (endDate) {
      endDate = new Date(endDate.getTime() + 86400000 - 1); // Tambahkan 1 hari dan kurangi 1 milidetik
    }

    const maxAllowedDate = new Date(startDate.getTime() + 31 * 86400000); // Tambahkan 30 hari ke tanggal awal

    if (endDate > maxAllowedDate) {
      endDate = maxAllowedDate;
      endDateInput._flatpickr.setDate(endDate); // Perbarui tampilan tanggal pada input endDate
    }

    const table = document.getElementById("table2");
    const rows = table.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) {
      const row = rows[i];

      // Periksa apakah baris memiliki sel di indeks ke-5 (kolom keenam) sebelum mencoba mengaksesnya
      if (row.cells.length >= 6) {
        const dateStr = row.cells[4].textContent;
        const date = new Date(dateStr);

        // Periksa apakah tanggal berada dalam rentang filter
        if (startDate && endDate && date >= startDate && date <= endDate) {
          row.style.display = ""; // Menampilkan baris jika tanggal berada dalam rentang filter
        } else {
          row.style.display = "none"; // Menyembunyikan baris jika tanggal tidak berada dalam rentang filter
        }
      }
    }
  }
</script> -->

<!-- Tambahkan tag script ini di akhir bagian body -->
<!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        const startDateInput = document.getElementById('start-date');
        const endDateInput = document.getElementById('end-date');

        startDateInput.addEventListener('change', handleDateFilter);
        endDateInput.addEventListener('change', handleDateFilter);
    });

    function handleDateFilter() {
        const startDate = document.getElementById('start-date').value;
        const endDate = document.getElementById('end-date').value;

        const tableRows = document.querySelectorAll('#table2 tbody tr');

        // Menampilkan jumlah baris pada tabel di konsol log
        console.log("Jumlah Baris Sebelum Filter: " + tableRows.length);

        for (const row of tableRows) {
            const invoiceDateCell = row.querySelector('td:nth-child(5)'); // Sesuaikan indeks kolom berdasarkan posisinya
            if (invoiceDateCell) {
                const invoiceDate = invoiceDateCell.textContent.trim();

                if (invoiceDate !== '') {
                    if (startDate <= invoiceDate && endDate >= invoiceDate) {
                        row.style.display = ''; // Tampilkan baris
                    } else {
                        row.style.display = 'none'; // Sembunyikan baris
                    }
                }
            }
        }

        // Menampilkan jumlah baris setelah filter tanggal di konsol log
        const visibleRows = document.querySelectorAll('#table2 tbody tr:not([style*="display: none"])');
        console.log("Jumlah Baris Setelah Filter: " + visibleRows.length);
    }
</script> -->

<script>
  function filterStatus() {
    const filterSelect = document.getElementById("filterSelect");
    const filterValue = filterSelect.value.toLowerCase().trim();
    console.log("Filter Value:", filterValue);

    const rows = document.querySelectorAll("#table2 tbody tr");
    let dataFound = false; // Gunakan variabel untuk mengecek apakah data sesuai dengan filter ditemukan

    for (const row of rows) {
      const statusPembayaranCell = row.getElementsByTagName("td")[7];
      if (statusPembayaranCell) {
        const statusPembayaran = statusPembayaranCell.innerText.toLowerCase().trim();
        console.log("Status Pembayaran:", statusPembayaran);

        if (filterValue === "all" || statusPembayaran === filterValue) {
          row.style.display = "table-row";
          dataFound = true; // Set dataFound menjadi true jika ada data yang sesuai dengan filter
        } else {
          row.style.display = "none";
        }
      }
    }

    // Tampilkan pesan "Data Tidak Ditemukan" jika tidak ada data yang sesuai dengan filter
    // const messageRow = document.getElementById("messageRow");
    // if (!dataFound) {
    //   messageRow.style.display = "table-row";
    // } else {
    //   messageRow.style.display = "none";
    // }
  }

  // Panggil fungsi filterStatus() saat halaman dimuat dan atur opsi select ke "all" secara default.
  filterStatus();
  document.getElementById("filterSelect").value = "all";

  // Tambahkan event listener untuk elemen select
  document.getElementById("filterSelect").addEventListener("change", filterStatus);
</script>

<!-- <script>
    // Inisialisasi Flatpickr pada input tanggal
    const startDateInput = flatpickr("#start-date", {
        dateFormat: "d/m/Y", // Format tanggal Flatpickr menjadi "d/m/Y"
        onChange: filterData, // Panggil fungsi filterData setiap kali input berubah
    });

    const endDateInput = flatpickr("#end-date", {
        dateFormat: "d/m/Y", // Format tanggal Flatpickr menjadi "d/m/Y"
        onChange: filterData, // Panggil fungsi filterData setiap kali input berubah
    });

    function filterData() {
        const startDateString = startDateInput.input.value; // Ambil tanggal dari input Flatpickr
        const endDateString = endDateInput.input.value; // Ambil tanggal dari input Flatpickr
        const startDate = new Date(startDateString); // Konversi string tanggal ke objek Date
        const endDate = new Date(endDateString); // Konversi string tanggal ke objek Date

        const table = document.getElementById("table2");
        const rows = table.getElementsByTagName("tr");
        let totalCount = 0; // Variabel untuk menyimpan jumlah data yang ditampilkan

        // Setel gaya tampilan semua baris menjadi tampil sebelum menerapkan filter
        for (let i = 1; i < rows.length; i++) {
            rows[i].style.display = "";
        }

        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const dateString = row.cells[4].textContent;
            const date = new Date(dateString); // Konversi string tanggal di dalam tabel ke objek Date

            if (date >= startDate && date <= endDate) {
                row.style.display = "";
                totalCount++; // Tambahkan 1 ke jumlah data yang ditampilkan jika baris ditampilkan
            } else {
                row.style.display = "none";
            }
        }

        // Tampilkan jumlah data yang ditampilkan di luar tabel atau di bagian yang diinginkan.
        const totalCountElement = document.getElementById("total-count");
        totalCountElement.textContent = "Jumlah data yang ditampilkan: " + totalCount;

        // Tampilkan jumlah data yang ditampilkan di console log.
        console.log("Jumlah data yang ditampilkan: " + totalCount);

        // Cek apakah jumlah data yang ditampilkan adalah 0
        const messageRow = document.getElementById("messageRow");
        if (totalCount === 0) {
            // Jika jumlah data adalah 0, tampilkan pesan "Data Tidak Ditemukan"
            messageRow.style.display = "";
        } else {
            // Jika jumlah data bukan 0, sembunyikan pesan "Data Tidak Ditemukan"
            messageRow.style.display = "none";
        }
    }
</script> -->


<!-- <script>
  function submitForm(action) {
      document.getElementById("invoiceForm").action = action;
      document.getElementById("invoiceForm").submit();
  }
</script> -->






