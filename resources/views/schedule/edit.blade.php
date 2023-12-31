@extends('layouts.master')

@push('css')
<link href="{{ asset('assets') }}/css/plugins/select2/select2.min.css" rel="stylesheet">
<link href="{{ asset('assets') }}/css/plugins/select2/select2-bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Ubah Jadwal</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <span><a href="{{ route('schedule.index') }}">Jadwal</a></span>
            </li>
            <li class="breadcrumb-item active">
                <strong>Ubah</strong>
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
                <form action="{{ route('schedule.update', $schedule->id) }}" method="post" id="formSchedule">
                    @csrf
                    @method('PUT')

                    <div class="ibox-content">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Dosen</label>
                            <div class="col-md-9">
                                <select class="select2-dosen form-control" name="user_id" id="user_id" required>
                                    @foreach($dosen as $row)

                                    @if($schedule->user_id == $row->id)
                                    <option value="{{ $row->id }}" selected>{{ $row->name }} ({{ $row->email }})</option>
                                    @else
                                    <option value="{{ $row->id }}">{{ $row->name }} ({{ $row->email }})</option>
                                    @endif

                                    @endforeach
                                </select>
                                <small class="text-danger" id="user_id_error"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Tahun Akademik</label>
                            <div class="col-md-9">
                                <select class="select2-tahun-akademik form-control" name="academic_year" id="academic_year" required>

                                    @for ($i = 2019; $i < 2029; $i++) @php $academic_year=$i . '/' . ($i+1) @endphp @if($schedule->academic_year == $academic_year)
                                        <option value="{{ $academic_year }}" selected>{{ $academic_year }}</option>
                                        @else
                                        <option value="{{ $academic_year }}">{{ $academic_year }}</option>
                                        @endif

                                        @endfor
                                </select>
                                <small class="text-danger" id="academic_year_error"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Periode</label>
                            <div class="col-md-9">
                                <select class="select2-periode form-control" name="type_periode" id="type_periode" required>
                                    @if($schedule->type_periode == 'Ganjil')
                                    <option value="Ganjil" selected>Ganjil</option>
                                    <option value="Genap">Genap</option>
                                    @else
                                    <option value="Ganjil">Ganjil</option>
                                    <option value="Genap" selected>Genap</option>
                                    @endif
                                </select>
                                <small class="text-danger" id="type_periode_error"></small>
                            </div>
                        </div>

                        <hr class="hr-line-dashed pb-4">
                        <button class="btn btn-primary float-right" style="margin-top: -30px;" type="submit"><i class="fa fa-edit"></i> Ubah Jadwal</button>
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

        $(".select2-dosen").select2({
            theme: 'bootstrap4',
            placeholder: "Pilih Dosen",
            allowClear: true
        });

        $(".select2-tahun-akademik").select2({
            theme: 'bootstrap4',
            placeholder: "Pilih Tahun Akademik",
            allowClear: true
        });

        $(".select2-periode").select2({
            theme: 'bootstrap4',
            placeholder: "Pilih Periode",
            allowClear: true
        });

        $("#formSchedule").validate({
            messages: {
                user_id: "Dosen tidak boleh kosong",
                academic_year: "Tahun akademik tidak boleh kosong",
                type_periode: "Periode tidak boleh kosong",
            },
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