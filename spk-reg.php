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
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">SPK</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section>
      <div class="container-fluid">
        <div class="card">
          <div class="card-body mt-3">
            <a href="form-create-spk-reg.php" class="btn btn-primary btn-sm p-2"><i class="bi bi-plus-circle"></i> Buat SPK Reguler</a>
            <a href="form-create-spk-ecat.php" class="btn btn-success btn-sm p-2"><i class="bi bi-plus-circle"></i> Buat SPK E-cat</a>
          </div>
        </div>
        <div class="card">
          <div class="card-body mt-3">
            <div class="card-body">
              <div class="row g-3">
                <div class="col-7">
                  <nav>
                    <ol class="breadcrumb" style="font-size: 15px;">
                      <li class="breadcrumb-item active">SPK Reguler</li>
                      <li class="breadcrumb-item"><a style="color: blue;" href="spk-ecat.php">SPK E-Cat</a></li>
                    </ol>
                  </nav>
                </div>
              </div>
            </div>
            <ul class="nav nav-tabs d-flex" role="tablist" id="myTab" role="tablist">
              <li class="nav-item flex-fill" role="presentation">
                <a class="nav-link active">Belum Diproses</a>
              </li>
              <li class="nav-item flex-fill" role="presentation">
                <a class="nav-link" href="spk-dalam-proses.php?sort=baru">Dalam Proses</a>
              </li>
              <li class="nav-item flex-fill" role="presentation">
                <a class="nav-link" href="spk-siap-kirim.php?sort=baru">Siap Kirim</a>
              </li>
              <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link" id="dicetak-tab" data-bs-toggle="tab" data-bs-target="#dicetak-tab-pane" type="button" role="tab" aria-controls="dicetak-tab-pane" aria-selected="false">Invoice Sudah Dicetak</button>
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
                  <div class="card-body pt-3">
                    <div class="row mb-3">
                      <div class="col-2">
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
                                <a href="detail-produk-spk-reg.php?id=<?php echo base64_encode($data['id_spk_reg']) ?>" id="detail-spk" class="btn btn-primary btn-sm mb-2"><i class="bi bi-eye-fill"></i> Lihat Produk</a>
                              </td>
                            </tr>
                            <?php $no++ ?>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <!-- End Belum diproses -->
                <!-- ================================================ -->

                <!-- Dalam Proses -->

                <!-- Siap Kirim -->
                <div class="tab-pane fade mb-3" id="siap-kirim-tab-pane" role="tabpanel" aria-labelledby="siap-kirim-tab" tabindex="0">
                  <div class="card-body pt-3">
                    <div class="row">
                      <div class="col-2">
                        <select class="form-select" aria-label="Default select example">
                          <option value="1">Paling Baru</option>
                          <option value="2">Paling Lama</option>
                        </select>
                      </div>
                      <div class="col-6">
                        <button class="btn btn-primary btn-md" id="checkButton-nonppn">Create Invoice Non PPN</button>
                        <button class="btn btn-secondary btn-md" id="checkButton-ppn">Buat Invoice PPN</button>
                      </div>
                    </div>
                    <div class="table-responsive">
                      <form action="test.php" method="post">
                        <table class="table table-striped table-bordered" id="table2" style="width:100%">
                          <thead>
                            <tr class="text-white bg-secondary">
                              <td class="text-center" style="width: 80px">Pilih</td>
                              <td class="text-center" style="width: 80px">No</td>
                              <td class="text-center" style="width: 150px">No.SPK</td>
                              <td class="text-center" style="width: 150px">No.PO</td>
                              <td class="text-center" style="width: 250px">Nama Pelanggan</td>
                              <td class="text-center" style="width: 300px">Alamat</td>
                              <td class="text-center" style="width: 150px">Tanggal</td>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="text-center"><input type="checkbox" name="" value="Ibu Melly"></td>
                              <td class="text-center">1</td>
                              <td class="text-center">SPK/001/01/2023</td>
                              <td class="text-center">PO-001</td>
                              <td class="">Ibu Melly</td>
                              <td class="">Jakarta</td>
                              <td class=" text-center">01 Jan 2023</td>
                            </tr>
                            <tr>
                              <td class="text-center"><input type="checkbox" name="" value="Ibu Jhon"></td>
                              <td class="text-center">2</td>
                              <td class="text-center">SPK/001/01/2023</td>
                              <td class="text-center">PO-001</td>
                              <td class="">Ibu Jhon</td>
                              <td class="">Jakarta</td>
                              <td class=" text-center">01 Jan 2023</td>
                            </tr>
                            <tr>
                              <td class="text-center"><input type="checkbox" name="" value="Ibu Melly"></td>
                              <td class="text-center">3</td>
                              <td class="text-center">SPK/001/01/2023</td>
                              <td class="text-center">PO-001</td>
                              <td class="">Ibu Melly</td>
                              <td class="">Jakarta</td>
                              <td class=" text-center">01 Jan 2023</td>
                            </tr>
                            <tr>
                              <td class="text-center"><input type="checkbox" name="" value="Ibu Jhon"></td>
                              <td class="text-center">4</td>
                              <td class="text-center">SPK/001/01/2023</td>
                              <td class="text-center">PO-001</td>
                              <td class="">Ibu Jhon</td>
                              <td class="">Jakarta</td>
                              <td class=" text-center">01 Jan 2023</td>
                            </tr>
                            <tr>
                              <td class="text-center"><input type="checkbox" name="" value="Ibu Melly"></td>
                              <td class="text-center">5</td>
                              <td class="text-center">SPK/001/01/2023</td>
                              <td class="text-center">PO-001</td>
                              <td class="">Ibu Melly</td>
                              <td class="">Jakarta</td>
                              <td class=" text-center">01 Jan 2023</td>
                            </tr>
                            <tr>
                              <td class="text-center"><input type="checkbox" name="" value="Ibu Jhon"></td>
                              <td class="text-center">6</td>
                              <td class="text-center">SPK/001/01/2023</td>
                              <td class="text-center">PO-001</td>
                              <td class="">Ibu Jhon</td>
                              <td class="">Jakarta</td>
                              <td class=" text-center">01 Jan 2023</td>
                            </tr>
                            <tr>
                              <td class="text-center"><input type="checkbox" name="" value="Ibu Melly"></td>
                              <td class="text-center">7</td>
                              <td class="text-center">SPK/001/01/2023</td>
                              <td class="text-center">PO-001</td>
                              <td class="">Ibu Melly</td>
                              <td class="">Jakarta</td>
                              <td class=" text-center">01 Jan 2023</td>
                            </tr>
                            <tr>
                              <td class="text-center"><input type="checkbox" name="" value="Ibu Melly"></td>
                              <td class="text-center">7</td>
                              <td class="text-center">SPK/001/01/2023</td>
                              <td class="text-center">PO-001</td>
                              <td class="">Ibu Melly</td>
                              <td class="">Jakarta</td>
                              <td class=" text-center">01 Jan 2023</td>
                            </tr>
                            <tr>
                              <td class="text-center"><input type="checkbox" name="" value="Ibu Melly"></td>
                              <td class="text-center">7</td>
                              <td class="text-center">SPK/001/01/2023</td>
                              <td class="text-center">PO-001</td>
                              <td class="">Ibu Melly</td>
                              <td class="">Jakarta</td>
                              <td class=" text-center">01 Jan 2023</td>
                            </tr>
                          </tbody>
                        </table>
                      </form>
                    </div>
                  </div>
                </div>
                <script>
                  // Get the "Create Invoice Non PPN" button
                  const btnNonPPN = document.getElementById("checkButton-nonppn");

                  // Get all the checkboxes in the table
                  const checkboxes5 = document.querySelectorAll("#table2 tbody input[type='checkbox']");

                  // Add a click event listener to each checkbox
                  checkboxes5.forEach((checkbox) => {
                    checkbox.addEventListener("click", () => {
                      // Get the number of checkboxes that are checked
                      const checkedCount = document.querySelectorAll("#table2 tbody input[type='checkbox']:checked").length;

                      // Disable the "Create Invoice Non PPN" button if more than 5 checkboxes are checked
                      if (checkedCount > 5) {
                        btnNonPPN.disabled = true;
                      } else {
                        btnNonPPN.disabled = false;
                      }
                    });
                  });
                </script>

                <script>
                  let checkboxes = document.querySelectorAll('input[type="checkbox"]');
                  let checkButton1 = document.querySelector('#checkButton-nonppn');

                  checkButton1.addEventListener('click', () => {
                    let values = new Set();
                    checkboxes.forEach(checkbox => {
                      if (checkbox.checked) {
                        values.add(checkbox.value);
                      }
                    });
                    if (values.size === 0) {
                      alert('No checkboxes are checked.');
                    } else if (values.size === 1) {
                      let nextPage = 'form-invoice-nonppn.php'; // replace with the URL of the next page
                      window.location.href = nextPage;
                    } else {
                      alert('Nama customer berbeda, silahkan pilih data customer yang sama');
                    }
                  });
                </script>
                <script>
                  let checkboxes2 = document.querySelectorAll('input[type="checkbox"]');
                  let checkButton2 = document.querySelector('#checkButton-ppn');

                  checkButton2.addEventListener('click', () => {
                    let values = new Set();
                    checkboxes2.forEach(checkbox => {
                      if (checkbox.checked) {
                        values.add(checkbox.value);
                      }
                    });
                    if (values.size === 0) {
                      alert('No checkboxes are checked.');
                    } else if (values.size === 1) {
                      let nextPage = 'form-invoice-ppn.php'; // replace with the URL of the next page
                      window.location.href = nextPage;
                    } else {
                      alert('Nama customer berbeda, silahkan pilih data customer yang sama');
                    }
                  });
                </script>
                <script>
                  let checkboxes3 = document.querySelectorAll('input[type="checkbox"]');
                  let checkButton3 = document.querySelector('#checkButton-nonppn');

                  checkboxes3.forEach(checkbox => {
                    checkbox.addEventListener('change', () => {
                      let values = new Set();
                      checkboxes3.forEach(cb => {
                        if (cb.checked) {
                          values.add(cb.value);
                        }
                      });
                      if (values.size === 0 || values.size > 1) {
                        checkButton3.disabled = true;
                      } else {
                        checkButton3.disabled = false;
                      }
                    });
                  });
                </script>
                <!-- End Siap Kirim -->
                <!-- ================================================ -->

                <!-- Inv Sudah dicetak -->
                <div class="tab-pane fade" id="dicetak-tab-pane" role="tabpanel" aria-labelledby="dicetak-tab" tabindex="0">Invoice Sudah Dicetak</div>
                <!-- End Inv Sudah Dicetak -->
                <!-- ================================================ -->

                <!-- Dikirim -->
                <div class="tab-pane fade" id="dikirim-tab-pane" role="tabpanel" aria-labelledby="dikirim-tab" tabindex="0">Dikirim</div>
                <!-- End Dikirim -->
                <!-- ================================================ -->

                <!-- Diterima -->
                <div class="tab-pane fade" id="diterima-tab-pane" role="tabpanel" aria-labelledby="diterima-tab" tabindex="0">Diterima</div>
                <!-- End Diterima -->
                <!-- ================================================ -->

                <!-- Transaksi Selesai -->
                <div class="tab-pane fade" id="transaksi-selesai-tab-pane" role="tabpanel" aria-labelledby="transaksi-selesai-tab" tabindex="0">Transaksi Selesai</div>
                <!-- End Transaksi Selesai -->
                <!-- ================================================ -->
              </div>
              <!-- End Menampilkan Data SPK -->
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
<!-- pagination -->
<script src="assets/js/pagination.js"></script>

<!-- search -->
<script src="assets/js/search.js"></script>

<!-- sort data -->
<script src="assets/js/sorting.js"></script>

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