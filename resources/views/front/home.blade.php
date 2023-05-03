<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="M_Adnan">
    <link rel="shortcut icon" href="/front/images/favicon1.png">
    <title>FlowTC DEX</title>

    <!-- Bootstrap Core CSS -->
    <link href="/front/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="/front/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <!-- Custom CSS -->
    <link href="/front/assets/css/main.css" rel="stylesheet">
    <link href="/front/assets/css/style1.css" rel="stylesheet">
    <link href="/front/assets/css/responsive.css" rel="stylesheet">
    <link href="/front/assets/css/flaticon.css" rel="stylesheet">
    <link href="/front/assets/css/ionicons.min.css" rel="stylesheet">

    <!-- JavaScripts -->
    <script src="js/modernizr.js"></script>

    <!-- Online Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Merriweather:300,400,700,900|Montserrat:300,400,500,600,700,800" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    </head>
<body>

<!-- LOADER -->
<div id="loader">
  <div class="position-center-center">
    <div class="ldr"></div>
  </div>
</div>

<!-- Wrap -->
<div id="wrap"> 
  
  <!-- header -->
  <header class="sticky">
    <div class="container"> 
      
      <!-- Logo -->
      <div class="logo"> <a href="/"><img class="img-responsive" src="/front/images/logo1.png" alt="" ></a> </div>
      <nav class="navbar ownmenu navbar-expand-lg ">
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="nav">
            <li class="scroll active"><a href="#hme">Home</a></li>
            <li class="scroll"> <a href="#about">About </a> </li>
            <li class="scroll"> <a href="#token">OTC Market</a> </li>
            <li class="scroll"> <a href="#activity">Activity</a> </li>
            <li class="scroll"> <a href="#team">Team</a> </li>
            @if(auth()->check())
            <ul class="menu-btns">
                <li><a href="{!! url('/logout'); !!}" class="btn btn-md btn-round btn-thin btn-outline btn-primary btn-auto no-change" style="width:90px"><span>Logout</span></a></li>
            </ul>
            @else
            <ul class="menu-btns">
                @if(!isset($referral_code))
                    <li><a href="{!! url('/login'); !!}" class="btn btn-md btn-round btn-thin btn-primary btn-auto no-change" style="width:90px"><span>Login</span></a></li>
                @endif
                @if(isset($referral_code))
                <li><a href="{!! url('/register/'.$referral_code); !!}" class="btn btn-md btn-round btn-thin btn-outline btn-primary btn-auto no-change" style="width:90px"><span>SignUp</span></a></li>
                @else
                <li><a href="{!! url('/register'); !!}" class="btn btn-md btn-round btn-thin btn-outline btn-primary btn-auto no-change" style="width:90px"><span>SignUp</span></a></li>
                @endif
            </ul>
            @endif
          </ul>
        </div>
      </nav>
      
    </div>
    <div class="clearfix"></div>
  </header>
  
  <!-- HOME MAIN  -->
  <section class="simple-head" data-stellar-background-ratio="0.5" id="hme"> 
    <!-- Particles -->
    <div id="particles-js"></div>
    <div class="position-center-center">
      <div class="container text-center">
        <h1>Effortless Crypto-to-Crypto OTC Trading Platform With Zero Market Impact</h1>
        <p>Discover the ultimate solution for anonymous crypto-to-crypto OTC trading. Our platform integrates both centralized and decentralized exchanges, ensuring a seamless trading experience without affecting market prices. Place your trade request and enjoy unmatched security and privacy. Join now and revolutionize your digital asset trading experience.</p>
        <!-- <a href="#." class="btn">Join Us</a> <a href="#." class="btn btn-inverse">View White Paper</a> </div> -->
    </div>
  </section>
  
  <!-- Content -->
  <div id="content"> 
    
    <!-- Why Choose Us -->
    <section class="why-choose padding-top-150 padding-bottom-150" id="about">
      <div class="container"> 
        
        <!-- Why Choose Us  ROW-->
        <div class="row">
          <div class="col-md-7 margin-top-60"> 
            
            <!-- Tittle -->
            <div class="heading margin-bottom-20">
              <h6 class="margin-bottom-10">The world’s only enterprise blockchain solution for global payments</h6>
              <h4>Introduction (30-40 words)</h4>
            </div>
            <p>Welcome to our high-volume Anonymous Crypto OTC Market, where we facilitate seamless crypto-to-crypto transactions daily.Experience unmatched efficiency and privacy in a secure trading environment.</p>
            <p>a. Seamless Integration: Our platform unifies centralized and decentralized exchanges, providing an effortless trading experience without impacting market prices.</p>

            <p>b. Anonymity and Security: We prioritize your privacy and security, offering a discreet and encrypted trading platform for all crypto-to-crypto transactions.</p>

            <p>c. Huge Daily Trading Volume: Our platform connects to over 50 verified exchange accounts and has a capability of doing up to 20000BTC daily trading volume.</p>

            <div class="ultra-ser"> <span><span class="name"> Flowtc.vip &nbsp; - &nbsp;</span> <span>Ceo/Founder Chain</span></span> </div>
            <a class="vid-btn margin-top-30 popup-youtube" href="https://www.youtube.com/watch?v=7e90gBu4pas"><i class="fas fa-play-circle"></i> Watch Video <br>
            <span>How it work</span></a> </div>
          
          <!-- Image -->
          <div class="col-md-5 text-right"> <img src="/images/chain-img.png" alt="Why Choose Us Image" > </div>
        </div>
        
        <!-- Services ROW -->
        <div class="row"> 
          
          <!-- Services -->
          <div class="col-md-4">
            <div class="ib-icon"> <i class="flaticon-smartphone"></i> </div>
            <div class="ib-info">
              <h4 class="h6">Peer-to-Peer Transactions</h4>
              <p>Contrary to popular belief , Lorem Ipsum is not simply random text. It has roots in a piece</p>
            </div>
          </div>
          
          <!-- Services -->
          <div class="col-md-4">
            <div class="ib-icon"> <i class="flaticon-flat-world-map"></i> </div>
            <div class="ib-info">
              <h4 class="h6">Borderless Payments</h4>
              <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem not simply random accusantium</p>
            </div>
          </div>
          
          <!-- Services -->
          <div class="col-md-4">
            <div class="ib-icon"> <i class="flaticon-secure-shield"></i> </div>
            <div class="ib-info">
              <h4 class="h6">Fully Protection</h4>
              <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece</p>
            </div>
          </div>
          
          <!-- Services -->
          <div class="col-md-4">
            <div class="ib-icon"> <i class="flaticon-credit-card"></i> </div>
            <div class="ib-info">
              <h4 class="h6">Smart Money</h4>
              <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium</p>
            </div>
          </div>
          
          <!-- Services -->
          <div class="col-md-4">
            <div class="ib-icon"> <i class="flaticon-wallet"></i> </div>
            <div class="ib-info">
              <h4 class="h6">Secure Wallet</h4>
              <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece</p>
            </div>
          </div>
          
          <!-- Services -->
          <div class="col-md-4">
            <div class="ib-icon"> <i class="flaticon-money"></i> </div>
            <div class="ib-info">
              <h4 class="h6">Easy To buy & Sell</h4>
              <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Token Distribution -->
    <section class="distri drk padding-top-150 padding-bottom-150 " id="token">
      <div class="container">
        <div class="row"> 
          
          <!-- Token  -->
          <div class="col-lg-7">
            <h3>OTC Market Distribution</h3>
            <p>FlowTC Crypto token will be released on the basis of Ethereum and Bitocin platform. It’s compatibility of the token with third-party services wallets, exchanges etc, and provides easy-to-use integration.</p>
            
            <!-- Progress -->
            <div class="progress">
              <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="150"><span>9,000,000 <small>50%</small></span> </div>
            </div>
            <div class="row">
              <div class="col">
                <h6> Now Distribution</h6>
                <span>2,000,000</span> </div>
              <div class="col">
                <h6> 99,910</h6>
                <span>ETH Received</span> </div>
              <div class="col">
                <h6> 99,910</h6>
                <span>BTC Received</span> </div>
            </div>
            
            <!-- CountdownEnd -->
            <div class="countdown">
              <h6>Current Distribution Section End  150/350</h6>
              <!-- Countdown-->
              <ul class="row">
                <!-- Days -->
                <li class="col-md-3">
                  <article> <span class="days">00</span>
                    <p class="days_ref">Days</p>
                  </article>
                </li>
                <!-- Hours -->
                <li class="col-md-3">
                  <article> <span class="hours">00</span>
                    <p class="hours_ref">Hours</p>
                  </article>
                </li>
                <!-- Mintes -->
                <li class="col-md-3">
                  <article><span class="minutes">00</span>
                    <p class="minutes_ref">Minutes</p>
                  </article>
                </li>
                <!-- Seconds -->
                <li class="col-md-3">
                  <article><span class="seconds">00</span>
                    <p class="seconds_ref">Seconds</p>
                  </article>
                </li>
              </ul>
            </div>
          </div>
          
          <!-- Total Distribution -->
          <div class="col-lg-5">
            <h3>Total Distribution Section End <b>350/350</b></h3>
            <p>FlowTC Crypto token will be released on the basis of Ethereum and Bitocin platform.</p>
            <div class="countdown-all"> 
              
              <!-- Countdown -->
              <ul class="row">
                <!-- Days -->
                <li class="col-md-3">
                  <article> <span class="days">00</span>
                    <p class="days_ref">Days</p>
                  </article>
                </li>
                <!-- Hours -->
                <li class="col-md-3">
                  <article> <span class="hours">00</span>
                    <p class="hours_ref">Hours</p>
                  </article>
                </li>
                <!-- Mintes -->
                <li class="col-md-3">
                  <article><span class="minutes">00</span>
                    <p class="minutes_ref">Minutes</p>
                  </article>
                </li>
                <!-- Seconds -->
                <li class="col-md-3">
                  <article><span class="seconds">00</span>
                    <p class="seconds_ref">Seconds</p>
                  </article>
                </li>
              </ul>
              <a href="#." class="btn">Join Us</a> <a href="#." class="btn btn-inverse">Buy Now</a> 
              
              <!-- Buy Option -->
              <div class="card-info"> <i class="fab  fa-bitcoin"></i> <i class="fab  fa-cc-discover"></i> <i class="fab  fa-cc-visa"></i> <i class="fab  fa-cc-mastercard"></i> </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Development -->
    <section class="dev-activ text-center padding-top-150 padding-bottom-150" id="activity">
      <div class="container">
        <div class="sm-intro">
          <h2>Development Activity</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas nibh dolor, efficitur eget pharetra ac, cursus sed sapien. Cras posuere ligula ut blandit varius. </p>
        </div>
        <ul class="row margin-top-50 margin-bottom-50">
          <li class="col"> <i class="flaticon-rotate"></i> <span><span class="counter">4</span> hrs Ago</span>
            <p>Last Update</p>
          </li>
          <li class="col"><i class="flaticon-building"></i> <span><span class="counter">10</span> Days Ago</span>
            <p>Last Block Found</p>
          </li>
          <li class="col"><i class="flaticon-money-1"></i> <span><span class="counter">45057</span>+</span>
            <p>Contributions</p>
          </li>
          <li class="col"><i class="flaticon-team"></i> <span  class="counter">80</span>
            <p>Team Members</p>
          </li>
        </ul>
        <!-- <a href="#." class="btn">Start on GitHub</a> <a href="#." class="btn btn-inverse">White Paper</a> </div> -->
    </section>
    
    <!-- ABOUT -->
    <section class="about light-bg"> 
      <!-- Right Background -->
      <div class="main-page-section half_left_layout">
        <div class="main-half-layout half_right_layout"> </div>
        
        <!-- Left Content -->
        <div class="main-half-layout-container half_right_layout">
          <div class="about-us-con">
            <h3>Growing Global Network</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas nibh dolor, efficitur eget pharetra ac, cursus sed sapien. Cras posuere ligula ut blandit varius. </p>
            <ul class="count-info row">
              <li class="col"> <span class="counter">5000</span><span>+</span>
                <p>Customers</p>
              </li>
              <li class="col"> <span class="counter">750</span><span>+</span>
                <p>Deploying</p>
              </li>
            </ul>
            <!-- <a href="#." class="btn">White Paper</a> <a href="#." class="btn btn-inverse">Find an Exchange</a> </div> -->
        </div>
      </div>
    </section>
    
    <!-- Team Members -->
    <section class="team style-2 padding-top-150 padding-bottom-150" id="team">
      <div class="container">
        <div class="heading text-center">
          <h2>Meet our Core Team</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas nibh dolor, efficitur eget pharetra ac, cursus sed sapien. Cras posuere ligula ut blandit varius. </p>
        </div>
        <ul class="team-small">
          <li><img  src="/members/Arman-Stepanyan.png" alt=""><a class="hover" href="#.">Arman Stepanyan</a></li>
          <li><img  src="/members/Kevin-McNamara.png" alt=""><a class="hover" href="#.">Kevin McNamara</a></li>
          <li><img  src="/members/Samvel-Barseghyan.png" alt=""><a class="hover" href="#.">Samvel Barseghyan </a></li>
          
      </ul>
      </div>
    </section>
    
    <!-- Team Members -->
    <section class="light-bg padding-top-150 padding-bottom-150" id="team">
      <div class="container">
        <div class="heading text-center">
          <h2>Frequently asked questions</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas nibh dolor, efficitur eget pharetra ac, cursus sed sapien. Cras posuere ligula ut blandit varius. </p>
        </div>
        <!-- FAQS -->
        <div class="row">
          <div class="col-md-6"> 
            
            <!-- According Style 1 -->
            <div class="panel-group accordion" id="accordion"> 
              
              <!-- According 1 -->
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="collapsed"> What is FlowTC ?</a> </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                  <div class="panel-body"> There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas nibh dolor, efficitur eget pharetra ac, cursus sed sapien. Cras posuere ligula ut blandit varius. </div>
                </div>
              </div>
              
              <!-- According 2 -->
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed"> Why The Best FlowTC BlockChain</a> </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse">
                  <div class="panel-body"> There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some </div>
                </div>
              </div>
              
              <!-- According 3 -->
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="collapsed"> What is FlowTC Blockchain</a> </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse">
                  <div class="panel-body"> There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some </div>
                </div>
              </div>
              
              <!-- According 4 -->
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapsefour" class="collapsed"> Best Crypto in this world</a> </h4>
                </div>
                <div id="collapsefour" class="panel-collapse collapse">
                  <div class="panel-body"> There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6"> 
            
            <!-- According Style 1 -->
            <div class="panel-group accordion" id="accordion"> 
              
              <!-- According 1 -->
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne-1" class="collapsed"> Our Mission</a> </h4>
                </div>
                <div id="collapseOne-1" class="panel-collapse collapse">
                  <div class="panel-body"> There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some </div>
                </div>
              </div>
              
              <!-- According 2 -->
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo-1" class="collapsed"> Our Services</a> </h4>
                </div>
                <div id="collapseTwo-1" class="panel-collapse collapse">
                  <div class="panel-body"> There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some </div>
                </div>
              </div>
              
              <!-- According 3 -->
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree-1" class="collapsed"> Block Chain Into</a> </h4>
                </div>
                <div id="collapseThree-1" class="panel-collapse collapse">
                  <div class="panel-body"> There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some </div>
                </div>
              </div>
              
              <!-- According 4 -->
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapsefour-1" class="collapsed"> Crypto Currency FAQS</a> </h4>
                </div>
                <div id="collapsefour-1" class="panel-collapse collapse">
                  <div class="panel-body"> There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Join our community -->
    <section class="community-sec padding-top-150 padding-bottom-150">
      <div class="container">
        <div class="row">
          <div class="col">
            <div class="sm-intro">
              <h2>Join our community</h2>
              <ul class="socials">
                <li><a href="#."><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="#."><i class="fab fa-twitter"></i></a></li>
                <li><a href="#."><i class="fab fa-github"></i></a></li>
                <li><a href="#."><i class="fab fa-telegram"></i></a></li>
                <li><a href="#."><i class="fab fa-gitter"></i></a></li>
                <li><a href="#."><i class="fab fa-instagram"></i></a></li>
                <li><a href="#."><i class="fab fa-linkedin"></i></a></li>
                <li><a href="#."><i class="fab fa-youtube"></i></a></li>
              </ul>
            </div>
          </div>
          <div class="col">
            <div class="news-letter">
              <h2>Subscribe to our newsletter</h2>
              <form>
                <input type="email" placeholder="Enter your email address" required>
                <button type="submit">SEND</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>

<!-- GO TO TOP --> 
	<a href="#" class="cd-top"><i class="ion-chevron-up"></i></a> 
<!-- GO TO TOP End --> 

<!-- Script --> 
<script src="js/jquery-1.11.3.min.js"></script> 
<script src="js/bootstrap.bundle.js"></script> 
<script src="js/particles.min.js"></script> 
<script src="js/jquery.counterup.min.js"></script> 
<script src="js/jquery.sticky.js"></script> 
<script src="js/jquery.magnific-popup.min.js"></script> 
<script src="js/main.js"></script>
</body>
</html>