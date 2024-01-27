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
  <style>
    #modal2{
      cursor: pointer;
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
            <?php  
               include "koneksi.php";
               $id_role = $_SESSION['tiket_role'];
               $sql_role = "SELECT * FROM user_role WHERE id_user_role='$id_role'";
               $query_role = mysqli_query($connect, $sql_role) or die(mysqli_error($connect));
               $data_role = mysqli_fetch_array($query_role);
               if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Manager Gudang") { 
                ?>
                  <a href="#" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#modal1"><i class="bi bi-plus-circle"></i> Tambah data kategori produk</a>
                <?php 
               }
            ?>
            <div class="table-responsive mt-3">
              <table class="table table-striped table-bordered" id="table1">
                <thead>
                  <tr class="text-white" style="background-color: #051683;">
                    <td class="text-center p-3 text-nowrap">No</td>
                    <td class="text-center p-3 text-nowrap">Nama Kategori Produk</td>
                    <td class="text-center p-3 text-nowrap">Merk</td>
                    <td class="text-center p-3 text-nowrap">Nomor Izin Edar</td>
                    <td class="text-center p-3 text-nowrap">Tgl. Terbit</td>
                    <td class="text-center p-3 text-nowrap">Tgl. Berlaku Sampai</td>
                    <td class="text-center p-3 text-nowrap">Sisa Waktu Perpanjangan</td>
                    <?php  
                      if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Manager Gudang") { 
                        ?>
                            <td class="text-center p-3 text-nowrap">Aksi</td>
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
                  $sql = "  SELECT 
                                tkp.id_kat_produk, 
                                tkp.nama_kategori, 
                                tkp.no_izin_edar, 
                                tkp.tgl_terbit,
                                tkp.berlaku_sampai,
                                DATE_FORMAT(STR_TO_DATE(tkp.berlaku_sampai, '%d/%m/%Y'), '%Y-%m-%d') AS tanggal_berlaku_sampai,
                                mr.nama_merk
                            FROM 
                                tb_kat_produk AS tkp
                            LEFT JOIN 
                                tb_merk AS mr ON tkp.id_merk = mr.id_merk
                            ORDER BY 
                                tkp.nama_kategori ASC";
                  $query = mysqli_query($connect, $sql) or die(mysqli_error($connect));
                  while ($data = mysqli_fetch_array($query)) {
                    $id_kat = base64_encode($data['id_kat_produk']);
                    $tanggal_awal = new DateTime();
                    $tanggal_awal->setTime(0, 0, 0);  // Set waktu ke 00:00:00

                    if ($data['berlaku_sampai'] == '') {
                        $selisih = "Tanggal Berlaku Tidak Ada";
                    } else {
                        // Tanggal akhir dari data yang diambil dari database
                        $tanggal_berlaku_sampai = DateTime::createFromFormat('Y-m-d', $data['tanggal_berlaku_sampai']);
                        $tanggal_berlaku_sampai->setTime(0, 0, 0);  // Set waktu ke 00:00:00

                        // Menghitung selisih waktu
                        $selisih = $tanggal_awal->diff($tanggal_berlaku_sampai);

                        // Menyimpan selisih ke dalam variabel dengan nama yang diinginkan
                        $sisa_tahun = $selisih->y;
                        $sisa_bulan = $selisih->m;
                        $sisa_hari = $selisih->d;
                    }

                  ?>
                    <tr>
                      <td class="text-center text-nowrap"><?php echo $no; ?></td>
                      <td class="text-nowrap"><?php echo $data['nama_kategori'] ?></td>
                      <td class="text-center text-nowrap"><?php echo $data['nama_merk'] ?></td>
                      <td class="text-center text-nowrap"><?php echo $data['no_izin_edar'] ?></td>
                      <td class="text-center text-nowrap"><?php echo $data['tgl_terbit'] ?></td>
                      <td class="text-center text-nowrap">
                        <?php 
                          if ($data['berlaku_sampai'] == '') {
                            echo 'Tanggal Berlaku Tidak Ada';
                          } else {
                            echo $data['berlaku_sampai'];
                          }
                        ?>
                      
                      </td>
                      <td class="text-center text-nowrap">
                        <?php
                          if ($data['berlaku_sampai'] == '') {
                              echo 'Tanggal Berlaku Tidak Ada';
                          } else if ($sisa_tahun == '0' && $sisa_bulan == '0' && $sisa_hari == '0') {
                              echo "Expired";
                          } else if ($sisa_tahun == '0' && $sisa_bulan == '0') {
                              echo $sisa_hari . ' Hari';
                          } else if ($sisa_tahun == '0' && $sisa_hari == '0') {
                              echo $sisa_bulan . ' Bulan';
                          } else if ($sisa_bulan == '0') {
                              echo $sisa_tahun . ' Tahun ' . $sisa_hari . ' Hari';
                          } else if ($sisa_tahun != '0' && $sisa_bulan != '0' && $sisa_hari != '0') {
                              echo $sisa_tahun . ' Tahun ' . $sisa_bulan . ' Bulan ' . $sisa_hari . ' Hari';
                          } else {
                              echo $sisa_bulan . ' Bulan ' . $sisa_hari . ' Hari';
                          }
                        ?>
                      </td>
                      <?php  
                        if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Manager Gudang") { 
                          ?>
                            <td class="text-center text-nowrap">
                              <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal2" data-id="<?php echo $data['id_kat_produk']; ?>" data-nama="<?php echo $data['nama_kategori']; ?>" data-merk="<?php echo $data['nama_merk'] ?>" data-nie="<?php echo $data['no_izin_edar'] ?>" data-terbit="<?php echo $data['tgl_terbit'] ?>" data-exp="<?php echo $data['berlaku_sampai'] ?>">
                                <i class="bi bi-pencil"></i>
                              </button>
                              <a href="proses/proses-kat-produk.php?hapus-kat-produk=<?php echo $id_kat ?>" class="btn btn-danger btn-sm delete-data"><i class="bi bi-trash"></i></a>
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
    </section>
  </main><!-- End #main -->
  <!-- Footer -->
  <?php include "page/footer.php" ?>
  <!-- End Footer -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include "page/script.php" ?>
</body>
</html>
<!-- Modal Edit -->
<div class="modal fade" id="modal2" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Edit Data Kategori Produk</h1>
      </div>
      <form action="proses/proses-kat-produk.php" method="POST">
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nama Kategori Produk</label>
            <input type="hidden" class="form-control" name="id_kat_produk" id="id_kat_produk" value="">
            <input type="text" class="form-control" name="nama_kat_produk" id="nama_kategori" required>
          </div>
          <div class="mb-3">
            <label>Merk</label>
            <input type="text" class="form-control bg-light" name="merk" id="merk" data-bs-toggle="modal" data-bs-target="#ubahMerk" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label">Nomor Izin Edar</label>
            <input type="text" class="form-control" name="no_izin_edar" id="nie" required>
            <input type="hidden" class="form-control" name="updated" value="<?php echo date('d/m/Y, G:i') ?>">
            <input type="hidden" class="form-control" name="user_updated" value="<?php echo $_SESSION['tiket_id'] ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Tgl. Terbit</label>
            <input type="text" class="form-control" name="tgl_terbit" id="terbit">
          </div>
          <div class="mb-3">
            <label class="form-label">Tgl. Berlaku Sampai</label>
            <input type="text" class="form-control" name="exp_date" id="exp">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="edit-kat-produk" id="simpan" class="btn btn-primary btn-md" disabled><i class="bx bx-save"></i> Simpan Perubahan</button>
          <button type="button" class="btn btn-secondary btn-md" id="tutupModal2"><i class="bi bi-x"></i> Tutup</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Modal Edit -->

<!-- Modal pilih merk -->
<div class="modal fade" id="ubahMerk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Pilih Merk</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="table2">
                <thead>
                    <tr>
                        <th>Merk</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  
                      include "koneksi.php";
                      $no = 1;
                      $sql_merk = mysqli_query($connect, "SELECT nama_merk FROM tb_merk");
                      while($data_merk = mysqli_fetch_array($sql_merk)){
                    ?>
                    <tr data-merk="<?php echo $data_merk['nama_merk']; ?>">
                        <td><?php echo $data_merk['nama_merk']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

 <!-- Modal Input -->
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
                <select class="form-select" name="merk" required>
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
              <div class="mb-3">
                <label class="form-label">Tgl. Terbit</label>
                <input type="date" class="form-control" name="tgl_terbit" id="terbit" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Berlaku Sampai</label>
                <input type="date" class="form-control" name="expired_date" id="exp" required>
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
  <!-- End Modal input -->

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


<!-- Script Untuk Modal Edit -->
<script>
    $('#ubahMerk').on('show.bs.modal', function () {
        // Check if modal2 is open, if yes, hide it
        if ($('#modal2').hasClass('show')) {
            $('#modal2').modal('hide');
        }
    });

    $('#modal2').on('hide.bs.modal', function (e) {
        // Prevent #modal2 from closing
        e.preventDefault();
    });

    $('#ubahMerk').on('hidden.bs.modal', function () {
        // Show modal2 when ubahMerk is hidden
        $('#modal2').modal('show');
    });

   
    document.getElementById('tutupModal2').addEventListener('click', function() {
      // Reload halaman
      location.reload();
    });

    // select lokasi
    $(document).on('click', '#table2 tbody tr', function (e) {
      var selectedMerk = $(this).data('merk');
      $('#merk').val(selectedMerk).trigger('input'); // Trigger event input setelah mengubah nilai
      $('#ubahMerk').modal('hide');
    });
</script>





<script>
  // delete button
  $("#table1").on("click", ".delete-button", function() {
    $(this).closest("tr").remove();
    if ($("#table1 tbody tr").length === 0) {
      $("#table1 tbody").append("<tr><td colspan='5' align='center'>Data not found</td></tr>");
    }
  });
</script>

<script>
   flatpickr("#exp", {
        dateFormat: "d/m/Y"
    });
    flatpickr("#terbit", {
        dateFormat: "d/m/Y"
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
    var terbit = button.data('terbit');
    var exp = button.data('exp');
    var modal = $(this);
    var simpanBtn = modal.find('.modal-footer #simpan');
    var namaInput = modal.find('.modal-body #nama_kategori');
    var merkInput = modal.find('.modal-body #merk'); // Corrected ID for merk select
    var nieInput = modal.find('.modal-body #nie');
    var terbitInput = modal.find('.modal-body #terbit'); // Corrected ID for exp input
    var expInput = modal.find('.modal-body #exp'); // Corrected ID for exp input

    modal.find('.modal-body #id_kat_produk').val(id);
    namaInput.val(nama);
    merkInput.val(merk);
    nieInput.val(nie);
    terbitInput.val(terbit);
    expInput.val(exp);

    // Pengecekan data, dan buttun disable or enable saat data di ubah
    // dan data kembali ke nilai awal
    var originalNama = namaInput.val();
    var originalMerk = merkInput.val();
    var originalNie = nieInput.val();
    var originalTerbit = terbitInput.val();
    var originalExp = expInput.val();

    namaInput.on('input', function() {
      var currentNama = $(this).val();
      var currentMerk = merkInput.val();
      var currentNie = nieInput.val();
      var currentTerbit = terbitInput.val();
      var currentExp = expInput.val();

      if (currentNama != originalNama || currentMerk != originalMerk || currentNie != originalNie || currentTerbit != originalTerbit || currentExp != originalExp) {
        simpanBtn.prop('disabled', false);
      } else {
        simpanBtn.prop('disabled', true);
      }
    });

    nieInput.on('input', function() {
      var currentNie = $(this).val();
      var currentNama = namaInput.val();
      var currentMerk = merkInput.val();
      var currentTerbit = terbitInput.val();
      var currentExp = expInput.val();

      if (currentNama != originalNama || currentMerk != originalMerk || currentNie != originalNie || currentTerbit != originalTerbit || currentExp != originalExp) {
        simpanBtn.prop('disabled', false);
      } else {
        simpanBtn.prop('disabled', true);
      }
    });

    merkInput.on('input', function() {
      var currentMerk = $(this).val();
      var currentNama = namaInput.val();
      var currentNie = nieInput.val();
      var currentTerbit = terbitInput.val();
      var currentExp = expInput.val();

      if (currentNama !== originalNama || currentMerk !== originalMerk || currentNie !== originalNie || currentTerbit != originalTerbit || currentExp !== originalExp) {
        simpanBtn.prop('disabled', false);
      } else {
        simpanBtn.prop('disabled', true);
      }
    });

    terbitInput.on('input', function() {
      var currentTerbit = $(this).val();
      var currentNama = namaInput.val();
      var currentNie = nieInput.val();
      var currentExp = expInput.val();
      var currentMerk = merkInput.val();

      if (currentNama != originalNama || currentMerk != originalMerk || currentNie != originalNie || currentTerbit != originalTerbit || currentExp != originalExp) {
        simpanBtn.prop('disabled', false);
      } else {
        simpanBtn.prop('disabled', true);
      }
    });

    expInput.on('input', function() {
      var currentExp = $(this).val();
      var currentNama = namaInput.val();
      var currentNie = nieInput.val();
      var currentTerbit = terbitInput.val();
      var currentMerk = merkInput.val();

      if (currentNama != originalNama || currentMerk != originalMerk || currentNie != originalNie || currentTerbit != originalTerbit || currentExp != originalExp) {
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