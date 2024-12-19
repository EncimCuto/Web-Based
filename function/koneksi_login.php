    <?php
    $host = 'localhost:3306';
    $dbname = 'pkl';
    $username = 'root';
    $password = '';

    try {
        $koneksi = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }   catch (PDOException $e) {
        die("Gagal: " . $e->getMessage());
    }
    ?>
