<?php
$page = 'finance';
$page2  = 'finance-ppn';
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
      <section >
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
            <div class="col-md-2 mb-3" id="cs">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCs">
                Filter By Customer
              </button>
            </div>
            <div class="col-md-5 mb-3">
              <div class="row">
                <div class="col-md-4 mb-3">
                  <label for="start_date">Start Date:</label>
                  <input type="text" id="start-date" class="form-control form-control-md" placeholder="dd/mm/yyyy" name="start_date" onchange="filterData()">
                </div>
                <div class="col-md-4 mb-3">
                  <label for="end_date">End Date:</label>
                  <input type="text" id="end-date" class="form-control form-control-md" placeholder="dd/mm/yyyy" name="end_date" onchange="filterData()">
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
            </div>
            <div class="row">
              <div class="md-3 mb-3">
               
              </div>
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
            <table id="table2" class="table table-striped nowrap" style="width:100%">
              <thead>
                <tr class="text-white" style="background-color: navy;">
                  <td class="text-center p-3">No</td>
                  <td class="text-center p-3">No. Invoice</td>
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
                  $month = date('m');
                  $nama_cs = isset($_GET['cs']) ? $_GET['cs'] : array();
                  $sql_inv = "SELECT  ppn.id_inv_ppn,
                                      ppn.no_inv,
                                      STR_TO_DATE(ppn.tgl_inv, '%d/%m/%Y') AS tgl_inv,
                                      ppn.cs_inv,
                                      STR_TO_DATE(ppn.tgl_tempo, '%d/%m/%Y') AS tgl_tempo,
                                      ppn.kategori_inv,
                                      ppn.total_inv,
                                      ppn.status_transaksi,
                                      fnc.id_inv,
                                      fnc.status_pembayaran,
                                      fnc.status_lunas
                              FROM inv_ppn AS ppn
                              JOIN finance fnc ON (ppn.id_inv_ppn = fnc.id_inv)";
                  // Check if the end_date is provided
                 if (isset($_GET['cs'])) {
                    $nama_cs = $_GET['cs'];
                    $nama_cs = array_map(function ($cs) {
                        return "'" . $cs . "'";
                    }, $nama_cs);
                    $nama_cs = implode(",", $nama_cs);
                    $sql_inv .= " WHERE ppn.cs_inv IN ($nama_cs)";
                  }
                
                  $sql_inv .= "ORDER BY tgl_inv ASC";
                  $query_inv = mysqli_query($connect, $sql_inv);
                  while($data = mysqli_fetch_array($query_inv)) {
                    $status_pembayaran = $data['status_pembayaran'];
                    $tgl_tempo = $data['tgl_tempo'];
                    $date_now = date('Y-m-d');

                    // Konversi tanggal ke timestamp
                    $timestamp_tgl_tempo = strtotime($tgl_tempo);
                    $timestamp_now = strtotime($date_now);

                    // Hitung selisih timestamp
                    $selisih_timestamp = $timestamp_tgl_tempo - $timestamp_now;

                    // Konversi selisih timestamp ke dalam hari
                    $selisih_hari = floor($selisih_timestamp / (60 * 60 * 24));
                  ?>
                <tr data-status="<?php echo $data['status_pembayaran'] ?>">
                  <td class="text-center"><?php echo $no; ?></td>
                  <td class="text-nowrap text-center"><?php echo $data['no_inv'] ?></td>
                  <td class="text-nowrap"><?php echo $data['cs_inv'] ?></td>
                  <td class="text-nowrap text-center"><?php echo date('d/m/Y', strtotime($data['tgl_inv'])); ?></td>
                  <td class="text-center text-nowrap">
                    <?php 
                      if ($tgl_tempo != 0){
                        echo date('d/m/Y',strtotime($tgl_tempo));
                      }else{
                        echo "Tidak ada tempo";
                      }
                    ?>
                  </td>
                  <td class="text-end text-nowrap"><?php echo number_format($data['total_inv'])?></td>
                  <td class="text-center">
                    <?php  
                      if($status_pembayaran == 0){
                        echo 'Belum Bayar';
                      } else {
                        echo 'Sudah Bayar';
                      }
                    ?>
                  </td>
                  <?php 
                      if ($tgl_tempo != 0 && $tgl_tempo > $date_now){
                        echo '<td class="text-end text-nowrap bg-secondary text-white">'. "Tempo < " .$selisih_hari. " Hari".'</td>';
                      }else if ($tgl_tempo != 0 && $tgl_tempo < $date_now){
                        echo '<td class="text-end text-nowrap bg-danger text-white">'. "Tempo > " .abs($selisih_hari). " Hari".'</td>';
                      }else{
                        echo '<td class="text-end text-nowrap">Tidak Ada Tempo</td>';
                      }
                  ?>
                  <td class="text-center">
                    <a href="detail-fnc-ppn.php?id=<?php echo base64_encode($data['id_inv_ppn']) ?>" class="btn btn-primary btn-sm"><i class="bi bi-eye"></i> Lihat Data</a>
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
            <div id="data-container">
                <!-- Hasil data akan ditampilkan di sini -->
            </div>

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
                    a.download = "data-invoice-ppn.xlsx";
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
                  $sql_cs_ppn = "SELECT DISTINCT cs_inv FROM inv_ppn";
                  $query_cs_ppn = mysqli_query($connect, $sql_cs_ppn);
                  while($data_cs = mysqli_fetch_array($query_cs_ppn)){
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

<!-- Filter date range -->
<script>
    // Ambil tanggal saat ini untuk digunakan sebagai tanggal awal dan akhir batas
    const today = new Date();
    const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
    const lastDayOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);
   
    // Inisialisasi Flatpickr pada input tanggal
    const startDateInput = flatpickr("#start-date", {
        dateFormat: "d/m/Y", // Format tanggal Flatpickr menjadi "d/m/Y"
        minDate: firstDayOfMonth,
        maxDate: lastDayOfMonth,
        onChange: filterData, // Panggil fungsi filterData setiap kali input berubah
    });

    const endDateInput = flatpickr("#end-date", {
        dateFormat: "d/m/Y", // Format tanggal Flatpickr menjadi "d/m/Y"
        minDate: firstDayOfMonth,
        maxDate: lastDayOfMonth,
        onChange: filterData, // Panggil fungsi filterData setiap kali input berubah
    });

    function filterData() { 
        const startDateString = startDateInput.input.value; // Ambil tanggal dari input Flatpickr
        const endDateString = endDateInput.input.value; // Ambil tanggal dari input Flatpickr
        const startDate = flatpickr.parseDate(startDateString, "d/m/Y"); // Parse tanggal sesuai format Flatpickr
        const endDate = flatpickr.parseDate(endDateString, "d/m/Y"); // Parse tanggal sesuai format Flatpickr

        const table = document.getElementById("table2");
        const rows = table.getElementsByTagName("tr");
        let totalCount = 0; // Variabel untuk menyimpan jumlah data yang ditampilkan

        // Setel gaya tampilan semua baris menjadi tampil sebelum menerapkan filter
        for (let i = 1; i < rows.length; i++) {
            rows[i].style.display = "";
        }

        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const dateString = row.cells[3].textContent;
            const date = flatpickr.parseDate(dateString, "d/m/Y");

            if (date >= startDate && date <= endDate) {
                row.style.display = "";
                totalCount++; // Tambahkan 1 ke jumlah data yang ditampilkan jika baris ditampilkan
            } else {
                row.style.display = "none";
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
    }
</script>
<!-- Filter Customer -->

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

<script>
  function filterStatus() {
    const filterSelect = document.getElementById("filterSelect");
    const filterValue = filterSelect.value.toLowerCase().trim();
    console.log("Filter Value:", filterValue);

    const rows = document.querySelectorAll("#table2 tbody tr");
    let dataFound = false; // Gunakan variabel untuk mengecek apakah data sesuai dengan filter ditemukan

    for (const row of rows) {
      const statusPembayaranCell = row.getElementsByTagName("td")[6];
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