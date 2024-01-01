@extends('layouts.master')

@push('css')
<link href="{{ asset('assets') }}/css/plugins/select2/select2.min.css" rel="stylesheet">
<link href="{{ asset('assets') }}/css/plugins/select2/select2-bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Tambah Detail Jadwal</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <span><a href="{{ route('schedule.index') }}">Jadwal</a></span>
            </li>
            <li class="breadcrumb-item">
                <span><a href="{{ route('schedule.show', $scheduleId) }}">Detail</a></span>
            </li>
            <li class="breadcrumb-item active">
                <strong>Tambah</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Data Jadwal</h5>
                </div>
                <form action="{{ route('schedule-detail.store') }}" method="post" id="formSchedule">
                    @csrf
                    @method('POST')

                    <input type="hidden" name="schedule_id" value="{{ $scheduleId }}">

                    <div class="ibox-content">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Kode</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="code" id="code" value="{{ $code }}" readonly required>
                                <small class="text-danger" id="code_error"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Matkul</label>
                            <div class="col-md-9">
                                <select class="select2-matkul form-control" name="matkul_id" id="matkul_id" required>
                                    <option value=""></option>
                                    @foreach($matkul as $row)
                                    @if(old('matkul_id') == $row->id)
                                    <option value="{{ $row->id }}" selected>({{ $row->code }}) {{ $row->name }} - {{ $row->sks }} SKS</option>
                                    @else
                                    <option value="{{ $row->id }}">({{ $row->code }}) {{ $row->name }} - {{ $row->sks }} SKS</option>
                                    @endif
                                    @endforeach
                                </select>
                                <small class="text-danger" id="matkul_id_error"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Kelas</label>
                            <div class="col-md-9">
                                <select class="select2-class form-control" name="class_id" id="class_id" required>
                                    <option value=""></option>
                                    @foreach($class as $row)
                                    @if(old('class_id') == $row->id)
                                    <option value="{{ $row->id }}" selected>{{ $row->name }} ({{ $row->angkatan }})</option>
                                    @else
                                    <option value="{{ $row->id }}">{{ $row->name }} ({{ $row->angkatan }})</option>
                                    @endif
                                    @endforeach
                                </select>
                                <small class="text-danger" id="class_id_error"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">SKS</label>
                            <div class="col-md-9">
                                <input type="number" name="sks" id="sks" class="form-control" value="{{ old('sks') }}" required>
                                <small class="text-danger" id="sks_error"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Hari</label>
                            <div class="col-md-9">
                                <select class="form-control" name="day" id="day" required>
                                    <option value="">Pilih Hari</option>
                                    @php $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] @endphp
                                    @foreach($days as $day)
                                    @if(old('day') == $day)
                                    <option value="{{ $day }}" selected>{{ $day }}</option>
                                    @else
                                    <option value="{{ $day }}">{{ $day }}</option>
                                    @endif
                                    @endforeach
                                </select>
                                <small class="text-danger" id="day_error"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Waktu</label>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-5">
                                        <input type="time" class="form-control" name="start_time" id="start_time" required>
                                        <small class="text-danger" id="start_time_error"></small>
                                    </div>
                                    <div class="col-md-2 pt-2">
                                        <p>Sampai</p>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="time" class="form-control" name="end_time" id="end_time" required>
                                        <small class="text-danger" id="end_time_error"></small>
                                    </div>
                                </div>
                                @if(session('recomendation'))
                                <span>
                                    Alternatif Jam (tersedia)
                                    <ul>
                                        @foreach(session('recomendation') as $row)
                                        <li>{{ $row['start_time'] }} s.d {{ $row['end_time'] }}</li>
                                        @endforeach
                                    </ul>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Ruangan</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="room" id="room" value="{{ old('room') }}" required>
                                <small class="text-danger" id="room_error"></small>
                            </div>
                        </div>


                        <hr class="hr-line-dashed pb-4">
                        <button class="btn btn-primary float-right" style="margin-top: -30px;" type="submit"><i class="fa fa-plus"></i> Tambah Detail Jadwal</button>
                    </div>
                </form>
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

        if ("{{ session('failed') }}") {
            sweetalert('Gagal', "{{ session('failed') }}", 'error', 60000)
        }

        $(".select2-matkul").select2({
            theme: 'bootstrap4',
            placeholder: "Pilih Matkul",
            allowClear: true
        });

        $(".select2-class").select2({
            theme: 'bootstrap4',
            placeholder: "Pilih Kelas",
            allowClear: true
        });

        $("#formSchedule").validate({
            success: function(messages) {
                $(messages).remove();
            },
            errorPlacement: function(error, element) {
                let name = element.attr("name");
                $("#" + name + "_error").text(error.text());
            }
        });
    });
</script>
@endpush