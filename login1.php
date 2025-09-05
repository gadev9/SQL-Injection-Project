<?php
// Database configuration
$host = 'localhost';
$dbname = 'mysql';
$username = 'root';
$password = '';

// Display basic styling
echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Query Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 { color: #333; text-align: center; }
        .query-display {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            font-family: monospace;
            word-break: break-all;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            margin: 20px 0;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            margin: 20px 0;
        }
        .back-btn {
            display: inline-block;
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
        .back-btn:hover {
            background-color: #5a6268;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">';
// Check if form was submitted
if ($_POST && isset($_POST['sql_query'])) {
    $sql_query = $_POST['sql_query'];

    echo '<h2>SQL Query Results</h2>';
    echo '<div class="query-display"><strong>Executed Query:</strong> ' . htmlspecialchars($sql_query) . '</div>';

    try {
        // Create PDO connection with additional options for MySQL
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, $options);

        // Execute the query
        $stmt = $pdo->query($sql_query);

        if ($stmt) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($results)) {
                echo '<div class="success">Query executed successfully. No results returned.</div>';
            } else {
                echo '<div class="success">Query executed successfully. ' . count($results) . ' rows returned.</div>';

                // Display results in table format
                echo '<table>';

                // Table headers
                if (!empty($results)) {
                    echo '<thead><tr>';
                    foreach (array_keys($results[0]) as $column) {
                        echo '<th>' . htmlspecialchars($column) . '</th>';
                    }
                    echo '</tr></thead>';

                    // Table body
                    echo '<tbody>';
                    foreach ($results as $row) {
                        echo '<tr>';
                        foreach ($row as $value) {
                            echo '<td>' . htmlspecialchars($value ?? 'NULL') . '</td>';
                        }
                        echo '</tr>';
                    }
                    echo '</tbody>';
                }
                echo '</table>';
            }
        }

    } catch (PDOException $e) {
        echo '<div class="error"><strong>Database Error:</strong> ' . htmlspecialchars($e->getMessage()) . '</div>';
    } catch (Exception $e) {
        echo '<div class="error"><strong>Error:</strong> ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
} else {
    echo '<h2>No Query Provided</h2>';
    }

echo '<a href="page1.html" class="back-btn">← Back to Query Form</a>';
echo '</div></body></html>';
?>
