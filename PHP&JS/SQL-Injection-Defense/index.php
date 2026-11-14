
<?php

// Create database connection

try {
    $pdo = new PDO("sqlite::memory:");

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create users table

    $pdo->exec("CREATE TABLE users (
        id INTEGER PRIMARY KEY,
        username TEXT,
        password TEXT
    )");

    // Insert test users

    $pdo->exec("
        INSERT INTO users (username, password) VALUES
        ('admin', '12345'),
        ('ahmed', 'abc123'),
        ('mohammed', 'pass2026')
    ");

    // Get username from URL

    $username = $_GET['username'] ?? '';

    // Select query mode

    $mode = $_GET['mode'] ?? 'safe';

    echo "<h2>SQL Injection Defense Tool</h2>";

    if ($mode == "unsafe") {

        // Unsafe query

        $sql = "SELECT * FROM users WHERE username = '$username'";

        $result = $pdo->query($sql);

        echo "<h3>Unsafe Query Results</h3>";

    } else {

        // Safe query using Prepared Statements

        $sql = "SELECT * FROM users WHERE username = :username";

        $result = $pdo->prepare($sql);
        $result->execute(['username' => $username]);

        echo "<h3>Safe Query Results</h3>";
    }

    $users = $result->fetchAll(PDO::FETCH_ASSOC);

    if ($users) {

        foreach ($users as $user) {
            echo "ID: " . htmlspecialchars($user['id']) . "<br>";
            echo "Username: " . htmlspecialchars($user['username']) . "<br>";
            echo "<hr>";
        }

    } else {
        echo "No users found.";
    }

} catch (PDOException $e) {

    http_response_code(500);
    echo "Database error. Please check your input.";

}

?>
