<?php
// Database configuration
define('DB_FILE', __DIR__ . '/march8_party.db');

// Initialize database
function initDatabase() {
    if (!file_exists(DB_FILE)) {
        $db = new PDO('sqlite:' . DB_FILE);
        
        // Create photos table
        $db->exec("
            CREATE TABLE IF NOT EXISTS photos (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                image_data LONGTEXT NOT NULL,
                image_type TEXT DEFAULT 'jpeg',
                timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
                time_display TEXT,
                date_display TEXT
            )
        ");
        
        // Create suggestions table
        $db->exec("
            CREATE TABLE IF NOT EXISTS suggestions (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                text TEXT NOT NULL,
                timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
                time_display TEXT,
                date_display TEXT
            )
        ");
        
        return $db;
    }
    
    return new PDO('sqlite:' . DB_FILE);
}

// Get database connection
function getDB() {
    return new PDO('sqlite:' . DB_FILE);
}

// Set JSON header
function setJsonHeader() {
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
}

// Return JSON response
function jsonResponse($success, $message = '', $data = null) {
    return json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
}
?>
