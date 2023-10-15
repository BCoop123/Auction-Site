<?php

function importHeader($pathToSurface){
echo'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bidorama Auctions</title>
    <link rel="icon" href="' . $pathToSurface . '/data/assets/logo_icon.png">
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!--The Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <!--The CSS-->
    <link href="' . $pathToSurface . '/themes/stylesheet/styles.css" rel="stylesheet">
    <!--Font Awesome-->
    <script src="https://kit.fontawesome.com/7bf037d0fc.js" crossorigin="anonymous"></script>
  </head>
  <body class="bg-light">
    <!-- <div id="grid-container"> -->
      <header>
        <div class="row text-light" style="background-image: url(' . $pathToSurface . '/data/assets/demos.png); background-color: #e8e8e8;">
          <div class="col-3 d-flex justify-content-center pt-2">
            <a href="/"><img class="logo" src="' . $pathToSurface . '/data/assets/logo.png" height="175px"></a>      
          </div>
          <div class="col-6 d-flex justify-content-center align-items-center">
            <div class="d-flex">
              <div class="searchSelection input-group">
                <select class="custom-select" id="inputGroupSelect01">
                  <option value="0" selected disabled hidden>Select Auction Type</option>
                  <option id="songSelect" value="1">Normal Auction</option>
                  <option id="albumSelect" value="2">Lottery Auction</option>
                  <option id="artistSelect" value="3">Mystery Auction</option>
                </select>
              </div>
            </div>
            <div class="searchInput form-outline">
              <input type="search" placeholder="Search" id="form1" class="form-control" />
            </div>
            <button type="button" class="searchButton btn btn-primary" style="border-radius: 0px 7px 7px 0px; background-color: #ffc907;" onclick="search()">
              <i class="fas fa-search"></i>
            </button>
        </div>
        <div class="col-3 d-flex justify-content-center align-items-center pt-4">
          
          <div id="menu-container">
            <!--<button id="menu-button">Menu</button>-->
            <section class="material-design-hamburger">
              <button class="material-design-hamburger__icon">
                <span class="material-design-hamburger__layer"></span>
              </button>
            </section>
            <section class="menu menu--off">
              <div class="menu-div-header">
              

                <a href="' . $pathToSurface . '/app/profile/index.php"><img src="' . getProfileImagePath() . '" alt="profile" style="width: 50px; height: 50px; margin-left: 10px;"></a>
                <h2 style="text-align: center;" class="profileUsername">Sign In / Sign Up</h2>
              </div>
              <a href="#"><div class="custom-btn" onclick="goHome()">Home</div></a>
              <hr class="menuDivider">
              <a href="#"><div class="custom-btn" onclick="goAboutUs()">Nav Page</div></a>
              <hr class="menuDivider">
              <a href="#"><div class="custom-btn" onclick="goToSelfProfile()">Account Details</div></a>
              <hr class="menuDivider">
              <a href="#"><div class="custom-btn" onclick="goTermsConditions()">Terms & Conditions</div></a>
              <hr class="menuDivider">
              <a href="#"><div class="custom-btn signStatus" onclick="signEvent()">Something</div></a>
    
            </section>
          </div>
        </div>
      </div>
    </header>
    ';
}


function importFooter($pathToSurface){
    echo'
    <footer class="text-light" style="background-image: url(' . $pathToSurface . '/data/assets/demos.png); background-color: #e8e8e8;">
      <div class="footer-whole" >
        <div class="row w-100">
          <div class="col-6 w-50 justify-content-center text-dark align-items-center footer-left">
            <h1>Quick Links:</h1>
            <a href="#" onclick="goHome()">Home</a>
            <a href="#" onclick="goAboutUs()">Nav Page</a>
            <a href="#" onclick="goToSelfProfile()">Nav Page</a>
            <a href="#" class="signStatus" onclick="signEvent()"></a>
            <a href="#" onclick="goTermsConditions()">Nav Page</a>
          </div>
          <div class="col-6 w-50 justify-content-center text-dark align-items-center footer-right">
            <h1>Connect with us:</h1>
            <a href="https://github.com/BCoop123/Auction-Site" target="_blank"><i class="fa-brands fa-github fa-2xl" style="color: #ffc907;"></i></a>
            <a href="https://www.instagram.com" target="_blank"><i class="fa-brands fa-instagram fa-2xl" style="color: #ffc907;"></i></a>
            <a href="mailto:ASE220@nku.edu" target="_blank"><i class="fa-solid fa-envelope fa-2xl" style="color: #ffc907;"></i></a>
            <a href="https://www.twitter.com" target="_blank"><i class="fa-brands fa-twitter fa-2xl" style="color: #ffc907;"></i></a>
            <a href="tel:000-0000" target="_blank"><i class="fa-solid fa-phone fa-2xl" style="color: #ffc907;"></i></a>
          </div>
        </div>
        </div>
      <div class="text-center text-dark p-2">
        © Copyright 2023 Bidorama inc. All rights reserved.          
      </div>
    </footer>
    <script>
      (function() {

        "use strict";

        document.querySelector(".material-design-hamburger__icon").addEventListener(
          "click",
          function() {      
            var child;
    
            this.parentNode.nextElementSibling.classList.toggle("menu--on");

            child = this.childNodes[1].classList;

            if (child.contains("material-design-hamburger__icon--to-arrow")) {
              child.remove("material-design-hamburger__icon--to-arrow");
              child.add("material-design-hamburger__icon--from-arrow");
            } else {
              child.remove("material-design-hamburger__icon--from-arrow");
              child.add("material-design-hamburger__icon--to-arrow");
            }

            checkSignedIn();
        });

      })();
    </script>
  </body> 
</div> 
</html>
';
}

?>
