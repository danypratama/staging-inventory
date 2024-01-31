<?php
$page = 'list-tagihan';
$page2 = 'tagihan-pembelian';
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
    <section class="section dashboard">
        <div class="card">
            <div class="card-header text-center">
                <h5><strong>Form Pembelian Barang Lokal</strong></h5>
            </div>
            <div class="card-body p-3">
                <form action="" method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="fw-bold">No Transaksi Pembelian</label>
                                <input type="text" class="form-control" name="no_trx" id="">
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold">Tanggal Pembelian</label>
                                <input type="text" class="form-control" name="tanggal" id="date">
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold">No Invoice Pembelian</label>
                                <input type="text" class="form-control" name="no_inv" id="">
                            </div>
                            <div class="col-mb-3">
                                <label class="fw-bold mb-2">Jenis Transaksi</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_trx" value="PPN">
                                    <label class="form-check-label" for="inlineRadio1">PPN</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_trx" value="Non PPN">
                                    <label class="form-check-label" for="inlineRadio2">Non PPN</label>
                                </div>
                            </div>
                            <div class="mb-3 mt-2">
                                <label class="fw-bold">Tanggal Jatuh Tempo</label>
                                <div class="input-group flex-nowrap">
                                    <input type="text" class="form-control" name="tanggal_tempo" id="date">
                                    <button class="input-group-text bg-danger text-white" id="addon-wrapping"> X </button>
                                </div>
                            </div>
                            <div class="col-mb-3">
                                <label class="fw-bold mb-2">Jenis Diskon</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_diskon" id="inlineRadio1" value="Tanpa Diskon">
                                    <label class="form-check-label" for="inlineRadio1">Tanpa Diskon</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_diskon" id="inlineRadio2" value="Diskon Satuan">
                                    <label class="form-check-label" for="inlineRadio2">Diskon Satuan</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_diskon" id="inlineRadio2" value="Spesial Diskon">
                                    <label class="form-check-label" for="inlineRadio2">Spesial Diskon</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="fw-bold">Nama Supllier</label>
                                <input type="hidden" class="form-control" name="id_sp" id="id_sp">
                                <input type="text" class="form-control" id="nama_sp" data-bs-toggle="modal" data-bs-target="#modalSp" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold">Alamat Supplier</label>
                                <textarea class="form-control" id="alamat_sp" rows="5" readonly></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold">Note Pembelian</label>
                                <textarea class="form-control" name="note" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
  </main><!-- End #main -->

  <!-- Modal -->
  <div class="modal fade" id="modalSp" tabindex="-1">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Data Supplier</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <style>
                      .wrap-text {
                          max-width: 300px; /* Contoh lebar maksimum */
                          overflow: hidden; /* Sembunyikan teks yang melebihi max-width */
                          white-space: pre-line; /* Tetapkan spasi putih dan pecah baris sesuai dengan teks */
                          word-wrap: break-word; /* Pecah kata jika melebihi max-width */
                      }
                      @media (max-width: 767px) { /* Media query untuk tampilan mobile */
                          .wrap-text {
                              min-width: 400px; /* Contoh lebar maksimum */
                              overflow: hidden; /* Sembunyikan teks yang melebihi max-width */
                              white-space: pre-line; /* Tetapkan spasi putih dan pecah baris sesuai dengan teks */
                              word-wrap: break-word; /* Pecah kata jika melebihi max-width */
                          }
                      }
                  </style>
                  <div class="card p-3">
                      <div class="table-responsive">
                          <table class="table table-hover table-striped table-bordered" id="table2">
                          <thead>
                              <tr class="text-white" style="background-color: navy;">
                                <td class="col-4 text-nowrap">Nama Supplier</td>
                                <td class="col-6 text-nowrap">Alamat Supplier</td>
                              </tr>
                          </thead>
                          <tbody>
                              <?php
                              include "koneksi.php";
                              $sql_cs = "SELECT * FROM tb_supplier";
                              $query_cs = mysqli_query($connect, $sql_cs);
                              while ($data_cs = mysqli_fetch_array($query_cs)) {
                              ?>
                              <tr data-id="<?php echo $data_cs['id_sp'] ?>" data-nama="<?php echo $data_cs['nama_sp'] ?>" data-alamat="<?php echo $data_cs['alamat'] ?>" data-bs-dismiss="modal">
                                  <td><?php echo $data_cs['nama_sp'] ?></td>
                                  <td class="wrap-text"><?php echo $data_cs['alamat'] ?></td>
                              </tr>
                              <?php } ?>
                          </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- End Large Modal-->

  <!-- Footer -->
  <?php include "page/footer.php" ?>
  <!-- End Footer -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include "page/script.php" ?>
</body>

</html>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var resetButton = document.getElementById("resetTempo");
        var inputTanggalTempo = document.getElementsByName("tanggal_tempo")[0];

        // Mendengarkan klik pada tombol resetTempo
        resetButton.addEventListener("click", function () {
            // Mereset nilai input tanggal_tempo menjadi kosong
            inputTanggalTempo.value = "";
        });
    });
</script>

<!-- Script Select Data Supplier -->
<script>
  $(document).on('click', '#table2 tbody tr', function(e) {
    $('#id_sp').val($(this).data('id'));
    $('#nama_sp').val($(this).data('nama'));
    $('#alamat_sp').val($(this).data('alamat'));
    $('#modalCs').modal('hide');
  });
</script>
