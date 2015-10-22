@extends('layouts.app2')
@section('content')
{!! Html::style('assets/css/dashboard.css') !!}
{!! Html::style('assets/css/sb-admin.css') !!} 
{!! Html::style('assets/css/llamadas.css') !!}

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
                            Listado de usuarios:
                        </h1>
                    </div>

					<div class="panel-heading col-md-offset-1">
                    	<ol class="breadcrumb">
		                	<li class="active">
		                    	<i class="fa fa-user"></i> Usuarios
		                     </li>
		                </ol>
                    </div>
                </div>    
                <!-- /.row -->
                <!-- /.row -->

					
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12 text-center">
								<div class="panel panel-default">
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
										</div>
										
										<div class="row" style="float: none; margin-left: auto; margin-right: auto;">
											<div class="col-md-12 col-md-offset-1">
												{!! $users->render() !!}
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

		<!-- ./row -->
	
	<div class="row pull-right">
		<a class="btn btn-default" href="../auth/register">Nuevo usuario</a>
	</div>
	
	
	
</div>
@endsection