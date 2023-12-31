@extends('layouts.master')

@push('css')
<link href="{{ asset('assets') }}/css/plugins/select2/select2.min.css" rel="stylesheet">
<link href="{{ asset('assets') }}/css/plugins/select2/select2-bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Tambah Jadwal</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <span><a href="{{ route('schedule.index') }}">Jadwal</a></span>
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
                <form action="{{ route('schedule.store') }}" method="post" id="formSchedule">
                    @csrf
                    @method('POST')

                    <div class="ibox-content">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Dosen</label>
                            <div class="col-md-9">
                                <select class="select2-dosen form-control" name="user_id" id="user_id" value="{{ old('user_id') }}" required>
                                    <option value=""></option>
                                    @foreach($dosen as $row)
                                    <option value="{{ $row->id }}">{{ $row->name }} ({{ $row->email }})</option>
                                    @endforeach
                                </select>
                                <small class="text-danger" id="user_id_error"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Tahun Akademik</label>
                            <div class="col-md-9">
                                <select class="select2-tahun-akademik form-control" name="academic_year" id="academic_year" value="{{ old('academic_year') }}" required>
                                    <option value=""></option>
                                    @for ($i = 2019; $i < 2029; $i++) <option value="{{ $i }}/{{ $i+1 }}">{{ $i }}/{{ $i+1 }}</option>
                                        @endfor
                                </select>
                                <small class="text-danger" id="academic_year_error"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Periode</label>
                            <div class="col-md-9">
                                <select class="select2-periode form-control" name="type_periode" id="type_periode" value="{{ old('type_periode') }}" required>
                                    <option value=""></option>
                                    <option value="Ganjil">Ganjil</option>
                                    <option value="Genap">Genap</option>
                                </select>
                                <small class="text-danger" id="type_periode_error"></small>
                            </div>
                        </div>

                        <hr class="hr-line-dashed pb-4">
                        <button class="btn btn-primary float-right" style="margin-top: -30px;" type="submit"><i class="fa fa-plus"></i> Tambah Jadwal</button>
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