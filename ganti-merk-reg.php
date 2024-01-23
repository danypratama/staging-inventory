<?php
    $page = 'perubahan-merk';
    $page2  = 'ganti-merk';
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
      <h1>Ganti Merk Produk Reguler</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Ganti Merk</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section>
      <!-- SWEET ALERT -->
      <div class="info-data" data-infodata="<?php if(isset($_SESSION['info'])){ echo $_SESSION['info']; } unset($_SESSION['info']); ?>"></div>
      <!-- END SWEET ALERT -->
      <div class="container-fluid">
        <?php  
            include "koneksi.php";
            $id_role = $_SESSION['tiket_role'];
            $sql_role = "SELECT * FROM user_role WHERE id_user_role='$id_role'";
            $query_role = mysqli_query($connect, $sql) or die(mysqli_error($connect));
            $data_role = mysqli_fetch_array($query_role);
        ?>
        <div class="card">
            <div class="card-body">
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered" id="borderedTab" role="tablist">
                    <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#bordered-home" type="button" role="tab" aria-controls="home" aria-selected="true">Merk Awal</button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#bordered-profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Merk Akhir</button>
                    </li>
                </ul>
                <div class="tab-content pt-2" id="borderedTabContent">
                    <div class="tab-pane fade show active" id="bordered-home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="card-body p-3">
                            <?php  
                                if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Manager Gudang" ) { 
                                    ?>
                                        <a href="input-ganti-merk-reg.php" class="btn btn-primary btn-md"><i class="bi bi-plus-circle"></i> Tambah data</a>
                                    <?php
                                }
                            ?>
                            <div class="table-responsive mt-3">
                                <table class="table table-bordered table-striped" id="tableAwal">
                                    <thead>
                                        <tr class="text-white" style="background-color: #051683;">
                                            <th class="text-center p-3" style="width: 50px">No</th>
                                            <th class="text-center p-3" style="width: 350px">Nama Produk</th>
                                            <th class="text-center p-3" style="width: 100px">Merk</th>
                                            <th class="text-center p-3" style="width: 80px">Qty</th>
                                            <th class="text-center p-3" style="width: 150px">Dibuat Oleh</th>
                                            <th class="text-center p-3" style="width: 150px">Dibuat Tanggal</th>
                                            <?php  
                                                if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Manager Gudang" ) { 
                                                    ?>
                                                        <th class="text-center p-3" style="width: 100px">Aksi</th>
                                                    <?php
                                                }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php  
                                            include "koneksi.php";
                                            $no = 1;
                                            $sql = "SELECT 
                                                    gmro.*, 
                                                    gmro.created_date AS 'created',
                                                    us.*,
                                                    tpr.*,
                                                    mr.*
                                                    FROM ganti_merk_reg_out AS gmro
                                                    LEFT JOIN user us ON (gmro.id_user = us.id_user)
                                                    LEFT JOIN tb_produk_reguler tpr ON (gmro.id_produk_reg = tpr.id_produk_reg)
                                                    LEFT JOIN tb_merk mr ON (tpr.id_merk = mr.id_merk)
                                                    ORDER BY created ASC ";
                                            $query = mysqli_query($connect, $sql) OR DIE (mysqli_error($connect, $sql));
                                            while($data = mysqli_fetch_array($query)){
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no; ?></td>
                                            <td><?php echo $data['nama_produk']; ?></td>
                                            <td class="text-center"><?php echo $data['nama_merk']; ?></td>
                                            <td class="text-end"><?php echo $data['qty']; ?></td>
                                            <td class="text-center"><?php echo $data['nama_user']; ?></td>
                                            <td class="text-center"><?php echo $data['created']; ?></td>
                                            <?php  
                                                if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Manager Gudang" ) { 
                                                    ?>
                                                        <td class="text-center">
                                                            <a href="proses/proses-ganti-merk.php?hapus_id=<?php echo $data['id_ganti_merk_out']; ?>" class="btn btn-sm btn-danger delete-data"><i class="bi bi-trash"></i></a>
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
                    <div class="tab-pane fade" id="bordered-profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card-body p-3">
                            <div class="table-responsive mt-3">
                                <table class="table table-bordered table-striped" id="tableAkhir">
                                    <thead>
                                        <tr class="text-white" style="background-color: #051683;">
                                            <th class="text-center p-3" style="width: 50px">No</th>
                                            <th class="text-center p-3" style="width: 350px">Nama Produk</th>
                                            <th class="text-center p-3" style="width: 100px">Merk</th>
                                            <th class="text-center p-3" style="width: 80px">Qty</th>
                                            <th class="text-center p-3" style="width: 150px">Dibuat Oleh</th>
                                            <th class="text-center p-3" style="width: 150px">Dibuat Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php  
                                            include "koneksi.php";
                                            $no = 1;
                                            $sql = "SELECT 
                                                    gmri.*, 
                                                    gmri.created_date AS 'created',
                                                    us.*,
                                                    tpr.*,
                                                    mr.*
                                                    FROM ganti_merk_reg_in AS gmri
                                                    LEFT JOIN user us ON (gmri.id_user = us.id_user)
                                                    LEFT JOIN tb_produk_reguler tpr ON (gmri.id_produk_reg = tpr.id_produk_reg)
                                                    LEFT JOIN tb_merk mr ON (tpr.id_merk = mr.id_merk)
                                                    ORDER BY created ASC ";
                                            $query = mysqli_query($connect, $sql) OR DIE (mysqli_error($connect, $sql));
                                            while($data = mysqli_fetch_array($query)){
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no; ?></td>
                                            <td><?php echo $data['nama_produk']; ?></td>
                                            <td class="text-center"><?php echo $data['nama_merk']; ?></td>
                                            <td class="text-end"><?php echo $data['qty']; ?></td>
                                            <td class="text-center"><?php echo $data['nama_user']; ?></td>
                                            <td class="text-center"><?php echo $data['created']; ?></td>
                                        </tr>
                                        <?php $no++; ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><!-- End Bordered Tabs -->
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
        var table = $('#tableAwal').DataTable({
            "lengthChange": false,
            "ordering": false,
            "autoWidth": false
        });
    });
    $(document).ready(function() {
        var table = $('#tableAkhir').DataTable({
            "lengthChange": false,
            "ordering": false,
            "autoWidth": false
        });
    });
</script>