<?php
$page = 'spcs';
$page2  = 'data-cs';
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
  <link rel="stylesheet" href="assets/css/wrap-text.css">
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
    <!-- End Loading -->
    <div class="pagetitle">
      <h1>Data Customer</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Customer</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section>
      <!-- SWEET ALERT -->
      <div class="info-data" data-infodata="<?php if (isset($_SESSION['info'])) { echo $_SESSION['info']; } unset($_SESSION['info']); ?>"></div>
      <!-- END SWEET ALERT -->
      <div class="container-fluid">
        <div class="card">
          <div class="card-body p-3">
            <?php  
               include "koneksi.php";
               $id_role = $_SESSION['tiket_role'];
               $sql_role = "SELECT * FROM user_role WHERE id_user_role='$id_role'";
               $query_role = mysqli_query($connect, $sql_role) or die(mysqli_error($connect));
               $data_role = mysqli_fetch_array($query_role);
               if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Manager Gudang" || $data_role['role'] == "Admin Penjualan") { 
                 ?>
                   <a href="#" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#modal1"><i class="bi bi-plus-circle"></i> Tambah data customer</a>
                 <?php 
               }
            ?>
            <div class="table-responsive mt-3">
              <table class="table table-striped table-bordered" id="table1">
                <thead>
                  <tr class="text-white" style="background-color: #051683;">
                    <td class="text-center text-nowrap p-3 col-1">No</td>
                    <td class="text-center text-nowrap p-3 col-3">Nama Customer</td>
                    <td class="text-center text-nowrap p-3 col-3">Alamat</td>
                    <td class="text-center text-nowrap p-3 col-2">Telepon</td>
                    <td class="text-center text-nowrap p-3 col-2">Email</td>
                    <?php
                      if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Manager Gudang" || $data_role['role'] == "Admin Penjualan") { 
                        ?>
                          <td class="text-center text-nowrap p-3 col-2">Aksi</td>
                        <?php 
                      }
                    ?>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  date_default_timezone_set('Asia/Jakarta');
                  include "koneksi.php";
                  $no = 1;
                  $sql = "SELECT 
                            cs.jenis_usaha,
                            cs.id_cs,
                            cs.nama_cs, 
                            cs.email, 
                            cs.nama_cp,
                            cs.no_telp, 
                            cs.alamat, 
                            cs.npwp,
                            cs.created_date, 
                            cs.created_by,
                            cs.updated_date, 
                            cs.updated_by,
                            uc.nama_user AS user_created, 
                            uu.nama_user AS user_updated
                          FROM tb_customer AS cs 
                          LEFT JOIN user AS uc ON (cs.created_by = uc.id_user)
                          LEFT JOIN user AS uu ON (cs.updated_by = uu.id_user)
                          ORDER BY cs.nama_cs ASC";
                  $query = mysqli_query($connect, $sql) or die(mysqli_error($connect));
                  while ($data = mysqli_fetch_array($query)) {
                    $id_cs = base64_encode($data['id_cs']);
                  ?>
                    <tr>
                      <td class="text-center"><?php echo $no ?></td>
                      <td class="text-nowrap"><?php echo $data['nama_cs']; ?></td>
                      <td class="wrap-text"><?php echo $data['alamat']; ?></td>
                      <td><?php echo $data['no_telp']; ?></td>
                      <td><?php echo $data['email']; ?></td>
                      <?php
                        if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Manager Gudang") { 
                          ?>
                            <td class="text-center text-nowrap">
                              <!-- Button  modal detail -->
                              <button type="button" class="btn btn-primary btn-sm btn-detail" data-bs-toggle="modal" data-bs-target="#detailCs" title="Detail" data-jenis="<?php echo $data['jenis_usaha']; ?>" data-cs="<?php echo $data['nama_cs']; ?>" data-email="<?php echo $data['email']; ?>" data-cp="<?php echo $data['nama_cp']; ?>" data-telp="<?php echo $data['no_telp']; ?>" data-alamat="<?php echo $data['alamat']; ?>" data-npwp="<?php echo $data['npwp']; ?>" data-createdby="<?php echo $data['user_created']; ?>" data-created="<?php echo $data['created_date']; ?>" data-updated="<?php echo $data['updated_date']; ?>" data-updatedby="<?php echo $data['user_updated']; ?>">
                                <i class="bi bi-eye-fill"></i>
                              </button>
                              <!-- End Modal Detail -->
                              <!-- Modal Edit -->
                              <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal2" data-jenis="<?php echo $data['jenis_usaha']; ?>" data-id="<?php echo $data['id_cs']; ?>" data-nama="<?php echo $data['nama_cs']; ?>" data-alamat="<?php echo $data['alamat']; ?>" data-cp="<?php echo $data['nama_cp']; ?>" data-telp="<?php echo $data['no_telp']; ?>" data-email="<?php echo $data['email']; ?>" data-npwp="<?php echo $data['npwp']; ?>" title="Edit Data">
                                <i class="bi bi-pencil"></i>
                              </button>
                              <!-- End Modal Edit -->
                              <a href="proses/proses-cs.php?hapus-cs=<?php echo $id_cs ?>" class="btn btn-danger btn-sm delete-data" data-bs-delay="0" title="Hapus Data"><i class="bi bi-trash"></i></a>
                            </td>
                          <?php 
                        } else if ($data_role['role'] == "Admin Penjualan"){
                          ?>
                            <td class="text-center text-nowrap">
                              <!-- Button  modal detail -->
                              <button type="button" class="btn btn-primary btn-sm btn-detail" data-bs-toggle="modal" data-bs-target="#detailCs" title="Detail" data-jenis="<?php echo $data['jenis_usaha']; ?>" data-cs="<?php echo $data['nama_cs']; ?>" data-email="<?php echo $data['email']; ?>" data-cp="<?php echo $data['nama_cp']; ?>" data-telp="<?php echo $data['no_telp']; ?>" data-alamat="<?php echo $data['alamat']; ?>" data-npwp="<?php echo $data['npwp']; ?>" data-createdby="<?php echo $data['user_created']; ?>" data-created="<?php echo $data['created_date']; ?>" data-updated="<?php echo $data['updated_date']; ?>" data-updatedby="<?php echo $data['user_updated']; ?>">
                                <i class="bi bi-eye-fill"></i>
                              </button>
                              <!-- End Modal Detail -->
                              <!-- Modal Edit -->
                              <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal2" data-jenis="<?php echo $data['jenis_usaha']; ?>" data-id="<?php echo $data['id_cs']; ?>" data-nama="<?php echo $data['nama_cs']; ?>" data-alamat="<?php echo $data['alamat']; ?>" data-cp="<?php echo $data['nama_cp']; ?>" data-telp="<?php echo $data['no_telp']; ?>" data-email="<?php echo $data['email']; ?>" data-npwp="<?php echo $data['npwp']; ?>" title="Edit Data">
                                <i class="bi bi-pencil"></i>
                              </button>
                              <!-- End Modal Edit -->
                            </td>
                          <?php 
                        }
                      ?>
                    </tr>
                    <?php $no++; ?>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal Detail -->
      <div class="modal fade animate__animated animate__zoomInDown" id="detailCs" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Customer</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                      <tr>
                        <td class="col-4">Nama Customer</td>
                        <td id="dataCs"></td>
                      </tr>
                      <tr>
                        <td class="col-4">Jenis Usaha</td>
                        <td id="jenisUsaha"></td>
                      </tr>
                      <tr>
                        <td class="col-4">Email</td>
                        <td id="dataEmail"></td>
                      </tr>
                      <tr>
                        <td class="col-4">Nama Contact Person</td>
                        <td id="namaCp"></td>
                      </tr>
                      <tr>
                        <td class="col-4">No. Telepon</td>
                        <td id="dataTelp"></td>
                      </tr>
                      <tr>
                        <td class="col-4">Alamat</td>
                        <td id="dataAlamat"></td>
                      </tr>
                      <tr>
                        <td class="col-4">NPWP</td>
                        <td id="npwp"></td>
                      </tr>
                      <tr>
                        <td class="col-4">Dibuat Oleh</td>
                        <td id="dataCreatedBy"></td>
                      </tr>
                      <tr>
                        <td class="col-4">Dibuat Tanggal</td>
                        <td id="dataCreated"></td>
                      </tr>
                      <tr>
                        <td class="col-4">Diubah Oleh</td>
                        <td id="dataUpdatedBy"></td>
                      </tr>
                      <tr>
                        <td class="col-4">Diubah Tanggal</td>
                        <td id="dataUpdated"></td>
                      </tr>
                    </table>
               </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Modal Detail -->
      <!-- Modal Edit CS -->
      <div class="modal fade animate__animated animate__zoomIn" id="modal2" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5">Edit Data Customer</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="proses/proses-cs.php" method="POST">
              <div class="modal-body">
                <div class="mb-3">
                  <input type="text" class="form-control" id="id">
                  <div class="mb-3">
                    <label for="jenisUsaha" class="form-label">Jenis Usaha :</label><br>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="jenis_usaha" id="jenisUsaha" value="Perorangan">
                      <label class="form-check-label">Perorangan</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="jenis_usaha" id="jenisUsaha" value="Perusahaan">
                      <label class="form-check-label">Perusahaan</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="jenis_usaha" id="jenisUsaha" value="Toko">
                      <label class="form-check-label">Toko</label>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Nama Peusahaan / Toko</label>
                    <input type="hidden" class="form-control" name="id_cs" id="id">
                    <input type="text" class="form-control" name="nama_cs" id="nama" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <input type="text" class="form-control" name="alamat_cs" id="alamat" required>
                  </div>
                  <div class="mb3">
                    <label>Nama Contact Person</label>
                    <input type="text" class="form-control" name="nama_cp" id="namaCp">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Telepon</label>
                    <input type="text" class="form-control" name="telp_cs" id="telp" maxlength="13" required>
                    <small class="form-text text-muted">Masukkan hanya angka (maksimal 13 digit).</small>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email">
                    <input type="hidden" class="form-control" name="updated" value="<?php echo date('d/m/Y, G:i') ?>">
                  </div>
                  <div class="mb3">
                    <label>NPWP</label>
                    <input type="text" class="form-control" id="npwp" name="npwp" maxlength="20">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" name="edit-cs" id="simpan" class="btn btn-primary btn-md" disabled><i class="bx bx-save"></i> Simpan Perubahan</button>
                  <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal"><i class="bi bi-x"></i> Tutup</button>
                </div>
            </form>
          </div>
        </div>
      </div>
      <!-- End Modal Edit CS -->
    </section>
  </main><!-- End #main -->

  <!-- Footer -->
  <?php include "page/footer.php" ?>
  <!-- End Footer -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include "page/script.php" ?>'
</body>

</html>
<!-- Modal Add CS -->
<div class="modal fade animate__animated animate__fadeInUpBig" id="modal1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Tambah Data Customer</h1>
      </div>
      <form action="proses/proses-cs.php" method="POST">
        <div class="modal-body">
          <div class="mb-3">
            <?php
              $UUID = generate_uuid();
            ?>
            <div class="mb-3">
              <label class="fw-bold">Jenis Usaha :</label><br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="jenis_usaha" value="Perorangan">
                <label class="form-check-label">Perorangan</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="jenis_usaha" value="Perusahaan">
                <label class="form-check-label">Perusahaan</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="jenis_usaha" value="Toko">
                <label class="form-check-label">Toko</label>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">Nama Perusahaan / Toko</label>
              <input type="hidden" class="form-control" name="id_cs" value="CS<?php echo $UUID; ?>">
              <input type="text" class="form-control" name="nama_cs" required>
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">Alamat</label>
              <input type="text" class="form-control" name="alamat_cs" required>
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">Nama Contact Person</label>
              <input type="text" class="form-control" name="nama_cp" required>
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">Telepon</label>
              <input type="text" class="form-control" name="telp_cs" id="telp_cs" pattern="\d*" maxlength="13" required>
              <small class="form-text text-muted">Masukkan hanya angka (maksimal 13 digit).</small>
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">Email</label>
              <input type="email" class="form-control" name="email">
              <input type="hidden" class="form-control" name="created" value="<?php echo date('d/m/Y, G:i') ?>">
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">NPWP (Optional)</label>
              <input type="text" class="form-control" name="npwp" maxlength="20">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="simpan-cs" class="btn btn-primary btn-md"><i class="bx bx-save"></i> Simpan Data</button>
            <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal" id="btn-close"><i class="bi bi-x"></i> Tutup</button>
          </div>
      </form>
    </div>
  </div>
</div>
<!-- End Modal Add CS -->


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
  var inputElement = document.getElementById('telp_cs');

  // Menambahkan event listener untuk memeriksa panjang input
  inputElement.addEventListener('input', function(event) {
    // Menghapus karakter selain angka
    this.value = this.value.replace(/\D/g, '');

    // Memeriksa panjang input
    if (this.value.length < 9) {
      inputElement.setCustomValidity('Nomor telepon harus minimal 9 angka.');
    } else {
      inputElement.setCustomValidity('');
    }

    // Memastikan panjang input tidak melebihi 13 karakter
    if (this.value.length > 13) {
      this.value = this.value.slice(0, 13);
    }
  });
</script>
<script>
  var inputElement = document.getElementById('telp');

  // Menambahkan event listener untuk memeriksa panjang input
  inputElement.addEventListener('input', function(event) {
    // Menghapus karakter selain angka
    this.value = this.value.replace(/\D/g, '');

    // Memeriksa panjang input
    if (this.value.length < 9) {
      inputElement.setCustomValidity('Nomor telepon harus minimal 9 angka.');
    } else {
      inputElement.setCustomValidity('');
    }

    // Memastikan panjang input tidak melebihi 13 karakter
    if (this.value.length > 13) {
      this.value = this.value.slice(0, 13);
    }
  });
</script>


<!-- Modal edit -->
<script>
  $('#modal2').on('show.bs.modal', function(event) {
    // Mendapatkan data dari tombol yang ditekan
    var button = $(event.relatedTarget);
    var jenis = button.data('jenis');
    var id = button.data('id');
    var nama = button.data('nama');
    var alamat = button.data('alamat');
    var cp = button.data('cp');
    var telp = button.data('telp');
    var email = button.data('email');
    var npwp = button.data('npwp');
    var modal = $(this);
    var simpanBtn = modal.find('.modal-footer #simpan');
    var jenisInput = modal.find('.modal-body input[name="jenis_usaha"]');
    var jenisRadio = modal.find('.modal-body #jenisRadio');
    var idInput = modal.find('.modal-body #id');
    var namaInput = modal.find('.modal-body #nama');
    var alamatInput = modal.find('.modal-body #alamat');
    var cpInput = modal.find('.modal-body #namaCp');
    var telpInput = modal.find('.modal-body #telp');
    var emailInput = modal.find('.modal-body #email');
    var npwpInput = modal.find('.modal-body #npwp');

    // Menampilkan data
    modal.find('.modal-body').val(id);
    jenisInput.filter('[value="' + jenis + '"]').prop('checked', true);
    idInput.val(id);
    namaInput.val(nama);
    alamatInput.val(alamat);
    cpInput.val(cp);
    telpInput.val(telp);
    emailInput.val(email);
    npwpInput.val(npwp);

    // Pengecekan data, dan button disable atau enable saat data diubah
    // dan data kembali ke nilai awal
    var originalNama = namaInput.val();
    var originalAlamat = alamatInput.val();
    var originalTelp = telpInput.val();
    var originalEmail = emailInput.val();
    var originalCp = cpInput.val();
    var originalNpwp = npwpInput.val();

    // Deklarasikan selectedJenis sesuai dengan jenis yang sedang dipilih
    var selectedJenis = jenis;

    // Menambahkan elemen input jenis ke dalam array inputFields
    var inputFields = [jenisInput, namaInput, alamatInput, telpInput, emailInput, cpInput, npwpInput];

    // Menambahkan event listener untuk setiap input
    inputFields.forEach(function (field) {
        field.on('input', function () {
            var currentJenis = jenisInput.filter(':checked').val();
            var currentNama = namaInput.val();
            var currentAlamat = alamatInput.val();
            var currentTelp = telpInput.val();
            var currentEmail = emailInput.val();
            var currentCp = cpInput.val();
            var currentNpwp = npwpInput.val();

            if (
                currentJenis !== selectedJenis ||
                currentNama !== originalNama ||
                currentAlamat !== originalAlamat ||
                currentTelp !== originalTelp ||
                currentEmail !== originalEmail ||
                currentCp !== originalCp ||
                currentNpwp !== originalNpwp
            ) {
                simpanBtn.prop('disabled', false);
            } else {
                simpanBtn.prop('disabled', true);
            }
        });
    });

    modal.find('form').on('reset', function () {
        simpanBtn.prop('disabled', true);
    });
  });
</script>

<script>
  $(document).ready(function() {
    // Inisialisasi DataTables
    var table = $('#table1').DataTable();
    // Event handler untuk mengisi modal saat tombol .btn-detail diklik
    $('.btn-detail').click(function() {
      var jenis = $(this).data('jenis');
      var cs = $(this).data('cs');
      var email = $(this).data('email');
      var cp = $(this).data('cp');
      var telp = $(this).data('telp');
      var alamat = $(this).data('alamat');
      var npwp = $(this).data('npwp');
      var createdby = $(this).data('createdby');
      var created = $(this).data('created');
      var updatedby = $(this).data('updatedby');
      var updated = $(this).data('updated');

      $('#dataCs').text(cs);
      $('#jenisUsaha').text(jenis);
      $('#dataEmail').text(email);
      $('#namaCp').text(cp);
      $('#dataTelp').text(telp);
      $('#dataAlamat').text(alamat);
      $('#npwp').text(npwp);
      $('#dataCreatedBy').text(createdby);
      $('#dataCreated').text(created);
      $('#dataUpdatedBy').text(updatedby);
      $('#dataUpdated').text(updated);

      $('#detailCs').modal('show'); // Menggunakan ID modal yang benar
    });
    // Event handler untuk memperbarui modal saat DataTables menggambar ulang (pindah halaman)
    table.on('draw.dt', function() {
      // Memperbarui event handler .btn-detail untuk data yang baru dimuat
      $('.btn-detail').off('click'); // Menghapus event handler yang ada
      $('.btn-detail').on('click', function() {
        var jenis = $(this).data('jenis');
        var cs = $(this).data('cs');
        var email = $(this).data('email');
        var cp = $(this).data('cp');
        var telp = $(this).data('telp');
        var alamat = $(this).data('alamat');
        var npwp = $(this).data('npwp');
        var createdby = $(this).data('createdby');
        var created = $(this).data('created');
        var updatedby = $(this).data('updatedby');
        var updated = $(this).data('updated');

        $('#dataCs').text(cs);
        $('#jenisUsaha').text(jenis);
        $('#dataEmail').text(email);
        $('#namaCp').text(cp);
        $('#dataTelp').text(telp);
        $('#dataAlamat').text(alamat);
        $('#npwp').text(npwp);
        $('#dataCreatedBy').text(createdby);
        $('#dataCreated').text(created);
        $('#dataUpdatedBy').text(updatedby);
        $('#dataUpdated').text(updated);

        $('#detailCs').modal('show'); // Menggunakan ID modal yang benar
      });
    });
  });
</script>

<!-- reset form modal -->
<script>
  $(document).ready(function() {
    // Event handler saat tombol "Tutup" di klik
    $('#btn-close').click(function() {
      // Mengosongkan semua input dalam modal
      $('#modal1').find('input[type=text], input[type=email]').val('');
    });
  });
</script>
<!-- End reset form modal -->