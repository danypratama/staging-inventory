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
  <div class="info-data" data-infodata="<?php if (isset($_SESSION['info'])) {
                                          echo $_SESSION['info'];
                                        }
                                        unset($_SESSION['info']); ?>"></div>
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
                  <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Data User</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">User Active</button>
                </li>
              </ul>
              <div class="tab-content pt-2" id="myTabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="home-tab">
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
                          <td class="text-center p-3" style="width: 150px;">Created</td>
                          <td class="text-center p-3" style="width: 100px;">Aksi</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        date_default_timezone_set('Asia/Jakarta');
                        include "koneksi.php";
                        $no = 1;
                        $sql = "SELECT u.*, d.id_user_role, d.role, d.created_date AS 'create' 
                              FROM user AS u 
                              JOIN user_role AS d ON (u.id_user_role = d.id_user_role)";
                        $query = mysqli_query($connect, $sql) or die(mysqli_error($connect));
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                          <tr>
                            <td class="text-center"><?php echo $no; ?></td>
                            <td><?php echo $data['nama_user']; ?></td>
                            <td><?php echo $data['email']; ?></td>
                            <td><?php echo $data['username']; ?></td>
                            <td class="text-center"><?php echo $data['role']; ?></td>
                            <td><?php echo $data['created_date']; ?></td>
                            <td class="text-center">
                              <a href="" name="edit-user" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit-user<?php echo $data['id_user_role'] ?>"><i class="bi bi-pencil"></i></a>
                              <a href="proses/proses-user.php?hapus-user=<?php echo $data['id_user'] ?>" class="btn btn-danger btn-sm delete-data"><i class="bi bi-trash"></i></a>
                            </td>
                          </tr>
                          <?php $no++; ?>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="profile-tab">
                  <!-- Table User Aktive -->
                  <div class="table-responsive mt-3">
                    <table class="table table-hover table-striped table-bordered" id="table2">
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
                        $no = 1;
                        $sql = "SELECT his.*, u.*
                              FROM user_history AS his 
                              JOIN user u ON (his.id_user = u.id_user)
                              WHERE status_perangkat = 'Online'";
                        $query = mysqli_query($connect, $sql) or die(mysqli_error($connect));
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                          <tr>
                            <td><?php echo $data['nama_user']; ?></td>
                            <td><?php echo $data['login_time']; ?></td>
                            <td><?php echo $data['logout_time']; ?></td>
                            <td class="text-center"><?php echo $data['ip_login']; ?></td>
                            <td><?php echo $data['jenis_perangkat']; ?></td>
                            <td><?php echo $data['lokasi']; ?></td>
                            <td class="text-center">
                              <a href="logout.php?id_off=<?php echo $data['id_history'] ?>&ip=<?php echo $data['ip_login'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin logout dengan IP <?php echo $data['ip_login'] ?> ?')">OFF</a>

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