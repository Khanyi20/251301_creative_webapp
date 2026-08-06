<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css//buttons.css">
    <link rel="stylesheet" href="../css/deco-elements.css">
    

    <link rel="stylesheet" href="https://www.flaticon.com/free-icons/arrow" title="arrow icons">
    <title>Document</title>
</head>
<body>
    


    <?php
    echo '<div class="image-container"></div>';
    echo '<div class="h2-content">What is Trade or Drop?</div>';
    ?>

    <div class="info-card">
        <div class="info-card__extra" id="extra-1">
            <?php echo $fullDescription= "This a student app dedicated to creating a 
            strong community by providing a platform where students can trade items they don’t need. 
            With a twist of ranking best to weirdest items, you can become the lead No. 
            1 on the ranking stage."; ?>
        </div>

        <button class="info-card__toggle-btn" onclick="toggleExtra(this, 'extra-1')">
            <i class="fi fi-rr-angle-left"></i>
            <span class="btn-label">See more</span>
        </button>
    </div>


<?php echo '<div class= "available-trade__title"><h4>Available trades</h4></div>' ?>
    <div class= "available-trade">
        
        <div class="available-trade__container">
            <?php $imagePath = "../assets/pencil_case.jpg";
            echo '<div><img class= "available-trade__item" src="' . $imagePath . '" alt="Pencil Case"></div>' ;
            echo '<div class= "available-trade__content">Pencil case</div>';
            ?>
        </div>

        <div class="available-trade__container">
            <?php $imagePath = "../assets/rubiks.jpg";
            echo '<div><img class= "available-trade__item" src="' . $imagePath . '" alt="Rubiks Cube"></div>' ;
            echo '<div class= "available-trade__content">Rubiks cube</div>';
            ?>
        </div>

        <div class="available-trade__container">
            <?php $imagePath = "../assets/journal.jpg";
            echo '<div><img class= "available-trade__item" src="' . $imagePath . '" alt="Notebook"></div>' ;
            echo '<div class= "available-trade__content">Notebook</div>';
            ?>
        </div>
    </div>

    <?php echo '<div class= "top-traders_title"><h4>Top Traders</h4></div>' ?>

    <div class= "available-trade">
        
        <div class="available-trade__container">
            <?php $imagePath = "../assets/cutecat.jpg";
            echo '<div><img class= "available-trade__item" src="' . $imagePath . '" alt="Cute Cat"></div>' ;
            ?>
        </div>

        <div class="available-trade__container">
            <?php $imagePath = "../assets/madcow.jpg";
            echo '<div><img class= "available-trade__item" src="' . $imagePath . '" alt="Mad Cow"></div>' ;
            ?>
        </div>

        <div class="available-trade__container">
            <?php $imagePath = "../assets/cutesnake.jpg";
            echo '<div><img class= "available-trade__item" src="' . $imagePath . '" alt="Cute Snake"></div>' ;
            ?>
        </div>
    </div>

    <div class="info-card">
            <?php echo "<p>You could be the next champion on the stage. 
            Don’t wait for tomorrow start today by joining our community</p>"; ?>
    </div>

    <button type="submit" class="join-us-btn" >Join Us</button>
    
    <div class="deco-circles">
        <span class="circle circle-1"></span>
        <span class="circle circle-2"></span>
        <span class="circle circle-3"></span>
        <span class="circle circle-4"></span>
        <span class="circle circle-5"></span>
        <span class="circle circle-6"></span>
        <span class="circle circle-7"></span>
        <span class="circle circle-8"></span>
        <span class="circle circle-9"></span>
        <span class="circle circle-10"></span>
    </div>

</body>

<script src="../js/landing_page.js"></script>
</html>