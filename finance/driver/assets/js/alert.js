var notifikasi = $('.info-data').data('infodata');

if(notifikasi == "Disimpan" || notifikasi=="Dihapus" || notifikasi == "Diupdate" || notifikasi == "Dicancel"){
	Swal.fire({
	  icon: 'success',
	  title: 'Sukses',
	  text: 'Data Berhasil '+notifikasi,
	})
}else if(notifikasi == "Data Gagal Disimpan" || notifikasi == "Data Gagal Dihapus" || notifikasi == "Data Gagal Diupdate" || notifikasi == "Kode Barang Sudah Ada" || notifikasi == "Nama customer sudah ada" || notifikasi == "Nama supplier sudah ada" || notifikasi == "Nama kategori sudah ada" || notifikasi == "No faktur sudah ada" || notifikasi == "Nama user sudah di gunakan" || notifikasi == "Nama role sudah ada" || notifikasi == "Data sudah ada" || notifikasi == "Nama merk sudah ada" || notifikasi == "Merk Tidak Boleh Sama"){
	Swal.fire({
	  icon: 'error',
	  title: 'GAGAL',
	  text: '' +notifikasi,
	})
}else if(notifikasi == "Data Belum Dipilih"){
 Swal.fire({
	  icon: 'info',
	  title: 'Gagal',
	  text: '' +notifikasi,
	})
}else if(notifikasi == "Tidak Ada Perubahan Data" || notifikasi == "No Izin Edar Berhasil Diubah"){
	Swal.fire({
		icon: 'success',
		title: 'Sukses',
		text: '' +notifikasi,
	  })
}else if(notifikasi == "Silahkan Ulangi Kembali"){
	Swal.fire({
		imageUrl: 'img/error-icon.png',
		imageWidth: 100,
		imageHeight: 80,
		imageAlt: 'Custom image',
		 title: 'Terjadi Kesalahan Pada Server',
		 text: '' +notifikasi,
	   })
}


$('.delete-data').on('click', function(e){
	e.preventDefault();
	var getLink = $(this).attr('href');

	Swal.fire({
	  title: 'Anda yakin?',
	  text: "Data akan dihapus permanen",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Hapus'
	}).then((result) => {
	  if (result.value) {
	    window.location.href = getLink;
	  }
	})
});

// $('.cancel-data').on('click', function(e){
// 	e.preventDefault();
// 	var getLink = $(this).attr('href');

// 	Swal.fire({
// 	  title: 'Anda Yakin Cancel Transaksi Ini ?',
// 	  text: "Transaksi Ini Akan Dicancel Permanen",
// 	  icon: 'warning',
// 	  showCancelButton: true,
// 	  confirmButtonColor: '#3085d6',
// 	  cancelButtonColor: '#d33',
// 	  confirmButtonText: 'Ya, Cancel Transaksi'
// 	}).then((result) => {
// 	  if (result.value) {
// 	    window.location.href = getLink;
// 	  }
// 	})
// });

$('.cancel-data').on('click', function(e) {
    e.preventDefault();
    var form = $(this).closest('form');
    var getAction = form.attr('action');
    var cancelValue = form.find('input[name="id_spk"]').val();

    Swal.fire({
        title: 'Anda Yakin Cancel Transaksi Ini ?',
        text: "Transaksi Ini Akan Dicancel Permanen",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Cancel Transaksi'
    }).then((result) => {
        if (result.value) {
            form.attr('action', getAction);
            form.submit();
        }
    });
});

