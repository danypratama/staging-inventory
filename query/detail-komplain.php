<?php  
    include "koneksi.php";

   // query untuk detail
   $sql_detail = "SELECT DISTINCT
                    nonppn.id_inv_nonppn AS id_inv,
                    nonppn.no_inv AS no_inv,
                    nonppn.tgl_inv AS tgl_inv,
                    nonppn.kategori_inv AS kategori_inv,
                    nonppn.cs_inv AS cs_inv,
                    nonppn.ongkir AS ongkir,
                    STR_TO_DATE(ik.tgl_komplain, '%d/%m/%Y') AS tanggal,
                    ik.id_komplain,
                    ik.no_komplain,
                    ik.status_komplain,
                    ik.created_date,
                    spk_nonppn.no_spk AS no_spk,
                    spk_nonppn.no_po AS no_po,
                    spk_nonppn.tgl_pesanan AS tgl_pesanan,
                    cs_nonppn.nama_cs AS nama_cs,
                    cs_nonppn.alamat AS alamat,
                    order_nonppn.order_by AS order_by,
                    sales_nonppn.nama_sales AS nama_sales
                FROM inv_komplain AS ik
                LEFT JOIN inv_nonppn nonppn ON ik.id_inv = nonppn.id_inv_nonppn
                LEFT JOIN spk_reg spk_nonppn ON ik.id_inv = spk_nonppn.id_inv
                LEFT JOIN tb_customer cs_nonppn ON spk_nonppn.id_customer = cs_nonppn.id_cs
                LEFT JOIN tb_orderby order_nonppn ON spk_nonppn.id_orderby = order_nonppn.id_orderby
                LEFT JOIN tb_sales sales_nonppn ON spk_nonppn.id_sales = sales_nonppn.id_sales
                WHERE ik.id_komplain = '$id' ORDER BY ik.created_date DESC LIMIT 1";
    $query_detail = mysqli_query($connect, $sql_detail);
    $data_detail = mysqli_fetch_array($query_detail);
    $query_detail2 = mysqli_query($connect, $sql_detail);
    // Query Driver
    $sql_driver = " SELECT DISTINCT
                        ik.id_komplain,
                        nonppn.id_inv_nonppn AS id_inv,
                        status_kirim_nonppn.jenis_pengiriman AS jenis_pengiriman,
                        status_kirim_nonppn.jenis_penerima AS jenis_penerima,
                        status_kirim_nonppn.no_resi AS no_resi,
                        status_kirim_nonppn.dikirim_oleh AS dikirim_oleh,
                        status_kirim_nonppn.penanggung_jawab AS penanggung_jawab,
                        user_nonppn.nama_user AS nama_driver,
                        ekspedisi_nonppn.nama_ekspedisi AS nama_ekspedisi,
                        penerima.nama_penerima AS nama_penerima,
                        penerima.created_date
                    FROM inv_komplain AS ik
                    LEFT JOIN inv_nonppn nonppn ON ik.id_inv = nonppn.id_inv_nonppn
                    LEFT JOIN status_kirim status_kirim_nonppn ON status_kirim_nonppn.id_inv = nonppn.id_inv_nonppn
                    LEFT JOIN user user_nonppn ON status_kirim_nonppn.dikirim_driver = user_nonppn.id_user
                    LEFT JOIN ekspedisi ekspedisi_nonppn ON status_kirim_nonppn.dikirim_ekspedisi = ekspedisi_nonppn.id_ekspedisi
                    LEFT JOIN inv_penerima_revisi penerima ON ik.id_komplain = penerima.id_komplain
                    WHERE ik.id_komplain = '$id' ORDER BY penerima.created_date DESC LIMIT 1";
    $query_driver = mysqli_query($connect, $sql_driver);
    $data_driver = mysqli_fetch_array($query_driver);


    $sql_driver_rev = " SELECT DISTINCT 
                            sk.id_komplain,
                            sk.jenis_pengiriman,
                            sk.jenis_penerima,
                            sk.no_resi,
                            sk.dikirim_oleh,
                            sk.penanggung_jawab,
                            user.nama_user AS nama_driver,
                            ekspedisi.nama_ekspedisi,
                            penerima.nama_penerima AS nama_penerima,
                            COALESCE(MAX(penerima.created_date), 'Tidak Ada Data') AS created_date
                        FROM 
                            revisi_status_kirim AS sk
                        LEFT JOIN 
                            user user ON sk.dikirim_driver = user.id_user
                        LEFT JOIN 
                            ekspedisi ekspedisi ON sk.dikirim_ekspedisi = ekspedisi.id_ekspedisi
                        LEFT JOIN 
                            inv_penerima_revisi penerima ON sk.id_komplain = penerima.id_komplain
                        WHERE 
                            sk.id_komplain = '$id'
                        GROUP BY
                            sk.id_komplain,
                            sk.jenis_pengiriman,
                            sk.jenis_penerima,
                            sk.no_resi,
                            sk.dikirim_oleh,
                            sk.penanggung_jawab,
                            user.nama_user,
                            ekspedisi.nama_ekspedisi,
                            penerima.nama_penerima
                        ORDER BY 
                            created_date DESC
                        LIMIT 1";
    $query_driver_rev = mysqli_query($connect, $sql_driver_rev);
    $data_driver_rev = mysqli_fetch_array($query_driver_rev);
    $total_driver_rev = mysqli_num_rows($query_driver_rev);

    // Query untuk total inv
    $sql_total = " SELECT DISTINCT
                        ik.id_komplain,
                        nonppn.id_inv_nonppn AS id_inv,
                        nonppn.total_inv AS total_inv
                    FROM inv_komplain AS ik
                    LEFT JOIN inv_nonppn nonppn ON ik.id_inv = nonppn.id_inv_nonppn
                    WHERE ik.id_komplain = '$id'";
    $query_total = mysqli_query($connect, $sql_total);
    $data_total = mysqli_fetch_array($query_total);
    
    // Query Umtuk kondisi komplain
    $sql_kondisi = "SELECT DISTINCT
                        nonppn.id_inv_nonppn AS id_inv,
                        nonppn.no_inv AS no_inv,
                        ik.id_inv,
                        kk.kat_komplain,
                        kk.kondisi_pesanan,
                        kk.created_date
                    FROM inv_komplain AS ik
                    LEFT JOIN komplain_kondisi kk ON ik.id_komplain = kk.id_komplain
                    LEFT JOIN inv_nonppn nonppn ON ik.id_inv = nonppn.id_inv_nonppn
                    WHERE ik.id_komplain = '$id' ORDER BY kk.created_date DESC LIMIT 1";
    $query_kondisi = mysqli_query($connect, $sql_kondisi);
    $data_kondisi = mysqli_fetch_array($query_kondisi);
    
    // Query Untuk Table
    $sql = "SELECT DISTINCT
                nonppn.id_inv_nonppn AS id_inv,
                nonppn.no_inv AS no_inv,
                STR_TO_DATE(ik.tgl_komplain, '%d/%m/%Y') AS tanggal,
                ik.id_komplain,
                spk_nonppn.id_spk_reg AS id_spk,
                spk_nonppn.no_spk AS no_spk,
                tpr_nonppn.id_transaksi AS id_transaksi,
                tpr_nonppn.id_produk AS id_produk,
                tpr_nonppn.nama_produk_spk AS nama_produk_spk,
                tpr_nonppn.harga AS harga,
                tpr_nonppn.qty AS qty,
                tpr_nonppn.disc AS disc,
                mr_produk.nama_merk AS merk
            FROM
                inv_komplain AS ik
            LEFT JOIN
                inv_nonppn nonppn ON ik.id_inv = nonppn.id_inv_nonppn
            LEFT JOIN
                spk_reg spk_nonppn ON ik.id_inv = spk_nonppn.id_inv
            LEFT JOIN
                transaksi_produk_reg tpr_nonppn ON spk_nonppn.id_spk_reg = tpr_nonppn.id_spk
            LEFT JOIN
                tb_produk_reguler pr ON tpr_nonppn.id_produk = pr.id_produk_reg
            LEFT JOIN
                tb_merk mr_produk ON pr.id_merk = mr_produk.id_merk
            WHERE ik.id_komplain = '$id'";
    $query = mysqli_query($connect, $sql);
   
?>