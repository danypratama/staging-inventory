<?php  
    include "koneksi.php";
    // Query Untuk Table
    $sql_tmp = "SELECT DISTINCT
                    COALESCE(nonppn.id_inv_nonppn, ppn.id_inv_ppn, bum.id_inv_bum) AS id_inv,
                    STR_TO_DATE(ik.tgl_komplain, '%d/%m/%Y') AS tanggal,
                    ik.id_inv,
                    ik.id_komplain,
                    kk.kat_komplain,
                    kk.kondisi_pesanan,
                    kk.status_refund,
                    COALESCE(spk_nonppn.id_spk_reg, spk_ppn.id_spk_reg, spk_bum.id_spk_reg) AS id_spk,
                    COALESCE(spk_nonppn.no_spk, spk_ppn.no_spk, spk_bum.no_spk) AS no_spk,
                    COALESCE(tpk.id_tmp, tpk_nonppn.id_tmp, tpk_ppn.id_tmp, tpk_bum.id_tmp) AS id_tmp,
                    COALESCE(tpk.id_inv, tpk_nonppn.id_inv, tpk_ppn.id_inv, tpk_bum.id_inv) AS id_inv_tp,
                    COALESCE(tpk.id_produk, tpk_nonppn.id_produk, tpk_ppn.id_produk, tpk_bum.id_produk) AS id_produk_tp,
                    COALESCE(tpk.nama_produk, tpk_nonppn.nama_produk, tpk_ppn.nama_produk, tpk_bum.nama_produk) AS nama_produk_tp,
                    COALESCE(tpk.harga, tpk_nonppn.harga, tpk_ppn.harga, tpk_bum.harga) AS harga_tp,
                    COALESCE(tpk.qty, tpk_nonppn.qty, tpk_ppn.qty, tpk_bum.qty) AS qty_tp,
                    COALESCE(tpk.disc, tpk_nonppn.disc, tpk_ppn.disc, tpk_bum.disc) AS disc_tp,
                    COALESCE(tpk.total_harga, tpk_nonppn.total_harga, tpk_ppn.total_harga, tpk_bum.total_harga) AS total_harga_tp,
                    COALESCE(mr_produk.nama_merk, mr_set.nama_merk) AS merk,
                    spr.stock
                FROM
                    inv_komplain AS ik
                LEFT JOIN
                    inv_nonppn nonppn ON ik.id_inv = nonppn.id_inv_nonppn
                LEFT JOIN
                    inv_ppn ppn ON ik.id_inv = ppn.id_inv_ppn
                LEFT JOIN
                    inv_bum bum ON ik.id_inv = bum.id_inv_bum
                LEFT JOIN
                    komplain_kondisi kk ON ik.id_komplain = kk.id_komplain
                LEFT JOIN
                    spk_reg spk_nonppn ON ik.id_inv = spk_nonppn.id_inv
                LEFT JOIN
                    spk_reg spk_ppn ON ik.id_inv = spk_ppn.id_inv
                LEFT JOIN
                    spk_reg spk_bum ON ik.id_inv = spk_bum.id_inv
                LEFT JOIN
                    tmp_produk_komplain tpk_nonppn ON spk_nonppn.id_inv = tpk_nonppn.id_inv
                LEFT JOIN
                    tmp_produk_komplain tpk_ppn ON spk_ppn.id_inv = tpk_ppn.id_inv
                LEFT JOIN
                    tmp_produk_komplain tpk_bum ON spk_bum.id_inv = tpk_bum.id_inv
                LEFT JOIN
                    tb_produk_reguler pr ON COALESCE(tpk.id_produk, tpk_nonppn.id_produk, tpk_ppn.id_produk, tpk_bum.id_produk) = pr.id_produk_reg
                LEFT JOIN
                    tb_produk_set_marwa tpsm ON COALESCE(tpk.id_produk, tpk_nonppn.id_produk, tpk_ppn.id_produk, tpk_bum.id_produk) = tpsm.id_set_marwa
                LEFT JOIN
                    tb_merk mr_produk ON pr.id_merk = mr_produk.id_merk
                LEFT JOIN
                    tb_merk mr_set ON tpsm.id_merk = mr_set.id_merk
                LEFT JOIN
                    stock_produk_reguler spr ON COALESCE(tpk.id_produk, tpk_nonppn.id_produk, tpk_ppn.id_produk, tpk_bum.id_produk) = spr.id_produk_reg
                WHERE
                    ik.id_inv = '$id_inv' AND status_tmp = '1' AND status_br_refund = '0'";

    $query_tmp = mysqli_query($connect, $sql_tmp);
    $query_total = mysqli_query($connect, $sql_tmp);

    // Query tampil Produk
    $sql_produk = " SELECT DISTINCT
                        tpk.id_tmp,
                        tpk.id_produk,
                        tpk.nama_produk,
                        tpk.harga,
                        tpk.qty,
                        tpk.disc,
                        tpk.total_harga,
                        COALESCE(spk_nonppn.id_spk_reg, spk_ppn.id_spk_reg, spk_bum.id_spk_reg) AS id_spk,
                        COALESCE(spk_nonppn.no_spk, spk_ppn.no_spk, spk_bum.no_spk) AS no_spk,
                        COALESCE(mr_produk.nama_merk, mr_set.nama_merk) AS merk,
                        spr.stock
                    FROM tmp_produk_komplain AS tpk
                    LEFT JOIN tb_produk_reguler pr ON tpk.id_produk = pr.id_produk_reg
                    LEFT JOIN tb_produk_set_marwa tpsm ON tpk.id_produk = tpsm.id_set_marwa
                    LEFT JOIN tb_merk mr_produk ON pr.id_merk = mr_produk.id_merk -- JOIN untuk produk reguler
                    LEFT JOIN tb_merk mr_set ON tpsm.id_merk = mr_set.id_merk -- JOIN untuk produk set
                    LEFT JOIN stock_produk_reguler spr ON tpk.id_produk = spr.id_produk_reg
                    LEFT JOIN spk_reg spk_nonppn ON tpk.id_inv = spk_nonppn.id_inv
                    LEFT JOIN spk_reg spk_ppn ON tpk.id_inv = spk_ppn.id_inv
                    LEFT JOIN spk_reg spk_bum ON tpk.id_inv = spk_bum.id_inv
                    WHERE tpk.id_inv = '$id_inv' AND status_tmp = '1' AND status_br_refund = '0' ORDER BY tpk.nama_produk ASC";
    $query_produk = mysqli_query($connect, $sql_produk);
    $query_produk_total = mysqli_query($connect, $sql_produk);


    $sql_refund = "SELECT DISTINCT
                    COALESCE(nonppn.id_inv_nonppn, ppn.id_inv_ppn, bum.id_inv_bum) AS id_inv,
                    STR_TO_DATE(ik.tgl_komplain, '%d/%m/%Y') AS tanggal,
                    ik.id_komplain,
                    kk.kat_komplain,
                    kk.kondisi_pesanan,
                    kk.status_refund,
                    COALESCE(spk_nonppn.id_spk_reg, spk_ppn.id_spk_reg, spk_bum.id_spk_reg) AS id_spk,
                    COALESCE(spk_nonppn.no_spk, spk_ppn.no_spk, spk_bum.no_spk) AS no_spk,
                    tpk.id_tmp,
                    tpk.id_produk,
                    tpk.nama_produk,
                    tpk.harga,
                    tpk.qty,
                    tpk.disc,
                    tpk.total_harga,
                    COALESCE(mr_produk.nama_merk, mr_set.nama_merk) AS merk,
                    spr.stock
                FROM inv_komplain AS ik
                LEFT JOIN inv_nonppn nonppn ON ik.id_inv = nonppn.id_inv_nonppn
                LEFT JOIN inv_ppn ppn ON ik.id_inv = ppn.id_inv_ppn
                LEFT JOIN inv_bum bum ON ik.id_inv = bum.id_inv_bum
                LEFT JOIN komplain_kondisi kk ON ik.id_komplain = kk.id_komplain
                LEFT JOIN spk_reg spk_nonppn ON ik.id_inv = spk_nonppn.id_inv
                LEFT JOIN spk_reg spk_ppn ON ik.id_inv = spk_ppn.id_inv
                LEFT JOIN spk_reg spk_bum ON ik.id_inv = spk_bum.id_inv
                LEFT JOIN tmp_produk_komplain tpk ON spk_nonppn.id_inv = tpk.id_inv OR spk_ppn.id_inv = tpk.id_inv OR spk_bum.id_inv = tpk.id_inv
                LEFT JOIN tb_produk_reguler pr ON tpk.id_produk = pr.id_produk_reg
                LEFT JOIN tb_produk_set_marwa tpsm ON tpk.id_produk = tpsm.id_set_marwa
                LEFT JOIN tb_merk mr_produk ON pr.id_merk = mr_produk.id_merk -- JOIN untuk produk reguler
                LEFT JOIN tb_merk mr_set ON tpsm.id_merk = mr_set.id_merk -- JOIN untuk produk set
                LEFT JOIN stock_produk_reguler spr ON tpk.id_produk = spr.id_produk_reg
                WHERE (nonppn.id_inv_nonppn = '$id_inv' OR ppn.id_inv_ppn = '$id_inv' OR bum.id_inv_bum = '$id_inv') AND status_tmp = '1' AND status_br_refund = '1'";
    $query_refund = mysqli_query($connect, $sql_refund);
    $query_total_refund = mysqli_query($connect, $sql_refund);
?>