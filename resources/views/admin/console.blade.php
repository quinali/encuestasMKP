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
               	@include('mensaje')
                <!-- /.row -->
					
				<div class="row">
                    	<div class="col-lg-12">
                    		<div class="panel panel-default">
	                            <div class="panel-heading">
	                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Encuestas</h3>
	                            </div>
								
								<div class="row">
									<div class="col-md-10 col-sm-9">
										<section id="search">
											<label for="search-input"><i class="fa fa-search" aria-hidden="true"></i><span class="sr-only">Buscar por cliente</span></label>
											<input id="search-input" class="form-control input-lg" placeholder="Nombre de cliente..." autocomplete="off" spellcheck="false" autocorrect="off" tabindex="1" onkeyup="show_hide_icon()"
											 
											 @if(!empty($filterName))
												value="{{ $filterName }}"
											 @endif
											 >
											
											
											<a id="search-clear" onclick="pageReload();" class="fa fa-times-circle" aria-hidden="true"><span class="sr-only">Clear search</span></a>
										</section>
									</div>
								</div>
								
                          		<div class="panel-body">
													<div class="table-responsive">
														<table id="encuestas" class="kkk table table-bordered table-hover">
															<thead>
																<tr>
																	<th>Encuesta</th>
																	<th>Activa</th>
																	<th>Acceso</th>
																</tr>
															</thead>
															<tbody>

																@foreach ($surveys as $survey)
							
																	<tr class='alt'>
																		<td>{{ $survey->surveyls_title }}</td>
																		<td>
																			@if( $survey->expires == null)
																				Y
																			@else
																				N	
																			@endif			
																		</td>
																		<td><a href='survey/{{$survey->sid }}'><i class='fa fa-sign-in fa-2x'></i></a></td>
																	</tr>
																
																@endforeach

															</tbody>
														</table>
													</div>
													<div class="row" style="float: none; margin-left: auto; margin-right: auto;">
														<div class="col-md-12 col-md-offset-1">
															{!! $surveys->appends(['filterName' => $filterName])->render() !!}
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
		
		<script>
		
		var input = document.getElementById("search-input");
		
		$('#search-clear').click(function(){ input.value=''; mySearchFunction();});
		
		search.addEventListener("keydown", function (e) {
			if (e.keyCode === 13) {  //checks whether the pressed key is "Enter"
				mySearchFunction(e);
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
		
		function mySearchFunction() {
		
			// Declare variables 
			var input, filter, table, tr, td, i;
			input = document.getElementById("search-input");
			filter = input.value.toUpperCase();
			
			//Reload page with filter name and page=1
			uri = window.location.href;
			
			uri=updateQueryStringParameter(uri,"page",1);
			//alert(uri);
		  	uri=updateQueryStringParameter(uri,"filterName",filter);
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
