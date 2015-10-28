@if (Session::has('status'))
	<div class="row">
		<div class="col-lg-9">
	    	<div class="alert alert-info alert-dismissable">
	        	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	           	<i class="fa fa-info-circle"></i> {{ Session::get('status') }}
	    	</div>
		</div>
	</div>
@endif