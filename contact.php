<?php
require 'db.php';

$message = ''; // Initialize the message variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['full_name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $userMessage = $_POST['message'];

    try {
        $stmt = $pdo->prepare("INSERT INTO contacts (full_name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([$fullName, $email, $subject, $userMessage]);
        $message = 'Your message has been sent successfully!';
    } catch (Exception $e) {
        $message = 'Failed to send your message: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Contact Veebeckz Tech Hub - We are here to help with your inquiries.">
    <meta name="keywords" content="Contact Us, Veebeckz Tech Hub, Get in Touch, Customer Support">
    <meta name="author" content="Veebeckz Tech Hub">
    <title>Contact Us - Veebeckz Tech Hub</title>
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
                <h1>Contact us</h1>
               

            </div>
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="./images/slide_1.jpg" alt="">

                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container careers">
            <h1>Contact Us</h1>
            <p>Have questions or need assistance? Fill out the form below, and we’ll get back to you shortly.</p>

            <?php if (!empty($message)): ?>
                <script>
                    alert("<?= htmlspecialchars($message) ?>");
                </script>
            <?php endif; ?>

            <form action="contact.php" method="POST">
               <div class="forms">
               <label for="full_name">Full Name:</label>
               <input type="text" id="full_name" name="full_name" required>
               </div>

               <div class="forms">
               <label for="email">Email Address:</label>
               <input type="email" id="email" name="email" required>
               </div>

                <div class="forms">
                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" required>
                </div>

              <div class="forms">  <label for="message">Message:</label>
              <textarea id="message" name="message" rows="5" required></textarea></div>

           <div class="forms">
           <button type="submit">Send Message</button>
           </div>
            </form>
        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>

</html>
