<?php
$page = 'data';
$page2 = 'data-produk';
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
    <link rel="stylesheet" href="assets/css/style-cetak-qr.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit&family=Lato&display=swap" rel="stylesheet">
    <!-- <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>
    <style>
        body{
            font-family: 'Arial', sans-serif;
        }
        .vertical-text {
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            font-size: 30px;
            
        }

        .img-thumbnail {
            border: none;
        }
        #content {
            margin: 0;
            padding: 0;
            background-color: white; /* Atur latar belakang elemen menjadi putih */
            border: 4px solid #A9A9A9;
        }
        #content2 {
            margin: 0;
            padding: 0;
            background-color: white; /* Atur latar belakang elemen menjadi putih */
            border: 4px solid #A9A9A9;
        }
    </style>
</head>

<body>
    <div style=" max-width: 21cm;">
        <?php  
        include "koneksi.php";
        $id = base64_decode($_GET['id']);
        $sql = "SELECT pr.nama_produk, qr.id_produk_qr, qr.qr_img, kp.no_izin_edar,  mr.nama_merk
                FROM tb_produk_reguler AS pr
                JOIN qr_link qr ON (pr.id_produk_reg = qr.id_produk_qr)
                JOIN tb_kat_produk kp ON (pr.id_kat_produk = kp.id_kat_produk)
                JOIN tb_merk mr ON (pr.id_merk = mr.id_merk)
                WHERE pr.id_produk_reg = '$id'";
        $query = mysqli_query($connect, $sql);
        $data = mysqli_fetch_array($query);
        $img = $data['qr_img'];
        $no_img = $data["qr_img"] == "" ? "gambar/QRcode/no-image.png" : "gambar/QRcode/$img";
        ?>
        <div id="content">
            <div class="row">
                <div class="col-1 vertical-text text-center">
                    <?php echo $data['nama_merk']; ?>
                </div>
                <div class="col-8">
                    <div class="row p-1">
                        <div class="col-9" style="font-size: 18px;">AKL : <?php echo $data['no_izin_edar'] ?></div>
                        <div class="col-3" style="font-size: 18px;">QTY :  </div>
                    </div>        
                    <p class="p-2" style="font-weight: bold; font-size: 26px;"><?php echo $data['nama_produk']; ?></p>
                </div>
                <div class="col-3">
                    <img src="gambar/QRcode/<?php echo $img ?>" style="width:175px; height:175px" >
                </div>
            </div>
        </div>
        <br>
        <div class="text-center">
            <button onclick="convertToImage()" class="btn btn-primary">Download</button>
        </div>
        <script>
            function convertToImage() {
                var contentElement = document.getElementById("content");

                domtoimage.toPng(contentElement)
                    .then(function (dataUrl) {
                        var link = document.createElement("a");
                        link.href = dataUrl;
                        link.download = "<?php echo $data['nama_produk']; ?>.png";
                        link.click();
                    })
                    .catch(function (error) {
                        console.error('Error:', error);
                    });
            }
        </script>
    </div>
    <br>
    <div style=" max-width: 21cm;">
        <div id="content2">
            <div class="row">
                <div class="col-1 vertical-text text-center">
                    <?php echo $data['nama_merk']; ?>
                </div>
                <div class="col-8">
                    <div class="row p-1">
                        <div class="col-9" style="font-size: 18px;">AKL : <?php echo $data['no_izin_edar'] ?></div>
                    </div>        
                    <p class="p-2" style="font-weight: bold; font-size: 26px;"><?php echo $data['nama_produk']; ?></p>
                </div>
                <div class="col-3">
                    <img src="gambar/QRcode/<?php echo $img ?>" style="width:175px; height:175px" >
                </div>
            </div>
        </div>
        <br>
        <div class="text-center">
            <button onclick="convertToImage2()" class="btn btn-primary">Download</button>
        </div>
        <script>
            function convertToImage2() {
                var contentElement = document.getElementById("content2");

                domtoimage.toPng(contentElement)
                    .then(function (dataUrl) {
                        var link = document.createElement("a");
                        link.href = dataUrl;
                        link.download = "<?php echo $data['nama_produk']; ?>.png";
                        link.click();
                    })
                    .catch(function (error) {
                        console.error('Error:', error);
                    });
            }
        </script>
    </div>
  
  <?php include "page/script.php" ?>
</body>

</html>
