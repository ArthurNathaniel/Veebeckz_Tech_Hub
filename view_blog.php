<?php
require 'db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $blog = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$blog) {
        die("Blog not found.");
    }
} else {
    die("Invalid blog ID.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($blog['title']); ?> - Veebeckz Tech Hub</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/index.css">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <section class="blog-details">
      
        <h1><?php echo htmlspecialchars($blog['title']); ?></h1>
        <img src="<?php echo $blog['image']; ?>" alt="Blog Image">
        <div class="blog-content">
            <?php echo $blog['content']; ?>
        </div>
        <p><strong>Date:</strong> <?php echo $blog['date']; ?></p>
    </section>

    <?php include 'footer.php'; ?>
</body>

</html>
<style>
    .blog-details{
        padding: 0 5%;
        width: 100%;
        margin-top: 50px;
    }
    .blog-details img{
        width: 100%;
        height: 350px;
        object-fit: contain;
    }
</style>