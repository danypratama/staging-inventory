<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav">
    <li class="nav-item">
      <a class="nav-link <?php if ($page == 'dashboard') { echo 'active-link'; } ?>" href="dashboard.php">
        <i class="bi bi-grid"></i><span>Dasboard</span>
      </a>
    </li>
    <!-- End Dashboard Nav -->

    <!-- List Inv -->
    <li class="nav-item">
      <a class="nav-link collapsed <?php if ($page == 'list-inv') { echo 'active-link'; } ?>" href="list-invoice.php">
        <i class="bi bi-file-check"></i><span>List Invoice</span>
      </a>
    </li>
    <!-- End List Invoice -->

     <!-- List Tagihan -->
     <li class="nav-item">
      <a class="nav-link collapsed <?php if ($page == 'list-tagihan') { echo 'active-link'; } ?>" href="list-tagihan.php">
        <i class="bi bi-file-check"></i><span>List Tagihan</span>
      </a>
    </li>
    <!-- End List Tagihan -->

    <!-- History Inv-->
    <li class="nav-item">
      <a class="nav-link collapsed <?php if ($page == 'hist-inv') { echo 'active-link'; } ?>" href="history-invoice.php">
        <i class="bi bi-bar-chart"></i><span>History Invoice</span>
      </a>
    </li>
    <!-- End History Inv -->

    <!-- History Tagihan -->
    <li class="nav-item">
      <a class="nav-link collapsed <?php if ($page == 'hist-tagihan') { echo 'active-link'; } ?>" href="history-tagihan.php">
        <i class="bi bi-bar-chart"></i><span>History Tagihan</span>
      </a>
    </li>
    <!-- End History Tagihan -->
  </ul>
</aside><!-- End Sidebar-->