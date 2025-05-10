<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "12345";
$db   = "db_lab_system";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Initialize variables
$email   = "";
$success = "";
$error   = "";

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get and sanitize email
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Prepare and execute delete statement
        $sql  = "DELETE FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $success = "✅ Record with email “{$email}” deleted successfully!";
            } else {
                $error = "❌ No record found with that email.";
            }
        } else {
            $error = "❌ Error deleting record: " . $conn->error;
        }
    } else {
        $error = "❌ Please enter a valid email address.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Delete Record</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center text-indigo-700">🗑️ Delete User Record</h2>

    <?php if ($success): ?>
      <p class="text-green-600 font-semibold mb-4"><?= $success ?></p>
    <?php elseif ($error): ?>
      <p class="text-red-600 font-semibold mb-4"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
      <div>
        <label class="block font-medium text-gray-700">Email</label>
        <input
          type="email"
          name="email"
          value="<?= htmlspecialchars($email) ?>"
          required
          class="mt-1 w-full border px-4 py-2 rounded-lg focus:ring-2 ring-indigo-400"
        />
      </div>
      <button
        type="submit"
        class="w-full bg-red-600 text-white py-2 rounded-lg font-semibold hover:bg-red-700 transition"
      >
        Delete Record
      </button>
    </form>

    <div class="text-center mt-6">
      <a href="dashboard.html" class="text-indigo-600 hover:text-indigo-800 font-medium">← Back to Dashboard</a>
    </div>
  </div>
</body>
</html>

<?php $conn->close(); ?>
