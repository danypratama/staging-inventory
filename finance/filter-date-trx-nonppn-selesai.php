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
    <div class="table-responsive" id="filteredData">
        <table class="table table-bordered table-striped" id="table7">
            <thead>
                <tr class="text-white" style="background-color: navy;">
                    <th class="text-center p-3 text-nowrap" style="width: 30px">No</th>
                    <th class="text-center p-3 text-nowrap" style="width: 150px">No. Invoice</th>
                    <th class="text-center p-3 text-nowrap" style="width: 150px">Tgl. Invoice</th>
                    <th class="text-center p-3 text-nowrap" style="width: 150px">No. PO</th>
                    <th class="text-center p-3 text-nowrap" style="width: 250px">Nama Customer</th>
                    <th class="text-center p-3 text-nowrap" style="width: 100px">Kat. Inv</th>
                    <th class="text-center p-3 text-nowrap" style="width: 100px">Status Pembayaran</th>
                    <th class="text-center p-3 text-nowrap" style="width: 80px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include "koneksi.php";
                $no = 1;
                $start_date = $_GET['start_date']; // Tanggal awal rentang
                $end_date = $_GET['end_date']; // Tanggal akhir rentang
                $sql = " SELECT nonppn.id_inv_nonppn,
                                nonppn.no_inv, 
                                STR_TO_DATE(nonppn.tgl_inv, '%d/%m/%Y') AS tgl_inv,
                                nonppn.cs_inv, 
                                nonppn.tgl_tempo, 
                                nonppn.sp_disc, 
                                nonppn.note_inv, 
                                nonppn.kategori_inv, 
                                nonppn.ongkir, 
                                nonppn.total_inv, 
                                nonppn.status_transaksi, 
                                sr.id_inv, 
                                sr.id_customer, 
                                sr.no_po, 
                                cs.nama_cs, cs.alamat, 
                                fn.status_pembayaran, fn.id_inv
                                FROM inv_nonppn AS nonppn
                                LEFT JOIN spk_reg sr ON(nonppn.id_inv_nonppn = sr.id_inv)
                                JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                JOIN finance fn ON (fn.id_inv = nonppn.id_inv_nonppn)
                                WHERE status_transaksi = 'Transaksi Selesai' AND
                            STR_TO_DATE(nonppn.tgl_inv, '%d/%m/%Y') >= STR_TO_DATE('$start_date', '%d/%m/%Y') AND
                            STR_TO_DATE(nonppn.tgl_inv, '%d/%m/%Y') <= STR_TO_DATE('$end_date', '%d/%m/%Y')
                        GROUP BY no_inv";
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
                            <a href="cek-produk-inv-nonppn-selesai.php?id=<?php echo base64_encode($data['id_inv_nonppn']) ?>" class="btn btn-primary btn-sm mb-2"><i class="bi bi-eye-fill"></i> Lihat</a>
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
