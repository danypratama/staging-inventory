<?php
$page = 'produk';
$page2 = 'data-kat-penj';
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
      <h1>Kategori Penjualan</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Kategori Penjualan</li>
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
            <a href="#" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#modal1"><i class="bi bi-plus-circle"></i> Tambah data kategori penjualan</a>
            <div class="table-responsive mt-3">
              <table class="table table-striped table-bordered" id="table1">
                <thead>
                  <tr class="text-white" style="background-color: #051683;">
                    <td class="text-center p-3 col-1">No</td>
                    <td class="text-center p-3 col-5">Nama Kategori Penjualan</td>
                    <td class="text-center p-3 col-2">Minimal Stock</td>
                    <td class="text-center p-3 col-2">Maximal Stock</td>
                    <td class="text-center p-3 col-2">Aksi</td>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  date_default_timezone_set('Asia/Jakarta');
                  include "koneksi.php";
                  $no = 1;
                  $sql = "SELECT kp.*,  uc.nama_user as user_created, uu.nama_user as user_updated
                            FROM tb_kat_penjualan as kp
                            LEFT JOIN user uc ON (kp.id_user = uc.id_user)
                            LEFT JOIN user uu ON (kp.user_updated = uu.id_user)";
                  $query = mysqli_query($connect, $sql) or die(mysqli_error($connect));
                  while ($data = mysqli_fetch_array($query)) {
                    $id_kat = base64_encode($data['id_kat_penjualan']);
                  ?>
                    <tr>
                      <td class="text-center"><?php echo $no; ?></td>
                      <td><?php echo $data['nama_kategori'] ?></td>
                      <td class="text-center"><?php echo number_format($data['min_stock'], 0, '.', '.') ?></td>
                      <td class="text-center"><?php echo number_format($data['max_stock'], 0, '.', '.') ?></td>
                      <td class="text-center">
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal3" data-user="<?php echo $data['user_created'] ?>" data-nama="<?php echo $data['nama_kategori'] ?>" data-created="<?php echo $data['created_date'] ?>" data-updated="<?php echo $data['updated_date'] ?>" data-userupdated="<?php echo $data['user_updated'] ?>">
                          <i class="bi bi-info-circle"></i>
                        </button>
                        <!-- Modal Info -->
                        <div class="modal fade" id="modal3" tabindex="-1">
                          <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h1 class="modal-title fs-5">Informasi Lengkap</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <div class="table-responsive">
                                  <table class="table table-bordered table-striped">
                                    <tr>
                                      <td class="col-4 text-start">Nama Kategori</td>
                                      <td class="col-8 text-start" id="nama-kategori"></td>
                                    </tr>
                                    <tr>
                                      <td class="col-4 text-start">Dibuat Oleh</td>
                                      <td class="col-8 text-start" id="user-created"></td>
                                    </tr>
                                    <tr>
                                      <td class="col-4 text-start">Dibuat Tanggal</td>
                                      <td class="col-8 text-start" id="created-date"></td>
                                    </tr>
                                    <tr>
                                      <td class="col-4 text-start">Diubah Oleh</td>
                                      <td class="col-8 text-start" id="user-updated"></td>
                                    </tr>
                                    <tr>
                                      <td class="col-4 text-start">Diubah Tanggal</td>
                                      <td class="col-8 text-start" id="updated-date"></td>
                                    </tr>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- End Info -->
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal2" data-id="<?php echo $data['id_kat_penjualan'] ?>" data-nama="<?php echo $data['nama_kategori'] ?>" data-minstock="<?php echo number_format($data['min_stock'], 0, '.', '.') ?>" data-maxstock="<?php echo number_format($data['max_stock'], 0, '.', '.') ?>">
                          <i class="bi bi-pencil"></i>
                        </button>

                        <a href="proses/proses-kat-penjualan.php?hapus-kat-penjualan=<?php echo $id_kat ?>" class="btn btn-danger btn-sm delete-data"><i class="bi bi-trash"></i></a>
                      </td>
                      <!-- Modal Edit  -->
                      <div class="modal fade" id="modal2" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5">Edit Data Kategori Penjualan</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="proses/proses-kat-penjualan.php" method="POST">
                              <div class="modal-body">
                                <div class="mb-3">
                                  <label class="form-label">Nama Kategori Penjualan</label>
                                  <input type="hidden" class="form-control" name="id_kat_penjualan" id="id_kat_penjualan">
                                  <input type="text" class="form-control" name="nama_kategori" id="nama_kategori" required>
                                </div>
                                <div class="mb-3">
                                  <label class="form-label">Minimal Stock</label>
                                  <input type="text" class="form-control" name="min_stock" id="min_stock" required>
                                </div>
                                <div class="mb-3">
                                  <label class="form-label">Maksimal Stock</label>
                                  <input type="text" class="form-control" name="max_stock" id="max_stock" required>
                                  <input type="hidden" class="form-control" name="updated" value="<?php echo date('d/m/Y, G:i') ?>">
                                  <input type="hidden" class="form-control" name="user_updated" value="<?php echo $_SESSION['tiket_id'] ?>">
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="submit" name="edit-kat-penjualan" id="simpan" class="btn btn-primary btn-md" disabled><i class="bx bx-save"></i> Simpan Perubahan</button>
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
  <!-- Modal Input-->
  <div class="modal fade" id="modal1" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">Tambah Data Kategori Penjualan</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="proses/proses-kat-penjualan.php" method="POST">
          <div class="modal-body">
            <div class="mb-3">
              <?php
              $UUID = generate_uuid();
              ?>
              <div class="mb-3">
                <label class="form-label">Nama Kategori Penjualan</label>
                <input type="hidden" class="form-control" name="id_kat_penjualan" value="KATPENJ<?php echo $UUID; ?>">
                <input type="hidden" class="form-control" name="id_user" value="<?php echo $_SESSION['tiket_id']; ?>">
                <input type="text" class="form-control" name="nama_kategori" required>
                <input type="hidden" class="form-control" name="created" value="<?php echo date('d/m/Y, G:i') ?>">
              </div>
              <div class="mb-3">
                <label class="form-label">Minimal Stock</label>
                <input type="text" class="form-control" name="min_stock" id="min_stock" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Maksimal Stock</label>
                <input type="text" class="form-control" name="max_stock" id="max_stock" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" name="simpan-kat-penjualan" class="btn btn-primary btn-md"><i class="bx bx-save"></i> Simpan Data</button>
              <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal"><i class="bi bi-x"></i> Tutup</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  <!-- End Modal Input-->

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

<!-- Number Format -->
<script>
  $(document).on('input', '#min_stock', function(e) {
    var minStock = parseInt($(this).val().replace(/\D/g, ''));
    $(this).val(minStock.toLocaleString('id-ID').replace(',', '.'));
  });

  $(document).on('input', '#max_stock', function(e) {
    var maxStock = parseInt($(this).val().replace(/\D/g, ''));
    $(this).val(maxStock.toLocaleString('id-ID').replace(',', '.'));
  });
</script>

<script>
  $('#modal2').on('show.bs.modal', function(event) {
    // Mendapatkan data dari tombol yang ditekan
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var nama = button.data('nama');
    var minstock = button.data('minstock');
    var maxstock = button.data('maxstock');
    var modal = $(this);
    var simpanBtn = modal.find('.modal-footer #simpan');
    var namaInput = modal.find('.modal-body #nama_kategori');
    var minstockInput = modal.find('.modal-body #min_stock');
    var maxstockInput = modal.find('.modal-body #max_stock');

    var formatOptions = {
      style: 'decimal',
      minimumFractionDigits: 0
    };

    // Menampilkan data
    modal.find('.modal-body #id_kat_penjualan').val(id);
    namaInput.val(nama);
    minstockInput.val(minstock);
    maxstockInput.val(maxstock);

    // Pengecekan data, dan buttun disable or enable saat data di ubah
    // dan data kembali ke nilai awal
    var originalNama = namaInput.val();
    var originalMinstock = minstockInput.val();
    var originalMaxstock = maxstockInput.val();

    namaInput.on('input', function() {
      var currentNama = $(this).val();
      var currentMinstock = minstockInput.val();
      var currentMaxstock = maxstockInput.val();
      if (currentNama != originalNama || currentMinstock != originalMinstock || currentMaxstock != originalMaxstock) {
        simpanBtn.prop('disabled', false);
      } else {
        simpanBtn.prop('disabled', true);
      }
    });

    minstockInput.on('input', function() {
      var minStock = parseInt($(this).val().replace(/\D/g, ''));
      var currentMinstock = minStock.toLocaleString('id-ID', formatOptions);
      var currentNama = namaInput.val();
      var currentMaxstock = maxstockInput.val();
      if (currentNama != originalNama || currentMinstock != originalMinstock || currentMaxstock != originalMaxstock) {
        simpanBtn.prop('disabled', false);
      } else {
        simpanBtn.prop('disabled', true);
      }
    });

    maxstockInput.on('input', function() {
      var currentMinstock = minstockInput.val();
      var currentNama = namaInput.val();
      var maxStock = parseInt($(this).val().replace(/\D/g, ''));
      var currentMaxstock = maxStock.toLocaleString('id-ID', formatOptions);
      if (currentNama != originalNama || currentMinstock != originalMinstock || currentMaxstock != originalMaxstock) {
        simpanBtn.prop('disabled', false);
      } else {
        simpanBtn.prop('disabled', true);
      }
      console.log(currentMaxstock);
    });

    modal.find('form').on('reset', function() {
      simpanBtn.prop('disabled', true);
    });
  });
</script>

<script>
  $('#modal3').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var user = button.data('user');
    var nama = button.data('nama');
    var created = button.data('created');
    var updated = button.data('updated');
    var userupdated = button.data('userupdated');
    var modal = $(this);
    modal.find('.modal-body #id_user').val(user);
    modal.find('.modal-body #nama_kategori').val(nama);
    modal.find('.modal-body #created_date').val(created);
    modal.find('.modal-body #updated_date').val(updated);
    modal.find('.modal-body #user_updated').val(userupdated);

    // untuk menampilkan data pada atribut <td>
    $('#user-created').html(user);
    $('#nama-kategori').html(nama);
    $('#created-date').html(created);
    $('#updated-date').html(updated);
    $('#user-updated').html(userupdated);
  })
</script>