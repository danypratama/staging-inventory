<?php
    $page  = 'transaksi';
    $page2 = 'sph';
    include "akses.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Create SPH</title>
    <?php include "page/head.php"; ?>
    <style type="text/css">
        /* Menghilangkan garis pada input */
        td{
            padding: 0;
        }


        .wrap-text {
            max-width: 300px; /* Contoh lebar maksimum */
            overflow: hidden; /* Sembunyikan teks yang melebihi max-width */
            white-space: pre-line; /* Tetapkan spasi putih dan pecah baris sesuai dengan teks */
            word-wrap: break-word; /* Pecah kata jika melebihi max-width */
        }
  
        .mobile-label{
            display: none;
        }
        @media (max-width: 800px) { /* Media query untuk tampilan mobile */
            
            .wrap-text {
                min-width: 400px; /* Contoh lebar maksimum */
                overflow: hidden; /* Sembunyikan teks yang melebihi max-width */
                white-space: pre-line; /* Tetapkan spasi putih dan pecah baris sesuai dengan teks */
                word-wrap: break-word; /* Pecah kata jika melebihi max-width */
            }

            .qty {
                width: 100px;
            }

            .mobile-no{
                display: none;
            }

            .div-none{
                display: none;
            }
        }

        @media (max-width: 680px) { /* Media query untuk tampilan mobile */
            
            .qty {
                width: 80px;
            }

            .mobile-no{
                display: none;
            }
        }

        @media only screen and (max-width: 600px) {
            body {
                font-size: 16px;
            }

            .mobile {
                display: none;
            }

            .mobile-text {
                text-align: left !important;
            }

            .mobile-label{
                display: none;
            }

            .mobile-no{
                display: none;
            }

            .qty {
                width: 70px;
            }
        }
        @media (max-width: 580px) { /* Media query untuk tampilan mobile */
            body {
                font-size: 16px;
            }

            .mobile {
                display: none;
            }

            .mobile-text {
                text-align: left !important;
            }

            .mobile-label{
                display: none;
            }

            .mobile-no{
                display: none;
            }

            .qty {
                width: 60px;
            }
        }

        @media (max-width: 578px) { /* Media query untuk tampilan mobile */
            body {
                font-size: 16px;
            }

            .mobile {
                display: none;
            }

            .mobile-text {
                text-align: left !important;
            }

            .mobile-label{
                display: block;
            }

            .mobile-no{
                display: none;
            }

            .qty {
                width: 100%;
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
        <section class="pagetitle">
            <div class="card p-3">
                <div class="card-header text-center">
                    <h5>Form Surat Penawaran Harga</h5>
                </div>
                <div class="row mt-3">
                    <?php  
                        include "koneksi.php";
                        $id_sph = $_GET['id'];
                        $id_sph_decode = base64_decode($id_sph);

                        $sph = " SELECT 
                                        sph.id_sph, sph.no_sph, sph.tanggal, sph.up, sph.id_cs, sph.alamat, sph.ttd_oleh, sph.jabatan, sph.perihal, sph.note, cs.nama_cs
                                 FROM sph as sph
                                 LEFT JOIN tb_customer_sph cs ON (cs.id_cs = sph.id_cs) 
                                 WHERE sph.id_sph = '$id_sph_decode'";
                        $query_sph = mysqli_query($connect, $sph);
                        $data_sph = mysqli_fetch_array($query_sph);
                        $id_sph = $data_sph['id_sph'];
                    ?>
                    <div class="col-sm-6">
                        <div class="card-body p-3 border">
                            <div class="row">
                                <div class="col-5">
                                    <p style="float: left;">No. SPH</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php echo $data_sph['no_sph'] ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <p style="float: left;">Tgl. SPH</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php echo $data_sph['tanggal'] ?>
                                </div>
                            </div>
                            <?php  
                                if($data_sph['up'] == ''){
                                }else{
                                    echo '<div class="row">
                                            <div class="col-5">
                                                <p style="float: left;">U.P</p>
                                                <p style="float: right;">:</p>
                                            </div>
                                            <div class="col-7">
                                                '.$data_sph['up'].'
                                            </div>
                                        </div>';
                                }
                            
                            
                            ?>
                            
                            <div class="row">
                                <div class="col-5">
                                    <p style="float: left;">Customer</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php echo $data_sph['nama_cs'] ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <p style="float: left;">Alamat</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php echo $data_sph['alamat'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card-body p-3 border">
                            <div class="row">
                                <div class="col-5">
                                    <p style="float: left;">TTD</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php echo $data_sph['ttd_oleh'] ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <p style="float: left;">Jabatan</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php echo $data_sph['jabatan'] ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <p style="float: left;">Perihal</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                    <?php echo $data_sph['perihal'] ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <p style="float: left;">Notes</p>
                                    <p style="float: right;">:</p>
                                </div>
                                <div class="col-7">
                                <?php
                                    $note = $data_sph['note'];

                                    $items = explode("\n", trim($note));

                                    foreach ($items as $notes) {
                                        echo trim($notes) . '<br>';
                                    }
                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3 mb-3">
                        <button class="btn btn-info btn-md" data-bs-toggle="modal" data-bs-target="#editPelanggan"><i class="bi bi-pencil"></i> Edit Pelanggan SPH</button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="editPelanggan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Pelanggan SPH</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="proses/proses-sph.php" method="POST">
                                    <input type="hidden" name="id_sph" value="<?php echo $data_sph['id_sph'] ?>">
                                    <div class="mb-3">
                                        <label>Tanggal</label>
                                        <input type="text" class="form-control" name="tanggal" id="date" value="<?php echo $data_sph['tanggal'] ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label>U.P</label>
                                        <input type="text" class="form-control" name="up" id="up" value="<?php echo $data_sph['up'] ?>">
                                    </div>
                                    <div class="mb-2">
                                        <label>Customer</label>
                                        <input type="hidden" class="form-control" id="id" name="id_cs" value="<?php echo $data_sph['id_cs'] ?>">
                                        <input type="text" class="form-control" name="cs" id="cs" value="<?php echo $data_sph['nama_cs'] ?>" data-bs-toggle="modal" data-bs-target="#modalCs" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label>Alamat</label>
                                        <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $data_sph['alamat'] ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label>TTD</label>
                                        <input type="text" class="form-control" name="ttd" value="<?php echo $data_sph['ttd_oleh'] ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label>Jabatan</label>
                                        <input type="text" class="form-control" name="jabatan" value="<?php echo $data_sph['jabatan'] ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label>Perihal</label>
                                        <input type="text" class="form-control" name="perihal" value="<?php echo $data_sph['perihal'] ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label>Notes</label>
                                        <textarea type="text" class="form-control" name="note" cols="30" style="max-height: 200px; min-height: 200px;"><?php echo $data_sph['note'] ?></textarea>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="ubah-cs-sph" class="btn btn-primary">Ubah Data</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-2">
                <a href="sph.php" class="btn btn-warning btn-detail mb-3">
                    <i class="bi bi-arrow-left"></i> Halaman Sebelumnya
                </a>
                <button class="btn btn-primary btn-detail mb-3" data-sph="<?php echo  $id_sph_decode ?>" data-bs-toggle="modal" data-bs-target="#modalBarang">
                    <i class="bi bi-plus-circle"></i> Tambah Produk
                </button>
                <a class="btn btn-secondary btn-detail mb-3" href="cetak-sph.php?id=<?php echo base64_encode($id_sph) ?>">
                    <i class="bi bi-plus-circle"></i> Cetak SPH 
                </a>          
            </div>
            <div class="card-body p-2">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="table2">
                        <?php
                            $no = 1;
                            $sql_sph = "SELECT tps.*, tps.status_trx, mr.nama_merk, spr.stock
                                        FROM transaksi_produk_sph AS tps
                                        LEFT JOIN stock_produk_reguler spr ON (spr.id_produk_reg = tps.id_produk)
                                        LEFT JOIN tb_produk_reguler tpr ON (tpr.id_produk_reg = spr.id_produk_reg)
                                        LEFT JOIN tb_merk mr ON (tpr.id_merk = mr.id_merk)
                                        LEFT JOIN tb_produk_set_marwa tpsm ON (spr.id_produk_reg = tpsm.id_set_marwa)
                                        WHERE status_trx = 1 AND id_sph = '$id_sph_decode'";
                            $query_sph = mysqli_query($connect, $sql_sph);
                            $totalRows = mysqli_num_rows($query_sph);

                            if ($totalRows != 0) {
                                echo '
                                    <thead>
                                        <tr class="text-white" style="background-color: navy">
                                            <td class="text-center text-nowrap p-3">No</td>
                                            <td class="text-center text-nowrap p-3">Nama Produk</td>
                                            <td class="text-center text-nowrap p-3">Merk</td>
                                            <td class="text-center text-nowrap p-3">Satuan</td>
                                            <td class="text-center text-nowrap p-3">Harga</td>
                                            <td class="text-center text-nowrap p-3">Qty</td>
                                            <td class="text-center text-nowrap p-3">Aksi</td>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                
                                while ($data_sph = mysqli_fetch_array($query_sph)) {
                                    $id_produk = $data_sph['id_produk'];
                                    $id_produk_substr = substr($id_produk, 0, 2);
                                    echo '
                                        <tr>
                                            <td class="text-center text-nowrap">' . $no . '</td>
                                            <td class="text-nowrap">' . $data_sph['nama_produk_sph'] . '</td>
                                            <td class="text-center text-nowrap">' . $data_sph['nama_merk'] . '</td>
                                            <td class="text-center text-nowrap">' . ($id_produk_substr == 'BR' ? "Pcs" : "Set") . '</td>
                                            <td class="text-end text-nowrap">' . number_format($data_sph['harga'],0,'.','.') . '</td>
                                            <td class="text-end text-nowrap">' . $data_sph['qty'] . '</td>
                                            <td class="text-center text-nowrap">
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editProduk" data-id="'.$data_sph['id_transaksi'].'" data-nama="'.$data_sph['nama_produk_sph'].'" data-merk="'.$data_sph['nama_merk'].'" data-harga="'.$data_sph['harga'].'" data-stock="'.number_format($data_sph['stock']).'" data-qty="'.$data_sph['qty'].'"><i class="bi bi-pencil"></i> Edit</button>
                                                <a href="proses/proses-sph.php?hapus='. base64_encode($data_sph['id_transaksi']) .' && id_sph= '. base64_encode($data_sph['id_sph']) .'" class="btn btn-danger btn-sm delete-data"><i class="bi bi-trash"> Hapus</i> 
                                             </td>
                                        </tr>';
                                    
                                    $no++;
                                }
                                
                                echo '</tbody>';
                            } 
                        ?>
                    </table>
                </div>
            </div>
             <!-- Kode untuk menampilkan data yang belum di input Qty dan pengecekan harga -->
            <div class="card-body p-2">
                <form action="proses/proses-sph.php" method="post">
                    <?php
                        $no = 1;
                        $sql_sph_cek = "SELECT tps.*, tps.status_trx, mr.nama_merk, spr.stock
                                            FROM transaksi_produk_sph AS tps
                                            LEFT JOIN stock_produk_reguler spr ON (spr.id_produk_reg = tps.id_produk)
                                            LEFT JOIN tb_produk_reguler tpr ON (tpr.id_produk_reg = spr.id_produk_reg)
                                            LEFT JOIN tb_merk mr ON (tpr.id_merk = mr.id_merk)
                                            WHERE status_trx = 0";
                        $query_sph_cek = mysqli_query($connect, $sql_sph_cek);
                        $totalRows_cek = mysqli_num_rows($query_sph_cek);
                        if ($totalRows_cek != 0) { 
                            echo' 
                                <div class="text-center">
                                    <h5>Tambahan Produk SPH</h5>
                                </div>
                            ';
                        }
                        
                       
                        if ($totalRows_cek != 0) { ?>
                           
                                <div class="row p-2 mobile mobile-no">
                                    <div class="col-sm-1 mb-1 text-center">
                                        <label class="mobile-no">No</label>
                                    </div>
                                    <div class="col-sm-4 mb-1 text-center">
                                        <label>Nama Produk</label>
                                    </div>
                                    <div class="col-sm-2 mb-1 text-center">
                                        <label>Merk</label>
                                    </div>
                                    <div class="col-sm-2 mb-1 text-center">
                                        <label>Harga</label>
                                    </div>
                                    <div class="col-sm-2 mb-1 text-center">
                                        <label>Stock</label>
                                    </div>
                                    <div class="col-sm-1 mb-1 text-center">
                                        <label>Qty</label>
                                    </div>
                                </div>
                            <?php       
                            while ($data_sph_cek = mysqli_fetch_array($query_sph_cek)) { ?>
                                <div class="row p-2">
                                    <div class="col-sm-1 mb-1 div-none">
                                        <label class="mobile-label">No</label>
                                        <input type="hidden" name="id_sph[]" value="<?php echo $data_sph_cek['id_sph'] ?>">
                                        <input type="hidden" class="form-control text-center" name="id_trx[]" id="id_<?php echo $data_sph_cek['id_transaksi'] ?>" value="<?php echo $data_sph_cek['id_transaksi'] ?>">
                                        <input type="text" class="form-control text-center" value="<?php echo $no ?>">
                                    </div>
                                    <div class="col-sm-4 mb-1">
                                        <label class="mobile-label">Nama Produk</label>
                                        <input type="text" class="form-control mobile-text" value="<?php echo $data_sph_cek['nama_produk_sph'] ?>" required>
                                    </div>
                                    <div class="col-sm-2 mb-1">
                                        <label class="mobile-label">Merk</label>
                                        <input type="text" class="form-control mobile-text text-center bg-light" value="<?php echo $data_sph_cek['nama_merk'] ?>" readonly>
                                    </div>
                                    <div class="col-sm-2 mb-1">
                                        <label class="mobile-label">Harga</label>
                                        <input type="text" class="form-control mobile-text text-end" name="harga[]" id="hargaInput_<?php echo $data_sph_cek['id_transaksi']; ?>" value="<?php echo number_format($data_sph_cek['harga']) ?>" oninput="formatCurrency(this)" required>
                                    </div>
                                    <div class="col-sm-2 mb-1">
                                        <label class="mobile-label">Stock</label>
                                        <input type="text" class="form-control mobile-text text-end bg-light" value="<?php echo number_format($data_sph_cek['stock']) ?>" id="stock_<?php echo $data_sph_cek['id_transaksi'] ?>" readonly>
                                    </div>
                                    <div class="col-sm-1 qty mb-1">
                                        <label class="mobile-label">Qty</label>
                                        <input type="text" class="form-control mobile-text text-end" name="qty[]" id="qtyInput_<?php echo $data_sph_cek['id_transaksi'] ?>" oninput="checkStock('<?php echo $data_sph_cek['id_transaksi'] ?>')">
                                    </div>
                                    
                                </div>
                            <?php
                            $no++;
                            }
                        } 
                    ?>
                    <div class="mt-3 text-center">
                        <?php  
                            if ($totalRows_cek != 0) { 
                                echo '<button type="submit" class="btn btn-primary btn-md" name="simpan-cek-produk"> Simpan Data</button>';
                            }
                        ?>
                    </div>
                </form>
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
<!-- Modal -->
<div class="modal fade" id="editProduk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Produk</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card-body">
            <form action="proses/proses-sph.php" method="POST">
                <input type="hidden" id="idTmpValue" name="id_trx" class="form-control">
                <input type="hidden" name="id_sph" value="<?php echo $id_sph_decode ?>" class="form-control">
                <div class="mb-3">
                    <label class="text-start">Nama Produk</label>
                    <input type="text" id="namaTmpValue" class="form-control bg-light" readonly>
                </div>
                <div class="mb-3">
                    <label class="text-start">Merk Produk</label>
                    <input type="text" id="merkTmpValue" class="form-control bg-light" readonly>
                </div>
                <div class="mb-3">
                    <label class="text-start">Stock Tersedia</label>
                    <input type="text" id="stockTmpValue" class="form-control bg-light" readonly>
                </div>
                <div class="mb-3">
                    <label class="text-start">Qty Order</label>
                    <input type="text" id="qtyTmpValue" name="qty_edit" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="text-start">Harga Produk</label>
                    <input type="text" id="hargaTmpValue" name="harga" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="edit" name="edit-br" disabled>Simpan Perubahan</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- Modal Cs-->
<div class="modal fade" id="modalCs" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Pelanggan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <style>
                    .wrap-text {
                        max-width: 300px; /* Contoh lebar maksimum */
                        overflow: hidden; /* Sembunyikan teks yang melebihi max-width */
                        white-space: pre-line; /* Tetapkan spasi putih dan pecah baris sesuai dengan teks */
                        word-wrap: break-word; /* Pecah kata jika melebihi max-width */
                    }
                    @media (max-width: 767px) { /* Media query untuk tampilan mobile */
                        .wrap-text {
                            min-width: 400px; /* Contoh lebar maksimum */
                            overflow: hidden; /* Sembunyikan teks yang melebihi max-width */
                            white-space: pre-line; /* Tetapkan spasi putih dan pecah baris sesuai dengan teks */
                            word-wrap: break-word; /* Pecah kata jika melebihi max-width */
                        }
                    }
                </style>
                <div class="card p-3">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered" id="table3">
                        <thead>
                            <tr class="text-white" style="background-color: navy;">
                            <td class="col-4 text-nowrap">Nama Customer</td>
                            <td class="col-6 text-nowrap">Alamat Customer</td>
                            <td class="col-2 text-nowrap">Telepon</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "koneksi.php";
                            $sql_cs = "SELECT id_cs, nama_cs, alamat, no_telp FROM tb_customer_sph";
                            $query_cs = mysqli_query($connect, $sql_cs);
                            while ($data_cs = mysqli_fetch_array($query_cs)) {
                            ?>
                            <tr data-id="<?php echo $data_cs['id_cs'] ?>" data-nama="<?php echo $data_cs['nama_cs'] ?>" data-alamat="<?php echo $data_cs['alamat'] ?>" data-bs-dismiss="modal">
                                <td><?php echo $data_cs['nama_cs'] ?></td>
                                <td class="wrap-text"><?php echo $data_cs['alamat'] ?></td>
                                <td class="text-nowrap"><?php echo $data_cs['no_telp'] ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Large Modal-->

<!-- Modal Barang -->
<div class="modal fade" id="modalBarang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <form method="post" action=""> <!-- Tambahkan form dengan method POST -->
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Data Barang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="tableBr">
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
                                $id_sph = $_GET['id'];
                                $selected_produk = [];
                                $id_sph_produk = $id_sph_decode;
                                $no = 1;

                                // Mengambil data produk yang ada dalam tmp_produk_sph untuk id_sph yang sedang aktif
                                $query_selected_produk = mysqli_query($connect, "SELECT id_produk FROM transaksi_produk_sph WHERE id_sph = '$id_sph_produk'");
                                while ($selected_data = mysqli_fetch_array($query_selected_produk)) {
                                    $selected_produk[] = $selected_data['id_produk'];
                                }

                                $sql = "SELECT 
                                            COALESCE(tpr.id_produk_reg, tpsm.id_set_marwa) AS id_produk,
                                            COALESCE(tpr.nama_produk, tpsm.nama_set_marwa) AS nama_produk,
                                            COALESCE(mr_tpr.nama_merk, mr_tpsm.nama_merk) AS nama_merk,
                                            tpr.satuan,
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
                                    $isChecked = in_array($id_produk, $selected_produk);
                                    $isDisabled = false;
                                    $id_produk_substr = substr($id_produk, 0, 2);

                                    if ($data['stock'] == 0) {
                                        $isDisabled = true; // Jika stock = 0, maka tombol pilih akan menjadi disabled
                                    }
                                ?>
                                    <tr>
                                        <td class="text-center text-nowrap"><?php echo $no; ?></td>
                                        <td class="text-nowrap">
                                            <?php 
                                                if(!empty($data['nama_produk'])){
                                                    echo $data['nama_produk'];
                                                } else {
                                                    echo $data['nama_set_marwa'];
                                                }
                                            ?>
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <?php
                                                if($id_produk_substr == 'BR'){
                                                    echo "Pcs";
                                                }else{
                                                    echo "Set";
                                                }
                                            
                                            ?>
                                        </td>  
                                        <td class="text-center text-nowrap"><?php echo $data['nama_merk']; ?></td>
                                        <td class="text-center text-nowrap"><?php echo number_format($data['stock']); ?></td>
                                        <td class="text-center text-nowrap">
                                            <button class="btn-pilih btn btn-primary btn-sm" data-id="<?php echo $id_produk; ?>" data-sph="<?php echo $id_sph_produk; ?>" data-nama="<?php echo $data['nama_produk'] ?>" data-harga="<?php echo $data['harga_produk']; ?>" <?php echo ($isChecked || $isDisabled) ? 'disabled' : ''; ?>>Pilih</button>
                                        </td>
                                    </tr>
                                    <?php $no++; ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="refreshPage()">Close</button>
                </div>
            </form> <!-- Akhir dari form -->
        </div>
    </div>
</div>
<!-- End Modal -->




<!-- Edit Data Produk -->
<script>
    $(document).ready(function() {
        var initialQty = null;

        $('#editProduk').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var idTmp = button.data('id');
            var spkTmp = button.data('spk');
            var namaTmp = button.data('nama');
            var merkTmp = button.data('merk');
            var hargaTmp = button.data('harga');
            var qtyTmp = button.data('qty');
            var stockTmp = button.data('stock');

            initialQty = qtyTmp;
            initialHarga = hargaTmp;

            console.log(initialQty);
            console.log(initialHarga);
            

            // Format angka qty dengan ribuan separator
            var formattedQty = numberWithCommas(qtyTmp);

            // Format angka stock dengan ribuan separator
            var formattedStock = numberWithCommas(stockTmp);

             // Format angka stock dengan ribuan separator
             var formattedHarga = numberWithCommas(hargaTmp);

            $('#idTmpValue').val(idTmp);
            $('#spkTmpValue').val(spkTmp);
            $('#namaTmpValue').val(namaTmp);
            $('#merkTmpValue').val(merkTmp);
            $('#hargaTmpValue').val(formattedHarga);
            $('#stockTmpValue').val(formattedStock);
            $('#qtyTmpValue').val(formattedQty);
        });

        // Fungsi untuk menambahkan separator ribuan pada angka
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        // Validasi saat nilai qty berubah
        $('#qtyTmpValue').on('input', function() {
            var qtyValue = parseFloat($(this).val().replace(/,/g, ''));
            var stockValue = parseFloat($('#stockTmpValue').val().replace(/,/g, ''));


            if (isNaN(qtyValue)) {
                qtyValue = 0;
            }

            if (qtyValue > stockValue) {
                qtyValue = stockValue;
            }

            // Format angka qty dengan ribuan separator
            var formattedQty = numberWithCommas(qtyValue);

            $(this).val(formattedQty);

            // Cek apakah nilai qty berubah dari nilai awal
            if (qtyValue !== initialQty ) {
                $('#edit').prop('disabled', false);
            } else {
                $('#edit').prop('disabled', true);
            }
        });

        $('#hargaTmpValue').on('input', function() {
            var hargaValue = parseFloat($(this).val().replace(/,/g, ''));


            if (isNaN(hargaValue)) {
                hargaValue = 0;
            }
            // Format angka qty dengan ribuan separator
            var formattedHarga = numberWithCommas(hargaValue);

            $(this).val(formattedHarga);

            // Cek apakah nilai qty berubah dari nilai awal
            if (hargaValue !== initialHarga ) {
                $('#edit').prop('disabled', false);
            } else {
                $('#edit').prop('disabled', true);
            }
        });
    });
</script>


<!-- date picker with flatpick -->
<script type="text/javascript">
  flatpickr("#date", {
    dateFormat: "d/m/Y",
  });
</script>
<!-- end date picker -->

<script>
    $(document).ready(function() {
    var table = $('#tableBr').DataTable({
        "lengthChange": false,
        "ordering": false,
        "autoWidth": false
    });
});
</script>


<!-- Select Data -->
<script>
  $(document).on('click', '#table3 tbody tr', function(e) {
    $('#id').val($(this).data('id'));
    $('#cs').val($(this).data('nama'));
    $('#alamat').val($(this).data('alamat'));
    $('#modalCs').modal('hide');
    $('#editPelanggan').modal('show');
  });
</script>


<script>
    function refreshPage() {
        location.reload();
    }
</script>

<!-- Kode untuk pilih produk sph -->
<script>
    $(document).ready(function() {
        $('.btn-detail').click(function() {
            var idsph = $(this).data('sph');
            $('#sph').text(idsph);

            $('button.btn-pilih').attr('data-sph', idsph);

            $('#modalBarang').modal('show');
        });

        $(document).on('click', '.btn-pilih', function(event) {
            event.preventDefault();
            event.stopPropagation();

            var id = $(this).data('id');
            var sph = $(this).attr('data-sph');
            var nama = $(this).attr('data-nama');
            var harga = $(this).attr('data-harga');

            saveData(id, sph, nama, harga);
        });

        function saveData(id, sph, nama, harga) {
            $.ajax({
                url: 'simpan-data-sph.php',
                type: 'POST',
                data: {
                    id: id,
                    sph: sph,
                    nama: nama,
                    harga: harga
                },
                success: function(response) {
                    console.log('Data berhasil disimpan.');
                    $('button[data-id="' + id + '"]').prop('disabled', true);
                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan saat menyimpan data:', error);
                }
            });
        }
    });
</script>

<!-- format Curency -->
<script>
function formatCurrency(input) {
    // Menghapus semua karakter non-digit
    var cleanValue = input.value.replace(/\D/g, '');
    
    // Mengonversi ke angka
    var numberValue = parseInt(cleanValue);
    
    // Jika hasil konversi NaN, ganti dengan angka 0
    if (isNaN(numberValue)) {
        numberValue = 0;
    }
    
    // Memformat angka ke format rupiah Indonesia dengan pemisah koma
    var formattedValue = numberValue.toLocaleString('id-ID').replace(/\./g, ',');
    
    // Menetapkan nilai input dengan format yang diformat
    input.value = formattedValue;
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
    }
</script>
