@extends('layouts.master')

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
        <div class="col-lg-5">
            <div class="ibox-title">
                <h5>List Matkul</u></h5>
            </div>
            <div class="ibox-content">
                <form action="{{ route('schedule-matkul.store') }}" method="POST">
                    @csrf
                    @method('POST')

                    <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">

                    <div class="form-group pb-2">
                        <table class="table table-bordered table-hover" id="TableListMatkul">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Matkul</th>
                                    <th>Semester</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($matkuls as $matkul)
                                <tr>
                                    @php $isExist = false @endphp
                                    @foreach ($schedule->matkuls as $scheduleMatkul)

                                    @if ($matkul->id == $scheduleMatkul->matkul->id)
                                    @php $isExist = true @endphp
                                    @endif

                                    @endforeach

                                    @if ($isExist)
                                    <td><input type="checkbox" value="{{ $matkul->id }}" checked="" disabled></td>
                                    @else
                                    <td><input type="checkbox" name="matkul_ids[]" value="{{ $matkul->id }}"></td>
                                    @endif
                                    <td>({{ $matkul->code }}) {{ $matkul->name }} </td>
                                    <td>{{ $matkul->semester }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <hr class="hr-line">
                        <button class="btn btn-outline btn-sm btn-primary float-right" type="submit"><i class="fa fa-plus"></i> Tambahkan Matkul</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-7">

            <div class="ibox">
                <div class="ibox-title">
                    <h5>Informasi Jadwal</u></h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Dosen</b></label>
                                <p class="form-control-static">{{ $schedule->user->name }} ({{ $schedule->user->email }})</p>
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
                                <label><b>Takun Akademik</b></label>
                                <p class="form-control-static">{{ $schedule->academic_year }}</p>
                            </div>
                        </div>
                    </div>

                    <hr class="hr-line">

                    <div class="form-group">
                        <label><b>Jadwal Matkul</b></label>
                        <table class="table table-bordered table-hover" id="TableScheduleMatkul">
                            <thead>
                                <tr>
                                    <th width="1px">No</th>
                                    <th>Matkul</th>
                                    <th>Semester</th>
                                    <th width="1px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schedule->matkuls as $matkul)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>({{ $matkul->matkul->code }}) {{ $matkul->matkul->name }}</td>
                                    <td>{{ $matkul->matkul->semester }}</td>
                                    <td class="btn-group pull-right">
                                        <a class="btn btn-sm btn-success" href="{{ route('schedule-matkul.show', $matkul->id) }}"><i class="fa fa-eye"></i></a>
                                        <button class="btn btn-sm btn-danger" id="delete" data-integrity="{{ $matkul->id }}" data-name="{{ $matkul->matkul->name }}"><i class="fa fa-trash"></i></button>
                                    </td>
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
<script src="{{ asset('build/assets') }}/js/plugins/select2/select2.full.min.js"></script>
<script>
    $(document).ready(function() {

        if ("{{ session('success') }}") {
            sweetalert('Berhasil', 'Data berhasil ditambahkan', null, 500, false)
        }

        function sweetalert(title, msg, type, timer = 60000, confirmButton = true) {
            swal({
                title: title,
                text: msg,
                type: type,
                timer: timer,
                showConfirmButton: confirmButton
            });
        }

        $('#TableListMatkul').DataTable({
            pageLength: 10,
            order: [
                [2, 'asc']
            ],
        })

        $('#TableScheduleMatkul').DataTable({
            pageLength: 10,
            order: [
                [2, 'asc']
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
                    url: "{{ route('schedule-matkul.store') }}/" + id,
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
    })
</script>
@endpush