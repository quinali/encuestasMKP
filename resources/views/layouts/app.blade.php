<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="assets/images/favicon.png"> 
    <title>Callcenter</title>
	
	
    <!-- Bootstrap Core CSS -->
    {!! Html::style('assets/css/bootstrap.min.css') !!}
	
	<!-- Custom CSS -->
	{!! Html::style('assets/css/sb-operator.css') !!} 
	<!--{!! Html::style('assets/css/encuestas.css') !!}-->

	<!-- Custom Fonts -->
	{!! Html::style('assets/font-awesome/css/font-awesome.min.css') !!}

	
	 <!-- Scripts -->
	{!! Html::script('assets/js/jquery.js') !!}
    {!! Html::script('assets/js/bootstrap.min.js') !!}
    
	 <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
     	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	<div id="wrapper">
	
	<!-- Static navbar -->
    <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{route('encuestas')}}" > MKPersons</a>
            </div>
        
	<!-- Top Menu Items -->
           


            <ul class="nav navbar-right top-nav">
           			@if (Auth::guest())
					    <li><a href="{{route('auth/login')}}">Login</a></li>
				    @else

		                <li class="dropdown">
		                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{ Auth::user()->name }} <b class="caret"></b></a>
		                    <ul class="dropdown-menu">
		                        <li>
		                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
		                        </li>
		                        <li>
		                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
		                        </li>
		                        <li>
		                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
		                        </li>
		                        <li class="divider"></li>
		                        <li>
		                            <a href="{{route('auth/logout')}}"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
		                        </li>
		                    </ul>
		                </li>
           			@endif
		    </ul>

	</nav>
	
	
	@yield('content')
	
	</div>
</body>
</html>