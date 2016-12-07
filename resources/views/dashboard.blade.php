@extends('admin.layouts.app')

@section('html.head.title', 'Dashboard')
@section('contentheader.title', 'Forum Arts et Métiers')
@section('contentheader.description', 'Espace d\'administration')

@section('main-content')
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ \App\Models\Company::count() }}</h3>
                    <p>Entreprises (dont {{App\Models\Company::showable()->count()}} publiques)</p>
                </div>
                <div class="icon">
                    <i class="fa fa-building"></i>
                </div>
                <a href="{{action('Admin\DownloadController@companies')}}" class="small-box-footer">Exporter <i class="fa fa-arrow-circle-down"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ \App\Models\Order::count() }}</h3>
                    <p>Produits commandés</p>
                </div>
                <div class="icon">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <a href="{{action('Admin\DownloadController@products')}}" class="small-box-footer">Exporter <i class="fa fa-arrow-circle-down"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ \App\Models\Badge::count() }}</h3>
                    <p>Badges</p>
                </div>
                <div class="icon">
                    <i class="fa fa-ticket"></i>
                </div>
                <a href="{{action('Admin\DownloadController@badges')}}" class="small-box-footer">Exporter <i class="fa fa-arrow-circle-down"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ \App\Models\Order::totalPrice() }}</h3>
                    <p>Montant total</p>
                </div>
                <div class="icon">
                    <i class="fa fa-euro"></i>
                </div>
                <a href="{{action('Admin\DownloadController@results')}}" class="small-box-footer">Exporter <i class="fa fa-arrow-circle-down"></i></a>
            </div>
        </div><!-- ./col -->
    </div><!-- /.row -->
@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.12/r-2.1.0/rr-1.1.2/datatables.min.css"/>
@endpush

@push('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.12/r-2.1.0/rr-1.1.2/datatables.min.js"></script>
{{--<script>
    $(function () {
        $("#index").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ $config['ajax_url'] }}",
            columns: [
                    @foreach( $columns as $label => $value )
                {data: '{{$value}}', name: '{{$value}}'},
                @endforeach
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
    });

</script>--}}
@endpush
