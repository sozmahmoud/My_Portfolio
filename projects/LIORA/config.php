<?php
// Database configuration
$host = "localhost";
$user = "root";
$pass = "";
$dbName = "liora_db";

// Optional local override for custom environments.
// Copy config.local.php.example to config.local.php and update values
// if the other PC uses a different MySQL user/password/database.
if (file_exists(__DIR__ . '/config.local.php')) {
    require __DIR__ . '/config.local.php';
}

// Optional environment variable override for portability.
$envHost = getenv('LIORA_DB_HOST');
if ($envHost !== false && $envHost !== '') {
    $host = $envHost;
}
$envUser = getenv('LIORA_DB_USER');
if ($envUser !== false && $envUser !== '') {
    $user = $envUser;
}
$envPass = getenv('LIORA_DB_PASS');
if ($envPass !== false && $envPass !== '') {
    $pass = $envPass;
}
$envDbName = getenv('LIORA_DB_NAME');
if ($envDbName !== false && $envDbName !== '') {
    $dbName = $envDbName;
}

if (!function_exists('liora_admin_accounts')) {
    function liora_admin_accounts(): array {
        return [
            [
                'username' => 'soz',
                'first_name' => 'Soz',
                'last_name' => 'Mahmoud',
                'email' => 'sozmahmoud68@gmail.com',
                'password' => 'soz2004',
            ],
            [
                'username' => 'LioraSupport',
                'first_name' => 'Liora',
                'last_name' => 'Support',
                'email' => 'support@liora.com',
                'password' => 'liora123',
            ],
        ];
    }
}

if (!function_exists('liora_is_admin_email')) {
    function liora_is_admin_email(?string $email): bool {
        $email = strtolower(trim((string) $email));
        if ($email === '') {
            return false;
        }

        foreach (liora_admin_accounts() as $admin) {
            if ($email === strtolower($admin['email'])) {
                return true;
            }
        }

        return false;
    }
}

// Connect to MySQL server (without selecting a database)
$conn = new mysqli($host, $user, $pass);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbName CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if (!$conn->query($sql)) {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db($dbName);

// On a fresh XAMPP computer, the database may exist but the tables may not.
// Bootstrap once from the existing setup script so pages can open immediately.
if (!function_exists('liora_table_exists')) {
    function liora_table_exists(mysqli $conn, string $tableName): bool {
        $stmt = $conn->prepare(
            'SELECT COUNT(*) AS table_count
             FROM INFORMATION_SCHEMA.TABLES
             WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?'
        );
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('s', $tableName);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result ? $result->fetch_assoc() : null;
        $stmt->close();

        return !empty($row['table_count']);
    }
}

if (!function_exists('liora_sync_admin_accounts')) {
    function liora_sync_admin_accounts(mysqli $conn, bool $resetPasswords = false): void {
        if (!liora_table_exists($conn, 'users')) {
            return;
        }

        foreach (liora_admin_accounts() as $admin) {
            $checkAdmin = $conn->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
            if (!$checkAdmin) {
                continue;
            }

            $checkAdmin->bind_param('s', $admin['email']);
            $checkAdmin->execute();
            $adminResult = $checkAdmin->get_result();

            if ($adminResult && $adminResult->num_rows > 0) {
                $existingAdmin = $adminResult->fetch_assoc();
                $checkAdmin->close();

                if ($resetPasswords) {
                    $passwordHash = password_hash($admin['password'], PASSWORD_BCRYPT);
                    $updateAdmin = $conn->prepare("UPDATE users SET username = ?, first_name = ?, last_name = ?, password_hash = ?, role = 'admin', is_active = 1, verification_token = NULL WHERE id = ?");
                    if ($updateAdmin) {
                        $updateAdmin->bind_param('ssssi', $admin['username'], $admin['first_name'], $admin['last_name'], $passwordHash, $existingAdmin['id']);
                        $updateAdmin->execute();
                        $updateAdmin->close();
                    }
                } else {
                    $updateAdmin = $conn->prepare("UPDATE users SET username = ?, first_name = ?, last_name = ?, role = 'admin', is_active = 1, verification_token = NULL WHERE id = ?");
                    if ($updateAdmin) {
                        $updateAdmin->bind_param('sssi', $admin['username'], $admin['first_name'], $admin['last_name'], $existingAdmin['id']);
                        $updateAdmin->execute();
                        $updateAdmin->close();
                    }
                }
            } else {
                $checkAdmin->close();

                $passwordHash = password_hash($admin['password'], PASSWORD_BCRYPT);
                $insertAdmin = $conn->prepare("INSERT INTO users (username, first_name, last_name, email, password_hash, role, is_active) VALUES (?, ?, ?, ?, ?, 'admin', 1)");
                if ($insertAdmin) {
                    $insertAdmin->bind_param('sssss', $admin['username'], $admin['first_name'], $admin['last_name'], $admin['email'], $passwordHash);
                    $insertAdmin->execute();
                    $insertAdmin->close();
                }
            }
        }
    }
}

$scriptName = basename($_SERVER['SCRIPT_FILENAME'] ?? '');
$isSetupScript = in_array($scriptName, ['init_db.php', 'setup_db.php', 'database_reset.php'], true);

if (!$isSetupScript && !liora_table_exists($conn, 'users') && file_exists(__DIR__ . '/init_db.php')) {
    if (!defined('LIORA_AUTO_BOOTSTRAP')) {
        define('LIORA_AUTO_BOOTSTRAP', true);
    }
    ob_start();
    require __DIR__ . '/init_db.php';
    ob_end_clean();
}

if (!$isSetupScript) {
    liora_sync_admin_accounts($conn);
}

// Define global constants
if (!defined('GEMINI_API_KEY')) {
    define('GEMINI_API_KEY', 'AIzaSyBFy68ZXoxKrBxoL3ufmFwaZpEpmhR2cDo');
}
if (!defined('OPENAI_API_KEY')) {
    // User will add their API key here
    define('OPENAI_API_KEY', '');
}
if (!defined('BUSINESS_EMAIL')) {
    define('BUSINESS_EMAIL', 'support@liora.com');
}
if (!defined('ADMIN_EMAIL')) {
    define('ADMIN_EMAIL', 'sozmahmoud68@gmail.com');
}
?>
