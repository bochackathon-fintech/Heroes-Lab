<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Metis | Banking Battler</title>

    <!-- Styles -->

    <link href="{{url('css/core.min.css')}}" rel="stylesheet">
    <link href="{{url('css/thesaas.css')}}" rel="stylesheet">
    <link href="{{url('css/style.css')}}" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="{{url('images/apple-touch-icon.png')}}">

    <link rel="icon" href="{{url('images/favicon.png')}}">


</head>
<body>

<script>

    window.fbAsyncInit = function() {
        FB.init({
            appId: "134601750423617",
            xfbml: true,
            version: "v2.6"
        });

    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) { return; }
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

</script>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @if (Auth::check())
                <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ url('/login') }}">Login</a>
                <a href="{{ url('/register') }}">Register</a>
            @endif
        </div>
    @endif
    <!-- Navigation -->
        <nav class="topbar topbar-inverse topbar-expand-sm topbar-sticky">
            <div class="container">

                <div class="topbar-left">
                    <button class="topbar-toggler">&#9776;</button>
                    <span class="topbar-brand fs-18 fw-400">
           <a class="logo-default" href="#" style="color: #563d7c">Metis</a>
           <a class="logo-inverse text-white" href="#">Metis</a>
         </span>
                </div>

                <div class="topbar-right">
                    <ul class="topbar-nav nav">
                        <li class="nav-item"><a class="nav-link" href="#">Getting started</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">CSS</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Components</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Javascript</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Customize</a></li>
                    </ul>
                </div>


            </div>
        </nav>
        <!-- END Topbar -->

        <!-- Header -->
        <header class="header header-inverse h-fullscreen p-0 overflow-hidden" data-overlay="7">
            <video class="bg-video" poster="{{url('images/workspace.jpg')}}" autoplay loop>
                <source src="{{url('images/video/workspace.mp4')}}" type="video/mp4">
                <source src="{{url('images/video/workspace.webm')}}" type="video/webm">
            </video>
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-6 align-self-center pb-70">
                            <h1>Managing and controling your financial life before you know it. Literally.</h1>
                            <a href="https://www.messenger.com/t/372522269811171/?messaging_source=source%3Apages%3Amessage_shortlink" class="btn btn-lg btn-round btn-primary shadow-3" target="_blank">Meet Metis</a>
                              </div>
                        <div class="col-12 col-md-6 text-center">
                            <img class="mr-40" src="{{url('images/phone-2.png')}}" alt="..." style="margin-top: 15%;">
                        </div>
                    </div>

                </div>
            </section>

        </header>
        <!-- END Header -->

        <!--
       |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
       | Vertical Tab
       |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
       !-->
        <section class="section">
            <div class="container">
                <header class="section-header">
                    <h2>Meet Metis</h2>
                    <img src="{{url('images/logo5.png')}}">
                    <hr>
                    <p class="lead">The most powerful and personalize banker tailor to your needs.</p>
                </header>



                <div class="row gap-5">


                    <div class="col-12 col-md-4">
                        <ul class="nav nav-vertical">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#home-2">
                                    <h6>Open a bank account</h6>
                                    <p>Some description about tab</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#profile-2">
                                    <h6>Unlock powerful insights</h6>
                                    <p></p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#messages-2">
                                    <h6>Transfer cash in Real-Time</h6>
                                    <p>Some description about tab</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#settings-2">
                                    <h6>High level of trust</h6>
                                    <p>Some description about tab</p>
                                </a>
                            </li>
                        </ul>
                    </div>


                    <div class="col-12 col-md-8 align-self-center">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="home-2">
                                <p class="text-center"><img src="{{url('images/blog-1.jpg')}}" alt="..."></p>
                            </div>

                            <div class="tab-pane fade" id="profile-2">
                                <p class="text-center"><img src="{{url('images/blog-2.jpg')}}" alt="..."></p>
                            </div>

                            <div class="tab-pane fade" id="messages-2">
                                <p class="text-center"><img src="{{url('images/blog-3.jpg')}}" alt="..."></p>
                            </div>

                            <div class="tab-pane fade" id="settings-2">
                                <p class="text-center"><img src="{{url('images/blog-4.jpg')}}" alt="..."></p>
                            </div>

                        </div>
                    </div>


                </div>


            </div>
        </section>

        <!--
                |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
                | Why you should trust us
                |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
                !-->

        <section class="section">
            <div class="container">
                <h2 class="text-center">Why you should use Metis?</h2><br><br>
                <div class="row gap-y text-center">

                    <div class="col-12 col-md-6 col-lg-3">
                        <p class="text-center"><img src="{{url('images/247av.png')}}"></p>
                        <h5>Availability</h5>
                        <p>24 / 7 ease of access</p>
                    </div>


                    <div class="col-12 col-md-6 col-lg-3">
                        <p class="text-center"><img src="{{url('images/analysis.png')}}"></p>
                        <h5>Insights</h5>
                        <p>Get better understanding of your bank statement</p>
                    </div>


                    <div class="col-12 col-md-6 col-lg-3">
                        <p class="text-center"><img src="{{url('images/transfer2.png')}}"></p>
                        <h5>B2B Transfer</h5>
                        <p>Transfer money securely over Blockchain</p>
                    </div>

                </div>
            </div>
        </section>

        <!--
      |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
      | Team
      |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
      !-->
        <section class="section">
            <div class="container">
                <header class="section-header">
                    <h2>Heroes_Lab</h2>
                    <hr>
                    <p class="lead">Meet out team of heroes that make this great product.</p>
                </header>

                <div class="row gap-y">
                    <div class="col-12 col-md-4 team-2">
                        <a href="#">
                            <img src="{{url('images/LG.jpg')}}" alt="...">
                        </a>
                        <h5>George Lambrianides</h5>
                        <medium>Tech / Business</medium>
                    </div>


                    <div class="col-12 col-md-4 team-2">
                        <a href="#">
                            <img src="{{url('images/AP.jpg')}}" alt="...">
                        </a>
                        <h5>Andreas Poyiatzis</h5>
                        <medium>Tech</medium>
                    </div>


                    <div class="col-12 col-md-4 team-2">
                        <a href="#">
                            <img src="{{url('images/NM.jpg')}}" alt="...">
                        </a>
                        <h5>Nikos Mouzoura</h5>
                        <medium>Tech</medium>

                    </div>

                    <div class="col-12 col-md-4 team-2">
                        <a href="#">
                            <img src="{{url('images/MV.jpg')}}" alt="...">
                        </a>
                        <h5>Marios Vasiliou</h5>
                        <medium>Tech</medium>

                    </div>

                    <div class="col-12 col-md-4 team-2">
                        <a href="#">
                            <img src="{{url('images/TD.jpg')}}" alt="...">
                        </a>
                        <h5>Tommys Daniel</h5>
                        <medium>Tech</medium>

                    </div>

                    <div class="col-12 col-md-4 team-2">
                        <a href="#">
                            <img src="{{url('images/PA.jpg')}}" alt="...">
                        </a>
                        <h5>Prodromos Alampritis</h5>
                        <medium>Tech</medium>

                    </div>
                </div>

            </div>

        </section>



        <!-- Scripts -->
        <script src="{{url('js/core.min.js')}}"></script>
        <script src="{{url('js/thesaas.min.js')}}"></script>
        <script src="{{url('js/script.js')}}"></script>
</div>

</body>
</html>
