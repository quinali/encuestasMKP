@extends('layouts.app2')
@section('content')

{!! Html::style('assets/css/dashboard.css') !!}
{!! Html::style('assets/css/sb-admin.css') !!} 
{!! Html::style('assets/css/llamadas.css') !!}

<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
		<li>
			<a href="../admin"><i class="fa fa-fw fa-dashboard"></i> Encuestas</a>
        </li>
		<li>
			<a href="../../../admin/usuarios"><i class="fa fa-fw fa-user"></i> Usuarios</a>
		</li>
	</ul>
</div>
<!-- /.navbar-collapse -->

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Registro de nuevo usuario</div>
				
				
				<div class="panel-body">
                   {!! Form::model($user, array('route' => 'user.edit', $user->id))!!} 

                        <div class="form-group">
                            <label>{!! Form::label('name', 'Name') !!}</label>
                           {!! Form::text('name') !!}
                        </div>
						
						{!! Form::hidden ('id') !!}
						
						   
						
                        <div class="form-group">
                            <label>{!! Form::label('email', 'Email') !!}</label>
                            {!! Form::email('email') !!}      
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            {!! Form::password('password', ['class'=> 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            <label>Password confirmation</label>
                            {!! Form::password('password_confirmation', ['class'=> 'form-control']) !!}
                        </div>

                        <div>
                           {!! Form::submit('Guardar',['class' => 'btn btn-default']) !!} <a class="btn btn-default" href="../../../admin/usuarios">Cancelar</a>
                        </div>
						
						
						
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection