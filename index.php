<?php
    session_start();
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
    $role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome -->
    <title>TrashHandler</title>
</head>
<body>
    <header id="header">
        <div class="logo"><a href="index.html">TrashHandler</a></div>
        <nav>
            <ul>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact Us</a></li>
                <li><?php
                        if($username && $role == "vendor") 
                            echo "<a href='Vendor/buy.php'>Buy</a>";
                        else if($username && $role == "seller")
                            echo "<a href='Seller/sell.php'>Sell</a>";
                        else
                            echo "<a href='login.php'>Buy/Sell</a>";
                    ?>
                </li>
                <li>
                    <?php
                        if($username && $role == "vendor") 
                            echo "<a href='Vendor/dashboard.php'>Dashboard</a>";
                        else if($username && $role == "seller")
                            echo "<a href='Seller/dashboard.php'>Dashboard</a>";
                        else
                            echo "<a href='login.php'>Login/SignUp</a>";
                    ?>
                    
                </li>
            </ul>
        </nav>
    </header>

    <div id="slideshow-container">
        <div id="slideshow">
            <img src="assets/image1.jpg" alt="A view of waste management in action">
            <img src="assets/image2.jpg" alt="Recycling materials being sorted" style="display:none;">
            <img src="assets/image3.jpg" alt="Clean environment promoting sustainability" style="display:none;">
        </div>
    </div>
    
    <div id="slideshow-text">Welcome to TrashHandler</div>

    <hr> <!-- Horizontal line -->

    <main>
        <div class="container">
            <div class="section" id="about">
                <h2>About Us</h2>
                <p>Welcome to TrashHandler, your trusted partner in waste management and recycling solutions. At TrashHandler, we believe in creating a sustainable future by connecting sellers of scrap materials with vendors who can responsibly recycle them.</p>
                <p>Founded in 2022, TrashHandler aims to reduce landfill waste and promote a circular economy by making it easy for individuals and businesses to dispose of their scrap materials. Our platform simplifies the process of scheduling pickups, ensuring that waste is collected efficiently and effectively.</p>
                <p>Our mission is to:</p>
                <ul>
                    <li style="color: #333;">Provide a seamless and user-friendly platform for scrap material disposal.</li>
                    <li style="color: #333;">Empower local vendors to expand their businesses while contributing to a cleaner environment.</li>
                    <li style="color: #333;">Educate the community about the importance of recycling and sustainable practices.</li>
                </ul>
                <p>At TrashHandler, we value:</p>
                <ul>
                    <li style="color: #333;"><strong>Integrity:</strong> We operate with honesty and transparency in all our dealings.</li>
                    <li style="color: #333;"><strong>Community:</strong> We believe in building strong relationships with our users and partners.</li>
                    <li style="color: #333;"><strong>Innovation:</strong> We continuously seek to improve our services through technology and feedback.</li>
                </ul>
                <p>Join us in our journey to make the world a cleaner, greener place. Together, we can transform waste into valuable resources!</p>
            </div>

            <hr> <!-- Horizontal line -->

            <div class="section" id="contact">
                <h2>Contact Us</h2>
                <p>If you have any questions, feel free to reach out to us!</p>
                <p>Email: <a href="mailto:support@trashhandler.com">support@trashhandler.com</a></p>
                <p>Phone: +1 (555) 123-4567</p>
                <p>Address: 123 Trash Lane, Clean City, CC 12345</p>
            </div>
        </div>
    </main>

    <div class="up-arrow" onclick="scrollToTop()">
        <i class="fas fa-arrow-up"></i>
    </div>

    <script src="index.js"></script>
    <script src="handler.js" defer></script>
    <script>
    let currentIndex = 0; // Start from the first image
    const images = document.querySelectorAll('#slideshow img'); // Get all the images in the slideshow

    function changeImage() {
        images[currentIndex].style.display = 'none';
        currentIndex = (currentIndex + 1) % images.length; 
        images[currentIndex].style.display = 'block';
    }
    setInterval(changeImage, 2000);
</script>
</body>
</html>
