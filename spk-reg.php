<?php
$page  = 'transaksi';
$page2 = 'spk';
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
    @media (max-width: 767px) {

      /* Tambahkan aturan CSS khusus untuk tampilan mobile di bawah 767px */
      .col-12.col-md-2 {
        /* Contoh: Mengatur tinggi elemen select pada tampilan mobile */
        height: 50px;
      }
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
      <h1>Dashboard</h1>
    </div><!-- End Page Title -->

    <section class="pagetitle">
      <nav aria-label="breadcrumb">
        <ol class=" breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">SPK</li>
        </ol>
      </nav>
      <div class="card">
        <div class="card-body mt-3">
          <div class="row mt-4 text-center">
            <div class="mb-4" style="width: 180px;">
              <a href="form-create-spk-reg.php" class="btn btn-primary btn-sm p-2"><i class="bi bi-plus-circle"></i> Buat SPK Reguler</a>
            </div>
            <div class="mb-4" style="width: 160px;">
              <a href="form-create-spk-ecat.php" class="btn btn-success btn-sm p-2"><i class="bi bi-plus-circle"></i> Buat SPK E-cat</a>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="mt-4">
          <div class="ps-4">
            <div class="row g-3">
              <div class="col-12">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb" style="font-size: 18px;">
                    <li class="breadcrumb-item active">SPK Reguler</li>
                    <li class="breadcrumb-item"><a style="color: blue;" href="spk-ecat.php">SPK E-Cat</a></li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
          <ul class="nav nav-tabs d-flex ms-3 me-3 justify-content-between" role="tablist" id="myTab" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
              <?php
              $sql_belum_diproses = " SELECT sr.*, cs.nama_cs, cs.alamat
                                        FROM spk_reg AS sr
                                        JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                        WHERE status_spk = 'Belum Diproses'";
              $query_belum_diproses = mysqli_query($connect, $sql_belum_diproses);
              $total_data_belum_diproses = mysqli_num_rows($query_belum_diproses);
              ?>
              <a class="nav-link active">
                Belum Diproses &nbsp;
                <?php if ($total_data_belum_diproses != 0) {
                  echo '<span class="badge text-bg-secondary">' . $total_data_belum_diproses . '</span>';
                }
                ?>
              </a>
            </li>
            <li class="nav-item flex-fill" role="presentation">
              <?php
              $sql_dalam_proses = " SELECT sr.*, cs.nama_cs, cs.alamat
                                        FROM spk_reg AS sr
                                        JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                        WHERE status_spk = 'Dalam Proses'";
              $query_dalam_proses = mysqli_query($connect, $sql_dalam_proses);
              $total_data_dalam_proses = mysqli_num_rows($query_dalam_proses);
              ?>
              <a class="nav-link" href="spk-dalam-proses.php?sort=baru">
                Dalam Proses &nbsp;
                <?php if ($total_data_dalam_proses != 0) {
                  echo '<span class="badge text-bg-secondary">' . $total_data_dalam_proses . '</span>';
                }
                ?>
              </a>
            </li>
            <li class="nav-item flex-fill" role="presentation">
              <?php
              include "koneksi.php";
              $sql_siap_kirim = " SELECT sr.*, cs.nama_cs, cs.alamat
                                    FROM spk_reg AS sr
                                    JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                    WHERE status_spk = 'Siap Kirim'";
              $query_siap_kirim = mysqli_query($connect, $sql_siap_kirim);
              $total_data_siap_kirim = mysqli_num_rows($query_siap_kirim);
              ?>
              <a class="nav-link" href="spk-siap-kirim.php?sort=baru">
                Siap Kirim &nbsp;
                <?php if ($total_data_siap_kirim != 0) {
                  echo '<span class="badge text-bg-secondary">' . $total_data_siap_kirim . '</span>';
                }
                ?>
              </a>
            </li>
            <li class="nav-item flex-fill" role="presentation">
              <?php
              $sql_inv = "SELECT nonppn.*, sr.id_inv, sr.id_customer, sr.no_po, cs.nama_cs, cs.alamat
                                FROM inv_nonppn AS nonppn
                                LEFT JOIN spk_reg sr ON(nonppn.id_inv_nonppn = sr.id_inv)
                                JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                WHERE status_transaksi = 'Belum Dikirim' GROUP BY no_inv";
              $query_inv = mysqli_query($connect, $sql_inv);
              $total_inv_nonppn = mysqli_num_rows($query_inv);
              ?>
              <?php
              $sql_inv_ppn = "SELECT ppn.*, sr.id_inv, sr.id_customer, sr.no_po, cs.nama_cs, cs.alamat
                                FROM inv_ppn AS ppn
                                LEFT JOIN spk_reg sr ON(ppn.id_inv_ppn = sr.id_inv)
                                JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                WHERE status_transaksi = 'Belum Dikirim' GROUP BY no_inv";
              $query_inv_ppn = mysqli_query($connect, $sql_inv_ppn);
              $total_inv_ppn = mysqli_num_rows($query_inv_ppn);
              $hasil = $total_inv_nonppn + $total_inv_ppn;
              ?>
              <a class="nav-link" href="invoice-reguler.php?sort=baru">
                Invoice Sudah Dicetak &nbsp;
                <?php if ($hasil != 0) {
                  echo '<span class="badge text-bg-secondary">' . $hasil . '</span>';
                }
                ?>
              </a>
            </li>
            <li class="nav-item flex-fill" role="presentation">
              <button class="nav-link" id="dikirim-tab" data-bs-toggle="tab" data-bs-target="#dikirim-tab-pane" type="button" role="tab" aria-controls="dikirim-tab-pane" aria-selected="false">Dikirim</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
              <button class="nav-link" id="diterima-tab" data-bs-toggle="tab" data-bs-target="#diterima-tab-pane" type="button" role="tab" aria-controls="diterima-tab-pane" aria-selected="false">Diterima</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
              <button class="nav-link" id="transaksi-selesai-tab" data-bs-toggle="tab" data-bs-target="#transaksi-selesai-tab-pane" type="button" role="tab" aria-controls="transaksi-selesai-tab-pane" aria-selected="false">Transaksi Selesai</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
              <a class="nav-link" href="transaksi-cancel.php">Transaksi Cancel</a>
            </li>
          </ul>
          <div class="card-body bg-body rounded mt-3">
            <!-- Menampilkan Data SPK -->
            <div class="tab-content">
              <!-- Belum diproses -->
              <div class="tab-pane fade show active" id="belum-diproses-tab-pane" role="tabpanel" aria-labelledby="belum-diproses-tab" tabindex="0">
                <div class="card p-3 pt-3">
                  <div class="row mb-3">
                    <div class="col-12 col-md-2"> <!-- Modified: Changed col-2 to col-12 col-md-2 -->
                      <form action="" method="GET">
                        <select name="sort" class="form-select" id="select" aria-label="Default select example" onchange='if(this.value != 0) { this.form.submit(); }'>
                          <option value="baru" <?php if (isset($_GET['sort']) && $_GET['sort'] == "baru") {
                                                  echo "selected";
                                                } ?>>Paling Baru</option>
                          <option value="lama" <?php if (isset($_GET['sort']) && $_GET['sort'] == "lama") {
                                                  echo "selected";
                                                } ?>>Paling Lama</option>
                        </select>
                      </form>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="tableA">
                      <thead>
                        <tr class="text-white" style="background-color: navy;">
                          <th class="text-center p-3" style="width: 30px">No</th>
                          <th class="text-center p-3" style="width: 150px">No. SPK</th>
                          <th class="text-center p-3" style="width: 150px">Tgl. SPK</th>
                          <th class="text-center p-3" style="width: 150px">No. PO</th>
                          <th class="text-center p-3" style="width: 200px">Nama Customer</th>
                          <th class="text-center p-3" style="width: 150px">Note</th>
                          <th class="text-center p-3" style="width: 150px">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        include "koneksi.php";
                        $no = 1;
                        $filter = '';
                        if (isset($_GET['sort'])) {
                          if ($_GET['sort'] == "baru") {
                            $filter = "ORDER BY tgl_spk DESC";
                          } elseif ($_GET['sort'] == "lama") {
                            $filter = "ORDER BY tgl_spk ASC";
                          }
                        }
                        $sql = "SELECT sr.*, cs.nama_cs, cs.alamat
                      FROM spk_reg AS sr
                      JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                      WHERE status_spk = 'Belum Diproses' $filter";
                        $query = mysqli_query($connect, $sql);
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                          <tr>
                            <td class="text-center"><?php echo $no; ?></td>
                            <td><?php echo $data['no_spk'] ?></td>
                            <td><?php echo $data['tgl_spk'] ?></td>
                            <td><?php echo $data['no_po'] ?></td>
                            <td><?php echo $data['nama_cs'] ?></td>
                            <td><?php echo $data['note'] ?></td>
                            <td class="text-center">
                              <a href="detail-produk-spk-reg.php?id=<?php echo base64_encode($data['id_spk_reg']) ?>" id="detail-spk" class="btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i> Lihat Produk</a>
                              <p></p>
                              <a href="#" data-bs-toggle="modal" data-bs-target="#cancelModal" class="btn btn-danger btn-sm"><i class="bi bi-x-circle"></i> Cancel Order</a>
                            </td>
                            <!-- Modal -->
                            <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h4><strong>Silahkan Isi Alasan</strong></h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <form action="proses/proses-produk-spk-reg.php" method="POST">
                                      <div class="mb-3">
                                        <input type="hidden" name="id_spk" value="<?php echo $data['id_spk_reg'] ?>">
                                        <Label>Alasan Cancel</Label>
                                        <input type="text" class="form-control" name="alasan" required>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" name="cancel-belum-diproses">Ya, Cancel Transaksi</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </tr>
                          <?php $no++ ?>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
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

<script>
  $(document).ready(function() {
    var table = $('#tableA').DataTable({
      "lengthChange": false,
      "ordering": false,
      "autoWidth": false
    });
  });
  $(document).ready(function() {
    var table = $('#tableB').DataTable({
      "lengthChange": false,
      "ordering": false,
      "autoWidth": false
    });
  });
  $(document).ready(function() {
    var table = $('#tableC').DataTable({
      "lengthChange": false,
      "ordering": false,
      "autoWidth": false
    });
  });
  $(document).ready(function() {
    var table = $('#tableD').DataTable({
      "lengthChange": false,
      "ordering": false,
      "autoWidth": false
    });
  });
  $(document).ready(function() {
    var table = $('#tableE').DataTable({
      "lengthChange": false,
      "ordering": false,
      "autoWidth": false
    });
  });
  $(document).ready(function() {
    var table = $('#tableF').DataTable({
      "lengthChange": false,
      "ordering": false,
      "autoWidth": false
    });
  });
  $(document).ready(function() {
    var table = $('#tableG').DataTable({
      "lengthChange": false,
      "ordering": false,
      "autoWidth": false
    });
  });
</script>

<script>
  $(document).ready(function() {
    $("#select").change(function() {
      var open = $(this).data("isopen");
      if (open) {
        window.location.href = $(this).val();
      }
      //set isopen to opposite so next time when user clicks select box
      //it won't trigger this event
      $(this).data("isopen", !open);
    });
  });
</script>