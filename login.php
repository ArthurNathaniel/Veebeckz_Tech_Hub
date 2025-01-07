<?php
// Include database connection
include 'db.php';

// Initialize error and success messages
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate inputs
    if (empty($email) || empty($password)) {
        $error = 'Both fields are required.';
    } else {
        try {
            // Prepare and execute the select query
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify the password
            if ($user && password_verify($password, $user['password'])) {
                // Start session and store user info
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];

                // Redirect to a dashboard or welcome page
                header('Location: add_blog.php');
                exit;
            } else {
                $error = 'Invalid email or password.';
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
    <title>Login</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/signup.css">
</head>

<body>
    <div class="signup_all">
        <div class="signup_box">
            <div class="forms_title">
                <h1>Login</h1>
            </div>
            <?php if ($error): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="forms">
                    <label for="email">Email:</label>
                    <input type="email" placeholder="Enter your email address" id="email" name="email" required>
                </div>
                <div class="forms">

                    <label for="password">Password:</label>
                    <input type="password" placeholder="Enter your password" id="password" name="password" required>
                </div>

                <div class="forms">
                    <button type="submit">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>