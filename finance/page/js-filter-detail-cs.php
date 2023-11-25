 <script>
  document.addEventListener('DOMContentLoaded', function () {
    const filterJenisInv = document.getElementById('filterJenisInv');
    const dataTable = document.getElementById('table1');

    filterJenisInv.addEventListener('change', applyFilters);

    function applyFilters() {
        const selectedValue = filterJenisInv.value;
        const rows = dataTable.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const cell = row.cells[4]; // Pastikan indeks 10 sesuai dengan kolom nomor tagihan
            const cellValue = cell.textContent.trim();

            let showRow = false;

            if (selectedValue === 'all') {
                showRow = true;
            } else if (selectedValue === 'non' && cellValue === 'Non PPN') {
                showRow = true;
            } else if (selectedValue === 'ppn' && cellValue === 'PPN') {
                showRow = true;
            } else if (selectedValue === 'bum' && cellValue === 'BUM') {
                showRow = true;
            }

            row.style.display = showRow ? '' : 'none';
        }
    }
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const filterStatusTrx = document.getElementById('filterStatusTrx');
    const dataTable = document.getElementById('table1');

    filterStatusTrx.addEventListener('change', applyFilters);

    function applyFilters() {
        const selectedValue = filterStatusTrx.value;
        const rows = dataTable.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const cell = row.cells[6]; // Pastikan indeks 10 sesuai dengan kolom nomor tagihan
            const cellValue = cell.textContent.trim();

            let showRow = false;

            if (selectedValue === 'all') {
                showRow = true;
            } else if (selectedValue === 'Selesai' && cellValue === 'Transaksi Selesai') {
                showRow = true;
            } else if (selectedValue === 'Dikirim' && cellValue === 'Dikirim') {
                showRow = true;
            } else if (selectedValue === 'Diterima' && cellValue === 'Diterima') {
                showRow = true;
            }

            row.style.display = showRow ? '' : 'none';
        }
    }
  });
</script>

<script>
  function filterStatusBayar() {
    const filterSelect = document.getElementById("filterSelect");
    const filterValue = filterSelect.value.toLowerCase().trim();

    const rows = document.querySelectorAll("#table1 tbody tr");
    let dataFound = false; // Gunakan variabel untuk mengecek apakah data sesuai dengan filter ditemukan

    for (const row of rows) {
      const statusPembayaranCell = row.getElementsByTagName("td")[7];
      if (statusPembayaranCell) {
        const statusPembayaran = statusPembayaranCell.innerText.toLowerCase().trim();

        if (filterValue === "all" || statusPembayaran === filterValue) {
          row.style.display = "table-row";
          dataFound = true; // Set dataFound menjadi true jika ada data yang sesuai dengan filter
        } else {
          row.style.display = "none";
        }
      }
    }

    // Tampilkan pesan "Data Tidak Ditemukan" jika tidak ada data yang sesuai dengan filter
    const messageRow = document.getElementById("messageRow");
    if (!dataFound) {
      messageRow.style.display = "table-row";
    } else {
      messageRow.style.display = "none";
    }
  }

  // Panggil fungsi filterStatusBayar() saat halaman dimuat dan atur opsi select ke "all" secara default.
  filterStatusBayar();
  document.getElementById("filterSelect").value = "all";

  // Tambahkan event listener untuk elemen select
  document.getElementById("filterSelect").addEventListener("change", filterStatusBayar);
</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const filterStatusLunas = document.getElementById('filterStatusLunas');
    const dataTable = document.getElementById('table1');

    filterStatusLunas.addEventListener('change', applyFilters);

    function applyFilters() {
        const selectedValue = filterStatusLunas.value;
        const rows = dataTable.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const cell = row.cells[9]; // Pastikan indeks 10 sesuai dengan kolom nomor tagihan
            const cellValue = cell.textContent.trim();

            let showRow = false;

            if (selectedValue === 'all') {
                showRow = true;
            } else if (selectedValue === 'Belum Lunas' && cellValue === 'Belum Lunas') {
                showRow = true;
            } else if (selectedValue === 'Lunas' && cellValue === 'Lunas') {
                showRow = true;
            }

            row.style.display = showRow ? '' : 'none';
        }
    }
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const filterSelectTagihan = document.getElementById('filterSelectTagihan');
    const dataTable = document.getElementById('table1');

    filterSelectTagihan.addEventListener('change', applyFilters);

    function applyFilters() {
        const selectedValue = filterSelectTagihan.value;
        const rows = dataTable.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const cell = row.cells[11]; // Pastikan indeks 10 sesuai dengan kolom nomor tagihan
            const cellValue = cell.textContent.trim();

            let showRow = false;

            if (selectedValue === 'all') {
                showRow = true;
            } else if (selectedValue === 'Belum' && cellValue === 'Belum Dibuat') {
                showRow = true;
            } else if (selectedValue === 'Sudah' && cellValue !== 'Belum Dibuat') {
                showRow = true;
            }

            row.style.display = showRow ? '' : 'none';
        }
    }
  });
</script>

<script>
  function submitForm(action) {
      document.getElementById("invoiceForm").action = action;
      document.getElementById("invoiceForm").submit();
  }
</script>

<script>
  // Mendapatkan URL dari halaman web saat ini
  const url = new URL(window.location.href);
  console.log(url);
</script>