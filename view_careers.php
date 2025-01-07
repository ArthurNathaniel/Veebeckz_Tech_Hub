<?php
require 'db.php';

// Fetch career submissions
$stmt = $pdo->prepare("SELECT id, full_name, gender, phone_number, role, resume, created_at FROM careers ORDER BY created_at DESC");
$stmt->execute();
$careers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="View Career Applications - Veebeckz Tech Hub">
    <meta name="keywords" content="Career Applications, Veebeckz Tech Hub, Applicants Table">
    <meta name="author" content="Veebeckz Tech Hub">
    <title>Career Applications - Veebeckz Tech Hub</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/careers.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>

    <section>
        <div class="container careers">
            <h1>Career Applications</h1>
            <?php if (count($careers) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Gender</th>
                            <th>Phone Number</th>
                            <th>Role</th>
                            <th>Resume</th>
                            <th>Date Submitted</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($careers as $career): ?>
                            <tr>
                                <td><?= htmlspecialchars($career['id']) ?></td>
                                <td><?= htmlspecialchars($career['full_name']) ?></td>
                                <td><?= htmlspecialchars($career['gender']) ?></td>
                                <td><?= htmlspecialchars($career['phone_number']) ?></td>
                                <td><?= htmlspecialchars($career['role']) ?></td>
                                <td>
                                    <a href="<?= htmlspecialchars($career['resume']) ?>" target="_blank">View Resume</a>
                                </td>
                                <td><?= htmlspecialchars($career['created_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No applications have been submitted yet.</p>
            <?php endif; ?>
        </div>
    </section>


</body>

</html>
