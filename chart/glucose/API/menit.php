<?php
if (isset($_GET['tanggal-awal']) && isset($_GET['data'])) {
    $tanggal_awal = $_GET['tanggal-awal'];
    $tanggal_akhir = isset($_GET['tanggal-akhir']) ? $_GET['tanggal-akhir'] : $tanggal_awal;
    $data_types = explode(',', $_GET['data']);

    // Koneksi ke database
    $conn = mysqli_connect("localhost", "root", "", "glucosedb");

    if (!$conn) {
        echo json_encode(['error' => "Koneksi gagal: " . mysqli_connect_error()]);
        exit;
    }

    $data = [];


    if (in_array('GST1', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                GST1 AS gst1
            FROM `readsensors` 
            WHERE waktu BETWEEN ? AND ?
            GROUP BY DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00')
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

        $data['GST1'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['GST1'][] = [
                'waktu' => $row['waktu'],
                'gst1' => $row['gst1']
            ];
        }
    }
    if (in_array('GST2', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                GST2 AS gst2
            FROM `readsensors` 
            WHERE waktu BETWEEN ? AND ?
            GROUP BY DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00')
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

        $data['GST2'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['GST2'][] = [
                'waktu' => $row['waktu'],
                'gst2' => $row['gst2']
            ];
        }
    }
    if (in_array('GST3', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                GST3 AS gst3
            FROM `readsensors` 
            WHERE waktu BETWEEN ? AND ?
            GROUP BY DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00')
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

        $data['GST3'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['GST3'][] = [
                'waktu' => $row['waktu'],
                'gst3' => $row['gst3']
            ];
        }
    }
    if (in_array('GST4', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                GST4 AS gst4
            FROM `readsensors` 
            WHERE waktu BETWEEN ? AND ?
            GROUP BY DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00')
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

        $data['GST4'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['GST4'][] = [
                'waktu' => $row['waktu'],
                'gst4' => $row['gst4']
            ];
        }
    }
    if (in_array('GST5', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                GST5 AS gst5
            FROM `readsensors` 
            WHERE waktu BETWEEN ? AND ?
            GROUP BY DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00')
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

        $data['GST5'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['GST5'][] = [
                'waktu' => $row['waktu'],
                'gst5' => $row['gst5']
            ];
        }
    }

    $conn->close();

    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Silakan pilih tanggal dan data yang akan ditampilkan.']);
}
