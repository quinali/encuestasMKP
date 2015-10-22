@extends('layouts.app2')
@section('content')
{!! Html::style('assets/css/dashboard.css') !!}
{!! Html::style('assets/css/sb-admin.css') !!} 
{!! Html::style('assets/css/llamadas.css') !!}

<!-- Morris Charts CSS -->
{!! Html::style('assets/css/plugins/morris.css') !!}


<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
		<li>
			<a href="../../survey/{{$data['sid']}}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
        </li>
		<li>
			<a href="#"><i class="fa fa-fw fa-group"></i> Operadores</a>
		</li>
		<li>
			<a href="#"><i class="fa fa-fw fa-edit"></i> Configuración</a>
		</li>
	</ul>
</div>
<!-- /.navbar-collapse -->

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 ">
			<div class="panel panel-default">
				
				<!-- Page Heading -->
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12 col-md-offset-1">
                        <h1 class="page-header">
                            <small>Asignaci&oacute;n de operadores:</small> <br/>
                            {{$data['survey_title']}}
                        </h1>
                    </div>

					<div class="panel-heading col-md-offset-1">
                    	<ol class="breadcrumb">
		                	<li>
                                <i class="fa fa-dashboard"></i>Dashboard
                            </li>
                            <li class="active">
                                <i class="fa fa-users"></i> Operadores
                            </li>
		                </ol>
                    </div>
                </div>    
                <!-- /.row -->
            

            
                <div class="panel-body">
					<div class="row">
                   		<div class="col-lg-12">
                       		<div class="panel panel-default">
                           	
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="panel panel-default">
                                                
                                                <div class="panel-body">
                            
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-6 text-center">
                                                            <div class="panel panel-default  clear">
                                                                <div class="panel-body">
                                                                    <b>No asignados:</b><br/>
                                                                        <select multiple id='lstBox1' size="10">
                                                                           
                                                                           //Propuesta de operadores
                                                                            @foreach ($data['operadores'] as $operador)
                                                                                                                                                                        
                                                                               <option value='{{$operador->id}}'>{{$operador->name}}</option>
                                                                            
                                                                            @endforeach
                
                                                                        </select>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.row -->
                                </divv>
                        </div>
                    </div>
                    <!-- /.row -->
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

@endsection