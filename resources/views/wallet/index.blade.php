@extends('layouts.master')
@section('page.name', __('Wallet'))
@section('page.body')
    <wallet-page inline-template>
        <div class="content-wrapper">

            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{__('Wallet')}}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            {{ Breadcrumbs::render('wallet') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-detached content-right">
                <div class="content-body">
                    <section class="row">
                        <div class="col-12">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in show" id="bitcoin"
                                     aria-labelledby="bitcoin-tab" aria-expanded="true">
                                    @include('wallet.partials.tabs.bitcoin')
                                </div>


                                <div role="tabpanel" class="tab-pane fade" id="komodo"
                                     aria-labelledby="komodo-tab" aria-expanded="true">
                                    @include('wallet.partials.tabs.komodo')
                                </div>


                                <div role="tabpanel" class="tab-pane fade" id="ethereum"
                                     aria-labelledby="ethereum-tab" aria-expanded="true">
                                    @include('wallet.partials.tabs.ethereum')
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <div class="sidebar-detached sidebar-left">
                <div class="sidebar">
                    <div class="bug-list-sidebar-content">
                        <!-- Predefined Views -->
                        <div class="card">
                            <div class="card-head">
                                <div class="card-header">
                                    <h4 class="card-title">{{__('Navigation')}}</h4>
                                </div>
                            </div>
                            <div class="card-content">
                                <!-- Groups -->
                                <div class="card-body">
                                    <ul class="nav nav-pills nav-pill-with-active-bordered flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="bitcoin-tab" data-toggle="pill"
                                               href="#bitcoin" role="tab" aria-controls="bitcoin" aria-expanded="true">
                                                <i class="cc BTC-alt"></i> Bitcoin
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" id="komodo-tab" data-toggle="pill"
                                               href="#komodo" role="tab" aria-controls="komodo" aria-expanded="true">
                                                <i class="cc KMD-alt"></i> Komodo
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" id="ethereum-tab" data-toggle="pill"
                                               href="#ethereum" role="tab" aria-controls="ethereum" aria-expanded="true">
                                                <i class="cc ETH-alt"></i> Ethereum
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </wallet-page>

@endsection

@push('data')
    <script type="text/javascript">
        window._tableData = [
            // Bitcoin
            {
                'selector': '#bitcoin-address-list',
                'options': {
                    "ajax": {
                        "async": true,
                        "url": '{{route('wallet.address-data', ['coin' => 'btc'])}}',
                        "type": "POST",
                    },

                    columns: [
                        {data: null, defaultContent: ''},
                        {data: 'address', orderable: false},
                        {data: 'created_at', searchable: false}
                    ],

                    "order": [
                        [2, 'desc']
                    ],
                }
            },

            {
                'selector': '#bitcoin-transaction-list',
                'options': {
                    "ajax": {
                        "async": true,
                        "url": '{{route('wallet.transaction-data', ['coin' => 'btc'])}}',
                        "type": "POST",
                    },

                    ordering: false,

                    columns: [
                        {data: null, defaultContent: ''},
                        {data: 'type'},
                        {data: 'value'},
                        {data: 'date', orderable: false},
                        {data: 'confirmations'},
                    ]
                }
            },


            // Komodo
            {
                'selector': '#komodo-address-list',
                'options': {
                    "ajax": {
                        "async": true,
                        "url": '{{route('wallet.address-data', ['coin' => 'kmd'])}}',
                        "type": "POST",
                    },

                    columns: [
                        {data: null, defaultContent: ''},
                        {data: 'address', orderable: false},
                        {data: 'created_at', searchable: false}
                    ],

                    "order": [
                        [2, 'desc']
                    ],
                }
            },

            {
                'selector': '#komodo-transaction-list',
                'options': {
                    "ajax": {
                        "async": true,
                        "url": '{{route('wallet.transaction-data', ['coin' => 'kmd'])}}',
                        "type": "POST",
                    },

                    ordering: false,

                    columns: [
                        {data: null, defaultContent: ''},
                        {data: 'type'},
                        {data: 'value'},
                        {data: 'date', orderable: false},
                        {data: 'confirmations'},
                    ]
                }
            },
            
        ]
    </script>
@endpush

