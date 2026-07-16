<?php
// Put your real InfinityFree database connection details here
$db_host = "sql201.infinityfree.com
";
$db_user = "if0_42425260";
$db_pass = "Petke0bBMH ";
$db_name = "if0_42425260_XXX
";

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) { die("Database connection failed"); }

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action === 'add') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $query = "INSERT INTO users (name, age) VALUES ('$name', $age)";
    mysqli_query($conn, $query);
    header("Location: index.php");
    exit();
}

if ($action === 'toggle') {
    $id = (int)$_GET['id'];
    $res = mysqli_query($conn, "SELECT status FROM users WHERE id = $id");
    $row = mysqli_fetch_assoc($res);
    $new_status = ($row['status'] == 0) ? 1 : 0;
    mysqli_query($conn, "UPDATE users SET status = $new_status WHERE id = $id");
    echo json_encode(['success' => true, 'new_status' => $new_status]);
    exit();
}
mysqli_close($conn);
?>