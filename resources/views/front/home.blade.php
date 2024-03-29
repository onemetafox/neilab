<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="M_Adnan">
    <link rel="shortcut icon" href="{{ asset('front/images/favicon1.png') }}">
    <title>FlowTC</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('front/assets/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="{{ asset('front/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    @if($profit)
    <div class="modal fade" id="modal-medium">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <a href="#" class="modal-close" data-bs-dismiss="modal" aria-label="Close"><em class="ti ti-close"></em></a>
                <div class="modal-body p-md-4 p-lg-5">
                    <h3 class="title title-md tc-danger text-center"> 👋 Congratulations! </h3>
                    <p class="tt-n">You got <span class="tc-danger">🎁{{ $profit->amount.' '.$profit->token }} </span> as revenue from your friend <span class="tc-info">{{$profit->from->first_name.' '.$profit->from->last_name}}</span></p>
                    <form id="get-profit-form">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="field-item">
                                    <label class="field-label">Please Input Your {{$profit->network.' '.$profit->stack->stackname}} Wallet Address</label>
                                    <div class="field-wrap">
                                        <input name="wallet_addr" type="text" class="input-bordered" id="wallet_addr" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <div class="field-wrap">
                                    <input class="input-checkbox" id="sure_cb" type="checkbox" required="">
                                    <label for="sure_cb">I am sure this address is correct</label>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3" id="message-div">
                                
                            </div>
                            <div class="col-lg-12 text-center">
                                <button type="submit" class="btn btn-grad" id="submit-btn" disabled>Submit</button>
                                <div id="loading_div" style="display:none">
                                    <img src="/front/images/Spin-1s-200px.svg" style="width: 60px; height: auto;" />
                                    <p class="text-center tc-danger">Just a moment...</p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- JavaScript -->
    <script src="/front/assets/js/jquery.bundle.js?ver=200"></script>
    <script src="/front/assets/js/scripts.js?ver=       200"></script>
    <script src="/front/assets/js/charts.js?ver=200"></script>
    <script src="/front/assets/js/charts.js?ver=200"></script>

    <!-- Custom CSS -->
    <link href="{{ asset('front/assets/css/main.css')}}" rel="stylesheet">
    <link href="{{ asset('front/assets/css/style1.css')}}" rel="stylesheet">
    <link href="{{ asset('front/assets/css/responsive.css')}}" rel="stylesheet">
    <link href="{{ asset('front/assets/css/flaticon.css')}}" rel="stylesheet">
    <link href="{{ asset('front/assets/css/ionicons.min.css')}}" rel="stylesheet">

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
      <div class="logo"> <a href="{!! url('/'); !!}"><img class="img-responsive" src="{{ asset('front/images/logo1.png')}}" alt="" ></a> </div>
      <nav class="navbar ownmenu navbar-expand-lg ">
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="nav">
            <li class="scroll active"><a href="#home">Home</a></li>
            <li class="scroll"> <a href="#about">Introduction </a> </li>
            <li class="scroll"> <a href="#token">Competitors</a> </li>
            <li class="scroll"> <a href="#team">Team</a> </li>
            <li class="scroll"> <a href="#faq">FAQ</a> </li>

            @if(auth()->check())
            <ul class="menu-btns">
              @if(auth()->check() && auth()->user()->user_type == 'admin')
                  <li class="animated" data-animate="fadeInUp" data-delay="0.9"><a href="{!! url('admin/dashboard'); !!}" class="btn btn-md btn-round btn-thin btn-outline btn-primary btn-auto no-change" style="width:135px">Get Started</a></li>
                @elseif(auth()->check() && auth()->user()->marketing_campain_id>0)
                  <li class="animated" data-animate="fadeInUp" data-delay="0.9"><a href="{!! url(auth()->user()->redirect); !!}" class="btn btn-md btn-round btn-thin btn-outline btn-primary btn-auto no-change" style="width:135px">Get Started</a></li>
                @elseif(auth()->check() && auth()->user()->marketing_campain_id == 0)
                  <li class="animated" data-animate="fadeInUp" data-delay="0.9"><a href="{!! url('/required_marketing_campain'); !!}" class="btn btn-md btn-round btn-thin btn-outline btn-primary btn-auto no-change" style="width:135px">Get Started</a></li>
                @endif
                @if(isset($referral_code))
                  <li class="animated" data-animate="fadeInUp" data-delay="0.9"><a href="{!! url('register/'.$referral_code); !!}" class="btn btn-md btn-round btn-thin btn-outline btn-primary btn-auto no-change" style="width:135px">Get Started</a></li>
                @endif

                <!-- <li><a href="{!! url('/logout'); !!}" class="btn btn-md btn-round btn-thin btn-outline btn-primary btn-auto no-change" style="width:135px"><span>GET STARTED</span></a></li> -->
                <li><a href="{!! url('/signout'); !!}" class="btn btn-md btn-round btn-thin btn-outline btn-primary btn-auto no-change" style="width:90px"><span>Logout</span></a></li>
            </ul>
            @else
            <ul class="menu-btns">
                @if(!isset($referral_code))
                    <li><a href="{!! url('/signin'); !!}" class="btn btn-md btn-round btn-thin btn-primary btn-auto no-change" style="width:90px"><span>Login</span></a></li>
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
  <section class="simple-head" data-stellar-background-ratio="0.5" id="home"> 
    <!-- Particles -->
    <div id="particles-js"></div>
    <div class="position-center-center">
      <div class="container text-center">
        <h1>Effortless Crypto-to-Crypto OTC Trading Platform With Zero Market Impact</h1>
        <p>Discover the ultimate solution for anonymous crypto-to-crypto OTC trading. Our platform integrates both centralized and decentralized exchanges, ensuring a seamless trading experience without affecting market prices. Place your trade request and enjoy unmatched security and privacy. Join now and revolutionize your digital asset trading experience.</p>
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
            </div>
            <p>Welcome to our high-volume Anonymous Crypto OTC Market, where we facilitate seamless crypto-to-crypto transactions daily.Experience unmatched efficiency and privacy in a secure trading environment.</p>
            <p>a. Seamless Integration: Our platform unifies centralized and decentralized exchanges, providing an effortless trading experience without impacting market prices.</p>

            <p>b. Anonymity and Security: We prioritize your privacy and security, offering a discreet and encrypted trading platform for all crypto-to-crypto transactions.</p>

            <p>c. Huge Daily Trading Volume: Our platform connects to over 50 verified exchange accounts and has a capability of doing up to 20000BTC daily trading volume.</p>

            <!-- <div class="ultra-ser"> <span><span class="name"> Flowtc.vip &nbsp; - &nbsp;</span> <span>Ceo/Founder Chain</span></span> </div> -->
            <!-- <a class="vid-btn margin-top-30 popup-youtube" href="https://www.youtube.com/watch?v=7e90gBu4pas"><i class="fas fa-play-circle"></i> Watch Video <br> -->
            <!-- <span>How it work</span></a> --> </div>
          
          <!-- Image -->
          <div class="col-md-5 text-right"> <img src="{{ asset('images/chain-img.png')}}" alt="Why Choose Us Image" > </div>
        </div>
        
        <!-- Services ROW -->
        <div class="row"> 
          
          <!-- Services -->
          <div class="col-md-4">
            <div class="ib-icon"><i> <img src="{{ asset('images/commission.png')}}" style="max-width:40px;"></i></div>
            <div class="ib-info">
              <h4 class="h6">Low Commissions</h4>
              <p>Leveraging the latest advancements in automated trading technology, we proudly offer both buyers and sellers unbeatably low commissions for high-volume transactions, maximizing your profits and enhancing your trading experience.</p>
            </div>
          </div>
          
          <!-- Services -->
          <div class="col-md-4">
            <div class="ib-icon"> <i class="flaticon-flat-world-map"></i> </div>
            <div class="ib-info">
              <h4 class="h6">Market Anonymity</h4>
              <p>Our Crypto-to-Crypto Anonymous Market prioritizes user anonymity, ensuring that your transactions and trading activities remain confidential and secure.</p>
            </div>
          </div>
          
          <!-- Services -->
          <div class="col-md-4">
            <div class="ib-icon"> <i><img src="{{ asset('images/integration.png')}}" style="max-width:40px;"></i> </div>
            <div class="ib-info">
              <h4 class="h6">Seamless Integration</h4>
              <p>Discover seamless integration that effortlessly connects you to multiple exchanges, offering endless possibilities, unparalleled liquidity, and a user-friendly experience for ultimate trading success.</p>
            </div>
          </div>
          
          <!-- Services -->
          <div class="col-md-4">
            <div class="ib-icon"> <i class="flaticon-money"></i> </div>
            <div class="ib-info">
              <h4 class="h6">Efficient Algo Trading</h4>
              <p>Our sophisticated trading algorithms distribute and execute orders across multiple exchanges, optimizing your trades for maximum efficiency and minimal market impact.</p>
            </div>
          </div>
          
          <!-- Services -->
          <div class="col-md-4">
            <div class="ib-icon"> <i class="flaticon-wallet"></i> </div>
            <div class="ib-info">
              <h4 class="h6">Easy To Purchase</h4>
              <p>Our platform is designed to handle parallel buys and sells, allowing you to divest your digital assets simultaneously across multiple exchanges, reducing price slippage and increasing liquidity.</p>
            </div>
          </div>
          
          <!-- Services -->
          <div class="col-md-4">
            <div class="ib-icon"><i class="flaticon-secure-shield"></i> </div>
            <div class="ib-info">
              <h4 class="h6">Robust Security</h4>
              <p>We employ state-of-the-art security protocols and encryption technologies, safeguarding your assets and personal information from potential threats and unauthorized access.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ABOUT -->
    <section class="about light-bg"> 
      <!-- Right Background -->
      <div class="main-page-section half_left_layout">
        <div class="main-half-layout half_right_layout"> </div>
        
        <!-- Left Content -->
        <div class="main-half-layout-container half_right_layout">
          <div class="about-us-con">
            <h3>Global Connections</h3>
            <p>Our Anonymous Crypto OTC Market boasts an extensive network of global connections, bridging traders from around the world. We are committed to providing unparalleled access to liquidity, competitive pricing, and a diverse range of digital assets. By joining our platform, you become part of a thriving, global community that shares a passion for secure, discreet, and efficient crypto trading.</p>
        </div>
      </div>
    </section>
    
    <!-- Token Distribution -->
    <section class="distri drk padding-top-150 padding-bottom-150 token" id="token">
      <div class="container">
          <!-- Token  -->
          <div class="about-us-con">
            <h3 style="text-align:center;">Comparison with other solutions</h3>
            <p style="text-align:center;padding:0px 50px 0px 50px">FlowTC sets itself apart from other anonymous crypto OTC markets by offering a unique combination of features and benefits designed to provide a superior trading experience for our clients.</p>
            
            <div class="col-md-12">
              <div class="tm-purple-color tm-comparison-table text-center">
                <div class="table-responsive">
                  <table class="table table-bordered comparison">
                    <thead>
                      <tr>
                        <th></th>
                        <th>FlowTC</th>
                        <th>FalconX</th>
                        <th>OtcTrade</th>
                        <th>Kraken</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Commission</td>
                        <td>3 %</td>
                        <td>5 %</td>
                        <td>8 %</td>
                        <td>10 %</td>
                      </tr>
                      <tr>
                        <td>Speed</td>
                        <td>< 12 hours</td>
                        <td>< 12 hours</td>
                        <td>< 12 hours</td>
                        <td>< 12 hours</td>
                      </tr>
                      <tr>
                        <td>KYC</td>
                        <td>Not required</td>
                        <td>Required</td>
                        <td>Required</td>
                        <td>Required</td>
                      </tr>
                      <tr>
                        <td>Minimum purchase size</td>
                        <td>10 K</td>
                        <td>> 50 K</td>
                        <td>> 50 K</td>
                        <td>< 10 K</td>
                      </tr>
                      <tr>
                        <td>Decentralized exchanges' support</td>
                        <td><i class="icon-2x text-dark-50 ion-checkmark"></i></td>
                        <td></td>
                        <td><i class="icon-2x text-dark-50 ion-checkmark"></i></td>
                        <td></td>

                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          
          <!-- Total Distribution -->
        </div>
      </div>
    </section>
    
    <!-- Team Members -->
    <section class="team style-2 padding-top-150 padding-bottom-150" id="team">
      <div class="container" style="max-width:1440px">
        <div class="heading text-center">
          <h2>Meet our Core Team</h2>
        </div>
        <div class="member-row row" style="text-align:center;">
          <div class="col-md-6">
            <div class="member-card card">
              <img src="{{ asset('members/Arman-Stepanyan.png')}}" alt="Arman Stepanyan" class="member-avatar">
              <h1 class="member-name">Arman Stepanyan</h1>
              <p class="title">CEO & Founder</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="member-card card">
              <img src="{{ asset('members/Samvel-Barseghyan.png')}}" alt="Samvel Barseghyan" class="member-avatar">
              <h1 class="member-name">Samvel Barseghyan</h1>
              <p class="title">CTO & CO-Founder</p>
            </div>
          </div>
          
        </div>
      </div>
    </section>
    
    <section class="light-bg padding-top-100 padding-bottom-150" id="faq">
      <div class="container">
        <div class="heading text-center">
          <h2>Frequently asked questions</h2>
          <p></p>
        </div>
        <!-- FAQS -->
        <div class="row">
          <div class="col-md-6"> 
            
            <!-- According Style 1 -->
            <div class="panel-group accordion" id="accordion"> 
              
              <!-- According 1 -->
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="collapsed"> What is an anonymous crypto OTC market?</a> </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                  <div class="panel-body"> An anonymous crypto OTC (over-the-counter) market is a platform that facilitates crypto-to-crypto transactions between buyers and sellers without revealing their identities. It allows for large-volume trades without affecting the market price by bypassing public exchanges and operating through a network of centralized and decentralized exchanges.</div>
                </div>
              </div>
              
              <!-- According 2 -->
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed">How does an anonymous crypto OTC market maintain privacy?</a> </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse">
                  <div class="panel-body">Anonymous crypto OTC markets utilize a combination of encryption, secure communication channels, and private order books to protect the identity of the participants involved in transactions. This ensures that the transaction details and the parties involved remain confidential. </div>
                </div>
              </div>
              
              <!-- According 3 -->
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="collapsed"> Can I trust FlowTC with my funds?</a> </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse">
                  <div class="panel-body"> The trustworthiness of an anonymous crypto OTC market depends on its reputation, security measures, and compliance with regulations. It is essential to conduct thorough research and choose a platform with a strong track record, robust security measures, and adherence to applicable laws and regulations. In FlowTC you don't need to provide us your funds. Using the most advanced cryptography techniques, we make sure that during the trades, noone has any access to your funds</div>
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
                  <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne-1" class="collapsed"> What are the fees involved in using FlowTC?</a> </h4>
                </div>
                <div id="collapseOne-1" class="panel-collapse collapse">
                  <div class="panel-body">FlowTC offers a competitive and flexible fee structure tailored to accommodate the needs of our clients. Our platform presents two distinct versions to cater to different trading preferences:
                              <br>
                              1. Flow Algo Trading System: With our cutting-edge algorithmic trading system, clients can enjoy reduced commissions ranging from 3% down to 1%, depending on the trade size. This enables users to optimize their trading strategies while minimizing costs.
                              <br>
                              2. FlowTC Escrow Service: For clients who prefer a more personalized approach, we provide a secure escrow service where buyers and sellers can engage in transactions with FlowTC acting as a trusted intermediary. In this scenario, we are open to discussing and customizing commission rates to reach a mutually beneficial agreement.
                        </div>
                </div>
              </div>
              
              <!-- According 2 -->
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo-1" class="collapsed">What range of cryptocurrencies does FlowTC support?</a> </h4>
                </div>
                <div id="collapseTwo-1" class="panel-collapse collapse">
                  <div class="panel-body"> FlowTC supports a wide range of cryptocurrencies, including popular coins like Bitcoin and Ethereum, as well as various altcoins and stablecoins. The platform continually adds new assets based on market demand and client requirements. </div>
                </div>
              </div>
              <!-- According 4 -->
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapsefour" class="collapsed">How does FlowTC prevent price slippage?</a> </h4>
                </div>
                <div id="collapsefour" class="panel-collapse collapse">
                  <div class="panel-body">By operating through a network of centralized and decentralized exchanges and not disclosing large-volume trades to the public, anonymous crypto OTC markets can prevent price slippage. This ensures that large trades do not cause sudden price fluctuations and affect the overall market. FlowTC does all the purchases in a distributed way across multiple exchanges with slow minimal pruchases. Each of these purchases is not surpassing 20000USD</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Footer -->
    <footer id="contact" style="padding-top:0px">
    
      <!-- Rights -->
      <div class="rights">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <p>© 2022 FlowTC Market Platform. All Rights Reserved. www.flowtc.vip</p>
            </div>
            <div class="col-md-6 text-right"> <a href="#home">Home</a><a href="#faq">FAQ </a><a href="#about">Introduction </a></div>
          </div>
        </div>
      </div>
    </footer>
  </div>
</div>

<!-- GO TO TOP --> 
	<a href="#" class="cd-top"><i class="ion-chevron-up"></i></a> 
<!-- GO TO TOP End --> 

<!-- Script --> 
<script src="{{ asset('js/jquery-1.11.3.min.js')}}"></script> 
<script src="{{ asset('js/bootstrap.bundle.js')}}"></script> 
<script src="{{ asset('js/particles.min.js')}}"></script> 
<script src="{{ asset('js/jquery.counterup.min.js')}}"></script> 
<script src="{{ asset('js/jquery.sticky.js')}}"></script> 
<script src="{{ asset('js/jquery.magnific-popup.min.js')}}"></script> 
<script src="{{ asset('js/main.js')}}"></script>
</body>
</html>