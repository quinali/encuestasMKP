<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="assets/images/favicon.png"> 
    <title>Callcenter</title>
    {!! Html::style('assets/css/bootstrap.css') !!}
	{!! Html::style('assets/css/encuestas.css') !!}
	{!! Html::style('assets/font-awesome/css/font-awesome.min.css') !!}
    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
     	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	<!-- Static navbar -->
    <nav id="cabecera" class="navbar navbar-default navbar-static-top">
        <div  class="container">
		    <div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ URL::to('encuestas')}}">MKpersons</a>
		    </div>
		    <div class="collapse navbar-collapse" >
		        <ul class="nav navbar-nav navbar-right">
				    @if (Auth::guest())
				        <li><a href="{{route('auth/login')}}">Login</a></li>
						<li><a href="{{route('auth/register')}}">Register</a></li>
				    @else
		                <li><a href="#">Operador: {{ Auth::user()->name }}</a></li>
		                <li><a href="{{route('auth/logout')}}">Logout</a></li>
		            @endif
				</ul>
			</div>
		</div>
	</nav>
	
	
    <div class="container">
       @if (Session::has('errors'))
			<div class="row">
				<div class="alert alert-warning" role="alert">
					<ul>
					<strong>Oops! Something went wrong : </strong>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
					</ul>
				</div>
			</div>	
		@endif
	
		@if (Session::has('status'))
			<div class="row">
				<div class="alert alert-info" role="alert">
					<i class="fa fa-info-circle"></i>  {{ session('status') }}
				</div>
			</div>	
		@endif
		
	
	@yield('content')
	
	</div>
    <!-- Scripts -->
	{!! Html::script('assets/js/jquery.js') !!}
    {!! Html::script('assets/js/bootstrap.min.js') !!}
</body>
</html>