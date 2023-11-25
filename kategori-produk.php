<?php
$page = 'produk';
$page2 = 'data-kat-prod';
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
    <div class="loader loader">
      <div class="loading">
        <img src="img/loading.gif" width="200px" height="auto">
      </div>
    </div>
    <!-- ENd Loading -->
    <div class="pagetitle">
      <h1>Kategori Produk</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Kategori Produk</li>
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
            <a href="#" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#modal1"><i class="bi bi-plus-circle"></i> Tambah data kategori produk</a>
            <div class="table-responsive mt-3">
              <table class="table table-striped table-bordered" id="table1">
                <thead>
                  <tr class="text-white" style="background-color: #051683;">
                    <td class="text-center p-3 col-1">No</td>
                    <td class="text-center p-3 col-4">Nama Kategori Produk</td>
                    <td class="text-center p-3 col-2">Merk</td>
                    <td class="text-center p-3 col-3">Nomor Izin Edar</td>
                    <td class="text-center p-3 col-2">Aksi</td>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  date_default_timezone_set('Asia/Jakarta');
                  include "koneksi.php";
                  $no = 1;
                  $sql = "SELECT * FROM tb_kat_produk 
                            LEFT JOIN tb_merk ON (tb_kat_produk.id_merk = tb_merk.id_merk)
                            ORDER BY nama_kategori ASC";
                  $query = mysqli_query($connect, $sql) or die(mysqli_error($connect));
                  while ($data = mysqli_fetch_array($query)) {
                    $id_kat = base64_encode($data['id_kat_produk']);
                  ?>
                    <tr>
                      <td class="text-center"><?php echo $no; ?></td>
                      <td><?php echo $data['nama_kategori'] ?></td>
                      <td class="text-center"><?php echo $data['nama_merk'] ?></td>
                      <td class="text-center"><?php echo $data['no_izin_edar'] ?></td>
                      <td class="text-center">
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal2" data-id="<?php echo $data['id_kat_produk']; ?>" data-nama="<?php echo $data['nama_kategori']; ?>" data-merk="<?php echo $data['nama_merk'] ?>" data-nie="<?php echo $data['no_izin_edar'] ?>">
                          <i class="bi bi-pencil"></i>
                        </button>
                        <a href="proses/proses-kat-produk.php?hapus-kat-produk=<?php echo $id_kat ?>" class="btn btn-danger btn-sm delete-data"><i class="bi bi-trash"></i></a>
                      </td>
                      <!-- Modal Edit -->
                      <div class="modal fade" id="modal2" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5">Edit Data Kategori Produk</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="proses/proses-kat-produk.php" method="POST">
                              <div class="modal-body">
                                <div class="mb-3">
                                  <label class="form-label">Nama Kategori Produk</label>
                                  <input type="hidden" class="form-control" name="id_kat_produk" id="id_kat_produk" value="">
                                  <input type="text" class="form-control" name="nama_kat_produk" id="nama_kategori" required>
                                </div>
                                <div class="mb-3">
                                  <label class="form-label">Merk</label>
                                  <input type="text" class="form-control" name="merk" id="merk" readonly>
                                </div>
                                <div class="mb-3">
                                  <label class="form-label">Nomor Izin Edar</label>
                                  <input type="text" class="form-control" name="no_izin_edar" id="nie" required>
                                  <input type="hidden" class="form-control" name="updated" value="<?php echo date('d/m/Y, G:i') ?>">
                                  <input type="hidden" class="form-control" name="user_updated" value="<?php echo $_SESSION['tiket_id'] ?>">
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="submit" name="edit-kat-produk" id="simpan" disabled class="btn btn-primary btn-md"><i class="bx bx-save"></i> Simpan Perubahan</button>
                                <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal"><i class="bi bi-x"></i> Tutup</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <!-- End Modal Edit -->
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
          <h1 class="modal-title fs-5">Tambah Data Kategori Produk</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="proses/proses-kat-produk.php" method="POST">
          <div class="modal-body">
            <div class="mb-3">
              <?php
              $UUID = generate_uuid();
              ?>
              <div class="mb-3">
                <label class="form-label">Nama Kategori Produk</label>
                <input type="hidden" class="form-control" name="id_kat_produk" value="KATPROD<?php echo $UUID; ?>">
                <input type="hidden" class="form-control" name="id_user" value="<?php echo $_SESSION['tiket_id']; ?>">
                <input type="text" class="form-control" name="nama_kat_produk" required>
                <input type="hidden" class="form-control" name="created" value="<?php echo date('d/m/Y, G:i') ?>">
                <input type="hidden" class="form-control" name="user_created" value="<?php echo $_SESSION['tiket_id'] ?>">
              </div>
              <div class="mb-3">
                <label class="form-label">Merk</label>
                <select class="selectize-js form-select" name="merk" required>
                  <option value="">Pilih Merk...</option>
                  <?php
                  include "koneksi.php";
                  $sql = "SELECT * FROM tb_merk";
                  $query = mysqli_query($connect, $sql) or die(mysqli_error($connect, $sql));
                  while ($data = mysqli_fetch_array($query)) {
                  ?>
                    <option value="<?php echo $data['id_merk'] ?>"><?php echo $data['nama_merk'] ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Nomor Izin Edar</label>
                <input type="text" class="form-control" name="nie" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" name="simpan-kat-produk" class="btn btn-primary btn-md"><i class="bx bx-save"></i> Simpan Data</button>
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
      $("#table1 tbody").append("<tr><td colspan='5' align='center'>Data not found</td></tr>");
    }
  });
</script>

<!-- Script untuk modal edit -->
<script>
  $('#modal2').on('show.bs.modal', function(event) {
    // Menampilkan data
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var nama = button.data('nama');
    var merk = button.data('merk');
    var nie = button.data('nie');
    var modal = $(this);
    var simpanBtn = modal.find('.modal-footer #simpan');
    var namaInput = modal.find('.modal-body #nama_kategori');
    var merkInput = modal.find('.modal-body #merk');
    var nieInput = modal.find('.modal-body #nie');

    modal.find('.modal-body #id_kat_produk').val(id);
    namaInput.val(nama);
    nieInput.val(nie);
    merkInput.val(merk);

    // Pengecekan data, dan buttun disable or enable saat data di ubah
    // dan data kembali ke nilai awal
    var originalNama = namaInput.val();
    var originalMerk = merkInput.val();
    var originalNie = nieInput.val();

    namaInput.on('input', function() {
      var currentNama = $(this).val();
      var currentMerk = merkInput.val();
      var currentNie = nieInput.val();

      if (currentNama != originalNama || currentMerk != originalMerk || currentNie != originalNie) {
        simpanBtn.prop('disabled', false);
      } else {
        simpanBtn.prop('disabled', true);
      }
    });

    nieInput.on('input', function() {
      var currentNie = $(this).val();
      var currentNama = namaInput.val();
      var currentMerk = merkInput.val();

      if (currentNama != originalNama || currentMerk != originalMerk || currentNie != originalNie) {
        simpanBtn.prop('disabled', false);
      } else {
        simpanBtn.prop('disabled', true);
      }
    });

    merkInput.on('input', function() {
      var currentMerk = $(this).val();
      var currentNama = namaInput.val();
      var currentNie = nieInput.val();

      if (currentNama != originalNama || currentMerk != originalMerk || currentNie != originalNie) {
        simpanBtn.prop('disabled', false);
      } else {
        simpanBtn.prop('disabled', true);
      }
    });

    modal.find('form').on('reset', function() {
      simpanBtn.prop('disabled', true);
    });
  });
</script>
<!-- End Script modal edit -->