<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        include "koneksi.php";
        // Tangkap dengan method post dati file data-pembelian.php
        if (isset($_POST['id_inv'])) {
            $id_inv = $_POST['id_inv'];

            // Lakukan operasi atau kueri database sesuai kebutuhan
            $sql_bukti = $connect->query("SELECT 
                                            ibtp.id_inv_pembelian, ibtp.bukti_pembelian, ipl.no_trx, ipl.no_inv, ipl.no_inv, ipl.path_inv, ipl.tgl_terima, sp.nama_sp 
                                            FROM inv_bukti_terima_pembelian AS ibtp
                                            LEFT JOIN inv_pembelian_lokal ipl ON (ipl.id_inv_pembelian = ibtp.id_inv_pembelian)
                                            LEFT JOIN tb_supplier sp ON (sp.id_sp = ipl.id_sp)
                                            WHERE ibtp.id_inv_pembelian = '$id_inv'
                                        ");
            $data_bukti = mysqli_fetch_array($sql_bukti);
            $bukti_pembelian = $data_bukti['bukti_pembelian'];
            $nama_sp = $data_bukti['nama_sp'];
            $path = $data_bukti['path_inv'];
            // Periksa karakter nama supplier yang tidak valid
            $nama_sp_replace = preg_replace("/[^a-zA-Z0-9]/", "_", $nama_sp);
            $image = "gambar/pembelian/" . $nama_sp_replace . "/" . $path . "/" . $bukti_pembelian;
        } else {
            // Handle jika tidak ada data yang diterima
            echo "Tidak ada data yang diterima.";
        }
    ?>
    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-md-6">
                <img src="<?php echo $image ?>" class="img-fluid" alt="...">
            </div>
            <div class="col-md-6">
                <div class="card-body p-5">
                    <div class="mb-3">
                        <label class="fw-bold">No. Transaksi Pembelian:</label>
                        <p><?php echo $data_bukti['no_trx']; ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">No. Invoice Pembelian:</label>
                        <p><?php echo $data_bukti['no_inv']; ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Supplier:</label>
                        <p><?php echo $nama_sp; ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Tgl. Terima:</label>
                        <p><?php echo $data_bukti['tgl_terima']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
