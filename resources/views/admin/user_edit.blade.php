@extends('layouts.app2')
@section('content')


<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
		<li>
			<a href="../../../admin"><i class="fa fa-fw fa-dashboard"></i> Encuestas</a>
        </li>
		<li>
			<a href="../../../admin/usuarios"><i class="fa fa-fw fa-user"></i> Usuarios</a>
		</li>
	</ul>
</div>
</nav>
<!-- /.navbar-collapse -->

<div id="page-wrapper">

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                   Edición de usuarios
                </h1>
		     </div>
        </div>    
        <!-- /.row -->
		
         <!-- Zona del mensaje -->
        @include('mensaje')
        <!-- /.row -->


        <div class="row">
            <div class="col-lg-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-user fa-fw"></i> Datos de usuario </h3>
                    </div>
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
                                <label>{!! Form::label('isadmin', 'Administrador') !!}</label>
                                {!! Form::checkbox('isAdmin') !!}      
                            </div>
							
							<div class="form-group">
                                <label>{!! Form::label('isenabled', 'Habilitado') !!}</label>
                                {!! Form::checkbox('isEnabled') !!}      
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
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper --> 
@endsection