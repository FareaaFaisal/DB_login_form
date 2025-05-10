<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "12345";
$db = "db_lab_system";

// Create DB connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch records
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Lab Records</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-6xl mx-auto bg-white p-8 rounded-xl shadow-md">
    <h2 class="text-3xl font-bold mb-6 text-center text-indigo-700">🧾 All Lab Records</h2>

    <?php if ($result && $result->num_rows > 0): ?>
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 shadow-sm rounded-lg">
          <thead>
            <tr class="bg-indigo-100 text-indigo-700">
              
              <th class="py-3 px-4 border">Email</th>
              <th class="py-3 px-4 border">Password</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr class="hover:bg-indigo-50 transition">
                
                <td class="py-2 px-4 border"><?= htmlspecialchars($row['email']); ?></td>
                <td class="py-2 px-4 border"><?= $row['password']; ?></td>
              
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <p class="text-center text-red-600 font-semibold">No records found.</p>
    <?php endif; ?>

    <div class="text-center mt-6">
      <a href="dashboard.html" class="text-indigo-600 hover:text-indigo-800 font-medium">← Back to Dashboard</a>
    </div>
  </div>
</body>
</html>

<?php $conn->close(); ?>
