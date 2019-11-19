@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/unidad_de_medidas') }}">Unidad de Medida</a> :
@endsection
@section("contentheader_description", $unidad_de_medida->$view_col)
@section("section", "Unidad de Medidas")
@section("section_url", url(config('laraadmin.adminRoute') . '/unidad_de_medidas'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Unidad de Medidas Edit : ".$unidad_de_medida->$view_col)

@section("main-content")

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="box">
	<div class="box-header">
		
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				{!! Form::model($unidad_de_medida, ['route' => [config('laraadmin.adminRoute') . '.unidad_de_medidas.update', $unidad_de_medida->id ], 'method'=>'PUT', 'id' => 'unidad_de_medida-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'NombreUnidad')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/unidad_de_medidas') }}">Cancel</a></button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
	$("#unidad_de_medida-edit-form").validate({
		
	});
});
</script>
@endpush
