@extends('layouts.master')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Matkul</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5><button class="btn btn-primary btn-sm" data-toggle="modal" data-mode="add" data-target="#ModalAddEdit"><i class="fa fa-plus-square mr-1"></i> Tambah Matkul [F2]</button></h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover brandTable" width="100%">
                            <thead>
                                <tr>
                                    <th width="1px">No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Semester</th>
                                    <th>SKS</th>
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

<div class="modal fade" id="ModalAddEdit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formAddEdit" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Kode</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="code" name="code" tabindex="1" value="{{ $code }}" readonly required maxlength="200">
                            <small class="text-danger" id="code_error"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Matkul</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" tabindex="2" required maxlength="200">
                            <small class="text-danger" id="name_error"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Semester</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="semester" name="semester" tabindex="3" required maxlength="200">
                            <small class="text-danger" id="semester_error"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">SKS</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="sks" name="sks" tabindex="3" required maxlength="200">
                            <small class="text-danger" id="sks_error"></small>
                        </div>
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
<script>
    $(document).ready(function() {
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
                [1, 'asc']
            ],
            ajax: {
                url: "{{ route('matkul.create') }}",
            },
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                searchable: false,
                orderable: false,
            }, {
                data: 'code',
                name: 'code'
            }, {
                data: 'name',
                name: 'name'
            }, {
                data: 'semester',
                name: 'semester'
            }, {
                data: 'sks',
                name: 'sks'
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


        $('#ModalAddEdit').on('shown.bs.modal', function(e) {
            $('#code').focus();
            let button = $(e.relatedTarget)
            let modal = $(this)
            if (button.data('mode') == 'edit') {
                let id = button.data('integrity')
                let closeTr = button.closest('tr')
                $('#formAddEdit').attr('action', '{{ route("matkul.store") }}/' + id).attr('method', 'PATCH')

                modal.find('#modal-title').text('Edit Matkul');
                modal.find('#code').val(closeTr.find('td:eq(1)').text())
                modal.find('#name').val(closeTr.find('td:eq(2)').text())
                modal.find('#semester').val(closeTr.find('td:eq(3)').text())
                modal.find('#sks').val(closeTr.find('td:eq(4)').text())

            } else {
                $('#formAddEdit').trigger('reset').attr('action', '{{ route("matkul.store") }}').attr('method', 'POST')
                modal.find('#modal-title').text('Tambah Matkul');
            }
        })

        $("#formAddEdit").validate({
            messages: {
                code: "Kode tidak boleh kosong",
                name: "Nama tidak boleh kosong",
                semester: "Semester tidak boleh kosong",
                sks: "SKS tidak boleh kosong"
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
                        if ($(form).attr('method') == 'POST') {
                            window.location.reload()
                        } else {
                            $('#ModalAddEdit').modal('hide')
                            LaddaAndDrawTable()
                            sweetalert('Berhasil', res.msg, null, 500, false)
                        }

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
                    url: "{{ route('matkul.store') }}/" + id,
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