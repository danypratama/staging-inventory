<?php
    $page  = 'transaksi';
    $page2  = 'list-cmp';
    include "akses.php";
    include 'function/class-komplain.php';
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>Inventory KMA</title>
        <meta content="" name="description">
        <meta content="" name="keywords">
        <link rel="stylesheet" href="assets/css/wrap-text.css">
    
        <?php include "page/head.php"; ?>
        <?php include "page/style-button-filterdate.php"; ?>

        <style>
            .label-mobile{
                display: none;
            }

            .disable-click {
                pointer-events: none;
            }
            @media (max-width: 767px) {

                body {
                font-size: 14px;
               }

                .mobile {
                    display: none;
                }

                .mobile-text {
                    text-align: left !important;
                }

                /* Tambahkan aturan CSS khusus untuk tampilan mobile di bawah 767px */
                .col-12.col-md-2 {
                    /* Contoh: Mengatur tinggi elemen select pada tampilan mobile */
                    height: 50px;
                }

                .card-mobile{
                    display: none;
                }

                .label-mobile{
                    display: block;
                }
                
            }

            .btn.active {
                background-color: black;
                color: white;
                border-color: 1px solid white;
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
                /* Menghilangkan garis pada input */
            input {
                border: none;
                outline: none;
                background: none;
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
            <!-- Loading -->
            <div class="loader loader">
                <div class="loading">
                    <img src="img/loading.gif" width="200px" height="auto">
                </div>
            </div>
            <!-- ENd Loading -->
            <section>
                <!-- SWEET ALERT -->
                <div class="info-data" data-infodata="<?php if (isset($_SESSION['info'])) {
                                                            echo $_SESSION['info'];
                                                            }
                                                            unset($_SESSION['info']); ?>"></div>
                <!-- END SWEET ALERT -->
                <?php  
                    $id = base64_decode($_GET['id']);
                    include "../query/detail-komplain.php";
                    $id_inv = $data_kondisi['id_inv'];
                    $no_inv = $data_kondisi['no_inv'];
                    $alamat = $data_detail['alamat'];
                    include "../query/produk-komplain-tmp.php";

                    $id_inv_substr = $id_inv;
                    $inv_id = substr($id_inv_substr, 0, 3);
                    $jenis_inv = "";
                    if ($inv_id == "NON"){
                        $jenis_inv = "nonppn";
                    } else if ($inv_id == "PPN"){
                        $jenis_inv = "ppn";
                    } else if ($inv_id == "BUM"){
                        $jenis_inv = "bum";
                    }



                    // query untuk cek no invoice
                    $cek_no_inv = mysqli_query($connect,"   SELECT 
                                                                COALESCE(nonppn.id_inv_nonppn, ppn.id_inv_ppn, bum.id_inv_bum) AS id_inv,
                                                                max(rev.no_inv_revisi) AS no_inv_revisi
                                                            FROM inv_revisi AS rev
                                                            LEFT JOIN inv_komplain ik ON rev.id_inv = ik.id_inv
                                                            LEFT JOIN inv_nonppn nonppn ON ik.id_inv = nonppn.id_inv_nonppn
                                                            LEFT JOIN inv_ppn ppn ON ik.id_inv = ppn.id_inv_ppn
                                                            LEFT JOIN inv_bum bum ON ik.id_inv = bum.id_inv_bum 
                                                            WHERE '$id_inv' IN (nonppn.id_inv_nonppn, ppn.id_inv_ppn, bum.id_inv_bum) GROUP BY id_inv
                                              ");
                    $total_row_rev = mysqli_num_rows($cek_no_inv);
                    $data_inv_rev = mysqli_fetch_array($cek_no_inv);
                    $no_inv_fix = '';
                    if($total_row_rev == 0){
                        $no_inv_fix = $no_inv;
                    } else {
                        $no_inv_fix = $data_inv_rev['no_inv_revisi'];
                    }
                ?>
                <div class="card p-2">     
                    <div class="row mb-2">
                        <!-- Kolom No Komplain (di atas) -->
                        <div class="col-md-3">
                            <button class="btn btn-secondary">No Komplain : <?php echo $data_detail['no_komplain'] ?></button>
                        </div>
                        <!-- Kolom Open (di tengah) -->
                        <div class="col-md-6 text-center">
                            <p><b>Detail Invoice Revisi</b></p>
                        </div>
                        <!-- Kolom Details (paling bawah) -->
                        <div class="col-md-3 text-end">
                            <button class="btn btn-secondary">
                                <?php 
                                    if($data_detail['status_komplain'] == 0){
                                        echo "Open";
                                    } else {
                                        echo "Selesai";
                                    }
                                ?>
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="border p-3">
                                <div class="table-responsive">
                                    <table class="table table-borderless">  
                                        <tr>
                                            <td class="col-md-6 text-nowrap">Tgl. Pesanan</td>
                                            <td class="text-nowrap">: <?php echo $data_detail['tgl_pesanan'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-6 text-nowrap">No. SPK</td>
                                            <td class="text-nowrap">
                                                :  <?php 
                                                        $no = 1;
                                                        $total_rows = mysqli_num_rows($query_detail2); // Menghitung total baris data
                                                        while ($data_detail2 = mysqli_fetch_array($query_detail2)) {
                                                            $no_spk = $data_detail2['no_spk'];
                                                            $tgl_pesanan = $data_detail2['tgl_pesanan'];
                                                            $no_po = $data_detail2['no_po'];
                                                            
                                                            // Mengecek apakah ini adalah baris kedua atau lebih
                                                            if ($no > 1) {
                                                                echo "<br>"; // Menambahkan baris baru setelah baris pertama
                                                            }
                                                            
                                                            echo $no . ". (" . $tgl_pesanan . ")";
                                                            
                                                            // Menampilkan nomor PO jika tersedia
                                                            if (!empty($no_po)) {
                                                                echo " / (" . $no_po . ")";
                                                            }
                                                            
                                                            echo " / (" . $no_spk . ")";
                                                            
                                                            $no++;
                                                        }
                                                    ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-6 text-nowrap">No. Invoice</td>
                                            <td class="text-nowrap">: <?php echo $no_inv_fix ?></td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-6 text-nowrap">Tgl.Invoice</td>
                                            <td class="text-nowrap">: <?php echo $data_detail['tgl_inv'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-6 text-nowrap">Jenis Invoice</td>
                                            <td class="text-nowrap">: <?php echo $data_detail['kategori_inv'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-6 text-nowrap">Order Via</td>
                                            <td class="text-nowrap">: <?php echo $data_detail['order_by'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-6 text-nowrap">Sales</td>
                                            <td class="text-nowrap">: <?php echo $data_detail['nama_sales'] ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border p-3">
                                <div class="table-responsive">
                                    <table class="table table-borderless">  
                                        <tr>
                                            <td class="col-md-6 text-nowrap">Pelanggan</td>
                                            <td class="text-nowrap">: <?php echo $data_detail['nama_cs'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-6 text-nowrap">Pelanggan Inv</td>
                                            <td class="text-nowrap">: <?php echo $data_detail['cs_inv'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-6 text-nowrap">Alamat</td>
                                            <td class="text-nowrap">: <?php echo $data_detail['alamat'] ?></td>
                                        </tr>

                                        <tr>
                                            <td class="col-md-6 text-nowrap">Ongkos Kirim</td>
                                            <td class="text-nowrap">: <?php echo number_format($data_detail['ongkir']) ?></td>
                                        </tr>
                                        <?php  
                                            if($total_driver_rev != 0){
                                                ?>
                                                    <tr>
                                                        <td class="col-md-6 text-nowrap">Jenis Pengiriman</td>
                                                        <td class="text-nowrap">
                                                            :   <?php  
                                                                    if($data_driver_rev['jenis_pengiriman'] == 'Driver'){
                                                                        ?>
                                                                            <?php echo $data_driver_rev['jenis_pengiriman']?> (<?php echo $data_driver_rev['nama_driver'] ?>)
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                            <?php echo $data_driver_rev['jenis_pengiriman']?> (<?php echo $data_driver_rev['nama_ekspedisi'] ?>)
                                                                        <?php
                                                                    }
                                                            
                                                                ?>

                                                        </td>
                                                    </tr>
                                                    <?php  
                                                        if(!empty($data_driver_rev['jenis_pengiriman'] && $data_driver_rev['jenis_penerima'])){
                                                            ?>
                                                                <tr>
                                                                    <td class="col-md-6 text-nowrap">Diterima Oleh</td>
                                                                    <td class="text-nowrap">
                                                                        :   <?php 
                                                                                if($data_driver_rev['jenis_penerima'] == 'Customer'){
                                                                                    ?>
                                                                                        <?php echo $data_driver_rev['jenis_penerima'] ?> 
                                                                                    <?php
                                                                                } else {
                                                                                    ?>
                                                                                        <?php echo $data_driver_rev['jenis_penerima'] ?> (<?php echo $data_driver_rev['nama_ekspedisi'] ?>)
                                                                                    <?php
                                                                                }
                                                                        
                                                                            ?>
                                                                
                                                                    </td>
                                                                </tr>
                                                            <?php
                                                        }
                                                    
                                                    ?>
                                                    <?php  
                                                        if(!empty($data_driver_rev['nama_penerima'])){
                                                            ?>
                                                                <tr>
                                                                    <td class="col-md-6 text-nowrap">Nama Penerima</td>
                                                                    <td class="text-nowrap">: <?php echo $data_driver_rev['nama_penerima'] ?></td>
                                                                </tr>
                                                            <?php
                                                        }
                                                    
                                                    ?>
                                                    <?php  
                                                        if(!empty($data_driver_rev['dikirim_oleh']) && !empty($data_driver_rev['penanggung_jawab'])){
                                                            ?>
                                                                <tr>
                                                                    <td class="col-md-6 text-nowrap">Dikirim Oleh</td>
                                                                    <td class="text-nowrap">: <?php echo $data_driver_rev['dikirim_oleh'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="col-md-6 text-nowrap">PJ. Paket Kirim</td> 
                                                                    <td class="text-nowrap">: <?php echo $data_driver_rev['penanggung_jawab'] ?></td>
                                                                </tr>
                                                            <?php
                                                        }
                                                    
                                                    ?>
                                                <?php
                                            }
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <style>
                    /* CSS untuk layar kecil (misalnya, ukuran layar ponsel) */
                    @media (max-width: 767px) {
                        .w-100 {
                            flex-wrap: wrap;
                            justify-content: center;
                        }
                        .p-2 {
                            flex: 1 1 calc(33.33% - 10px);
                            margin: 5px;
                            /* text-align: center; */
                        }
                        .text-end {
                            text-align: center;
                        }
                        .btn {
                            width: 100%;
                            white-space: nowrap; 
                        }
                        .btn button {
                            display: block;
                            margin-top: 10px;
                        }
                        
                    }

                </style>
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-md-7 mb-2">
                                <p class="bg-secondary text-center text-white p-2" style="border-radius: 5px;">
                                    <?php echo $alasan_komplain = komplain::getKondisi($data_kondisi['kondisi_pesanan']); ?>
                                </p>
                            </div>
                            <div class="col-md-5 text-end">
                                <p class="btn btn-secondary" style="margin-right: 38px">
                                    <?php  
                                        if($data_kondisi['kat_komplain'] == 0) {
                                            echo "Invoice";
                                        } else {
                                            echo "Barang";
                                        }
                                    ?>
                                </p>
                            </div>
                        </div>
                        <!-- kode untuk status TRX Dikirim atau Selesai -->
                        <?php 
                            $id_kmpl = $id;
                            $sql_kmpl = mysqli_query($connect, "SELECT status_komplain FROM inv_komplain WHERE id_komplain = '$id_kmpl'");
                            $data_kmpl = mysqli_fetch_array($sql_kmpl);
                            $sql_rev = mysqli_query($connect, "SELECT id_inv, status_pengiriman, status_trx_komplain, status_trx_selesai, created_date FROM inv_revisi WHERE id_inv = '$id_inv' ORDER BY created_date DESC LIMIT 1");
                            $data_rev = mysqli_fetch_array($sql_rev);
                            $total_data_rev = mysqli_num_rows($sql_rev);
                            $status_kmpl = $data_kmpl['status_komplain'];
                        ?>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card-body">
                                    <a href="invoice-komplain.php?date_range=weekly" class="btn btn-warning mb-3">
                                        <i class="bi bi-arrow-left"></i> Halaman Sebelumnya
                                    </a>
                                    <?php  
                                        $cek_bukti_terima = mysqli_query($connect, "SELECT id_komplain FROM inv_bukti_terima_revisi WHERE id_komplain = '$id'");
                                        $total_data_bukti = mysqli_num_rows($cek_bukti_terima);
                                        if($total_data_bukti != '0'){
                                            ?>
                                                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#bukti">
                                                    <i class="bi bi-image"></i> Bukti Terima
                                                </button>
                                            <?php
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card-body text-end">
                                    <?php  
                                        if($jenis_inv == 'ppn'){
                                            ?>
                                                <button class="btn border-dark">
                                                    <?php  
                                                    $total_harga_revisi = 0;
                                                    while($data_total = mysqli_fetch_array($query_produk_total)){
                                                        $total_harga =  $data_total['harga'] * $data_total['qty'];
                                                        $discount = $data_total['disc'] / 100; // 50% diskon
                                                        $harga_final = $total_harga * (1 - $discount); // Harga akhir setelah diskon   
                                                        $total_harga_revisi += $total_harga;
                                                        } 
                                                        $grand_total_revisi = $total_harga_revisi * 1.11 + $data_detail['ongkir'];
                                                    ?>
                                                    <b>Total Invoice Revisi</b><br>
                                                    Rp. <?php echo number_format($grand_total_revisi); ?>
                                                </button> 
                                            <?php
                                        } else {
                                            ?>
                                                 <button class="btn border-dark">
                                                    <?php  
                                                    $total_harga_revisi = 0;
                                                    while($data_total = mysqli_fetch_array($query_produk_total)){
                                                        $total_harga =  $data_total['harga'] * $data_total['qty'];
                                                        $discount = $data_total['disc'] / 100; // 50% diskon
                                                        $harga_final = $total_harga * (1 - $discount); // Harga akhir setelah diskon   
                                                        $total_harga_revisi += $total_harga;
                                                        } 
                                                        $grand_total_revisi = $total_harga_revisi + $data_detail['ongkir'];
                                                    ?>
                                                    <b>Total Invoice Revisi</b><br>
                                                    Rp. <?php echo number_format($grand_total_revisi); ?>
                                                </button> 
                                            <?php
                                        }
                                    
                                    
                                    ?> 
                                </div>
                            </div>
                            <div class="card p-3">
                                <!-- Default Tabs -->
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a href="detail-komplain.php?id=<?php echo base64_encode($id) ?>" class="nav-link">Original</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a href="#" class="nav-link active">Revisi</a>
                                    </li>
                                </ul>
                                <div class="d-flex justify-content-start mb-3 flex-wrap">
                                    <div class="p-2 text-start">
                                        <?php  
                                            $id_komplain = $id;
                                            $sql_komplain = mysqli_query($connect, "SELECT status_refund, status_retur FROM komplain_kondisi WHERE id_komplain = '$id_komplain'");
                                            $data_status_refund = mysqli_fetch_array($sql_komplain);
                                            if($data_status_refund['status_retur'] == 1 && $data_status_refund['status_refund'] == 1) {
                                                ?>
                                                    <a href="#" class="btn btn-secondary mb-3" data-bs-toggle="modal" data-bs-target="#bayarRefund">
                                                        <i></i> Pembayaran Refund
                                                    </a>   
                                                <?php
                                            }
                                        ?>
                                    </div>
                                    <!-- kode untuk kondisi button cetak -->
                                    <?php  
                                        $sql_rev = mysqli_query($connect, "SELECT id_inv, no_inv_revisi FROM inv_revisi WHERE id_inv = '$id_inv' ORDER BY no_inv_revisi DESC LIMIT 1");
                                        $cek_rev = mysqli_fetch_array($sql_rev);
                                        $total_data = mysqli_num_rows($sql_rev);
                                    
                                    ?>                             
                                </div>
                                <div class="table-responsive p-3">
                                    <table class="table table-bordered table-striped" id="table2">
                                        <thead>
                                            <tr class="text-white" style="background-color: navy;">
                                                <th class="text-center text-nowrap p-3">No</th>
                                                <th class="text-center text-nowrap p-3">Nama Produk</th>
                                                <th class="text-center text-nowrap p-3">Satuan</th>
                                                <th class="text-center text-nowrap p-3">Merk</th>
                                                <th class="text-center text-nowrap p-3">Qty Order</th>
                                                <th class="text-center text-nowrap p-3">Harga</th>
                                                <th class="text-center text-nowrap p-3">Diskon</th>
                                                <th class="text-center text-nowrap p-3">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $no = 1;  
                                                include "function/class-spk.php";
                                                while($data_tmp = mysqli_fetch_array($query_produk)){
                                                    $satuan = detailSpkFnc::getSatuan($data_tmp['id_produk']);
                                                    $total_harga =  $data_tmp['harga'] * $data_tmp['qty'];
                                                    $discount = $data_tmp['disc'] / 100; // 50% diskon
                                                    $harga_final = $total_harga * (1 - $discount); // Harga akhir setelah diskon   
                                                    $id_tmp = $data_tmp['id_tmp'];        
                                            ?>
                                            <tr>
                                                <td class="text-center text-nowrap"><?php echo $no ?></td>
                                                <td class="text-nowrap"><?php echo $data_tmp['nama_produk'] ?></td>
                                                <td class="text-center text-nowrap"><?php echo $satuan ?></td>
                                                <td class="text-center text-nowrap"><?php echo $data_tmp['merk'] ?></td>
                                                <td class="text-center text-nowrap"><?php echo number_format($data_tmp['qty']) ?></td>
                                                <td class="text-end text-nowrap"><?php echo number_format($data_tmp['harga']) ?></td>
                                                <td class="text-end text-nowrap"><?php echo $data_tmp['disc'] ?></td>
                                                <td class="text-end text-nowrap"><?php echo number_format($harga_final) ?></td>
                                            </tr>
                                            <?php $no++ ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php
                                    $no = 1;
                                    $sql = "SELECT
                                                COALESCE(nonppn.id_inv_nonppn, ppn.id_inv_ppn, bum.id_inv_bum) AS id_inv,
                                                STR_TO_DATE(ik.tgl_komplain, '%d/%m/%Y') AS tanggal,
                                                ik.id_komplain,
                                                COALESCE(spk_nonppn.id_spk_reg, spk_ppn.id_spk_reg, spk_bum.id_spk_reg) AS id_spk,
                                                COALESCE(spk_nonppn.no_spk, spk_ppn.no_spk, spk_bum.no_spk) AS no_spk,
                                                tpk.id_tmp,
                                                tpk.id_produk,
                                                tpk.nama_produk,
                                                tpk.harga,
                                                tpk.qty,
                                                tpk.disc,
                                                tpk.total_harga,
                                                tpk.status_tmp,
                                                spr.stock,
                                                COALESCE(mr_produk.nama_merk, mr_set.nama_merk) AS merk
                                            FROM inv_komplain AS ik 
                                            LEFT JOIN inv_nonppn nonppn ON ik.id_inv = nonppn.id_inv_nonppn
                                            LEFT JOIN inv_ppn ppn ON ik.id_inv = ppn.id_inv_ppn
                                            LEFT JOIN inv_bum bum ON ik.id_inv = bum.id_inv_bum
                                            LEFT JOIN spk_reg spk_nonppn ON ik.id_inv = spk_nonppn.id_inv
                                            LEFT JOIN spk_reg spk_ppn ON ik.id_inv = spk_ppn.id_inv
                                            LEFT JOIN spk_reg spk_bum ON ik.id_inv = spk_bum.id_inv
                                            LEFT JOIN tmp_produk_komplain tpk ON spk_nonppn.id_inv = tpk.id_inv OR spk_ppn.id_inv = tpk.id_inv OR spk_bum.id_inv = tpk.id_inv
                                            LEFT JOIN stock_produk_reguler spr ON tpk.id_produk = spr.id_produk_reg
                                            LEFT JOIN tb_produk_reguler pr ON tpk.id_produk = pr.id_produk_reg
                                            LEFT JOIN tb_produk_set_marwa tpsm ON tpk.id_produk = tpsm.id_set_marwa
                                            LEFT JOIN tb_merk mr_produk ON pr.id_merk = mr_produk.id_merk -- JOIN untuk produk reguler
                                            LEFT JOIN tb_merk mr_set ON tpsm.id_merk = mr_set.id_merk -- JOIN untuk produk set
                                            WHERE (nonppn.id_inv_nonppn = '$id_inv' OR ppn.id_inv_ppn = '$id_inv' OR bum.id_inv_bum = '$id_inv') AND tpk.status_tmp = '0'";
                                    $query = mysqli_query($connect, $sql);
                                    $totalRows = mysqli_num_rows($query);
                                    if ($totalRows != 0) {
                                ?>
                                <div class="card">
                                    <br>  
                                    <h5 class="text-center">Tambahan Produk Revisi</h5>
                                    <div class="card-body p-2 card-mobile">
                                        <div class="row p-1">
                                            <div class="col-sm-1 mb-2">
                                                <input type="text" class="form-control text-center mobile" style="border: none;" value="No" readonly>
                                            </div>
                                            <div class="col-sm-3 mb-2">
                                                <input type="text" class="form-control text-center" style="border: none;" value="Nama Produk">
                                            </div>
                                            <div class="col-sm-1 mb-2">
                                                <input type="text" class="form-control text-center mobile-text" style="border: none;" value="Satuan" readonly>
                                            </div>
                                            <div class="col-sm-1 mb-2">
                                                <input type="text" class="form-control text-center mobile-text" style="border: none;" value="Merk" readonly>
                                            </div>
                                            <div class="col-sm-2 mb-2">
                                                <input type="text" class="form-control text-center mobile-text" style="border: none;" value="Harga">
                                            </div>
                                            <div class="col-sm-1 mb-2">
                                                <input type="text" class="form-control text-center mobile-text" style="border: none;" value="Stock" readonly>
                                            </div>
                                            <div class="col-sm-1 mb-2">
                                                <input type="text" class="form-control text-center mobile-text" style="border: none;" value="Qty" readonly>
                                            </div>
                                            <div class="col-sm-1 mb-2">
                                                <input type="text" class="form-control text-center mobile-text" style="border: none;" value="Diskon" readonly>
                                            </div>
                                            <div class="col-sm-1 mb-2 text-center">
                                                <input type="text" class="form-control text-center mobile-text" style="border: none;" value="Aksi" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        } else {
                                        }

                                    while ($data = mysqli_fetch_array($query)) {
                                        $id_inv = $data['id_inv'];
                                        $satuan = detailSpkFnc::getSatuan($data['id_produk']);  
                                        // $uuid = generate_uuid();
                                        $isEmpty = false; // Setel variabel pengecekan menjadi false jika ada data
                                    ?>
                                    <form action="proses/produk-tmp.php" method="POST" enctype="multipart/form-data">
                                        <div class="card-body p-2">
                                            <div class="row p-1">
                                                <div class="col-sm-1 mb-2">
                                                    <input type="text" class="form-control text-center bg-light mobile" value="<?php echo $no; ?>" readonly>
                                                    <?php $no++ ?>
                                                </div>
                                                <div class="col-sm-3 mb-2">
                                                    <label class="form-control mobile-text fw-bold label-mobile" style="border: none;">Nama Produk</label> 
                                                    <input type="hidden" name="id_komplain"  value="<?php echo $id ?>" readonly>
                                                    <input type="hidden" name="id_tmp[]" id="id_<?php echo $data['id_tmp'] ?>" value="<?php echo $data['id_tmp'] ?>" readonly>
                                                    <input type="hidden" class="form-control" name="id_produk_tmp[]" value="<?php echo $data['id_produk'] ?>" readonly>
                                                    <input type="text" class="form-control" name="nama_produk[]" value="<?php echo $data['nama_produk']; ?>">
                                                </div>
                                                <div class="col-sm-1 mb-2">
                                                    <label class="form-control mobile-text fw-bold label-mobile" style="border: none;">Satuan</label> 
                                                    <input type="text" class="form-control bg-light text-center mobile-text" value="<?php echo $satuan; ?>" readonly>
                                                </div>
                                                <div class="col-sm-1 mb-2">
                                                    <label class="form-control mobile-text fw-bold label-mobile" style="border: none;">Merk</label> 
                                                    <input type="text" class="form-control bg-light text-center mobile-text" value="<?php echo $data['merk'] ?>" readonly>
                                                </div>
                                                <div class="col-sm-2 mb-2">
                                                    <label class="form-control mobile-text fw-bold label-mobile" style="border: none;">Harga</label> 
                                                    <input type="text" class="form-control text-end mobile-text" name="harga[]" value="<?php echo number_format($data['harga']) ?>" oninput="formatNumberHarga(this)">
                                                </div>
                                                <div class="col-sm-1 mb-2">
                                                    <label class="form-control mobile-text fw-bold label-mobile" style="border: none;">Stock</label> 
                                                    <input type="text" class="form-control bg-light text-end mobile-text" name="stock[]" id="stock_<?php echo $data['id_tmp'] ?>" value="<?php echo number_format($data['stock']) ?>" readonly>
                                                </div>
                                                <div class="col-sm-1 mb-2">
                                                    <label class="form-control mobile-text fw-bold label-mobile" style="border: none;">Qty</label> 
                                                    <input type="text" class="form-control text-end mobile-text" name="qty_tmp[]" id="qtyInput_<?php echo $data['id_tmp'] ?>" oninput="checkStock('<?php echo $data['id_tmp'] ?>')" required>
                                                </div>
                                                <div class="col-sm-1 mb-2">
                                                    <label class="form-control mobile-text fw-bold label-mobile" style="border: none;">Diskon</label> 
                                                    <input type="text" class="form-control text-end mobile-text" name="disc[]" oninput="validasiDiskon(this)" required>
                                                </div>
                                                <div class="col-sm-1 mb-2 text-center">
                                                    <a href="proses/produk-tmp.php?hapus_tmp=<?php echo base64_encode($data['id_tmp']) ?>&&id_komplain=<?php echo base64_encode($id) ?>" class="btn btn-danger btn-sm delete-data"><i class="bi bi-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <div class="card-body mt-3 text-end">
                                            <?php  
                                                if ($totalRows != 0) {
                                                    echo '<button type="submit" class="btn btn-primary" name="simpan-tmp" id="simpan-data"><i class="bi bi-save"></i> Simpan</button>';
                                                }
                                            ?>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
<!-- Modal Bukti Terima -->
<div class="modal fade" id="bukti" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card-body">
                    <?php
                        include "koneksi.php";
                        $sql_bukti = "  SELECT 
                                            ibt.id_komplain, ibt.bukti_satu, ibt.bukti_dua, ibt.bukti_tiga, ibt.created_date, ip.id_komplain, ip.nama_penerima, ip.tgl_terima, ip.created_date, sk.jenis_penerima, sk.dikirim_ekspedisi, sk.no_resi, sk.tgl_kirim, ex.nama_ekspedisi
                                        FROM inv_bukti_terima_revisi AS ibt
                                        LEFT JOIN inv_penerima_revisi ip ON (ibt.id_komplain = ip.id_komplain)
                                        LEFT JOIN revisi_status_kirim sk ON (ibt.id_komplain = sk.id_komplain)
                                        LEFT JOIN ekspedisi ex ON (ex.id_ekspedisi = sk.dikirim_ekspedisi) 
                                        WHERE ibt.id_komplain = '$id_komplain' ORDER BY ip.created_date  DESC LIMIT 1";
                        $query_bukti = mysqli_query($connect, $sql_bukti);
                        $data_bukti = mysqli_fetch_array($query_bukti);
                        $gambar1 = $data_bukti['bukti_satu'];
                        $gambar_bukti1 = "gambar-revisi/bukti1/$gambar1";
                        $gambar2 = $data_bukti['bukti_dua'];
                        $gambar_bukti2 = "gambar-revisi/bukti2/$gambar2";
                        $gambar3 = $data_bukti['bukti_tiga'];
                        $gambar_bukti3 = "gambar-revisi/bukti3/$gambar3";
                        $jenis_penerima = $data_bukti['jenis_penerima'];
                        $no_resi = $data_bukti['no_resi'];
                        $tgl_terima = $data_bukti['tgl_terima'];
                    ?>
                    <div class="mb-3">
                        <?php  
                            if($data_bukti['nama_penerima'] != ''){
                                ?>
                                    <h6>Nama Penerima : <?php echo $data_bukti['nama_penerima'] ?></h6>
                                    <?php if ($jenis_penerima == 'Ekspedisi') {
                                        echo'
                                            <h6>No. Resi :' . $no_resi . '</h6> 
                                        ';
                                    }
                                    ?>
                                <?php
                            }
                        ?>
                        <?php  
                            if( $tgl_terima){
                                ?>
                                <h6>Tgl. Terima : <?php echo $data_bukti['tgl_terima']?></h6>
                                <?php
                            } else {
                                ?>
                                <h6>Tgl. Kirim : <?php echo $data_bukti['tgl_kirim']?></h6>
                                <?php
                            }
                        ?>
                    </div>
                    <div id="carouselExample" class="carousel carousel-dark slide">
                        <div class="carousel-indicators">
                            <?php if (!empty($gambar1)) : ?>
                                <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <?php endif; ?>

                            <?php if (!empty($gambar2)) : ?>
                                <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <?php endif; ?>

                            <?php if (!empty($gambar3)) : ?>
                                <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            <?php endif; ?>
                            
                        </div>
                        <div class="carousel-inner">
                            <?php if (!empty($gambar1)) : ?>
                                <div class="carousel-item active">
                                    <img src="<?php echo $gambar_bukti1 ?>" class="d-block w-100">
                                    <div class="text-center mt-5">
                                        <div class="carousel-caption d-none d-md-block">
                                            <h5>Bukti Terima 1</h5>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($gambar2)) : ?>
                                <div class="carousel-item">
                                    <img src="<?php echo $gambar_bukti2 ?>" class="d-block w-100">
                                    <div class="text-center mt-5">
                                        <div class="carousel-caption d-none d-md-block">
                                            <h5>Bukti Terima 2</h5>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($gambar3)) : ?>
                                <div class="carousel-item">
                                    <img src="<?php echo $gambar_bukti3 ?>" class="d-block w-100">
                                    <div class="text-center mt-5">
                                        <div class="carousel-caption d-none d-md-block">
                                            <h5>Bukti Terima 3</h5>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Bukti Terima -->

<!-- Modal Ubah Status -->
<div class="modal fade" id="ubahStatus">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Status Transaksi Komplain</h1>
            </div>
            <form action="proses/proses-ubah-status.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_komplain" value="<?php echo $id ?>"> 
                <input type="hidden" name="id_inv" value="<?php echo $id_inv ?>"> 
                <input type="hidden" name="no_inv" value="<?php echo $no_inv_fix ?>">
                <input type="hidden" name="cs_inv" value="<?php echo $data_detail['cs_inv'] ?>">
                <input type="hidden" name="alamat" value="<?php echo $data_detail['alamat'] ?>">
                <input type="hidden" name="total_inv" value="<?php echo $grand_total_revisi ?>">
                <input type="hidden" name="jenis_inv" value="<?php echo $jenis_inv ?>">
                <div class="modal-body">
                    <div class="mb-3">  
                        <p>Pilih aksi yang akan dilakukan untuk komplain pelanggan ini</p>
                    </div>
                    <div class="mb-3">
                        <?php  
                            if ($total_data_rev != '0' && $status_kmpl == '0') {
                                $status_pengiriman = $data_rev['status_pengiriman'];
                                $status_trx_komplain = $data_rev['status_trx_komplain'];
                                $status_trx_selesai = $data_rev['status_trx_selesai'];
                                if($status_pengiriman == "1" && $status_trx_komplain == "1" && $status_trx_selesai == "1") {

                                } else if ($status_pengiriman == '1' && $status_trx_komplain == '0' && $status_trx_selesai == '0') {
                                    ?>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status_kirim" id="dikirim" value="dikirim">
                                            <label class="form-check-label" for="dikirim">Dikirim</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status_kirim" id="selesai" value="selesai">
                                            <label class="form-check-label" for="selesai">Transaksi Selesai</label>
                                        </div>
                                    <?php
                                } else if ($status_pengiriman == "1" && $status_trx_komplain == "1" && $status_trx_selesai == "0") {
                                    ?>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status_kirim" id="selesai" value="selesai">
                                            <label class="form-check-label" for="selesai">Transaksi Selesai</label>
                                        </div>
                                    <?php
                                } else if ($status_pengiriman == "0" && $status_trx_komplain == "0" && $status_trx_selesai == "0") {
                                    ?>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status_kirim" id="dikirim" value="dikirim">
                                            <label class="form-check-label" for="dikirim">Dikirim</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status_kirim" id="selesai" value="selesai">
                                            <label class="form-check-label" for="selesai">Transaksi Selesai</label>
                                        </div>
                                    <?php
                                } 
                            } else if ($total_data_rev == '0' && $status_kmpl == '0'){
                                ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status_kirim" id="dikirim" value="dikirim">
                                        <label class="form-check-label" for="dikirim">Dikirim</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input bg-light" type="radio" name="status_kirim" id="selesai" value="selesai" disabled>
                                        <label class="form-check-label" for="selesai">Transaksi Selesai</label>
                                    </div>
                                <?php
                            }
                        ?>
                    </div>
                    <div id="trxKirim" style="display: none;">
                        <div class="mb-3">
                            <label>Jenis Pengiriman</label>
                            <select class="form-select" name="jenis_pengiriman" id="jenis_pengiriman" required>
                                <option value="">Pilih</option>
                                <option value="Driver">Driver</option>
                                <option value="Ekspedisi">Expedisi</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3" id="jenis_driver" style="display: none;">
                        <label id="labelDriver">Pilih Driver</label>
                        <select id="pengirim" name="pengirim" class="form-select">
                            <option value="">Pilih...</option>
                            <?php
                            include "koneksi.php";
                            $sql_driver = mysqli_query($connect, "SELECT us.id_user_role, us.id_user, us.nama_user, rl.role FROM user AS us JOIN user_role rl ON (us.id_user_role = rl.id_user_role) WHERE rl.role = 'Driver'");
                            while ($data_driver_rev = mysqli_fetch_array($sql_driver)) {
                            ?>
                                <option value="<?php echo $data_driver_rev['id_user'] ?>"><?php echo $data_driver_rev['nama_user'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3" id="jenis_ekspedisi" style="display: none;">
                        <div class="mb-3">
                            <label id="labelEkspedisi">Pilih Ekspedisi</label>
                            <select id="ekspedisi" name="ekspedisi" class="form-select">
                                <option value="">Pilih...</option>
                                <?php
                                include "koneksi.php";
                                $sql_ekspedisi = mysqli_query($connect, "SELECT * FROM ekspedisi");
                                while ($data_ekspedisi = mysqli_fetch_array($sql_ekspedisi)) {
                                ?>
                                    <option value="<?php echo $data_ekspedisi['id_ekspedisi'] ?>"><?php echo $data_ekspedisi['nama_ekspedisi'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label id="labelResi">No. Resi</label>
                            <input type="text" class="form-control" name="resi" id="resi">
                        </div>
                        <div class="mb-3">
                            <label id="labelJenisOngkir">Jenis Ongkir</label>
                            <select id="jenis_ongkir" name="jenis_ongkir" class="form-select">
                                <option>Pilih</option>
                                <option value="0">Non COD</option>
                                <option value="1">COD</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label id="labelOngkir">Ongkir</label>
                            <input type="text" class="form-control" style="background-color: #f8f9fa;" name="ongkir" id="ongkos_kirim" readonly>
                        </div>
                        <div class="mb-3">
                            <label id="labelDikirimOleh">Dikirim Oleh</label>
                            <input type="text" class="form-control" name="dikirim" id="dikirim_oleh">
                        </div>
                        <div class="mb-3">
                            <label id="labelPj">Penanggung Jawab</label>
                            <input type="text" class="form-control" name="pj" id="penanggung_jawab">
                        </div>
                    </div>
                    <div class="mb-3" id="tanggal" style="display: none;">
                        <label id="labelDate">Tanggal</label>
                        <input type="text" style="background-color:white;" class="bg-white form-control" name="tgl" id="date" required>
                    </div>
                    <div class="mb-3" id="bukti" style="display: none;">
                        <label id="labelBukti">Bukti Terima 1</label>
                        <input type="file" name="fileku" id="fileku" accept="image/*" onchange="compressAndPreviewImage(event)">
                    </div>
                    <div class="mb-3 preview-image" id="imagePreview"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelDikirim">Tutup</button>
                    <button type="submit" class="btn btn-primary" name="ubah-status"> Ubah Status</button>
                </div>
            </form>
            
            <?php include "page/upload-img.php";  ?>
            <style>
                .preview-image {
                    max-width: 100%;
                    height: auto;
                }
            </style>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var dikirim = document.getElementById('dikirim');
                    var selesai = document.getElementById('selesai');
                    var trxKirim = document.getElementById('trxKirim');
                    var jenisPengiriman = document.getElementById('jenis_pengiriman');
                    var jenisEkspedisi = document.getElementById('jenis_ekspedisi');
                    var jenisDriver = document.getElementById('jenis_driver');
                    var ekspedisi = document.getElementById('ekspedisi');
                    var pengirim = document.getElementById('pengirim');
                    var resi = document.getElementById('resi');
                    var jenis_ongkir = document.getElementById('jenis_ongkir');
                    var bukti = document.getElementById('bukti');
                    var tanggal = document.getElementById('tanggal');
                    var ongkos_kirim = document.getElementById('ongkos_kirim');
                    var penanggung_jawab = document.getElementById('penanggung_jawab');
                    var dikirim_oleh = document.getElementById('dikirim_oleh');
                    var fileku = document.getElementById('fileku');

                    // Tambahkan event listener untuk menangani perubahan pada radio button "Selesai"
                    dikirim.addEventListener('change', function() {
                        if (dikirim.checked) {
                            trxKirim.style.display = 'block';
                            jenisPengiriman.style.display = 'block'; // Tampilkan jenis pengiriman saat dikirim dipilih
                            tanggal.style.display = 'none'; // Tampilkan jenis pengiriman saat dikirim dipilih
                        }
                    });
                    selesai.addEventListener('change', function() {
                        if (selesai.checked) {
                            trxKirim.style.display = 'none';
                            jenisPengiriman.style.display = 'none'; // Sembunyikan jenis pengiriman saat selesai dipilih
                            jenisPengiriman.value = ''; // Sembunyikan jenis pengiriman saat selesai dipilih
                            jenisDriver.style.display = 'none'; // Sembunyikan jenis pengiriman saat selesai dipilih
                            jenisEkspedisi.style.display = 'none';
                            bukti.style.display = 'none';
                            tanggal.style.display = 'block'; // Tampilkan jenis pengiriman saat dikirim dipilih
                            jenisPengiriman.removeAttribute('required');
                        }
                    });

                    jenisPengiriman.addEventListener('change', function() {
                        if (this.value === 'Driver') {
                            jenisDriver.style.display = 'block';
                            jenisEkspedisi.style.display = 'none';
                            ekspedisi.value = '';
                            ekspedisi.removeAttribute('required');
                            resi.value = '';
                            resi.removeAttribute('required');
                            jenis_ongkir.value = '';
                            jenis_ongkir.removeAttribute('required');
                            tanggal.value = '';
                            tanggal.removeAttribute('required');
                            pengirim.style.display = 'block';
                            pengirim.setAttribute('required', 'true');
                            tanggal.style.display = 'block'; // Tampilkan jenis pengiriman saat dikirim dipilih
                        } else if (this.value === 'Ekspedisi') {
                            jenisEkspedisi.style.display = 'block';
                            jenisDriver.style.display = 'none';
                            pengirim.value = '';
                            ekspedisi.value = '';
                            ekspedisi.setAttribute('required', 'true');
                            resi.value = '';
                            resi.setAttribute('required', 'true');
                            jenis_ongkir.value = '';
                            jenis_ongkir.setAttribute('required', 'true');
                            tanggal.value = '';
                            tanggal.removeAttribute('required');
                            ongkos_kirim.value = '';
                            ongkos_kirim.removeAttribute('required');
                            penanggung_jawab.value = '';
                            penanggung_jawab.removeAttribute('required');
                            bukti.style.display = 'block';
                            dikirim_oleh.value = '';
                            dikirim_oleh.removeAttribute('required');
                            tanggal.style.display = 'block'; // Tampilkan jenis pengiriman saat dikirim dipilih
                        } else {
                            jenisEkspedisi.style.display = 'none';
                            jenisDriver.style.display = 'none';
                            ekspedisi.value = '';
                            ekspedisi.removeAttribute('required');
                            
                            // Disembunyikan elemen-elemen yang tidak diperlukan
                            pengirim.style.display = 'none';
                            bukti.style.display = 'none';
                        }
                    });

                    jenis_ongkir.addEventListener('change', function() {
                        if (this.value === '0') {
                            ongkos_kirim.style.display = 'block';
                            ongkos_kirim.style.backgroundColor = '';
                            ongkos_kirim.removeAttribute('readonly');
                            ongkos_kirim.setAttribute('required', 'true');
                        } else {
                            ongkos_kirim.style.display = 'block';
                            ongkos_kirim.style.backgroundColor = '#f8f9fa';
                            ongkos_kirim.removeAttribute('required');
                            ongkos_kirim.setAttribute('readonly', 'true');
                            ongkos_kirim.value = '0';
                        }
                    });

                   // Menambahkan event listener untuk memformat angka saat nilai berubah
                    ongkos_kirim.addEventListener('input', function() {
                        formatNumber(ongkos_kirim);
                    });

                    // Fungsi untuk memformat angka
                    function formatNumber(input) {
                        var value = input.value.replace(/\D/g, ''); // Menghapus karakter non-digit
                        value = new Intl.NumberFormat().format(value); // Memformat angka
                        input.value = value;
                    }

                    // Mendapatkan tombol "Cancel" berdasarkan ID
                    const cancelButton = document.getElementById('cancelDikirim');

                    // Fungsi untuk mengatur ulang input teks dan tombol
                    // Event listener saat tombol "Cancel" ditekan
                    cancelButton.addEventListener('click', function() {
                        // Memuat ulang halaman saat tombol "Tutup" ditekan
                        location.reload();
                    });
                });

                flatpickr("#date", {
                    dateFormat: "d/m/Y",
                    defaultDate: "today"
                });
            </script>
        </div>
    </div>
</div>
<!-- End Modal Ubah Status -->

<!-- Modal Refund -->
<div class="modal fade" id="bayarRefund" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card text-center p-3">
                    <p class="text-center" style="font-size: 20px;"><b>Barang Refund Dana</b></p>
                    <div class="d-flex justify-content-center">
                        <div class="card p-3 border">
                            <p class="text-center" style="font-size: 18px;">
                                Total Nilai Refund <br>
                                <?php  
                                    $grand_total_refund = 0;
                                    while($total_refund = mysqli_fetch_array($query_total_refund)){
                                        $harga_total =  $total_refund['harga'] * $total_refund['qty'];
                                        $disc = $total_refund['disc'];
                                        $hasil_disc = $disc / 100;
                                        $harga_final = $harga_total * (1 - $hasil_disc); // Harga akhir setelah diskon  
                                        $grand_total_refund += $harga_final;
                                    }
                                ?>
                                <?php  echo number_format($grand_total_refund)?>
                            </p>   
                        </div>
                    </div>
                    <div class="table-responsive p-3">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-white" style="background-color: navy;">
                                            <th class="text-center text-nowrap p-3">No</th>
                                            <th class="text-center text-nowrap p-3">Nama Produk</th>
                                            <th class="text-center text-nowrap p-3">Satuan</th>
                                            <th class="text-center text-nowrap p-3">Merk</th>
                                            <th class="text-center text-nowrap p-3">Qty Order</th>
                                            <th class="text-center text-nowrap p-3">Harga</th>
                                            <th class="text-center text-nowrap p-3">Diskon</th>
                                            <th class="text-center text-nowrap p-3">Total</th>
                                            <th class="text-center text-nowrap p-3">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $no = 1;
                                            while($data_refund = mysqli_fetch_array($query_refund)){
                                                $id_produk = $data_refund['id_produk'];
                                                $total_harga =  $data_refund['harga'] * $data_refund['qty'];
                                                $discount = $data_refund['disc'] / 100; // 50% diskon
                                                $harga_final = $total_harga * (1 - $discount); // Harga akhir setelah diskon  
                                                $id_produk_substr = substr($id_produk, 0, 2);
                                                $pcs = 'Pcs';
                                                $set = 'Set';    
                                        ?>
                                        <tr>
                                            <td class="text-center text-nowrap"><?php echo $no ?></td>
                                            <td class="text-nowrap text-start"><?php echo $data_refund['nama_produk'] ?></td>
                                            <td class="text-center text-nowrap">
                                                <?php 
                                                    if($id_produk_substr == 'BR'){
                                                        echo $pcs;
                                                    } else {
                                                        echo $set;
                                                    }   
                                                ?>
                                            </td>
                                            <td class="text-center text-nowrap"><?php echo $data_refund['merk'] ?></td>
                                            <td class="text-center text-nowrap"><?php echo $data_refund['qty'] ?></td>
                                            <td class="text-end text-nowrap"><?php echo number_format($data_refund['harga']) ?></td>
                                            <td class="text-end text-nowrap"><?php echo $data_refund['disc'] ?></td>
                                            <td class="text-end text-nowrap"><?php echo number_format($harga_final) ?></td>
                                            <td class="text-center text-nowrap">
                                                <a href="proses/produk-tmp.php?batal_refund=<?php echo base64_encode($data_refund['id_tmp']) ?>&&id_komplain=<?php echo base64_encode($id) ?>" class="btn btn-danger btn-sm">Batal Refund</a>
                                            </td>
                                        </tr>
                                        <?php $no++ ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>          
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Refund -->




