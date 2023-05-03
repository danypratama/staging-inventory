<?php
    if(!isset($_SESSION))
    {
        session_start();
    }

    //jika sesi ($_SESSION) tidak ada atau kosong
    if (empty($_SESSION['tiket_user'])) {
        //redirect ke halaman login.php
        header("location: login.php");
    }
?>