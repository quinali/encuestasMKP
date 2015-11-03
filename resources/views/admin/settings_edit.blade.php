@extends('layouts.app2')
@section('content')

	<div class="collapse navbar-collapse navbar-ex1-collapse">
	    <ul class="nav navbar-nav side-nav">
			<li>
				<a href="../../survey/{{$data['sid']}}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
	        </li>
			<li>
				<a href="operadores"><i class="fa fa-fw fa-group"></i> Operadores</a>
			</li>
			<li class="active" >
				<a href="#"><i class="fa fa-fw fa-edit"></i> Configuración</a>
			</li>
	        <li>
	            <a href="dispatch"><i class="fa fa-fw fa-refresh"></i> Asignación</a>
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
                        <i class="fa fa-dashboard"></i> Encuesta</li>
                             <li>
                                <i class="fa fa-edit"></i>
                                <a href='#'> Configuración</a>
                            </li>
                        </ol>
                    </div>
                </div>    
                <!-- /.row -->
                <!-- Zona del mensaje -->
               	@include('mensaje')
                <!-- /.row -->



	    <div class="row">
	    	<div class="col-lg-9">
	    		
	    		<div class="panel panel-default">
		    		<div class="panel-heading">
	                	<h3 class="panel-title"><i class="fa fa-edit fa-fw"></i> Configuración de encuesta</h3>
	                </div>
					
					<div class="panel-body">
						<div class="row">
							
							{!! Form::open(['route' => ['url.updateSetting', $data["sid"]] , 'method' => 'post']) !!} 
                            <div class="col-lg-6" >	
				                <div class="form-group">
									<label>{!! Form::label('urlLanguage', 'URL language') !!}</label>
			                		<div class="row">
										<div class="col-lg-12" >	
											{!! Form::text('url',$data['surveyls_url'],['id'=>'url','size'=>'50']) !!}
											{!! Form::hidden('sid',$data['sid']) !!}

											<a href="javascript:getUrl();" class="btn btn-info"><span data-toggle='tooltip' data-placement='top' title='Recalcular URL'><i class="fa fa-refresh"></i></span></a>
												
										</div>
									</div>
							    </div>
								
								<div class="form-group">
									<label>{!! Form::label('urlTitle', 'URL title') !!}</label>
									
									<div class="row">
										<div class="col-lg-12" >	
											{!! Form::text('title',$data['surveyls_urldescription'],['id'=>'title','size'=>'50']) !!}
											{!! Form::hidden('sid',$data['sid']) !!}

											<a href="javascript:getUrlTitle();" class="btn btn-info"><span data-toggle='tooltip' data-placement='top' title='Recalcular'><i class="fa fa-refresh"></i></span></a>
										</div>
									</div>
								</div>

		                        <div class="form-group">
								    <div class="row">
								    	<div class="col-lg-12" >	
										<label>{!! Form::label('isConfirmacion', 'Campaña de confirmación') !!}</label>
									
										{!! Form::checkbox('isConfirmation','value',$data['pluggins_settings_isConfirmation']) !!}
										{!! Form::hidden('sid',$data['sid']) !!}

									</div>
									
									</div>
								
								{!! Form::close() !!}	
		                        </div>
		                        <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
					    </div>
					</div>
					<!-- ./row -->
		        </div>
		    </div>
		</div>
	</div>
	<!-- ./row -->	
@endsection


@section('scripts')
<script>


function getUrl(){

		$.ajax({
                url:   'settings/url',
                type:  'get',
                success:  function (data) {
                      $("#url").val(data);
                }
        });
}


function getUrlTitle(){

		$.ajax({
                url:   'settings/urlTitle',
                type:  'get',
                beforeSend: function () {
                        $("#resultado").html("Procesando, espere por favor...");
                },
                success:  function (data) {
  
                    $("#title").val(data);
                }
        });
}


function getPluginSetting(){

		$.ajax({
                url:   'settings/pluginSetting',
                type:  'get',
                beforeSend: function () {
                        $("#resultado").html("Procesando, espere por favor...");
                },
                success:  function (data) {
  
                    $("#plugginSettings").val(data);
                }
        });
}

</script>
@endsection