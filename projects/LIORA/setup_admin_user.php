<?php
require_once 'config.php';

liora_sync_admin_accounts($conn, true);

foreach (liora_admin_accounts() as $admin) {
    echo "✅ Admin account ready: {$admin['email']}\n";
}
?>
