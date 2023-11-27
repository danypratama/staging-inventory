<script>
    // Mengambil referensi ke textarea
    var textarea = document.getElementById('catatan');

    // Mengambil referensi ke elemen yang akan menampilkan jumlah karakter
    var hitungKarakter = document.getElementById('hitungKarakter');

    // Menambahkan event listener untuk menghitung karakter saat textarea berubah
    textarea.addEventListener('input', function() {
        // Mengambil teks dari textarea
        var teks = textarea.value;

        // Menghitung jumlah karakter
        var jumlahKarakter = teks.length;

        // Memeriksa apakah jumlah karakter melebihi batas maksimum (150)
        if (jumlahKarakter > 150) {
            // Jika melebihi, potong teks menjadi 150 karakter
            teks = teks.substring(0, 150);
            textarea.value = teks; // Set ulang nilai textarea
            jumlahKarakter = 150; // Set ulang jumlah karakter
        }

        // Memperbarui teks pada elemen yang menampilkan jumlah karakter
        hitungKarakter.textContent = jumlahKarakter;
    });
</script>
<script>
    const jenisPengiriman = <?php echo json_encode($jenis_pengiriman); ?>;
    const jenisPenerima = document.getElementById('jenis-penerima');
    const customer = document.getElementById('cs');
    const ekspedisi = document.getElementById('eks');
    const sesuai = document.getElementById('sesuai');
    const tidakSesuai = document.getElementById('tidak_sesuai');
    const tidakSesuaiForm = document.getElementById('tidak_sesuai_form');
    const penerima = document.getElementById('penerima');
    const kat_komplain = document.getElementById('kat_komplain');
    const retur_ya = document.getElementById('retur_ya');
    const retur_tidak = document.getElementById('retur_tidak');
    const refundDana = document.getElementById('refundDana');
    const refund_ya = document.getElementById('refund_ya');
    const refund_tidak = document.getElementById('refund_tidak');
    const jenisOngkir = document.getElementById('jenis_ongkir');
    const kondisi_pesanan0 = document.getElementById('kondisi_pesanan0');
    const kondisi_pesanan1 = document.getElementById('kondisi_pesanan1');
    const kondisi_pesanan2 = document.getElementById('kondisi_pesanan2');
    const kondisi_pesanan3 = document.getElementById('kondisi_pesanan3');
    const kondisi_pesanan4 = document.getElementById('kondisi_pesanan4');
    const kondisi_pesanan5 = document.getElementById('kondisi_pesanan5');
    const dropdown_input = document.getElementById('dropdown-input');
    const resi = document.getElementById('resi');
    const ongkir = document.getElementById('ongkir');
    //Membuat event listener saat select data
    jenisPenerima.addEventListener('change', function () {
        if (this.value === 'Customer') {
            customer.style.display = 'block'; // Menampilkan Form Input
            ekspedisi.style.display = 'none'; // Menampilkan Form Input
            resi.removeAttribute('required');
            ongkir.removeAttribute('required');
            dropdown_input.removeAttribute('required');
            kat_komplain.removeAttribute('required');
            retur_ya.removeAttribute('required');
            retur_tidak.removeAttribute('required');
            refund_ya.removeAttribute('required');
            refund_tidak.removeAttribute('required');
            kondisi_pesanan0.removeAttribute('required');
            kondisi_pesanan1.removeAttribute('required');
            kondisi_pesanan2.removeAttribute('required');
            kondisi_pesanan3.removeAttribute('required');
            kondisi_pesanan4.removeAttribute('required');
            kondisi_pesanan5.removeAttribute('required');
        } else if (this.value === 'Ekspedisi') {
            customer.style.display = 'none'; // Menampilkan Form Input
            ekspedisi.style.display = 'block'; // Menampilkan Form Input
            ongkir.setAttribute('readonly', 'true');
            ongkir.style.backgroundColor = '#f3f3f3';
            penerima.removeAttribute('required');
            sesuai.removeAttribute('required');
            tidakSesuai.removeAttribute('required');
            kat_komplain.removeAttribute('required');
            retur_ya.removeAttribute('required');
            retur_tidak.removeAttribute('required');
            refund_ya.removeAttribute('required');
            refund_tidak.removeAttribute('required');
            kondisi_pesanan0.removeAttribute('required');
            kondisi_pesanan1.removeAttribute('required');
            kondisi_pesanan2.removeAttribute('required');
            kondisi_pesanan3.removeAttribute('required');
            kondisi_pesanan4.removeAttribute('required');
            kondisi_pesanan5.removeAttribute('required');
        } else if (this.value === '') {
            customer.style.display = 'none'; // Menampilkan Form Input
            ekspedisi.style.display = 'none'; // Menampilkan Form Input
            penerima.removeAttribute('required');
            kondisi.removeAttribute('required');
        }
    });

        // Tambahkan event listener untuk menangani perubahan pada radio button "Cash"
        sesuai.addEventListener('change', function() {
        if (sesuai.checked) {
            tidakSesuaiForm.style.display = 'none'; // Menampilkan Form Input
        }
    });

    // Tambahkan event listener untuk menangani perubahan pada radio button "Transfer"
    tidakSesuai.addEventListener('change', function() {
        if (tidakSesuai.checked) {
            tidakSesuaiForm.style.display = 'block'; // Menampilkan Form Input
            kat_komplain.setAttribute('required', 'true');
            retur_ya.setAttribute('required', 'true');
            retur_tidak.setAttribute('required', 'true');
            kondisi_pesanan0.setAttribute('required', 'true');
            kondisi_pesanan1.setAttribute('required', 'true');
            kondisi_pesanan2.setAttribute('required', 'true');
            kondisi_pesanan3.setAttribute('required', 'true');
            kondisi_pesanan4.setAttribute('required', 'true');
            kondisi_pesanan5.setAttribute('required', 'true');
            
        }
    });

    // Tambahkan event listener untuk menangani perubahan pada radio button "Transfer"
    retur_ya.addEventListener('change', function() {
        if (retur_ya.checked) {
            refundDana.style.display = 'block'; // Menampilkan Form Input
            refund_ya.setAttribute('required', 'true');
            refund_tidak.setAttribute('required', 'true');
        }
    });

    retur_tidak.addEventListener('change', function() {
        if (retur_tidak.checked) {
            refundDana.style.display = 'none'; // Menampilkan Form Input
            refund_ya.removeAttribute('required');
            refund_tidak.removeAttribute('required');
        }
    });

    jenisOngkir.addEventListener('change', function () {
        if (this.value === '0') {
            ongkir.setAttribute('readonly', 'true');
            ongkir.style.backgroundColor = '#f3f3f3';
        } else {
            ongkir.style.backgroundColor = '';
            ongkir.removeAttribute('readonly');
            ongkir.setAttribute('required', 'true');
        }
    });

    const cancelDriver = document.getElementById('cancelDriver');
    if (cancelDriver) {
        cancelDriver.addEventListener('click', function () {
            sesuai.checked = false;
            tidakSesuai.checked = false;
            jenisPenerima.value = '';
            penerima.value = '';
            customer.style.display = 'none'; 
            ekspedisi.style.display = 'none';
            refundDana.style.display = 'none';
            file1.value = ''; // Mengatur ulang nilai menjadi kosong
            file2.value = ''; // Mengatur ulang nilai menjadi kosong
            file3.value = ''; // Mengatur ulang nilai menjadi kosong
            imagePreview.innerHTML = ''; // Menghapus konten di dalam elemen "imagePreview"
            imagePreview2.innerHTML = ''; // Menghapus konten di dalam elemen "imagePreview2"
            imagePreview3.innerHTML = ''; // Menghapus konten di dalam elemen "imagePreview3"
        });
    }


    
    function formatNumber(input) {
        // Menghapus semua karakter selain angka dan titik desimal
        let formattedValue = input.value.replace(/[^\d.]/g, '');

        // Memisahkan angka ribuan dengan titik
        formattedValue = formattedValue.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

        // Mengatur nilai input dengan angka yang diformat
        input.value = formattedValue;
    }
</script>