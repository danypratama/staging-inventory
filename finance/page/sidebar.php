<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav">
    <li class="nav-item">
      <a class="nav-link <?php if ($page == 'dashboard') { echo 'active-link'; } ?>" href="dashboard.php">
        <i class="bi bi-grid"></i><span>Dasboard</span>
      </a>
    </li>
    <!-- End Dashboard Nav -->

    <!-- Data Bank -->
    <li class="nav-item">
      <a class="nav-link <?php if ($page == 'bank') { echo 'active-link'; } ?>" data-bs-target="#bank" data-bs-toggle="collapse" href="#">
        <i class="bi bi-bank"></i><span>Data Bank</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="bank" class="nav-content collapse " data-bs-parent="#bank">
        <li>
          <a class="<?php if ($page2 == 'bank-master') { echo 'active'; } ?>" href="data-bank.php">
            <i class="bi bi-circle"></i><span>Bank</span>
          </a>
        </li>
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

    <!-- Data SPK -->
    <li class="nav-item">
      <a class="nav-link <?php if ($page == 'spk') { echo 'active-link'; } ?>" href="spk-reg.php">
        <i class="bi bi-bar-chart"></i><span>Data SPK</span>
      </a>
    </li>
    <!-- End Data SPK -->

    <!-- Data Pembelian -->
    <li class="nav-item">
      <a class="nav-link <?php if ($page == 'pembelian') { echo 'active-link'; } ?>" href="data-pembelian.php?date_range=year">
        <i class="bi bi-bar-chart"></i><span>Data Pembelian</span>
      </a>
    </li>
    <!-- End Data SPK -->
    
    <!-- Data Finance -->
    <li class="nav-item">
      <a class="nav-link <?php if ($page == 'finance') { echo 'active-link'; } ?>" href="finance-inv.php?date_range=monthly">
        <i class="bi bi-cash-stack"></i><span>Invoice Penjualan</span>
      </a>
    </li>
    <!-- End Finance -->

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
        <li>
          <a class="<?php if ($page2 == 'tagihan-refund') { echo 'active'; } ?>" href="list-pembayaran-refund.php">
            <i class="bi bi-circle"></i><span>Pembayaran Refund</span>
          </a>
        </li>
      </ul>
    </li>

    <!-- Data Customer -->
    <li class="nav-item">
      <a class="nav-link <?php if ($page == 'list-cs') { echo 'active-link'; } ?>" href="finance-customer.php?date_range=monthly">
        <i class="bi bi-cash-stack"></i><span>Transaksi Customer</span>
      </a>
    </li>
    <!-- End Finance -->
    <!-- Data Customer -->
    <li class="nav-item">
      <a class="nav-link <?php if ($page == 'list-komplain') { echo 'active-link'; } ?>" href="invoice-komplain.php?date_range=monthly">
        <i class="bi bi-clipboard-x"></i><span>Invoice Komplain</span>
      </a>
    </li>
    <!-- End Finance -->
  </ul>
</aside><!-- End Sidebar-->