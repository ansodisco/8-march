<?php
require_once 'config.php';

setJsonHeader();

// Initialize database
initDatabase();

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($method === 'POST') {
    // Upload photo
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['dataURL']) || !isset($input['time']) || !isset($input['date'])) {
        http_response_code(400);
        echo jsonResponse(false, 'Missing required fields');
        exit;
    }
    
    try {
        $db = getDB();
        $stmt = $db->prepare("
            INSERT INTO photos (image_data, time_display, date_display)
            VALUES (:image_data, :time_display, :date_display)
        ");
        
        $stmt->execute([
            ':image_data' => $input['dataURL'],
            ':time_display' => $input['time'],
            ':date_display' => $input['date']
        ]);
        
        echo jsonResponse(true, 'Photo saved successfully', [
            'id' => $db->lastInsertId()
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo jsonResponse(false, 'Database error: ' . $e->getMessage());
    }
} elseif ($method === 'GET') {
    // Get all photos
    try {
        $db = getDB();
        $photos = $db->query("SELECT * FROM photos ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
        
        echo jsonResponse(true, 'Photos retrieved', $photos);
    } catch (Exception $e) {
        http_response_code(500);
        echo jsonResponse(false, 'Database error: ' . $e->getMessage());
    }
} elseif ($method === 'DELETE') {
    // Delete photo
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['id'])) {
        http_response_code(400);
        echo jsonResponse(false, 'Missing photo ID');
        exit;
    }
    
    try {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM photos WHERE id = :id");
        $stmt->execute([':id' => $input['id']]);
        
        echo jsonResponse(true, 'Photo deleted successfully');
    } catch (Exception $e) {
        http_response_code(500);
        echo jsonResponse(false, 'Database error: ' . $e->getMessage());
    }
} else {
    http_response_code(405);
    echo jsonResponse(false, 'Method not allowed');
}
?>
