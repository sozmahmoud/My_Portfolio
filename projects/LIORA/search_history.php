<?php
session_start();
header('Content-Type: application/json');

require_once 'config.php';

function sendResponse($data) {
    echo json_encode($data);
    exit;
}

function initializeSearchHistoryTable($conn) {
    $createSql = "CREATE TABLE IF NOT EXISTS user_search_history (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        search_query VARCHAR(255) NOT NULL,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        INDEX idx_search_history_user (user_id),
        INDEX idx_search_history_timestamp (timestamp),
        INDEX idx_search_history_query (search_query)
    ) ENGINE=InnoDB;";

    $conn->query($createSql);
}

initializeSearchHistoryTable($conn);

$userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
$action = isset($_REQUEST['action']) ? trim($_REQUEST['action']) : 'fetch';

if ($userId <= 0) {
    if ($action === 'fetch') {
        sendResponse(['success' => true, 'history' => []]);
    }
    sendResponse(['success' => false, 'message' => 'Not logged in']);
}

switch ($action) {
    case 'save':
        $query = isset($_POST['query']) ? trim($_POST['query']) : '';
        if ($query === '') {
            sendResponse(['success' => false, 'message' => 'Empty query']);
        }

        $query = mb_substr($query, 0, 255);

        $stmt = $conn->prepare('SELECT search_query FROM user_search_history WHERE user_id = ? ORDER BY timestamp DESC LIMIT 1');
        if ($stmt) {
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $stmt->bind_result($lastQuery);
            if ($stmt->fetch()) {
                if (mb_strtolower($lastQuery) === mb_strtolower($query)) {
                    $stmt->close();
                    break;
                }
            }
            $stmt->close();
        }

        $insert = $conn->prepare('INSERT INTO user_search_history (user_id, search_query) VALUES (?, ?)');
        if ($insert) {
            $insert->bind_param('is', $userId, $query);
            $insert->execute();
            $insert->close();
        }

        break;

    case 'remove':
        $query = isset($_POST['query']) ? trim($_POST['query']) : '';
        if ($query === '') {
            sendResponse(['success' => false, 'message' => 'Empty query']);
        }

        $delete = $conn->prepare('DELETE FROM user_search_history WHERE user_id = ? AND LOWER(search_query) = LOWER(?)');
        if ($delete) {
            $delete->bind_param('is', $userId, $query);
            $delete->execute();
            $delete->close();
        }

        break;
    
    case 'clear_all':
        $delete = $conn->prepare('DELETE FROM user_search_history WHERE user_id = ?');
        if ($delete) {
            $delete->bind_param('i', $userId);
            $delete->execute();
            $delete->close();
        }
        break;

    case 'fetch':
    default:
        break;
}

$stmt = $conn->prepare(
    'SELECT search_query FROM (
        SELECT search_query, MAX(timestamp) AS latest_ts
        FROM user_search_history
        WHERE user_id = ?
        GROUP BY search_query
        ORDER BY latest_ts DESC
        LIMIT 10
    ) AS recent_queries
    ORDER BY latest_ts DESC'
);

$history = [];
if ($stmt) {
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $stmt->bind_result($searchQuery);
    while ($stmt->fetch()) {
        $history[] = $searchQuery;
    }
    $stmt->close();
}

sendResponse(['success' => true, 'history' => $history]);
