<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">{{ $config['title'] }}</h4>
</div>
{!! Form::open(['url' => $config['store_url'], 'class' => 'bootstrap-modal-form', 'file' => true]) !!}
<div class="modal-body">
    <div class="box-body">
        @foreach($fields as list($name, $input))
            <div class="form-group">
                {!! Form::label($name, trans('validation.attributes.'.$name)) !!}
                {!! $input !!}
            </div>
        @endforeach
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
    {!! Form::submit( 'Créer', ['class'=>'btn btn-success']) !!}
</div>
{!! Form::close() !!}

<script src="{{ asset('js/modal-forms.js') }}" type="text/javascript"></script>
<script src={{ asset('js/forms.js') }}></script>

