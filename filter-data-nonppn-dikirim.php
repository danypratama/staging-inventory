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
        <div class="row mb-3 mt-4">
            <div class="col-md-2">
                <form action="" method="GET">

                    <select name="sort" class="form-select" id="select" aria-label="Default select example" onchange="filterData()">
                        <option value="baru" <?php if (isset($_GET['sort']) && $_GET['sort'] == "baru") {
                                                    echo "selected";
                                                } ?>>Paling Baru</option>
                        <option value="lama" <?php if (isset($_GET['sort']) && $_GET['sort'] == "lama") {
                                                    echo "selected";
                                                } ?>>Paling Lama</option>
                    </select>

                </form>
            </div>
        </div>
        <table class="table table-bordered table-striped" id="table5">
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
                $filter = '';
                if (isset($_GET['sort'])) {
                    if ($_GET['sort'] == "baru") {
                        $filter = "ORDER BY tgl_inv DESC";
                    } elseif ($_GET['sort'] == "lama") {
                        $filter = "ORDER BY tgl_inv ASC";
                    }
                }
                $sql = "SELECT nonppn.*, sr.id_inv, sr.id_customer, sr.no_po, cs.nama_cs, cs.alamat
                                                            FROM inv_nonppn AS nonppn
                                                            LEFT JOIN spk_reg sr ON(nonppn.id_inv_nonppn = sr.id_inv)
                                                            JOIN tb_customer cs ON(sr.id_customer = cs.id_cs)
                                                            WHERE status_transaksi = 'Dikirim' GROUP BY no_inv  $filter";
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
                            <a href="cek-produk-inv-nonppn-dikirim.php?id=<?php echo base64_encode($data['id_inv_nonppn']) ?>" class="btn btn-primary btn-sm mb-2"><i class="bi bi-eye-fill"></i> Lihat</a>
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
            var table = $('#table5').DataTable({
                "lengthChange": false,
                "ordering": false,
                "autoWidth": false
            });
        });

        // Fungsi untuk mengirim permintaan AJAX
        function filterData() {
            var sortValue = document.getElementById('select').value;

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById('filteredData').innerHTML = this.responseText;

                    // Inisialisasi ulang DataTable setelah mengganti isi tabel
                    $('#table5').DataTable({
                        "lengthChange": false,
                        "ordering": false,
                        "autoWidth": false
                    });
                }
            };

            xhttp.open('GET', 'filter-data-nonppn-dikirim.php?sort=' + sortValue, true);
            xhttp.send();
        }
    </script>
</body>

</html>