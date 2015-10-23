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

 	<!-- Scripts -->
	{!! Html::script('assets/js/jquery.js') !!}
    {!! Html::script('assets/js/bootstrap.min.js') !!}

    <!-- Morris Charts CSS -->
	{!! Html::style('assets/css/plugins/morris.css') !!}
	{!! Html::script('assets/js/plugins/morris/raphael.min.js') !!}
	{!! Html::script('assets/js/plugins/morris/morris.js') !!}
	{!! Html::script('assets/js/plugins/morris/morris-data.js') !!}


</head>
<body>
	<!-- Static navbar -->
    <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ URL::to('admin')}}">{!! HTML::image('assets/images/mkpersons-logo1.png', 'logo', array( 'height' => 35, 'margin-top' => -13)) !!}</a>
            <!-- Top Menu Items -->
            
	            <ul class="nav navbar-nav navbar-right">
					    @if (Auth::guest())
					        <li><a href="{{route('auth/login')}}">Login</a></li>
							<li><a href="{{route('auth/register')}}">Register</a></li>
					    @else
			                <li><a href="#">Usuario: {{ Auth::user()->name }}</a></li>
			                <li><a href="{{route('auth/logout')}}">Logout</a></li>
			            @endif
				</ul>
          
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

</body>

@include('scriptsFooter')


</html>