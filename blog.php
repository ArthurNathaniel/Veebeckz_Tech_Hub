<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Stay updated with blogs from Veebeckz Tech Hub.">
    <meta name="keywords" content="Veebeckz Tech Hub, Blog">
    <meta name="author" content="Veebeckz Tech Hub">
    <title>Veebeckz Tech Hub - Blog</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/index.css">
    <style>
      

        .blog-card {
            
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.2s;
            margin-top: 50px;
        }

        .blog-card:hover {
            transform: scale(1.02);
        }

        .blog-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .blog-card h3 {
            margin: 0;
            padding: 10px;
            font-size: 1.2em;
        }

        .blog-details {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            max-width: 500px;
            width: 90%;
        }

        .blog-details img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .blog-details h2 {
            margin-top: 15px;
        }

        .blog-details p {
            margin-top: 10px;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <section>
        <div class="swiper mySwiper">
            <div class="hero_text">
                <h1>Our Blog</h1>
                <p>Stay updated with the latest news, insights, and articles from Veebeckz Tech Hub.</p>
            </div>
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="./images/slide_1.jpg" alt="">
                </div>
            </div>
        </div>
    </section>

    <section class="blog-cards">
    <?php
    require 'db.php';

    $stmt = $pdo->query("SELECT * FROM blogs ORDER BY date DESC");
    $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($blogs) > 0) {
        foreach ($blogs as $blog) {
            echo "<a href='view_blog.php?id={$blog['id']}' class='blog-card'>";
            echo "<img src='{$blog['image']}' alt='Blog Image'>";
            echo "<h3>{$blog['title']}</h3>";
            echo "</a>";
        }
    } else {
        echo "<div class='no_blog_message'>
                <h2>Oops! No Blogs Available</h2>
                <p>Currently, there are no blogs available. Please check back later for updates and exciting content!</p>
              </div>";
    }
    ?>
</section>


    <?php include 'footer.php'; ?>
<style>
    
</style>
   

    <script src="./js/swiper.js"></script>
</body>

</html>
