@extends('layouts.master')

@push('css')
<link href="{{ asset('assets') }}/css/plugins/select2/select2.min.css" rel="stylesheet">
<link href="{{ asset('assets') }}/css/plugins/select2/select2-bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Detail Jadwal</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <span><a href="{{ route('schedule.index') }}">Jadwal</a></span>
            </li>
            <li class="breadcrumb-item active">
                <strong>Detail</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Informasi Jadwal</u></h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Nama Dosen</b></label>
                                <p class="form-control-static">{{ $schedule->user->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>NIP</b></label>
                                <p class="form-control-static">{{ $schedule->user->nip }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Email</b></label>
                                <p class="form-control-static">{{ $schedule->user->email }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Takun Akademik</b></label>
                                <p class="form-control-static">{{ $schedule->academic_year }} {{ $schedule->type_periode }}</p>
                            </div>
                        </div>
                    </div>

                    <hr class="hr-line">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Data Jadwal</b></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        @if(auth()->user()->role->name == 'Admin' || auth()->user()->role->name == 'Staff')
                        <a class="btn btn-outline btn-sm btn-primary mb-2" href="{{ route('schedule-detail.create', ['scheduleId' => $schedule->id]) }}"><i class="fa fa-plus"></i> Tambah Jadwal</a>
                        @endif
                        <table class="table table-bordered table-hover" id="TableScheduleMatkul">
                            <thead>
                                <tr>
                                    <th width="1px">No</th>
                                    <th>Kode</th>
                                    <th>Matkul</th>
                                    <th>SKS</th>
                                    <th>Kelas</th>
                                    <th>Angkatan</th>
                                    <th>Hari / Waktu / Ruang</th>
                                    @if(auth()->user()->role->name == 'Admin' || auth()->user()->role->name == 'Staff')
                                    <th width="1px">#</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($schedule->detail as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->code }} ({{ $row->matkul->code }})</td>
                                    <td>{{ $row->matkul->name }}</td>
                                    <td>{{ $row->sks }}</td>
                                    <td>{{ $row->class->name }}</td>
                                    <td>{{ $row->class->angkatan }}</td>
                                    <td>{{ $row->day }} / {{ date('H:i', strtotime($row->start_time)) }} s.d {{ date('H:i', strtotime($row->end_time)) }} / {{ $row->room }}</td>
                                    @if(auth()->user()->role->name == 'Admin' || auth()->user()->role->name == 'Staff')
                                    <td class="btn-group pull-right">
                                        <button class="btn btn-sm btn-danger" id="delete" data-integrity="{{ $row->id }}" data-name="{{ $row->matkul->name }}"><i class="fa fa-trash"></i></button>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('script')
<script src="{{ asset('assets') }}/js/plugins/select2/select2.full.min.js"></script>
<script>
    $(document).ready(function() {

        function sweetalert(title, msg, type, timer = 60000, confirmButton = true) {
            swal({
                title: title,
                text: msg,
                type: type,
                timer: timer,
                showConfirmButton: confirmButton
            });
        }

        if ("{{ session('success') }}") {
            sweetalert('Berhasil', "{{ session('success') }}", null)
        }

        if ("{{ session('failed') }}") {
            sweetalert('Gagal', "{{ session('failed') }}", 'error', 60000)
        }

        $('#TableScheduleMatkul').DataTable({
            pageLength: 10,
            order: [
                [1, 'desc']
            ],
        })

        $(document).on('click', '#delete', function(e) {
            let id = $(this).data('integrity')
            let name = $(this).data('name')
            swal({
                title: "Hapus?",
                text: `Data "${name}" akan terhapus!`,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, hapus!",
                closeOnConfirm: false
            }, function() {
                swal.close()
                $.ajax({
                    url: "{{ route('schedule-detail.store') }}/" + id,
                    type: "DELETE",
                    dataType: 'json',
                    success: function(response) {
                        sweetalert('Berhasil', `Data berhasil dihapus.`, null, 500, false)
                        window.location.reload()
                    },
                    error: function(response) {
                        sweetalert('Tidak terhapus!', 'Terjadi kesalahan saat menghapus data.', 'error')
                        window.location.reload()
                    }
                })
            });
        })

    });
</script>
@endpush