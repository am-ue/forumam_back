@extends("admin.layouts.app")

@section('html.head.title', ucfirst($config['vars']))
@section('contentheader.title', ucfirst($config['vars']))
@section('contentheader.description', $config['description'])

@section('contentheader.elements', $config['elements'])

@section("main-content")

    <div class="box">
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
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.12/r-2.1.0/rr-1.1.2/datatables.min.css"/>
@endpush

@push('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.12/r-2.1.0/rr-1.1.2/datatables.min.js"></script>
<script>
    $(function () {
        var datatable = $("#index").DataTable({
            @if(isset($config['reorder_url']))
                rowReorder: {
                    update: false,
                    dataSrc: 'order'
                },
            @endif
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
                processing: "Traitement en cours...",
                info: "Affichage des {{ $config['vars'] }} _START_ &agrave; _END_ sur _TOTAL_ {{ $config['vars'] }}",
                infoEmpty: "Aucun(e) {{ $config['var'] }} trouvé(e)",
                infoFiltered: "(filtr&eacute; de _MAX_ {{ $config['vars'] }} au total)",
                infoPostFix: "",
                loadingRecords: "Chargement en cours...",
                zeroRecords: "Aucun(e) {{ $config['var'] }} trouvé(e)",
                emptyTable: "Aucun(e) {{ $config['var'] }} trouvé(e)",
                paginate: {
                    first: "<<",
                    previous: "<",
                    next: ">",
                    last: ">>"
                },
                aria: {
                    sSortAscending: ": activer pour trier la colonne par ordre croissant",
                    sSortDescending: ": activer pour trier la colonne par ordre d&eacute;croissant"
                },
                lengthMenu: "_MENU_",
                search: "_INPUT_",
                searchPlaceholder: "Recherche"
            },
            columnDefs: [{orderable: false, targets: [-1]}],
            fnDrawCallback: function(oSettings) {
                if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
                    $(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
                    var $indexInfo = $('#index_info');
                    $indexInfo.text('Affichage des ' + oSettings.fnRecordsDisplay() + ' {!! $config['vars'] !!}');
                    if (oSettings.fnRecordsDisplay() <= 1) {
                        $indexInfo.hide();
                    }
                } else {
                    $(oSettings.nTableWrapper).find('.dataTables_paginate').show();
                    $('ul.pagination li.paginate_button.disabled').remove();
                }

            }

        });
        @if(isset($config['reorder_url']))
            datatable.on('row-reorder', function ( e, diff ) {
                $.ajax({
                    url: "{{ $config['reorder_url'] }}",
                    type: 'POST',
                    data: JSON.stringify(diff),
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}',
                        'content-type': 'application/json'
                    },
                    success: function (data) {
                        datatable.ajax.reload(null, false);
                    },
                    error: function (data) {
                        alert('Problème ! merci de contacter l\'admin !');
                    }
                });
            });
        @endif
    });

</script>
@endpush