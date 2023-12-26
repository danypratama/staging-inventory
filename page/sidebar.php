<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav">
    <li class="nav-item">
      <a class="nav-link <?php if ($page == 'dashboard') { echo 'active-link'; } ?>" href="dashboard.php">
        <i class="bi bi-grid"></i><span>Dasboard</span>
      </a>
    </li>
    <!-- End Dashboard Nav -->
    
    <!-- Supplier & Customer -->
    <li class="nav-item">
      <a class="nav-link collapsed <?php if ($page == 'spcs') { echo 'active-link'; } ?>" data-bs-target="#suppliercs" data-bs-toggle="collapse" href="#">
        <i class="bi bi-truck"></i><span>Supplier & Customer</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="suppliercs" class="nav-content collapse " data-bs-parent="#suppliercs">
        <li>
            <a class="<?php if ($page2 == 'data-sp') { echo 'active'; } ?>" href="data-supplier.php">
              <i class="bi bi-circle"></i><span>Supplier</span>
            </a>
          </li>
          <li>
            <a class="<?php if ($page2 == 'data-cs') { echo 'active'; } ?>" href="data-customer.php">
              <i class="bi bi-circle"></i><span>Customer</span>
            </a>
          </li>
          <li>
            <a class="<?php if ($page2 == 'data-cs-sph') { echo 'active'; } ?>" href="data-customer-sph.php">
              <i class="bi bi-circle"></i><span>Customer SPH</span>
            </a>
          </li>
      </ul>
    </li>
    <!-- End Supplier & Customer -->

    <!-- Produk -->
    <li class="nav-item">
      <a class="nav-link collapsed <?php if ($page == 'produk') { echo 'active-link'; } ?>" data-bs-target="#produk" data-bs-toggle="collapse" href="#">
        <i class="bi bi-box-seam-fill"></i><span>Data Produk</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="produk" class="nav-content collapse " data-bs-parent="#produk">
        <li>
          <a class="<?php if ($page2 == 'data-produk') { echo 'active'; } ?>" href="data-produk-reg.php">
            <i class="bi bi-circle"></i><span>Produk</span>
          </a>
        </li>
        <li>
            <a class="<?php if ($page2 == 'data-stock-reg') { echo 'active'; } ?>" href="stock-produk-reg.php">
              <i class="bi bi-circle"></i><span>Stok Produk Reguler</span>
            </a>
        </li>
        <li>
            <a class="<?php if ($page2 == 'data-stock-ecat') { echo 'active'; } ?>" href="stock-produk-ecat.php">
              <i class="bi bi-circle"></i><span>Stok Produk Ecat</span>
            </a>
        </li>
        <li>
          <a class="<?php if ($page2 == 'data-produk-set-marwa') { echo 'active'; } ?>" href="data-produk-set-marwa.php">
            <i class="bi bi-circle"></i><span>Set Produk Reguler</span>
          </a>
        </li>
        <li>
          <a class="<?php if ($page2 == 'data-produk-set-ecat') { echo 'active'; } ?>" href="data-produk-set-ecat.php">
            <i class="bi bi-circle"></i><span>Set Produk Ecat</span>
          </a>
        </li>
        <li>
          <a class="<?php if ($page2 == 'data-kat-prod') {
                      echo 'active';
                    } ?>" href="kategori-produk.php">
            <i class="bi bi-circle"></i><span>Kategori Produk</span>
          </a>
        </li>
        <li>
          <a class="<?php if ($page2 == 'data-kat-penj') {
                      echo 'active';
                    } ?>" href="kategori-penjualan.php">
            <i class="bi bi-circle"></i><span>Kategori Penjualan</span>
          </a>
        </li>
        <li>
          <a class="<?php if ($page2 == 'data-merk') {
                      echo 'active';
                    } ?>" href="merk-produk.php">
            <i class="bi bi-circle"></i><span>Merk Produk</span>
          </a>
        </li>
        <li>
          <a class="<?php if ($page2 == 'lokasi') {
                      echo 'active';
                    } ?>" href="lokasi-produk.php">
            <i class="bi bi-circle"></i><span>Lokasi Produk</span>
          </a>
        </li>
        <li>
          <a class="<?php if ($page2 == 'grade') {
                      echo 'active';
                    } ?>" href="grade-produk.php">
            <i class="bi bi-circle"></i><span>Grade Produk</span>
          </a>
        </li>
      </ul>
    </li>
    <!-- End Produk -->
    <!-- Barang Masuk -->
    <li class="nav-item">
      <a class="nav-link collapsed <?php if ($page == 'br-masuk') { echo 'active-link'; } ?>" data-bs-target="#barang-masuk" data-bs-toggle="collapse" href="#">
        <i class="bi bi-file-ruled-fill"></i><span>Barang Masuk</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="barang-masuk" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a class="<?php if ($page2 == 'br-masuk-reg') { echo 'active'; } ?>" href="barang-masuk-reg.php">
            <i class="bi bi-circle"></i><span>Reguler</span>
          </a>
          <a href="barang-masuk-set-reg.php">
            <i class="bi bi-circle"></i><span>Set Produk Reguler</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="bi bi-circle"></i><span>E-Cat</span>
          </a>
          <a class="<?php if ($page2 == 'br-masuk-ecat') { echo 'active'; } ?>" href="barang-masuk-set-ecat.php">
            <i class="bi bi-circle"></i><span>Set Produk E-Cat</span>
          </a>
        </li>
      </ul>
    </li>
    <!-- End Barang Masuk Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed <?php if ($page == 'br-keluar') { echo 'active-link'; } ?>" data-bs-target="#barang-keluar" data-bs-toggle="collapse" href="#">
        <i class="bi bi-file-ruled"></i><span>Barang Keluar</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="barang-keluar" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="barang-keluar-reg.php">
            <i class="bi bi-circle"></i><span>Barang Keluar Reguler</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="bi bi-circle"></i><span>Barang Keluar E-Cat</span>
          </a>
        </li>
      </ul>
    </li>
    <!-- End Barang Keluar Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed <?php if ($page == 'perubahan-merk') { echo 'active-link'; } ?>" data-bs-target="#perubahan-merk" data-bs-toggle="collapse" href="#">
        <i class="bi bi-arrow-left-right"></i><span>Perubahan Merk</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="perubahan-merk" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a class="<?php if ($page2 == 'ganti-merk') {  echo 'active'; } ?>" href="ganti-merk-reg.php">
            <i class="bi bi-circle"></i><span>Reguler</span>
          </a>
          <a href="#">
            <i class="bi bi-circle"></i><span>E-Cat</span>
          </a>
        </li>
      </ul>
    </li>
    <!-- End Perubahan Merk -->

    <li class="nav-item">
      <a class="nav-link collapsed <?php if ($page == 'transaksi') { echo 'active-link'; } ?>" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-bar-chart"></i><span>Transaksi</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a class="<?php if ($page2 == 'spk') { echo 'active'; } ?>" href="spk-reg.php?sort=baru">
            <i class="bi bi-circle"></i><span>SPK</span>
          </a>
        </li>
        <li>
          <a class="<?php if ($page2 == 'sph') { echo 'active'; } ?>" href="sph.php">
            <i class="bi bi-circle"></i><span>SPH</span>
          </a>
        </li>
        <li>
          <a class="<?php if ($page2 == 'list-cmp') { echo 'active'; } ?>" href="invoice-komplain.php?date_range=year">
            <i class="bi bi-circle"></i><span>Faktur Komplain</span>
          </a>
        </li>
      </ul>
    </li><!-- End Forms Nav -->


     <!-- Pajak di Gunggung -->
     <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-layout-text-window-reverse"></i><span>Data Pajak Digunggung</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="#">
            <i class="bi bi-circle"></i><span>Non PPN</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="bi bi-circle"></i><span>BUM</span>
          </a>
        </li>
      </ul>
    </li>
    <!-- End Pajak di Gunggung -->

    <!-- Sales -->
    <li class="nav-item">
      <a class="nav-link collapsed <?php if ($page == 'sales') { echo 'active-link'; } ?>" href="data-sales.php">
        <i class="bi bi-people"></i><span>Sales</span>
      </a>
    </li>
    <!-- Emd Sales -->

    <!-- Ekspedisi -->
    <li class="nav-item">
      <a class="nav-link collapsed <?php if ($page == 'ekspedisi') { echo 'active-link'; } ?>" href="data-ekspedisi.php">
        <i class="ri-truck-line"></i><span>Ekspedisi</span>
      </a>
    </li>
    <!-- End Ekspedisi -->

    <!-- Keterangan -->
    <li class="nav-item">
      <a class="nav-link collapsed <?php if ($page == 'keterangan') { echo 'active-link'; } ?>" data-bs-target="#keterangan" data-bs-toggle="collapse" href="#">
        <i class="bi bi-bookmarks"></i><span>Keterangan</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="keterangan" class="nav-content collapse " data-bs-parent="#keterangan">
        <li>
          <a class="<?php if ($page2 == 'ket-in') {
                      echo 'active';
                    } ?>" href="keterangan-in.php">
            <i class="bi bi-circle"></i><span>Barang Masuk</span>
          </a>
        </li>
        <li>
          <a class="<?php if ($page2 == 'ket-out') {
                      echo 'active';
                    } ?>" href="keterangan-out.php">
            <i class="bi bi-circle"></i><span>Barang Keluar</span>
          </a>
        </li>
      </ul>
    </li>
    <!-- End Keterangan -->



    <!-- End Pajak di Gunggung -->
    <!-- Order By -->
    <li class="nav-item">
      <a class="nav-link collapsed <?php if ($page == 'orderby') { echo 'active-link'; } ?>" href="data-orderby.php">
        <i class="bi bi-dropbox"></i><span>Order By</span>
      </a>
    </li>
    <!-- End Order By -->

    <?php
    include "koneksi.php";
    $id_role = $_SESSION['tiket_role'];
    $sql = "SELECT * FROM user_role WHERE id_user_role='$id_role'";
    $query = mysqli_query($connect, $sql) or die(mysqli_error($connect));
    $data = mysqli_fetch_array($query);
    if ($data['role'] == "Super Admin") { ?>
      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed <?php if ($page == 'data-user') {
                              echo 'active-link';
                            } ?>" href="data-user.php">
          <i class="bi bi-person"></i>
          <span>Data User</span>
        </a>
      </li><!-- End Data User Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed <?php if ($page == 'role-user') {
                              echo 'active-link';
                            } ?>" href="data-user-role.php">
          <i class="bi bi-arrows-fullscreen"></i>
          <span>Role User</span>
        </a>
      </li><!-- End Role User Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed <?php if ($page == 'history-user') {
                              echo 'active-link';
                            } ?>" href="data-user-history.php">
          <i class="bi bi-clock-history"></i>
          <span>History User</span>
        </a>
      </li><!-- End History User Page Nav -->
    <?php } ?>
  </ul>
</aside><!-- End Sidebar-->