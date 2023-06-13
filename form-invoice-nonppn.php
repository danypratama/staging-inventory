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
    <div class="container-fluid">
      <!-- Form simpan ke table invoice -->
      <div class="card">
        <div class="card-header text-center">
          <h5>Form Invoice Nonppn</h5>
        </div>
        <div class="card-body">
          <form action="proses/proses-invoice-nonppn.php" method="POST">
            <?php
            // Mendapatkan data dari form sebelumnya

            if (isset($_POST['spk_id'])) {
              $selectedSpkIds = $_POST['spk_id'];

              // Lakukan sesuatu dengan data yang dipilih
              // Misalnya, tampilkan daftar ID SPK yang dipilih
              foreach ($selectedSpkIds as $spkId) {
                echo '<input type="hidden" name="id_spk[]" value="' . $spkId . '">';
                $sql = mysqli_query($connect, " SELECT sr.id_customer, cs.nama_cs, cs.alamat
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
            $sql  = mysqli_query($connect, "SELECT max(no_inv) as maxID, STR_TO_DATE(tgl_inv, '%d/%m/%Y') AS tgl FROM inv_nonppn WHERE YEAR(STR_TO_DATE(tgl_inv, '%d/%m/%Y')) = '$thn'");
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
            <div class="row g-3 p-3">
              <input type="hidden" name="id_inv_nonppn" value="NONPPN-<?php echo $year ?><?php echo $month ?><?php echo $uuid ?><?php echo $day ?>">
              <div class="col-sm-2">
                <label><strong>No Invoice Nonppn</strong></label>
                <input type="text" class="form-control" name="no_inv_nonppn" value="<?php echo $no_inv ?>" required>
              </div>
              <div class="col-sm-4">
                <label><strong>Pelanggan</strong></label>
                <input type="text" class="form-control bg-light" name="cs" value="<?php echo $data_spk['nama_cs']; ?>" required>
              </div>
              <div class="col-sm-4">
                <label><strong>Pelanggan Invoice</strong></label>
                <input type="text" class="form-control" name="cs_inv" value="<?php echo $data_spk['nama_cs']; ?>" required>
              </div>
              <div class="col-sm-2">
                <label><strong>Jenis Invoice</strong></label>
                <select name="jenis_inv" id="select" class="form-select" onchange="enabled()">
                  <option value="Reguler">Reguler</option>
                  <option value="Diskon">Diskon</option>
                  <option value="Spesial Diskon">Spesial Diskon</option>
                </select>
              </div>
            </div>
            <div class="row g-3 p-3">
              <div class="col">
                <label><strong>Tanggal Invoice</strong></label>
                <input type="text" id="date" class="form-control" name="tgl_inv" required>
              </div>
              <div class="col">
                <label><strong>Tanggal Tempo</strong></label>
                <input type="text" id="tempo" class="form-control" name="tgl_tempo" required>
              </div>
              <div class="col">
                <labe><strong>Spesial Diskon</strong></label>
                  <input type="text" id="sp_disc" name="sp_disc" value="0" class="form-control bg-light" readonly>
              </div>
              <div class="col">
                <label><strong>Ongkir</strong></label>
                <input type="text" class="form-control" name="ongkir" required>
              </div>
              <div class="col">
                <label><strong>Note Invoice</strong></label>
                <input type="text" class="form-control" name="note_inv">
              </div>
            </div>
            <div class="text-center mt-2">
              <button type="submit" class="btn btn-primary btn-md" name="simpan-inv">Simpan Data</button>
              <a href="spk-siap-kirim.php?sort=baru" class="btn btn-secondary">Batal</a>
            </div>
          </form>
        </div>
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



<!-- date picker with flatpick -->
<script type="text/javascript">
  flatpickr("#date", {
    dateFormat: "d/m/Y",
  });

  flatpickr("#tempo", {
    dateFormat: "d/m/Y",
  });
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