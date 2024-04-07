
function getStatusCount() {
    $.ajax({
        type: 'GET',
        url: 'config/get_count.php',
        success: function (response) {
            if (response.status === 'success') {
                console.log('Koneksi Berhasil:', response.message);
                updateStatusCount(response.waiting_count, response.handled_count);

            } else {
                console.error('Koneksi Gagal:', response.message);

            }
        },
        error: function (xhr, status, error) {
            console.error('Terjadi kesalahan AJAX:', status, error);
            console.log(xhr.responseText); // Display server response
        }
    });
}


function updateStatusCount(waitingCount, handledCount) {
    $('.purecounter-waiting').attr('data-purecounter-end', waitingCount).html(waitingCount);
    $('.purecounter-handled').attr('data-purecounter-end', handledCount).html(handledCount);
}
getStatusCount();