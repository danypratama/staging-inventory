<?php  
    include '../koneksi.php';
    $sql_rev = "SELECT 
        max(ir.no_inv_revisi) AS no_inv_rev,
        ik.id_inv,
        ik.id_komplain,
        sk.dikirim_driver,
        sk.jenis_pengiriman,
        sk.jenis_penerima,
        -- spk nonppn
        spk_nonppn.tgl_pesanan AS spk_tgl_pesanan_nonppn,
        -- spk ppn
        spk_ppn.tgl_pesanan AS spk_tgl_pesanan_ppn,
        -- spk bum 
        spk_bum.tgl_pesanan AS spk_tgl_pesanan_bum,
        COALESCE(nonppn.id_inv_nonppn, ppn.id_inv_ppn, bum.id_inv_bum) AS id_inv,
        COALESCE(nonppn.created_date, ppn.created_date, bum.created_date) AS created_date,

        nonppn.no_inv AS no_inv_nonppn,
        nonppn.cs_inv AS cs_inv_nonppn,
        nonppn.status_transaksi AS status_trx_nonppn,
        -- ppn
        ppn.no_inv AS no_inv_ppn,
        ppn.cs_inv AS cs_inv_ppn,
        ppn.status_transaksi AS status_trx_ppn,
        -- bum
        bum.no_inv AS no_inv_bum,
        bum.cs_inv AS cs_inv_bum,
        bum.status_transaksi AS status_trx_bum,
        -- Customer
        cs_spk_nonppn.alamat AS alamat_nonppn,
        cs_spk_ppn.alamat AS alamat_ppn,
        cs_spk_bum.alamat AS alamat_bum
    FROM revisi_status_kirim AS sk
    LEFT JOIN inv_komplain ik ON (ik.id_komplain = sk.id_komplain)
    LEFT JOIN inv_revisi ir ON (ir.id_inv = ik.id_inv)
    LEFT JOIN inv_nonppn nonppn ON (ik.id_inv = nonppn.id_inv_nonppn)
    LEFT JOIN inv_ppn ppn ON (ik.id_inv = ppn.id_inv_ppn)
    LEFT JOIN inv_bum bum ON (ik.id_inv = bum.id_inv_bum)
    LEFT JOIN spk_reg spk_nonppn ON (nonppn.id_inv_nonppn = spk_nonppn.id_inv)
    LEFT JOIN spk_reg spk_ppn ON (ppn.id_inv_ppn = spk_ppn.id_inv)
    LEFT JOIN spk_reg spk_bum ON (bum.id_inv_bum = spk_bum.id_inv)
    LEFT JOIN tb_customer cs_spk_nonppn ON (spk_nonppn.id_customer = cs_spk_nonppn.id_cs)
    LEFT JOIN tb_customer cs_spk_ppn ON (spk_ppn.id_customer = cs_spk_ppn.id_cs)
    LEFT JOIN tb_customer cs_spk_bum ON (spk_bum.id_customer = cs_spk_bum.id_cs)
    WHERE sk.dikirim_driver = '$id_user' AND sk.status_kirim = '0' AND jenis_penerima = ''
    GROUP BY no_inv_nonppn, no_inv_ppn, no_inv_bum";


?>