@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Listado <small>de encuestas activas</small></div>

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
@endsection