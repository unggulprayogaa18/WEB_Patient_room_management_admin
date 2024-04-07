function submitForm() {
    var formData = $('#kamarForm').serialize();

    $.ajax({
        type: 'POST',
        url: 'config/kamar/api_kamar.php',
        data: formData,
        contentType: 'application/x-www-form-urlencoded',
        success: function (response) {
            if (response.status === 'success') {
                console.log('Koneksi Berhasil:', response.message);
                untukkamar();
                // Tambahkan perbaruan tabel setelah penyimpanan
                updateTabledashboard();
            } else {
                console.error('Koneksi Gagal:', response.message);
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
}


function untukkamar() {
    $('#tableforkamar').empty();
    $.ajax({
        type: 'GET',
        url: 'config/kamar/get_data_kamar.php',
        success: function (response) {
            console.log('Server Response:', response); // Debugging line
            if (response.status === 'success') {
                console.log('Koneksi Berhasil:', response.message);
                updateTabledashboard(response.data_kamar);
            } else {
                console.error('Koneksi Gagal:', response.message);
            }
        },
        error: function (error) {
            console.error('AJAX Error:', error); // Debugging line
        }
    });
}

// Rest of your code remains unchanged

function updateTabledashboard(dataKamar) {
    var rowsPerPage = 10; // Jumlah baris per halaman
    var totalPages = Math.ceil(dataKamar.length / rowsPerPage);
    $('#pagination').twbsPagination({
        totalPages: totalPages,
        visiblePages: totalPages > 10 ? 10 : totalPages,
        onPageClick: function (event, page) {
            displayDataByPageDashboard(page, dataKamar, rowsPerPage);
        }
    });
    displayDataByPageDashboard(1, dataKamar, rowsPerPage);
}

function displayDataByPageDashboard(page, dataKamar, rowsPerPage) {
    $('#tableforkamar').empty();
    var startIndex = (page - 1) * rowsPerPage;
    var endIndex = startIndex + rowsPerPage;
    for (var i = startIndex; i < endIndex && i < dataKamar.length; i++) {
        var kamar = dataKamar[i];
        var row = '<tr>' +
            '<td>' + kamar.id_kamar + '</td>' +
            '<td>' + kamar.nomer_kamar + '</td>' +
            '<td>' + kamar.status_kamar + '</td>' +
            '<td>' +
            '<button class="btn btn-info btn-sm" onclick="editData(' + kamar.id_kamar + ')" id="tombol_edit_' + kamar.id_kamar + '">Edit</button> ' +
            '<button class="btn btn-success btn-sm" onclick="simpanData(' + kamar.id_kamar + ')" id="tombol_simpan_' + kamar.id_kamar + '" style="display: none;">Simpan</button>' +
            '<button class="btn btn-danger btn-sm" onclick="deleteData(' + kamar.id_kamar + ')"  >Delete</button>' +
            '</td>' +
            '</tr>';
        $('#tableforkamar').append(row);
    }
}


function deleteData(id_Kamar) {
    var confirmation = confirm('Apakah Anda yakin ingin menghapus data dengan ID Kamar ' + id_Kamar + '?');

    if (confirmation) {
        $.ajax({
            type: 'POST',
            url: 'config/kamar/delete_kamar.php',
            data: {
                id_kamar: id_Kamar
            },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    console.log('Data berhasil dihapus:', response.message);
                    alert('Data berhasil dihapus!');
                    untukkamar();
                    updateTabledashboard();
                } else {
                    console.error('Gagal menghapus data:', response.message);
                    alert('Gagal menghapus data!');
                }
            },
            error: function (xhr, status, error) {
                console.error('Terjadi kesalahan:', error);
                alert('Terjadi kesalahan saat menghapus data!');
            }
        });
    }
}

function editData(id_Kamar) {
    // $('[id^=tombol_simpan_]').css('display', 'none');
    // $('[id^=tombol_edit_]').css('display', 'inline-block');
    $.ajax({
        type: 'POST',
        url: 'config/kamar/edit_kamar.php',
        data: {
            id_kamar: id_Kamar
        },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                 $('#id_kamar').val(response.data_kamar.id_kamar);
                $('#nomer_kamar').val(response.data_kamar.nomer_kamar);
                $('#status_kamar').val(response.data_kamar.status_kamar);

                alert("Anda yakin ingin mengubah id : " + id_Kamar);
                $('#tombol_edit_' + id_Kamar).hide();
                $('#tombol_simpan_' + id_Kamar).css('display', 'inline-block');
                $('#daftarkan').css('display', 'none');
                $('#tombol_simpan_' + id_Kamar).attr('data-id', id_Kamar);
                $('#kamarForm').show();

            } else {
                alert('Gagal mengambil data kamar: ' + response.message);
            }
        },
        error: function (xhr, status, error) {
            alert('Terjadi kesalahan: ' + error);
        }
    });
}

function simpanData(id_Kamar) {
    var nomer_kamar = $('#nomer_kamar').val();
    var status_kamar = $('#status_kamar').val();

    $.ajax({
        type: 'GET',
        url: 'config/kamar/edit_kamar.php',
        data: {
            id_kamar: id_Kamar,
            nomer_kamar: nomer_kamar,
            status_kamar: status_kamar,
        },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                console.log('Perubahan berhasil disimpan:', response.message);
                alert('Perubahan berhasil disimpan!');
                untukkamar();
                updateTabledashboard();
                refreshdata();
                batalin();
            } else {
                console.error('Gagal menyimpan perubahan:', response.message);
                alert('Gagal menyimpan perubahan!');
            }
        },
        error: function (xhr, status, error) {
            console.error('Terjadi kesalahan:', error);
            alert('Terjadi kesalahan saat menyimpan perubahan!');
        }
    });
}


function batalin() {
    var formData = $('#kamarForm').serialize();
    document.getElementById('kamarForm').reset();
}

function refreshdata(idkamar) {
    $('#tombol_simpan_' + idkamar).css('display', 'inline-block');
    $('#daftarkan').css('display', 'inline-block');


}


untukkamar();