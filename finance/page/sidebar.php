<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav">
    <li class="nav-item">
      <a class="nav-link <?php if ($page == 'dashboard') { echo 'collapsed'; } ?>" href="dashboard.php">
        <i class="bi bi-grid"></i><span>Dasboard</span>
      </a>
    </li>
    <!-- End Dashboard Nav -->

    <!-- Data Bank -->
    <li class="nav-item">
      <a class="nav-link <?php if ($page == 'bank') { echo 'collapsed'; } ?>" href="data-bank.php">
        <i class="bi bi-bank"></i><span>Data Bank</span>
      </a>
    </li>
    <!-- End Data Bank -->

    <!-- Data Bank PT-->
    <li class="nav-item">
      <a class="nav-link <?php if ($page == 'bank-pt') { echo 'collapsed'; } ?>" href="data-bank-pt.php">
        <i class="bi bi-bank"></i><span>Data Bank KMA</span>
      </a>
    </li>
    <!-- End Data Bank -->

    <!-- Data Bank SP-->
    <li class="nav-item">
      <a class="nav-link <?php if ($page == 'bank-sp') { echo 'collapsed'; } ?>" href="data-bank-sp.php">
        <i class="bi bi-bank"></i><span>Data Bank Supplier</span>
      </a>
    </li>
    <!-- End Data Bank -->

    <!-- Data Bank CS -->
    <li class="nav-item">
      <a class="nav-link <?php if ($page == 'bank-cs') { echo 'collapsed'; } ?>" href="data-bank-cs.php">
        <i class="bi bi-bank"></i><span>Data Bank Customer</span>
      </a>
    </li>
    <!-- End Data Bank -->

    <!-- Data SPK -->
    <li class="nav-item">
      <a class="nav-link <?php if ($page == 'transaksi') { echo 'collapsed'; } ?>" href="spk-reg.php">
        <i class="bi bi-bar-chart"></i><span>Data SPK</span>
      </a>
    </li>
    <!-- End Data SPK -->
    
    <!-- Data Finance -->
    <li class="nav-item">
      <a class="nav-link <?php if ($page == 'finance') { echo 'collapsed'; } ?>" href="finance-inv.php?date_range=monthly">
        <i class="bi bi-cash-stack"></i><span>Finance</span>
      </a>
    </li>
    <!-- End Finance -->

    <!-- Data Finance -->
    <li class="nav-item">
      <a class="nav-link <?php if ($page == 'list-tagihan') { echo 'collapsed'; } ?>" href="list-tagihan.php">
        <i class="bi bi-cash-stack"></i><span>List Tagihan</span>
      </a>
    </li>
    <!-- End Finance -->

    <!-- Data Customer -->
    <li class="nav-item">
      <a class="nav-link <?php if ($page == 'list-cs') { echo 'collapsed'; } ?>" href="finance-customer.php?date_range=weekly">
        <i class="bi bi-cash-stack"></i><span>List Customer</span>
      </a>
    </li>
    <!-- End Finance -->
    <!-- Data Customer -->
    <li class="nav-item">
      <a class="nav-link <?php if ($page == 'list-cmp') { echo 'collapsed'; } ?>" href="invoice-komplain.php?date_range=weekly">
        <i class="bi bi-clipboard-x"></i><span>Invoice Komplain</span>
      </a>
    </li>
    <!-- End Finance -->
  </ul>
</aside><!-- End Sidebar-->