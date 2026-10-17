<?php
$host = 'localhost';
$db = 'liora_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $desc = $pdo->query("DESCRIBE products");
    echo "Table Structure:\n";
    while ($row = $desc->fetch(PDO::FETCH_ASSOC)) {
        echo "- {$row['Field']}: {$row['Type']}\n";
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
