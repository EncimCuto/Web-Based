$(document).ready(function() {
    // Fungsi untuk memuat dan memperbarui nilai feed water secara berkala
    function updateRHTEMPValue() {
        $.ajax({
            url: '../../data/daily_tank/DT_RO.php', // File PHP untuk mengambil data terbaru dari MySQL
            dataType: 'json',
            success: function(response) {
                $('#RO').text(response.RO); // Update nilai feed water
            },
            error: function(_xhr, status, error) {
                console.error('AJAX Error: ' + status + error);
            }
        });
    }

    // Memanggil fungsi updateFeedWaterValue setiap 1 detik
    setInterval(updateRHTEMPValue, 1000); // Interval setiap 1 detik (1000 ms)
});