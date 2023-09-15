<?php session_start();
ob_start();
include("panel/config.php");
$ayar = @mysqli_query($baglanti, "select * from ayarlar where id='1'");
$ayar = $ayar->fetch_assoc();
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $ayar["ad"]; ?></title>
  <meta name="keywords" content="<?php echo $ayar["keyword"]; ?>">
  <meta name="description" content="<?php echo $ayar["description"]; ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Saira&display=swap" rel="stylesheet">
  <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
</head>

<body>
  <header class="hero container-fluid">
    <nav class="hero-nav container px-4 px-lg-0 mx-auto">
      <ul class="nav w-100 list-unstyled align-items-center p-0">
        <li class="hero-nav__item">
          <img class="hero-nav__logo" src="img/xd.png">
        </li>
        <li id="hero-menu" class="flex-grow-1 hero__nav-list hero__nav-list--mobile-menu ft-menu">
          <ul class="hero__menu-content nav flex-column flex-lg-row ft-menu__slider animated list-unstyled p-2 p-lg-0">
            <li class="flex-grow-1">
              <ul class="nav list-unstyled align-items-center p-0">
                <li class="hero-nav__item">
                  <a href="index" class="nav_menu">Home</a>
                </li>
                <li class="hero-nav__item">
                  <a href="#features" onclick="smoothScroll(document.getElementById('features'))" class="nav_menu">Features</a>
                </li>
                <li class="hero-nav__item">
                  <a href="#pricing" onclick="smoothScroll(document.getElementById('pricing'))" class="nav_menu">Pricing</a>
                </li>
                <li class="hero-nav__item">
                  <a href="#faq" onclick="smoothScroll(document.getElementById('faq'))" class="nav_menu">FAQ</a>
                </li>
                <li class="hero-nav__item">
                  <a href="/panel/login" class="nav_menu">Login</a>
                </li>
                <li class="hero-nav__item">
                  <a href="/panel/register" class="nav_menu">Register</a>
                </li>
              </ul>
            </li>
          </ul>
          <button onclick="document.querySelector('#hero-menu').classList.toggle('ft-menu--js-show')" class="ft-menu__close-btn animated">
            <svg class="bi bi-x" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M11.854 4.146a.5.5 0 010 .708l-7 7a.5.5 0 01-.708-.708l7-7a.5.5 0 01.708 0z" clip-rule="evenodd" />
              <path fill-rule="evenodd" d="M4.146 4.146a.5.5 0 000 .708l7 7a.5.5 0 00.708-.708l-7-7a.5.5 0 00-.708 0z" clip-rule="evenodd" />
            </svg>
          </button>
        </li>
        <li class="d-lg-none flex-grow-1 d-flex flex-row-reverse hero-nav__item">
          <button onclick="document.querySelector('#hero-menu').classList.toggle('ft-menu--js-show')" class="text-center px-2">
            <i class="fas fa-bars"></i>
          </button>
        </li>
      </ul>
    </nav>
    <div class="hero__content container mx-auto">
      <div class="row px-0 mx-0 align-items-center">
        <div class="col-lg-6 px-0">
          <h1 class="hero__title mb-3">
            Stresser.gg<br>
            Best IP Stresser
          </h1>
          <p class="hero__paragraph mb-5">
            We are the best IP Stresser / booter you can find on the market.
          </p>
          <div class="hero__btns-container">
            <a class="hero__btn btn btn-primary mb-2 mb-lg-0" href="panel/register">
              Sign Up
            </a>
          </div>
        </div>
        <div class="col-lg-5 mt-5 mt-lg-0 mx-0">
          <div class="hero__img-container">
            <img src="./gg.png" class="hero__img w-100">
          </div>
        </div>
      </div>
    </div>
  </header>
  <div id="features" class="block-11 space-between-blocks">
    <div class="container">
      <div class="block__header col-lg-8 col-xl-7 mx-auto text-center">
        <h1 class="block__title mb-3">Features</h1>
        <p class="block__paragraph mb-0">
          Some features about our system
        </p>
      </div>
      <div class="row align-items-center justify-content-center flex-column-reverse flex-lg-row px-2">
        <div class="col-lg-8 col-xl-6">
          <div class="row">
            <div class="col-md-6 mb-2-1rem">
              <div class="card-1 card-1--selected text-center">
                <span class="card-1__symbol mx-auto mb-4">
                  <i class="fa fa-rocket"></i>
                </span>
                <h3 class="card-1__title mb-2">Fast Transactions</h3>
                <p class="card-1__paragraph">
                  With our infrastructure designed without using unnecessary codes and our API connection, we provide you with a split-second response.
                </p>
              </div>
            </div>
            <div class="col-md-6 mb-2-1rem">
              <div class="card-1 text-center">
                <span class="card-1__symbol mx-auto mb-4">
                  <i class="fa fa-user-secret"></i>
                </span>
                <h3 class="card-1__title mb-2">Your safety is important to us</h3>
                <p class="card-1__paragraph">
                  Stress tests are started from multiple places (dedicated servers) and cannot be monitored. Your privacy is safe with us, no logs are kept and all data is encrypted.
                </p>
              </div>
            </div>
            <div class="col-md-6 mb-2-1rem">
              <div class="card-1 text-center">
                <span class="card-1__symbol mx-auto mb-4">
                  <i class="fa fa-life-ring"></i>
                </span>
                <h3 class="card-1__title mb-2">Our support team is with you 24/7</h3>
                <p class="card-1__paragraph">
                  Our support is here to help you, if you need anything you can contact them.
                </p>
              </div>
            </div>
            <div class="col-md-6 mb-2-1rem">
              <div class="card-1 text-center">
                <span class="card-1__symbol mx-auto mb-4">
                  <i class="fa fa-bolt"></i>
                </span>
                <h3 class="card-1__title mb-2">Possibility of high power with our own special methods</h3>
                <p class="card-1__paragraph">
                  Our ddos attack methods are capable of bypassing the latest protections.
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-xl-5 p-lg-5">
          <img class="w-100" src="img/home.png">
        </div>
      </div>
    </div>
  </div>
  <div class="block-32 space-between-blocks">
    <div class="container">
      <div class="col-lg-8 col-xl-7 mx-auto text-center mb-5">
        <h1 class="block__title mb-3">Join us</h1>
        <p class="block__paragraph mb-0">
          A reliable Booter and Web Stresser, ran by experienced in DDoS area.We are capable of providing the best DDoS for hire service of the century with an attack power that will never seen in any other Stresser.
        </p>
      </div>
      <div class="text-center">
        <a href="/panel/register" class="btn btn-primary">Sign Up</a>
      </div>
    </div>
  </div>
  <div id="pricing" class="block-39 space-between-blocks">
    <div class="container">
      <div class="col-lg-8 col-xl-7 mx-auto text-center mb-5">
        <h1 class="block__title">Pricing</h1>
      </div>
      <div class="row px-2">

        <div class="col-lg-4">
          <div class=" fiyat">
            <h4 class="content-block__title">
              <b>Free Package</b><br>
              <b>€0 / Lifetime</b>
            </h4>
            <p class="content-block__paragraph"><br>
              Max. Stress Time: <b>60</b><br><br>
              Concurrents: <b>1</b><br><br>
              Premium Network: <b><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle">
                  <circle cx="12" cy="12" r="10"></circle>
                  <line x1="15" y1="9" x2="9" y2="15"></line>
                  <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg></b><br><br>
              <a href="/panel/login" class="btn btn-primary">Buy it!</a><br><br>
            </p>
          </div>
        </div>

        <div class="col-lg-4">
          <div class=" fiyat">
            <h4 class="content-block__title">
              <b>Advanced</b><br>
              <b>€25 / Monthly</b>
            </h4>
            <p class="content-block__paragraph"><br>
              Max. Stress Time: <b>360</b><br><br>
              Concurrents: <b>2</b><br><br>
              Premium Network: <b><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle">
                  <circle cx="12" cy="12" r="10"></circle>
                  <line x1="15" y1="9" x2="9" y2="15"></line>
                  <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg></b><br><br>
              <a href="/panel/login" class="btn btn-primary">Buy it!</a><br><br>
            </p>
          </div>
        </div>

        <div class="col-lg-4">
          <div class=" fiyat">
            <h4 class="content-block__title">
              <b>High Level</b><br>
              <b>€45 / Monthly</b>
            </h4>
            <p class="content-block__paragraph"><br>
              Max. Stress Time: <b>560</b><br><br>
              Concurrents: <b>2</b><br><br>
              Premium Network: <b><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle">
                  <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                  <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg></b><br><br>
              <a href="/panel/login" class="btn btn-primary">Buy it!</a><br><br>
            </p>
          </div>
        </div>



      </div>
    </div>
  </div>
  <div id="faq" class="block-39 space-between-blocks">
    <div class="container">
      <div class="col-lg-8 col-xl-7 mx-auto text-center mb-5">
        <h1 class="block__title">Frequently Asked Questions</h1>
      </div>
      <div class="row px-2">
        <div class="col-lg-6">
          <div class="content-block">
            <h4 class="content-block__title">
              What is a stresser/booter ?
            </h4>
            <p class="content-block__paragraph">
              An IP stresser is a tool designed to test a network or server for robustness. The administrator may run a stress test in order to determine whether the existing resources (bandwidth, CPU, etc.) are sufficient to handle additional load.
            </p>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="content-block">
            <h4 class="content-block__title">
              How long does it take to activate my package?
            </h4>
            <p class="content-block__paragraph">
              IP Stresser offers automated services, after coinpayments declares the payment as "complete" it usually takes another 10-30 minutes for you to receive your purchased package.
            </p>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="content-block">
            <h4 class="content-block__title">
              What is the difference between Premium and Non-Premium?
            </h4>
            <p class="content-block__paragraph">
              Premium plans usually get an average of 60% more power than regular packages. Premium plans also gives customers priority support service. And they can use special methods prepared for Premium.
            </p>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="content-block">
            <h4 class="content-block__title">
              Can i share my account with a friend?
            </h4>
            <p class="content-block__paragraph">
              Based on IP Stresser terms and conditions, you cannot share your account or sell your account to anyone. If the system detects such an account, it will auto-ban the account and you will loose access to your package.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="block-44 py-5">
    <div class="container">
      <div class="row flex-column flex-md-row px-2 justify-content-center">
        <p class="block-41__copyrights">&copy; <?php echo date("Y"); ?> <?php echo $ayar["ad"]; ?> All rights Reserved.</p>
        <div class="flex-grow-1">
          <div class="right">
            <a href="https://t.me/stresser_gg" target="_blank"><i class="fab fa-telegram-plane"></i> Telegram</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    window.smoothScroll = function(target) {
      var scrollContainer = target;
      do {
        scrollContainer = scrollContainer.parentNode;
        if (!scrollContainer) return;
        scrollContainer.scrollTop += 1;
      } while (scrollContainer.scrollTop == 0);

      var targetY = 0;
      do {
        if (target == scrollContainer) break;
        targetY += target.offsetTop;
      } while (target = target.offsetParent);

      scroll = function(c, a, b, i) {
        i++;
        if (i > 30) return;
        c.scrollTop = a + (b - a) / 30 * i;
        setTimeout(function() {
          scroll(c, a, b, i);
        }, 20);
      }
      scroll(scrollContainer, scrollContainer.scrollTop, targetY, 0);
    }
  </script>
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="https://kit.fontawesome.com/b5170af4d1.js" crossorigin="anonymous"></script>
</body>

</html>