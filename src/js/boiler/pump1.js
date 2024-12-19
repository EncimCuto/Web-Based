$(document).ready(function() {
    // Fungsi untuk memuat dan memperbarui nilai feed water secara berkala
    function updateIDFanValue() {
        $.ajax({
            url: '../../data/boiler/pump1.php', // File PHP untuk mengambil data terbaru dari MySQL
            dataType: 'json',
            success: function(response) {
                $('#pump1').text(response.pump1); // Update nilai feed water
            },
            error: function(_xhr, status, error) {
                console.error('AJAX Error: ' + status + error);
            }
        });
    }

    // Memanggil fungsi updateFeedWaterValue setiap 1 detik
    setInterval(updateIDFanValue, 1000); // Interval setiap 1 detik (1000 ms)
});