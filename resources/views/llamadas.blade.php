@extends('layouts.app')
@section('content')
<div id="page-wrapper">
	<div class="container-fluid">
		
		<div class="row">
			<div class="col-lg-12 col-md-offset-1">
				<h1 class="page-header">
					{{ $data['surveyTitle'] }}
				</h1>
			</div>
		</div>    
        <!-- /.row -->
		
		<!-- Zona del mensaje -->
        @include('mensaje')
        <!-- /.row -->		
				
		<div class="row">
			<div class="col-lg-12 col-md-6 col-md-offset-1">	
				<div class="col-lg-3 col-md-6">
					<div class="panel panel-green">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-phone fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class="huge">{{ $data['contadoresLlamadas']->totalPtes }}</div>
									<div>Pendientes</div>
								</div>
							</div>
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
									<div class="huge">{{ $data['contadoresLlamadas']->totalEmitidas }}</div>
									<div>Emitidas</div>
								</div>
							</div>
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
									<div class="huge">{{ $data['contadoresLlamadas']->totalAsignadas }}</div>
									<div>Total asignadas</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	
		<!-- ./row -->
		<div class="row">
			<div class="col-lg-9 col-md-offset-1">
				<div class="panel panel-default">
					<!--div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-phone fa-fw"></i> Llamadas asignadas</h3>
					</div-->
				
					<!-- TABLA -->
					<div class="panel-body">
					<div class="row">
						<div class="col-md-10 col-sm-9">
							<section id="search">
								<label for="search-input"><i class="fa fa-search" aria-hidden="true"></i><span class="sr-only">Buscar por cliente</span></label>
								<input id="search-input" class="form-control input-lg" placeholder="Nombre de cliente..." autocomplete="off" spellcheck="false" autocorrect="off" tabindex="1" onkeyup="show_hide_icon()"
								
								 @if(!empty($data['nameFilter']))
									value="{{ $data['nameFilter']}}"
								 @endif
								 >

								<a id="search-clear" onclick="pageReload();" class="fa fa-times-circle" aria-hidden="true"><span class="sr-only">Clear search</span></a>
								</section>
							</div>
						</div>
								
						<div class="row">
							<div class="col-lg-12">
								@if( $data['page'] >0)
									<div class="table-responsive">
										<table id="encuestas" class="kkk table table-bordered table-hover">
											<thead>
												<tr>
													<th>Nombre</th>
													
													@if ($data['isConfirmacion'] == 0)
														<th>Teléfono 1</th>
														<th>Teléfono 2</th>
													@else									
														<th>Fecha cita</th>
														<th>Teléfonos</th>
													@endif
													
														
													<!-- Introducir aqui las columnas cuando segunda ronda-->
													<th>Recuperar</th>
													<th>Intentos</th>
													<th>Encuesta</th>
												</tr>
											</thead>
											<tbody>
												@foreach ($data['llamadas'] as $llamada)
													<tr class='alt' id="{{$llamada->tid}}">
														<td>{{$llamada->firstname}} {{$llamada->lastname}}</td>
														
													@if ($data['isConfirmacion'] == 0)
														<td>{{$llamada->attribute_3}}</td>
														<td>{{$llamada->attribute_4}}</td>
													@else									
														<td>{{$llamada->attribute_3}}</td>
														<td>{{$llamada->attribute_4}} - {{$llamada->attribute_5}}</td>
													@endif
														
														<!-- Columna recuperar-->
													@if ($llamada->completed === 'N' and (($llamada->CONTACT === 'N' and $llamada->MOTIV === 'A1') OR ($llamada->CONTACT === 'A2' and $llamada->MOTIV === 'A1'))
														)
														<td><span class='orange'>{{$llamada->answer}}</span></td>
													@elseif(($llamada->CONTACT === 'N' and $llamada->MOTIV === 'A1') OR ($llamada->CONTACT === 'A2' and $llamada->MOTIV ==='A1'))
														<td><a href='../rellamar/{{$data['sid']}}/{{$llamada->tid}}'><span class='red! glyphicon glyphicon-refresh'></span> <span class='red'>{{$llamada->answer}}</span></td>	
													@else
														<td></td>
													@endif
														
													<!-- Columna intentos-->
														<td>
															@if ((-1*($llamada->intentos)+1) != 0)
																{{(-1*($llamada->intentos)+1)}}
															@endif	
														</td>
															
													<!-- Columna acceso encuesta-->												
														<td>
															@if ($llamada->completed === 'N')
																<a href='/limesurvey/index.php/survey/index/sid/{{$data['sid']}}/token/{{$llamada->token}}/lang//newtest/Y'><i class='fa fa-sign-in fa-2x'></i></a>
															@else
																<span style='red' class='glyphicon glyphicon-phone-alt' data-toggle='tooltip' data-placement='top' title='{{$llamada->completed}}'></span>
															@endif
														</td>
													</tr>
												@endforeach
											</tbody>		
										</table>
									</div>
								@else
									<div class="row"><p class="text-center">No se han encontrado resultados.</p></div>
								@endif
							</div>
						</div>
					</div>
					<!-- /.row -->
					@if( $data['totalPages'] >1)
		
						<div class="row">
							<div class="col-lg-12 text-center">
								<div class="panel panel-default">
									<div class="panel-body">
										<ul class="pagination">
											<!-- Filter information to include in pagination-->
											
												@foreach (range(1, $data['totalPages']) as $page)
													@if( $page == $data['page'] )
														<li class="active"><a href="{{$data['sid']}}?page={{$page}}{{$data['filterQuery']}}">{{$page}}</a></li>
													@elseif( $page == 1 || $page == $data['totalPages'] || ($page >= $data['page']- 2 && $page <= $data['page'] + 2))
														<li><a href="{{$data['sid']}}?page={{$page}}{{$data['filterQuery']}}">{{$page}}</a></li>
													@endif
												@endforeach
												
										</ul>
									</div>
								</div>
							</div>
						</div>	
					@endif	
					<!-- /.row -->
				</div>		
			</div>
		</div>
	</div>
</div>
<script>
		
		var input = document.getElementById("search-input");
		
		$('#search-clear').click(function(){ input.value=''; myNameSearchFunction();});
		
		search.addEventListener("keydown", function (e) {
			if (e.keyCode === 13) {  //checks whether the pressed key is "Enter"
				myNameSearchFunction(e);
			}
		});
		
		show_hide_icon();
		
		
		function hideIcon(self) {
			self.style.display = 'none';
			}
			
		function showIcon(self) {
			self.style.display = 'inline';
			}
		

		function show_hide_icon(){
		
			input = document.getElementById("search-input");
			filter = input.value.toUpperCase();
		
			if(filter.length >0) 
					showIcon(document.getElementById("search-clear"));
				else
					hideIcon(document.getElementById("search-clear"));
			}
		
		function myNameSearchFunction() {
		
			// Declare variables 
			var input, filter, table, tr, td, i;
			input = document.getElementById("search-input");
			filter = input.value.toUpperCase();
			
			//Reload page with filter name and page=1
			uri = window.location.href;
			
			uri=updateQueryStringParameter(uri,"page",1);
			//alert(uri);
		  	uri=updateQueryStringParameter(uri,"nameFilter",filter);
			//alert(uri);
			document.location = uri;
			}
			
		function updateQueryStringParameter(_uri, key, value) {
			
			var uri = _uri;
			
			var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
			var separator = uri.indexOf('?') !== -1 ? "&" : "?";
			
			if (uri.match(re)) {
				return uri.replace(re, '$1' + key + "=" + value + '$2');
			}
			else {
				return uri + separator + key + "=" + value;
			}
		}
</script>	
@endsection