<?php
/**
 * Setup script to initialize the database
 * Run this file once to create the database tables
 */

require_once 'config.php';

header('Content-Type: text/html; charset=utf-8');

echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Database Setup</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 2rem; background: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .success { color: #27ae60; padding: 1rem; background: #d5f4e6; border-left: 4px solid #27ae60; margin-bottom: 1rem; }
        .error { color: #e74c3c; padding: 1rem; background: #fadbd8; border-left: 4px solid #e74c3c; margin-bottom: 1rem; }
        h1 { color: #333; }
        .info { color: #666; font-size: 0.9rem; }
    </style>
</head>
<body>
<div class='container'>
    <h1>🎉 March 8th Party - Database Setup</h1>";

try {
    initDatabase();
    $db = getDB();
    
    // Test tables exist
    $photos = $db->query("SELECT COUNT(*) as count FROM photos")->fetch(PDO::FETCH_ASSOC);
    $suggestions = $db->query("SELECT COUNT(*) as count FROM suggestions")->fetch(PDO::FETCH_ASSOC);
    
    echo "<div class='success'>
        <strong>✓ Database Initialized Successfully!</strong><br>
        <p>The SQLite database has been created with the following tables:</p>
        <ul>
            <li><strong>photos</strong> - Stores party photos ({$photos['count']} photos)</li>
            <li><strong>suggestions</strong> - Stores party suggestions ({$suggestions['count']} suggestions)</li>
        </ul>
    </div>";
    
    echo "<div class='info'>
        <p><strong>Database file:</strong> " . DB_FILE . "</p>
        <p><strong>API Endpoints:</strong></p>
        <ul>
            <li><code>api_photos.php</code> - Manages photos (GET, POST, DELETE)</li>
            <li><code>api_suggestions.php</code> - Manages suggestions (GET, POST)</li>
        </ul>
        <p>You can now close this page and use the invitation page normally. All photos and suggestions will be saved to the database.</p>
    </div>";
    
} catch (Exception $e) {
    echo "<div class='error'>
        <strong>✗ Setup Error</strong><br>
        " . htmlspecialchars($e->getMessage()) . "
    </div>";
    echo "<p class='info'>Make sure the directory is writable by the web server.</p>";
}

echo "</div>
</body>
</html>";
?>
