<?php
$page = 'data';
$page2 = 'data-produk';
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
    #table2 {
      cursor: pointer;
    }

    #table3 {
      cursor: pointer;
    }

    .fileUpload {
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .fileUpload input.upload {
      position: absolute;
      top: 0;
      right: 0;
      margin: 0;
      padding: 0;
      font-size: 20px;
      width: 10px;
      cursor: pointer;
      opacity: 0;
      filter: alpha(opacity=0);
    }

    input[type="text"]:read-only {
      background: #e9ecef;
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

  <?php  
    include "koneksi.php";
    $id_role = $_SESSION['tiket_role'];
    $sql_role = "SELECT * FROM user_role WHERE id_user_role='$id_role'";
    $query_role = mysqli_query($connect, $sql_role) or die(mysqli_error($connect));
    $data_role = mysqli_fetch_array($query_role);
    if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Manager Gudang" || $data_role['role'] == "Admin Penjualan") { 
      ?>
          <main id="main" class="main">
            <section>
              <div class="container">
                <div class="card">
                  <div class="card-header text-center">
                    <h5>Edit Produk Reguler</h5>
                  </div>
                  <div class="card-body">
                    <form action="proses/proses-produk-reg.php" method="POST" enctype="multipart/form-data">
                      <div class="modal-body">
                        <div class="mb-3">
                          <?php
                          //tangkap URL dengan $_GET
                          $ide = base64_decode($_GET['edit-data']);

                          //mengambil nama gambar yang terkait
                          $sql = "SELECT 
                                    pr.id_produk_reg, pr.kode_produk, pr.nama_produk, pr.kode_katalog, pr.satuan, pr.harga_produk, pr.gambar,
                                    mr.id_merk, mr.nama_merk,
                                    kp.id_kat_produk, kp.nama_kategori as kat_prod,
                                    kj.id_kat_penjualan, kj.nama_kategori as kat_penj,
                                    gr.id_grade, gr.nama_grade,
                                    lok.id_lokasi, lok.nama_lokasi,
                                    lok.no_lantai, lok.nama_area, lok.no_rak
                                  FROM tb_produk_reguler as pr
                                  LEFT JOIN tb_merk mr ON (pr.id_merk = mr.id_merk)
                                  LEFT JOIN tb_kat_produk kp ON (pr.id_kat_produk = kp.id_kat_produk)
                                  LEFT JOIN tb_kat_penjualan kj ON (pr.id_kat_penjualan = kj.id_kat_penjualan)
                                  LEFT JOIN tb_produk_grade gr ON (pr.id_grade = gr.id_grade)
                                  LEFT JOIN tb_lokasi_produk lok ON (pr.id_lokasi = lok.id_lokasi)
                                  WHERE pr.id_produk_reg = '$ide'";
                          $result = mysqli_query($connect, $sql);
                          $row = mysqli_fetch_array($result);
                          $img = $row['gambar'];
                          $no_img = $row["gambar"] == "" ? "gambar/upload-produk-reg/no-image.png" : "gambar/upload-produk-reg/$img";
                          ?>
                          <div class="mb-3">
                            <label class="form-label"><strong>Kode Produk</strong></label>
                            <input type="hidden" class="form-control" name="id_produk" value="<?php echo $row['id_produk_reg']; ?>">
                            <input type="text" class="form-control" name="kode_produk" value="<?php echo $row['kode_produk'] ?>" readonly>
                          </div>
                          <div class="row">
                            <div class="col-8 mb-3">
                              <label class="form-label"><strong>Nama Produk</strong></label>
                              <input type="text" class="form-control" name="nama_produk" value="<?php echo $row['nama_produk'] ?>" required>
                            </div>
                            <div class="col-4 mb-3">
                              <label class="form-label"><strong>Kode Katalog</strong></label>
                              <input type="text" class="form-control" name="kode_katalog" value="<?php echo $row['kode_katalog'] ?>" required>
                            </div>
                          </div>
                          <div class="mb-3">
                            <div class="row">
                              <div class="col mb-3">
                                <label class="form-label"><strong>Satuan</strong></label>
                                <select name="satuan" class="form-control">
                                  <option value="<?php echo $row['satuan'] ?>"><?php echo $row['satuan'] ?></option>
                                  <option value="Pcs">Pcs</option>
                                  <option value="Set">Set</option>
                                </select>
                              </div>
                              <div class="col-sm mb-3">
                                <label class="form-label"><strong>Merk</strong></label>
                                <select class="form-select" name="merk" required>
                                  <option value="<?php echo $row['id_merk'] ?>"><?php echo $row['nama_merk'] ?></option>
                                  <?php
                                  include "koneksi.php";
                                  $sql = "SELECT * FROM tb_merk ";
                                  $query = mysqli_query($connect, $sql) or die(mysqli_error($connect));
                                  while ($data = mysqli_fetch_array($query)) { ?>
                                    <option value="<?php echo $data['id_merk']; ?>"><?php echo $data['nama_merk']; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                              <div class="col-sm">
                                <label class="form-label"><strong>Harga Produk</strong></label>
                                <input type="text" class="form-control" name="harga" id="inputBudget" value="<?php echo $row['harga_produk'] ?>" required>
                              </div>
                            </div>
                          </div>
                          <div class="mb-3">
                            <div class="row">
                              <div class="col-sm mb-3">
                                <label class="form-label"><strong>Lokasi Produk</strong></label>
                                <input type="hidden" class="form-control" name="id_lokasi" id="id_lokasi" value="<?php echo $row['id_lokasi'] ?>">
                                <input type="text" class="form-control" name="lokasi" id="nama_lokasi" data-bs-toggle="modal" data-bs-target="#modalLokasi" value="<?php echo $row['nama_lokasi'] ?>" readonly>
                              </div>
                              <div class="col-sm mb-3">
                                <label class="form-label"><strong>No. Lantai</strong></label>
                                <input type="text" class="form-control" name="no_lantai" id="no_lantai" value="<?php echo $row['no_lantai'] ?>" readonly>
                              </div>
                              <div class="col-sm mb-3">
                                <label class="form-label"><strong>Area</strong></label>
                                <input type="text" class="form-control" name="area" id="area" value="<?php echo $row['nama_area'] ?>" readonly>
                              </div>
                              <div class="col-sm">
                                <label class="form-label"><strong>No. Rak</strong></label>
                                <input type="text" class="form-control" name="no_rak" id="no_rak" value="<?php echo $row['no_rak'] ?>" readonly>
                              </div>
                            </div>
                          </div>
                          <div class="mb-3">
                            <div class="row">
                              <div class="col-sm mb-3">
                                <label class="form-label"><strong>Kategori Produk</strong></label>
                                <input type="hidden" class="form-control" name="id_kat_produk" id="idKatProduk" value="<?php echo $row['id_kat_produk'] ?>">
                                <input type="text" class="form-control" name="nama_kat_produk" id="namaKatProduk" data-bs-toggle="modal" data-bs-target="#modalkatprod" value="<?php echo $row['kat_prod'] ?> - <?php echo $row['nama_merk'] ?>" readonly>
                              </div>
                              <div class="col-sm mb-3">
                                <label class="form-label"><strong>Kategori Penjualan</strong></label>
                                <select class="form-select" name="kategori_penjualan" required>
                                  <option value="<?php echo $row['id_kat_penjualan']; ?>"><?php echo $row['kat_penj']; ?></option>
                                  <?php
                                  include "koneksi.php";
                                  $sql = "SELECT * FROM tb_kat_penjualan ";
                                  $query = mysqli_query($connect, $sql) or die(mysqli_error($connect));
                                  while ($data = mysqli_fetch_array($query)) { ?>
                                    <option value="<?php echo $data['id_kat_penjualan']; ?>"><?php echo $data['nama_kategori']; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                              <div class="col-sm">
                                <label class="form-label"><strong>Grade Produk</strong></label>
                                <select class="form-select" name="grade" required>
                                  <option value="<?php echo $row['id_grade']; ?>"><?php echo $row['nama_grade']; ?></option>
                                  <?php
                                  include "koneksi.php";
                                  $sql = "SELECT * FROM tb_produk_grade ";
                                  $query = mysqli_query($connect, $sql) or die(mysqli_error($connect));
                                  while ($data = mysqli_fetch_array($query)) { ?>
                                    <option value="<?php echo $data['id_grade']; ?>"><?php echo $data['nama_grade']; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="mb-3 col-sm-6">
                            <img id="imagePreview" src="<?php echo $no_img; ?>" id="output" height="300" width="300">
                            <div id="console-output"></div>
                          </div>
                          <div class="mb-3 col-sm-6">
                            <div class="input-group">
                              <div class="fileUpload btn btn-primary" id="fileUpload">
                                <span><i class="bi bi-upload"></i> Ubah Gambar</span>
                                <input class="upload" type="file" name="fileku" id="formFile" accept="image/*" onchange="compressImage(event)">
                              </div>
                              <div class="fileUpload btn btn-danger" id="resetButton">
                                <span><i class="bi bi-arrow-repeat"></i> Reset File</span>
                                <input class="upload" type="button">
                              </div>
                            </div>
                          </div>
                          <input type="hidden" class="form-control" name="id_user" value="<?php echo $_SESSION['tiket_id']; ?>">
                          <input type="hidden" class="form-control" name="updated" id="datetime-input">
                        </div>
                        <div class="modal-footer">
                          <button type="submit" name="edit-produk-reg" id="ubahData" class="btn btn-primary btn-md m-1" onclick="ubahData()"><i class="bx bx-save"></i> Ubah Data</button>
                          <a href="data-produk-reg.php" class="btn btn-secondary btn-md m-1"><i class="bi bi-x"></i> Tutup</a>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
            </section>
          </main><!-- End #main -->
      <?php 
    } else {
      ?>
        <!-- Sweet Alert -->
        <link rel="stylesheet" href="../assets/sweet-alert/dist/sweetalert2.min.css">
        <script src="assets/sweet-alert/dist/sweetalert2.all.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: "Error!",
                text: "Maaf Anda Tidak Memiliki Akses Fitur Ini",
                icon: "error",
            }).then(function() {
                window.location.href = "data-produk-reg.php";
            });
            });
        </script>
      <?php
    }
  ?>

  <!-- Modal Lokasi -->
  <div class="modal fade" id="modalLokasi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">Pilih Data</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="card">
          <div class="card-body table-responsive mt-3">
            <table class="table table-bordered table-striped" id="table2">
              <thead>
                <tr class="text-white" style="background-color: #051683;">
                  <td class="text-center p-3" style="width: 80px">No</td>
                  <td class="text-center p-3" style="width: 200px">Lokasi</td>
                  <td class="text-center p-3" style="width: 200px">No. Lantai</td>
                  <td class="text-center p-3" style="width: 300px">Area</td>
                  <td class="text-center p-3" style="width: 150px">No. Rak</td>
                </tr>
              </thead>
              <tbody>
                <?php
                date_default_timezone_set('Asia/Jakarta');
                include "koneksi.php";
                $no = 1;
                $sql = "SELECT lp.*,  uc.nama_user as user_created, uu.nama_user as user_updated
                                  FROM tb_lokasi_produk as lp
                                  LEFT JOIN user uc ON (lp.id_user = uc.id_user)
                                  LEFT JOIN user uu ON (lp.user_updated = uu.id_user)";
                $query = mysqli_query($connect, $sql) or die(mysqli_error($connect, $sql));
                while ($data = mysqli_fetch_array($query)) {
                ?>
                  <tr data-id="<?php echo $data['id_lokasi']; ?>" data-nama="<?php echo $data['nama_lokasi']; ?>" data-lantai="<?php echo $data['no_lantai'] ?>" data-area="<?php echo $data['nama_area'] ?>" data-rak="<?php echo $data['no_rak']; ?>" data-bs-dismiss="modal">
                    <td class="text-center"><?php echo $no; ?></td>
                    <td class="text-center"><?php echo $data['nama_lokasi']; ?></td>
                    <td class="text-center"><?php echo $data['no_lantai']; ?></td>
                    <td class="text-center"><?php echo $data['nama_area']; ?></td>
                    <td class="text-center"><?php echo $data['no_rak']; ?></td>
                  </tr>
                  <?php $no++; ?>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Modal Lokasi -->

  <!-- Modal Kategori Produk -->
  <div class="modal fade" id="modalkatprod" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">Pilih Data</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="card">
          <div class="card-body table-responsive mt-3">
            <table class="table table-bordered table-striped katProd" id="table3">
              <thead>
                <tr class="text-white" style="background-color: #051683;">
                  <td class="text-center p-3" style="width: 80px">No</td>
                  <td class="text-center p-3" style="width: 200px">Nama Kategori</td>
                  <td class="text-center p-3" style="width: 200px">Merk</td>
                  <td class="text-center p-3" style="width: 200px">Nomor Izin Edar</td>
                </tr>
              </thead>
              <tbody>
                <?php
                date_default_timezone_set('Asia/Jakarta');
                include "koneksi.php";
                $no = 1;
                $sql = "SELECT * FROM tb_kat_produk AS tkp
                                  JOIN tb_merk AS m ON (tkp.id_merk = m.id_merk)
                                  ORDER BY nama_kategori ASC";
                $query = mysqli_query($connect, $sql) or die(mysqli_error($connect, $sql));
                while ($data = mysqli_fetch_array($query)) {
                ?>
                  <tr data-idkat="<?php echo $data['id_kat_produk']; ?>" data-namakatprod="<?php echo $data['nama_kategori'] ?> - <?php echo $data['nama_merk'] ?>" data-bs-dismiss="modal">
                    <td class="text-center"><?php echo $no; ?></td>
                    <td class="text-center"><?php echo $data['nama_kategori']; ?></td>
                    <td class="text-center"><?php echo $data['nama_merk']; ?></td>
                    <td class="text-center"><?php echo $data['no_izin_edar']; ?></td>
                  </tr>
                  <?php $no++; ?>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Modal  -->

  <!-- Footer -->
  <?php include "page/footer.php" ?>
  <!-- End Footer -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include "page/script.php" ?>
</body>

</html>

<!-- Clock js -->
<script>
  function inputDateTime() {
    // Get current date and time
    let currentDate = new Date();

    // Format date and time as yyyy-mm-ddThh:mm:ss
    let year = currentDate.getFullYear();
    let month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
    let day = currentDate.getDate().toString().padStart(2, '0');
    let hours = currentDate.getHours();
    let minutes = currentDate.getMinutes().toString().padStart(2, '0');
    let seconds = currentDate.getSeconds().toString().padStart(2, '0');
    let formattedDateTime = `${day}/${month}/${year}, ${hours}:${minutes}`;

    // Set value of input field to current date and time
    document.getElementById("datetime-input").setAttribute('value', formattedDateTime);

  }

  // Call updateDateTime function every second
  setInterval(inputDateTime, 1000);
</script>

<script>
  const inputBudget = document.getElementById('inputBudget');
  let formattedValue = Number(inputBudget.value).toLocaleString('id-ID', {
    style: 'currency',
    currency: 'IDR'
  });
  inputBudget.value = formattedValue.replace(",00", "");

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

<!-- Button enable or disable -->
<script>
  //   function ubahData() {
  //     //implementasi untuk mengubah data
  //     // update nilai original setelah data berhasil diubah
  //     originalNamaProduk = namaProdukInput.value;
  //     originalMerkProduk = merkProdukInput.value;
  //     originalHargaProduk = hargaProdukInput.value;
  //     originalKatPenjualanProduk = katPenjualanInput.value;


  //     // dinonaktifkan tombol simpan kembali setelah data berhasil diubah
  //     simpanBtn.disabled = true;

  //   }
  //     const inputBudget = document.getElementById('inputBudget');
  //     let formattedValue = Number(inputBudget.value).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
  //     inputBudget.value = formattedValue.replace(",00", "");
  //     const simpanBtn = document.getElementById('ubahData');
  //     const namaProdukInput = document.getElementsByName("nama_produk")[0];
  //     const merkProdukInput = document.getElementsByName("merk")[0];
  //     const hargaProdukInput = document.getElementsByName("harga")[0];
  //     const katPenjualanInput = document.getElementsByName("kategori_penjualan")[0];
  //     const gradeInput = document.getElementsByName("grade")[0];
  //     let originalNamaProduk = namaProdukInput.value;
  //     let originalMerkProduk = merkProdukInput.value;
  //     let originalHargaProduk = hargaProdukInput.value;
  //     let originalKatPenjualan = katPenjualanInput.value;
  //     let originalGrade = gradeInput.value;

  //     console.log(originalGrade);



  //   inputBudget.addEventListener('input', () => {
  //     let input = inputBudget.value.replace(/[^\d]/g, '');
  //     let formattedInput = Number(input).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
  //     formattedInput = formattedInput.replace(",00", "");
  //     inputBudget.value = formattedInput;

  //     let currentNamaProduk = namaProdukInput.value;
  //     let currentMerkProduk = merkProdukInput.value;
  //     let currentHargaProduk = inputBudget.value;
  //     let currentKatPenjualan = katPenjualanInput.value;
  //     let currentGrade = gradeInput.value;

  //     if (currentNamaProduk !== originalNamaProduk || currentMerkProduk !== originalMerkProduk || currentHargaProduk !== originalHargaProduk
  //     || currentKatPenjualan !== originalKatPenjualan || currentGrade !== originalGrade) {
  //       simpanBtn.disabled = false;
  //     } else {
  //       simpanBtn.disabled = true;
  //     }
  //   });

  //   namaProdukInput.addEventListener('input', () => {
  //     let currentNamaProduk = namaProdukInput.value;
  //     let currentMerkProduk = merkProdukInput.value;
  //     let currentHargaProduk = inputBudget.value;
  //     let currentKatPenjualan = katPenjualanInput.value;
  //     let currentGrade = gradeInput.value;

  //     if (currentNamaProduk !== originalNamaProduk || currentMerkProduk !== originalMerkProduk || currentHargaProduk !== originalHargaProduk || currentKatPenjualan !== originalKatPenjualan || currentGrade !== originalGrade) {
  //       simpanBtn.disabled = false;
  //     } else {
  //       simpanBtn.disabled = true;
  //     }
  //   });

  //   merkProdukInput.addEventListener('change', () => {
  //     let currentNamaProduk = namaProdukInput.value;
  //     let currentMerkProduk = merkProdukInput.value;
  //     let currentHargaProduk = inputBudget.value;
  //     let currentKatPenjualan = katPenjualanInput.value;
  //     let currentGrade = gradeInput.value;

  //     if (currentNamaProduk !== originalNamaProduk || currentMerkProduk !== originalMerkProduk || currentHargaProduk !== originalHargaProduk || currentKatPenjualan !== originalKatPenjualan || currentGrade !== originalGrade) {
  //       simpanBtn.disabled = false;
  //     } else {
  //       simpanBtn.disabled = true;
  //     }
  //   });

  //   katPenjualanInput.addEventListener('change', () => {
  //     let currentNamaProduk = namaProdukInput.value;
  //     let currentMerkProduk = merkProdukInput.value;
  //     let currentHargaProduk = inputBudget.value;
  //     let currentKatPenjualan = katPenjualanInput.value;
  //     let currentGrade = gradeInput.value;

  //     if (currentNamaProduk !== originalNamaProduk || currentMerkProduk !== originalMerkProduk || currentHargaProduk !== originalHargaProduk || currentKatPenjualan !== originalKatPenjualan || currentGrade !== originalGrade) {
  //       simpanBtn.disabled = false;
  //     } else {
  //       simpanBtn.disabled = true;
  //     }
  //   });

  //   gradeInput.addEventListener('change', () => {
  //     let currentNamaProduk = namaProdukInput.value;
  //     let currentMerkProduk = merkProdukInput.value;
  //     let currentHargaProduk = inputBudget.value;
  //     let currentKatPenjualan = katPenjualanInput.value;
  //     let currentGrade = gradeInput.value;

  //     if (currentNamaProduk !== originalNamaProduk || currentMerkProduk !== originalMerkProduk || currentHargaProduk !== originalHargaProduk || currentKatPenjualan !== originalKatPenjualan || currentGrade !== originalGrade) {
  //       simpanBtn.disabled = false;
  //     } else {
  //       simpanBtn.disabled = true;
  //     }
  //     console.log(currentGrade);
  //   });

  //   function enableSubmitButton() {
  //   var fileInput = document.getElementById("formFile");
  //   var submitButton = document.getElementById("ubahData");

  //   if (fileInput.files.length > 0) {
  //     submitButton.disabled = false;
  //   } else {
  //     submitButton.disabled = true;
  //   }
  //   }
  //   document.getElementById("formFile").addEventListener("change", enableSubmitButton);
  // 
</script>
<!-- End Button disable or enable -->

<!-- select data -->
<script src="assets/js/select-data.js"></script>


<!-- Script untuk menjalankan fungsi previewImage() dan resetForm() -->
<script>
  function compressImage() {
    var file = document.querySelector('#formFile').files[0];
    var reader = new FileReader();
    var consoleOutput = document.getElementById('console-output');

    // Empty the console output
    consoleOutput.innerHTML = '';

    reader.onload = function() {
      var img = new Image();
      img.src = reader.result;

      img.onload = function() {
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');
        var maxWidth = 650;
        var maxHeight = 650;
        var width = img.width;
        var height = img.height;

        // Calculate new dimensions
        if (width > height) {
          if (width > maxWidth) {
            height *= maxWidth / width;
            width = maxWidth;
          }
        } else {
          if (height > maxHeight) {
            width *= maxHeight / height;
            height = maxHeight;
          }
        }

        // Set canvas dimensions
        canvas.width = width;
        canvas.height = height;

        // Compress image
        ctx.drawImage(img, 0, 0, width, height);
        canvas.toBlob(function(blob) {
          // Get compressed file size
          var compressedSize = blob.size / 1024; // convert to KB
          // console.log('Compressed file size:', compressedSize + ' KB');

          // Get original file size
          var originalSize = file.size / 1024; // convert to KB
          // console.log('Original file size:', originalSize + ' KB');

          // Display console log output in HTML
          var consoleOutput = document.getElementById('console-output');
          consoleOutput.innerHTML += 'File size: ' + compressedSize.toFixed(2) + ' KB<br>';
          // consoleOutput.innerHTML += 'Original file size: ' + originalSize.toFixed(2) + ' KB<br>';


          // Set compressed image preview
          var preview = document.querySelector('#imagePreview');
          preview.src = URL.createObjectURL(blob);
          preview.style.display = 'block';
          preview.style.width = '300px';
          preview.style.height = '300px';
        }, file.type);
      };
    };

    if (file) {
      reader.readAsDataURL(file);
    }
  }

  function resetForm() {
    document.getElementById('formFile').value = '';
    var preview = document.querySelector('#imagePreview');
    var console = document.querySelector('#console-output');
    preview.style.display = 'none';
    console.style.display = 'block';
    preview.src = '#';
    console.innerHTML = '';
  }

  document.querySelector('#resetButton').addEventListener('click', resetForm);
</script>

<script>
  // Menyimpan nilai awal dari #idKatProduk
  const originalValue = $('#idKatProduk').val();

  // Menambahkan event listener pada elemen #table3 tbody tr
  $(document).on('click', '#table3 tbody tr', function(e) {
    $('#idKatProduk').val($(this).data('idkat'));
    $('#namaKatProduk').val($(this).data('namakatprod'));
    $('#modalkatprod').modal('hide');

    // Mengaktifkan button ubahData
    $('#ubahData').prop('disabled', false);
  });

  // Menambahkan event listener pada perubahan nilai #idKatProduk
  $('#idKatProduk').on('change', function() {
    if ($('#idKatProduk').val() == originalValue) {
      $('#ubahData').prop('disabled', true);
    } else {
      $('#ubahData').prop('disabled', false);
    }
  });
</script>

<script>
  const fileUpload = document.getElementById('fileUpload');
  const fileInput = document.getElementById('formFile');

  fileUpload.addEventListener('click', function() {
    fileInput.click();
  });
</script>