@extends("admin.layouts.app")

@section('html.head.title', 'Ma commande')
@section('contentheader.title', 'Ma commande')
@section('contentheader.description', 'Le résumé')

@section('contentheader.elements', $config['elements'])

@section("main-content")
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{\App\Models\Order::totalPrice($company_id) ?: '0'}}</h3>
                    <p>Montant total</p>
                </div>
                <div class="icon">
                    <i class="fa fa-euro"></i>
                </div>
                <a href="#" class="small-box-footer">Voir ma facture <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    @php($people_count = \App\Models\Order::whereCompanyId($company_id)->whereOptionId(2)->sum('value'))
                    <h3>{{ $people_count }}</h3>
                    <p>Personnes présentes</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user"></i>
                </div>
                <a href={{ action('Admin\OrderController@edit', $company_id) }} class="small-box-footer">Editer la commande <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-orange">
                <div class="inner">
                    <h3>{{ \App\Models\Badge::whereCompanyId($company_id)->count() }}/{{ $people_count }}</h3>
                    <p>Badges édités</p>
                </div>
                <div class="icon">
                    <i class="fa fa-ticket"></i>
                </div>
                <a href={{ action('Admin\BadgeController@edit', $company_id) }} class="small-box-footer">Editer les badges <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ \App\Models\Company::find($company_id)->completePercentage() }}</h3>
                    <p>Remplissage profile</p>
                </div>
                <div class="icon">
                    <i class="fa fa-percent"></i>
                </div>
                @if(\App\Models\Company::find($company_id)->public)
                    <a href="{{ action('Admin\CompanyController@edit', $company_id) }}" class="small-box-footer" style="width: 49.6%;display: inline-block;">Remplir mes infos <i class="fa fa-arrow-circle-right"></i></a>
                    <a href="{{ config('app.url') }}/#/exposants/{{ $company_id }}" class="small-box-footer" style ="width: 49.6%;display: inline-block;">Voir ma fiche <i class="fa fa-arrow-circle-right"></i></a>
                @else
                    <a href="{{ action('Admin\CompanyController@edit', $company_id) }}" class="small-box-footer">Remplir mes infos <i class="fa fa-arrow-circle-right"></i></a>
                @endif
            </div>
        </div><!-- ./col -->
    </div>
    <div class="box">
        <!--<div class="box-header"></div>-->
        <div class="box-body">
            <table id="index" class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                    @foreach( $columns as $label => $value )
                        <th>{{$label }}</th>
                    @endforeach
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

</script>
@endpush