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
                    @foreach(\App\Models\Option::with('details')->orderBy('order')->get() as $option)
                        <div class="form-group">
                            <label class="col-md-3" for="name">{{ $option->name }} :</label>
                            <div class="col-md-2">
                                @if($option->type == 'checkbox')
                                    [ + {{  $option->details()->first()->price }} € ]
                                @elseif($option->type == 'int')
                                    [ x {{  $option->details()->first()->price }} € ]
                                @endif
                            </div>
                            <div class="col-md-7 fvalue">
                                @php($value = ($order = $option->orders()->whereCompanyId($company_id)->first()) ? $order->value : null)
                                @if($option->type == 'checkbox')
                                    {{ Form::checkbox($option->id, 1, $value, ['rel' => 'switch']) }}
                                @elseif($option->type == 'int')
                                     {{ Form::number($option->id, $value, ['class' => 'form-control', 'style' => 'width: 134px']) }}
                                @elseif($option->type == 'select')
                                    {{ Form::select(
                                        $option->id,
                                        $option->details->pluck('label_with_price', 'id'),
                                        $value,
                                        ['rel' => 'select2']
                                     ) }}
                                @endif
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
