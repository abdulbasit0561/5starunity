
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-2" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="theme-color" content="rgba(70,104,109,.8)">
    <meta name="msapplication-navbutton-color" content="rgba(70,104,109,.8)">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700,800,900|Open+Sans:300,300i,400,600,600i,700,700i,800,800i|Oswald:200,300,400,500,600,700|Lato:100,400,300,300italic,400italic,700,700italic,900italic,900|Kalam:300,400,700|Roboto+Condensed|Roboto:300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ asset('frontend/code/css/fonts/font-awesome/css/font-awesome.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('frontend/code/jquery-ui/jquery-ui.min.css')}}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-hover-dropdown/2.2.1/bootstrap-hover-dropdown.css">
    <link rel="stylesheet" href="{{ asset('frontend/code/jquery-ui/jquery-ui.theme.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('frontend/code/css/style6c71.css?ver=1549632172')}}" />
    <script type="text/javascript" src="{{ asset('frontend/code/scripts/jquery-1.11.2.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('frontend/code/jquery-ui/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('frontend/code/Highcharts-4.1.8/js/highcharts.js')}}"></script>
    <script src="{{ asset('frontend/code/jquery-ui/jquery.ui.touch-punch.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('frontend/code/scripts/site-scripts7031.js?v=1548947668')}}"></script>
    <script type="text/javascript" src="{{ asset('frontend/code/scripts/login-register.js')}}"></script>
    <script type="text/javascript" src="{{ asset('frontend/main.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-hover-dropdown/2.2.1/bootstrap-hover-dropdown.js"></script>
    @yield('style')
    <style>
    .newLayout .navbar-default .navbar-nav li .largeDropdown
    {
        /* border: solid 1px #000 !important; */
        box-shadow: 1px 6px 20px -5px #ccc !important;
    }
    </style>
    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
</head>
<body class="newLayout">
        <div class="co_navbar" style="height: 80px">
                <nav class="navbar navbar-default new_header navbar-transparent absolute-positioning ">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <div class="col-sm-8 col-md-8 col-xs-8 col-md-offset-3" style="position: relative; left: -30px;">
                                <a class="navbar-brand" href="/">
                                    <div class="navbar-logo-holder"></div>
                                </a>
                            </div>
                            <div class="col-xs-3 pull-right">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" style="background-color:black">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>

                            </div>
                        </div>
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                                <li  ><a href="/lotter-of-things">{{ __('menu.lottery_things')}}</a></li>
                                <li  ><a href="/page/promotions">{{ __('menu.promotions')}}</a></li>
                                <li ><a href="/page/partner/">{{ __('menu.partner')}}</a></li>
                                <li class="dropdown" id="bigmenu">
                                    <button style="color:black !important" class="btn btn-default dropdown-toggle menubtn" type="button" data-toggle="dropdown" data-hover="dropdown">{{ __('menu.more')}} <span class="caret"></span></button>
                                    <ul class="dropdown-menu sub_menu">
                                        <li><a style="margin-top:0px !important; font-size:15px !important" href="{{route('howitworks')}}">{{ __('menu.idea')}}</span></a></li>
                                        <li><a style="margin-top:0px !important; font-size:15px !important" href="{{route('inventro.acadmy')}}">{{ __('menu.knowledge')}}</span></a></li>
                                        <li><a style="margin-top:0px !important; font-size:15px !important" href="{{route('news')}}">{{ __('menu.latest')}}</a></li>
                                        <li><a style="margin-top:0px !important; font-size:15px !important" href="{{route('ceo')}}">{{ __('menu.ceo')}}</a></li>
                                        <li><a style="margin-top:0px !important; font-size:15px !important" href="{{route('media-info')}}">{{ __('menu.press')}}</a></li>
                                        <li><a style="margin-top:0px !important; font-size:15px !important" href="{{route('contact-us')}}">{{ __('menu.contact')}}</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav pull-left hidden-xs">
                                {{-- <li><a class="navbar-brand" href="/"><div class="navbar-logo-holder"></div></a></li> --}}
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                @if(!Auth::guard('client')->check())
                                    <li><a class="login uppercase" href="{{ route('login') }}">Log In</a></li>
                                    <li><a class="uppercase" href="{{ route('register') }}">{{ __('menu.register')}}</a></li>
                                @else
                                <li class="dropdown" id="bigmenu"> 
                                    <a href="#" class="" data-toggle="dropdown" role="button" aria-expanded="false">{{ __('lables.my_account')}} &nbsp;</a>
                                    <div class="dropdown-menu largeDropdown" role="menu" aria-labelledby="bigmenu" style="padding:0px !important; padding-bottom:7px !important; width:100px">
                                        <div class="row nopadding">
                                            <div class="col-md-12 nopadding text-left">
                                                <div class="list_nav">
                                                    <ul style="margin-top:10px">
                                                        <li style="padding:0px"><a style="margin-top:0px !important" href="{{route('dashboard')}}">Dashboard</a></li>
                                                        <li style="padding:0px"><a style="margin-top:0px !important" href="/logout">AUSLOGGEN</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                <li><a href="/" class="uppercase language-link no_padding_left bold-text">DE</a></li>
                                <li class="lang-separator hidden-xs hidden-sm" style="margin-top:20px">|</li>
                                <li><a href="#" data-toggle="modal" data-target="#exampleModal" class="uppercase language-link no_padding_right ">EN</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {{-- <div class="modal-header">
                    <h5 class="modal-title">Notice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div> --}}
                    <div class="modal-body">
                       <h2 class="text-center">Coming soon...</h2>
                    </div>
                    {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                    </div> --}}
                </div>
                </div>
            </div>
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @yield('footer')

        <div id="defaultFooter">

            <div class="modal KontactModal fade" id="KontactForm" tabindex="-1" role="dialog" aria-labelledby="KontactFormLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Contact Us</h4>
                        </div>

                        <div class="modal-body bodyKontact">
                            <div class="row">
                                <div class="col-xs-12 col-md-4 TelNr text-center">
                                    <div class="iconKontact"></div>
                                    <div class="infoAbout text-left pluspadding">
                                        <p class="toll_free_service">Phone number for investors</p>
                                        <p>
                                            <span class="glyphicon glyphicon-earphone"></span> <strong>0800 - 100 267 0 (DE/Toll-free)</strong><br />
                                            <span class="glyphicon glyphicon-earphone"></span> <strong>+49(0)30 3464914 93</strong><br />
                                        </p>
                                        <p><strong>Mo-Fr 9 a.m. - 7 p.m.</strong></p>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-4 LiveChat text-center">
                                    <div class="iconKontact"></div>
                                    <div class="infoAbout">
                                        <a class="btn-default-new-layout btn-new-layout-white-transparent marginBottom30pxMobile" href="javascript:$zopim.livechat.window.show();$('#KontactForm').modal('hide');">Start live chat</a>
                                        <br/>
                                        <br/>
                                        <p><strong>Mo-Fr 9 a.m. - 7 p.m.</strong></p>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-4 EmailForm text-center">
                                    <div class="iconKontact"></div>
                                    <div class="infoAbout">
                                        <a class="btn-default-new-layout btn-new-layout-white-transparent marginBottom30pxMobile" href="de/contact-us.html#contact" target="_blank">More</a>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-10 col-md-offset-1 text-center whiteBorderKontact">
                                    <a class="btn-default-new-layout btn-new-layout-transparent-white" href="de/faq.html" target="_blank">Help center</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div id="followUsWrapNew" style="background: transparent !important;">
            </div>

            <div id="footerBottomBar">
                <div class="container border">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 BottomText grey_75 text-center">
                            <a style="text-decoration: none;cursor: default !important;">&copy; 2019 - <?php echo date('Y') ?> 5starUnity Europe OÜ </a>
                            <a href="/page/terms">{{ __('menu.terms')}}</a>
                            <a href="/page/data-security">{{ __('menu.privacy')}}</a>
                            <a href="/impresum">{{ __('menu.legal_notice')}}</a>
                        </div>

                        <div class="clear"></div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 BottomFollow-us grey_75 text-center">
                            <div id="follow-us-footer">
                                <ul>
                                    <li>
                                        <a target="_blank" href="https://www.linkedin.com/company/47984332/" title="">
                                            <i class="fa fa-linkedin" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a target="_blank" href="https://www.facebook.com/pg/5starunity-Europe-O%C3%9C-103240304411163" title="">
                                            <i class="fa fa-facebook" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a target="_blank" href="https://twitter.com/5starUnity" title="">
                                            <i class="fa fa-twitter" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a target="_blank" href="https://www.instagram.com/5starunity/" title="">
                                            <i class="fa fa-instagram" aria-hidden="true"></i>
                                        </a>
                                    </li>

                                    <li>
                                        <a target="_blank" href="https://www.pinterest.at/5starUnity/" title="">
                                            <i class="fa fa-pinterest" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a target="_blank" href="https://www.youtube.com/channel/UC8LLdXLjsYPxCRl5mT0eQqQ" title="">
                                            <i class="fa fa-youtube-play" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <br />
                                    <li>
                                        <font color="black">
                                            Designed and Developed by <a href="http://xnowad.com" target="_blank"><font color="blue" size="4">Xnowad.com</font></a>
                                        </font>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('cookie-consent::index')
        {{-- <div class="investoren_support_div" data-toggle="modal" data-target="#KontactForm" id="BtnInvestorenSupport">
            <span>Investor Support</span>
            <img src="graphics/layout/LiveChat.svg" class="iconSupport">
        </div> --}}
    <script type="text/javascript" src="{{ asset('frontend/code/scripts/jquery.bcSwipe.min.js')}}"></script>
    <script src="{{ asset('frontend/code/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    
    @yield('script')
<script>
var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
var currentScrollPos = window.pageYOffset;
  if (prevScrollpos > currentScrollPos) {
      $(".navbar").css('top','0');
  } else {
    $(".navbar").css('top','-100px');
  }
  prevScrollpos = currentScrollPos;
}

</script>
</body>
</html>
