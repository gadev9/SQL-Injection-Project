<?php
$servername = "localhost";
$username = "webapp";
$password = "webapp123";
$dbname = "testdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_POST['username']) {
    $user = $_POST['username'];
  
    $stmt = $conn->prepare("SELECT id, username FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        echo "<h3 style='color: green;'>Login Successful! (Protected by WAF)</h3>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Username</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["id"]."</td><td>".$row["username"]."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<h3 style='color: red;'>Login Failed!</h3>";
    }
    
    $stmt->close();
}

$conn->close();
?>
<br><a href="page2.html">Back to Login</a>
