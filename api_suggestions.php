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
    // Create suggestion
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['text']) || !isset($input['time']) || !isset($input['date'])) {
        http_response_code(400);
        echo jsonResponse(false, 'Missing required fields');
        exit;
    }
    
    // Trim and validate text
    $text = trim($input['text']);
    if (strlen($text) === 0 || strlen($text) > 300) {
        http_response_code(400);
        echo jsonResponse(false, 'Invalid text length');
        exit;
    }
    
    try {
        $db = getDB();
        $stmt = $db->prepare("
            INSERT INTO suggestions (text, time_display, date_display)
            VALUES (:text, :time_display, :date_display)
        ");
        
        $stmt->execute([
            ':text' => $text,
            ':time_display' => $input['time'],
            ':date_display' => $input['date']
        ]);
        
        echo jsonResponse(true, 'Suggestion saved successfully', [
            'id' => $db->lastInsertId()
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo jsonResponse(false, 'Database error: ' . $e->getMessage());
    }
} elseif ($method === 'GET') {
    // Get all suggestions
    try {
        $db = getDB();
        $suggestions = $db->query("SELECT * FROM suggestions ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
        
        echo jsonResponse(true, 'Suggestions retrieved', $suggestions);
    } catch (Exception $e) {
        http_response_code(500);
        echo jsonResponse(false, 'Database error: ' . $e->getMessage());
    }
} else {
    http_response_code(405);
    echo jsonResponse(false, 'Method not allowed');
}
?>
