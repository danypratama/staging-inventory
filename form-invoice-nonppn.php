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
      <form action="" method="post">
        <!-- Form simpan ke table invoice -->
        <div class="card">
          <div class="card-header text-center"><h5>Form Invoice Nonppn</h5></div>
          <div class="card-body">
            <div class="row g-3 p-3">
              <div class="col-sm-2">
                <label><strong>ID Invoice Nonppn</strong></label>
                <input type="text" class="form-control" name="id_inv_nonppn" required>
              </div>
              <div class="col-sm-4">
                <label><strong>Pelanggan</strong></label>
                <input type="text" class="form-control" name="pelanggan" required>
              </div>
              <div class="col-sm-4">
                <label><strong>Pelanggan Invoice</strong></label>
                <input type="text" class="form-control" name="pelanggan_inv" required>
              </div>
              <div class="col-sm-2">
                <label><strong>Jenis Invoice</strong></label>
                <select name="jenis_inv" id="select" class="form-select">
                  <option value="1">Reg</option>
                  <option value="2">Diskon</option>
                  <option value="3">Sp.disc</option>
                </select>
              </div>
            </div>
            <div class="row g-3 p-3">
              <div class="col">
                <label><strong>Tanggal Invoice</strong></label>
                <input type="date" class="form-control" name="tgl_inv" required>
              </div>
              <div class="col">
                <label><strong>Tanggal Tempo</strong></label>
                <input type="date" class="form-control" name="tgl_tempo" required>
              </div>
              <div class="col">
                <labe><strong>Spesial Diskon</strong></label>
                <input disabled type="text" id="sp_disc" name="sp_disc" class="form-control">
              </div>
              <div class="col">
                <label><strong>Ongkir</strong></label>
                <input type="text" class="form-control" name="ongkir" required>
              </div>
              <div class="col">
                <label><strong>Note Invoice</strong></label>
                <input type="text" class="form-control" name="note_inv" required>
              </div>
            </div>
          </div>
        </div>
        <!-- End simpan ke table invoice -->
        <!-- Form update ke table spk -->
        <div class="card">
          <div class="card-body">
            <div class="row g-3 p-3">
              <div class="col-sm-2">
                <label><strong>No.SPK</strong></label>
                <input type="text" class="form-control" name="no_spk" required>
              </div>
              <div class="col-sm-4">
                <label><strong>Pelanggan</strong></label>
                <input type="text" class="form-control" name="pelanggan" id="gfg_field0" oninput="gfg_check_duplicates()" required>
                <div id="status0"></div>
              </div>
              <div class="col-sm-4">
                <label><strong>ID Invoice</strong></label>
                <input type="text" class="form-control" name="id_inv_spk" required>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <div class="row g-3 p-3">
              <div class="col-sm-2">
                <label><strong>No.SPK</strong></label>
                <input type="text" class="form-control" name="no_spk" required>
              </div>
              <div class="col-sm-4">
                <label><strong>Pelanggan</strong></label>
                <input type="text" class="form-control" name="pelanggan" id="gfg_field1" oninput="gfg_check_duplicates()" required>
                <button disabled id="status1"> SIMPAN</button>
              </div>
              <div class="col-sm-4">
                <label><strong>ID Invoice</strong></label>
                <input type="text" class="form-control" name="id_inv_spk" required>
              </div>
            </div>
          </div>
        </div>
        <!-- End update ke table spk  -->
        <div class="container">
          <div class="row">
            <div class="col-12 text-center">
              <button href="#" disabled class="btn btn-primary btn-md" id="simpan-data">Simpan Data</button>
              <button href="#" class="btn btn-secondary btn-md">Batal</button>
            </div>
          </div>  
        </div>
      </form>
    </div>

  </main><!-- End #main -->

  <!-- Footer -->
  <?php include "page/footer.php" ?>
  <!-- End Footer -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include "page/script.php" ?>
</body>
</html>
<script type="text/javascript">
	var select = document.getElementById("select");
  var text = document.getElementById("sp_disc");

	select.onchange = function(e) {
	  text.disabled = (select.value !== "3");
	};

  var select = document.getElementById("select");
  var btnsimpan = document.getElementById("simpan-data");

	select.onchange = function(e) {
	  btnsimpan.disabled = (select.value !== "3");
	};
</script>

<script>
function gfg_check_duplicates() {
  var btnsimpan = document.getElementById("simpan-data");
  var myarray = [];
    for (i = 0; i < 2; i++) {
        myarray[i] = 
        document.getElementById("gfg_field" + i).value;
            }
        for (i = 0; i < 2; i++) {
        for (j = i + 1; j < 2; j++) {
            if (i == j || myarray[i] == "" || myarray[j] == "") 
                continue;
                if (myarray[i] == myarray[j]) {
                document.getElementById("status" + i)
                  .innerHTML = "duplicated values!";
                document.getElementById("status" + j)
                .innerHTML = "duplicated values!";
                  status.onchange = function(e) {
                    status.disabled = false;
                  };
                    }
                }
            }
        }
</script>
<script>
  var myarray = [];
    for (i = 0; i < 2; i++) {
        myarray[i] = 
        document.getElementById("gfg_field" + i).value;
            }
        for (i = 0; i < 2; i++) {
        for (j = i + 1; j < 2; j++) {
            if (i == j || myarray[i] == "" || myarray[j] == "") 
                continue;
                if (myarray[i] == myarray[j]) {
                      var btnsimpan = document.getElementById("simpan-data");
                        gfg_field.onchange = function(e) {
                        btnsimpan.disabled = false;
                      };
                    }
                }
            }
        
</script>