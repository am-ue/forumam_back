@extends("admin.layouts.app")

@section('html.head.title', ucfirst($config['vars']))
@section('contentheader.title', ucfirst($config['vars']))
@section('contentheader.description', $config['description'])

@section('contentheader.elements')
    <button class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Ajouter {{ $config['preps'][1] }} {{ $config['var'] }}</button>
@endsection

@section("main-content")

    <div class="box box-success">
        <!--<div class="box-header"></div>-->
        <div class="box-body">
            <table id="index" class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                    @foreach( $columns as $label => $value )
                        <th>{{$label }}</th>
                    @endforeach
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>


@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css"/>

@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>

<script>
    $(function () {
        $("#index").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ $config['ajax_url'] }}",
            columns: [
                @foreach( $columns as $label => $value )
                        {data: '{{$value}}', name: '{{$value}}'},
                @endforeach
                {data: 'actions', name: 'actions'}
            ],
            language: {
                'sProcessing': "Traitement en cours...",
                "sInfo": "",
                "sInfoEmpty": "Aucun {{ $config['var'] }} trouvé",
                "sInfoFiltered": "(filtr&eacute; de _MAX_ {{ $config['vars'] }} au total)",
                "sInfoPostFix": "",
                "sLoadingRecords": "Chargement en cours...",
                "sZeroRecords": "Aucun {{ $config['var'] }} trouvé",
                "sEmptyTable": "Aucun {{ $config['var'] }} trouvé",
                "oPaginate": {
                    "sFirst": "Premier",
                    "sPrevious": "Pr&eacute;c&eacute;dent",
                    "sNext": "Suivant",
                    "sLast": "Dernier"
                },
                "oAria": {
                    "sSortAscending": ": activer pour trier la colonne par ordre croissant",
                    "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                },
                lengthMenu: "_MENU_",
                search: "_INPUT_",
                searchPlaceholder: "Recherche"
            },
            columnDefs: [{orderable: false, targets: [-1]}]
        });
    });
</script>
@endpush