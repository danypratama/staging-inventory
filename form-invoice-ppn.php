<!DOCTYPE html>
<html>

<head>
    <title>Form Invoice Non PPN</title>
</head>

<body>
    <h1>Form Invoice Non PPN</h1>

    <form id="invoiceForm" method="POST">
        <?php
        // Mendapatkan data dari form sebelumnya
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['spk_id'])) {
                $selectedSpkIds = $_POST['spk_id'];

                // Lakukan sesuatu dengan data yang dipilih
                // Misalnya, tampilkan daftar ID SPK yang dipilih
                foreach ($selectedSpkIds as $spkId) {
                    echo "ID SPK: $spkId<br>";
                }
            }
        }
        ?>
    </form>
</body>

</html>