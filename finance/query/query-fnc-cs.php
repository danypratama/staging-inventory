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
$sql = "SELECT
            subq.cs_inv, subq.tgl_inv, subq.id_customer, subq.nama_cs, SUM(subq.total_bayar) AS total_bayar, subq.id_finance,
            MAX(subq.status_transaksi) AS status_transaksi,
            SUM(CASE WHEN subq.status_transaksi = 'Transaksi Selesai' THEN 1 ELSE 0 END) AS total_transaksi_selesai,
            SUM(CASE WHEN subq.status_transaksi <> 'Transaksi Selesai' THEN 1 ELSE 0 END) AS total_transaksi_belum_selesai,
            SUM(CASE WHEN subq.status_transaksi = 'Transaksi Selesai' THEN subq.nominal_inv ELSE 0 END) AS total_nominal_inv_selesai,
            SUM(CASE WHEN subq.status_transaksi <> 'Transaksi Selesai' THEN subq.total_inv ELSE 0 END) AS total_nominal_inv_belum_selesai
            FROM (
            SELECT
                spk.id_inv, spk.id_customer, cs.nama_cs, SUM(fb.total_bayar) AS total_bayar, fb.id_finance,
                COALESCE(nonppn.cs_inv, ppn.cs_inv, bum.cs_inv) AS cs_inv,
                COALESCE(nonppn.tgl_inv, ppn.tgl_inv, bum.tgl_inv) AS tgl_inv,
                COALESCE(nonppn.status_transaksi, ppn.status_transaksi, bum.status_transaksi) AS status_transaksi,
                COALESCE(nonppn.total_inv, ppn.total_inv, bum.total_inv) AS total_inv,
                fnc.total_inv AS nominal_inv
            FROM spk_reg AS spk
            LEFT JOIN inv_nonppn nonppn ON spk.id_inv = nonppn.id_inv_nonppn
            LEFT JOIN inv_ppn ppn ON spk.id_inv = ppn.id_inv_ppn
            LEFT JOIN inv_bum bum ON spk.id_inv = bum.id_inv_bum
            LEFT JOIN tb_customer cs ON spk.id_customer = cs.id_cs
            LEFT JOIN finance fnc ON spk.id_inv = fnc.id_inv
            LEFT JOIN finance_bayar fb ON fnc.id_finance = fb.id_finance
            WHERE $sort_option
            GROUP BY spk.id_inv, spk.id_customer, cs.nama_cs, fb.id_finance, cs_inv, tgl_inv, status_transaksi, nominal_inv
            ) AS subq
            GROUP BY subq.nama_cs ORDER BY subq.nama_cs ASC";

$query = mysqli_query($connect, $sql) or die(mysqli_error($connect));
$query2 = mysqli_query($connect, $sql) or die(mysqli_error($connect));
$total_data = mysqli_num_rows($query);
 
?>