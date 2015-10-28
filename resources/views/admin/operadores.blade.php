@extends('layouts.app3')
@section('content')

<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
        		<li>
        			<a href="../../survey/{{$data['sid']}}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                </li>
        		<li class="active" >
        			<a href="#"><i class="fa fa-fw fa-group"></i> Operadores</a>
        		</li>
        		<li>
        			<a href="settings"><i class="fa fa-fw fa-edit"></i> Configuración</a>
        		</li>
                <li>
                    <a href="dispatch"><i class="fa fa-fw fa-refresh"></i> Asignación</a>
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
                        {{$data['survey_title']}}
                </h1>
                <ol class="breadcrumb">
                    <li class="active">
                        <i class="fa fa-dashboard"></i> Encuesta</li>
                             <li>
                                <i class="fa fa-users"></i>
                                <a href='#'> Asignación de operadores</a>
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

                <!-- Zona de contadores -->
                <div class="row">
                    <div class="col-lg-2 col-md-6 col-md-offset-1">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-users fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{$data['OpConLlamada']}}</div>
                                        <div>Con llamadas</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 col-md-offset-1">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-users fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{$data['OpTotal']}}</div>
                                        <div>Actualmente asignados</div>
                                    </div>
                                </div>
                            </div>   
                        </div>
                    </div>
                </div>    
                <!-- /.row -->   
        
        <div class="row">
            <div class="col-lg-9 ">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-users fa-fw"></i> Asignación de operadores</h3>
                    </div>
                    <!-- LISTADOS -->
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12" >
                                
                                <div class="col-lg-3 col-md-6 text-center">
                                    <div class="panel panel-default  clear">
                                        <div class="panel-body">
                                            <b>No asignados:</b><br/>
                                            <select multiple id='lstBox1' size="10">
                                                //Propuesta de operadores
                                                @foreach ($data['opPosibles'] as $operador)
                                                    <option value='{{$operador->id}}'>{{$operador->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <!-- BOTONERA DE ASIGNACION -->
                                <div class="col-lg-3 col-md-6 text-center" style="vertical-align:middle;">
                                    <div class="panel panel-default clear">
                                        <div class="panel-body">
                                        <br/><br/><br/>
                                        <input type='button' id='btnLeft' value ='  <  ' onclick="lanzaEvento();"/>
                                        <input type='button' id='btnRight' value ='  >  '/>
                                        <br/><br/>

                                        {!! Form::open(array('route' => array('admin\operadores', $data['sid']))) !!}
                                            <input type="hidden"    name="surveyID" value="{{$data['sid']}}"  >
                                            <input type="hidden"    id="operadoresID" name="operadoresID" value="{{$data['opIdAsignados']}}" >
                                            <input type="submit" class="btn btn-info" value="Guardar">
                                        {!! Form::close() !!}
            
                                        </div>
                                    </div>
                                </div>   

                                <!-- MULTISELECT OPERADORES ASIGNADOS -->
                                <div class="col-lg-3 col-md-6 text-center">
                                    <div class="panel panel-default clear">
                                        <div class="panel-body">
                                            <b>Asignados: </b><br/>
                                            <select multiple id='lstBox2' name="lstBox2[]" size="10">
                                                @foreach ($data['opAsignados'] as $operador)
                                                    <option value='{{$operador->id}}'>{{$operador->name}}</option>
                                                @endforeach                                                        
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- /.row -->
                    </div>
                </div>
    		</div>
		</div>
	   <!-- ./row -->
            
        </div>                      
    </div>                      
@endsection