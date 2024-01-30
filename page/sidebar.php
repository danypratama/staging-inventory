<!-- Kode untuk role akses -->
<?php  
  include "koneksi.php";
  $id_role = $_SESSION['tiket_role'];
  $sql = "SELECT * FROM user_role WHERE id_user_role='$id_role'";
  $query = mysqli_query($connect, $sql) or die(mysqli_error($connect));
  $data = mysqli_fetch_array($query);
?>
<!-- End Kode Role akses -->
<?php  
  if($data['role'] != "Pimpinan"){
    ?>
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
                  <i class="bi bi-circle"></i><span>Produk Set Reguler</span>
                </a>
              </li>
              <li>
                <a class="<?php if ($page2 == 'data-produk-set-ecat') { echo 'active'; } ?>" href="data-produk-set-ecat.php">
                  <i class="bi bi-circle"></i><span>Produk Set Ecat</span>
                </a>
              </li>
              <li>
                <a class="<?php if ($page2 == 'data-kat-prod') {
                            echo 'active';
                          } ?>" href="kategori-produk.php">
                  <i class="bi bi-circle"></i><span>Kategori Produk</span>
                </a>
              </li>
              <?php  
                if ($data['role'] == "Super Admin" || $data['role'] == "Manager Gudang" || $data['role'] == "Admin Penjualan") { 
                  ?>
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
                  <?php 
                }
              ?>
            </ul>
          </li>
          <!-- End Produk -->
          <!-- Produk  Masuk -->
          <li class="nav-item">
            <a class="nav-link collapsed <?php if ($page == 'br-masuk') { echo 'active-link'; } ?>" data-bs-target="#barang-masuk" data-bs-toggle="collapse" href="#">
              <i class="bi bi-file-ruled-fill"></i><span>Produk Masuk</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="barang-masuk" class="nav-content collapse " data-bs-parent="#sidebar-nav">
              <li>
                <?php  
                  if ($data['role'] == "Super Admin" || $data['role'] == "Manager Gudang" || $data['role'] == "Admin Penjualan") { 
                    ?>
                      <a class="<?php if ($page2 == 'br-masuk-import') { echo 'active'; } ?>" href="barang-masuk-reg-import.php">
                        <i class="bi bi-circle"></i><span>Import</span> 
                      </a>
                    <?php 
                  }
                ?>
                <a class="<?php if ($page2 == 'br-masuk-tambahan') { echo 'active'; } ?>" href="barang-masuk-tambahan.php">
                  <i class="bi bi-circle"></i><span>Tambahan</span>
                </a>
                <a class="<?php if ($page2 == 'br-masuk-tambahan') { echo 'active'; } ?>" href="barang-masuk-lokal.php">
                  <i class="bi bi-circle"></i><span>Lokal</span>
                </a>
                <a class="<?php if ($page2 == 'br-masuk-set-reg') { echo 'active'; } ?>" href="barang-masuk-set-reg.php">
                  <i class="bi bi-circle"></i><span>Produk Set Reguler</span>
                </a>
                <a class="<?php if ($page2 == 'br-masuk-set-ecat') { echo 'active'; } ?>" href="barang-masuk-set-ecat.php">
                  <i class="bi bi-circle"></i><span>Produk Set E-Cat</span>
                </a>
              </li>
            </ul>
          </li>
          <!-- End Produk  Masuk Nav -->

          <!-- Produk  Keluar -->
          <li class="nav-item">
            <a class="nav-link <?php if ($page == 'br-keluar') { echo 'active-link'; } ?>"  href="barang-keluar-reg.php">
              <i class="bi bi-file-ruled"></i><span>Produk  Keluar</span>
            </a>
          </li>
          <!-- End Produk  Keluar Nav -->

          <!-- Perubahan Merk -->
          <li class="nav-item">
            <a class="nav-link collapsed <?php if ($page == 'perubahan-merk') { echo 'active-link'; } ?>" href="ganti-merk-reg.php">
              <i class="bi bi-arrow-left-right"></i><span>Perubahan Merk</span>
            </a>
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
              <?php  
                if ($data['role'] == "Super Admin" || $data['role'] == "Manager Gudang" || $data['role'] == "Admin Penjualan") { 
                  ?>
                    <li>
                      <a class="<?php if ($page2 == 'list-cmp') { echo 'active'; } ?>" href="invoice-komplain.php?date_range=year">
                        <i class="bi bi-circle"></i><span>Invoice Komplain</span>
                      </a>
                    </li>
                  <?php
                }
              ?>
            </ul>
          </li><!-- End Forms Nav -->

          <?php  
            if ($data['role'] == "Super Admin" || $data['role'] == "Manager Gudang" || $data['role'] == "Admin Penjualan") { 
              ?>
                <!-- Pajak di Gunggung -->
                <!-- <li class="nav-item">
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
                </li> -->
                <!-- End Pajak di Gunggung -->
              <?php
            }
          ?>

          <?php  
            if ($data['role'] == "Super Admin" || $data['role'] == "Manager Gudang" || $data['role'] == "Admin Penjualan") { 
              ?>
                <!-- Sales -->
                <li class="nav-item">
                  <a class="nav-link collapsed <?php if ($page == 'sales') { echo 'active-link'; } ?>" href="data-sales.php">
                    <i class="bi bi-people"></i><span>Sales</span>
                  </a>
                </li>
                <!-- Emd Sales -->
              <?php
            }
          ?>

          <?php  
            if ($data['role'] == "Super Admin" || $data['role'] == "Manager Gudang" || $data['role'] == "Admin Penjualan") { 
              ?>
                <!-- Ekspedisi -->
                <li class="nav-item">
                  <a class="nav-link collapsed <?php if ($page == 'ekspedisi') { echo 'active-link'; } ?>" href="data-ekspedisi.php">
                    <i class="ri-truck-line"></i><span>Ekspedisi</span>
                  </a>
                </li>
                <!-- End Ekspedisi -->
              <?php
            }
          ?>


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
                  <i class="bi bi-circle"></i><span>Produk  Masuk</span>
                </a>
              </li>
              <li>
                <a class="<?php if ($page2 == 'ket-out') {
                            echo 'active';
                          } ?>" href="keterangan-out.php">
                  <i class="bi bi-circle"></i><span>Produk  Keluar</span>
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
    <?php
  } else {
    ?>
      <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav">
          <li class="nav-item">
            <a class="nav-link <?php if ($page == 'dashboard') { echo 'active-link'; } ?>" href="dashboard.php">
              <i class="bi bi-grid"></i><span>Dasboard</span>
            </a>
          </li>
          <!-- End Dashboard Nav -->

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
                <a class="<?php if ($page2 == 'data-kat-prod') { echo 'active'; } ?>" href="kategori-produk.php">
                  <i class="bi bi-circle"></i><span>Kategori Produk</span>
                </a>
              </li>
              <li>
                <a class="<?php if ($page2 == 'lokasi') {
                            echo 'active';
                          } ?>" href="lokasi-produk.php">
                  <i class="bi bi-circle"></i><span>Lokasi Produk</span>
                </a>
              </li>
            </ul>
          </li>
          <!-- End Produk -->
          <!-- Produk  Masuk -->
          <li class="nav-item">
            <a class="nav-link collapsed <?php if ($page == 'br-masuk') { echo 'active-link'; } ?>" data-bs-target="#barang-masuk" data-bs-toggle="collapse" href="#">
              <i class="bi bi-file-ruled-fill"></i><span>Produk  Masuk</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="barang-masuk" class="nav-content collapse " data-bs-parent="#sidebar-nav">
              <li>
                <a class="<?php if ($page2 == 'br-masuk-import') { echo 'active'; } ?>" href="barang-masuk-reg-import.php">
                  <i class="bi bi-circle"></i><span>Import</span> 
                </a>
                <a class="<?php if ($page2 == 'br-masuk-set-reg') { echo 'active'; } ?>" href="barang-masuk-set-reg.php">
                  <i class="bi bi-circle"></i><span>Produk Set Reguler</span>
                </a>
                <!-- <a class="<?php if ($page2 == 'br-masuk-set-ecat') { echo 'active'; } ?>" href="barang-masuk-set-ecat.php">
                  <i class="bi bi-circle"></i><span>Set Produk E-Cat</span>
                </a> -->
              </li>
            </ul>
          </li>
          <!-- End Produk  Masuk Nav -->

          <li class="nav-item">
            <a class="nav-link collapsed <?php if ($page == 'br-keluar') { echo 'active-link'; } ?>" data-bs-target="#barang-keluar" data-bs-toggle="collapse" href="#">
              <i class="bi bi-file-ruled"></i><span>Produk  Keluar</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="barang-keluar" class="nav-content collapse " data-bs-parent="#sidebar-nav">
              <li>
                <a href="barang-keluar-reg.php">
                  <i class="bi bi-circle"></i><span>Produk  Keluar Reguler</span>
                </a>
              </li>
              <!-- <li>
                <a href="#">
                  <i class="bi bi-circle"></i><span>Produk  Keluar E-Cat</span>
                </a>
              </li> -->
            </ul>
          </li>
          <!-- End Produk  Keluar Nav -->

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
              <?php  
                if ($data['role'] == "Super Admin" || $data['role'] == "Manager Gudang" || $data['role'] == "Admin Penjualan" || $data['role'] == "Pimpinan") { 
                  ?>
                    <li>
                      <a class="<?php if ($page2 == 'list-cmp') { echo 'active'; } ?>" href="invoice-komplain.php?date_range=year">
                        <i class="bi bi-circle"></i><span>Invoice Komplain</span>
                      </a>
                    </li>
                  <?php
                }
              ?>
            </ul>
          </li><!-- End Forms Nav -->

          <?php  
            if ($data['role'] == "Super Admin" || $data['role'] == "Manager Gudang" || $data['role'] == "Admin Penjualan") { 
              ?>
                <!-- Pajak di Gunggung -->
                <!-- <li class="nav-item">
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
                </li> -->
                <!-- End Pajak di Gunggung -->
              <?php
            }
          ?>
          <!-- Data Bank -->
          <li class="nav-item">
            <a class="nav-link <?php if ($page == 'bank') { echo 'active-link'; } ?>" data-bs-target="#bank" data-bs-toggle="collapse" href="#">
              <i class="bi bi-bank"></i><span>Data Bank</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="bank" class="nav-content collapse " data-bs-parent="#bank">
              <li>
                <a class="<?php if ($page2 == 'bank-pt') { echo 'active'; } ?>" href="data-bank-pt.php">
                  <i class="bi bi-circle"></i><span>Perusahaan</span>
                </a>
              </li>
              <li>
                <a class="<?php if ($page2 == 'bank-cs') { echo 'active'; } ?>" href="data-bank-cs.php">
                  <i class="bi bi-circle"></i><span>Customer</span>
                </a>
              </li>
              <li>
                <a class="<?php if ($page2 == 'bank-sp') { echo 'active'; } ?>" href="data-bank-sp.php">
                  <i class="bi bi-circle"></i><span>Supplier</span>
                </a>
              </li>
            </ul>
          </li>
          <!-- End Data Bank -->

          <!-- Data Invoice penjualan -->
          <li class="nav-item">
            <a class="nav-link <?php if ($page == 'finance') { echo 'active-link'; } ?>" href="finance-inv.php?date_range=monthly">
              <i class="bi bi-cash-stack"></i><span>Invoice Penjualan</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?php if ($page == 'list-tagihan') { echo 'active-link'; } ?>" data-bs-target="#tagihan" data-bs-toggle="collapse" href="#">
              <i class="bi bi-file-earmark-text"></i><span>List Tagihan</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tagihan" class="nav-content collapse " data-bs-parent="#tagihan">
              <li>
                <a class="<?php if ($page2 == 'tagihan-penjualan') { echo 'active'; } ?>" href="list-tagihan-penjualan.php">
                  <i class="bi bi-circle"></i><span>Penjualan</span>
                </a>
              </li>
              <li>
                <a class="<?php if ($page2 == 'tagihan-pembelian') { echo 'active'; } ?>" href="list-tagihan-pembelian.php">
                  <i class="bi bi-circle"></i><span>Pembelian</span>
                </a>
              </li>
            </ul>
          </li>
          <!-- End Invoice Penjualan -->

          <!-- Transaksi Per Customer -->
          <li class="nav-item">
            <a class="nav-link <?php if ($page == 'list-cs') { echo 'active-link'; } ?>" href="finance-customer.php?date_range=monthly">
              <i class="bi bi-cash-stack"></i><span>Transaksi Customer</span>
            </a>
          </li>
          <!-- End  -->

          <?php
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
    <?php
  }
?>