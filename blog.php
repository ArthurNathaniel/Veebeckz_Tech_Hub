<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Currently, there are no blogs available. Stay tuned for updates from Veebeckz Tech Hub.">
    <meta name="keywords" content="Veebeckz Tech Hub, Blog, No Blog Available">
    <meta name="author" content="Veebeckz Tech Hub">
    <title>Veebeckz Tech Hub - Blog</title>
    <?php include 'cdn.php' ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/index.css">
</head>

<body>
    <?php include 'navbar.php' ?>
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

    <section class="no_blog_available">
        <div class="no_blog_message">
            <h2>Oops! No Blogs Available</h2>
            <p>Currently, there are no blogs available. Please check back later for updates and exciting content!</p>
        </div>
    </section>


    <?php include 'footer.php'?>

<script src="./js/swiper.js"></script>
</body>
</html>