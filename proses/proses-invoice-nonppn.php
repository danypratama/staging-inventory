<?php
include "../koneksi.php";

if (isset($_POST['simpan-inv'])) {
    $id_spk = $_POST['id_spk'];
    $id_inv_nonppn = $_POST['id_inv_nonppn'];
    $no_inv_nonppn = $_POST['no_inv_nonppn'];
    $tgl_inv = $_POST['tgl_inv'];
    $cs = $_POST['cs'];
    $cs_inv = $_POST['cs_inv'];
    $jenis_inv = $_POST['jenis_inv'];
    $tgl_tempo = $_POST['tgl_tempo'];
    $sp_disc = $_POST['sp_disc'];
    $note_inv = $_POST['note_inv'];
    $ongkir = $_POST['ongkir'];
    for ($i = 0; $i < count($id_spk); $i++) {
        $id_spk_array = $_POST['id_spk'][$i];
        $sql  = mysqli_query($connect, "UPDATE spk_reg SET id_inv = '$id_inv_nonppn' WHERE id_spk_reg = '$id_spk_array'");
    }

    $sql_inv = mysqli_query($connect, "INSERT INTO inv_nonppn 
                                        (id_inv_nonppn, no_inv, tgl_inv, cs_inv, tgl_tempo, sp_disc, note_inv, kategori_inv, ongkir)
                                        VALUES
                                        ('$id_inv_nonppn', '$no_inv_nonppn', '$tgl_inv', '$cs_inv', '$tgl_tempo', '$sp_disc', '$note_inv', '$jenis_inv', '$ongkir')");
}
