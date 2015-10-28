@extends('layouts.app2')
@section('content')

<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
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
</nav>

<!-- /.navbar-collapse -->
<div id="page-wrapper">
    <div class="container-fluid">
         <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                        {{$data['survey_title']}}
                </h1>
                <ol class="breadcrumb">
                    <li class="active">
                        <i class="fa fa-dashboard"></i> Encuesta</li>
                             <li>
                                <i class="fa fa-phone"></i>
                                <a href='#'> Asignación de llamadas</a>
                            </li>
                        </ol>
                    </div>
                </div>    
                <!-- /.row -->
                <!-- Zona del mensaje -->
               <div class="row">
                    <div class="col-lg-9">
                        <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-info-circle"></i>  <strong>Like SB Admin?</strong> Try out <a href="http://startbootstrap.com/template-overviews/sb-admin-2" class="alert-link">SB Admin 2</a> for additional features!
                        </div>
                    </div>
                </div>
                <!-- /.row -->

     <div class="row">
            <div class="col-lg-9 ">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-phone fa-fw"></i> Asignación de llamadas</h3>
                    </div>
                    <!-- LISTADOS -->
                    <div class="panel-body">
                   
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection