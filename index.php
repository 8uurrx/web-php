<?php
// Put your real InfinityFree database connection details here
$db_host = "sql201.infinityfree.com
";
$db_user = "Your_Username_Here";
$db_pass = "Your_Password_Here";
$db_name = "if0_42425260_XXX
";

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
$query = "SELECT * FROM users ORDER BY id ASC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management Task</title>
    <style>
        body { font-family: sans-serif; margin: 40px; background-color: #fafafa; }
        .form-inline { display: flex; justify-content: center; align-items: center; gap: 15px; margin-bottom: 30px; }
        input[type="text"], input[type="number"] { padding: 6px 10px; border: 1px solid #ccc; border-radius: 4px; }
        input[type="submit"], button { padding: 6px 12px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        table { width: 70%; margin: 0 auto; border-collapse: collapse; background: #fff; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>

    <div class="form-inline">
        <form action="api.php?action=add" method="POST">
            <label>Name:</label>
            <input type="text" name="name" required>
            <label>Age:</label>
            <input type="number" name="age" required>
            <input type="submit" value="Submit">
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['age']; ?></td>
                <td id="status-<?php echo $row['id']; ?>"><?php echo $row['status']; ?></td>
                <td><button onclick="toggleStatus(<?php echo $row['id']; ?>)">Toggle</button></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <script>
    function toggleStatus(userId) {
        fetch('api.php?action=toggle&id=' + userId)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('status-' + userId).innerText = data.new_status;
                } else {
                    alert('Error updating status');
                }
            });
    }
    </script>
</body>
</html>
<?php mysqli_close($conn); ?>