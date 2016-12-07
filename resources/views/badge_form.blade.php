@extends("admin.layouts.app")

@section('html.head.title', ucfirst($config['vars']))
@if(isset($config['header']))
    @php $no_header = true; $no_padding = "no-padding" @endphp
@else
    @section('contentheader.title', ucfirst($config['var']))
@section('contentheader.description', $config['description'])
@section('contentheader.elements', $config['elements'])

@endif
@section('main-content')
    <div id="page-content" class="profile2">
        @if(isset($config['header']))
            @include($config['header'])
        @endif
        <div>
            <div class="panel infolist">
                <div class="panel-body">
                    {!! Form::open(['url' => $config['store_url'], 'method'=>'POST']) !!}
                    @foreach($badges as $key => $badge)
                        <div class="form-group">
                            <div class="col-md-2" >Invité n°{{ $key }} :</div>
                            <div class="col-md-3 fvalue">
                                {{ Form::text($key.'[first_name]', $badge->first_name, ['class' => 'form-control', 'placeholder' => 'Prénom']) }}
                            </div>
                            <div class="col-md-3 fvalue">
                                {{ Form::text($key.'[last_name]', $badge->last_name, ['class' => 'form-control', 'placeholder' => 'Nom']) }}
                            </div>
                        </div>
                    @endforeach
                    <br>
                    <div class="form-group">
                        {!! Form::submit( 'Enregistrer', ['class'=>'btn btn-success']) !!}
                        {!! link_to_action('Admin\OrderController@index', 'Annuler', $company_id, ['class' => 'btn btn-default pull-right']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src={{ asset('js/forms.js') }}></script>
@endpush
