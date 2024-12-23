<?php
if (isset($_GET['tanggal-awal']) && isset($_GET['data'])) {
    $tanggal_awal = $_GET['tanggal-awal'];
    $tanggal_akhir = isset($_GET['tanggal-akhir']) ? $_GET['tanggal-akhir'] : $tanggal_awal;
    $data_types = explode(',', $_GET['data']);

    // Koneksi ke database
    $conn = mysqli_connect("localhost", "root", "", "dissolver");

    if (!$conn) {
        echo json_encode(['error' => "Koneksi gagal: " . mysqli_connect_error()]);
        exit;
    }

    $data = [];


    if (in_array('DT_RO', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:%s') AS waktu, 
                DT_RO AS RO
            FROM `readsensors` 
            WHERE waktu BETWEEN ? AND ?
            GROUP BY DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:%s')
            ORDER BY waktu
        ";

        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            echo json_encode(['error' => mysqli_error($conn)]);
            exit;
        }

        mysqli_stmt_bind_param($stmt, 'ss', $tanggal_awal, $tanggal_akhir);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result === false) {
            echo json_encode(['error' => mysqli_error($conn)]);
            exit;
        }

        $data['DT_RO'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['DT_RO'][] = [
                'waktu' => $row['waktu'],
                'RO' => $row['RO']
            ];
        }
    }
    if (in_array('DT_Salt', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:%s') AS waktu, 
                DT_Salt AS salt
            FROM `readsensors` 
            WHERE waktu BETWEEN ? AND ?
            GROUP BY DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:%s')
            ORDER BY waktu
        ";

        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            echo json_encode(['error' => mysqli_error($conn)]);
            exit;
        }

        mysqli_stmt_bind_param($stmt, 'ss', $tanggal_awal, $tanggal_akhir);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result === false) {
            echo json_encode(['error' => mysqli_error($conn)]);
            exit;
        }

        $data['DT_Salt'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['DT_Salt'][] = [
                'waktu' => $row['waktu'],
                'salt' => $row['salt']
            ];
        }
    }
    if (in_array('DT_SoySauceA', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:%s') AS waktu, 
                DT_SoySauceA AS sauceA
            FROM `readsensors` 
            WHERE waktu BETWEEN ? AND ?
            GROUP BY DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:%s')
            ORDER BY waktu
        ";

        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            echo json_encode(['error' => mysqli_error($conn)]);
            exit;
        }

        mysqli_stmt_bind_param($stmt, 'ss', $tanggal_awal, $tanggal_akhir);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result === false) {
            echo json_encode(['error' => mysqli_error($conn)]);
            exit;
        }

        $data['DT_SoySauceA'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['DT_SoySauceA'][] = [
                'waktu' => $row['waktu'],
                'sauceA' => $row['sauceA']
            ];
        }
    }
    if (in_array('DT_SoySauceB', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:%s') AS waktu, 
                DT_SoySauceB AS sauceB
            FROM `readsensors` 
            WHERE waktu BETWEEN ? AND ?
            GROUP BY DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:%s')
            ORDER BY waktu
        ";

        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            echo json_encode(['error' => mysqli_error($conn)]);
            exit;
        }

        mysqli_stmt_bind_param($stmt, 'ss', $tanggal_awal, $tanggal_akhir);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result === false) {
            echo json_encode(['error' => mysqli_error($conn)]);
            exit;
        }

        $data['DT_SoySauceB'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['DT_SoySauceB'][] = [
                'waktu' => $row['waktu'],
                'sauceB' => $row['sauceB']
            ];
        }
    }
    if (in_array('DT_SoySauceC', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:%s') AS waktu, 
                DT_SoySauceC AS sauceC
            FROM `readsensors` 
            WHERE waktu BETWEEN ? AND ?
            GROUP BY DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:%s')
            ORDER BY waktu
        ";

        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            echo json_encode(['error' => mysqli_error($conn)]);
            exit;
        }

        mysqli_stmt_bind_param($stmt, 'ss', $tanggal_awal, $tanggal_akhir);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result === false) {
            echo json_encode(['error' => mysqli_error($conn)]);
            exit;
        }

        $data['DT_SoySauceC'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['DT_SoySauceC'][] = [
                'waktu' => $row['waktu'],
                'sauceC' => $row['sauceC']
            ];
        }
    }

    $conn->close();

    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Silakan pilih tanggal dan data yang akan ditampilkan.']);
}
