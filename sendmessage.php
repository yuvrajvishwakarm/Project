<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert & Fetch</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
        }
        th {
            background-color: #d4f4d4;
        }
    </style>
</head>
<body>

<?php
$conn = new mysqli("localhost", "root", "", "send");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/* ---------------- INSERT DATA ---------------- */
$Name = $_POST["name"] ?? "";
$PhoneNumber = $_POST["pn"] ?? "";
$Email = $_POST["email"] ?? "";
$msg = $_POST["msg"] ?? "";

if (!empty($Name) && !empty($Email)) {
    $stmt = $conn->prepare(
        "INSERT INTO send (Name, Email, PhoneNumber, Message)
         VALUES (?, ?, ?, ?)"
    );
    $stmt->bind_param("ssss", $Name, $Email, $PhoneNumber, $msg);

    if ($stmt->execute()) {
        echo "<p><b>New record created successfully</b></p>";
    } else {
        echo "Insert Error: " .$stmt->error;
    }
    $stmt->close();
}

/* ---------------- FETCH DATA ---------------- */
$result = $conn->query("SELECT * FROM send ORDER BY id DESC");

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Message</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>" . htmlspecialchars($row['Name']) . "</td>
                <td>" . htmlspecialchars($row['Email']) . "</td>
                <td>{$row['PhoneNumber']}</td>
                <td>" . htmlspecialchars($row['Message']) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No records found.";
}

$conn->close();
?>

</body>
</html>
