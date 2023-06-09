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
        <form id="invoiceForm" name="proses" onsubmit="filterData(); return false;">
            <div class="row mb-3 mt-4">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="start_date">Tanggal Awal:</label>
                            <input type="date" name="start_date" id="start_date" class="form-control text-center" value="<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="end_date">Tanggal Akhir:</label>
                            <input type="date" name="end_date" id="end_date" class="form-control text-center" value="<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>" readonly>
                        </div>
                        <div class="col-md-3 text-center">
                            <br>
                            <button type="submit" class="btn btn-primary" id="select">Cari Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <table class="table table-bordered table-striped" id="table7">
            <thead>
                <tr class="text-white" style="background-color: navy;">
                    <th class="text-center p-3 text-nowrap" style="width: 30px">No</th>
                    <th class="text-center p-3 text-nowrap" style="width: 150px">No. Invoice</th>
                    <th class="text-center p-3 text-nowrap" style="width: 150px">Tgl. Invoice</th>
                    <th class="text-center p-3 text-nowrap" style="width: 150px">No. PO</th>
                    <th class="text-center p-3 text-nowrap" style="width: 250px">Nama Customer</th>
                    <th class="text-center p-3 text-nowrap" style="width: 100px">Kat. Inv</th>
                    <th class="text-center p-3 text-nowrap" style="width: 100px">Note</th>
                    <th class="text-center p-3 text-nowrap" style="width: 80px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include "koneksi.php";
                $no = 1;
                $start_date = $_GET['start_date']; // Tanggal awal rentang
                $end_date = $_GET['end_date'];// Tanggal akhir rentang
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
                                tgl_inv >= '$start_date' AND
                                tgl_inv <= '$end_date' GROUP BY no_inv";
                $query = mysqli_query($connect, $sql);
                while ($data = mysqli_fetch_array($query)) {
                ?>
                    <tr>
                        <td class="text-center text-nowrap"><?php echo $no; ?></td>
                        <td class="text-nowrap"><?php echo $data['no_inv'] ?></td>
                        <td class="text-nowrap"><?php echo $data['tgl_inv'] ?></td>
                        <td class="text-nowrap"><?php echo $data['no_po'] ?></td>
                        <td class="text-nowrap"><?php echo $data['nama_cs'] ?></td>
                        <td class="text-nowrap"><?php echo $data['kategori_inv'] ?></td>
                        <td class="text-nowrap"><?php echo $data['note_inv'] ?></td>
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
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable
            var table = $('#table7').DataTable({
                "lengthChange": false,
                "ordering": false,
                "autoWidth": false
            });
        });

        function filterData() {
            // Ambil nilai filter dari elemen select
            var sortValue = document.getElementById('select').value;
            var startDate = document.getElementById('start_date').value;
            var endDate = document.getElementById('end_date').value;

            // Buat objek XMLHttpRequest
            var xhttp = new XMLHttpRequest();

            // Atur callback function untuk menangani perubahan status permintaan
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Update elemen filteredData dengan hasil filter yang selesai dari server
                    document.getElementById('filteredData').innerHTML = this.responseText;
                    // Inisialisasi ulang DataTable setelah mengganti isi tabel
                    $('#table7').DataTable({
                        "lengthChange": false,
                        "ordering": false,
                        "autoWidth": false
                    });

                    flatpickr("#start_date", {
                        dateFormat: "d/m/Y",
                        onClose: function(selectedDates, dateStr, instance) {
                        // Ambil tanggal awal yang dipilih
                        var startDate = selectedDates[0];

                        // Perbarui batas tanggal maksimal pada pemilih tanggal akhir
                        var endDateInput = document.getElementById("end_date");
                        var endDatePicker = flatpickr("#end_date", {
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
            xhttp.open('GET', 'filter-date-trx-nonppn-selesai.php?' + sortValue + '&start_date=' + startDate + '&end_date=' + endDate, true);
            xhttp.send();

            // Tambahkan kode berikut untuk menjaga collapse tetap terbuka setelah button cari data diklik
            $('#nonppn').collapse('show');
        }
    </script>
</body>

</html>