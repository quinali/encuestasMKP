@extends('layouts.app')
@section('content')
<div id="page-wrapper">
	<div class="container-fluid">
		
		<div class="row">
			<div class="col-lg-12 col-md-offset-1">
				<h1 class="page-header">
					<small>Encuestas
				</h1>
			</div>
		</div>    
        <!-- /.row -->
		
		<!-- Zona del mensaje -->
        @include('mensaje')
        <!-- /.row -->		
		
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Listado encuestas activas</div>

				<div class="panel-body">
					<table id="encuestas" class="kkk table table-bordered table-hover">
						<thead>
							<tr>
								<th>Encuesta</th>
								<th>Pendientes</th>
								<th>Totales</th>
								<th>Acceso</th>
							</tr>
						</thead>
						<tbody>
						
							@foreach ($encuestas as $encuesta)
							
								<tr class='alt'>
									<td>{{ $encuesta->surveyls_title }} </td>
									<td>{{ $encuesta->pdtes }}</td>
									<td>{{ $encuesta->tot }}</td>
									<td><a href='llamadas/{{ $encuesta->sid }}'><i class='fa fa-sign-in fa-2x'></i></a></td>
								</tr>
							
							@endforeach
					
						</tbody>
					</table>	
				</div>
			</div>
		</div>
	</div>
</div>
</div>
@endsection