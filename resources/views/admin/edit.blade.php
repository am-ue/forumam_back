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
                @foreach($fields as $label => $field)
                        <div class="form-group">
                            {!! Form::label($field[0], $label) !!}
                            {!! $field[1] !!}
                            {{ $errors->first($field[0], '<p class="help-block">:message</p>') }}
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
