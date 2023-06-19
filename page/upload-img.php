<!-- kode untuk kompress gambar sebelum upload -->
<!-- Bukti 1 -->


<script>
    function formatBytes(bytes, decimals = 2) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }

    function compressAndPreviewImage(event) {
        var file = event.target.files[0];
        var reader = new FileReader();
        reader.onload = function(e) {
            var img = new Image();
            img.src = e.target.result;
            img.onload = function() {
                var canvas = document.createElement('canvas');
                var ctx = canvas.getContext('2d');
                var maxWidth = 800; // Atur lebar maksimum yang diinginkan di sini
                var maxHeight = 800; // Atur tinggi maksimum yang diinginkan di sini
                var width = img.width;
                var height = img.height;

                console.log("Ukuran awal gambar:", width, "x", height);
                console.log("Ukuran memori awal gambar:", formatBytes(file.size));

                if (width > height) {
                    if (width > maxWidth) {
                        height *= maxWidth / width;
                        width = maxWidth;
                    }
                } else {
                    if (height > maxHeight) {
                        width *= maxHeight / height;
                        height = maxHeight;
                    }
                }

                canvas.width = width;
                canvas.height = height;
                ctx.drawImage(img, 0, 0, width, height);

                var compressedImageData = canvas.toDataURL('image/jpeg', 0.7); // Atur kualitas kompresi di sini (0.7 adalah contoh)
                var compressedFileSize = compressedImageData.length * 0.75; // Asumsikan kompresi menggunakan format base64

                console.log("Ukuran gambar setelah kompresi:", width, "x", height);
                console.log("Ukuran memori gambar setelah kompresi:", formatBytes(compressedFileSize));

                var previewElement = document.createElement('img');
                previewElement.src = compressedImageData;
                previewElement.classList.add('preview-image');

                var imagePreview = document.getElementById('imagePreview');
                imagePreview.innerHTML = '';
                imagePreview.appendChild(previewElement);
            }
        }
        reader.readAsDataURL(file);
    }

    function checkIfFileNameExists(fileName) {
        // Simulasikan pengecekan jika nama file sudah ada sebelumnya
        // Misalnya, Anda dapat menggunakan AJAX untuk memeriksa dengan server
        // Berikut ini hanya contoh sederhana
        var existingFileNames = ['image1.jpg', 'image2.jpg', 'image3.jpg'];

        return existingFileNames.includes(fileName);
    }
</script>

<script>
    function formatBytes2(bytes, decimals = 2) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }

    function compressAndPreviewImage2(event) {
        var file = event.target.files[0];
        var reader = new FileReader();
        reader.onload = function(e) {
            var img = new Image();
            img.src = e.target.result;
            img.onload = function() {
                var canvas = document.createElement('canvas');
                var ctx = canvas.getContext('2d');
                var maxWidth = 800; // Atur lebar maksimum yang diinginkan di sini
                var maxHeight = 800; // Atur tinggi maksimum yang diinginkan di sini
                var width = img.width;
                var height = img.height;

                console.log("Ukuran awal gambar:", width, "x", height);
                console.log("Ukuran memori awal gambar:", formatBytes2(file.size));

                if (width > height) {
                    if (width > maxWidth) {
                        height *= maxWidth / width;
                        width = maxWidth;
                    }
                } else {
                    if (height > maxHeight) {
                        width *= maxHeight / height;
                        height = maxHeight;
                    }
                }

                canvas.width = width;
                canvas.height = height;
                ctx.drawImage(img, 0, 0, width, height);

                var compressedImageData = canvas.toDataURL('image/jpeg', 0.7); // Atur kualitas kompresi di sini (0.7 adalah contoh)
                var compressedFileSize = compressedImageData.length * 0.75; // Asumsikan kompresi menggunakan format base64

                console.log("Ukuran gambar setelah kompresi:", width, "x", height);
                console.log("Ukuran memori gambar setelah kompresi:", formatBytes(compressedFileSize));

                var previewElement = document.createElement('img');
                previewElement.src = compressedImageData;
                previewElement.classList.add('preview-image');

                var imagePreview = document.getElementById('imagePreview2');
                imagePreview.innerHTML = '';
                imagePreview.appendChild(previewElement);
            }
        }
        reader.readAsDataURL(file);
    }

    function checkIfFileNameExists(fileName) {
        // Simulasikan pengecekan jika nama file sudah ada sebelumnya
        // Misalnya, Anda dapat menggunakan AJAX untuk memeriksa dengan server
        // Berikut ini hanya contoh sederhana
        var existingFileNames = ['image1.jpg', 'image2.jpg', 'image3.jpg'];

        return existingFileNames.includes(fileName);
    }
</script>

<script>
    function formatBytes3(bytes, decimals = 2) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }

    function compressAndPreviewImage3(event) {
        var file = event.target.files[0];
        var reader = new FileReader();
        reader.onload = function(e) {
            var img = new Image();
            img.src = e.target.result;
            img.onload = function() {
                var canvas = document.createElement('canvas');
                var ctx = canvas.getContext('2d');
                var maxWidth = 800; // Atur lebar maksimum yang diinginkan di sini
                var maxHeight = 800; // Atur tinggi maksimum yang diinginkan di sini
                var width = img.width;
                var height = img.height;

                console.log("Ukuran awal gambar:", width, "x", height);
                console.log("Ukuran memori awal gambar:", formatBytes3(file.size));

                if (width > height) {
                    if (width > maxWidth) {
                        height *= maxWidth / width;
                        width = maxWidth;
                    }
                } else {
                    if (height > maxHeight) {
                        width *= maxHeight / height;
                        height = maxHeight;
                    }
                }

                canvas.width = width;
                canvas.height = height;
                ctx.drawImage(img, 0, 0, width, height);

                var compressedImageData = canvas.toDataURL('image/jpeg', 0.7); // Atur kualitas kompresi di sini (0.7 adalah contoh)
                var compressedFileSize = compressedImageData.length * 0.75; // Asumsikan kompresi menggunakan format base64

                console.log("Ukuran gambar setelah kompresi:", width, "x", height);
                console.log("Ukuran memori gambar setelah kompresi:", formatBytes(compressedFileSize));

                var previewElement = document.createElement('img');
                previewElement.src = compressedImageData;
                previewElement.classList.add('preview-image');

                var imagePreview = document.getElementById('imagePreview3');
                imagePreview.innerHTML = '';
                imagePreview.appendChild(previewElement);
            }
        }
        reader.readAsDataURL(file);
    }
</script>