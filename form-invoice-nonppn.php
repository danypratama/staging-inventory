<?php
$page = 'index';
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
     <!-- SWEET ALERT -->
     <div class="info-data" data-infodata="<?php if (isset($_SESSION['info'])) {
                                              echo $_SESSION['info'];
                                            }
                                            unset($_SESSION['info']); ?>"></div>
      <!-- END SWEET ALERT -->
    <div class="container-fluid">
      <!-- Form simpan ke table invoice -->
      <div class="card">
        <div class="card-header text-center">
          <h5>Form Invoice Nonppn</h5>
        </div>
        <div class="card-body">
          <form action="proses/proses-invoice-nonppn.php" method="POST" id="myForm">
            <?php
            // Mendapatkan data dari form sebelumnya

              if (isset($_POST['spk_id'])) {
                $selectedSpkIds = $_POST['spk_id'];

                // Lakukan sesuatu dengan data yang dipilih
                // Misalnya, tampilkan daftar ID SPK yang dipilih
                foreach ($selectedSpkIds as $spkId) {
                  echo '<input type="hidden" name="id_spk[]" value="' . $spkId . '">';
                  $sql = mysqli_query($connect, " SELECT sr.id_customer, sr.no_po, cs.nama_cs, cs.alamat
                                                  FROM spk_reg AS sr
                                                  JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                                  WHERE id_spk_reg = '$spkId' ");
                  $data_spk = mysqli_fetch_array($sql);
                }
              }
            ?>

            <!-- Kode untuk membuat no invoice -->
            <?php
              // UUID
              $uuid = generate_uuid();
              $year = date('y');
              $day = date('d');
              $month = date('m');

              include "koneksi.php";
              $thn  = date('Y');
              $sql  = mysqli_query($connect, "SELECT max(no_inv) as maxID, STR_TO_DATE(tgl_inv, '%d/%m/%Y') AS tgl FROM inv_nonppn WHERE YEAR(STR_TO_DATE(tgl_inv, '%d/%m/%Y')) = '$thn' ORDER BY no_inv ASC");
              $data = mysqli_fetch_array($sql);

              $array_bln = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
              $kode = $data['maxID'];
              $ket1 = "/KM/";
              $bln = $array_bln[date('n')];
              $ket2 = "/";
              $ket3 = date("Y");
              $urutkan = (int)substr($kode, 0, 3);
              $urutkan++;
              $no_inv = sprintf("%03s", $urutkan) . $ket1 . $bln . $ket2 . $ket3;
            ?>
            <div class="card-body">
              <div class="row mt-3">
                <div class="col-sm-6">
                  <div class="card-body">
                    <input type="hidden" name="id_inv_nonppn" value="NONPPN-<?php echo $year ?><?php echo $month ?><?php echo $uuid ?><?php echo $day ?>">
                    <div class="mt-3">
                      <label><strong>No Invoice Nonppn</strong></label>
                      <input type="text" class="form-control" name="no_inv_nonppn" value="<?php echo $no_inv ?>" required>
                    </div>
                    <div class="mt-3">
                      <label><strong>Tanggal Invoice</strong></label>
                      <input type="text" id="date" class="form-control" name="tgl_inv">
                    </div>
                    <div class="mt-3">
                        <label><strong>Tanggal Tempo</strong></label>
                        <div class="input-group flex-nowrap">
                            <input type="text" id="tempo" class="form-control" name="tgl_tempo">
                            <span class="input-group-text" id="clear-search"><i class="bi bi-x-circle"></i></span>
                        </div>
                    </div>
                    <div class="mt-3">
                      <label><strong>No. PO</strong></label>
                      <input type="text" class="form-control" name="no_po" value="<?php echo $data_spk['no_po']; ?>">
                    </div>
                    <div class="mt-3">
                      <label><strong>Jenis Invoice</strong></label>
                      <select name="jenis_inv" id="select" class="form-select" onchange="enabled()">
                        <option value="Reguler">Reguler</option>
                        <option value="Diskon">Diskon</option>
                        <option value="Spesial Diskon">Spesial Diskon</option>
                      </select>
                    </div>
                    <div class="mt-3">
                      <label><strong>Spesial Diskon</strong></label>
                      <input type="text" id="sp_disc" name="sp_disc" value="0" class="form-control bg-light" readonly>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="card-body">
                    <div class="mt-3">
                      <label><strong>Pelanggan</strong></label>
                      <input type="text" class="form-control bg-light" name="cs" value="<?php echo $data_spk['nama_cs']; ?>" required>
                    </div>
                    <div class="mt-3">
                      <label><strong>Pelanggan Invoice</strong></label>
                      <input type="text" class="form-control" name="cs_inv" value="<?php echo $data_spk['nama_cs']; ?>" required>
                    </div>
                    <div class="mt-3">
                      <label><strong>Tambahan Invoice</strong></label><br>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="kwitansi" value="1">
                        <label class="form-check-label" for="inlineCheckbox1">Kwitansi</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="surat_jalan" value="1">
                        <label class="form-check-label" for="inlineCheckbox2">Surat Jalan</label>
                      </div>
                    </div>
                    <input type="hidden" class="form-control harga_produk" value="0" name="ongkir">
                    <div class="mt-3">
                      <label><strong>Note Invoice</strong></label>
                      <textarea type="text" class="form-control" style="height: 150px;" name="note_inv"></textarea>
                    </div>
                    <input type="hidden" name="id_user" value="<?php echo $_SESSION['tiket_id'] ?>">
                  </div>
                </div>
                <div class="text-center mt-2">
                  <button type="submit" class="btn btn-primary btn-md" name="simpan-inv">Simpan Data</button>
                  <a href="spk-siap-kirim.php?sort=baru" class="btn btn-secondary">Batal</a>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- End simpan ke table invoice -->
    <!-- End update ke table spk  -->
  </main><!-- End #main -->

  <!-- Footer -->
  <?php include "page/footer.php" ?>
  <!-- End Footer -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include "page/script.php" ?>
</body>

</html>
<script>
  function enabled() {
    var select = document.getElementById("select");
    var spDiscInput = document.getElementById("sp_disc");

    if (select.value === "Spesial Diskon") {
      spDiscInput.removeAttribute("readonly");
      spDiscInput.setAttribute("required", true);
      spDiscInput.classList.remove("bg-light");
    } else {
      spDiscInput.setAttribute("readonly", true);
      spDiscInput.removeAttribute("required");
      spDiscInput.classList.add("bg-light");
      spDiscInput.value = "0"; // Reset nilai input menjadi 0
    }
  }
</script>


<script type="text/javascript">
  var dateInput = document.getElementById('date');
  var tempoInput = document.getElementById('tempo');
  var datepickerInstance;

  // Mendapatkan tanggal hari ini dari sistem operasi
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, '0');
  var mm = String(today.getMonth() + 1).padStart(2, '0');
  var yyyy = today.getFullYear();
  var todayFormatted = dd + '/' + mm + '/' + yyyy;

  // Mengatur tanggal invoice sebagai tanggal hari ini dari sistem operasi
  dateInput.value = todayFormatted;
  tempoInput.value = '';

  // Kode untuk mengatur batasan tanggal invoice 7 hari kebelakang dan 3 hari kedepan
  // Mendapatkan tanggal awal dan akhir bulan ini
  var firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
  var lastDayOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);

  // Mendapatkan tanggal 7 hari sebelumnya dan 7 hari ke depan dari hari ini
  var sevenDaysAgo = new Date(today);
  sevenDaysAgo.setDate(today.getDate() - 7);

  var sevenDaysLater = new Date(today);
  sevenDaysLater.setDate(today.getDate() + 3);

  // Menentukan minDate dan maxDate untuk rentang yang diizinkan
  var minDate = new Date(
      Math.max(firstDayOfMonth, sevenDaysAgo) // Mengambil tanggal terbesar dari antara tanggal awal bulan ini dan 7 hari yang lalu
  );
  var maxDate = new Date(
      Math.min(lastDayOfMonth, sevenDaysLater) // Mengambil tanggal terkecil dari antara tanggal akhir bulan ini dan 7 hari ke depan
  );

  flatpickr("#date", {
    dateFormat: "d/m/Y",
    minDate: minDate,
    maxDate: maxDate,
    onClose: function(selectedDates, dateStr) {
      if (selectedDates[0]) {
        // Menghapus dan menghancurkan instance datepicker sebelumnya, jika ada
        if (datepickerInstance) {
          datepickerInstance.destroy();
        }

        // Mengatur tanggal tempo sebagai tanggal invoice yang baru dipilih atau tanggal invoice jika sebelumnya
        var selectedDate = new Date(selectedDates[0]);
        var tempoDate = (selectedDate < today) ? selectedDate : today;
        var tempoDateFormatted = String(tempoDate.getDate()).padStart(2, '0') + '/' + String(tempoDate.getMonth() + 1).padStart(2, '0') + '/' + tempoDate.getFullYear();
        tempoInput.value = tempoDateFormatted;

        // Menonaktifkan tanggal sebelum hari ini pada tanggal tempo
        var disableDates = [
          {
            from: new Date(0, 0, 1),
            to: today
          }
        ];

        // Menerapkan datepicker pada tanggal tempo
        datepickerInstance = flatpickr("#tempo", {
          dateFormat: "d/m/Y",
          disable: disableDates,
          defaultDate: tempoDateFormatted
        });
      }
    }
  });

  flatpickr("#tempo", {
    dateFormat: "d/m/Y",
    minDate: todayFormatted // Mengatur tanggal minimum pada tanggal tempo menjadi hari ini
  });

  // Validasi tanggal invoice agar tidak boleh kurang dari tanggal hari ini
  dateInput.addEventListener('blur', function() {
    var selectedDateParts = dateInput.value.split('/');
    var selectedDay = parseInt(selectedDateParts[0]);
    var selectedMonth = parseInt(selectedDateParts[1]) - 1;
    var selectedYear = parseInt(selectedDateParts[2]);
    var selectedDate = new Date(selectedYear, selectedMonth, selectedDay);

    if (selectedDate < today) {
      dateInput.value = todayFormatted; // Mengatur kembali tanggal invoice sebagai tanggal hari ini
      tempoInput.value = todayFormatted; // Mengatur kembali tanggal tempo sebagai tanggal hari ini
    } else {
      tempoInput.value = dateInput.value; // Mengatur tanggal tempo sesuai dengan tanggal invoice yang baru dipilih
    }
  });
  
  var tempoInput = document.getElementById('tempo');
  var clearSearchBtn = document.getElementById('clear-search');

  // Fungsi untuk menghapus isi input 'tempo'
  function clearSearch() {
    tempoInput.value = '';
  }

  // Menambahkan event listener pada tombol 'Clear Search'
  clearSearchBtn.addEventListener('click', clearSearch);
</script>

<!-- end date picker -->
<!-- Generate UUID -->
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

<script>
  // Mendapatkan referensi elemen input
  var hargaProdukInputs = document.querySelectorAll('.harga_produk');

  // Menambahkan event listener untuk memformat angka saat nilai berubah
  hargaProdukInputs.forEach(function(input) {
    input.addEventListener('input', function() {
      formatNumber(input);
    });
  });

  // Fungsi untuk memformat angka dengan pemisah ribuan
  function formatNumber(input) {
    var hargaProdukValue = input.value.replace(/[^0-9.-]+/g, '');

    if (hargaProdukValue !== '') {
      var formattedNumber = numberFormat(hargaProdukValue);
      input.value = formattedNumber;
    }
  }

  // Fungsi untuk memformat angka dengan pemisah ribuan
  function numberFormat(number) {
    return new Intl.NumberFormat('en-US').format(number);
  }
</script>

<script>
  function submitForm(event) {
    event.preventDefault(); // Mencegah pengiriman form secara otomatis

    var dateInput = document.getElementById('date');

    if (dateInput.value.trim() === '') {
      alert('Tanggal Invoice harus diisi!');
      return;
    }

    // Lanjutkan dengan mengirimkan form
    document.getElementById('myForm').submit();
  }
</script>