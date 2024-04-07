function submitForm() {
    var formData = $('#pasienForm').serialize();

    $.ajax({
        type: 'POST',
        url: 'config/pasien/api.php',
        data: formData,
        success: function (response) {
            if (response.status === 'success') {
                console.log('Koneksi Berhasil:', response.message);
                untukdashboard();
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


function untukdashboard() {
    $('#tabelfordashboard').empty();
    $.ajax({
        type: 'GET',
        url: 'config/pasien/get_data.php',
        success: function (response) {
            console.log('Server Response:', response); // Debugging line
            if (response.status === 'success') {
                console.log('Koneksi Berhasil:', response.message);
                updateTabledashboard(response.data_pasien);
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

function updateTabledashboard(dataPasien) {
    var rowsPerPage = 10; // Jumlah baris per halaman
    var totalPages = Math.ceil(dataPasien.length / rowsPerPage);
    $('#pagination').twbsPagination({
        totalPages: totalPages,
        visiblePages: totalPages > 10 ? 10 : totalPages,
        onPageClick: function (event, page) {
            displayDataByPageDashboard(page, dataPasien, rowsPerPage);
        }
    });
    displayDataByPageDashboard(1, dataPasien, rowsPerPage);
}

function displayDataByPageDashboard(page, dataPasien, rowsPerPage) {
    $('#tabelfordashboard').empty();
    var startIndex = (page - 1) * rowsPerPage;
    var endIndex = startIndex + rowsPerPage;
    for (var i = startIndex; i < endIndex && i < dataPasien.length; i++) {
        var pasien = dataPasien[i];
        var row = '<tr>' +
            '<td>' + pasien.idpasien + '</td>' +
            '<td>' + pasien.nama + '</td>' +
            '<td>' + pasien.jenis_kelamin + '</td>' +
            '<td>' + pasien.ciri_ciri + '</td>' +
            '<td>' + pasien.status_pasien + '</td>' +
            '<td>' + pasien.id_kamar + '</td>' +
            '<td>' +
            '<button class="btn btn-info btn-sm" onclick="editData(' + pasien.idpasien + ')" id="tombol_edit_' + pasien.idpasien + '">Edit</button> ' +
            '<button class="btn btn-success btn-sm" onclick="simpanData(' + pasien.idpasien + ')" id="tombol_simpan_' + pasien.idpasien + '" style="display: none;">Simpan</button>' +
            '<button class="btn btn-danger btn-sm" onclick="deleteData(' + pasien.idpasien + ')"  >Delete</button>' +
            '</td>' +
            '</tr>';
        $('#tabelfordashboard').append(row);
    }
}


function editData(idPasien) {
   
    // $('[id^=tombol_edit_]').css('display', 'inline-block');
    $.ajax({
        type: 'POST',
        url: 'config/pasien/edit.php',
        data: {
            idpasien: idPasien
        },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('#nama').val(response.data_pasien.nama);
                $('#jenis_kelamin').val(response.data_pasien.jenis_kelamin);
                $('#ciri_ciri').val(response.data_pasien.ciri_ciri);
                $('#status_pasien').val(response.data_pasien.status_pasien);
                $('#id_kamar').val(response.data_pasien.id_kamar);
                alert("Anda yakin ingin mengubah id : " + idPasien);
                $('#tombol_edit_' + idPasien).hide();
                $('#tombol_simpan_' + idPasien).css('display', 'inline-block');
                $('#daftarkan').css('display', 'none');
                $('#tombol_simpan_' + idPasien).attr('data-id', idPasien);
                $('#pasienForm').show();

            } else {
                alert('Gagal mengambil data pasien: ' + response.message);
            }
        },
        error: function (xhr, status, error) {
            alert('Terjadi kesalahan: ' + error);
        }
    });
}


function refreshdata(idPasien) {
    $('#tombol_simpan_' + idPasien).css('display', 'inline-block');
    $('#daftarkan').css('display', 'inline-block');


}

function simpanData(idPasien) {
    var nama = $('#nama').val();
    var jenis_kelamin = $('#jenis_kelamin').val();
    var ciri_ciri = $('#ciri_ciri').val();
    var status_pasien = $('#status_pasien').val();
    var id_kamar = $('#id_kamar').val();

    $.ajax({
        type: 'GET',
        url: 'config/pasien/edit.php',
        data: {
            idpasien: idPasien,
            nama: nama,
            jenis_kelamin: jenis_kelamin,
            ciri_ciri: ciri_ciri,
            status_pasien: status_pasien,
            id_kamar: id_kamar
        },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                console.log('Perubahan berhasil disimpan:', response.message);
                alert('Perubahan berhasil disimpan!');
                untukdashboard();
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
    var formData = $('#pasienForm').serialize();
    document.getElementById('pasienForm').reset();
}


function deleteData(idPasien) {
    var confirmation = confirm('Apakah Anda yakin ingin menghapus data dengan ID Pasien ' + idPasien + '?');

    if (confirmation) {
        $.ajax({
            type: 'POST',
            url: 'config/pasien/delete.php', // Change this to the appropriate URL for your delete operation
            data: {
                idpasien: idPasien
            },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    console.log('Data berhasil dihapus:', response.message);
                    alert('Data berhasil dihapus!');
                    untukdashboard();
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



$('#searchInput').on('input', function () {
    var keyword = $(this).val();
    pencarianaaa(keyword);
});


function pencarianaaa(keyword) {
    $('#tabelfordashboard').empty();
    $.ajax({
        type: 'GET',
        url: 'config/search.php',
        data: {
            keyword: keyword
        },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                console.log('Pencarian Berhasil:', response.message);
                updateTabledashboard(response.data_pasien);
            } else {
                console.error('Pencarian Gagal:', response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('Terjadi kesalahan:', error);
        }
    });
}

function untukhome() {
    $('#tabeluntukhome').empty();

    $.ajax({
        type: 'GET',
        url: 'config/pasien/get_data.php',
        success: function (response) {
            if (response.status === 'success') {
                console.log('Koneksi Berhasil:', response.message);
                updateTableHome(response.data_pasien);
            } else {
                console.error('Koneksi Gagal:', response.message);
            }
        },
        error: function (error) {
            console.log(error);
        },
    });
}

function updateTableHome(data_pasien) {
    var rowsPerPage = 10;
    var totalPages = Math.ceil(data_pasien.length / rowsPerPage);

    $('#pagination22').twbsPagination({
        totalPages: totalPages,
        visiblePages: totalPages > 10 ? 10 : totalPages,
        onPageClick: function (event, page) {
            displayDataByPagehome(page, data_pasien, rowsPerPage);
        }
    });
    displayDataByPagehome(1, data_pasien, rowsPerPage);
}

function displayDataByPagehome(page, data_pasien, rowsPerPage) {
    $('#tabeluntukhome').empty();

    var startIndex = (page - 1) * rowsPerPage;
    var endIndex = startIndex + rowsPerPage;

    for (var i = startIndex; i < endIndex && i < data_pasien.length; i++) {
        var pasien = data_pasien[i];
        var row = '<tr>' +
            '<td>' + pasien.nama + '</td>' +
            '<td>' + pasien.jenis_kelamin + '</td>' +
            '<td>' + pasien.ciri_ciri + '</td>' +
            '<td>' + pasien.status_pasien + '</td>' +
            '<td>' + pasien.id_kamar + '</td>' +
            '</tr>';
        $('#tabeluntukhome').append(row);
    }
}

$('#searchInputhome').on('input', function () {
    var keyword = $(this).val();
    pencarian(keyword);

});

function pencarian(keyword) {
    $('#tabeluntukhome').empty();
    $.ajax({
        type: 'GET',
        url: 'config/search.php',
        data: {
            keyword: keyword
        },
        dataType: 'json',
        success: function (response) {
            console.log(response);

            if (response.status === 'success') {
                if (response.status_user === 'admin') {
                    window.location.href = 'beranda.php';
                } else if (response.status_user === 'user') {
                    window.location.href = 'pesan_kamar.php';
                } else {
                    alert('Unknown status_user: ' + response.status_user);
                }
            } else {
                alert('Login failed. ' + response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('Terjadi kesalahan:', error);
        }
    });
}

function loginadmin() {
    var formData = {
        userName: $('#userName').val(),
        password: $('#pwd').val()
    };
    $.ajax({
        type: 'POST',
        url: 'config/autentikasi/login_proses.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            console.log(response); // Add this line for debugging

            if (response.status === 'success') {
                if (response.status_user === 'admin') {
                    window.location.href = 'beranda.php';
                } else if (response.status_user === 'user') {
                    window.location.href = 'pesan_kamar.php';
                } else {
                    alert('Unknown status_user: ' + response.status_user);
                }
            } else {
                alert('Login failed. ' + response.message);
            }
        },
        error: function (error) {
            console.log(error);
            alert('An error occurred during the login process.');
        }
    });
}


$(document).ready(function () {
    $('form').submit(function (event) {
        event.preventDefault();

        loginadmin();
    });
});


function logout() {
    $.ajax({
        type: 'POST',
        url: 'config/autentikasi/loggout.php',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {

                window.location.href = 'home.php';
                alert(response.message);
            } else {
                alert('Logout failed. ' + response.message);
            }
        },
        error: function (error) {
            console.log(error);
            alert('An error occurred during the logout process.');
        }
    });
}

untukdashboard();
untukhome();