<?php
$page  = 'list-komplain';
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
        <!-- <div class="loader loader">
            <div class="loading">
                <img src="img/loading.gif" width="200px" height="auto">
            </div>
        </div> -->
        <!-- ENd Loading -->
        <section>
            <?php  
                include "koneksi.php";
                $id_role = $_SESSION['tiket_role'];
                $sql_role = "SELECT * FROM user_role WHERE id_user_role='$id_role'";
                $query_role = mysqli_query($connect, $sql) or die(mysqli_error($connect));
                $data_role = mysqli_fetch_array($query_role);
            ?>
            <!-- SWEET ALERT -->
            <div class="info-data" data-infodata="<?php if (isset($_SESSION['info'])) {
                                                        echo $_SESSION['info'];
                                                        }
                                                        unset($_SESSION['info']); ?>"></div>
            <!-- END SWEET ALERT -->
            <?php  
                $id = base64_decode($_GET['id']);
                include "../query/detail-komplain-nonppn.php";
                $id_inv = $data_kondisi['id_inv'];
                $no_inv = $data_detail['no_inv'];
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
                                                            nonppn.id_inv_nonppn AS id_inv,
                                                            max(rev.no_inv_revisi) AS no_inv_revisi
                                                        FROM inv_revisi AS rev
                                                        LEFT JOIN inv_komplain ik ON rev.id_inv = ik.id_inv
                                                        LEFT JOIN inv_nonppn nonppn ON ik.id_inv = nonppn.id_inv_nonppn
                                                        WHERE '$id_inv' IN (nonppn.id_inv_nonppn) GROUP BY id_inv
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
                                <a href="invoice-komplain.php?date_range=year" class="btn btn-warning mb-3">
                                    <i class="bi bi-arrow-left"></i> Halaman Sebelumnya
                                </a>
                                <?php  
                                    $cek_bukti_terima = mysqli_query($connect, "SELECT id_komplain FROM inv_bukti_terima_revisi WHERE id_komplain = '$id'");
                                    $total_data_bukti = mysqli_num_rows($cek_bukti_terima);
                                    if($total_data_bukti != '0'){
                                        ?>
                                            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#bukti">
                                                <i class="bi bi-image"></i> Bukti Terima Revisi
                                            </button>
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-body text-end">
                                <?php  
                                    if($jenis_inv == 'nonppn'){
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
                        <!-- Default Tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="detail-komplain-nonppn.php?id=<?php echo base64_encode($id) ?>" class="nav-link">Original</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#" class="nav-link active">Revisi</a>
                            </li>
                        </ul>
                        <div class="card p-3">
                            <div class="table-responsive p-3">
                                <table class="table table-bordered table-striped" id="table2">
                                    <thead>
                                        <tr class="text-white" style="background-color: navy;">
                                            <th class="text-center text-nowrap p-3">No</th>
                                            <th class="text-center text-nowrap p-3">Nama Produk</th>
                                            <th class="text-center text-nowrap p-3">Merk</th>
                                            <th class="text-center text-nowrap p-3">Qty Order</th>
                                            <th class="text-center text-nowrap p-3">Satuan</th>
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
                                            <td class="text-center text-nowrap"><?php echo $data_tmp['merk'] ?></td>
                                            <td class="text-center text-nowrap"><?php echo number_format($data_tmp['qty']) ?></td>
                                            <td class="text-center text-nowrap"><?php echo $satuan ?></td>
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
                                $sql = "SELECT DISTINCT
                                            nonppn.id_inv_nonppn AS id_inv,
                                            STR_TO_DATE(ik.tgl_komplain, '%d/%m/%Y') AS tanggal,
                                            ik.id_komplain,
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
                                        LEFT JOIN tmp_produk_komplain tpk ON nonppn.id_inv_nonppn = tpk.id_inv
                                        LEFT JOIN stock_produk_reguler spr ON tpk.id_produk = spr.id_produk_reg
                                        LEFT JOIN tb_produk_reguler pr ON tpk.id_produk = pr.id_produk_reg
                                        LEFT JOIN tb_produk_set_marwa tpsm ON tpk.id_produk = tpsm.id_set_marwa
                                        LEFT JOIN tb_merk mr_produk ON pr.id_merk = mr_produk.id_merk -- JOIN untuk produk reguler
                                        LEFT JOIN tb_merk mr_set ON tpsm.id_merk = mr_set.id_merk -- JOIN untuk produk set
                                        WHERE (nonppn.id_inv_nonppn = '$id_inv') AND tpk.status_tmp = '0'";
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
                                <form action="proses/produk-tmp-revisi-nonppn.php" method="POST" enctype="multipart/form-data">
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
                                                <a href="proses/produk-tmp-revisi-nonppn.php?hapus_tmp=<?php echo base64_encode($data['id_tmp']) ?>&&id_komplain=<?php echo base64_encode($id) ?>" class="btn btn-danger btn-sm delete-data"><i class="bi bi-trash"></i></a>
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
                                        WHERE ibt.id_komplain = '$id' ORDER BY ip.created_date  DESC LIMIT 1";
                        $query_bukti = mysqli_query($connect, $sql_bukti);
                        $data_bukti = mysqli_fetch_array($query_bukti);
                        $gambar1 = $data_bukti['bukti_satu'];
                        $gambar_bukti1 = "../gambar-revisi/bukti1/$gambar1";
                        $gambar2 = $data_bukti['bukti_dua'];
                        $gambar_bukti2 = "../gambar-revisi/bukti2/$gambar2";
                        $gambar3 = $data_bukti['bukti_tiga'];
                        $gambar_bukti3 = "../gambar-revisi/bukti3/$gambar3";
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
<!-- Refresh page -->
<script>
    function refreshPage() {
        location.reload();
    }
</script>


