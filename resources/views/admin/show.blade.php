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
                    @foreach($fields as list($attribute, $result))
                        <div class="form-group">
                            <label for="name" class="col-md-3">{{ trans('validation.attributes.'.$attribute) }} :</label>
                            <div class="col-md-9 fvalue">
                                {!! $result !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
