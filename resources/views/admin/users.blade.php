@extends('layouts.app2')
@section('content')

<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
		<div class="collapse navbar-collapse navbar-ex1-collapse">
		    <ul class="nav navbar-nav side-nav">
				<li>
					<a href="../admin"><i class="fa fa-fw fa-dashboard"></i> Encuestas</a>
		        </li>
				<li>
					<a href="#"><i class="fa fa-fw fa-user"></i> Usuarios</a>
				</li>
			</ul>
		</div>
	</nav>
	<!-- /.navbar-collapse -->

	<div id="page-wrapper">
		
		<div class="container-fluid">
		
			<!-- Page Heading -->
			<div class="row">
				<div class="col-lg-12 ">
					<div class="panel panel-default">
						<h1 class="page-header">
                            Listado de usuarios:
                        </h1>
                    </div>
                </div>
            </div>        
                <!-- /.row -->

               <!-- Zona del mensaje -->
               	@include('mensaje')
                <!-- /.row -->

				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
	                                <h3 class="panel-title"><i class="fa fa-user fa-fw"></i> Listado de usuarios</h3>
                            </div>
							<div class="panel-body">
								<div class="table-responsive">
									<table id="encuestas" class="kkk table table-bordered table-hover">
										<thead>
											<tr>
												<th>Name</th>
												<th>Email</th>
												<th>Fecha creacion</th>
												<th>Fecha actualización</th>
												<th>Editar</th>
											</tr>
										</thead>
										<tbody>
												
											@foreach ($users as $user)
											
												<tr class='alt'>
													<td>{{ $user->name }} </td>
													<td>{{ $user->email }}</td>
													<td>{{ $user->created_at }}</td>
													<td>{{ $user->updated_at }}</td>
													<td><a href='user/edit/{{$user->id }}'><i class='fa fa-edit fa-2x'></i></a></td>
												</tr>
												
											@endforeach
											
										</tbody>
									</table>	
									
										{!! $users->render() !!}
									<div class="pull-right">
										<a class="btn btn-default" href="../auth/register">Nuevo usuario</a>
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