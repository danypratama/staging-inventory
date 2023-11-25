<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>
    <link href="assets/img/logo-kma.png" rel="icon">
    <link href="assets/img/logo-kma.png" rel="apple-touch-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style-inv-nonppn.css">
</head>

<body>
    <?php
    include "koneksi.php";
    $id_inv = base64_decode($_GET['id']);
    $sql = "SELECT 
            bum.*, 
            sr.id_user, sr.id_customer, sr.id_inv, sr.no_spk, sr.no_po, sr.tgl_pesanan,
            cs.nama_cs, cs.alamat, ordby.order_by, sl.nama_sales 
            FROM inv_bum AS bum
            JOIN spk_reg sr ON (bum.id_inv_bum = sr.id_inv)
            JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
            JOIN tb_orderby ordby ON(sr.id_orderby = ordby.id_orderby)
            JOIN tb_sales sl ON(sr.id_sales = sl.id_sales)
            WHERE bum.id_inv_bum = '$id_inv'";
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
    $dateStringTempo = $data['tgl_tempo'];
    ?>
    <div class="invoice">
        <div style="text-align: center;">
            <button id="printButton" class="print-button">
                <i class="fas fa-print"></i> Print
            </button>
        </div>
        <h2 align='right'><strong>INVOICE</strong></h2>
        <div class="invoice-header">
            <div class="col-header-1">
                <!-- Kolom pertama -->
                <div class="ket-in-1">
                    No. Invoice <br>
                    Tgl. Invoice <br>
                    <?php
                    if (!empty($dateStringTempo)) {
                        echo "Tgl.Jatuh Tempo";
                    }
                    ?>
                </div>

                <div class="ket-in-2">
                    &nbsp;: <?php echo $data['no_inv'] ?> <br>
                    &nbsp;: <?php echo $tgl_inv_format ?> <br>
                    <?php
                    if (!empty($dateStringTempo)) {
                        $datePartsTempo = explode('/', $dateStringTempo);
                        $dayTempo = $datePartsTempo[0];
                        $monthTempo = $datePartsTempo[1];
                        $yearTempo = $datePartsTempo[2];

                        $tgl_tempo_format = $dayTempo . ' ' . $bulan[$monthTempo] . ' ' . $yearTempo;
                        echo "&nbsp;:" . $tgl_tempo_format;
                    }
                    ?>
                </div>
            </div>
            <div class="col-header-2">
                <!-- Kolom kedua -->
                Kepada : <br>
                <?php echo $data['cs_inv'] ?> <br>
                <?php echo $data['alamat'] ?>
            </div>
        </div>
        <!-- Kolom kedua -->
        <?php
        $sql2 = "SELECT 
                bum.*, 
                sr.id_user, sr.id_customer, sr.id_inv, sr.no_spk, sr.no_po, sr.tgl_pesanan,
                cs.nama_cs, cs.alamat, ordby.order_by, sl.nama_sales 
                FROM inv_bum AS bum
                JOIN spk_reg sr ON (bum.id_inv_bum = sr.id_inv)
                JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                JOIN tb_orderby ordby ON(sr.id_orderby = ordby.id_orderby)
                JOIN tb_sales sl ON(sr.id_sales = sl.id_sales)
                WHERE bum.id_inv_bum = '$id_inv'";
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

            // Tampilkan hanya jika ada data yang ditampilkan
            echo "<div class='invoice-header'><div class='col-header-3'>No.PO :  <br>"  . $output . "</div></div>";
        }
        ?>

        <div class="invoice-body">
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th style="width: 30px;">No</th>
                        <th style="width: 200px;">Nama Produk</th>
                        <th style="width: 40px;">Qty</th>
                        <th style="width: 80px;">Harga</th>
                        <?php
                        if ($data['kategori_inv'] == 'Diskon') {
                            echo '<th style="width: 40px;">Disc</th>';
                        }
                        ?>
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
                    $id_bum_decode = base64_decode($_GET['id']);
                    $no = 1;
                    $grand_total = 0;
                    $sub_total_spdisc = 0;
                    $sql_trx = "SELECT
                                    bum.id_inv_bum,
                                    bum.kategori_inv,
                                    bum.sp_disc,
                                    bum.note_inv,
                                    bum.total_inv,
                                    spk.id_inv, 
                                    spk.no_spk,
                                    trx.id_transaksi,
                                    trx.id_produk,
                                    trx.nama_produk_spk,
                                    trx.harga,
                                    SUM(trx.qty) AS total_qty,
                                    trx.disc,
                                    trx.total_harga,
                                    trx.status_trx,
                                    tpr.nama_produk,
                                    mr_produk.nama_merk AS merk_produk, -- Nama merk untuk produk reguler
                                    tpsm.nama_set_marwa,
                                    tpsm.harga_set_marwa,
                                    mr_set.nama_merk AS merk_set -- Nama merk untuk produk set
                                FROM inv_bum AS bum
                                LEFT JOIN spk_reg spk ON (bum.id_inv_bum = spk.id_inv)
                                LEFT JOIN transaksi_produk_reg trx ON trx.id_spk = spk.id_spk_reg
                                LEFT JOIN tb_produk_reguler tpr ON trx.id_produk = tpr.id_produk_reg
                                LEFT JOIN tb_produk_set_marwa tpsm ON trx.id_produk = tpsm.id_set_marwa
                                LEFT JOIN tb_merk mr_produk ON tpr.id_merk = mr_produk.id_merk -- JOIN untuk produk reguler
                                LEFT JOIN tb_merk mr_set ON tpsm.id_merk = mr_set.id_merk -- JOIN untuk produk set
                                WHERE bum.id_inv_bum = '$id_bum_decode'
                                GROUP BY trx.id_produk, tpsm.nama_set_marwa, trx.nama_produk_spk, mr_set.nama_merk, mr_produk.nama_merk
                                ORDER BY no_spk ASC";
                    $trx_produk_reg = mysqli_query($connect, $sql_trx);
                    while ($data_trx = mysqli_fetch_array($trx_produk_reg)) {
                        $id_inv_update = $data_trx['id_inv_bum'];
                        $total_inv = $data_trx['total_inv'];
                        $note_inv = $data_trx['note_inv'];
                        $kat_inv = $data_trx['kategori_inv'];
                        $qty = $data_trx['total_qty'];
                        $harga = $data_trx['harga'];
                        $disc = $data_trx['disc'] / 100;
                        $tampil_disc = $data_trx['disc'];
                        $tampil_spdisc = $data_trx['sp_disc'];
                        $harga_disc = $harga * $disc;
                        $total = $harga - $harga_disc;
                        $sub_total = floor($total * $qty);
                        $sub_total_fix = floor($sub_total - $sub_total_spdisc);
                        $grand_total += floor($sub_total_fix);
                    ?>
                        <tr>
                            <td align="center"><?php echo $no; ?></td>
                            <td><?php echo $data_trx['nama_produk_spk'] ?></td>
                            <td align="right"><?php echo number_format($data_trx['total_qty'], 0, '.', '.') ?></td>
                            <td align="right"><?php echo number_format($data_trx['harga'], 0, '.', '.') ?></td>
                            <?php
                            if ($data_trx['kategori_inv'] == 'Diskon') {
                                echo '<td align="right">' . $tampil_disc . ' %</td>';
                            }
                            ?>
                            <td align="right"><?php echo number_format($sub_total_fix, 0, '.', '.') ?></td>
                        </tr>
                        <?php $no++ ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="invoice-payment">
            <?php
            $sql_inv = mysqli_query($connect, "SELECT id_inv_bum, sp_disc, ongkir FROM inv_bum WHERE id_inv_bum = '$id_bum_decode'");
            $data_inv = mysqli_fetch_array($sql_inv);
            $sp_disc = $data_inv['sp_disc'] / 100;
            $ongkir = $data_inv['ongkir'];
            $sub_total_spdisc = $grand_total * $sp_disc;
            $grand_total_fix = $grand_total - $sub_total_spdisc + $ongkir;
            ?>
            <div class="col-payment-1">
                <!-- Kolom pertama -->
                Terbilang :<br>
                <?php echo terbilang($grand_total_fix) ?>

            </div>
            <div class="col-payment-2">
                <!-- Kolom kedua -->
                <div class="grand-total">

                    <?php
                    if ($kat_inv == 'Spesial Diskon' && $sp_disc != 0) {
                        echo 'Spesial Diskon :';
                        echo "<br>";
                    }
                    ?>

                    <?php
                    if ($ongkir != 0) {
                        echo "Ongkir (Rp):";
                        echo "<br>";
                    }
                    ?>

                    Grand total (Rp):
                </div>
                <div class="amount">

                    <?php
                    if ($kat_inv == 'Spesial Diskon' && $sp_disc != 0) {
                        echo $data_inv['sp_disc'] . '(%)';
                        echo "<br>";
                    }
                    ?>

                    <?php
                    if ($ongkir != 0) {
                        echo number_format($ongkir, 0, '.', '.');
                        echo "<br>";
                    }
                    ?>

                    <?php echo number_format($grand_total_fix, 0, '.', '.') ?>
                </div>
            </div>
        </div>
        <!-- Tampilan Note -->
        <?php
        if ($note_inv != '') {
            echo "<div class='col-header-2'>";
            echo "Note : <br>";
            echo $note_inv;
            echo "</div>";
        }
        ?>

        <!-- Kode untuk update total harga -->
        <?php
        if ($total_inv != $grand_total_fix) {
            mysqli_query($connect, "UPDATE inv_bum SET total_inv = '$grand_total_fix' WHERE id_inv_bum = '$id_inv'");
        }

        ?>
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

<?php
function penyebut($nilai)
{
    $nilai = abs($nilai);
    $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " " . $huruf[$nilai];
    } else if ($nilai < 20) {
        $temp = penyebut($nilai - 10) . " Belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai / 10) . " Puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " Seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . " Ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . " Ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . " Juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . " Milyar" . penyebut(fmod($nilai, 1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . " Trilyun" . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
}

function terbilang($nilai)
{
    if ($nilai < 0) {
        $hasil = "minus " . trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }
    return $hasil;
}
?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js" integrity="sha512-OpVm6PQGWfDksMIZ0iigU4S+hRC3MM9J90Yij1EC5Bp7ZoABK/zZxttCzA3iTL4vYNY41FqCMLaE0WvjgiywFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        // Function to generate the PDF
        function generatePDF() {
            const element = document.querySelector('.invoice');
            const options = {
                margin: 0.5,
                filename: 'invoice.pdf',
                image: { type: 'jpeg', quality: 1 },
                html2canvas: { scale: 4 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            html2pdf().set(options).from(element).save();
        }

        // Call the generatePDF function when the page is loaded
        window.addEventListener('load', generatePDF);
    </script>

<script>
    // Fungsi untuk menampilkan dialog pencetakan
    function showPrintDialog() {
        window.print();
    }

    // Menambahkan event listener ke tombol cetak
    document.getElementById('printButton').addEventListener('click', showPrintDialog);
</script>