<?php
// Connection settings
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

// Initialize error message variable
$error_message = "";

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Simple validation for password match
    if ($password !== $confirm_password) {
        $error_message = "❌ Passwords do not match.";
    } else {
        // Check if the email already exists in the database
        $sql_check = "SELECT * FROM users WHERE email = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        // If the email already exists, show a warning message
        if ($result->num_rows > 0) {
            $error_message = "❌ This email is already in use. Please use a different email.";
        } else {
            // Insert the user into the database
            $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $email, $password); // Don't hash password for this example

            if ($stmt->execute()) {
                // Redirect to login page after successful signup
                header("Location: login.html");
                exit;
            } else {
                $error_message = "❌ Error: " . $conn->error;
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up - Lab System</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 min-h-screen flex items-center justify-center">

  <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-sm">
    <h2 class="text-2xl font-bold mb-6 text-center text-indigo-600">Sign Up</h2>

    <!-- Display error message if there is one -->
    <?php if (isset($error_message) && !empty($error_message)): ?>
      <p class="text-red-600 text-center font-semibold mb-4"><?= htmlspecialchars($error_message) ?></p>
    <?php endif; ?>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="space-y-4">
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input
          type="email"
          name="email"
          id="email"
          required
          class="mt-1 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400"
        />
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input
          type="password"
          name="password"
          id="password"
          required
          class="mt-1 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400"
        />
      </div>

      <div>
        <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
        <input
          type="password"
          name="confirm_password"
          id="confirm_password"
          required
          class="mt-1 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400"
        />
      </div>

      <button
        type="submit"
        class="w-full bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 transition-all duration-300"
      >
        Sign Up
      </button>
    </form>

    <div class="mt-4 text-center">
      <a href="login.html" class="text-indigo-600 hover:underline">Already have an account? Log in here</a>
    </div>
  </div>

</body>
</html>
