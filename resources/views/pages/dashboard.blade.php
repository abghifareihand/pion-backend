@extends('layouts.master')

@section('title')
    Dashboard
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Header Create -->
            <div class="col-md-12">
                <div class="card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        {{-- Teks di kiri --}}
                        <h5 class="fw-bold mb-0">Dashboard</h5>
                    </div>
                </div>
            </div>

            <!-- Start Baris 1 -->

            {{-- Card 1 --}}
            <div class="col-sm-6 col-xl-4 col-lg-6">
                <div class="card o-hidden border-0">
                    <div class="bg-primary b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center"><i data-feather="users"></i></div>
                            <div class="media-body">
                                <span class="m-0">Users</span>
                                <h4 class="mb-0 counter">{{ $totalUsers }}</h4>
                                <i class="icon-bg" data-feather="users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 2 --}}
            <div class="col-sm-6 col-xl-4 col-lg-6">
                <div class="card o-hidden border-0">
                    <div class="bg-primary b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center"><i data-feather="edit"></i></div>
                            <div class="media-body">
                                <span class="m-0">Informations</span>
                                <h4 class="mb-0 counter">{{ $totalInformations }}</h4>
                                <i class="icon-bg" data-feather="edit"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 3 --}}
            <div class="col-sm-6 col-xl-4 col-lg-6">
                <div class="card o-hidden border-0">
                    <div class="bg-primary b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center"><i data-feather="layers"></i></div>
                            <div class="media-body">
                                <span class="m-0">Learnings</span>
                                <h4 class="mb-0 counter">{{ $totalLearnings }}</h4>
                                <i class="icon-bg" data-feather="layers"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- End Baris 1 -->

            <!-- Start Baris 2 -->

            {{-- Card 1 --}}
            <div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden border-0">
                    <div class="bg-primary b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center"><i data-feather="dollar-sign"></i></div>
                            <div class="media-body">
                                <span class="m-0">Financials</span>
                                <h4 class="mb-0 counter">{{ $totalFinancials }}</h4>
                                <i class="icon-bg" data-feather="dollar-sign"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 2 --}}
            <div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden border-0">
                    <div class="bg-primary b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center"><i data-feather="globe"></i></div>
                            <div class="media-body">
                                <span class="m-0">Organizations</span>
                                <h4 class="mb-0 counter">{{ $totalOrganizations }}</h4>
                                <i class="icon-bg" data-feather="globe"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 3 --}}
            <div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden border-0">
                    <div class="bg-primary b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center"><i data-feather="share-2"></i></div>
                            <div class="media-body">
                                <span class="m-0">Socials</span>
                                <h4 class="mb-0 counter">{{ $totalSocials }}</h4>
                                <i class="icon-bg" data-feather="share-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 4 --}}
            <div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden border-0">
                    <div class="bg-primary b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="align-self-center text-center"><i data-feather="check-square"></i></div>
                            <div class="media-body">
                                <span class="m-0">Votes</span>
                                <h4 class="mb-0 counter">{{ $totalVotes }}</h4>
                                <i class="icon-bg" data-feather="check-square"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- End Baris 2 -->


            {{-- Table --}}
            <div class="col-xl-12 recent-order-sec">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <h5>Recent Orders</h5>
                            <table class="table table-bordernone">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Quantity</th>
                                        <th>Value</th>
                                        <th>Rate</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="media"><img class="img-fluid rounded-circle"
                                                    src="{{ asset('assets/images/dashboard/product-1.png') }}"
                                                    alt="" data-original-title="" title="">
                                                <div class="media-body"><a href="#"><span>Yellow New Nike
                                                            shoes</span></a></div>
                                            </div>
                                        </td>
                                        <td>
                                            <p>16 August</p>
                                        </td>
                                        <td>
                                            <p>54146</p>
                                        </td>
                                        <td><img class="img-fluid" src="{{ asset('assets/images/dashboard/graph-1.png') }}"
                                                alt="" data-original-title="" title=""></td>
                                        <td>
                                            <p>$210326</p>
                                        </td>
                                        <td>
                                            <p>Done</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="media"><img class="img-fluid rounded-circle"
                                                    src="{{ asset('assets/images/dashboard/product-2.png') }}"
                                                    alt="" data-original-title="" title="">
                                                <div class="media-body"><a href="#"><span>Sony Brand New
                                                            Headphone</span></a></div>
                                            </div>
                                        </td>
                                        <td>
                                            <p>2 October</p>
                                        </td>
                                        <td>
                                            <p>32015</p>
                                        </td>
                                        <td><img class="img-fluid" src="{{ asset('assets/images/dashboard/graph-2.png') }}"
                                                alt="" data-original-title="" title=""></td>
                                        <td>
                                            <p>$548526</p>
                                        </td>
                                        <td>
                                            <p>Done</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="media"><img class="img-fluid rounded-circle"
                                                    src="{{ asset('assets/images/dashboard/product-3.png') }}"
                                                    alt="" data-original-title="" title="">
                                                <div class="media-body"><a href="#"><span>Beautiful Golden
                                                            Tree plant</span></a></div>
                                            </div>
                                        </td>
                                        <td>
                                            <p>21 March</p>
                                        </td>
                                        <td>
                                            <p>12548</p>
                                        </td>
                                        <td><img class="img-fluid" src="{{ asset('assets/images/dashboard/graph-3.png') }}"
                                                alt="" data-original-title="" title=""></td>
                                        <td>
                                            <p>$589565</p>
                                        </td>
                                        <td>
                                            <p>Done</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="media"><img class="img-fluid rounded-circle"
                                                    src="{{ asset('assets/images/dashboard/product-4.png') }}"
                                                    alt="" data-original-title="" title="">
                                                <div class="media-body"><a href="#"><span>Marco M Kely
                                                            Handbeg</span></a></div>
                                            </div>
                                        </td>
                                        <td>
                                            <p>31 December</p>
                                        </td>
                                        <td>
                                            <p>15495</p>
                                        </td>
                                        <td><img class="img-fluid"
                                                src="{{ asset('assets/images/dashboard/graph-4.png') }}" alt=""
                                                data-original-title="" title=""></td>
                                        <td>
                                            <p>$125424 </p>
                                        </td>
                                        <td>
                                            <p>Done</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="media"><img class="img-fluid rounded-circle"
                                                    src="{{ asset('assets/images/dashboard/product-5.png') }}"
                                                    alt="" data-original-title="" title="">
                                                <div class="media-body"><a href="#"><span>Being Human
                                                            Branded T-Shirt </span></a></div>
                                            </div>
                                        </td>
                                        <td>
                                            <p>26 January</p>
                                        </td>
                                        <td>
                                            <p>56625</p>
                                        </td>
                                        <td><img class="img-fluid"
                                                src="{{ asset('assets/images/dashboard/graph-5.png') }}" alt=""
                                                data-original-title="" title=""></td>
                                        <td>
                                            <p>$112103</p>
                                        </td>
                                        <td>
                                            <p>Done</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
