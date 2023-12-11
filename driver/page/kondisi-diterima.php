<script>
    const jenisPengiriman = <?php echo json_encode($jenis_pengiriman); ?>;
    const jenisPenerima = document.getElementById('jenis-penerima');
    const customer = document.getElementById('cs');
    const ekspedisi = document.getElementById('eks');
    const jenisOngkir = document.getElementById('jenis_ongkir');
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
        } else if (this.value === 'Ekspedisi') {
            customer.style.display = 'none'; // Menampilkan Form Input
            ekspedisi.style.display = 'block'; // Menampilkan Form Input
            dropdown_input.setAttribute('required', 'true');
            resi.setAttribute('required', 'true');
            jenisOngkir.setAttribute('required', 'true');
            ongkir.setAttribute('readonly', 'true');
            ongkir.style.backgroundColor = '#f3f3f3';
            penerima.removeAttribute('required');
        } else if (this.value === '') {
            customer.style.display = 'none'; // Menampilkan Form Input
            ekspedisi.style.display = 'none'; // Menampilkan Form Input
            penerima.removeAttribute('required');
            kondisi.removeAttribute('required');
        }
    });

    jenisOngkir.addEventListener('change', function () {
        if (this.value === '1') {
            ongkir.setAttribute('readonly', 'true');
            ongkir.style.backgroundColor = '#f3f3f3';
            ongkir.value = '';
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