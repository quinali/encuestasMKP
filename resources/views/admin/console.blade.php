@extends('layouts.app2')
@section('content')

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
        </nav>
    <!-- /.navbar-collapse -->

  	<div id="page-wrapper">
		
		<div class="container-fluid">
		
			<!-- Page Heading -->
			<div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Administración encuestas:
                        </h1>
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
                    	<div class="col-lg-12">
                    		<div class="panel panel-default">
	                            <div class="panel-heading">
	                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Encuestas</h3>
	                            </div>
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
							<!-- ./row -->
						</div>
           				 <!-- /.container-fluid -->
		 </div>
        <!-- /#page-wrapper -->				

	
@endsection
