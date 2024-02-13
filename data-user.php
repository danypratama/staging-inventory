<?php
$page = 'data-user';
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

  <!-- SWEET ALERT -->
  <div class="info-data" data-infodata="<?php if (isset($_SESSION['info'])) { echo $_SESSION['info']; } unset($_SESSION['info']); ?>"></div>
  <!-- END SWEET ALERT -->

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
          <li class="breadcrumb-item active">Data User</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
      <div class="container-fluid">
        <div class="card shadow">
          <div class="container-fluid p-3">
            <div class="card-body rounded-3">
              <!-- Pills Tabs -->
              <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="user-tab" data-bs-toggle="pill" data-bs-target="#user" type="button" role="tab" aria-controls="user" aria-selected="true">Data user</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="user-active-tab" data-bs-toggle="pill" data-bs-target="#user-active" type="button" role="tab" aria-controls="user-active" aria-selected="false">User active</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="user-request-tab" data-bs-toggle="pill" data-bs-target="#user-request" type="button" role="tab" aria-controls="user-request" aria-selected="false">Data request user</button>
                </li>
              </ul>
              <div class="tab-content pt-2" id="myTabContent">
                <div class="tab-pane fade show active" id="user" role="tabpanel" aria-labelledby="home-tab">
                  <a href="registrasi-user.php" class="btn btn-primary">
                    <i class="bi bi-plus-circle"> Tambah data user</i>
                  </a>
                  <!-- Table User -->
                  <div class="table-responsive mt-3">
                    <table class="table table-hover table-striped table-bordered" id="table2">
                      <thead>
                        <tr class="text-white" style="background-color: #051683;">
                          <td class="text-center p-3" style="width: 60px;">No</td>
                          <td class="text-center p-3" style="width: 200px;">Nama User</td>
                          <td class="text-center p-3" style="width: 200px;">Email</td>
                          <td class="text-center p-3" style="width: 200px;">Username</td>
                          <td class="text-center p-3" style="width: 150px;">Role</td>
                          <td class="text-center p-3" style="width: 120px;">Tgl. Approval</td>
                          <td class="text-center p-3" style="width: 120px;">Approval by</td>
                          <td class="text-center p-3" style="width: 100px;">Aksi</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        date_default_timezone_set('Asia/Jakarta');
                        include "koneksi.php";
                        $no = 1;
                        $sql = "SELECT 
                                  u.id_user, u.nama_user, u.email, u.username, u.tgl_approval, u.approval_by, 
                                  ur.id_user_role, ur.role 
                                FROM user AS u 
                                LEFT JOIN user_role AS ur ON (u.id_user_role = ur.id_user_role)
                                WHERE approval = 1 ORDER BY nama_user ASC";
                        $query = mysqli_query($connect, $sql) or die(mysqli_error($connect));
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                          <tr>
                            <td class="text-center"><?php echo $no; ?></td>
                            <td class="text-nowrap"><?php echo $data['nama_user']; ?></td>
                            <td class="text-nowrap"><?php echo $data['email']; ?></td>
                            <td class="text-nowrap"><?php echo $data['username']; ?></td>
                            <td class="text-center"><?php echo $data['role']; ?></td>
                            <td class="text-nowrap text-center "><?php echo $data['tgl_approval']; ?></td>
                            <td class="text-nowrap "><?php echo $data['approval_by']; ?></td>
                            <td class="text-nowrap text-center">
                              <a href="" name="edit-user" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit-user<?php echo $data['id_user'] ?>"><i class="bi bi-pencil"></i></a>
                              <a href="proses/proses-user.php?hapus-user=<?php echo $data['id_user'] ?>" class="btn btn-danger btn-sm delete-data"><i class="bi bi-trash"></i></a>
                            </td>
                          </tr>
                          <?php $no++; ?>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="tab-pane fade" id="user-active" role="tabpanel" aria-labelledby="profile-tab">
                  <!-- Table User Aktive -->
                  <div class="table-responsive mt-3">
                    <table class="table table-hover table-striped table-bordered" id="table3">
                      <thead>
                        <tr class="text-white" style="background-color: #051683;">
                          <td class="text-center p-3" style="width: 200px;">Nama User</td>
                          <td class="text-center p-3" style="width: 100px;">Waktu Login</td>
                          <td class="text-center p-3" style="width: 100px;">Waktu Logout</td>
                          <td class="text-center p-3" style="width: 150px;">Ip Address</td>
                          <td class="text-center p-3" style="width: 150px;">Jenis Perangkat</td>
                          <td class="text-center p-3" style="width: 150px;">Lokasi</td>
                          <td class="text-center p-3" style="width: 100px;">Aksi</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        date_default_timezone_set('Asia/Jakarta');
                        include "koneksi.php";
                        $id_history = $_SESSION['id_history'];
                        $no = 1;
                        $sql_active = " SELECT 
                                          his.id_history, his.login_time, his.logout_time, his.ip_login, his.jenis_perangkat, his.lokasi,  
                                          u.nama_user
                                        FROM user_history AS his 
                                        JOIN user u ON (his.id_user = u.id_user)
                                        WHERE status_perangkat = 'Online'";
                        $query_active = mysqli_query($connect, $sql_active) or die(mysqli_error($connect));
                        while ($data_active = mysqli_fetch_array($query_active)) {
                        ?>
                          <tr>
                            <td class="text-nowrap"><?php echo $data_active['nama_user']; ?></td>
                            <td class="text-nowrap text-center"><?php echo $data_active['login_time']; ?></td>
                            <td class="text-nowrap text-center"><?php echo $data_active['logout_time']; ?></td>
                            <td class="text-center"><?php echo $data_active['ip_login']; ?></td>
                            <td class="text-nowrap"><?php echo $data_active['jenis_perangkat']; ?></td>
                            <td class="text-nowrap"><?php echo $data_active['lokasi']; ?></td>
                            <td class="text-nowrap text-center">
                              <?php  
                                if ($id_history === $data_active['id_history']) {
                                  
                                }else{
                                  ?>
                                    <a href="logout-paksa.php?id_off=<?php echo $data_active['id_history'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin logout dengan IP <?php echo $data_active['ip_login'] ?> ?')">OFF</a>
                                  <?php
                                }
                              ?>
                            </td>
                          </tr>
                          <?php $no++; ?>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="tab-pane fade" id="user-request" role="tabpanel" aria-labelledby="profile-tab">
                  <!-- Table User Aktive -->
                  <div class="table-responsive mt-3">
                    <table class="table table-hover table-striped table-bordered" id="table4">
                      <thead>
                        <tr class="text-white" style="background-color: #051683;">
                          <td class="text-center p-3" style="width: 60px;">No</td>
                          <td class="text-center p-3" style="width: 200px;">Nama User</td>
                          <td class="text-center p-3" style="width: 200px;">Email</td>
                          <td class="text-center p-3" style="width: 200px;">Username</td>
                          <td class="text-center p-3" style="width: 150px;">Role</td>
                          <td class="text-center p-3" style="width: 150px;">Tgl. Verifikasi</td>
                          <td class="text-center p-3" style="width: 100px;">Aksi</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        date_default_timezone_set('Asia/Jakarta');
                        include "koneksi.php";
                        $no = 1;
                        $sql_request = "SELECT 
                                          u.id_user, u.nama_user, u.email, u.username, u.tgl_verifikasi,
                                          ur.id_user_role, ur.role
                                        FROM user AS u 
                                        JOIN user_role AS ur ON (u.id_user_role = ur.id_user_role)
                                        WHERE approval = 0 ORDER BY tgl_verifikasi DESC";
                        $query_request = mysqli_query($connect, $sql_request) or die(mysqli_error($connect));
                        while ($data_request = mysqli_fetch_array($query_request)) {
                        ?>
                          <tr>
                            <td class="text-nowrap text-center"><?php echo $no; ?></td>
                            <td class="text-nowrap"><?php echo $data_request['nama_user']; ?></td>
                            <td class="text-nowrap"><?php echo $data_request['email']; ?></td>
                            <td class="text-nowrap"><?php echo $data_request['username']; ?></td>
                            <td class="text-nowrap"><?php echo $data_request['role']; ?></td>
                            <td class="text-nowrap text-center">
                              <?php 
                                if($data_request['tgl_verifikasi'] != '') {
                                  echo $data_request['tgl_verifikasi']; 
                                } else {
                                  echo "Belum Verifikasi"; 
                                }
                              ?>
                            </td>
                            <td class="text-nowrap text-center">
                              <button class="btn btn-success btn-sm" title="Terima" data-bs-toggle="modal" data-bs-target="#terima" data-id="<?php echo $data_request['id_user']; ?>" data-nama="<?php echo $data_request['nama_user']; ?>"><i class="bi bi-check-circle-fill"></i></button>
                              <button class="btn btn-danger btn-sm" title="Tolak" data-bs-toggle="modal" data-bs-target="#tolak"><i class="bi bi-x-circle"></i></button>
                            </td>
                          </tr>
                          <?php $no++; ?>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div><!-- End Pills Tabs -->
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
<!-- Modal Terima -->
<div class="modal fade" id="terima" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi</h1>
      </div>
      <div class="modal-body">
        <form action="proses/proses-user.php" method="POST">
          <input type="hidden" id="id_user" name="id_user">
          Apakah anda yakin ingin menerima permintaan <b id="nama_user"></b>?
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary" name="acc-user">Ya, terima</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tolak-->
<div class="modal fade" id="tolak" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi</h1>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('#terima').on('show.bs.modal', function(event) {
      // Mendapatkan data dari tombol yang ditekan
      var button = $(event.relatedTarget);
      var id = button.data('id');
      var nama = button.data('nama');
 
      // Membuat Variable untuk menampilkan data
      var modal = $(this);
      var idInput = modal.find('.modal-body #id_user');
      var namaInput = modal.find('.modal-body #nama_user');
    
      // Menampilkan data
      idInput.val(id);
      namaInput.text(nama); 
  });
</script>