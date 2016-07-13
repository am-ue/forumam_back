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
                    @foreach($fields as $attribute => $type)
                        <div class="form-group">
                            <label for="name" class="col-md-3">{{ trans('validation.attributes.'.$attribute) }} :</label>
                            <div class="col-md-9 fvalue">

                            @if($type == 'bool')
                                @if($object->$attribute)
                                    <div class="label label-success">Oui</div>
                                @else
                                    <div class='label label-danger'>Non</div>
                                @endif

                            @elseif($type == 'img')
                                    <a href="{{asset($object->$attribute)}}" target="_blank">
                                        <img src="{{asset($object->$attribute)}}" alt="{{$attribute}}" height = "100px">
                                    </a>

                            @elseif($type == 'date')
                                {{$object->$attribute->toFormattedDateString()}}

                            @elseif($type == 'url')
                                {{ link_to($object->$attribute) }}

                            @elseif($type == 'txt')
                                {{ $object->$attribute }}

                            @else
                                @php($custom_field = $type)
                                {!! $custom_field !!}

                            @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
