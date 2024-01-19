<?php
$page = 'br-masuk';
$page2 = 'br-masuk-reg';
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css">

    <style>
        #table2 {
            cursor: pointer;
        }

        #table3 {
            cursor: pointer;
        }

        input[type="text"]:read-only {
            background: #e9ecef;
        }

        textarea[type="text"]:read-only {
            background: #e9ecef;
        }

        pre {
            font-family: "Open Sans", sans-serif;
            font-size: 16px;
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
        <div class="loader loader">
            <div class="loading">
                <img src="img/loading.gif" width="200px" height="auto">
            </div>
        </div>
        <!-- ENd Loading -->
        <section>
            <!-- SWEET ALERT -->
            <div class="info-data" data-infodata="<?php if (isset($_SESSION['info'])) {
                                                        echo $_SESSION['info'];
                                                    }
                                                    unset($_SESSION['info']); ?>"></div>
            <!-- END SWEET ALERT -->
            <div class="container-fluid">
                <?php  
                    include "koneksi.php";
                    $id_role = $_SESSION['tiket_role'];
                    $sql_role = "SELECT * FROM user_role WHERE id_user_role='$id_role'";
                    $query_role = mysqli_query($connect, $sql) or die(mysqli_error($connect));
                    $data_role = mysqli_fetch_array($query_role);
                ?>
                <div class="card">
                    <div class="card-body mt-3">
                        <?php
                        $id = base64_decode($_GET['id']);
                        $add = base64_encode($id);
                        ?>
                        <div class="text-start">
                            <a href="barang-masuk-reg-import.php" class="btn btn-md btn-secondary text-end"><i class="bi bi-arrow-left"></i> Kembali</a>
                            <?php  
                                if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Manager Gudang" ) { 
                                    ?>
                                        <a href="input-isi-inv-br-import.php?id=<?php echo $add ?>" class="btn btn-md btn-primary text-end"><i class="bi bi-plus-circle"></i> Tambah data order</a>
                                    <?php
                                }
                            ?>
                        </div>
                        <div class="mt-3">
                            <div class="p-3">
                                <?php
                                include "koneksi.php";
                                $sql = "SELECT ibi.*, ibi.created_date AS created, sp.*, uc.nama_user as user_created
                                        FROM inv_br_import AS ibi
                                        LEFT JOIN user uc ON (ibi.id_user = uc.id_user)
                                        LEFT JOIN tb_supplier sp ON (ibi.id_supplier = sp.id_sp)
                                        WHERE id_inv_br_import = '$id' LIMIT 1 ";
                                $query = mysqli_query($connect, $sql);
                                while ($data = mysqli_fetch_array($query)) {
                                ?>
                                    <div class="row">
                                        <div class="col-sm-6 border">
                                            <pre>
                                        <table>
                                            <tr>
                                                <td class="p-2" style="width: 130px">No. Invoice</td>
                                                <td class="p-2" style="width: 350px">: <?php echo $data['no_inv'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class="p-2" style="width: 130px">Tgl. Invoice</td>
                                                <td class="p-2" style="width: 350px">: <?php echo $data['tgl_inv'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class="p-2" style="width: 130px">Tgl. Order</td>
                                                <td class="p-2" style="width: 350px">: <?php echo $data['tgl_order'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class="p-2" style="width: 130px">No. AWB</td>
                                                <td class="p-2" style="width: 350px">: <?php echo $data['no_awb'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class="p-2" style="width: 130px">Dikirim Via</td>
                                                <td class="p-2" style="width: 350px">: <?php echo $data['shipping_by'] ?></td>
                                            </tr>
                                        </table>
                                    </pre>
                                        </div>
                                        <div class="col-sm-6 border">
                                            <pre>
                                        <table>
                                            <tr>
                                                <td class="p-2" style="width: 130px">Supplier</td>
                                                <td class="p-2" style="width: 350px">: <?php echo $data['nama_sp'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class="p-2" style="width: 130px">Alamat</td>
                                                <td class="p-2" style="width: 350px">: <?php echo $data['alamat'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class="p-2" style="width: 130px">Tgl. Estimasi</td>
                                                <td class="p-2" style="width: 350px">: <?php echo $data['tgl_est'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class="p-2" style="width: 130px">Status</td>
                                                <td class="p-2" style="width: 350px">: <?php echo $data['status_pengiriman'] ?> <?php echo $data['tgl_terima'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class="p-2" style="width: 130px">Keterangan</td>
                                                <td class="p-2" style="width: 350px">: <?php echo $data['keterangan'] ?></td>
                                            </tr>
                                        </table>
                                    </pre>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body mt-3">
                        <!-- Pills Tabs -->
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Produk Order</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Produk Actual</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2" id="myTabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="table1">
                                        <thead>
                                            <tr class="text-white" style="background-color: navy;">
                                                <td class="text-center text-nowrap p-3 col-1">No</td>
                                                <td class="text-center text-nowrap p-3 col-5">Nama Produk</td>
                                                <td class="text-center text-nowrap p-3 col-1">Order</td>
                                                <td class="text-center text-nowrap p-3 col-1">Actual</td>
                                                <td class="text-center text-nowrap p-3 col-2">Status</td>
                                                <td class="text-center text-nowrap p-3 col-1">Aksi</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include "koneksi.php";
                                            $id = base64_decode($_GET['id']);
                                            $no = 1;
                                            $sql = "SELECT 
                                                        iibi.*, 
                                                        iibi.id_isi_inv_br_import AS id_isi_inv, 
                                                        iibi.created_date AS created, 
                                                        ibi.*, 
                                                        uc.nama_user AS user_created, 
                                                        uu.nama_user as user_updated, 
                                                        tpr.*, 
                                                        act.*, 
                                                        SUM(act.qty_act) AS total_qty_act
                                                    FROM isi_inv_br_import AS iibi 
                                                    LEFT JOIN user uc ON (iibi.id_user = uc.id_user) 
                                                    LEFT JOIN user uu ON (iibi.user_updated = uu.id_user) 
                                                    LEFT JOIN inv_br_import ibi ON (iibi.id_inv_br_import = ibi.id_inv_br_import) 
                                                    LEFT JOIN tb_produk_reguler tpr ON (iibi.id_produk_reg = tpr.id_produk_reg) 
                                                    LEFT JOIN act_br_import act ON (iibi.id_isi_inv_br_import = act.id_isi_inv_br_import) 
                                                    WHERE iibi.id_inv_br_import = '$id' 
                                                    GROUP BY iibi.id_isi_inv_br_import";

                                            $query = mysqli_query($connect, $sql);
                                            while ($data = mysqli_fetch_array($query)) {
                                                $order = $data['qty'];
                                                $actual = $data['total_qty_act'];
                                                $total_min = $actual - $order;
                                            ?>
                                                <tr>
                                                    <td class="text-center text-nowrap"><?php echo $no; ?></td>
                                                    <td class="text-nowrap"><?php echo $data['nama_produk']; ?></td>
                                                    <td class="text-end text-nowrap"><?php echo number_format($data['qty']); ?></td>
                                                    <td class="text-end text-nowrap"><?php echo number_format($data['total_qty_act']); ?></td>
                                                    <?php
                                                    if ($actual == 0) {
                                                        echo "<td class='text-end'></td>";
                                                    } else if ($actual < $order) {
                                                        echo "<td class='text-end text-nowrap bg-danger text-white'> $total_min item</td>";
                                                    } else if ($actual > $order) {
                                                        echo "<td class='text-end text-nowrap bg-warning'>+$total_min item</td>";
                                                    } else {
                                                        echo "<td class='text-end text-nowrap bg-success text-white'>Oke</td>";
                                                    }
                                                    ?>
                                                    <td class="text-center text-nowrap">
                                                        <?php  
                                                            if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Manager Gudang" ) { 
                                                                ?>
                                                                    <a class="btn btn-secondary btn-sm" href="update-br-import.php?id=<?php echo base64_encode($data['id_isi_inv']); ?>" title="Input Actual">
                                                                        <i class="bi bi-box-seam"></i>
                                                                    </a>
                                                                <?php
                                                            }
                                                        ?>
                                                       
                                                        <a class="btn btn-info btn-sm" href="list-act-br-import.php?id=<?php echo base64_encode($data['id_isi_inv']); ?> && id_inv=<?php echo base64_encode($data['id_inv_br_import']); ?>" title="Detail Actual">
                                                            <i class="bi bi-info-circle"></i>
                                                        </a>
                                                        <?php  
                                                            if ($data_role['role'] == "Super Admin" || $data_role['role'] == "Manager Gudang" ) { 
                                                                ?>
                                                                    <a class="btn btn-warning btn-sm" href="edit-br-import.php?id=<?php echo base64_encode($data['id_isi_inv']); ?> && id_inv=<?php echo base64_encode($data['id_inv_br_import']); ?>" title="Edit Data Order">
                                                                        <i class="bi bi-pencil"></i>
                                                                    </a>
                                                                    <a class="btn btn-danger btn-sm delete-data" href="proses/proses-br-in-import.php?hapus=<?php echo base64_encode($data['id_isi_inv']); ?> && id_inv=<?php echo base64_encode($data['id_inv_br_import']); ?> ">
                                                                        <i class="bi bi-trash"></i>
                                                                    </a>
                                                                <?php
                                                            }
                                                        ?>   
                                                    </td>
                                                </tr>
                                                <?php $no++ ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="table-responsive mt-3">
                                    <table class="table table-bordered table-striped" id="tableKu">
                                        <thead>
                                            <tr class="text-white" style="background-color: navy;">
                                                <td class="text-center text-nowrap p-3 col-1">No</td>
                                                <td class="text-center text-nowrap p-3 col-6">Nama Barang</td>
                                                <td class="text-center text-nowrap p-3 col-3">Merk</td>
                                                <td class="text-center text-nowrap p-3 col-1">Qty</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include "koneksi.php";
                                            $id = base64_decode($_GET['id']);
                                            $no = 1;
                                            $sql = "SELECT 
                                                    act.id_isi_inv_br_import AS id_isi_inv,  
                                                    tpr.nama_produk,
                                                    SUM(act.qty_act) AS total_qty_act,
                                                    mr.nama_merk
                                                    FROM isi_inv_br_import AS iibi
                                                    LEFT JOIN inv_br_import ibi ON (iibi.id_inv_br_import = ibi.id_inv_br_import) 
                                                    LEFT JOIN tb_produk_reguler tpr ON (iibi.id_produk_reg = tpr.id_produk_reg) 
                                                    LEFT JOIN act_br_import act ON (iibi.id_isi_inv_br_import = act.id_isi_inv_br_import) 
                                                    LEFT JOIN tb_merk mr ON (tpr.id_merk = mr.id_merk)
                                                    WHERE iibi.id_inv_br_import = '$id' AND act.qty_act IS NOT NULL GROUP BY iibi.id_isi_inv_br_import";
                                            $query = mysqli_query($connect, $sql);
                                            while ($data = mysqli_fetch_array($query)) {
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $no; ?></td>
                                                    <td class="text-nowrap"><?php echo $data['nama_produk']; ?></td>
                                                    <td class="text-center text-nowrap"><?php echo $data['nama_merk']; ?></td>
                                                    <td class="text-end text-nowrap"><?php echo number_format($data['total_qty_act']); ?></td>
                                                </tr>
                                                <?php $no++ ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div><!-- End Pills Tabs -->     
                    </div>

                </div>
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