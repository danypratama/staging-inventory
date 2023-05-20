<?php
include "../koneksi.php";

if (isset($_POST['simpan'])) {
    // Generate UUID untuk isi tr set
    $UUID = generate_uuid();
    $month = date('m');
    $year = date('y');
    $id_tr_set_isi = 'TR-SET-MRW-ISI' . $year . $UUID . $month;
    $id_tr_set = $_POST['id_tr_set'];
    $id_set = $_POST['id_set'];
    $id_set_isi = $_POST['id_set_isi'];
    $qty_set = $_POST['qty_set'];
    $id_produk = $_POST['id_produk'];
    $id_user = $_POST['id_user'];
    $created = $_POST['created'];

    $sql_tr_set = "INSERT INTO tr_set_marwa
                    (id_tr_set_marwa, id_set_marwa, qty, id_user, created_date)
                    VALUES
                    ('$id_tr_set', '$id_set', '$qty_set', '$id_user', '$created')";
    $query1 = mysqli_query($connect, $sql_tr_set);

    if ($query1 == true) {
        echo "Sukses";
        $total_data  = count($id_set_isi);
        for ($i = 0; $i < $total_data; $i++) {



            // $sql_tr_set_isi = "INSERT INTO tr_set_marwa_isi
            //         (id_tr_set_marwa, id_set_marwa, qty, id_user, created_date)
            //         VALUES
            //         ('$id_tr_set', '$id_set', '$qty_set', '$id_user', '$created')";
            // $query1 = mysqli_query($connect, $sql_tr_set);
        }
    }
}


// echo $id_set;
//         echo '<br>';
//         echo $id_set_isi[$i];
//         echo '<br>';
//         echo $id_produk[$i];
//         echo '<br>';

function generate_uuid()
{
    return sprintf(
        '%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}
