<?php
// Include database connection
include 'db.php';

// Initialize error and success messages
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate inputs
    if (empty($name) || empty($email) || empty($password)) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address.';
    } else {
        try {
            // Check for duplicate email
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $emailCount = $stmt->fetchColumn();

            if ($emailCount > 0) {
                $error = 'Email is already registered. Please use a different email.';
            } else {
                // Hash the password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insert the new user
                $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
                $stmt->execute([
                    ':name' => $name,
                    ':email' => $email,
                    ':password' => $hashedPassword,
                ]);

                // Redirect to login page after successful signup
                header('Location: login.php');
                exit;
            }
        } catch (PDOException $e) {
            $error = 'Error: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/signup.css">
</head>

<body>
   <div class="signup_all">
  <div class="signup_box">
<div class="forms_title">
<h1>Signup</h1>
</div>

<?php if ($error): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form action="signup.php" method="POST">
    <div class="forms">
        <label for="name">Name:</label>
        <input type="text" placeholder="Enter your full name" id="name" name="name" required>
    </div>

    <div class="forms">
        <label for="email">Email:</label>
        <input type="email" placeholder="Enter your email address" id="email" name="email" required>
    </div>
    <div class="forms">

        <label for="password">Password:</label>
        <input type="password" placeholder="Enter your password" id="password" name="password" required>
    </div>

    <div class="forms">
        <button type="submit">Signup</button>
    </div>
    <div class="forms">
        <a href="login.php">click here to login</a>
    </div>
</form>
  </div>
   </div>
</body>

</html>