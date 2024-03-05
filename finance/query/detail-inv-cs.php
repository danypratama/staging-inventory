<?php  
    $no = 1;
    $sort_option ="";
    $today = date('d/m/Y');
    $startWeek = date('d/m/Y', strtotime("-1 week"));
    $endWeek = date('d/m/Y', strtotime("now"));
    $thisWeekStart= date('d/m/Y',strtotime('last sunday')); 
    $thisWeekEnd= date('d/m/Y',strtotime('next sunday'));
    $thisMonth = date('m');

    // Kode Khusus Untuk Last Mont
    // Dapatkan tanggal saat ini
    $tanggalSaatIni = new DateTime();

    // Set tanggal ke awal bulan
    $tanggalSaatIni->setDate($tanggalSaatIni->format('Y'), $tanggalSaatIni->format('m'), 1);

    // Kurangkan satu bulan dari tanggal saat ini
    $tanggalSaatIni->modify('-1 month');

    // Dapatkan bulan dalam format numerik (dengan angka nol di depan jika berlaku)
    $lastMonth = $tanggalSaatIni->format('m');

    // Tampilkan nilai bulan sebelumnya
    $thisYear = date('Y');
    $lastYear = date("Y",strtotime("-1 year"));
    if(isset($_GET['date_range']))
    {
        if($_GET['date_range'] == "today")
        {
            $sort_option = "DATE(STR_TO_DATE(COALESCE(nonppn.tgl_inv, ppn.tgl_inv, bum.tgl_inv), '%d/%m/%Y')) = CURDATE()";
        }

        elseif($_GET['date_range'] == "weekly")
        {
            $sort_option = "
                            WEEK(STR_TO_DATE(COALESCE(nonppn.tgl_inv, ppn.tgl_inv, bum.tgl_inv), '%d/%m/%Y')) = WEEK(CURDATE())
                            AND YEAR(STR_TO_DATE(COALESCE(nonppn.tgl_inv, ppn.tgl_inv, bum.tgl_inv), '%d/%m/%Y')) = YEAR(CURDATE())
                        ";
        }

        elseif($_GET['date_range'] == "monthly")
        {

            $sort_option = "
                            MONTH(STR_TO_DATE(COALESCE(nonppn.tgl_inv, ppn.tgl_inv, bum.tgl_inv), '%d/%m/%Y')) = MONTH(CURDATE())
                            AND YEAR(STR_TO_DATE(COALESCE(nonppn.tgl_inv, ppn.tgl_inv, bum.tgl_inv), '%d/%m/%Y')) = YEAR(CURDATE())
                        "; 
            
        }

        elseif($_GET['date_range'] == "lastMonth")
        {
            $sort_option = " 
                            MONTH(STR_TO_DATE(COALESCE(nonppn.tgl_inv, ppn.tgl_inv, bum.tgl_inv), '%d/%m/%Y')) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))
                            AND YEAR(STR_TO_DATE(COALESCE(nonppn.tgl_inv, ppn.tgl_inv, bum.tgl_inv), '%d/%m/%Y')) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))
                            ";  
        }

        elseif($_GET['date_range'] == "year")
        {
            $sort_option = "YEAR(STR_TO_DATE(COALESCE(nonppn.tgl_inv, ppn.tgl_inv, bum.tgl_inv), '%d/%m/%Y')) = YEAR(CURDATE())";
        }

        elseif($_GET['date_range'] == "lastyear")
        {
            $sort_option = "YEAR(STR_TO_DATE(COALESCE(nonppn.tgl_inv, ppn.tgl_inv, bum.tgl_inv), '%d/%m/%Y')) = YEAR(CURDATE()) - 1";
        }
    }
    if (isset($_GET["start_date"]) && isset($_GET["end_date"])) {
    $dt1 = $_GET["start_date"];
    $dt2 = $_GET["end_date"];
    $format_dt1 = date('d/m/Y', strtotime($dt1));
    $format_dt2 = date('d/m/Y', strtotime($dt2));
    $sort_option = "STR_TO_DATE(COALESCE(nonppn.tgl_inv, ppn.tgl_inv, bum.tgl_inv), '%d/%m/%Y') BETWEEN STR_TO_DATE('$format_dt1', '%d/%m/%Y') AND STR_TO_DATE('$format_dt2', '%d/%m/%Y')";
    // Lakukan sesuatu dengan $sort_option, misalnya memproses data dari database
    }
    $total_nominal_trx = 0;
    $total_nominal_bayar = 0;
    // $sql = "SELECT DISTINCT
    //             fnc.jenis_inv,
    //             fnc.status_pembayaran,
    //             fnc.status_lunas,
    //             COALESCE(fnc.status_tagihan, 0) AS status_tagihan,
    //             spk.id_customer,  -- Menampilkan kolom id_customer dari tabel spk_reg
    //             cs.nama_cs AS nama_cs,  -- Menampilkan kolom nama_cs dari tabel tb_customer
    //             COALESCE(nonppn.id_inv_nonppn, ppn.id_inv_ppn, bum.id_inv_bum) AS id_inv,
    //             COALESCE(nonppn.no_inv, ppn.no_inv, bum.no_inv) AS no_inv,
    //             COALESCE(nonppn.cs_inv, ppn.cs_inv, bum.cs_inv) AS cs_inv,
    //             COALESCE(nonppn.status_transaksi, ppn.status_transaksi, bum.status_transaksi) AS status_trx,
    //             STR_TO_DATE(COALESCE(nonppn.tgl_inv, ppn.tgl_inv, bum.tgl_inv), '%d/%m/%Y') AS tgl_inv,
    //             COALESCE(nonppn.tgl_tempo, ppn.tgl_tempo, bum.tgl_tempo) AS tgl_tempo,
    //             STR_TO_DATE(COALESCE(nonppn.tgl_tempo, ppn.tgl_tempo, bum.tgl_tempo), '%d/%m/%Y') AS tgl_tempo_convert,
    //             COALESCE(nonppn.total_inv, ppn.total_inv, bum.total_inv) AS total_inv,
    //             ft.no_tagihan,
    //             SUM(fb.total_bayar) AS total_bayar
    //         FROM spk_reg AS spk
    //         LEFT JOIN inv_nonppn nonppn ON (spk.id_inv = nonppn.id_inv_nonppn)
    //         LEFT JOIN inv_ppn ppn ON (spk.id_inv = ppn.id_inv_ppn)
    //         LEFT JOIN inv_bum bum ON (spk.id_inv = bum.id_inv_bum)
    //         LEFT JOIN finance fnc ON (spk.id_inv = fnc.id_inv)
    //         LEFT JOIN finance_tagihan ft ON (fnc.id_tagihan = ft.id_tagihan)
    //         LEFT JOIN finance_bayar fb ON (fnc.id_finance = fb.id_finance)
    //         LEFT JOIN tb_customer cs ON (spk.id_customer = cs.id_cs)
    //         WHERE spk.id_customer = '$id_cs' AND $sort_option GROUP BY COALESCE(nonppn.no_inv, ppn.no_inv, bum.no_inv)";

    $sql =" SELECT
                fnc.jenis_inv,
                fnc.status_pembayaran,
                fnc.status_lunas,
                COALESCE(fnc.status_tagihan, 0) AS status_tagihan,
                spk.id_customer,
                cs.nama_cs AS nama_cs,
                COALESCE(nonppn.id_inv_nonppn, ppn.id_inv_ppn, bum.id_inv_bum) AS id_inv,
                COALESCE(nonppn.no_inv, ppn.no_inv, bum.no_inv) AS no_inv,
                COALESCE(nonppn.cs_inv, ppn.cs_inv, bum.cs_inv) AS cs_inv,
                COALESCE(nonppn.status_transaksi, ppn.status_transaksi, bum.status_transaksi) AS status_trx,
                STR_TO_DATE(COALESCE(nonppn.tgl_inv, ppn.tgl_inv, bum.tgl_inv), '%d/%m/%Y') AS tgl_inv,
                COALESCE(nonppn.tgl_tempo, ppn.tgl_tempo, bum.tgl_tempo) AS tgl_tempo,
                STR_TO_DATE(COALESCE(nonppn.tgl_tempo, ppn.tgl_tempo, bum.tgl_tempo), '%d/%m/%Y') AS tgl_tempo_convert,
                COALESCE(nonppn.total_inv, ppn.total_inv, bum.total_inv) AS total_inv,
                ft.no_tagihan,
                COALESCE(total_bayar, 0) AS total_bayar
            FROM spk_reg AS spk
            LEFT JOIN inv_nonppn nonppn ON (spk.id_inv = nonppn.id_inv_nonppn)
            LEFT JOIN inv_ppn ppn ON (spk.id_inv = ppn.id_inv_ppn)
            LEFT JOIN inv_bum bum ON (spk.id_inv = bum.id_inv_bum)
            LEFT JOIN finance fnc ON (spk.id_inv = fnc.id_inv)
            LEFT JOIN finance_tagihan ft ON (fnc.id_tagihan = ft.id_tagihan)
            LEFT JOIN (
                SELECT id_finance, SUM(total_bayar) AS total_bayar
                FROM finance_bayar
                GROUP BY id_finance
            ) fb ON (fnc.id_finance = fb.id_finance)
            LEFT JOIN tb_customer cs ON (spk.id_customer = cs.id_cs)
            WHERE spk.id_customer = '$id_cs' AND COALESCE(nonppn.status_transaksi, ppn.status_transaksi, bum.status_transaksi) <> 'Cancel Order'
            GROUP BY COALESCE(nonppn.no_inv, ppn.no_inv, bum.no_inv);";
    $query = mysqli_query($connect, $sql);
    $query_nominal = mysqli_query($connect, $sql);
    $total_trx = mysqli_num_rows($query);
?>