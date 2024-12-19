$(document).ready(function() {
    // Fungsi untuk memuat dan memperbarui nilai feed water secara berkala
    function updateLHFDValue() {
        $.ajax({
            url: '../../data/boiler/lhfd.php', // File PHP untuk mengambil data terbaru dari MySQL
            dataType: 'json',
            success: function(response) {
                $('#lhfd').text(response.lhfd); // Update nilai feed water
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ' + status + error);
            }
        });
    }

    // Memanggil fungsi updateFeedWaterValue setiap 1 detik
    setInterval(updateLHFDValue, 1000); // Interval setiap 1 detik (1000 ms)
});