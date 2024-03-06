<?php
$page = 'pembelian';
include "akses.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Inventory KMA</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <?php include "page/head.php"; ?>
    <style>
        th{
            padding-top: 15px !important;
            padding-bottom: 15px !important;
            padding-left: 25px !important;
            padding-right: 35px !important;
            text-align: center !important;
            white-space: nowrap !important;
            margin: 10px !important;
            background-color: navy !important;
        }
        /* Custom styling for the date inputs */
        .form-control[type="date"] {
            appearance: none;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* Optional: Adjust the date input height and font-size */
        .form-control[type="date"] {
            height: 38px;
            font-size: 14px;
        }

        /* Adjust the position of the dropdown */
        .dropdown {
            display: inline-block;
            position: relative;
        }

        /* Adjust the style of the dropdown menu items */
        .dropdown-menu {
            min-width: 350px;
            padding: 20px;
        }

        .dropdown-item{
            text-align: center;
            border: 1px solid #ced4da;
            margin-bottom: 10px;
        }

        .separator {
            display: inline-block;
            width: 40px; /* Atur panjang pemisah sesuai keinginan */
            font-size: 1.2rem;
            font-weight: bold;
            text-align: center;
            color: #333; /* Ubah warna sesuai keinginan */
        }

        .disabled-select{
            pointer-events: none;
            background-color: #0d6efd;
            color: white;
        }

        .btn-filter{
            width: 349px;
        }

        @media screen and (max-width: 1800px) {
            .justify-content-start{
                justify-content: space-between;
            }
            .col-md-3{
                width: 349px;
            }
        }

        @media screen and (max-width: 1200px) {
            .justify-content-start{
                justify-content: space-between;
            }
            .col-md-3{
                width: 349px;
            }
        }

        @media screen and (max-width: 880px) {
            .justify-content-start{
                justify-content: space-between;
            }
            .col-md-3{
                width: 349px;
            }
        }
        @media screen and (max-width: 825px) {
            .justify-content-start{
                justify-content: space-between;
            }

            .btn-filter{
                width: 300px;
            }
            .col-md-3{
                width: 300px;
            }
        }
        @media screen and (max-width: 727px) {
            .justify-content-start{
                justify-content: space-between;
            }

            .btn-filter{
                width: 250px;
            }
            .col-md-3{
                width: 250px;
            }
        }
        @media screen and (max-width: 460px) {
            .btn-filter{
                width: 250px;
            }

            .col-md-3{
                width: 250px;
            }

            label{
                font-size: 14px;
            }
            .form-select{
                font-size: 14px;
            }
            .btn{
                font-size: 14px;
            }
        }
        @media screen and (max-width: 390px) {
            .btn-filter{
                width: 250px;
            }

            .col-md-3{
                width: 250px;
            }
        }
        @media screen and (max-width: 330px) {
            .btn-filter{
                width: 200px;
            }
        }
    </style>
</head>

<body>
  <!-- nav header -->
  <?php include "page/nav-header.php" ?>
  <!-- end nav header -->

  <!-- sidebar  -->
  <?php include "page/sidebar.php"; ?>
  <!-- end sidebar -->

  <main id="main" class="main">
    <section class="section dashboard">
        <!-- SWEET ALERT -->
        <div class="info-data" data-infodata="<?php if (isset($_SESSION['info'])) { echo $_SESSION['info']; } unset($_SESSION['info']); ?>"></div>
        <!-- END SWEET ALERT -->
        <div class="card p-3">
            <div class="card-header">
                <h5 class="text-center fw-bold">Invoice Pembelian Produk Lokal</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-start flex-wrap">
                    <div class="col-md-3 me-2 mb-2">
                        <?php
                            // Mendapatkan bagian dari URL yang berisi parameter GET
                            $queryString = $_SERVER['QUERY_STRING'];

                            // Daftar parameter yang ingin dihapus
                            $parametersToRemove = ['status_bayar', 'jenis_inv', 'status_tagihan'];

                            // Simpan nilai-nilai filter dalam variabel terpisah
                            $dateRangeFilter = '';
                            $statusBayarFilter = '';
                            $jenisInvFilter = '';
                            $statusTagihanFilter = '';

                            // Loop melalui daftar parameter dan hapus dari URL
                            foreach ($parametersToRemove as $parameter) {
                                $queryString = preg_replace('/' . $parameter . '=[^&]+&?/', '', $queryString);
                            }

                            // Fungsi untuk menambahkan atau mengganti nilai parameter dalam URL
                            function addOrReplaceParameter($queryString, $paramName, $paramValue = '') {
                                // Membersihkan duplikasi tanda & sebelum menambahkan parameter baru
                                $queryString = rtrim($queryString, '&');

                                // Hapus parameter yang memiliki nama sama sebelum menambahkan yang baru
                                $queryString = preg_replace('/' . $paramName . '=[^&]+&?/', '', $queryString);

                                if (!empty($paramValue)) {
                                    // Jika nilai parameter tidak kosong, tambahkan parameter ke URL
                                    $queryString .= (empty($queryString) ? '' : '&') . $paramName . '=' . $paramValue;
                                }

                                return $queryString;
                            }

                            // Memeriksa apakah parameter date_range sudah ada dalam URL
                            if (strpos($queryString, 'date_range') === false) {
                                // Jika tidak ada, tambahkan parameter date_range ke URL
                                $queryString = (empty($queryString) ? '' : $queryString . '&') . 'date_range=weekly';
                            }

                            // Menyimpan nilai-nilai filter yang telah diaplikasikan
                            $dateRangeFilter = isset($_GET['date_range']) ? $_GET['date_range'] : '';
                            $statusBayarFilter = isset($_GET['status_bayar']) ? $_GET['status_bayar'] : '';
                            $jenisInvFilter = isset($_GET['jenis_inv']) ? $_GET['jenis_inv'] : '';
                            $statusTagihanFilter = isset($_GET['status_tagihan']) ? $_GET['status_tagihan'] : '';

                            // Menambah atau mengganti nilai parameter status_bayar dalam URL
                            $queryString = addOrReplaceParameter($queryString, 'status_bayar', $statusBayarFilter);

                            // Menambah atau mengganti nilai parameter jenis_inv dalam URL
                            $queryString = addOrReplaceParameter($queryString, 'jenis_inv', $jenisInvFilter);

                            // Menambah atau mengganti nilai parameter status_tagihan dalam URL
                            $queryString = addOrReplaceParameter($queryString, 'status_tagihan', $statusTagihanFilter);

                            // echo $queryString;
                        ?>

                        <!-- Mengganti date_range dan mempertahankan nilai-nilai filter yang telah diaplikasikan -->
                        <?php
                            if (!empty($dateRangeFilter)) {
                                $queryString = addOrReplaceParameter($queryString, 'date_range', $dateRangeFilter);
                            }
                        ?>
                         <label>Filter Tanggal Pembelian :</label>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle btn-filter" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php
                                // Menentukan teks yang ditampilkan berdasarkan nilai dari parameter date_range
                                $selectedOption = isset($_GET['date_range']) ? $_GET['date_range'] : 'today';
                                if ($selectedOption === "today") {
                                    echo "Hari ini";
                                } elseif ($selectedOption === "weekly") {
                                    echo "Minggu ini";
                                } elseif ($selectedOption === "monthly") {
                                    echo "Bulan ini";
                                } elseif ($selectedOption === "lastMonth") {
                                    echo "Bulan Kemarin";
                                } elseif ($selectedOption === "year") {
                                    echo "Tahun ini";
                                } elseif ($selectedOption === "lastyear") {
                                    echo "Tahun Lalu";
                                } else {
                                    echo "Pilih Tanggal";
                                }
                                ?>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <form action="" method="GET" class="form-group newsletter-group" id="resetLink">
                                <a class="custom-dropdown-item dropdown-item rounded <?php echo isset($_GET['date_range']) && $_GET['date_range'] === 'today' ? 'active' : ''; ?>" href="?<?php echo $queryString ?>&date_range=today">Hari ini</a>
                                <a class="custom-dropdown-item dropdown-item rounded <?php echo isset($_GET['date_range']) && $_GET['date_range'] === 'weekly' ? 'active' : ''; ?>" href="?<?php echo $queryString ?>&date_range=weekly">Minggu ini</a>
                                <a class="custom-dropdown-item dropdown-item rounded <?php echo isset($_GET['date_range']) && $_GET['date_range'] === 'monthly' ? 'active' : ''; ?>" href="?<?php echo $queryString ?>&date_range=monthly">Bulan ini</a>
                                <a class="custom-dropdown-item dropdown-item rounded <?php echo isset($_GET['date_range']) && $_GET['date_range'] === 'lastMonth' ? 'active' : ''; ?>" href="?<?php echo $queryString ?>&date_range=lastMonth">Bulan Kemarin</a>
                                <a class="custom-dropdown-item dropdown-item rounded <?php echo isset($_GET['date_range']) && $_GET['date_range'] === 'year' ? 'active' : ''; ?>" href="?<?php echo $queryString ?>&date_range=year">Tahun ini</a>
                                <a class="custom-dropdown-item dropdown-item rounded <?php echo isset($_GET['date_range']) && $_GET['date_range'] === 'lastyear' ? 'active' : ''; ?>" href="?<?php echo $queryString ?>&date_range=lastyear">Tahun Lalu</a>
                                <a class="custom-dropdown-item dropdown-item rounded <?php echo isset($_GET['date_range']) && $_GET['date_range'] === 'pilihTanggal' ? 'active' : ''; ?>">Pilih Tanggal</a>
                                </form>
                                <li><hr class="dropdown-divider"></li>
                                <form action="" method="GET" class="form-group newsletter-group" id="dateForm">
                                <div class="row p-2">
                                    <div class="col-md-6 mb-3">
                                        <label>From</label>
                                        <input type="date" id="startDate" class="form-control form-control-md date-picker" placeholder="dd/mm/yyyy" name="start_date">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>To</label>
                                        <input type="date" id="endDate" class="form-control form-control-md date-picker" placeholder="dd/mm/yyyy" name="end_date">
                                    </div>
                                    <input type="hidden" name="date_range" value="pilihTanggal">
                                </div>
                                
                                <!-- Add the submit button with name="tampilkan" -->
                                <a href="finance-inv.php?date_range=monthly" name="tampilkan" class="custom-dropdown-item dropdown-item rounded bg-danger text-white" id="resetLink">Reset</a>
                                </form>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const endDateInput = document.getElementById('endDate');
                                        const startDateInput = document.getElementById('startDate');
                                        const dateForm = document.getElementById('dateForm');
                                        const resetLink = document.getElementById('resetLink');

                                        // Cek apakah data tanggal tersimpan di localStorage
                                        const savedStartDate = localStorage.getItem('startDate');
                                        const savedEndDate = localStorage.getItem('endDate');

                                        if (savedStartDate) {
                                            startDateInput.value = savedStartDate;
                                        }

                                        if (savedEndDate) {
                                            endDateInput.value = savedEndDate;
                                        }

                                        startDateInput.addEventListener('change', () => {
                                            const startDateValue = new Date(startDateInput.value);
                                            const maxEndDateValue = new Date(startDateValue);
                                            maxEndDateValue.setDate(maxEndDateValue.getDate() + 30);

                                            endDateInput.value = ''; // Reset nilai endDate

                                            endDateInput.min = startDateValue.toISOString().split('T')[0];
                                            endDateInput.max = maxEndDateValue.toISOString().split('T')[0];

                                            endDateInput.disabled = false; // Aktifkan kembali input endDate
                                        });

                                        endDateInput.addEventListener('change', () => {
                                            const startDateValue = new Date(startDateInput.value);
                                            const endDateValue = new Date(endDateInput.value);

                                            const daysDifference = Math.floor((endDateValue - startDateValue) / (1000 * 60 * 60 * 24));

                                            if (daysDifference > 30) {
                                                endDateInput.value = '';
                                            }

                                            startDateInput.value = startDateValue.toISOString().split('T')[0]; // Menampilkan pada field startDate
                                            endDateInput.value = endDateValue.toISOString().split('T')[0]; // Menampilkan pada field endDate

                                            const queryParams = new URLSearchParams({
                                                start_date: startDateValue.toISOString().split('T')[0],
                                                end_date: endDateValue.toISOString().split('T')[0],
                                                date_range: 'pilihTanggal'
                                            });

                                            const newUrl = `finance-inv.php?${queryParams.toString()}`;

                                            dateForm.action = newUrl;
                                            dateForm.submit();

                                            // Simpan tanggal ke localStorage
                                            localStorage.setItem('startDate', startDateInput.value);
                                            localStorage.setItem('endDate', endDateInput.value);
                                        });

                                        resetLink.addEventListener('click', () => {
                                            // Hapus data dari localStorage
                                            localStorage.removeItem('startDate');
                                            localStorage.removeItem('endDate');

                                            // Hapus nilai dari field input
                                            startDateInput.value = '';
                                            endDateInput.value = '';
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 me-2 mb-2">
                        <label>Filter status pembelian :</label>
                        <select name="" class="form-select id="">
                            <option value="">Pilih Status</option>
                            <option value=""></option>
                            <option value=""></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <a href="form-pembelian.php" class="btn btn-primary btn-md"><i class="bi bi-plus-circle"></i> Tambah data pembelian</a>
                </div>
                <div class="table-responsive">
                  <table class="table table-bordered table-striped" id="table1">
                      <thead>
                            <tr class="text-white">
                                <th>No</th>
                                <th>No. Transaksi Pembelian</th>
                                <th>No. Faktur Pembelian</th>
                                <th>Tgl. Pembelian</th>
                                <th>Nama Supplier</th>
                                <th>Total Pembelian</th>
                                <th>Tgl. Tempo</th>
                                <th>Status Pembelian</th>
                                <th>Status Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                      </thead>
                      <tbody>
                            <?php  
                                include "koneksi.php";
                                $no = 1;
                                $sql_pembelian = $connect->query(" SELECT 
                                                                        pb.id_inv_pembelian AS id_inv,
                                                                        pb.no_trx,
                                                                        pb.no_inv,
                                                                        pb.tgl_pembelian,
                                                                        pb.tgl_tempo,
                                                                        pb.total_pembelian,
                                                                        pb.status_pembelian,
                                                                        pb.status_pembayaran,
                                                                        sp.nama_sp
                                                                    FROM inv_pembelian_lokal AS pb
                                                                    LEFT JOIN tb_supplier sp ON (pb.id_sp = sp.id_sp)
                                                                    ORDER BY no_trx ASC
                                                                ");
                                while($data_pembelian = mysqli_fetch_array($sql_pembelian)){
                                    $status_pembelian = "";
                                    $status_pembayaran = "";
                                    if($data_pembelian['status_pembelian'] == '0'){
                                        $status_pembelian = "Belum Diterima";
                                    } else {
                                        $status_pembelian = "Sudah Diterima";
                                    }

                                    if($data_pembelian['status_pembayaran'] == '0'){
                                        $status_pembayaran = "Belum Bayar";
                                    } else {
                                        $status_pembayaran = "Sudah Bayar";
                                    }
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $no; ?></td>
                                <td class="text-center"><?php echo $data_pembelian['no_trx']; ?></td>
                                <td class="text-center"><?php echo $data_pembelian['no_inv']; ?></td>
                                <td class="text-center"><?php echo $data_pembelian['tgl_pembelian']; ?></td>
                                <td class="text-start"><?php echo $data_pembelian['nama_sp']; ?></td>
                                <td class="text-end"><?php echo number_format($data_pembelian['total_pembelian']) ?></td>
                                <td class="text-center"><?php echo $data_pembelian['tgl_tempo']; ?></td>
                                <td class="text-center"><?php echo $status_pembelian; ?></td>
                                <td class="text-center"><?php echo $status_pembayaran; ?></td>
                                <td class="text-center">
                                    <a href="detail-produk-pembelian-lokal.php?id='<?php echo base64_encode($data_pembelian['id_inv']) ?>'" class="btn btn-primary btn-sm" title="Detail Pembelian"><i class="bi bi-eye"></i></a>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-success btn-sm btn-ubah-status" data-bs-toggle="modal" data-bs-target="#ubahStatusDiterima" data-id="<?php echo $data_pembelian['id_inv'] ?>" data-sp="<?php echo $data_pembelian['nama_sp']; ?>" data-nofaktur="<?php echo $data_pembelian['no_inv']; ?>" data-nominal="<?php echo number_format($data_pembelian['total_pembelian']) ?>" data-tglpembelian="<?php echo $data_pembelian['tgl_pembelian']; ?>">
                                        <i class="bi bi-send"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php $no++; ?>
                            <?php } ?>
                      </tbody>
                  </table>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="ubahStatusDiterima" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Status Diterima</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="refreshPage()"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3"><h5 class="fw-bold">Konfirmasi Penerimaan Barang</h5></div>
                    <form action="proses/status-kirim-pembelian.php" method="POST" enctype="multipart/form-data">
                        <?php  
                            $year = date('y');
                            $day = date('d');
                            $month = date('m');
                            $uuid = uuid();
                            $generate_uuid = "BP". $year . "" . $month . "" . $uuid . "" . $day ;
                        ?>
                        <input type="hidden" name="id_bukti_terima" class="form-control bg-light" value="<?php echo $generate_uuid ?>">
                        <input type="hidden" id="id_inv" name="id_inv" class="form-control bg-light">
                        <input type="hidden" id="sp" name="nama_sp" class="form-control bg-light">
                        <div class="mb-3">
                            <label class="fw-bold">No Faktur Pembelian</label>
                            <input type="text" id="no_faktur" name="no_faktur" class="form-control bg-light" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Nominal Pembelian</label>
                            <input type="text" id="nominal" class="form-control bg-light" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Tanggal Pembelian</label>
                            <input type="text" id="tgl_pembelian" class="form-control bg-light" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Tanggal Terima</label>
                            <input type="text" id="date" name="tgl_terima" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Bukti Terima (*)</label>
                        </div>
                        <div class="mb-3">
                            <input type="file" name="fileku1" id="fileku1" accept=".jpg, .jpeg, .png" onchange="compressAndPreviewImage(event)">
                        </div>
                        <div class="mb-3 preview-image" id="imagePreview"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="refreshPage()">Tutup</button>
                            <button type="submit" class="btn btn-primary" name="upload">Proses Diterima</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- kode JS Dikirim -->
    <?php include "page/upload-img.php";  ?>
    <style>
        .preview-image {
            max-width: 100%;
            height: auto;
        }
    </style>
    <!-- kode JS Dikirim -->
    <!-- End Modal Bukti Terima -->

  </main><!-- End #main -->

  <!-- Footer -->
  <?php include "page/footer.php" ?>
  <!-- End Footer -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include "page/script.php" ?>
</body>

</html>
<?php  
    function uuid() {
        $data = openssl_random_pseudo_bytes(16);
        assert(strlen($data) == 16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return vsprintf('%s%s', str_split(bin2hex($data), 4));
    }

?>
<script>
    // untuk menampilkan data pada atribut <td>
    $('#ubahStatusDiterima').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var sp = button.data('sp');
        var noFaktur = button.data('nofaktur');
        var nominal = button.data('nominal');
        var tglPembelian = button.data('tglpembelian');
        
        var modal = $(this);
        modal.find('.modal-body #id_inv').val(id);
        modal.find('.modal-body #sp').val(sp);
        modal.find('.modal-body #no_faktur').val(noFaktur);
        modal.find('.modal-body #nominal').val(nominal);
        modal.find('.modal-body #tgl_pembelian').val(tglPembelian);
    })
</script>
<script>
    function refreshPage() {
        location.reload();
    }
</script>