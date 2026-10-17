<?php
require 'config.php';
$username = 'sozma'; // Assuming this is the user based on metadata path
$conn->query("UPDATE users SET role = 'admin', is_active = 1 WHERE username = '$username'");
if ($conn->affected_rows > 0) {
    echo "User $username promoted to Admin! 🌸";
} else {
    echo "User $username not found or already admin.";
}
?>
