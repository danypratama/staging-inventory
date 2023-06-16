<?php
$page  = 'transaksi';
$page2 = 'spk';
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
    <style>
        @media (max-width: 767px) {

            /* Tambahkan aturan CSS khusus untuk tampilan mobile di bawah 767px */
            .col-12.col-md-2 {
                /* Contoh: Mengatur tinggi elemen select pada tampilan mobile */
                height: 50px;
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
                    <li class="breadcrumb-item active">SPK</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section>
            <div class="card">
                <div class="card-body mt-3">
                    <div class="row mt-4 text-center">
                        <div class="mb-4" style="width: 180px;">
                            <a href="form-create-spk-reg.php" class="btn btn-primary btn-sm p-2"><i class="bi bi-plus-circle"></i> Buat SPK Reguler</a>
                        </div>
                        <div class="mb-4" style="width: 160px;">
                            <a href="form-create-spk-ecat.php" class="btn btn-success btn-sm p-2"><i class="bi bi-plus-circle"></i> Buat SPK E-cat</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="mt-4">
                    <div class="ps-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb" style="font-size: 18px;">
                                        <li class="breadcrumb-item active">SPK Reguler</li>
                                        <li class="breadcrumb-item"><a style="color: blue;" href="spk-ecat.php">SPK E-Cat</a></li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-tabs d-flex ms-3 me-3 justify-content-between" role="tablist" id="myTab" role="tablist">
                        <li class="nav-item flex-fill" role="presentation">
                            <?php
                            $sql_belum_diproses = " SELECT sr.*, cs.nama_cs, cs.alamat
                                        FROM spk_reg AS sr
                                        JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                        WHERE status_spk = 'Belum Diproses'";
                            $query_belum_diproses = mysqli_query($connect, $sql_belum_diproses);
                            $total_data_belum_diproses = mysqli_num_rows($query_belum_diproses);
                            ?>
                            <a class="nav-link" href="spk-reg.php">
                                Belum Diproses &nbsp;
                                <?php if ($total_data_belum_diproses != 0) {
                                    echo '<span class="badge text-bg-secondary">' . $total_data_belum_diproses . '</span>';
                                }
                                ?>
                            </a>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <?php
                            $sql_dalam_proses = " SELECT sr.*, cs.nama_cs, cs.alamat
                                        FROM spk_reg AS sr
                                        JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                        WHERE status_spk = 'Dalam Proses'";
                            $query_dalam_proses = mysqli_query($connect, $sql_dalam_proses);
                            $total_data_dalam_proses = mysqli_num_rows($query_dalam_proses);
                            ?>
                            <a class="nav-link" href="spk-dalam-proses.php">
                                Dalam Proses &nbsp;
                                <?php if ($total_data_dalam_proses != 0) {
                                    echo '<span class="badge text-bg-secondary">' . $total_data_dalam_proses . '</span>';
                                }
                                ?>
                            </a>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <?php
                            include "koneksi.php";
                            $sql_siap_kirim = " SELECT sr.*, cs.nama_cs, cs.alamat
                                    FROM spk_reg AS sr
                                    JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                    WHERE status_spk = 'Siap Kirim'";
                            $query_siap_kirim = mysqli_query($connect, $sql_siap_kirim);
                            $total_data_siap_kirim = mysqli_num_rows($query_siap_kirim);
                            ?>
                            <button class="nav-link active">Siap Kirim &nbsp;<span class="badge text-bg-secondary"><?php echo  $total_data_siap_kirim ?></span></button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <?php
                            $sql_inv = "SELECT nonppn.*, sr.id_inv, sr.id_customer, sr.no_po, cs.nama_cs, cs.alamat
                                FROM inv_nonppn AS nonppn
                                LEFT JOIN spk_reg sr ON(nonppn.id_inv_nonppn = sr.id_inv)
                                JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                WHERE status_transaksi = 'Belum Dikirim' GROUP BY no_inv";
                            $query_inv = mysqli_query($connect, $sql_inv);
                            $total_inv = mysqli_num_rows($query_inv);
                            ?>
                            <?php
                            $sql_inv_ppn = "SELECT ppn.*, sr.id_inv, sr.id_customer, sr.no_po, cs.nama_cs, cs.alamat
                                FROM inv_ppn AS ppn
                                LEFT JOIN spk_reg sr ON(ppn.id_inv_ppn = sr.id_inv)
                                JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                WHERE status_transaksi = 'Belum Dikirim' GROUP BY no_inv";
                            $query_inv_ppn = mysqli_query($connect, $sql_inv_ppn);
                            $total_inv_ppn = mysqli_num_rows($query_inv_ppn);
                            $hasil = $total_inv_ppn + $total_inv_ppn;
                            ?>
                            <a class="nav-link" href="invoice-reguler.php?sort=baru">
                                Invoice Sudah Dicetak &nbsp;
                                <?php if ($hasil != 0) {
                                    echo '<span class="badge text-bg-secondary">' . $hasil . '</span>';
                                }
                                ?>
                            </a>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link" id="dikirim-tab" data-bs-toggle="tab" data-bs-target="#dikirim-tab-pane" type="button" role="tab" aria-controls="dikirim-tab-pane" aria-selected="false">Dikirim</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link" id="diterima-tab" data-bs-toggle="tab" data-bs-target="#diterima-tab-pane" type="button" role="tab" aria-controls="diterima-tab-pane" aria-selected="false">Diterima</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link" id="transaksi-selesai-tab" data-bs-toggle="tab" data-bs-target="#transaksi-selesai-tab-pane" type="button" role="tab" aria-controls="transaksi-selesai-tab-pane" aria-selected="false">Transaksi Selesai</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <a class="nav-link" href="transaksi-cancel.php">Transaksi Cancel</a>
                        </li>
                    </ul>
                    <div class="card-body bg-body rounded mt-3">
                        <div class="tab-content">
                            <div class="card p-3 pt-5">
                                <form id="invoiceForm" name="proses" method="POST">
                                    <div class="table-responsive">
                                        <div class="row mb-3">
                                            <div class="row mb-3">
                                                <div class="col-12 col-md-2 mb-2">
                                                    <form action="" method="GET">
                                                        <select name="sort" class="form-select" id="select" aria-label="Default select example" onchange='if(this.value != 0) { this.form.submit(); }'>
                                                            <option value="baru" <?php if (isset($_GET['sort']) && $_GET['sort'] == "baru") {
                                                                                        echo "selected";
                                                                                    } ?>>Paling Baru</option>
                                                            <option value="lama" <?php if (isset($_GET['sort']) && $_GET['sort'] == "lama") {
                                                                                        echo "selected";
                                                                                    } ?>>Paling Lama</option>
                                                        </select>
                                                    </form>
                                                </div>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="mb-3" style="width: 220px;">
                                                            <input id="nonPpnButton" type="button" name="inv-nonppn" class="btn btn-primary btn-md" value="Buat Invoice Non PPN" onclick="submitForm('form-invoice-nonppn.php')">
                                                        </div>
                                                        <div class="mb-3" style="width: 220px;">
                                                            <input id="ppnButton" type="button" class="btn btn-secondary btn-md" value="Buat Invoice PPN" onclick="submitForm('form-invoice-ppn.php')">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <table class="table table-bordered table-striped" id="table2">
                                                <thead>
                                                    <tr class="text-white" style="background-color: navy;">
                                                        <th class="text-center p-3" style="width: 20px">Pilih</th>
                                                        <th class="text-center p-3" style="width: 30px">No</th>
                                                        <th class="text-center p-3" style="width: 150px">No. SPK</th>
                                                        <th class="text-center p-3" style="width: 150px">Tgl. SPK</th>
                                                        <th class="text-center p-3" style="width: 150px">No. PO</th>
                                                        <th class="text-center p-3" style="width: 200px">Nama Customer</th>
                                                        <th class="text-center p-3" style="width: 150px">Note</th>
                                                        <th class="text-center p-3" style="width: 150px">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include "koneksi.php";
                                                    $no = 1;
                                                    $filter = '';
                                                    if (isset($_GET['sort'])) {
                                                        if ($_GET['sort'] == "baru") {
                                                            $filter = "ORDER BY tgl_spk DESC";
                                                        } elseif ($_GET['sort'] == "lama") {
                                                            $filter = "ORDER BY tgl_spk ASC";
                                                        }
                                                    }
                                                    $sql = "SELECT sr.*, cs.nama_cs, cs.alamat
                                                            FROM spk_reg AS sr
                                                            JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                                            WHERE status_spk = 'Siap Kirim'  $filter";
                                                    $query = mysqli_query($connect, $sql);
                                                    while ($data = mysqli_fetch_array($query)) {
                                                    ?>
                                                        <tr>
                                                            <td class="text-center"><input type="checkbox" name="spk_id[]" id="spk" value="<?php echo $data['id_spk_reg'] ?>" data-customer="<?php echo $data['nama_cs'] ?>"></td>
                                                            <td class="text-center"><?php echo $no; ?></td>
                                                            <td><?php echo $data['no_spk'] ?></td>
                                                            <td><?php echo $data['tgl_spk'] ?></td>
                                                            <td><?php echo $data['no_po'] ?></td>
                                                            <td><?php echo $data['nama_cs'] ?></td>
                                                            <td><?php echo $data['note'] ?></td>
                                                            <td class="text-center">
                                                                <a href="detail-produk-spk-reg-siap-kirim.php?id=<?php echo base64_encode($data['id_spk_reg']) ?>" class="btn btn-primary btn-sm mb-2"><i class="bi bi-eye-fill"></i> Lihat Produk</a>
                                                            </td>
                                                        </tr>
                                                        <?php $no++ ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Dalam Proses -->
                    <!-- ================================================ -->
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

<script>
    $(document).ready(function() {
        $("#select").change(function() {
            var open = $(this).data("isopen");
            if (open) {
                window.location.href = $(this).val();
            }
            //set isopen to opposite so next time when user clicks select box
            //it won't trigger this event
            $(this).data("isopen", !open);
        });
    });
</script>

<script>
    const form = document.getElementById("invoiceForm");
    const checkboxes = document.querySelectorAll('input[type="checkbox"][id^="spk"]');
    const nonPpnButton = document.getElementById("nonPpnButton");
    const ppnButton = document.getElementById("ppnButton");

    form.addEventListener("submit", function(event) {
        event.preventDefault();

        // Jika SPK yang dipilih sesuai dengan pelanggan yang dipilih, lanjutkan proses invoice
        if (selectedSpk) {
            console.log("Data Pelanggan:");
            console.log("Nama Customer:", selectedCustomer);
            console.log("SPK yang Dipilih:");
            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked && checkbox.getAttribute("data-customer") === selectedCustomer) {
                    console.log("ID SPK:", checkbox.value);
                }
            });
            // Lakukan tindakan selanjutnya, seperti mengirim data ke server atau melakukan tindakan lainnya
        }
    });

    function updateButtonState() {
        let selectedCustomer = null;
        let checkedCustomers = new Set(); // Menyimpan nama pelanggan yang dipilih

        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                checkedCustomers.add(checkbox.getAttribute("data-customer")); // Tambahkan nama pelanggan yang dipilih ke dalam Set
            }
        });

        if (checkedCustomers.size <= 5) { // Cek apakah jumlah data yang dicentang tidak melebihi 5
            if (checkedCustomers.size === 1) {
                selectedCustomer = checkedCustomers.values().next().value; // Ambil nama pelanggan dari Set

                nonPpnButton.disabled = false;
                ppnButton.disabled = false;
            } else {
                nonPpnButton.disabled = true;
                ppnButton.disabled = true;
            }
        } else {
            // Jika jumlah data yang dicentang melebihi 5, nonaktifkan tombol dan tampilkan peringatan
            nonPpnButton.disabled = true;
            ppnButton.disabled = true;

            Swal.fire({
                title: '<strong>HTML <u>example</u></strong>',
                icon: 'info',
                html: 'You can use <b>bold text</b>, ' +
                    '<a href="//sweetalert2.github.io">links</a> ' +
                    'and other HTML tags',
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: '<i class="fa fa-thumbs-up"></i> Great!',
                confirmButtonAriaLabel: 'Thumbs up, great!',
                cancelButtonText: '<i class="fa fa-thumbs-down"></i>',
                cancelButtonAriaLabel: 'Thumbs down'
            })
        }
    }

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener("change", function(event) {
            updateButtonState();

            // Membatasi pemilihan data hingga maksimal 5
            let checkedCount = 0;
            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    checkedCount++;
                    if (checkedCount > 5) {
                        checkbox.checked = false;
                        Swal.fire({
                            title: '<strong>Batas Maksimum Pemilihan</strong>',
                            icon: 'info',
                            html: 'Anda hanya dapat memilih maksimal 5 data.',
                            confirmButtonText: 'OK'
                        })
                    }
                }
            });

            updateButtonState();
        });
    });




    function checkInitialCheckbox() {
        checkboxes.forEach(function(checkbox) {
            if (checkbox.getAttribute("data-customer") === "agung") {
                checkbox.checked = true;
            }
        });
        updateButtonState();
    }

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener("change", updateButtonState);
    });

    checkInitialCheckbox();
</script>
<script>
    function submitForm(action) {
        document.getElementById("invoiceForm").action = action;
        document.getElementById("invoiceForm").submit();
    }
</script>