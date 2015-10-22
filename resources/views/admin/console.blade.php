@extends('layouts.app2')
@section('content')
{!! Html::style('assets/css/dashboard.css') !!}
{!! Html::style('assets/css/sb-admin.css') !!} 
{!! Html::style('assets/css/llamadas.css') !!}
   <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="#"><i class="fa fa-fw fa-dashboard"></i> Encuestas</a>
                    </li>
					<li>
                        <a href="admin/usuarios"><i class="fa fa-fw fa-user"></i> Usuarios</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				
				<!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12 col-md-offset-1">
                        <h1 class="page-header">
                            Administración encuestas activas:
                        </h1>
                    </div>

					<div class="panel-heading col-md-offset-1">
                    	<ol class="breadcrumb">
		                	<li class="active">
		                    	<i class="fa fa-dashboard"></i> Encuestas
		                     </li>
		                     <li>
		                     	<i class="fa fa-comments"></i>
		                        <a href='#'>Encuestras activas</a>
							</li>
                        </ol>
                    </div>
                </div>    
                <!-- /.row -->


                <!-- Zona del mensaje -->

                <!-- /.row -->
					
					<div class="row">
                    	<div class="col-lg-12">
                            <div class="panel-body">
									<div class="row">
										<div class="col-lg-12 text-center">
											<div class="panel panel-default">
												<div class="panel-body">
													<div class="table-responsive">
														<table id="encuestas" class="kkk table table-bordered table-hover">
															<thead>
																<tr>
																	<th>Encuesta</th>
																	<th>Activa</th>
																	<th>Pendientes</th>
																	<th>Totales</th>
																	<th>Operad.Asoc</th>
																	<th>Operad.Tot</th>
																	<th>Acceso</th>
																</tr>
															</thead>
															<tbody>

																@foreach ($surveys as $survey)
							
																	<tr class='alt'>
																		<td>{{ $survey->surveyls_title }}</td>
																		<td>{{ $survey->active }}</td>
																		<td>--</td>
																		<td>--</td>
																		<td>--</td>
																		<td>--</td>
																		<td><a href='survey/{{$survey->sid }}'><i class='fa fa-sign-in fa-2x'></i></a></td>
																	</tr>
																
																@endforeach

															</tbody>
														</table>
													</div>
													<div class="row" style="float: none; margin-left: auto; margin-right: auto;">
														<div class="col-md-12 col-md-offset-1">
															{!! $surveys->render() !!}
														</div>
													</div>				
												</div>	
											</div>
										</div>		
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
@endsection
