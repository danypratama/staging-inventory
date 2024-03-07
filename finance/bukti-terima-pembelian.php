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
            $sql_bukti = $connect->query("SELECT ibtp.id_inv_pembelian, ibtp.bukti_pembelian, ipl.no_inv, sp.nama_sp 
                                            FROM inv_bukti_terima_pembelian AS ibtp
                                            LEFT JOIN inv_pembelian_lokal ipl ON (ipl.id_inv_pembelian = ibtp.id_inv_pembelian)
                                            LEFT JOIN tb_supplier sp ON (sp.id_sp = ipl.id_sp)
                                            WHERE ibtp.id_inv_pembelian = '$id_inv'
                                        ");
            $data_bukti = mysqli_fetch_array($sql_bukti);
            $bukti_pembelian = $data_bukti['bukti_pembelian'];
            $nama_sp = $data_bukti['nama_sp'];
            $no_inv = $data_bukti['no_inv'];
        } else {
            // Handle jika tidak ada data yang diterima
            echo "Tidak ada data yang diterima.";
        }
    ?>
    <div class="card mb-3" style="max-width: 540px;">
        <div class="row g-0">
            <div class="col-md-6">
            <img src="..." class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-6">
            <div class="card-body">
                <h5 class="card-title"><?php echo $bukti_pembelian ?></h5>
                <p class="card-text"><?php echo $nama_sp ?></p>
                <p class="card-text"><small class="text-body-secondary"><?php echo $no_inv ?></small></p>
            </div>
            </div>
        </div>
    </div>
</body>
</html>
