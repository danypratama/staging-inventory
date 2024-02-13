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

        .btn.active {
            background-color: black;
            color: white;
            border-color: 1px solid white;
        }
    </style>
</head>

<body>
    <div class="table-responsive" id="filteredDataPPN">
        <table class="table table-bordered table-striped" id="table8">
            <thead>
                <tr class="text-white" style="background-color: navy;">
                    <th class="text-center p-3 text-nowrap" style="width: 30px">No</th>
                    <th class="text-center p-3 text-nowrap" style="width: 150px">No. Invoice</th>
                    <th class="text-center p-3 text-nowrap" style="width: 150px">Tgl. Invoice</th>
                    <th class="text-center p-3 text-nowrap" style="width: 150px">No. PO</th>
                    <th class="text-center p-3 text-nowrap" style="width: 250px">Nama Customer</th>
                    <th class="text-center p-3 text-nowrap" style="width: 100px">Kat. Inv</th>
                    <th class="text-center p-3 text-nowrap" style="width: 100px">Total Invoice</th>
                    <th class="text-center p-3 text-nowrap" style="width: 100px">Status Pembayaran</th>
                    <th class="text-center p-3 text-nowrap" style="width: 80px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include "koneksi.php";
                $no = 1;
                $start_date = $_GET['start_date_ppn']; // Tanggal awal rentang
                $end_date = $_GET['end_date_ppn'];// Tanggal akhir rentang
                $sql = " SELECT ppn.id_inv_ppn,
                                ppn.no_inv, 
                                STR_TO_DATE(ppn.tgl_inv, '%d/%m/%Y') AS tgl_inv,
                                ppn.cs_inv, 
                                ppn.tgl_tempo, 
                                ppn.sp_disc, 
                                ppn.note_inv, 
                                ppn.kategori_inv, 
                                ppn.ongkir, 
                                ppn.total_inv, 
                                ppn.status_transaksi, 
                                sr.id_inv, 
                                sr.id_customer, 
                                sr.no_po, 
                                cs.nama_cs, cs.alamat, 
                                fn.status_pembayaran, fn.id_inv
                                FROM inv_ppn AS ppn
                                LEFT JOIN spk_reg sr ON(ppn.id_inv_ppn = sr.id_inv)
                                JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                JOIN finance fn ON (fn.id_inv = ppn.id_inv_ppn)
                                WHERE status_transaksi = 'Transaksi Selesai' AND
                                STR_TO_DATE(ppn.tgl_inv, '%d/%m/%Y') >= STR_TO_DATE('$start_date', '%d/%m/%Y') AND
                                STR_TO_DATE(ppn.tgl_inv, '%d/%m/%Y') <= STR_TO_DATE('$end_date', '%d/%m/%Y')
                            GROUP BY no_inv ORDER BY no_inv";
                $query = mysqli_query($connect, $sql);
                while ($data = mysqli_fetch_array($query)) {
                ?>
                    <tr>
                        <td class="text-center text-nowrap"><?php echo $no; ?></td>
                        <td class="text-nowrap text-center"><?php echo $data['no_inv'] ?></td>
                        <td class="text-nowrap text-center"><?php echo date('d/m/Y', strtotime($data['tgl_inv'])) ?></td>
                        <td class="text-nowrap text-center"><?php echo $data['no_po'] ?></td>
                        <td class="text-nowrap"><?php echo $data['nama_cs'] ?></td>
                        <td class="text-nowrap text-center"><?php echo $data['kategori_inv'] ?></td>
                        <td class="text-nowrap text-end"><?php echo number_format($data['total_inv']) ?></td>
                        <td class="text-nowrap text-center">
                            <?php 
                            if($data['status_pembayaran'] == 0){
                                echo "Belum Bayar";
                            } else {
                                echo "Sudah Bayar";
                            }
                            ?>
                        </td>
                        <td class="text-center text-nowrap">
                            <a href="cek-produk-inv-ppn-selesai.php?id=<?php echo base64_encode($data['id_inv_ppn']) ?>" class="btn btn-primary btn-sm mb-2"><i class="bi bi-eye-fill"></i> Lihat</a>
                        </td>
                    </tr>
                    <?php $no++ ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php include "page/script.php" ?>
</body>
</html>