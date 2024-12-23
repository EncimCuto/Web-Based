<?php
if (isset($_GET['tanggal-awal']) && isset($_GET['data'])) {
    $tanggal_awal = $_GET['tanggal-awal'];
    $tanggal_akhir = isset($_GET['tanggal-akhir']) ? $_GET['tanggal-akhir'] : $tanggal_awal;
    $data_types = explode(',', $_GET['data']);

    // Koneksi ke database
    $conn = mysqli_connect("localhost", "root", "", "olahsaridb");

    if (!$conn) {
        echo json_encode(['error' => "Koneksi gagal: " . mysqli_connect_error()]);
        exit;
    }

    $data = [];


    if (in_array('TempMixer1', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:00:00') AS waktu, 
                TempMixer1 AS temp1
            FROM `readsensors` 
            WHERE waktu BETWEEN ? AND ?
            GROUP BY DATE_FORMAT(waktu, '%Y-%m-%d %H:00:00')
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

        $data['TempMixer1'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['TempMixer1'][] = [
                'waktu' => $row['waktu'],
                'temp1' => $row['temp1']
            ];
        }
    }
    if (in_array('LC_Mixer1', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:00:00') AS waktu, 
                LC_Mixer1 AS lc1
            FROM `readsensors` 
            WHERE waktu BETWEEN ? AND ?
            GROUP BY DATE_FORMAT(waktu, '%Y-%m-%d %H:00:00')
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

        $data['LC_Mixer1'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['LC_Mixer1'][] = [
                'waktu' => $row['waktu'],
                'lc1' => $row['lc1']
            ];
        }
    }
    if (in_array('TempMixer2', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:00:00') AS waktu, 
                TempMixer2 AS temp2
            FROM `readsensors` 
            WHERE waktu BETWEEN ? AND ?
            GROUP BY DATE_FORMAT(waktu, '%Y-%m-%d %H:00:00')
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

        $data['TempMixer2'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['TempMixer2'][] = [
                'waktu' => $row['waktu'],
                'temp2' => $row['temp2']
            ];
        }
    }
    if (in_array('LC_Mixer2', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:00:00') AS waktu, 
                LC_Mixer2 AS lc2
            FROM `readsensors` 
            WHERE waktu BETWEEN ? AND ?
            GROUP BY DATE_FORMAT(waktu, '%Y-%m-%d %H:00:00')
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

        $data['LC_Mixer2'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['LC_Mixer2'][] = [
                'waktu' => $row['waktu'],
                'lc2' => $row['lc2']
            ];
        }
    }

    $conn->close();

    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Silakan pilih tanggal dan data yang akan ditampilkan.']);
}
