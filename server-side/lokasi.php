<?php
// Koneksi ke database
include "../koneksi.php";
        

// Definisikan kolom yang bisa diurutkan
$columns = array(
    0 => 'id_lokasi',
    1 => 'nama_lokasi',
    2 => 'no_lantai',
    3 => 'nama_area',
    4 => 'no_rak'
);  

// Query utama
$sql = "SELECT lp.*, uc.nama_user as user_created, uu.nama_user as user_updated
        FROM tb_lokasi_produk as lp
        LEFT JOIN user uc ON (lp.id_user = uc.id_user)
        LEFT JOIN user uu ON (lp.user_updated = uu.id_user)";

// Proses filtering
if (!empty($_POST['search']['value'])) {
    $searchValue = $_POST['search']['value'];
    $sql .= " WHERE (nama_lokasi LIKE '%$searchValue%' 
                     OR no_lantai LIKE '%$searchValue%' 
                     OR nama_area LIKE '%$searchValue%' 
                     OR no_rak LIKE '%$searchValue%') ";
}

// Urutan
$orderColumn = $columns[$_POST['order'][0]['column']];
$orderDir = $_POST['order'][0]['dir'];
$sql .= " ORDER BY $orderColumn $orderDir ";

// Jumlah total data
$query = mysqli_query($connect, $sql);
$totalData = mysqli_num_rows($query);

// Limit data yang ditampilkan
$start = $_POST['start'];
$length = $_POST['length'];
$sql .= " LIMIT $start, $length ";

$query = mysqli_query($connect, $sql);

$data = array();
$no = $start + 1;

while ($row = mysqli_fetch_array($query)) {
    $id_lokasi = base64_encode($row['id_lokasi']);

    $data[] = array(
        '<div class="text-center text-nowrap">'.$no.'</div>',
        '<div class="text-center text-nowrap">'.$row['nama_lokasi'].'</div>',
        '<div class="text-center text-nowrap">'.$row['no_lantai'].'</div>',
        '<div class="text-center text-nowrap">'.$row['nama_area'].'</div>',
        '<div class="text-center text-nowrap">'.$row['no_rak'].'</div>',
        '<div class="text-center text-nowrap">
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal3" 
                data-user="' . $row['user_created'] . '" data-lokasi="' . $row['nama_lokasi'] . '" 
                data-lantai="' . $row['no_lantai'] . '" data-area="' . $row['nama_area'] . '" 
                data-rak="' . $row['no_rak'] . '" data-created="' . $row['created_date'] . '" 
                data-updated="' . $row['updated_date'] . '" data-userupdated="' . $row['user_updated'] . '" title="Detail Data">
                <i class="bi bi-info-circle"></i>
            </button>
            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal2" 
                data-id="' . $row['id_lokasi'] . '" data-user="' . $row['user_created'] . '" 
                data-lokasi="' . $row['nama_lokasi'] . '" data-lantai="' . $row['no_lantai'] . '" 
                data-area="' . $row['nama_area'] . '" data-rak="' . $row['no_rak'] . '" 
                data-created="' . $row['created_date'] . '" data-updated="' . $row['updated_date'] . '" 
                data-userupdated="' . $row['user_updated'] . '" title="Ubah Data">
                <i class="bi bi-pencil"></i>
            </button>
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusData" data-id="' . $row['id_lokasi'] . '" data-lokasi="' . $row['nama_lokasi'] . ' " data-lantai="' . $row['no_lantai'] . '" data-area="' . $row['nama_area'] . '"  data-rak="' . $row['no_rak'] . '">
                <i class="bi bi-trash"></i>
            </button>
        </div>'
    );
    $no++;
}

$output = array(
    "draw" => intval($_POST['draw']),
    "recordsTotal" => $totalData,
    "recordsFiltered" => $totalData,
    "data" => $data
);

echo json_encode($output);
?>
