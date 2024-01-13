<?php
$page  = 'transaksi';
$page2 = 'spk';
include "akses.php";
include "function/class-spk.php";
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

    <style type="text/css">
        table {
            border-collapse: collapse;
            width: 100%;
        }

        @media only screen and (max-width: 500px) {
            body {
                font-size: 14px;
            }

            .mobile {
                display: none;
            }

            .mobile-text {
                text-align: left !important;
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
        <section>
            <!-- SWEET ALERT -->
            <div class="info-data" data-infodata="<?php if (isset($_SESSION['info'])) {
                                                        echo $_SESSION['info'];
                                                    }
                                                    unset($_SESSION['info']); ?>"></div>
            <!-- END SWEET ALERT -->
            <div class="card shadow p-2">
                <div class="card-header text-center">
                    <h5><strong>DETAIL SPK</strong></h5>
                </div>
                <?php
                include "koneksi.php";
                $id_spk = base64_decode($_GET['id']);
                $sql = "SELECT sr.*, cs.nama_cs, cs.alamat, ordby.order_by, sl.nama_sales 
                    FROM spk_reg AS sr
                    JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                    JOIN tb_orderby ordby ON(sr.id_orderby = ordby.id_orderby)
                    JOIN tb_sales sl ON(sr.id_sales = sl.id_sales)
                    WHERE sr.id_spk_reg = '$id_spk'";
                $query = mysqli_query($connect, $sql);
                $data = mysqli_fetch_array($query);
                $petugas = $data['petugas'];
                ?>
                <div class="row mt-3">
                    <div class="col-sm-6">
                        <div class="card-body p-3 border">
                            <div class="row">
                                <div class="col-5">
                                    <p style="float: left;">No. SPK</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php echo $data['no_spk'] ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <p style="float: left;">Tgl. SPK</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php echo $data['tgl_spk'] ?>
                                </div>
                            </div>
                            <?php
                               if ($data['no_po'] != '') {
                                    echo '
                                    <div class="row">
                                        <div class="col-5">
                                            <p style="float: left;">No. PO</p>
                                            <p style="float: right;">:</p>
                                        </div>
                                        <div class="col-7">
                                            ' . $data['no_po'] . '
                                        </div>
                                    </div>';
                                }
                            ?>
                            <div class="row">
                                <div class="col-5">
                                    <p style="float: left;">Tgl. Pesanan</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php echo $data['tgl_pesanan'] ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <p style="float: left;">Order Via</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php echo $data['order_by'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card-body p-3 border">
                            <div class="row">
                                <div class="col-5">
                                    <p style="float: left;">Sales</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php echo $data['nama_sales'] ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <p style="float: left;">Pelanggan</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php echo $data['nama_cs'] ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <p style="float: left;">Alamat</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php echo $data['alamat'] ?>
                                </div>
                            </div>
                            <?php
                                $note = $data['note'];

                                $items = explode("\n", trim($note));
                                if (!empty($note)) {
                                    echo '
                                        <div class="row mt-2">
                                            <div class="col-5">
                                                <p style="float: left;">Note</p>
                                                <p style="float: right;">:</p>
                                            </div>
                                            <div class="col-7">
                                    ';

                                    foreach ($items as $notes) {
                                        echo trim($notes) . '<br>';
                                    }

                                    echo '
                                            </div>
                                        </div>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tampil data -->
            <div class="card shadow">
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <div class="text-start mb-3">
                            <a href="spk-dalam-proses.php?sort=baru" class="btn btn-warning btn-detail mb-3">
                                <i class="bi bi-arrow-left"></i> Halaman Sebelumnya
                            </a>
                            <?php
                                $id_spk = base64_decode($_GET['id']);
                            ?>
                            <?php  
                                include "koneksi.php";
                                $id_role = $_SESSION['tiket_role'];
                                $sql_role = "SELECT * FROM user_role WHERE id_user_role='$id_role'";
                                $query_role = mysqli_query($connect, $sql_role) or die(mysqli_error($connect));
                                $data_role = mysqli_fetch_array($query_role);
                                if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Admin Gudang") {
                                    ?>
                                        <input type="hidden" name="id_spk_reg" value="<?php echo $id_spk ?>">
                                        <?php  
                                            $sql_cek_empty = mysqli_query($connect,"SELECT sr.id_spk_reg, sr.id_inv, trx.id_transaksi
                                                                                    FROM  transaksi_produk_reg AS trx
                                                                                    LEFT JOIN spk_reg sr ON sr.id_spk_reg = trx.id_spk
                                                                                    WHERE sr.id_spk_reg = '$id_spk'");
                                            $data_cek_empty = mysqli_num_rows($sql_cek_empty);
                                        ?>
                                        <?php  
                                            if ($data_cek_empty != 0) {
                                                ?>
                                                    
                                                    <button type="button" class="btn btn-secondary mb-3" data-bs-toggle="modal" data-bs-target="#siapKirim"><i class="bi bi-send"></i> Siap Kirim</button>
                                                <?php
                                            } else {
                                                $update_spk = mysqli_query($connect,"UPDATE spk_reg SET status_spk = 'Belum Diproses' WHERE id_spk_reg = '$id_spk'");
                                            }
                                        ?>
                                    <?php
                                }
                            
                            ?>
                            
                        </div>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr class="text-white" style="background-color: #051683;">
                                    <th class="text-center p-3" style="width:20px">No</th>
                                    <th class="text-center p-3 text-nowrap" style="width:300px">Nama Produk</th>
                                    <th class="text-center p-3 text-nowrap" style="width:100px">Satuan</th>
                                    <th class="text-center p-3 text-nowrap" style="width:100px">Merk</th>
                                    <th class="text-center p-3 text-nowrap" style="width:100px">Harga</th>
                                    <th class="text-center p-3 text-nowrap" style="width:80px">Qty Order</th>
                                    <?php  
                                        if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Admin Gudang") {
                                            ?>
                                                <th class="text-center p-3 text-nowrap" style="width:80px">Aksi</th>
                                            <?php
                                        }
                                    
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    include "koneksi.php";
                                    $year = date('y');
                                    $day = date('d');
                                    $month = date('m');
                                    $id_spk_decode = base64_decode($_GET['id']);
                                    $no = 1;
                                    $total_spk = 0;
                                    $sql_trx = "SELECT
                                                    sr.id_spk_reg,
                                                    sr.id_inv,
                                                    trx.id_transaksi,
                                                    trx.id_produk,
                                                    trx.qty,
                                                    trx.created_date,
                                                    spr.stock, 
                                                    COALESCE(tpr.nama_produk, tpe.nama_produk, tpsm.nama_set_marwa, tpse.nama_set_ecat) AS nama_produk,
                                                    COALESCE(tpr.satuan, tpe.satuan) AS satuan,
                                                    COALESCE(tpr.harga_produk,  tpe.harga_produk, tpsm.harga_set_marwa, tpse.harga_set_ecat) AS harga_produk,
                                                    COALESCE(mr_produk.nama_merk, mr_produk_ecat.nama_merk, mr_set.nama_merk, mr_set_ecat.nama_merk) AS merk_produk -- Nama merk untuk produk reguler
                                                FROM  transaksi_produk_reg AS trx
                                                LEFT JOIN spk_reg sr ON sr.id_spk_reg = trx.id_spk
                                                LEFT JOIN stock_produk_reguler spr ON trx.id_produk = spr.id_produk_reg
                                                LEFT JOIN stock_produk_ecat spe ON trx.id_produk = spe.id_produk_ecat
                                                LEFT JOIN tb_produk_reguler tpr ON trx.id_produk = tpr.id_produk_reg
                                                LEFT JOIN tb_produk_ecat tpe ON trx.id_produk = tpe.id_produk_ecat
                                                LEFT JOIN tb_produk_set_marwa tpsm ON trx.id_produk = tpsm.id_set_marwa
                                                LEFT JOIN tb_produk_set_ecat tpse ON trx.id_produk = tpse.id_set_ecat
                                                LEFT JOIN tb_merk mr_produk ON tpr.id_merk = mr_produk.id_merk -- JOIN untuk produk reguler
                                                LEFT JOIN tb_merk mr_produk_ecat ON tpe.id_merk = mr_produk_ecat.id_merk -- JOIN untuk produk reguler
                                                LEFT JOIN tb_merk mr_set ON tpsm.id_merk = mr_set.id_merk -- JOIN untuk produk set
                                                LEFT JOIN tb_merk mr_set_ecat ON tpse.id_merk = mr_set_ecat.id_merk -- JOIN untuk produk set
                                                WHERE sr.id_spk_reg = '$id_spk_decode' ORDER BY trx.created_date ASC";
                                    $trx_produk_reg = mysqli_query($connect, $sql_trx);
                                    while ($data_trx = mysqli_fetch_array($trx_produk_reg)) {
                                        $namaProduk = $data_trx['nama_produk'];
                                        $id_produk = $data_trx['id_produk'];
                                        $satuan = $data_trx['satuan'];
                                        $nama_merk = $data_trx['merk_produk'];
                                        $harga = $data_trx['harga_produk'];
                                        $sub_total =  $harga * $data_trx['qty'];
                                        $total_spk += $sub_total;
                                        $satuan_produk = '';
                                        $id_produk_substr = substr($id_produk, 0, 2);
                                        if ($id_produk_substr == 'BR') {
                                            $satuan_produk = $satuan;
                                        } else {
                                            $satuan_produk = 'Set';
                                        }
                                    ?>  
                                    <tr>
                                        <td class="text-center"><?php echo $no; ?></td>
                                        <td class="text-nowrap"><?php echo $namaProduk ?></td>
                                        <td class="text-center text-nowrap"><?php echo $satuan_produk ?></td>
                                        <td class="text-center"><?php echo $nama_merk ?></td>
                                        <td class="text-end"><?php echo number_format($harga) ?></td>
                                        <td class="text-end"><?php echo number_format($data_trx['qty']) ?></td>
                                        <?php  
                                            if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Admin Gudang") {
                                                ?>
                                                    <td class="text-center">
                                                        <a href="proses/proses-produk-spk-reg.php?hapus_trx=<?php echo base64_encode($data_trx['id_transaksi']) ?> && id_spk=<?php echo base64_encode($data_trx['id_spk_reg']) ?>" class="btn btn-danger btn-sm delete-data"><i class="bi bi-trash"></i></a>
                                                    </td>
                                                <?php
                                            }                               
                                        ?>
                                    </tr>
                                    <?php $no++; ?>
                                <?php } ?>
                            </tbody>
                        </table>   
                        <?php  
                            $update_total = mysqli_query($connect, "UPDATE spk_reg SET total_spk = '$total_spk' WHERE id_spk_reg = '$id_spk_decode'");
                        ?>
                    </div>
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

<!-- Modal Trx Selesai -->
<div class="modal fade" id="siapKirim" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="proses/proses-produk-spk-reg.php" method="POST">
                <div class="modal-body">
                    <?php
                    $id_spk = base64_decode($_GET['id']);
                    ?>
                    <input type="hidden" name="id_spk_reg" value="<?php echo $id_spk ?>">
                    <h5>Apakah anda yakin pesanan ini siap kirim ?</h5>
                    <div class="mt-3">
                        <label><b>Nama Petugas</b></label>
                        <input type="text" class="form-control" id="petugas" name="petugas" placeholder="Isi Nama Petugas..." required>
                    </div>  
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="siap-kirim"><i class="bi bi-send"></i> Siap Kirim</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetInput()">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Trx Selesai -->

<!-- Generat UUID -->  
<?php
function generate_uuid()
{
    return sprintf(
        '%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}
?>
<!-- End Generate UUID -->

<script>
    function refreshPage() {
        location.reload();
    }
</script>

<!-- Add JavaScript function to reset the input value -->
<script>
    function resetInput() {
        // Set the value of the input field to an empty string
        document.getElementById("petugas").value = "";
    }
</script>

<!-- Kode Untuk Qty   -->
<script>
    function formatNumber(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function formatInputValue(value) {
        return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function checkStock(inputId) {
        var stock = parseInt(document.getElementById('stock_' + inputId).value.replace(/,/g, '')); // Menggunakan ID yang sesuai untuk elemen stock
        var qtyInput = document.getElementById('qtyInput_' + inputId); // Menggunakan ID yang sesuai untuk elemen qtyInput
        var qty = qtyInput.value.replace(/,/g, '');

        qtyInput.value = formatInputValue(qty);

        if (parseInt(qty) > stock) {
            qtyInput.value = formatNumber(stock);
        }

        var simpanButton = document.getElementById('simpan');
        if (parseInt(qty) > 0) {
            simpanButton.disabled = false;
        } else {
            simpanButton.disabled = true;
        }
    }
</script>

<!-- Fungsi menonaktifkan kerboard enter -->
<script>
    document.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            document.getElementById("simpan-data").click();
        }
    });
</script>