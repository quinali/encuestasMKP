@extends('layouts.app2')
@section('content')

<!-- Morris Charts CSS -->
{!! Html::style('assets/css/plugins/morris.css') !!}


<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
		<li>
			<a href="#"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
        </li>
		<li>
			<a href="{{$data['sid']}}/operadores"><i class="fa fa-fw fa-group"></i> Operadores</a>
		</li>
		<li>
			<a href="{{$data['sid']}}/settings"><i class="fa fa-fw fa-edit"></i> Configuración</a>
		</li>
        <li>
            <a href="{{$data['sid']}}/dispatch"><i class="fa fa-fw fa-refresh"></i> Asignación</a>
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
                                <i class="fa fa-dashboard"></i> Encuesta
                             </li>
                             <li>
                                <i class="fa fa-bar-chart"></i>
                                <a href='#'>Panel de encuesta</a>
                            </li>
                        </ol>
                    </div>
                </div>    
                <!-- /.row -->
              
                <!-- Zona del mensaje -->
                @include('mensaje')
                <!-- /.row -->

                <!-- ZONA DE CONTADORES -->
                <div class="row">
                    <div class="col-lg-12 col-md-6">    
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-phone fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge">{{$data['LlamPdtesNoRealizadas']}}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="panel-footer">
                                    <span class="pull-left panel-heading-label">Pendientes</span>
                                    <div class="clearfix"></div>
                                </div>
                                
                            </div>
                        </div>
                         <div class="col-lg-3 col-md-6">
                            <div class="panel panel-green">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-phone fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge">{{$data['LlamPdtesRecuperadas']}}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                        <span class="pull-left">Recuperadas Ptes.</span>
                                        <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-yellow">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-phone fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge">{{$data['LlamEmitidasRecuperables']}}</div>
                                         </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <span class="pull-left">Hechas Recuperables.</span>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-red">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-phone fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge">{{$data['LlamEmitidasNoRecuperables']}}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <span class="pull-left">Hechas NO Recuperables.</span>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>    
            <!-- /.row -->  



    <div class="row">
		<div class="col-lg-12 ">
			<div class="panel panel-default">
				<div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-bar-chart fa-fw"></i> Llamadas por operador</h3>
                </div>

               	<!-- GRAFICA -->
				<div class="panel-body">
					<div class="row">
                    		<div class="col-lg-12">

                       			<div id="graph"></div>

                            			<script>
											Morris.Bar({
                                      element: 'graph',
                                      data: [

                                        @foreach ($data['llamadasPorOperadores'] as $llamadasPorOperador)

                                                {   x: '{{$llamadasPorOperador->name}}', 
                                                    a: {{$llamadasPorOperador->ptesNuncaRealizadas}},  
                                                    b: {{$llamadasPorOperador->ptesRecuperadas}}, 
                                                    c: {{$llamadasPorOperador->ejecutadasRecuperables}},
                                                    d: {{$llamadasPorOperador->ejecutadasNORecuperables}} 

                                                },
                                                
                                        @endforeach        
                                            ],
                                      xkey: 'x',
                                      ykeys: ['a', 'b', 'c', 'd'],
                                      labels: ['Ptes', 'Ptes.Recuperadas','Hechas Recuperables','Hechas NO Recuperables'],
                                      stacked: true,
                                      barColors: ["#337ab7","#5CB85C", "#F0AD4E","#d9534f"],
                                    });
								 		</script>
								 	</div>
								 </div>
                    	</div>
                	</div>	

                    </div>
                </div>
                <!-- /.row -->
			</div>
		</div>						

		

@endsection