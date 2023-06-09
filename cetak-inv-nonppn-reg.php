<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Lato', sans-serif;
            letter-spacing: 0.8px;
        }

        .invoice {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 0.5cm;
            background-color: #ffffff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .invoice-header {
            text-align: left;
            display: grid;
            margin-bottom: 0.5cm;
            grid-template-columns: 4fr 1fr 1fr 4fr;
            grid-gap: 0.5cm;
        }

        .invoice-header h1 {
            font-size: 20px;
            margin: 0;
        }

        .col-header-1 {
            grid-column: 1;
            padding: 0.1cm;
            display: flex;
            justify-content: left;
            align-items: flex-start;
        }

        .col-header-2 {
            grid-column: 4;
            border: 1px solid Black;
            padding: 0.1cm;
            text-align: left;
            align-self: flex-end;
        }


        .col-header-3 {
            grid-column: 1 / span 4;
            border: 1px solid Black;
            padding: 0.1cm;
            text-align: left;
            align-self: flex-start;
        }

        .ket-inv-1 {
            grid-column: 2;
            border: 1px solid Black;
            padding: 0.1cm;
            display: flex;
            align-items: flex-start;
        }

        .ket-inv-2 {
            grid-column: 2;
            border: 1px solid Black;
            padding: 0.1cm;
            display: flex;
            align-items: flex-start;
        }

        .invoice-body {
            margin-bottom: 0.2cm;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-table th,
        .invoice-table td {
            padding: 0.1cm;
            border: 1px solid Black;
            font-size: 16px;
        }

        .invoice-payment {
            text-align: left;
            display: grid;
            grid-template-columns: 3fr 1fr 1fr 2.8fr;
            grid-gap: 0.5cm;
        }

        .col-payment-1 {
            grid-column: 1 / span 3;
            padding: 0.1cm;
            text-align: left;
            align-self: flex-start;
        }

        .col-payment-2 {
            grid-column: 4;
            display: flex;
            padding: 0.1cm;
            justify-content: space-between;
        }

        .grand-total {
            text-align: left;
        }

        .amount {
            text-align: right;
        }

        .invoice-footer {
            text-align: center;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 2fr;
            grid-gap: 0.5cm;
        }

        .col1 {
            grid-column: 1;
        }

        .col2 {
            grid-column: 2;
        }

        .col3 {
            grid-column: 3;
        }

        .col4 {
            grid-column: 4;
            text-align: left;
        }

        @media print {
            @page {
                size: letter;
                margin: 0;
            }

            .invoice {
                background-color: none;
                box-shadow: none;
                /* Warna dasar untuk ukuran kertas Letter */
            }
        }
    </style>
</head>

<body>
    <?php
    include "koneksi.php";
    $id_inv = base64_decode($_GET['id']);
    $sql = "SELECT 
            nonppn.*, 
            sr.id_user, sr.id_customer, sr.id_inv, sr.no_spk, sr.no_po, sr.tgl_pesanan,
            cs.nama_cs, cs.alamat, ordby.order_by, sl.nama_sales 
            FROM inv_nonppn AS nonppn
            JOIN spk_reg sr ON (nonppn.id_inv_nonppn = sr.id_inv)
            JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
            JOIN tb_orderby ordby ON(sr.id_orderby = ordby.id_orderby)
            JOIN tb_sales sl ON(sr.id_sales = sl.id_sales)
            WHERE nonppn.id_inv_nonppn = '$id_inv'";
    $query = mysqli_query($connect, $sql);
    $data = mysqli_fetch_array($query);
    // Ubah Format Tanggal
    $bulan = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    ];
    // Untuk tgl Invoice
    $dateString = $data['tgl_inv'];
    $dateParts = explode('/', $dateString);
    $day = $dateParts[0];
    $month = $dateParts[1];
    $year = $dateParts[2];
    $tgl_inv_format = $day . ' ' . $bulan[$month] . ' ' . $year;

    // Untuk tgl Tempo
    $dateString = $data['tgl_tempo'];
    $dateParts = explode('/', $dateString);
    $day = $dateParts[0];
    $month = $dateParts[1];
    $year = $dateParts[2];

    $tgl_tempo_format = $day . ' ' . $bulan[$month] . ' ' . $year;

    // kode untuk menampilkan jika ada data yang harus di tampilkan lebih dari 1
    // Tampilkan data lain jika ada
    ?>
    <div class="invoice">
        <div class="invoice-header">
            <div class="col-header-1">
                <!-- Kolom pertama -->
                <div class="ket-in-1">
                    No. Invoice <br>
                    Tgl. Invoice <br>
                    Tgl.Jatuh Tempo
                </div>

                <div class="ket-in-2">
                    &nbsp;: <?php echo $data['no_inv'] ?> <br>
                    &nbsp;: <?php echo $tgl_inv_format ?> <br>
                    &nbsp;: <?php echo $tgl_tempo_format ?>
                </div>
            </div>
            <div class="col-header-2">
                <!-- Kolom kedua -->
                Kepada : <br>
                <?php echo $data['nama_cs'] ?> <br>
                <?php echo $data['alamat'] ?>

            </div>
        </div>
        <div class="invoice-header">
            <div class="col-header-3">
                <!-- Kolom kedua -->
                No. PO : <br>
                <?php
                $sql2 = "SELECT 
                nonppn.*, 
                sr.id_user, sr.id_customer, sr.id_inv, sr.no_spk, sr.no_po, sr.tgl_pesanan,
                cs.nama_cs, cs.alamat, ordby.order_by, sl.nama_sales 
                FROM inv_nonppn AS nonppn
                JOIN spk_reg sr ON (nonppn.id_inv_nonppn = sr.id_inv)
                JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                JOIN tb_orderby ordby ON(sr.id_orderby = ordby.id_orderby)
                JOIN tb_sales sl ON(sr.id_sales = sl.id_sales)
                WHERE nonppn.id_inv_nonppn = '$id_inv'";
                $query2 = mysqli_query($connect, $sql2);
                $rowIndex = 0;
                $totalRows = mysqli_num_rows($query2);
                $dataCount = 0;
                $output = ''; // Variabel untuk menyimpan hasil output

                while ($data2 = mysqli_fetch_array($query2)) {
                    $dataCount++;
                    // Periksa jika nilai no_po tidak kosong
                    if (!empty($data2['no_po'])) {
                        // Tampilkan nilai kolom pada setiap baris
                        $output .= $data2['no_po'];

                        // Tambahkan koma jika bukan baris terakhir
                        if ($rowIndex < $totalRows - 1 && $dataCount < $totalRows) {
                            $output .= ', ';
                        }
                    }

                    $rowIndex++;
                }

                // Tambahkan tanda titik di akhir data
                if (!empty($output)) {
                    $output .= '.';
                }

                // Tampilkan hasil output
                echo $output;


                ?>

            </div>
        </div>
        <div class="invoice-body">
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th style="width: 30px;">No</th>
                        <th style="width: 200px;">Nama Produk</th>
                        <th style="width: 40px;">Qty</th>
                        <th style="width: 80px;">Harga</th>
                        <th style="width: 40px;">Disc</th>
                        <th style="width: 80px;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Detail produk -->
                    <?php
                    include "koneksi.php";
                    $year = date('y');
                    $day = date('d');
                    $month = date('m');
                    $id_nonppn_decode = base64_decode($_GET['id']);
                    $no = 1;
                    $sql_trx = "SELECT
                    nonppn.id_inv_nonppn, nonppn.status_simpan,
                    sr.id_inv, sr.no_spk,
                    trx.*,
                    spr.stock,
                    tpr.nama_produk,
                    tpr.harga_produk, mr.*
                    FROM inv_nonppn AS nonppn
                    JOIN spk_reg sr ON (nonppn.id_inv_nonppn = sr.id_inv)
                    JOIN transaksi_produk_reg trx ON(sr.id_spk_reg = trx.id_spk)
                    JOIN stock_produk_reguler spr ON(trx.id_produk = spr.id_produk_reg)
                    JOIN tb_produk_reguler tpr ON(trx.id_produk = tpr.id_produk_reg)
                    JOIN tb_merk mr ON (tpr.id_merk = mr.id_merk)
                    WHERE nonppn.id_inv_nonppn = '$id_nonppn_decode' AND nonppn.status_simpan = '0' ORDER BY no_spk ASC";
                    $trx_produk_reg = mysqli_query($connect, $sql_trx);
                    while ($data_trx = mysqli_fetch_array($trx_produk_reg)) {
                    ?>
                        <tr>
                            <td align="center"><?php echo $no; ?></td>
                            <td><?php echo $data_trx['nama_produk'] ?></td>
                            <td align="right"><?php echo number_format($data_trx['qty']) ?></td>
                            <td align="right"><?php echo number_format($data_trx['harga_produk']) ?></td>
                            <td align="right"><?php echo number_format($data_trx['qty']) ?></td>
                            <td align="right"><?php echo number_format($data_trx['qty']) ?></td>
                        </tr>
                        <?php $no++ ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="invoice-payment">
            <div class="col-payment-1">
                <!-- Kolom pertama -->
                Terbilang :<br>
                Satu Juta Lima Ratus Ribu Rupiah
            </div>
            <div class="col-payment-2">
                <!-- Kolom kedua -->
                <div class="grand-total">
                    Grand total (Rp):
                </div>
                <div class="amount">
                    1.569.300
                </div>
            </div>
        </div>

        <div class="invoice-footer">
            <div class="col1">
                <!-- Kolom pertama -->
                <p>Disetujui oleh:</p>
                <br>
                <p>_____________</p>
            </div>
            <div class="col2">
                <!-- Kolom kedua -->
                <p>Diantar oleh:</p>
                <br>
                <p>_____________</p>
            </div>
            <div class="col3">
                <!-- Kolom ketiga -->
                <p>Diterima oleh:</p>
                <br>
                <p>_____________</p>
            </div>
            <div class="col4">
                <!-- Kolom keempat -->
                <p></p>
                METODE PEMBAYARAN :<br>
                TRANSFER BANK BCA <br>
                NO. REK : 521 134 7105 <br>
                ATAS NAMA : LASINO <br>
            </div>
        </div>
    </div>
</body>

</html>