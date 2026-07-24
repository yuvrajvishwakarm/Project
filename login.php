<!DOCTYPE html>
<html>
<head>
    <title>PHP Generated Table</title>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px 0;
            background: lightgreen;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #03d41f;
            color: black;
        }
    </style>
</head>
<body>
<?php
$conn = new mysqli("localhost", "root", "", "sample_new");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table if it doesn't exist
$createTableSql = "CREATE TABLE IF NOT EXISTS `form` (
    `Your Name` VARCHAR(255) NOT NULL,
    `Property Name` VARCHAR(255) NOT NULL,
    `No. of rooms` INT NOT NULL,
    `Email` VARCHAR(255) NOT NULL,
    `Password` VARCHAR(255) NOT NULL,
    `Phone Number` INT NOT NULL
)";
if ($conn->query($createTableSql) === FALSE) {
    die("Error creating table: " . $conn->error);
}

$YourName = $_POST["yn"] ?? "";
$PropertyName = $_POST["pn"] ?? "";
$Noofrooms = $_POST["nor"] ?? 0;
$Email = $_POST["email"] ?? "";
$Password = $_POST["password"] ?? "";
$PhoneNumber = $_POST["pno"] ?? 0;

// Insert query
$sql = $conn->prepare("INSERT INTO `form` (`Your Name`, `Property Name`, `No. of rooms`, Email, Password, `Phone Number`) VALUES (?, ?, ?, ?, ?, ?)");
$sql->bind_param("ssissi", $YourName, $PropertyName, $Noofrooms, $Email, $Password, $PhoneNumber);
if ($sql->execute()) {
    echo "New record created successfully<br>";
} else {
    echo "Error: " . $sql->error . "<br>";
}
$sql->close();

// Select and display data
$sql = "SELECT * FROM `form` ORDER BY `Your Name` ASC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    echo "<table><tr><th>Your Name</th><th>Property Name</th><th>No. of rooms</th><th>Email</th><th>Password</th><th>Phone Number</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . htmlspecialchars($row["Your Name"]) . "</td><td>" . htmlspecialchars($row["Property Name"]) . "</td><td>" . $row["No. of rooms"] . "</td><td>" . htmlspecialchars($row["Email"]) . "</td><td>" . htmlspecialchars($row["Password"]) . "</td><td>" . $row["Phone Number"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "No results";
}
$conn->close();
?>
</body>
</html>
