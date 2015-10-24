@extends('layouts.app2')
@section('content')

{!! Html::style('assets/css/dashboard.css') !!}
{!! Html::style('assets/css/sb-admin.css') !!} 
{!! Html::style('assets/css/llamadas.css') !!}

<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
		<li>
			<a href="../admin"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
        </li>
		<li>
			<a href="operadores"><i class="fa fa-fw fa-group"></i> Operadores</a>
		</li>
		<li>
			<a href="#"><i class="fa fa-fw fa-edit"></i> Configuración</a>
		</li>
	</ul>
</div>
<!-- /.navbar-collapse -->

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Registro de parametros {{$data['survey_title']}}</div>
				
				
				<div class="panel-body">

                        <div class="form-group">
						    {!! Form::open(array('url' => 'settings/url')) !!} 
                            
							<label>{!! Form::label('urlLanguage', 'URL language') !!}</label>
                        
						<div class="row">
							{!! Form::text('url',$data['surveyls_url']) !!}
						
							<a href="javascript:getUrl();" class="btn btn-info"><span data-toggle='tooltip' data-placement='top' title='Recalcular'><i class="fa fa-refresh"></i></span></a>
							<a href="javascript: document.urlForm.submit();" class="btn btn-info"><span data-toggle='tooltip' data-placement='top' title='Guardar'><i class="fa fa-floppy-o"></i></span></a>
							
							{!! Form::submit('Guardar',['class' => 'btn btn-default']) !!} 
						</div>
						{!! Form::close() !!}	
                        </div>
						
						<div class="form-group">
						    {!! Form::open(array('url' => 'settings/url')) !!} 
                            
							<label>{!! Form::label('urlTitle', 'URL title') !!}</label>
							
							<div class="row">
								{!! Form::text('title',$data['surveyls_urldescription']) !!}
								<a href="javascript:getUrl();" class="btn btn-info"><span data-toggle='tooltip' data-placement='top' title='Recalcular'><i class="fa fa-refresh"></i></span></a>
								<a href="javascript: document.urlForm.submit();" class="btn btn-info"><span data-toggle='tooltip' data-placement='top' title='Guardar'><i class="fa fa-floppy-o"></i></span></a>
								{!! Form::submit('Guardar',['class' => 'btn btn-default']) !!} 
							</div>
						
						{!! Form::close() !!}	
                        </div>
						
						<div class="form-group">
						    {!! Form::open(array('url' => 'settings/url')) !!} 
                            
							<label>{!! Form::label('plugginSettings', 'Pluggins settings') !!}</label>
                        
						<div class="row">
							{!! Form::text('plugSettings',$data['pluggins_settings']) !!}
						
							<a href="javascript:getUrl();" class="btn btn-info"><span data-toggle='tooltip' data-placement='top' title='Recalcular'><i class="fa fa-refresh"></i></span></a>
							<a href="javascript: document.urlForm.submit();" class="btn btn-info"><span data-toggle='tooltip' data-placement='top' title='Guardar'><i class="fa fa-floppy-o"></i></span></a>
							
							{!! Form::submit('Guardar',['class' => 'btn btn-default']) !!} 
						</div>
						{!! Form::close() !!}	
                        </div>
												
						

						
						
						
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection