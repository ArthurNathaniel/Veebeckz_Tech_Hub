<?php
require 'db.php';

$message = ''; // Initialize message variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['full_name'];
    $gender = $_POST['gender'];
    $phoneNumber = $_POST['phone_number'];
    $role = $_POST['role'];
    $resume = $_FILES['resume'];

    // File upload handling
    $uploadDir = 'uploads/';
    $resumePath = $uploadDir . basename($resume['name']);

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true); // Ensure the uploads directory exists
    }

    if (move_uploaded_file($resume['tmp_name'], $resumePath)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO careers (full_name, gender, phone_number, role, resume) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$fullName, $gender, $phoneNumber, $role, $resumePath]);
            $message = 'Application submitted successfully!';
        } catch (Exception $e) {
            $message = 'Failed to submit application: ' . $e->getMessage();
        }
    } else {
        $message = 'Failed to upload resume.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Learn more about Veebeckz Tech Hub, a leader in Digital Transformation 🌐.">
    <meta name="keywords" content="Career Page, Veebeckz Tech Hub, Apply for Jobs, Technology Careers">
    <meta name="author" content="Veebeckz Tech Hub">
    <title>Careers at Veebeckz Tech Hub</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/careers.css">
</head>

<body>
    <?php include 'navbar.php'; ?>
    <section>
        <div class="swiper mySwiper">
            <div class="hero_text">
                <h1>Career</h1>
               

            </div>
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="./images/slide_1.jpg" alt="">

                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="careers">
            <h1>Join Veebeckz Tech Hub</h1>
            <p>We are looking for talented individuals to join our innovative team. Apply now!</p>

            <?php if (!empty($message)): ?>
                <script>
                    alert("<?= htmlspecialchars($message) ?>");
                </script>
            <?php endif; ?>

            <form action="career.php" method="POST" enctype="multipart/form-data">
                <div class="forms">
                    <label for="full_name">Full Name:</label>
                    <input type="text" id="full_name" name="full_name" required>
                </div>

                <div class="forms">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>

                <div class="forms">
                    <label for="phone_number">Phone Number:</label>
                    <input type="text" id="phone_number" name="phone_number" required>
                </div>

                <div class="forms">
                    <label for="role">Role:</label>
                    <select id="role" name="role" required>
                        <option value="Frontend">Frontend</option>
                        <option value="Backend">Backend</option>
                        <option value="UI/UX Designer">UI/UX Designer</option>
                        <option value="Graphic Designer">Graphic Designer</option>
                        <option value="Web Developer">Web Developer</option>
                    </select>
                </div>

                <div class="forms">
                    <label for="resume">Upload Resume:</label>
                    <input type="file" id="resume" name="resume" required>
                </div>

                <div class="forms">
                    <button type="submit">Submit Application</button>
                </div>
            </form>
        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>

</html>