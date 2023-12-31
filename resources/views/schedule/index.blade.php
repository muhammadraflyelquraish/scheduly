@extends('layouts.master')

@push('css')
<link href="{{ asset('assets') }}/css/plugins/select2/select2.min.css" rel="stylesheet">
<link href="{{ asset('assets') }}/css/plugins/select2/select2-bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Jadwal</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Filter Jadwal</h5>
                </div>
                <div class="ibox-content">
                    <div class="row m-b-sm m-t-sm">
                        @if(auth()->user()->role->name != 'Dosen')
                        <div class="col-md-3">
                            <label>Dosen</label>
                            <div class="input-group date">
                                <input type="search" name="dosen" id="dosen" placeholder="nama/email/nip" class="form-control">
                                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-3">
                            <label>Tahun Akademik</label>
                            <select class="select2-tahun-akademik form-control" name="academic_year" id="academic_year" required>
                                <option value=""></option>
                                @for ($i = 2019; $i < 2029; $i++) <option value="{{ $i }}/{{ $i+1 }}">{{ $i }}/{{ $i+1 }}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Periode</label>
                            <select name="type_periode" id="type_periode" class="form-control">
                                <option value="" selected>Pilih Periode</option>
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>
                        <div class="col-md-3" style="margin-top: 28px;">
                            <button class="btn btn-primary" id="btnFilter"><i class="fa fa-filter mr-1"></i>Filter</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    @if(auth()->user()->role->name == 'Admin' || auth()->user()->role->name == 'Staff')
                    <h5><a class="btn btn-primary btn-sm" href="{{ route('schedule.create') }}"><i class="fa fa-plus-square mr-1"></i> Tambah Jadwal</a></h5>
                    @endif
                    <h5><a class="btn btn-primary btn-sm" href="{{ route('schedule.export') }}" id="export" target="_blank"><i class="fa fa-file-excel-o mr-1"></i> Export [Excel]</a></h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover brandTable" width="100%">
                            <thead>
                                <tr>
                                    <th width="1px">No</th>
                                    <th>Dosen</th>
                                    <th>Tahun Akademik</th>
                                    <th class="text-right" width="1px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="downloadModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div style="padding-left: 45px;">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Example" alt="">
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-rectangle-o mr-1"></i>Tutup [Esc]</button>
                <button type="submit" class="btn btn-danger ladda-button ladda-button-demo" data-style="zoom-in" id="submit" tabindex="4"><i class="fa fa-file mr-1"></i>Download [PDF]</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('assets') }}/js/plugins/select2/select2.full.min.js"></script>
<script>
    $(document).ready(function() {

        $('#downloadModal').on('shown.bs.modal', function(e) {
            let button = $(e.relatedTarget)
            let closeTr = button.closest('tr')
            let modal = $(this)
            modal.find('#modal-title').text(`${closeTr.find('td:eq(1)').text()}`);
        })

        $(".select2-tahun-akademik").select2({
            theme: 'bootstrap4',
            placeholder: "Pilih Tahun Akademik",
            allowClear: true
        });


        if ("{{ session('success') }}") {
            sweetalert('Berhasil', "{{ session('success') }}", null)
        }

        if ("{{ session('failed') }}") {
            sweetalert('Gagal', 'Terjadi kesalah', 'error')
        }

        //BASE 
        let ladda = $('.ladda-button-demo').ladda();

        function LaddaStart() {
            ladda.ladda('start');
        }

        function LaddaAndDrawTable() {
            ladda.ladda('stop');
            serverSideTable.draw()
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

        //TEMPLATES 
        let serverSideTable = $('.brandTable').DataTable({
            processing: true,
            serverSide: true,
            order: [
                [2, 'desc']
            ],
            ajax: {
                url: "{{ route('schedule.data') }}",
                type: "GET",
                data: function(d) {
                    d.dosen = $('input[name="dosen"]').val()
                    d.academic_year = $('select[name="academic_year"]').val()
                    d.type_periode = $('select[name="type_periode"]').val()
                }
            },
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                searchable: false,
                orderable: false,
            }, {
                data: 'user.name',
                name: 'user.name'
            }, {
                data: 'academic_year',
                name: 'academic_year'
            }, {
                data: 'action',
                name: 'action',
                searchable: false,
                orderable: false
            }],
            search: {
                "regex": true
            }
        });

        $('#btnFilter').click(function(e) {
            e.preventDefault()
            serverSideTable.draw();
        })



        $('#ModalAddEdit').on('shown.bs.modal', function(e) {
            $('#name').focus();
            let button = $(e.relatedTarget)
            let modal = $(this)
            if (button.data('mode') == 'edit') {
                let id = button.data('integrity')
                let closeTr = button.closest('tr')
                $('#formAddEdit').attr('action', '{{ route("schedule.store") }}/' + id).attr('method', 'PATCH')

                modal.find('#modal-title').text('Edit Jadwal');
                modal.find('#user_id').val(closeTr.find('td:eq(1)').find('input[id="userId"]').val())
                modal.find('#academic_year').val(closeTr.find('td:eq(2)').text())

            } else {
                $('#formAddEdit').trigger('reset').attr('action', '{{ route("schedule.store") }}').attr('method', 'POST')
                modal.find('#modal-title').text('Tambah Jadwal');
            }
        })

        $("#formAddEdit").validate({
            messages: {
                user_id: "Dosen tidak boleh kosong",
                academic_year: "Tahun Akademik tidak boleh kosong",
            },
            success: function(messages) {
                $(messages).remove();
            },
            errorPlacement: function(error, element) {
                let name = element.attr("name");
                $("#" + name + "_error").text(error.text());
            },
            submitHandler: function(form) {
                LaddaStart()
                $.ajax({
                    url: $(form).attr('action'),
                    type: $(form).attr('method'),
                    data: $(form).serialize(),
                    dataType: 'JSON',
                    success: function(res) {
                        $('#ModalAddEdit').modal('hide')
                        LaddaAndDrawTable()
                        sweetalert('Berhasil', res.msg, null, 500, false)
                    },
                    error: function(res) {
                        LaddaAndDrawTable()
                        sweetalert('Gagal', 'Terjadi kesalah', 'error')
                    }
                })
            }
        });

        $(document).on('click', '#delete', function(e) {
            let id = $(this).data('integrity')
            let name = $(this).closest('tr').find('td:eq(1)').text()
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
                    url: "{{ route('schedule.store') }}/" + id,
                    type: "DELETE",
                    dataType: 'json',
                    success: function(response) {
                        LaddaAndDrawTable()
                        sweetalert('Berhasil', `Data berhasil dihapus.`, null, 500, false)
                    },
                    error: function(response) {
                        LaddaAndDrawTable()
                        sweetalert('Tidak terhapus!', 'Terjadi kesalahan saat menghapus data.', 'error')
                    }
                })
            });
        })

    });
</script>
@endpush