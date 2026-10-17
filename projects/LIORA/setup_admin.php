<?php
require_once 'config.php';

liora_sync_admin_accounts($conn, true);

echo "<h1>Success! 🌸</h1>";
foreach (liora_admin_accounts() as $admin) {
    echo "<p>Admin account ready: <strong>" . htmlspecialchars($admin['email'], ENT_QUOTES, 'UTF-8') . "</strong>.</p>";
}
echo "<p><a href='admin.php'>Go to Admin Dashboard</a></p>";
?>
