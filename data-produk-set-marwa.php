<?php
$page = 'produk';
$page2 = 'data-produk-set-marwa';
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
    <!-- Loading -->
    <!-- <div class="loader loader">
      <div class="loading">
        <img src="img/loading.gif" width="200px" height="auto">
      </div>
    </div> -->
    <!-- ENd Loading -->
    <div class="pagetitle">
      <h1>Data Produk Set Reguler</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dasboard.php">Home</a></li>
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
            <a href="tambah-data-produk-set-marwa.php" class="btn btn-primary btn-md"><i class="bi bi-plus-circle"></i> Tambah data produk set</a>
            <div class="table-responsive mt-3">
              <table class="table table-striped table-bordered" id="table1">
                <thead>
                  <tr class="text-white" style="background-color: #051683;">
                    <td class="text-center p-3" style="width: 50px">No</td>
                    <td class="text-center p-3" style="width: 120px">Kode Produk Set</td>
                    <td class="text-center p-3" style="width: 250px">Nama Set Produk </td>
                    <td class="text-center p-3" style="width: 100px">Merk</td>
                    <td class="text-center p-3" style="width: 100px">Kat Penjualan</td>
                    <td class="text-center p-3" style="width: 100px">Harga Modal</td>
                    <td class="text-center p-3" style="width: 100px">Harga Jual</td>
                    <!-- <td class="text-center p-3" style="width: 50px">Stok</td> -->
                    <td class="text-center p-3" style="width: 100px">Aksi</td>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  include "koneksi.php";

                  $no = 1;
                  $sql = "SELECT prs.*,
                              prs.created_date as 'produk_created',
                              prs.created_date as 'produk_updated',    
                              uc.nama_user as user_created, 
                              uu.nama_user as user_updated,
                              kj.nama_kategori as nama_kat,
                              mr.*,
                              lok.*
                              FROM tb_produk_set_marwa as prs
                              LEFT JOIN user uc ON (prs.id_user = uc.id_user)
                              LEFT JOIN user uu ON (prs.user_updated = uu.id_user)
                              LEFT JOIN tb_merk mr ON (prs.id_merk = mr.id_merk)
                              LEFT JOIN tb_kat_penjualan kj ON (prs.id_kat_penjualan = kj.id_kat_penjualan)
                              LEFT JOIN tb_lokasi_produk lok ON (prs.id_lokasi = lok.id_lokasi)
                              ";
                  $query = mysqli_query($connect, $sql) or die(mysqli_error($connect, $sql));
                  while ($data = mysqli_fetch_array($query)) {
                    $id_set = base64_encode($data['id_set_marwa']);
                  ?>
                    <tr>
                      <td class="text-center"><?php echo $no; ?></td>
                      <td><?php echo $data['kode_set_marwa']; ?></td>
                      <td><?php echo $data['nama_set_marwa']; ?></td>
                      <td class="text-center"><?php echo $data['nama_merk']; ?></td>
                      <td class="text-center"><?php echo $data['nama_kat']; ?></td>
                      <?php
                      $id = $data['id_set_marwa'];
                      $grand_total = 0;
                      $sql_data = "SELECT ipsm.id_produk, ipsm.qty, tpr.nama_produk, tpr.harga_produk FROM isi_produk_set_marwa ipsm
                                     LEFT JOIN tb_produk_reguler tpr ON (ipsm.id_produk = tpr.id_produk_reg)
                                     LEFT JOIN tb_produk_set_marwa tpsm ON (ipsm.id_set_marwa = tpsm.id_set_marwa)
                                     WHERE tpsm.id_set_marwa = '$id'";
                      $query_data = mysqli_query($connect, $sql_data) or die(mysqli_error($connect, $sql_data));
                      while ($row = mysqli_fetch_array($query_data)) {
                        $harga = $row['harga_produk'];
                        $qty = $row['qty'];
                        $jumlah = $qty * $harga;
                        $grand_total += $jumlah;
                      ?>
                      <?php } ?>

                      <td class="text-end"><?php echo number_format($grand_total, 0, '.', '.'); ?></td>
                      <td class="text-end"><?php echo number_format($data['harga_set_marwa'], 0, '.', '.'); ?></td>
                      <!-- <td class="text-end"><?php echo number_format($data['stock'], 0, '.', '.'); ?></td> -->
                      <td class="text-center">
                        <!-- Lihat Data -->
                        <a href="detail-set-marwa.php?detail-id=<?php echo $id_set ?>" class="btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i></a>
                        <!-- Edit Data -->
                        <a href="edit-data-set-marwa.php?edit-set-marwa=<?php echo $id_set ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                        <!-- Hapus Data -->
                        <a href="proses/proses-produk-set-marwa.php?hapus-set-marwa=<?php echo $id_set ?>" class="btn btn-danger btn-sm delete-data"><i class="bi bi-trash"></i></a>
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

  <!-- Modal SP -->
  <div class="modal fade" id="modal1" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">Tambah Data Produk Set</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="proses/proses-produk.php" method="POST">
          <div class="modal-body">
            <div class="mb-3">
              <?php
              $UUID = generate_uuid();
              ?>
              <div class="mb-3">
                <label class="form-label"><strong>Kode Produk Set</strong></label>
                <input type="hidden" class="form-control" name="id_produk" value="BR<?php echo $UUID; ?>">
                <input type="text" class="form-control" name="kode_barang" required>
              </div>
              <div class="mb-3">
                <label class="form-label"><strong>Nama Produk Set</strong></label>
                <input type="text" class="form-control" name="nama_barang" required>
              </div>
              <div class="mb-3">
                <label class="form-label"><strong>Merk</strong></label>
                <select class="selectize-js form-select" name="merk" required>
                  <?php
                  include "koneksi.php";
                  $sql = "SELECT * FROM tb_merk ";
                  $query = mysqli_query($connect, $sql) or die(mysqli_error($connect));
                  while ($data = mysqli_fetch_array($query)) { ?>
                    <option value="<?php echo $data['id_merk']; ?>"><?php echo $data['nama_merk']; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label"><strong>Harga Produk Set</strong></label>
                <input type="text" class="form-control" name="harga" id="inputBudget" required>
              </div>
              <div class="mb-3">
                <label class="form-label"><strong>Lokasi Produk</strong></label>
                <select class="selectize-js form-select" name="lokasi" required>
                  <?php
                  include "koneksi.php";
                  $sql = "SELECT * FROM tb_lokasi_produk ";
                  $query = mysqli_query($connect, $sql) or die(mysqli_error($connect));
                  while ($data = mysqli_fetch_array($query)) { ?>
                    <option value="<?php echo $data['id_lokasi'] ?>>Nama Lokasi= <?php echo $data['nama_lokasi'] ?> No.Lantai= <?php echo $data['no_lantai'] ?> Area= <?php echo $data['nama_area'] ?> No.Rak= <?php echo $data['no_rak'] ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class=" mb-3">
                      <label class="form-label"><strong>Kategori Penjualan</strong></label>
                      <select class="selectize-js form-select" name="kategori_penjualan" required>
                        <?php
                        include "koneksi.php";
                        $sql = "SELECT * FROM user_role ";
                        $query = mysqli_query($connect, $sql) or die(mysqli_error($connect));
                        while ($data = mysqli_fetch_array($query)) { ?>
                          <option value="<?php echo $data['id_user_role']; ?>"><?php echo $data['role']; ?></option>
                        <?php } ?>
                      </select>
              </div>
              <div class="mb-3">
                <label class="form-label"><strong>Stok</strong></label>
                <input type="text" class="form-control" name="stok" required>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="simpan-produk" class="btn btn-primary btn-md"><i class="bx bx-save"></i> Simpan Data</button>
            <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal"><i class="bi bi-x"></i> Tutup</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- End Modal SP -->

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

<script>
  // delete button
  $("#table1").on("click", ".delete-button", function() {
    $(this).closest("tr").remove();
    if ($("#table1 tbody tr").length === 0) {
      $("#table1 tbody").append("<tr><td colspan='9' align='center'>Data not found</td></tr>");
    }
  });
</script>

<!-- Format nominal Indo -->
<script>
  const inputBudget = document.getElementById('inputBudget');

  inputBudget.addEventListener('input', () => {
    // Remove any non-digit characters
    let input = inputBudget.value.replace(/[^\d]/g, '');
    // Convert to a number and format with "Rp" prefix and "." and "," separator
    let formattedInput = Number(input).toLocaleString('id-ID', {
      style: 'currency',
      currency: 'IDR'
    });
    // Remove trailing ",00" if present
    formattedInput = formattedInput.replace(",00", "");
    // Update the input value with the formatted number
    inputBudget.value = formattedInput;
  });
</script>