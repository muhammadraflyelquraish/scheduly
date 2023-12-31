@extends('layouts.master')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Detail Jadwal</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <span><a href="{{ route('schedule.index') }}">Jadwal</a></span>
            </li>
            <li class="breadcrumb-item">
                <span><a href="{{ route('schedule.show', $scheduleMatkul->schedule->id) }}">Matkul</a></span>
            </li>
            <li class="breadcrumb-item active">
                <span><strong>Kelas</strong></span>
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Dosen</b></label>
                                <p class="form-control-static">{{ $scheduleMatkul->schedule->user->name }} ({{ $scheduleMatkul->schedule->user->email }})</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><b>NIP</b></label>
                                <p class="form-control-static">{{ $scheduleMatkul->schedule->user->nip }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Takun Akademik</b></label>
                                <p class="form-control-static">{{ $scheduleMatkul->schedule->academic_year }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Matkul</b></label>
                                <p class="form-control-static">({{ $scheduleMatkul->matkul->code }}) {{ $scheduleMatkul->matkul->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Semester</b></label>
                                <p class="form-control-static">{{ $scheduleMatkul->matkul->semester }}</p>
                            </div>
                        </div>
                    </div>

                    <hr class="hr-line">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Jadwal Kelas ({{ $scheduleMatkul->matkul->name }})</b></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-outline btn-sm btn-primary mb-2" type="button" data-toggle="modal" data-target="#ModalAddClass"><i class="fa fa-plus"></i> Tambah Kelas</button>
                        <table class="table table-bordered table-hover" id="TableScheduleMatkulClass">
                            <thead>
                                <tr>
                                    <th width="1px">No</th>
                                    <th>Kelas / Angkatan</th>
                                    <th>Jumlah SKS</th>
                                    <th>Hari/ Waktu/ Ruang</th>
                                    <th width="1px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($scheduleMatkul->classes as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->class->name }} / {{ $row->class->angkatan }}</td>
                                    <td>{{ $row->sks }}</td>
                                    <td>{{ $row->day }} / {{ $row->hour }} / {{ $row->room }}</td>
                                    <td class="btn-group pull-right">
                                        <button class="btn btn-sm btn-danger" id="delete" data-integrity="{{ $row->id }}" data-name="{{ $row->class->name }}"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                                @endforeach()
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalAddClass" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('schedule-matkul-class.store') }}" id="formAddClass" method="POST">
                @csrf
                @method('POST')

                <input type="hidden" name="schedule_matkul_id" value="{{ $scheduleMatkul->id }}">

                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title">Tambah Jadwal Kelas</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kelas</label>
                        <select name="class_id" class="form-control" id="class_id" required>
                            <option value="" selected>Pilih Kelas</option>
                            @foreach ($class as $row)
                            <option value="{{ $row->id }}">{{ $row->name }} ({{ $row->angkatan }})</option>
                            @endforeach
                        </select>
                        <small class="text-danger" id="class_id_error"></small>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jumlah SKS</label>
                                <input type="number" class="form-control" name="sks" required value="{{ old('sks') }}">
                                <small class="text-danger" id="sks_error"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Hari</label>
                                <select class="form-control" id="day" required name="day">
                                    <option value="" selected>Pilih Hari</option>
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                </select>
                                <small class="text-danger" id="day_error"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Dari (jam)</label>
                                <input type="time" class="form-control" required id="start_time" name="start_time" value="{{ old('start_time') }}">
                                <small class="text-danger" id="start_time_error"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sampai (Jam)</label>
                                <input type="time" class="form-control" required id="end_time" name="end_time" value="{{ old('end_time') }}">
                                <small class="text-danger" id="end_time_error"></small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Ruangan</label>
                        <input type="text" class="form-control" required name="room" value="{{ old('room') }}">
                        <small class="text-danger" id="room_error"></small>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-rectangle-o mr-1"></i>Tutup [Esc]</button>
                    <button type="submit" class="btn btn-primary ladda-button ladda-button-demo" data-style="zoom-in" id="submit" tabindex="4"><i class="fa fa-check-square mr-1"></i>Simpan [Enter]</button>
                </div>
            </form>
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

        $("#formAddClass").validate({
            messages: {
                class_id: "Kelas tidak boleh kosong",
                sks: "Jumlah SKS tidak boleh kosong",
                day: "Hari tidak boleh kosong",
                start_time: "Jam tidak boleh kosong",
                end_time: "Jam tidak boleh kosong",
                room: "Ruangan tidak boleh kosong",
            },
            success: function(messages) {
                $(messages).remove();
            },
            errorPlacement: function(error, element) {
                let name = element.attr("name");
                $("#" + name + "_error").text(error.text());
            },
            submitHandler: function(form) {
                $(form).submit()
            }
        });


        $('#TableScheduleMatkulClass').DataTable({
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
                    url: "{{ route('schedule-matkul-class.store') }}/" + id,
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