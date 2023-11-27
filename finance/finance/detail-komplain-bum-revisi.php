<?php
    $page  = 'list-cmp';
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
        <link rel="stylesheet" href="../assets/css/wrap-text.css">
    
        <?php include "page/head.php"; ?>
        <?php include "page/style-button-filterdate.php"; ?>

        <style>
            .label-mobile{
                display: none;
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
                    $id = base64_decode($_GET['id']);
                    include "query/detail-komplain.php";
                    $id_inv = $data_kondisi['id_inv'];
                    echo $id_inv;
                    include "query/produk-komplain-tmp.php";
                ?>
                <div class="card p-2">     
                    <div class="row mb-2">
                        <!-- Kolom No Komplain (di atas) -->
                        <div class="col-md-3">
                            <button class="btn btn-secondary">No Komplain : <?php echo $data_detail['no_komplain'] ?></button>
                        </div>
                        <!-- Kolom Open (di tengah) -->
                        <div class="col-md-6 text-center">
                            <p><b>Detail Invoice BUM (REVISI)</b></p>
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
                                            <td class="text-nowrap">: <?php echo $data_detail['no_inv'] ?></td>
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
                                        <tr>
                                            <td class="col-md-6 text-nowrap">Jenis Pengiriman</td>
                                            <td class="text-nowrap">
                                                :   <?php  
                                                        if($data_driver['jenis_pengiriman'] == 'Driver'){
                                                            ?>
                                                                <?php echo $data_driver['jenis_pengiriman']?> (<?php echo $data_driver['nama_driver'] ?>)
                                                            <?php
                                                        } else {
                                                            ?>
                                                                <?php echo $data_driver['jenis_pengiriman']?> (<?php echo $data_driver['nama_ekspedisi'] ?>)
                                                            <?php
                                                        }
                                                
                                                    ?>

                                            </td>
                                        </tr>
                                        <?php  
                                            if(!empty($data_driver['jenis_penerima']) && $data_driver['jenis_pengiriman'] == 'Driver'){
                                                ?>
                                                    <tr>
                                                        <td class="col-md-6 text-nowrap">Diterima Oleh</td>
                                                        <td class="text-nowrap">
                                                            :   <?php 
                                                                    if($data_driver['jenis_penerima'] == 'Customer'){
                                                                        ?>
                                                                            <?php echo $data_driver['jenis_penerima'] ?> 
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                            <?php echo $data_driver['jenis_penerima'] ?> (<?php echo $data_driver['nama_ekspedisi'] ?>)
                                                                        <?php
                                                                    }
                                                            
                                                                ?>
                                                    
                                                        </td>
                                                    </tr>
                                                <?php
                                            }
                                        
                                        ?>
                                        <?php  
                                            if(!empty($data_driver['nama_penerima'])){
                                                ?>
                                                    <tr>
                                                        <td class="col-md-6 text-nowrap">Nama Penerima</td>
                                                        <td class="text-nowrap">: <?php echo $data_driver['nama_penerima'] ?></td>
                                                    </tr>
                                                <?php
                                            }
                                        
                                        ?>
                                        <?php  
                                            if(!empty($data_driver['dikirim_oleh']) && !empty($data_driver['penanggung_jawab'])){
                                                ?>
                                                    <tr>
                                                        <td class="col-md-6 text-nowrap">Dikirim Oleh</td>
                                                        <td class="text-nowrap">: <?php echo $data_driver['dikirim_oleh'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-6 text-nowrap">PJ. Paket Kirim</td>
                                                        <td class="text-nowrap">: <?php echo $data_driver['penanggung_jawab'] ?></td>
                                                    </tr>
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
                            text-align: center;
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
                <div class="card p-3">
                    <div class="row">
                        <div class="col-md-7 mb-3">
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
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card-body">
                                    <a href="invoice-komplain.php?date_range=lastMonth" class="btn btn-warning mb-3">
                                        <i class="bi bi-arrow-left"></i> Halaman Sebelumnya
                                    </a>
                               
                                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#bukti">
                                        <i class="bi bi-image"></i> Bukti Terima
                                    </button>

                                    <a href="#" class="btn btn-primary mb-3">
                                        <i></i> Ubah Status
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card-body text-end">
                                    <button class="btn border-dark">
                                        <?php  
                                            $total_harga = 0;
                                            while($data_total_revisi = mysqli_fetch_array($query_total)){
                                                $total_harga += $data_total_revisi['total_harga'];
                                           } 
                                           $grand_total_revisi = $total_harga + $data_detail['ongkir'];
                                        ?>
                                        <b>Total Invoice Revisi</b><br>
                                        Rp. <?php echo number_format($grand_total_revisi); ?>
                                    </button>  
                                </div>
                            </div>
                        </div>                   
                        <!-- Default Tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="detail-komplain-bum.php?id=<?php echo base64_encode($id) ?>" class="nav-link">Original</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#" class="nav-link active">Revisi</a>
                            </li>
                        </ul>
                        <div class="card p-3">
                            <div class="d-flex justify-content-start mb-3 flex-wrap">
                                <div class="p-2" id="edit" style="display: block;">
                                    <button type="button" class="btn btn-warning" id="edit-button">
                                        <i class="bi bi-pencil"></i> Edit Data Produk
                                    </button>            
                                </div>   
                                <div class="p-2" id="selesai-edit" style="display: none;">
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#selesaiEdit">
                                        <i class="bi bi-pencil"></i> Selesai Edit
                                    </button>            
                                </div>   
                                <div class="p-2">
                                    <button type="button" class="btn btn-primary tambahData" data-inv="<?php echo $id_inv ?>" data-bs-toggle="modal" data-bs-target="#tambahData" style="display: none;">
                                        <i class="bi bi-plus-circle"></i> Tambah data produk
                                    </button>   
                                </div>
                                <div class="p-2 text-start">
                                    <?php  
                                        $id_komplain = $id;
                                        $sql_komplain = mysqli_query($connect, "SELECT status_refund, status_retur FROM inv_komplain WHERE id_komplain = '$id_komplain'");
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
                                <div class="p-2 text-start">
                                    <a href="#" class="btn btn-primary mb-3">
                                        <i></i> Cetak Invoice
                                    </a> 
                                </div>                                
                            </div>
                            <div class="table-responsive p-3">
                                <table class="table table-bordered table-striped" id="table2">
                                    <thead>
                                        <tr class="text-white" style="background-color: navy;">
                                            <th class="text-center text-nowrap p-3">No</th>
                                            <th class="text-center text-nowrap p-3">No.SPK</th>
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
                                            include "function/class-spk.php";
                                            while($data_tmp = mysqli_fetch_array($query_tmp)){
                                                $satuan = detailSpkFnc::getSatuan($data_tmp['id_produk']);
                                                $total_harga =  $data_tmp['harga'] * $data_tmp['qty'];
                                                $discount = $data_tmp['disc'] / 100; // 50% diskon
                                                $harga_final = $total_harga * (1 - $discount); // Harga akhir setelah diskon  
                                                $id_tmp = $data_tmp['id_tmp'];        
                                        ?>
                                        <tr>
                                            <td class="text-center text-nowrap"><?php echo $no ?></td>
                                            <td class="text-center text-nowrap"><?php echo $data_tmp['no_spk'] ?></td>
                                            <td class="text-nowrap"><?php echo $data_tmp['nama_produk'] ?></td>
                                            <td class="text-center text-nowrap"><?php echo $satuan ?></td>
                                            <td class="text-center text-nowrap"><?php echo $data_tmp['merk'] ?></td>
                                            <td class="text-center text-nowrap"><?php echo $data_tmp['qty'] ?></td>
                                            <td class="text-end text-nowrap"><?php echo number_format($data_tmp['harga']) ?></td>
                                            <td class="text-end text-nowrap"><?php echo $data_tmp['disc'] ?></td>
                                            <td class="text-end text-nowrap"><?php echo number_format($harga_final) ?></td>
                                            <td class="text-center">
                                                <div class="text-center aksi" style="display: none;">
                                                    <button class="btn btn-warning btn-sm mb-2" title="Edit Data" data-bs-toggle="modal" data-bs-target="#editData" data-id="<?php echo $data_tmp['id_tmp'] ?>" data-nama="<?php echo $data_tmp['nama_produk'] ?>" data-merk="<?php echo $data_tmp['merk'] ?>" data-harga="<?php echo $data_tmp['harga'] ?>" data-disc="<?php echo $data_tmp['disc'] ?>" data-stock="<?php echo $data_tmp['stock'] ?>" data-qty="<?php echo $data_tmp['qty'] ?>">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <?php  
                                                        $id_komplain = $id;
                                                        $sql_komplain = mysqli_query($connect, "SELECT status_refund, status_retur FROM inv_komplain WHERE id_komplain = '$id_komplain'");
                                                        $data_status_refund = mysqli_fetch_array($sql_komplain);
                                                        if($data_status_refund['status_retur'] == 1 && $data_status_refund['status_refund'] == 0){
                                                            ?>
                                                                <a href="proses/produk-tmp.php?hapus_tmp=<?php echo base64_encode($id_tmp) ?>&&id_komplain=<?php echo base64_encode($id_komplain) ?>" class="btn btn-danger btn-sm delete-data"><i class="bi bi-trash"></i></a>
                                                            <?php
                                                        } else if($data_status_refund['status_retur'] == 1 && $data_status_refund['status_refund'] == 1) {
                                                            ?>
                                                                <button type="button" class="btn btn-danger btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#hapus" data-id="<?php echo $data_tmp['id_tmp'] ?>" data-total="<?php echo $harga_final ?>">
                                                                    <i class="bi bi-trash"></i>
                                                                </button> 
                                                            <?php
                                                        }
                                                    ?>
                                                </div>     
                                            </td>
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
                                        ik.kat_komplain,
                                        ik.kondisi_pesanan,
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
                                                <input type="text" class="form-control bg-light text-end mobile-text" name="stock" id="stock_<?php echo $data['id_tmp'] ?>" value="<?php echo number_format($data['stock']) ?>" readonly>
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
                        </div><!-- End Default Tabs -->
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
                        $sql_bukti = "SELECT ibt.*, ip.id_inv, ip.nama_penerima, ip.tgl_terima, sk.jenis_penerima, sk.dikirim_ekspedisi, sk.no_resi, ex.nama_ekspedisi
                                        FROM inv_bukti_terima AS ibt
                                        LEFT JOIN inv_penerima ip ON (ibt.id_inv = ip.id_inv)
                                        LEFT JOIN status_kirim sk ON (ibt.id_inv = sk.id_inv)
                                        LEFT JOIN ekspedisi ex ON (ex.id_ekspedisi = sk.dikirim_ekspedisi) 
                                        WHERE ibt.id_inv = '$id_inv'";
                        $query_bukti = mysqli_query($connect, $sql_bukti);
                        $data_bukti = mysqli_fetch_array($query_bukti);
                        $gambar1 = $data_bukti['bukti_satu'];
                        $gambar_bukti1 = "../gambar/bukti1/$gambar1";
                        $gambar2 = $data_bukti['bukti_dua'];
                        $gambar_bukti2 = "../gambar/bukti2/$gambar2";
                        $gambar3 = $data_bukti['bukti_tiga'];
                        $gambar_bukti3 = "../gambar/bukti3/$gambar3";
                        $jenis_penerima = $data_bukti['jenis_penerima'];
                        $no_resi = $data_bukti['no_resi'];
                    ?>
                    <div class="mb-3">
                        <h6>Nama Penerima : <?php echo $data_bukti['nama_penerima'] ?></h6>
                        <?php if ($jenis_penerima == 'Ekspedisi') {
                            echo'
                                <h6>No. Resi :' . $no_resi . '</h6> 
                            ';
                        }
                        ?>
                        <h6>Tgl. Terima : <?php echo date('d/m/Y', strtotime($data_bukti['created_date']))?></h6>
                    </div>
                    <div id="carouselExample" class="carousel slide">
                        <div class="carousel-inner">
                            <?php if (!empty($gambar1)) : ?>
                                <div class="carousel-item active">
                                    <img src="<?php echo $gambar_bukti1 ?>" class="d-block w-100">
                                    <div class="text-center mt-3">
                                        <h5>Bukti Terima 1</h5>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($gambar2)) : ?>
                                <div class="carousel-item">
                                    <img src="<?php echo $gambar_bukti2 ?>" class="d-block w-100">
                                    <div class="text-center mt-3">
                                        <h5>Bukti Terima 2</h5>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($gambar3)) : ?>
                                <div class="carousel-item">
                                    <img src="<?php echo $gambar_bukti3 ?>" class="d-block w-100">
                                    <div class="text-center mt-3">
                                        <h5>Bukti Terima 3</h5>
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

<!-- Modal Add Produk -->
<div class="modal fade" id="tambahData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form method="post" action=""> <!-- Tambahkan form dengan method POST -->
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Data Barang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="table3">
                            <thead>
                                <tr class="text-white" style="background-color: #051683;">
                                    <td class="text-center p-3 text-nowrap" style="width: 50px">No</td>
                                    <td class="text-center p-3 text-nowrap" style="width: 350px">Nama Produk</td>
                                    <td class="text-center p-3 text-nowrap" style="width: 100px">Satuan</td>
                                    <td class="text-center p-3 text-nowrap" style="width: 100px">Merk</td>
                                    <td class="text-center p-3 text-nowrap" style="width: 100px">Stock</td>
                                    <td class="text-center p-3 text-nowrap" style="width: 100px">Aksi</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "koneksi.php";
                                $id = $_GET['id'];
                                $selected_produk = [];
                                $no = 1;

                                // Mengambil data produk yang ada dalam tmp_produk_spk untuk id_spk yang sedang aktif
                                $query_selected_produk = mysqli_query($connect, "SELECT id_produk FROM tmp_produk_komplain WHERE id_inv = '$id_inv'");
                                while ($selected_data = mysqli_fetch_array($query_selected_produk)) {
                                    $selected_produk[] = $selected_data['id_produk'];
                                }

                                $sql = "SELECT 
                                            COALESCE(tpr.id_produk_reg, tpsm.id_set_marwa) AS id_produk,
                                            COALESCE(tpr.nama_produk, tpsm.nama_set_marwa) AS nama_produk,
                                            COALESCE(tpr.harga_produk, tpsm.harga_set_marwa) AS harga_produk,
                                            COALESCE(mr_tpr.nama_merk, mr_tpsm.nama_merk) AS nama_merk,
                                            spr.id_stock_prod_reg,
                                            spr.stock,
                                            tkp.min_stock, 
                                            tkp.max_stock
                                        FROM stock_produk_reguler AS spr
                                        LEFT JOIN tb_produk_reguler AS tpr ON (tpr.id_produk_reg = spr.id_produk_reg)
                                        LEFT JOIN tb_kat_penjualan AS tkp ON (tkp.id_kat_penjualan = spr.id_kat_penjualan)
                                        LEFT JOIN tb_produk_set_marwa AS tpsm ON (tpsm.id_set_marwa = spr.id_produk_reg)
                                        LEFT JOIN tb_merk AS mr_tpr ON (tpr.id_merk = mr_tpr.id_merk)
                                        LEFT JOIN tb_merk AS mr_tpsm ON (tpsm.id_merk = mr_tpsm.id_merk)
                                        ORDER BY nama_produk ASC";

                                $query = mysqli_query($connect, $sql);

                                while ($data = mysqli_fetch_array($query)) {
                                    $id_produk = $data['id_produk'];
                                    $id_produk_substr = substr($id_produk, 0, 2);
                                    $isChecked = in_array($id_produk, $selected_produk);
                                    $isDisabled = false;

                                    if ($data['stock'] == 0) {
                                        $isDisabled = true; // Jika stock = 0, maka tombol pilih akan menjadi disabled
                                    }
                                ?>
                                    <tr>
                                        <td class="text-center text-nowrap"><?php echo $no; ?></td>
                                        <td class="text-nowrap"><?php echo $data['nama_produk']; ?></td>
                                        <td class="text-center text-nowrap">
                                            <?php 
                                            if($id_produk_substr == 'BR'){
                                                echo "Pcs";
                                            } else {
                                                echo "Set";
                                            }
                                            ?>
                                        </td>
                                        <td class="text-center text-nowrap"><?php echo $data['nama_merk']; ?></td>
                                        <td class="text-center text-nowrap"><?php echo number_format($data['stock']); ?></td>
                                        <td class="text-center text-nowrap">
                                            <button class="btn-pilih btn btn-primary btn-sm"  data-inv="<?php echo $id_inv; ?>" data-id-produk="<?php echo $id_produk; ?>" data-nama-produk="<?php echo $data['nama_produk']; ?>" data-harga="<?php echo $data['harga_produk']; ?>"  <?php echo ($isChecked || $isDisabled) ? 'disabled' : ''; ?>>Pilih</button>
                                        </td>
                                    </tr>
                                    <?php $no++; ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="refreshPage()">Tutup</button>
                </div>
            </form> <!-- Akhir dari form -->
        </div>
    </div>
</div>

<!-- Modal Selesai Edit -->
<div class="modal fade" id="selesaiEdit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <?php  
                    $sql_button = "SELECT
                        COALESCE(nonppn.id_inv_nonppn, ppn.id_inv_ppn, bum.id_inv_bum) AS id_inv,
                        tpk.id_produk,
                        tpk.nama_produk,
                        tpk.qty,
                        tpk.total_harga,
                        tpk.status_tmp
                    FROM inv_komplain AS ik
                    LEFT JOIN inv_nonppn nonppn ON ik.id_inv = nonppn.id_inv_nonppn
                    LEFT JOIN inv_ppn ppn ON ik.id_inv = ppn.id_inv_ppn
                    LEFT JOIN inv_bum bum ON ik.id_inv = bum.id_inv_bum
                    LEFT JOIN spk_reg spk_nonppn ON ik.id_inv = spk_nonppn.id_inv
                    LEFT JOIN spk_reg spk_ppn ON ik.id_inv = spk_ppn.id_inv
                    LEFT JOIN spk_reg spk_bum ON ik.id_inv = spk_bum.id_inv
                    LEFT JOIN tmp_produk_komplain tpk ON spk_nonppn.id_inv = tpk.id_inv OR spk_ppn.id_inv = tpk.id_inv OR spk_bum.id_inv = tpk.id_inv
                    LEFT JOIN tb_produk_reguler pr ON tpk.id_produk = pr.id_produk_reg
                    LEFT JOIN tb_produk_set_marwa tpsm ON tpk.id_produk = tpsm.id_set_marwa
                    WHERE nonppn.id_inv_nonppn = '$id_inv' OR ppn.id_inv_ppn = '$id_inv' OR bum.id_inv_bum = '$id_inv'";
                    $query_button = mysqli_query($connect, $sql_button);

                    // Inisialisasi variabel statusTmpDisabled
                    $statusTmpDisabled = false;

                    // Loop melalui hasil query untuk mengecek status_tmp
                    while ($row = mysqli_fetch_array($query_button)) {
                        if ($row['status_tmp'] == 0) {
                            $statusTmpDisabled = true; // Set variabel statusTmpDisabled menjadi true jika ada status_tmp yang = 0
                            break; // Keluar dari loop jika sudah ditemukan satu status_tmp yang = 0
                        }
                    }

                    $selisih = $grand_total_revisi - $data_total['total_inv'];
                ?>
                <h5>
                    Terdapat perbedaan total invoice setelah perubahan senilai <b><?php echo number_format($selisih) ?></b> dari sebelumnya <b><?php echo number_format($data_total['total_inv']) ?></b><br>
                    Apakah anda yakin sudah selesai merubah barang pada orderan ini ?
                </h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Belum Selesai</button>
                <?php
                if ($statusTmpDisabled) {
                    // Jika statusTmpDisabled adalah true, maka tambahkan atribut disabled pada tombol "Sudah Selesai"
                    echo '<button type="button" class="btn btn-primary" disabled>Sudah Selesai</button>';
                } else {
                    // Jika statusTmpDisabled adalah false, maka tampilkan tombol "Sudah Selesai" tanpa atribut disabled
                    echo '<button type="button" class="btn btn-primary">Sudah Selesai</button>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="hapus" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <form action="proses/produk-tmp.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <p>
                    Pilih jenis hapus untuk barang ini: <br>
                    * Jika anda memilih delete only maka nilai barang tidak akan masuk kedalam perhitungan refund (akan hapus permanen)<br>
                    ** Jika anda memilih delete refund maka nilai barang akan masuk kedalam perhitungan refund 
                </p>
                <input type="text" name="id_tmp" id="id_tmp">
                <input type="text" name="total_harga" id="total_harga">
                <input type="text" name="id_komplain" value="<?php echo base64_decode($id) ?>">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary" name="hapus-produk-tmp">Delete Only</button> 
                
                <button type="submit" class="btn btn-primary" name="hapus-produk-refund">Delete Refund</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- End Modal Hapus -->

<!-- Alert Hapus -->
<div class="modal fade" id="hapusAlert" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <form action="proses/produk-tmp.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <p>Apakah anda yakin ingin refund dana dengan nominal <b>Rp.</b><b id="total_harga"></b> ?</p>
                <input type="hidden" name="id_tmp">
                <input type="hidden" name="total_harga">
                <input type="hidden" name="id_komplain" value="<?php echo base64_decode($id) ?>">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" name="hapus-produk-tmp" data-bs-toggle="modal" data-bs-target="#cancel">Cancel</button>
                <button type="button" class="btn btn-primary">Ya, Saya Yakin</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- End Modal Hapus -->

<!-- Modal Edit -->
<div class="modal fade" id="editData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Edit Produk Revisi</h5>
            </div>
            <div class="modal-body">
                <form action="proses/produk-tmp.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_tmp" id="id_produk_edit">
                    <input type="hidden" name="id_komplain" value="<?php echo $id ?>">
                    <div class="mb-3">
                        <label for="nama_produk_edit">Nama Produk</label>
                        <input type="text" class="form-control" name="nama_produk" id="nama_produk_edit" required>
                    </div>
                    <div class="mb-3">
                        <label for="merk_edit">Merk</label>
                        <input type="text" class="form-control" name="merk" id="merk_edit" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="harga">Harga</label>
                        <input type="text" class="form-control" name="harga" id="harga_edit" oninput="formatNumberHarga(this)" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga">Diskon</label>
                        <input type="text" class="form-control" name="disc" id="disc_edit" oninput="validasiDiskon(this)" required>
                    </div>
                    <div class="mb-3">
                        <label for="qty_order">Stock</label>
                        <input type="text" class="form-control" name="stock" id="stock_edit" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="qty_order">Qty Order</label>
                        <input type="text" class="form-control" name="qty" id="qty_edit" oninput="formatNumberHarga(this)" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" name="ubah-data">Ubah Data</button>
                    </div>
                </form> 
            </div>
        </div>
    </div>
</div>

<!-- Modal Refund -->
<div class="modal fade" id="bayarRefund" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7"><P style="font-size: 18px;"><b>Total Nilai Refund</b></P></div>
                    <div class="col-md-5 text-end"><button class="btn btn-primary btn-sm"><i class="bi bi-eye"></i> Lihat Barang</button></div>
                </div>
                <div class="card mt-3">
                    <button class="btn btn-secondary p-3">Rp. 150.000</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Menampilkan data konfirmasi saat Hapus Data -->
<script>
    // untuk menampilkan data pada atribut <td>
    $('#hapus').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var total = button.data('total');
        
        var modal = $(this);
        modal.find('.modal-body #id_tmp').val(id);
        modal.find('.modal-body #total_harga').val(total);

        // var id_tmp_value = $('#id_tmp').val();
        // var total_value = $('#total_harga').val();
        // var formattedTotalValue = parseFloat(total_value).toLocaleString().replace(",", ".");
        // $('#hapusAlert input[name="id_tmp"]').val(id_tmp_value);
        // $('#hapusAlert input[name="total_harga"]').val(total_value);
        // $('#hapusAlert b[id="total_harga"]').text(formattedTotalValue);
    })
</script>

<!-- Menampilkan data konfirmasi saat Hapus Data -->
<!-- Menampilkan data konfirmasi saat Ubah Data -->
<script>
    $('#editData').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id_edit = button.data('id');
        var nama_edit = button.data('nama');
        var merk_edit = button.data('merk');
        var harga_edit = button.data('harga');
        var disc_edit = button.data('disc');
        var stock_edit = button.data('stock');
        var qty_edit = button.data('qty');

        // Menggunakan toLocaleString() untuk memformat qty dan stock menjadi angka dengan tanda ribuan
        var formattedHarga = parseFloat(harga_edit).toLocaleString();
        var formattedStock = parseFloat(stock_edit).toLocaleString();
        var formattedQty = parseFloat(qty_edit).toLocaleString();

        var modal = $(this);
        modal.find('.modal-body #id_produk_edit').val(id_edit);
        modal.find('.modal-body #nama_produk_edit').val(nama_edit);
        modal.find('.modal-body #merk_edit').val(merk_edit);
        modal.find('.modal-body #harga_edit').val(formattedHarga);
        modal.find('.modal-body #disc_edit').val(disc_edit);

        var stock_input = modal.find('.modal-body #stock_edit');
        var qty_input = modal.find('.modal-body #qty_edit');

        stock_input.val(formattedStock);
        qty_input.val(formattedQty);

        // Menambahkan event listener untuk mengontrol input qty agar tidak melebihi stock
        qty_input.on('input', function() {
            var qtyValue = parseFloat(qty_input.val().replace(/,/g, '')) || 0;
            var stockValue = parseFloat(stock_input.val().replace(/,/g, '')) || 0;

            if (qtyValue > stockValue) {
                qty_input.val(stockValue.toLocaleString()); // Mengatur nilai input qty menjadi nilai stock yang sudah diformat
            }
        });
    });
</script>

<!-- Display Block dan None kolom aksi -->
<script>
    // Inisialisasi variabel nilai awal
    var toggleValue = 0;
    var edit = document.getElementById("edit");
    var selesai = document.getElementById("selesai-edit");
    var editButton = document.getElementById("edit-button");
    var aksiElements = document.querySelectorAll(".aksi");
    var tambahDataButton = document.querySelector("button.tambahData");

    editButton.addEventListener("click", function () {
        // Toggle nilai antara 0 dan 1
        toggleValue = 1 - toggleValue;

        // Lakukan sesuatu berdasarkan nilai toggle
        if (toggleValue === 1) {
            // Jika nilai adalah 1, lakukan tindakan ketika tombol diaktifkan
            console.log("Nilai saat ini adalah 1");
            aksiElements.forEach(function (aksi) {
                aksi.style.display = 'block';
                selesai.style.display = 'block';
                edit.style.display = 'none';
            });
            tambahDataButton.style.display = 'block';
        } else {
            // Jika nilai adalah 0, lakukan tindakan ketika tombol dinonaktifkan
            console.log("Nilai saat ini adalah 0");
            aksiElements.forEach(function (aksi) {
                aksi.style.display = 'none';
            });
            tambahDataButton.style.display = 'none';
        }
    });
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
    }
</script>

<!-- Refresh page -->
<script>
    function refreshPage() {
        location.reload();
    }
</script>

<script>
    $(document).ready(function() {
        $('.btn-detail').click(function() {
            var idInv = $(this).data('inv');
            $('#inv').text(idInv);

            $('button.btn-pilih').attr('data-inv', idInv);

            $('#tambahData').modal('show');
        });

        $(document).on('click', '.btn-pilih', function(event) {
            event.preventDefault();
            event.stopPropagation();

            var inv = $(this).attr('data-inv');
            var produk = $(this).data('id-produk');
            var namaProduk = $(this).data('nama-produk');
            var hargaProduk = $(this).data('harga');
           


            saveData(inv, produk, namaProduk, hargaProduk);
        });

        function saveData(inv, produk, namaProduk, hargaProduk) {
            $.ajax({
                url: 'simpan-data-tmp.php',
                type: 'POST',
                data: {
                    inv:inv,
                    produk:produk,
                    namaProduk:namaProduk,
                    hargaProduk:hargaProduk
                },
                success: function(response) {
                    console.log('Data berhasil disimpan.');
                    $('button[data-inv="' + inv + '"]').prop('disabled', true);
                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan saat menyimpan data:', error);
                }
            });
        }
    });
</script>

<script>
function formatNumberHarga(input) {
    // Mengambil nilai input
    var inputValue = input.value;

    // Menghapus semua karakter kecuali angka dan tanda koma (,)
    var cleanedValue = inputValue.replace(/[^0-9,]/g, '');

    // Menghapus tanda koma (,) tambahan yang mungkin ada
    cleanedValue = cleanedValue.replace(/,/g, '');

    // Mengubah nilai input menjadi format angka yang sesuai
    var formattedValue = Number(cleanedValue).toLocaleString('en-US');

    // Memasukkan kembali nilai yang telah diformat ke dalam input
    input.value = formattedValue;
}
</script>

<script>
function validasiDiskon(input) {
    // Hapus karakter selain angka, titik (.), dan tanda persen (%)
    input.value = input.value.replace(/[^0-9.%]/g, '');

    // Hapus tanda persen (%) yang ada di akhir input
    if (input.value.endsWith('%')) {
        input.value = input.value.slice(0, -1);
    }

    // Konversi input ke dalam format angka
    var nilaiDiskon = parseFloat(input.value);
    
    // Pastikan nilai diskon tidak lebih dari 100%
    if (isNaN(nilaiDiskon) || nilaiDiskon > 100) {
        input.value = "100";
    }
}
</script>











