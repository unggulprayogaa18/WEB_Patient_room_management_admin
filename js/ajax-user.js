function submitForm() {
    var formData = $('#userForm').serialize();

    $.ajax({
        type: 'POST',
        url: 'config/user/api_user.php',
        data: formData,
        contentType: 'application/x-www-form-urlencoded',
        success: function (response) {
            if (response.status === 'success') {
                console.log('Koneksi Berhasil:', response.message);
                untukuser();
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


function untukuser() {
    $('#tableforuser').empty();
    $.ajax({
        type: 'GET',
        url: 'config/user/get_data_user.php',
        success: function (response) {
            console.log('Server Response:', response); // Debugging line
            if (response.status === 'success') {
                console.log('Koneksi Berhasil:', response.message);
                updateTabledashboard(response.data_user);
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

function updateTabledashboard(data_user) {
    var rowsPerPage = 10; // Jumlah baris per halaman
    var totalPages = Math.ceil(data_user.length / rowsPerPage);
    $('#pagination').twbsPagination({
        totalPages: totalPages,
        visiblePages: totalPages > 10 ? 10 : totalPages,
        onPageClick: function (event, page) {
            displayDataByPageDashboard(page, data_user, rowsPerPage);
        }
    });
    // Hapus semua baris yang ada sebelum menambahkan yang baru
    $('#tableforuser').empty();
    displayDataByPageDashboard(1, data_user, rowsPerPage);
}


function displayDataByPageDashboard(page, data_user, rowsPerPage) {
    $('#tableforuser2').empty();
    var startIndex = (page - 1) * rowsPerPage;
    var endIndex = startIndex + rowsPerPage;
    for (var i = startIndex; i < endIndex && i < data_user.length; i++) {
        var user = data_user[i];
        var row = '<tr>' +
            '<td>' + user.username + '</td>' +
            '<td>' + user.password + '</td>' +
            '<td>' + user.status_user + '</td>' +
            '<td>' +
            '<button class="btn btn-info btn-sm" onclick="editData(\'' + user.username + '\')" id="tombol_edit_' + user.username + '">Edit</button> ' +
            '<button class="btn btn-success btn-sm" onclick="simpanData(\'' + user.username + '\')" id="tombol_simpan_' + user.username + '" style="display: none;">Simpan</button>' +
            '<button class="btn btn-danger btn-sm" onclick="deleteData(\'' + user.username + '\')">Delete</button>' +
            '</td>' +
            '</tr>';
        $('#tableforuser').append(row);
    }
}



function deleteData(Username) {
    var confirmation = confirm('Apakah Anda yakin ingin menghapus data dengan ID user ' + Username + '?');

    if (confirmation) {
        $.ajax({
            type: 'POST',
            url: 'config/user/delete_user.php',
            data: {
                username: Username
            },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    console.log('Data berhasil dihapus:', response.message);
                    alert('Data berhasil dihapus!');
                    untukuser();
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


function editData(username) {
    $.ajax({
        type: 'POST',
        url: 'config/user/edit_user.php',
        data: {
            username: username
        },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('#username').val(response.data_user.username);
                $('#password').val(response.data_user.password);
                $('#status_user').val(response.data_user.status_user);
                alert("Anda yakin ingin mengubah id : " + username);
                $('#tombol_edit_' + username).hide();
                $('#tombol_simpan_' + username).css('display', 'inline-block');
                $('#daftarkan').css('display', 'none');
                $('#tombol_simpan_' + username).attr('data-id', username);
                $('#userForm').show();
            } else {
                alert('Gagal mengambil data kamar: ' + response.message);
            }
        },
        error: function (xhr, status, error) {
            alert('Terjadi kesalahan: ' + error);
        }
    });
}

function simpanData(username) {
    var password = $('#password').val();
    var status_user = $('#status_user').val();

    $.ajax({
        type: 'POST',
        url: 'config/user/edit_user.php',
        data: {
            username: username,
            password: password,
            status_user: status_user
        },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                console.log('Perubahan berhasil disimpan:', response.message);
                alert('Perubahan berhasil disimpan!');
                untukuser();
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
    var formData = $('#userForm').serialize();
    document.getElementById('userForm').reset();
}

function refreshdata(Username) {
    $('#tombol_simpan_' + Username).css('display', 'inline-block');
    $('#daftarkan').css('display', 'inline-block');


}

untukuser();