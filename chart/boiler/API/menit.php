<?php
header('Content-Type: application/json'); // Pastikan header JSON

if (isset($_GET['tanggal-awal']) && isset($_GET['data'])) {
    $tanggal_awal = $_GET['tanggal-awal'];
    $tanggal_akhir = isset($_GET['tanggal-akhir']) ? $_GET['tanggal-akhir'] : $tanggal_awal;
    $data_types = explode(',', $_GET['data']);

    // Koneksi ke database
    $conn = mysqli_connect("localhost", "root", "", "boilerdb");

    if (!$conn) {
        echo json_encode(['error' => "Koneksi gagal: " . mysqli_connect_error()]);
        exit;
    }

    $data = [];

    if (in_array('FeedPressure', $data_types)) {
        // Query untuk Feed Pressure
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                FeedPressure AS pressure
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

        $data['FeedPressure'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['FeedPressure'][] = [
                'waktu' => $row['waktu'],
                'pressure' => $row['pressure']
            ];
        }
    }

    if (in_array('LevelFeedWater', $data_types)) {
        // Query untuk Feed Water
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                LevelFeedWater AS level
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

        $data['LevelFeedWater'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['LevelFeedWater'][] = [
                'waktu' => $row['waktu'],
                'level' => $row['level']
            ];
        }
    }

    if (in_array('RHGuiloutine', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                RHGuiloutine AS rhg
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

        $data['RHGuiloutine'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['RHGuiloutine'][] = [
                'waktu' => $row['waktu'],
                'rhg' => $row['rhg']
            ];
        }
    }

    if (in_array('LHGuiloutine', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                LHGuiloutine AS lhg
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

        $data['LHGuiloutine'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['LHGuiloutine'][] = [
                'waktu' => $row['waktu'],
                'lhg' => $row['lhg']
            ];
        }
    }

    if (in_array('RHTemp', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                RHTemp AS rh
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

        $data['RHTemp'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['RHTemp'][] = [
                'waktu' => $row['waktu'],
                'rh' => $row['rh']
            ];
        }
    }

    if (in_array('LHTemp', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                LHTemp AS lh
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

        $data['LHTemp'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['LHTemp'][] = [
                'waktu' => $row['waktu'],
                'lh' => $row['lh']
            ];
        }
    }

    if (in_array('PVSteam', $data_types)) {
        // Query untuk PV Steam
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                PVSteam AS value
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

        $data['PVSteam'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['PVSteam'][] = [
                'waktu' => $row['waktu'],
                'value' => $row['value']
            ];
        }
    }

    if (in_array('LHFDFan', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                LHFDFan AS lhf
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

        $data['LHFDFan'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['LHFDFan'][] = [
                'waktu' => $row['waktu'],
                'lhf' => $row['lhf']
            ];
        }
    }

    if (in_array('RHFDFan', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                RHFDFan AS rhf
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

        $data['RHFDFan'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['RHFDFan'][] = [
                'waktu' => $row['waktu'],
                'rhf' => $row['rhf']
            ];
        }
    }

    if (in_array('LHStoker', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                LHStoker AS lhs
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

        $data['LHStoker'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['LHStoker'][] = [
                'waktu' => $row['waktu'],
                'lhs' => $row['lhs']
            ];
        }
    }

    if (in_array('RHStoker', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                RHStoker AS rhs
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

        $data['RHStoker'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['RHStoker'][] = [
                'waktu' => $row['waktu'],
                'rhs' => $row['rhs']
            ];
        }
    }

    if (in_array('WaterPump1', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                WaterPump1 AS pump1
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

        $data['WaterPump1'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['WaterPump1'][] = [
                'waktu' => $row['waktu'],
                'pump1' => $row['pump1']
            ];
        }
    }

    if (in_array('WaterPump2', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                WaterPump2 AS pump2
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

        $data['WaterPump2'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['WaterPump2'][] = [
                'waktu' => $row['waktu'],
                'pump2' => $row['pump2']
            ];
        }
    }

    if (in_array('InletWaterFlow', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                InletWaterFlow AS inwater
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

        $data['InletWaterFlow'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['InletWaterFlow'][] = [
                'waktu' => $row['waktu'],
                'inwater' => $row['inwater']
            ];
        }
    }

    if (in_array('OutletSteamFlow', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                OutletSteamFlow AS outlet
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

        $data['OutletSteamFlow'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['OutletSteamFlow'][] = [
                'waktu' => $row['waktu'],
                'outlet' => $row['outlet']
            ];
        }
    }

    if (in_array('SuhuFeedTank', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                SuhuFeedTank AS suhu
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

        $data['SuhuFeedTank'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['SuhuFeedTank'][] = [
                'waktu' => $row['waktu'],
                'suhu' => $row['suhu']
            ];
        }
    }

    if (in_array('IDFan', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                IDFan AS idfan
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

        $data['IDFan'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['IDFan'][] = [
                'waktu' => $row['waktu'],
                'idfan' => $row['idfan']
            ];
        }
    }


    // Tutup koneksi
    mysqli_close($conn);

    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Parameter tidak lengkap']);
}
