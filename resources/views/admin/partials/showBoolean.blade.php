@if($boolean)
    <div class="label label-success">{{ $true }}</div>
@else
    <div class='label label-danger'>{{ $false }}</div>
@endif