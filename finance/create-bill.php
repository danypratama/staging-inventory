<?php
$page = 'finance';
$page2  = 'finance-nonppn';
include 'akses.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'page/head.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- nav header -->
    <?php include "page/nav-header.php" ?>
    <!-- end nav header -->

    <!-- sidebar  -->
    <?php include "page/sidebar.php"; ?>
    <!-- end sidebar --> 
    <main id="main" class="main">
        <section>
            <form action="proses/bill.php" method="POST">
                <div class="card p-3">
                    <?php  
                       if (isset($_GET['inv_id'])) {
                            $selectedInvIds = $_GET['inv_id'];
                            $totalNonppn = 0;
                            $totalPpn = 0;
                            $totalBum = 0;
                        
                            // Lakukan sesuatu dengan data yang dipilih
                            // Misalnya, tampilkan daftar ID SPK yang dipilih
                            foreach ($selectedInvIds as $invId) {
                                echo '<input type="hidden" name="id_inv[]" value="' . $invId . '">';
                                $sql = mysqli_query($connect, "SELECT DISTINCT
                                                                    sr.id_customer, sr.id_inv, cs.nama_cs, 
                                                                    nonppn.id_inv_nonppn, 
                                                                    nonppn.no_inv AS no_inv_nonppn, 
                                                                    nonppn.cs_inv AS cs_nonppn, 
                                                                    STR_TO_DATE(nonppn.tgl_tempo, '%d/%m/%Y') AS tgl_tempo_nonppn, 
                                                                    STR_TO_DATE(nonppn.tgl_inv, '%d/%m/%Y') AS tgl_inv_nonppn,
                                                                    nonppn.total_inv AS total_inv_nonppn,
                        
                                                                    ppn.id_inv_ppn, 
                                                                    ppn.no_inv AS no_inv_ppn, 
                                                                    ppn.cs_inv AS cs_ppn, 
                                                                    STR_TO_DATE(ppn.tgl_tempo, '%d/%m/%Y') AS tgl_tempo_ppn, 
                                                                    STR_TO_DATE(ppn.tgl_inv, '%d/%m/%Y') AS tgl_inv_ppn,
                                                                    ppn.total_inv AS total_inv_ppn,
                        
                                                                    bum.id_inv_bum, 
                                                                    bum.no_inv AS no_inv_bum, 
                                                                    bum.cs_inv AS cs_bum, 
                                                                    STR_TO_DATE(bum.tgl_tempo, '%d/%m/%Y') AS tgl_tempo_bum, 
                                                                    STR_TO_DATE(bum.tgl_inv, '%d/%m/%Y') AS tgl_inv_bum,
                                                                    bum.total_inv AS total_inv_bum
                                                            FROM spk_reg AS sr
                                                            JOIN tb_customer cs ON (sr.id_customer = cs.id_cs)
                                                            LEFT JOIN inv_nonppn nonppn ON (sr.id_inv = nonppn.id_inv_nonppn)
                                                            LEFT JOIN inv_ppn ppn ON (sr.id_inv = ppn.id_inv_ppn)
                                                            LEFT JOIN inv_bum bum ON (sr.id_inv = bum.id_inv_bum)
                                                            WHERE sr.id_inv = '$invId'");
                                
                                // Pengecekan apakah data ditemukan
                                if ($sql) {
                                    while ($data_inv = mysqli_fetch_array($sql)) {
                                        $nama_cs = $data_inv['nama_cs']; 
                                        $totalNonppn += $data_inv['total_inv_nonppn'];
                                        $totalPpn += $data_inv['total_inv_ppn'];
                                        $totalBum += $data_inv['total_inv_bum'];
                                        $grandTotal = $totalNonppn + $totalPpn + $totalBum;
                                    }
                                } else {
                                    // Atau Anda bisa mengatur $nama_cs menjadi nilai default jika tidak ada data
                                    $nama_cs = "Tidak ada Customer yang dipilih";
                                }
                            }
                        } 
                    ?>
                    
                    <?php
                    include "koneksi.php";
                    $year  = date('Y');
                    $sql  = mysqli_query($connect, "SELECT max(no_tagihan) as maxID, STR_TO_DATE(tgl_tagihan, '%d/%m/%Y') AS tgl_tagihan FROM finance_tagihan WHERE YEAR(STR_TO_DATE(tgl_tagihan, '%d/%m/%Y')) = '$year'");
                    $data = mysqli_fetch_array($sql);

                    $array_bln = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
                    $kode = $data['maxID'];
                    $ket1 = "/BILL/";
                    $bln = $array_bln[date('n')];
                    $ket2 = "/";
                    $ket3 = date("Y");
                    $urutkan = (int)substr($kode, 0, 3);
                    $urutkan++;
                    $no_tagihan = sprintf("%03s", $urutkan) . $ket1 . $bln . $ket2 . $ket3;
                    ?>
                    <div class="text-center mb-3">
                        <h5><b>Buat Tagihan</b></h5>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-3 mb-3">
                            <label>No. Tagihan</label>
                            <input type="text" class="form-control bg-light" name="no_tagihan" value="<?php echo $no_tagihan ?>" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Customer</label>
                            <input type="text" class="form-control" name="cs" value="<?php echo $nama_cs ?>" required>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label>Tgl. Tagihan</label>
                            <input type="text" class="form-control" id="date" name="tgl_tagihan" id="tgl_tagihan">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Jenis Faktur Tagihan</label>
                            <input type="text" class="form-control" name="jenis_faktur"  maxlength="25">
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-2">
                                <p>Total Tagihan (Dipilih):</p>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                    <input type="text" class="form-control" name="total_tagihan" id="totalTagihan" value="<?php echo number_format($grandTotal, 0,'.','.') ?>" aria-label="total_tagihan" readonly>
                                </div>      
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <?php  
                                if (isset($_GET['inv_id'])) {
                                    $selectedInvIds = $_GET['inv_id'];
                                    $no = 1;

                                    // Lakukan sesuatu dengan data yang dipilih
                                    // Misalnya, tampilkan daftar ID SPK yang dipilih
                                    foreach ($selectedInvIds as $invId) {
                                        $sql = mysqli_query($connect, "SELECT sr.id_customer, sr.id_inv, cs.nama_cs, 
                                                                                nonppn.id_inv_nonppn, 
                                                                                nonppn.no_inv AS no_inv_nonppn, 
                                                                                nonppn.cs_inv AS cs_nonppn, 
                                                                                STR_TO_DATE(nonppn.tgl_tempo, '%d/%m/%Y') AS tgl_tempo_nonppn, 
                                                                                STR_TO_DATE(nonppn.tgl_inv, '%d/%m/%Y') AS tgl_inv_nonppn,
                                                                                nonppn.total_inv AS total_inv_nonppn,

                                                                                ppn.id_inv_ppn, 
                                                                                ppn.no_inv AS no_inv_ppn, 
                                                                                ppn.cs_inv AS cs_ppn, 
                                                                                STR_TO_DATE(ppn.tgl_tempo, '%d/%m/%Y') AS tgl_tempo_ppn, 
                                                                                STR_TO_DATE(ppn.tgl_inv, '%d/%m/%Y') AS tgl_inv_ppn,
                                                                                ppn.total_inv AS total_inv_ppn,

                                                                                bum.id_inv_bum, 
                                                                                bum.no_inv AS no_inv_bum, 
                                                                                bum.cs_inv AS cs_bum, 
                                                                                STR_TO_DATE(bum.tgl_tempo, '%d/%m/%Y') AS tgl_tempo_bum, 
                                                                                STR_TO_DATE(bum.tgl_inv, '%d/%m/%Y') AS tgl_inv_bum,
                                                                                bum.total_inv AS total_inv_bum
                                                                        FROM spk_reg AS sr
                                                                        JOIN tb_customer cs ON (sr.id_customer = cs.id_cs)
                                                                        LEFT JOIN inv_nonppn nonppn ON (sr.id_inv = nonppn.id_inv_nonppn)
                                                                        LEFT JOIN inv_ppn ppn ON (sr.id_inv = ppn.id_inv_ppn)
                                                                        LEFT JOIN inv_bum bum ON (sr.id_inv = bum.id_inv_bum)
                                                                        WHERE sr.id_inv = '$invId'");
                                        $total_data = mysqli_num_rows($sql);
                                    }
                                }
                            ?>
                            <thead>
                                <tr class="text-white" style="background-color: navy;">
                                    <th class="text-center p-3 text-nowrap">No</th>
                                    <th class="text-center p-3 text-nowrap">No. Invoice</th>
                                    <th class="text-center p-3 text-nowrap">Customer Invoice</th>
                                    <th class="text-center p-3 text-nowrap">Tgl. Invoice</th>
                                    <th class="text-center p-3 text-nowrap">Tgl. Tempo</th>
                                    <th class="text-center p-3 text-nowrap">Total Tagihan</th>
                                    <?php  
                                        if($total_data > 1){
                                            ?>
                                                <th class="text-center p-3 text-nowrap">Aksi</th>
                                            <?php
                                        }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    while ($data = mysqli_fetch_array($sql)) {
                                    ?>
                                    <tr>
                                        <td class="text-center text-nowrap"><?php echo $no; ?></td>
                                        <td class="text-center text-nowrap">
                                        <?php
                                            if (!empty($data['no_inv_nonppn'])) {
                                                echo $data['no_inv_nonppn'];
                                            } elseif (!empty($data['no_inv_ppn'])) {
                                                echo $data['no_inv_ppn'];
                                            } elseif (!empty($data['no_inv_bum'])) {
                                                echo $data['no_inv_bum'];
                                            }
                                        ?>
                                        </td>
                                        <td class="text-nowrap">
                                        <?php
                                            if (!empty($data['cs_nonppn'])) {
                                                echo $data['cs_nonppn'];
                                            } elseif (!empty($data['cs_ppn'])) {
                                                echo $data['cs_ppn'];
                                            } elseif (!empty($data['cs_bum'])) {
                                                echo $data['cs_bum'];
                                            }
                                        ?>
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <?php
                                                if (!empty($data['tgl_inv_nonppn'])) {
                                                    echo date('d/m/Y',strtotime($data['tgl_inv_nonppn']));
                                                } elseif (!empty($data['tgl_inv_ppn'])) {
                                                    echo date('d/m/Y',strtotime($data['tgl_inv_ppn']));
                                                } elseif (!empty($data['tgl_inv_bum'])) {
                                                    echo date('d/m/Y',strtotime($data['tgl_inv_bum']));
                                                }
                                            ?>
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <?php
                                                if (!empty($data['tgl_tempo_nonppn'])) {
                                                    echo date('d/m/Y',strtotime($data['tgl_tempo_nonppn']));
                                                } elseif (!empty($data['tgl_tempo_ppn'])) {
                                                    echo date('d/m/Y',strtotime($data['tgl_tempo_ppn']));
                                                } elseif (!empty($data['tgl_tempo_bum'])) {
                                                    echo date('d/m/Y',strtotime($data['tgl_tempo_bum']));
                                                } else {
                                                    echo "Tidak Ada Tempo";
                                                }
                                            ?>
                                        </td>
                                        <td class="text-end text-nowrap">
                                            <?php
                                                if (!empty($data['total_inv_nonppn'])) {
                                                    echo number_format($data['total_inv_nonppn']);
                                                } elseif (!empty($data['total_inv_ppn'])) {
                                                    echo number_format($data['total_inv_ppn']);
                                                } elseif (!empty($data['total_inv_bum'])) {
                                                    echo number_format($data['total_inv_bum']);
                                                }
                                            ?>
                                        </td>
                                        <?php  
                                            if($total_data > 1){
                                                ?>
                                                    <td class="text-center">
                                                        <button class="btn btn-danger btn-sm" type="button" data-id="<?php echo $data['id_inv']; ?>">Hapus Data</button>
                                                    </td>
                                                <?php
                                            }
                                        ?>
                                    </tr>
                                    <?php $no++ ?>
                                <?php } ?>
                            </tbody>
                            <script>
                                // Fungsi untuk memperbarui URL dengan array yang baru
                                function updateURL(newArray) {
                                    const currentURL = new URL(window.location.href);
                                    currentURL.searchParams.delete('inv_id[]'); // Hapus semua parameter inv_id[] dari URL

                                    newArray.forEach(item => {
                                        currentURL.searchParams.append('inv_id[]', item);
                                    });

                                    history.replaceState({}, '', currentURL);
                                }

                                // Menangkap klik tombol "Hapus Data"
                                document.addEventListener('click', function(event) {
                                    if (event.target && event.target.classList.contains('btn-danger')) {
                                        const deletedId = event.target.getAttribute('data-id');
                                        const selectedIds = <?php echo json_encode($selectedInvIds); ?>;

                                        // Hapus data dari array selectedIds
                                        const updatedIds = selectedIds.filter(id => id !== deletedId);

                                        // Perbarui URL
                                        updateURL(updatedIds);

                                        // Hapus elemen baris dari tampilan
                                        event.target.closest('tr').remove();

                                        // Reload halaman
                                        location.reload();
                                    }
                                });
                            </script>
                        </table>
                    </div>
                    <div class="text-end">
                        <a href="finance-inv.php?date_range=monthly" class="btn btn-secondary btn-md">Cancel</a>
                        <button class="btn btn-primary btn-md" id="simpanButton" name="simpan-bill">Simpan</button>
                    </div>
                </div>
            </form>
        </section>
    </main>
</body>
</html>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    var inputTglTagihan = document.getElementById("tgl_tagihan");
    var currentDate = new Date();
    var formattedDate = formatDate(currentDate);
    inputTglTagihan.value = formattedDate;
  });

  function formatDate(date) {
    var year = date.getFullYear();
    var month = String(date.getMonth() + 1).padStart(2, "0");
    var day = String(date.getDate()).padStart(2, "0");
    return day + "/" + month + "/" + year;
  }
</script>

<script type="text/javascript">
  flatpickr("#date", {
    dateFormat: "d/m/Y",
    defaultDate: new Date(),
  });
</script>