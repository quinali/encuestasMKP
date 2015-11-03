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
                @include('mensaje')
                

     <div class="row">
            <div class="col-lg-9 ">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-phone fa-fw"></i> Asignación de llamadas</h3>
                    </div>
                    <!-- LISTADOS -->
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-9 ">                          
                                {!! Form::open(['route' => ['admin.reassign', $data["sid"]] , 'method' => 'post']) !!} 
                                
                                    <label>{!! Form::label('desde', 'Llamadas desde') !!}</label>
                                    {!! Form::number('desde',"1",['id'=>'desde','size'=>'4']) !!}
                                    
                                    <label>{!! Form::label('hasta', 'hasta') !!}</label>

                                    {!! Form::number('hasta',$data['nLlamadasPendientes'],['id'=>'hasta','size'=>'4']) !!}
                                   
                                    <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-refresh"></span> Asignar</button>    
                                {!! Form::close() !!} 
                            </div>
                          </div>      
                    </div>
                </div>
            </div>
        </div>

       <div class="row">
            <div class="col-lg-9 ">
                <div class="panel panel-default">
                    {!! Form::open(['route' => ['admin.deallocate', $data["sid"]] , 'method' => 'post']) !!} 
                        <label>{!! Form::label('desde', 'Llamadas desde') !!}</label>
                        {!! Form::number('desde',"1",['id'=>'desde','size'=>'4']) !!}
                                        
                        <label>{!! Form::label('hasta', 'hasta') !!}</label>
                        {!! Form::number('hasta',$data['nLlamadasPendientes'],['id'=>'hasta','size'=>'4']) !!}
                                       
                         <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-erase"></span> Borrar asignaciones</button>    
                     {!! Form::close() !!}
                     
                     {!! Form::open(['route' => ['admin.recover', $data["sid"]] , 'method' => 'post']) !!}

                        <label>{!! Form::label('desde', 'Llamadas desde') !!}</label>
                        {!! Form::number('desde',"1",['id'=>'desde','size'=>'4']) !!}
                                    
                        <label>{!! Form::label('hasta', 'hasta') !!}</label>
                        {!! Form::number('hasta',$data['nLlamadasPendientes'],['id'=>'hasta','size'=>'4']) !!} 
                        <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-refresh"></span> Recuperar llamadas pendientes</button>    
                     {!! Form::close() !!}
                </div>      
            </div>
        </div>
    </div>
</div>
@endsection