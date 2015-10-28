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
        <div class="row">
            <div class="col-lg-12">
                    <div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="fa fa-info-circle"></i>  <strong>Like SB Admin?</strong> Try out <a href="http://startbootstrap.com/template-overviews/sb-admin-2" class="alert-link">SB Admin 2</a> for additional features!
                </div>
            </div>
        </div>
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