<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        if(isset($_POST["data_id"])){
            $finance_id = $_POST["data_id"];
        }
    ?>
    <div class="table-responsive">
        <table class="table table-responsive table-striped" id="table2">
            <thead>
                <tr class="text-white" style="background-color: navy;">
                    <td class="text-center p-3 text-nowrap">No</td>
                    <td class="text-center p-3 text-nowrap">Tgl. Pembayaran</td>
                    <td class="text-center p-3 text-nowrap">Nominal Bayar</td>
                    <td class="text-center p-3 text-nowrap">Metode Bayar</td>
                    <td class="text-center p-3 text-nowrap">Keterangan</td>
                    <td class="text-center p-3 text-nowrap">Bank</td>
                    <td class="text-center p-3 text-nowrap">No. Rekening</td>
                    <td class="text-center p-3 text-nowrap">Atas Nama</td>
                    <td class="text-center p-3 text-nowrap">Aksi</td>
                </tr>
            </thead>
            <tbody>
                <?php  
                    include "koneksi.php";
                    $no = 1;
                    $sql_history = "SELECT 
                                    byr.id_bayar,
                                    byr.id_bank_pt AS byr_bank, 
                                    byr.id_tagihan, 
                                    byr.id_finance, 
                                    byr.id_bukti, 
                                    byr.metode_pembayaran, 
                                    byr.total_bayar, 
                                    byr.tgl_bayar,
                                    byr.keterangan_bayar,
                                    byr.created_date,

                                    bnk.nama_bank,
                                    pt.id_bank,
                                    pt.no_rekening,
                                    pt.atas_nama,

                                    fnc.id_inv
                                    FROM finance_bayar AS byr
                                    LEFT JOIN bank_pt pt ON (byr.id_bank_pt = pt.id_bank_pt)
                                    LEFT JOIN bank bnk ON (pt.id_bank = bnk.id_bank)
                                    LEFT JOIN finance fnc ON (byr.id_finance = fnc.id_finance)
                                    WHERE byr.id_finance = '$finance_id' ORDER BY byr.created_date ASC";
                    $query_history = mysqli_query($connect, $sql_history);
                    while($data_history = mysqli_fetch_array($query_history)){
                        $no_rek = $data_history['no_rekening'];
                        $atas_nama = $data_history['atas_nama'];
                        $id_bayar = $data_history['id_bayar'];
                      
                ?>
                <tr>
                    <td class="text-center text-nowrap"><?php echo $no; ?></td>
                    <td class="text-center text-nowrap"><?php echo $data_history['tgl_bayar'] ?></td>
                    <td class="text-end text-nowrap"><?php echo number_format($data_history['total_bayar'],0,'.','.') ?></td>
                    <td class="text-center text-nowrap"><?php echo $data_history['metode_pembayaran'] ?></td>
                    <td class="text-center text-nowrap"><?php echo $data_history['keterangan_bayar'] ?></td>
                    <td class="text-center text-nowrap">
                        <?php 
                            if($data_history['byr_bank'] == ''){
                                echo '-';
                            } else {
                                echo $data_history['nama_bank'];
                            }
                        
                        ?>
                    </td>
                    <td class="text-center text-nowrap">
                        <?php 
                            if($data_history['byr_bank'] == ''){
                                echo '-';
                            } else {
                                echo $no_rek;
                            }
                        ?>
                    </td>
                    <td class="text-center text-nowrap">
                        <?php 
                            if($data_history['byr_bank'] == ''){
                                echo '-';
                            } else {
                                echo $atas_nama;
                            }
                        ?>
                    </td>
                    <td class="text-center text-nowrap">
                        <?php 
                            if($data_history['byr_bank'] == ''){
                                echo '<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" disabled>Lihat Gambar</button>';
                            } else {
                                echo '<button type="button" class="btn btn-primary btn-sm view_bukti" data-bs-toggle="modal" data-bs-target="#bukti" data-id="' . $id_bayar . '">Lihat Gambar</button>';
                            }
                        ?>
                    </td>
                </tr>
                <?php $no++ ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function(){
            $('.view_bukti').click(function(){
                var data_id = $(this).data("id")
                $.ajax({
                    url: "convert-json-modal-bukti.php",
                    method: "POST",
                    data: {data_id: data_id},
                    success: function(data){
                        $("#detail_bukti").html(data)
                        $("#bukti").modal('show')
                    }
                })
            })
        })
    </script>
</body>
</html>