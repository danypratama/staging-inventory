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
    <div class="table-responsive" id="filteredDataBUM">
        <table class="table table-bordered table-striped" id="table9">
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
                $start_date = $_GET['start_date_bum']; // Tanggal awal rentang
                $end_date = $_GET['end_date_bum'];// Tanggal akhir rentang
                $sql = "SELECT  bum.id_inv_bum,
                                bum.no_inv, 
                                STR_TO_DATE(bum.tgl_inv, '%d/%m/%Y') AS tgl_inv,
                                bum.cs_inv, 
                                bum.tgl_tempo, 
                                bum.sp_disc, 
                                bum.note_inv, 
                                bum.kategori_inv, 
                                bum.ongkir, 
                                bum.total_inv, 
                                bum.status_transaksi, 
                                sr.id_inv, 
                                sr.id_customer, 
                                sr.no_po, 
                                cs.nama_cs, cs.alamat, 
                                fn.status_pembayaran, fn.id_inv
                                FROM inv_bum AS bum
                                LEFT JOIN spk_reg sr ON(bum.id_inv_bum = sr.id_inv)
                                JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                JOIN finance fn ON (fn.id_inv = bum.id_inv_bum)
                                WHERE status_transaksi = 'Transaksi Selesai' AND
                                STR_TO_DATE(bum.tgl_inv, '%d/%m/%Y') >= STR_TO_DATE('$start_date', '%d/%m/%Y') AND
                                STR_TO_DATE(bum.tgl_inv, '%d/%m/%Y') <= STR_TO_DATE('$end_date', '%d/%m/%Y')
                        GROUP BY no_inv ORDER BY no_inv";
                $query = mysqli_query($connect, $sql);
                while ($data = mysqli_fetch_array($query)) {
                ?>
                    <tr>
                        <td class="text-center text-nowrap"><?php echo $no; ?></td>
                        <td class="text-nowrap"><?php echo $data['no_inv'] ?></td>
                        <td class="text-nowrap"><?php echo $data['tgl_inv'] ?></td>
                        <td class="text-nowrap"><?php echo $data['no_po'] ?></td>
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
                            <a href="cek-produk-inv-bum-selesai.php?id=<?php echo base64_encode($data['id_inv_bum']) ?>" class="btn btn-primary btn-sm mb-2"><i class="bi bi-eye-fill"></i> Lihat</a>
                        </td>
                    </tr>
                    <?php $no++ ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php include "page/script.php" ?>
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable
            var table = $('#table9').DataTable({
                "lengthChange": false,
                "ordering": false,
                "autoWidth": false
            });
        });

        function filterDataBUM() {
            // Ambil nilai filter dari elemen select
            var dateRangeBumValue = document.getElementById('dateRangeBUM').value;
            var startDate = document.getElementById('start_date_bum').value;
            var endDate = document.getElementById('end_date_bum').value;

            // Buat objek XMLHttpRequest
            var xhttp = new XMLHttpRequest();

            // Atur callback function untuk menangani perubahan status permintaan
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Update elemen filteredData dengan hasil filter yang selesai dari server
                    document.getElementById('filteredDataBUM').innerHTML = this.responseText;
                    // Inisialisasi ulang DataTable setelah mengganti isi tabel
                    $('#table9').DataTable({
                        "lengthChange": false,
                        "ordering": false,
                        "autoWidth": false
                    });

                    flatpickr("#start_date_bum", {
                        dateFormat: "d/m/Y",
                        onClose: function(selectedDates, dateStr, instance) {
                        // Ambil tanggal awal yang dipilih
                        var startDate = selectedDates[0];

                        // Perbarui batas tanggal maksimal pada pemilih tanggal akhir
                        var endDateInput = document.getElementById("end_date");
                        var endDatePicker = flatpickr("#end_date_bum", {
                            dateFormat: "d/m/Y",
                            minDate: startDate,
                            maxDate: new Date(startDate.getTime() + 30 * 24 * 60 * 60 * 1000)
                        });

                        // Jika tanggal akhir saat ini berada di bawah tanggal awal, hapus nilainya
                        var endDate = endDatePicker.selectedDates[0];
                        if (endDate < startDate) {
                            endDateInput.value = "";
                        }
                        }
                    });
                }
            };

            // Buat permintaan GET ke file PHP yang akan memproses filter
            var url = 'filter-date-trx-bum-selesai.php?start_date_bum=' + startDate + '&end_date_bum=' + endDate ;
            xhttp.open('GET', url, true);
            xhttp.send();
            // Tambahkan kode berikut untuk menjaga collapse tetap terbuka setelah button cari data diklik
            $('#bum').collapse('show');
        }
    </script>
</body>
</html>