$(document).ready(function() {
    // Fungsi untuk memuat dan memperbarui nilai feed water secara berkala
    function updateheatingValue() {
        $.ajax({
            url: '../../data/pasteurisasi/press-to-pasteur.php', // File PHP untuk mengambil data terbaru dari MySQL
            dataType: 'json',
            success: function(response) {
                $('#press-pasteur').text(response.presstopasteur); // Update nilai feed water
            },
            error: function(_xhr, status, error) {
                console.error('AJAX Error: ' + status + error);
            }
        });
    }

    // Memanggil fungsi updateFeedWaterValue setiap 1 detik
    setInterval(updateheatingValue, 1000); // Interval setiap 1 detik (1000 ms)
});