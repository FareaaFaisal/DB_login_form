<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the DB for user credentials
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['email'] = $email;
        header("Location: dashboard.html");
        exit;
    } else {
        // Redirect back to the login page with an error message
        $error_message = "❌ Incorrect login credentials. Please try again.";
    }
}
?>

<!-- Login Form (Displaying the Error Message) -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 min-h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-sm">
        <h2 class="text-2xl font-bold mb-6 text-center text-indigo-600">Login</h2>

        <!-- Display the error message if login failed -->
        <?php if (isset($error_message)): ?>
            <div class="text-red-500 text-sm text-center mb-4"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="space-y-4">
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
                <div class="relative">
                    <input
                        type="password"
                        name="password"
                        id="password"
                        required
                        class="mt-1 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400"
                    />
                </div>
            </div>

            <button
                type="submit"
                class="w-full bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 transition-all duration-300"
            >
                Login
            </button>
        </form>
    </div>

</body>
</html>
