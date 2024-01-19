<header id="header" class="header fixed-top d-flex align-items-center">
  <div class="d-flex align-items-center justify-content-between">
    <a href="#" class="logo d-flex align-items-center">
      <img src="assets/img/logo-kma.png" alt="" style="width: 80px; height: auto;">
      <span class="d-none d-lg-block" style="text-decoration: none;">PT.KMA</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div><!-- End Logo -->
  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">
      <a class="nav-link nav-profile d-flex align-items-center pe-4">
        Sesi akan berakhir dalam <span class="d-none d-md-block ps-2" id="countdown"></span>
      </a><!-- End Profile Iamge Icon -->
      <li class="nav-item dropdown pe-3">
        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <img src="assets/img/user.jpg" alt="Profile" class="rounded-circle">
          <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo ucfirst($_SESSION['tiket_nama']); ?></span>
        </a><!-- End Profile Iamge Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6>Anda Login Sebagai</h6>
            <?php
            include "koneksi.php";
            $id_role = $_SESSION['tiket_role'];
            $sql = "SELECT * FROM user_role WHERE id_user_role='$id_role'";
            $query = mysqli_query($connect, $sql) or die(mysqli_error($connect));
            $data = mysqli_fetch_array($query);
            ?>
            <span><?php echo $data['role']; ?></span>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center" href="logout.php?logout=<?php echo $_SESSION['encoded_id'] ?>">
              <i class="bi bi-box-arrow-right"></i>
              <span>Sign Out</span>
            </a>
          </li>

        </ul><!-- End Profile Dropdown Items -->
      </li><!-- End Profile Nav -->

    </ul>
  </nav><!-- End Icons Navigation -->

</header><!-- End Header -->