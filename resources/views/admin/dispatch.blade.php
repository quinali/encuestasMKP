@extends('layouts.app2')
@section('content')

{!! Html::style('assets/css/dashboard.css') !!}
{!! Html::style('assets/css/sb-admin.css') !!} 
{!! Html::style('assets/css/llamadas.css') !!}

<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
		<ul class="nav navbar-nav side-nav">
        <li>
            <a href="../../survey/{{$data['sid']}}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
        </li>
        <li>
            <a href="operadores"><i class="fa fa-fw fa-group"></i> Operadores</a>
        </li>
        <li>
            <a href="settings"><i class="fa fa-fw fa-edit"></i> Configuración</a>
        </li>
        <li class="active" >
            <a href="#"><i class="fa fa-fw fa-refresh"></i> Asignación</a>
        </li>
    </ul>
	</ul>
</div>
<!-- /.navbar-collapse -->

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Registro de nuevo usuario</div>
				
				
				<div class="panel-body">
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection