@extends('layouts.master')

@section('title')
    Data Pesan
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <style>
        .table-responsive table {
            white-space: nowrap;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Header Create -->
            <div class="col-md-12">
                <div class="card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        {{-- Teks di kiri --}}
                        <h5 class="fw-bold mb-0">Data Pesan</h5>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">

                        {{-- Alert sukses --}}
                        @if (session('success'))
                            <div class="alert alert-soft-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Table untuk list tickets --}}
                        @if ($tickets->count() > 0)
                            <div class="table-responsive">
                                <table class="display" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th class="dt-col-no">No</th>
                                            <th>Nama</th>
                                            <th>Tipe</th>
                                            <th>Status</th>
                                            <th>Tanggal Pesan</th>
                                            <th>PDF</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tickets as $ticket)
                                            <tr>
                                                <td class="dt-col-no">{{ $loop->iteration }}</td>
                                                <td>{{ $ticket->user->name }}</td>

                                                {{-- Badge untuk TYPE --}}
                                                <td>
                                                    @if ($ticket->type == 'report')
                                                        <span class="badge badge-report">Report</span>
                                                    @elseif($ticket->type == 'question')
                                                        <span class="badge badge-question">Question</span>
                                                    @else
                                                        <span class="badge badge-suggestion">Suggestion</span>
                                                    @endif
                                                </td>


                                                {{-- Badge untuk STATUS --}}
                                                <td>
                                                    @switch($ticket->status)
                                                        @case('pending')
                                                            <span class="badge badge-pending">Pending</span>
                                                        @break

                                                        @case('responded')
                                                            <span class="badge badge-responded">Responded</span>
                                                        @break

                                                        @case('processed')
                                                            <span class="badge badge-processed">Processed</span>
                                                        @break

                                                        @case('done')
                                                            <span class="badge badge-done">Done</span>
                                                        @break

                                                        @case('rejected')
                                                            <span class="badge badge-rejected">Rejected</span>
                                                        @break
                                                    @endswitch
                                                </td>

                                                <td>{{ $ticket->created_at->format('d/m/y H:i') }}</td>



                                                <td>
                                                    <a href="{{ route('tickets.pdf', $ticket->id) }}"
                                                        class="btn-premium btn-premium-success" target="_blank">
                                                        <i class="fa fa-file-pdf-o"></i> Dengan File
                                                    </a>

                                                    <a href="{{ route('tickets.pdf', $ticket->id) }}?hide_attachment=1"
                                                        class="btn-premium btn-premium-warning" target="_blank">
                                                        <i class="fa fa-file-pdf-o"></i> Tanpa File
                                                    </a>

                                                    @if ($ticket->attachment)
                                                        <a href="{{ url('storage/' . $ticket->attachment) }}"
                                                            target="_blank" class="btn-premium btn-premium-light">
                                                            <i class="fa fa-eye"></i> Lihat File
                                                        </a>
                                                    @endif
                                                </td>

                                                <td>
                                                    <!-- Reply button -->
                                                    <a href="{{ route('tickets.edit', $ticket->id) }}"
                                                        class="btn btn-success btn-xs">
                                                        Balas
                                                    </a>

                                                    <!-- Delete button -->
                                                    <a href="#" class="btn btn-danger btn-xs"
                                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                        data-action="{{ route('tickets.destroy', $ticket->id) }}"
                                                        data-name="{{ $ticket->name }}">
                                                        Hapus
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center p-5">
                                <span class="text-muted">Tidak ada data pesan</span>
                            </div>
                        @endif
                        {{-- End Table --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Delete (global) --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus pesan ini <strong id="deleteItemName"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-light" type="button" data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-danger" type="submit">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Delete --}}



    @push('scripts')
        <!-- Script delete -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const deleteModal = document.getElementById('deleteModal');
                const deleteForm = document.getElementById('deleteForm');
                const deleteItemName = document.getElementById('deleteItemName');

                document.querySelectorAll('.btn-danger[data-bs-target="#deleteModal"]').forEach(btn => {
                    btn.addEventListener('click', function() {
                        deleteForm.action = this.dataset.action;
                        deleteItemName.textContent = this.dataset.name;
                    });
                });
            });
        </script>

        <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
    @endpush
@endsection
