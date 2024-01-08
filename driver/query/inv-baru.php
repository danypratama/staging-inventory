<?php 
    include '../koneksi.php';
    $sql = "SELECT
    sk.id_inv,
    sk.jenis_inv,
    sk.dikirim_driver,
    sk.jenis_pengiriman,
    sk.jenis_penerima,
    -- spk nonppn
    spk_nonppn.tgl_pesanan AS spk_tgl_pesanan_nonppn,
    -- spk ppn
    spk_ppn.tgl_pesanan AS spk_tgl_pesanan_ppn,
    -- spk bum 
    spk_bum.tgl_pesanan AS spk_tgl_pesanan_bum,
    -- nonppn
    nonppn.id_inv_nonppn AS id_inv_nonppn,
    nonppn.no_inv AS no_inv_nonppn,
    nonppn.cs_inv AS cs_inv_nonppn,
    nonppn.status_transaksi AS status_trx_nonppn,
    nonppn.created_date AS created_date_nonppn,
    -- ppn
    ppn.id_inv_ppn AS id_inv_ppn,
    ppn.no_inv AS no_inv_ppn,
    ppn.cs_inv AS cs_inv_ppn,
    ppn.status_transaksi AS status_trx_ppn,
    ppn.created_date AS created_date_ppn,
    -- bum
    bum.id_inv_bum AS id_inv_bum,
    bum.no_inv AS no_inv_bum,
    bum.cs_inv AS cs_inv_bum,
    bum.status_transaksi AS status_trx_bum,
    bum.created_date AS created_date_bum,
    -- Customer
    cs_spk_nonppn.alamat AS alamat_nonppn,
    cs_spk_ppn.alamat AS alamat_ppn,
    cs_spk_bum.alamat AS alamat_bum
    FROM status_kirim AS sk
    LEFT JOIN inv_nonppn nonppn ON (sk.id_inv = nonppn.id_inv_nonppn)
    LEFT JOIN inv_ppn ppn ON (sk.id_inv = ppn.id_inv_ppn)
    LEFT JOIN inv_bum bum ON (sk.id_inv = bum.id_inv_bum)
    LEFT JOIN spk_reg spk_nonppn ON (nonppn.id_inv_nonppn = spk_nonppn.id_inv)
    LEFT JOIN spk_reg spk_ppn ON (ppn.id_inv_ppn = spk_ppn.id_inv)
    LEFT JOIN spk_reg spk_bum ON (bum.id_inv_bum = spk_bum.id_inv)
    LEFT JOIN tb_customer cs_spk_nonppn ON (spk_nonppn.id_customer = cs_spk_nonppn.id_cs)
    LEFT JOIN tb_customer cs_spk_ppn ON (spk_ppn.id_customer = cs_spk_ppn.id_cs)
    LEFT JOIN tb_customer cs_spk_bum ON (spk_bum.id_customer = cs_spk_bum.id_cs)
    WHERE
    sk.dikirim_driver = '$id_user'
    AND (nonppn.status_transaksi = 'Dikirim' OR ppn.status_transaksi = 'Dikirim' OR bum.status_transaksi = 'Dikirim')
    GROUP BY no_inv_nonppn, no_inv_ppn, no_inv_bum";

?>