@extends("admin.layouts.app")

@section('html.head.title', ucfirst($config['vars']))
@if(isset($config['header']))
    @php $no_header = true; $no_padding = "no-padding" @endphp
@else
    @section('contentheader.title', ucfirst($config['vars']))
    @section('contentheader.description', $config['description'])
@endif
@section('main-content')
    <div id="page-content" class="profile2">
        @if(isset($config['header']))
            @include($config['header'])
        @endif
        <div>
            <div class="panel infolist">
                <div class="panel-body">
                    @foreach($columns as $label => $value)
                        <div class="form-group">
                            <label for="name" class="col-md-2">{{ $label }}:</label>
                            <div class="col-md-10 fvalue">{{ $value }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
