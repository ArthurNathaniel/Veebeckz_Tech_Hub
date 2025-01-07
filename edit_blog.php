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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content']; // Quill.js content
    $date = $_POST['date'];
    $imagePath = $blog['image'];

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = 'uploads/';
        $imagePath = $uploadDir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        if (file_exists($blog['image'])) {
            unlink($blog['image']); // Delete old image
        }
    }

    // Update blog
    $updateStmt = $pdo->prepare("UPDATE blogs SET title = :title, image = :image, date = :date, content = :content WHERE id = :id");
    $updateStmt->execute([
        'title' => $title,
        'image' => $imagePath,
        'date' => $date,
        'content' => $content,
        'id' => $id,
    ]);

    header("Location: manage_blogs.php?success=Blog updated successfully");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog</title>
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/dashboard.css">
    <style>
        #editor-container {
            height: 300px;
        }
    </style>
</head>

<body>
    <?php include 'sidebar.php'; ?>

    <section class="manage_blogs_all">
        <h1>Edit Blog</h1>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="forms">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($blog['title']); ?>" required>
            </div>

            <div class="forms">
                <label for="image">Image:</label>
                <input type="file" name="image" id="image">
            </div>
            <div class="forms">
                <p>Current Image:
                    <br> <img src="<?php echo $blog['image']; ?>" alt="Current Blog Image" width="100">
                </p>

            </div>
            <div class="forms">
                <label for="date">Date:</label>
                <input type="date" name="date" id="date" value="<?php echo $blog['date']; ?>" required>
            </div>

            <div class="forms">
                <label for="content">Content:</label>
                <div id="editor-container"><?php echo htmlspecialchars($blog['content']); ?></div>
                <textarea name="content" id="content" style="display: none;"></textarea>
            </div>

            <div class="forms">
                <button type="submit">Update Blog</button>
            </div>
        </form>
    </section>


    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <script>
        // Initialize Quill editor
        var quill = new Quill('#editor-container', {
            theme: 'snow'
        });

        // Set initial content in Quill editor
        quill.root.innerHTML = <?php echo json_encode($blog['content']); ?>;

        // Update hidden textarea on form submit
        document.querySelector('form').onsubmit = function() {
            document.querySelector('#content').value = quill.root.innerHTML;
        };
    </script>
</body>

</html>