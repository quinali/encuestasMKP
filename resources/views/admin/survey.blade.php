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
			<a href="../admin"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
        </li>
		<li>
			<a href="{{$data['sid']}}/operadores"><i class="fa fa-fw fa-group"></i> Operadores</a>
		</li>
		<li>
			<a href="{{$data['sid']}}/settings"><i class="fa fa-fw fa-edit"></i> Configuración</a>
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
                            {{$data['survey_title']}}
                        </h1>
                    </div>

					<div class="panel-heading col-md-offset-1">
                    	<ol class="breadcrumb">
		                	<li class="active">
		                    	<i class="fa fa-dashboard"></i> Dashboard
		                     </li>
		                </ol>
                    </div>
                </div>    
                <!-- /.row -->
                <div class="row">
				<div class="col-lg-12 col-md-6">	
                    <div class="col-lg-2 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-phone fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{$data['LlamPdtes']}}</div>
                                        <div>Pdtes.</div>
                                    </div>
                                </div>
                            </div>
							<div class="panel-body">
								<div> 
									<a class='btn btn-info' href='reasignaEncuestas.php?surveyID='><span class="glyphicon glyphicon-refresh"></span> Asignar</a>	
								</div>
							</div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-phone fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{$data['LlamHechas']}}</div>
                                        <div>Hechas</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-phone fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{$data['LlamTotal']}}</div>
                                        <div>Total</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					
					
					<div class="col-lg-2 col-md-6">
                        
                    </div>
					
					<div class="col-lg-2 col-md-6">
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
					
					
                    <div class="col-lg-2 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-users fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{$data['OpTotal']}}</div>
                                        <div>Totales</div>
                                    </div>
                                </div>
                            </div>
                            <a href="asignarOperadores.php?idSurvey=">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
				</div>
            </div>
            <!-- /.row -->	

                <!-- ZONA DE CONTADORES -->


                <!-- ./contadores -->

                	<!-- GRAFICA -->
					<div class="panel-body">
						<div class="row">
                    		<div class="col-lg-12">
                        		<div class="panel panel-default">
                            		<div class="panel-heading">
                                		<h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Llamadas por operador</h3>
                            		</div>
                            		
                            		<div class="panel-body">
                            			<div id="graph"></div>

                            			<script>
											Morris.Bar({
                                      element: 'graph',
                                      data: [

                                        @foreach ($data['llamadasPorOperadores'] as $llamadasPorOperador)

                                                {x: '{{$llamadasPorOperador->operador}}', y: {{$llamadasPorOperador->ptes}},  a: {{$llamadasPorOperador->ejecutadas}} },
                                                
                                        @endforeach        
                                            ],
                                      xkey: 'x',
                                      ykeys: ['y', 'a'],
                                      labels: ['Ptes', 'Hechas'],
                                      stacked: true,
                                      barColors: ["#5CB85C", "#F0AD4E"],
                                    });
								 		</script>
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