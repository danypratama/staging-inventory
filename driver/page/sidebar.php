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
      <?php 
            $id_user = $_SESSION['tiket_id'];
            include 'query/inv-baru.php'; 
            $query_total_data = mysqli_query($connect, $sql) or die(mysqli_error($connect));
            $total_data = mysqli_num_rows($query_total_data);

            include "query/invoice-revisi.php";
            $query_total_data_rev = mysqli_query($connect, $sql_rev) or die(mysqli_error($connect));
            $total_data_rev = mysqli_num_rows($query_total_data_rev);
            $sum_total =  $total_data + $total_data_rev;
      ?>
      <a class="nav-link collapsed <?php if ($page == 'list-inv') { echo 'active-link'; } ?>" href="list-invoice.php">
        <i class="bi bi-file-check"></i>
        <span>
          List Invoice &nbsp;
          <?php  
            if ($sum_total != 0){
              ?>
                <span class="badge text-bg-secondary"><?php echo $sum_total; ?></span> 
              <?php
            }
          ?>
        </span>
      </a>
    </li>
    <!-- End List Invoice -->

     <!-- List Tagihan -->
     <li class="nav-item">
      <?php  
        $id_user = $_SESSION['tiket_id'];
        include 'query/list-tagihan.php'; 
        $query_total_data_tagihan = mysqli_query($connect, $sql_tagihan) or die(mysqli_error($connect));
        $total_data_tagihan = mysqli_num_rows($query_total_data_tagihan);
      ?>
      <a class="nav-link collapsed <?php if ($page == 'list-tagihan') { echo 'active-link'; } ?>" href="list-tagihan.php">
        <i class="bi bi-file-check"></i>
        <span>
          List Tagihan &nbsp;
          <?php  
            if ($total_data_tagihan != 0){
              ?>
                <span class="badge text-bg-secondary"><?php echo $total_data_tagihan; ?></span> 
              <?php
            }
          ?>
        </span>
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