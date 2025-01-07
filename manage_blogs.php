<?php
require 'db.php';

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    // Fetch blog to delete the image from the server
    $stmt = $pdo->prepare("SELECT image FROM blogs WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $blog = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($blog) {
        // Delete image file
        if (file_exists($blog['image'])) {
            unlink($blog['image']);
        }

        // Delete blog from the database
        $deleteStmt = $pdo->prepare("DELETE FROM blogs WHERE id = :id");
        $deleteStmt->execute(['id' => $id]);
        header("Location: manage_blogs.php?success=Blog deleted successfully");
        exit();
    } else {
        header("Location: manage_blogs.php?error=Blog not found");
        exit();
    }
}

// Fetch all blogs
$stmt = $pdo->query("SELECT * FROM blogs ORDER BY date DESC");
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blogs</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/dashboard.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <section class="manage_blogs_all">
        <h1>Manage Blogs</h1>

        <?php if (isset($_GET['success'])): ?>
            <p class="success"><?php echo htmlspecialchars($_GET['success']); ?></p>
        <?php elseif (isset($_GET['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($blogs as $blog): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($blog['title']); ?></td>
                        <td><?php echo $blog['date']; ?></td>
                        <td>
                            <a href="edit_blog.php?id=<?php echo $blog['id']; ?>">Edit</a> |
                            <a href="manage_blogs.php?delete=<?php echo $blog['id']; ?>" onclick="return confirm('Are you sure you want to delete this blog?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

 
</body>
</html>
