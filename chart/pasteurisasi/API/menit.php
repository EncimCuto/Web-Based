<?php
if (isset($_GET['tanggal-awal']) && isset($_GET['data'])) {
    $tanggal_awal = $_GET['tanggal-awal'];
    $tanggal_akhir = isset($_GET['tanggal-akhir']) ? $_GET['tanggal-akhir'] : $tanggal_awal;
    $data_types = explode(',', $_GET['data']);

    // Koneksi ke database
    $conn = mysqli_connect("localhost", "root", "", "pasteur1db");

    if (!$conn) {
        echo json_encode(['error' => "Koneksi gagal: " . mysqli_connect_error()]);
        exit;
    }

    $data = [];


    if (in_array('SpeedPompaMixing', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                SpeedPompaMixing AS pumpmixing
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

        $data['SpeedPompaMixing'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['SpeedPompaMixing'][] = [
                'waktu' => $row['waktu'],
                'pumpmixing' => $row['pumpmixing']
            ];
        }
    }
    if (in_array('SuhuPreheating', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                SuhuPreheating AS preheating
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

        $data['SuhuPreheating'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['SuhuPreheating'][] = [
                'waktu' => $row['waktu'],
                'preheating' => $row['preheating']
            ];
        }
    }
    if (in_array('PressureMixing', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                PressureMixing AS pressuremix
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

        $data['PressureMixing'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['PressureMixing'][] = [
                'waktu' => $row['waktu'],
                'pressuremix' => $row['pressuremix']
            ];
        }
    }
    if (in_array('LevelBT1', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                LevelBT1 AS levelBT1
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

        $data['LevelBT1'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['LevelBT1'][] = [
                'waktu' => $row['waktu'],
                'levelBT1' => $row['levelBT1']
            ];
        }
    }
    if (in_array('SpeedPumpBT1', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                SpeedPumpBT1 AS pumpBT1
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

        $data['SpeedPumpBT1'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['SpeedPumpBT1'][] = [
                'waktu' => $row['waktu'],
                'pumpBT1' => $row['pumpBT1']
            ];
        }
    }
    if (in_array('LevelVD', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                LevelVD AS levelVD
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

        $data['LevelVD'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['LevelVD'][] = [
                'waktu' => $row['waktu'],
                'levelVD' => $row['levelVD']
            ];
        }
    }
    if (in_array('SpeedPumpVD', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                SpeedPumpVD AS pumpVD
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

        $data['SpeedPumpVD'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['SpeedPumpVD'][] = [
                'waktu' => $row['waktu'],
                'pumpVD' => $row['pumpVD']
            ];
        }
    }
    if (in_array('Flowrate', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                Flowrate AS flowrate
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

        $data['Flowrate'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['Flowrate'][] = [
                'waktu' => $row['waktu'],
                'flowrate' => $row['flowrate']
            ];
        }
    }
    if (in_array('SuhuHeating', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                SuhuHeating AS heating
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

        $data['SuhuHeating'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['SuhuHeating'][] = [
                'waktu' => $row['waktu'],
                'heating' => $row['heating']
            ];
        }
    }
    if (in_array('SuhuHolding', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                SuhuHolding AS holding
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

        $data['SuhuHolding'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['SuhuHolding'][] = [
                'waktu' => $row['waktu'],
                'holding' => $row['holding']
            ];
        }
    }
    if (in_array('SuhuPrecooling', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                SuhuPrecooling AS precooling
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

        $data['SuhuPrecooling'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['SuhuPrecooling'][] = [
                'waktu' => $row['waktu'],
                'precooling' => $row['precooling']
            ];
        }
    }
    if (in_array('LevelBT2', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                LevelBT2 AS levelBT2
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

        $data['LevelBT2'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['LevelBT2'][] = [
                'waktu' => $row['waktu'],
                'levelBT2' => $row['levelBT2']
            ];
        }
    }
    if (in_array('SpeedPumpBT2', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                SpeedPumpBT2 AS pumpBT2
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

        $data['SpeedPumpBT2'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['SpeedPumpBT2'][] = [
                'waktu' => $row['waktu'],
                'pumpBT2' => $row['pumpBT2']
            ];
        }
    }
    if (in_array('PressureBT2', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                PressureBT2 AS pressureBT2
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

        $data['PressureBT2'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['PressureBT2'][] = [
                'waktu' => $row['waktu'],
                'pressureBT2' => $row['pressureBT2']
            ];
        }
    }
    if (in_array('SuhuCooling', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                SuhuCooling AS cooling
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

        $data['SuhuCooling'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['SuhuCooling'][] = [
                'waktu' => $row['waktu'],
                'cooling' => $row['cooling']
            ];
        }
    }    if (in_array('PressToPasteur', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                PressToPasteur AS pasteur
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

        $data['PressToPasteur'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['PressToPasteur'][] = [
                'waktu' => $row['waktu'],
                'pasteur' => $row['pasteur']
            ];
        }
    }
    if (in_array('PressVDHH', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                PressVDHH AS VDHH
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

        $data['PressVDHH'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['PressVDHH'][] = [
                'waktu' => $row['waktu'],
                'VDHH' => $row['VDHH']
            ];
        }
    }
    if (in_array('PressVDLL', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                PressVDLL AS VDLL
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

        $data['PressVDLL'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['PressVDLL'][] = [
                'waktu' => $row['waktu'],
                'VDLL' => $row['VDLL']
            ];
        }
    }
    if (in_array('MixingAM', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                MixingAM AS mixing
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

        $data['MixingAM'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['MixingAM'][] = [
                'waktu' => $row['waktu'],
                'mixing' => $row['mixing']
            ];
        }
    }
    if (in_array('BT1AM', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                BT1AM AS bt1am
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

        $data['BT1AM'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['BT1AM'][] = [
                'waktu' => $row['waktu'],
                'bt1am' => $row['bt1am']
            ];
        }
    }
    if (in_array('VDAM', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                VDAM AS vdam
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

        $data['VDAM'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['VDAM'][] = [
                'waktu' => $row['waktu'],
                'vdam' => $row['vdam']
            ];
        }
    }
    if (in_array('PCV1', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                PCV1 AS pcv1
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

        $data['PCV1'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['PCV1'][] = [
                'waktu' => $row['waktu'],
                'pcv1' => $row['pcv1']
            ];
        }
    }
    if (in_array('TimeDivert', $data_types)) {
        $sql = "
            SELECT 
                DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') AS waktu, 
                TimeDivert AS divert
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

        $data['TimeDivert'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data['TimeDivert'][] = [
                'waktu' => $row['waktu'],
                'divert' => $row['divert']
            ];
        }
    }


    $conn->close();

    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Silakan pilih tanggal dan data yang akan ditampilkan.']);
}
