<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "12345";
$db = "db_lab_system";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Initialize variables
$email = $password = "";
$success = $error = "";

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Basic validation
    if (!empty($id) && !empty($email) && !empty($password)) {
        $sql = "UPDATE users SET email=?, password=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $email, $password, $id);
        if ($stmt->execute()) {
            $success = "✅ Record updated successfully!";
        } else {
            $error = "❌ Error updating record: " . $conn->error;
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Update Record</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center text-indigo-700">✏️ Update User Record</h2>

    <?php if ($success): ?>
      <p class="text-green-600 font-semibold mb-4"><?= $success ?></p>
    <?php elseif ($error): ?>
      <p class="text-red-600 font-semibold mb-4"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
      <div>
        <label class="block font-medium text-gray-700">User ID</label>
        <input type="number" name="id" min="1" required class="mt-1 w-full border px-4 py-2 rounded-lg focus:ring-2 ring-indigo-400" />
      </div>
      <div>
        <label class="block font-medium text-gray-700">New Email</label>
        <input type="email" name="email" required class="mt-1 w-full border px-4 py-2 rounded-lg focus:ring-2 ring-indigo-400" />
      </div>
      <div>
        <label class="block font-medium text-gray-700">New Password</label>
        <input type="text" name="password" required class="mt-1 w-full border px-4 py-2 rounded-lg focus:ring-2 ring-indigo-400" />
      </div>
      <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 transition">
        Update Record
      </button>
    </form>

    <div class="text-center mt-6">
      <a href="dashboard.html" class="text-indigo-600 hover:text-indigo-800 font-medium">← Back to Dashboard</a>
    </div>
  </div>
</body>
</html>

<?php $conn->close(); ?>
