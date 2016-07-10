@extends("admin.layouts.app")

@section('html.head.title', ucfirst($config['vars']))
@section('contentheader.title', ucfirst($config['vars']))
@section('contentheader.description', $config['description'])

@section("main-content")
<div class="box">
	<div class="box-header">
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				{!! Form::model($object, ['url' => $config['update_url'], 'method'=>'PUT']) !!}
                    @foreach($fields as list($name, $input))
                        <div class="form-group  {{$errors->has($name) ? 'has-error' : '' }}">
                            {!! Form::label($name, trans('validation.attributes.'.$name)) !!}
                            {!! $input !!}
                            {!! $errors->first($name, '<p class="help-block">:message</p>') !!}
                        </div>
                    @endforeach
					<br>
					<div class="form-group">
						{!! Form::submit( 'Enregistrer', ['class'=>'btn btn-success']) !!}
                        <a class="btn btn-default pull-right" href="{{ $config['cancel_url'] }}">Annuler</a>
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
            $("[rel=select2]").select2({
            });
            $("[rel=taginput]").select2({
                tags: true,
                tokenSeparators: [',']
            });
        });
    </script>
@endpush
