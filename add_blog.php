<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $date = $_POST['date'];
    $content = $_POST['content'];
    
    // Handle file upload
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageName = basename($_FILES['image']['name']);
        $targetDir = "uploads/";
        $targetFile = $targetDir . $imageName;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $image = $targetFile;
        } else {
            echo "Error uploading image.";
            exit;
        }
    }

    // Insert data into database
    $stmt = $pdo->prepare("INSERT INTO blogs (title, image, date, content) VALUES (?, ?, ?, ?)");
    $stmt->execute([$title, $image, $date, $content]);

    echo "<script>alert('Blog added successfully!'); window.location.href='add_blog.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Blog</title>
    <?php include 'cdn.php'; ?>
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <style>
        form {
            max-width: 600px;
            margin: auto;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
        }
        #editor-container {
            height: 200px;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Add Blog</h1>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Blog Title</label>
            <input type="text" id="title" name="title" required>
        </div>

        <div class="form-group">
            <label for="image">Blog Image</label>
            <input type="file" id="image" name="image" accept="image/*" required>
        </div>

        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" id="date" name="date" required>
        </div>

        <div class="form-group">
            <label for="content">Blog Content</label>
            <div id="editor-container"></div>
            <textarea name="content" id="content" style="display:none;"></textarea>
        </div>

        <button type="submit">Add Blog</button>
    </form>

    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <script>
        const quill = new Quill('#editor-container', {
            theme: 'snow'
        });

        document.querySelector('form').addEventListener('submit', function () {
            const content = document.querySelector('textarea#content');
            content.value = quill.root.innerHTML;
        });
    </script>
</body>
</html>
