$(function () {

    $('#tanggal').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: true,
        defaultDate: moment().format("YYYY-MM-DD")
    });

    $('#postdate').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        useCurrent: true,
        defaultDate: moment().format("YYYY-MM-DD HH:mm:ss")
    });
    
    let dataOrder;

    $("#dataList").DataTable({
        data: dataOrder,
        columnDefs: [{
            "searchable": false,
            "orderable": false,
            "targets": [0, 14]
        },
        {
            "width": 30,
            "targets": 0
        },
        {
            "width": 80,
            "targets": 1
        },
        {
            "width": 70,
            "targets": 14
        },
        {
            "visible": false,
            "targets": [4,6,7,9,10,11,12,13]
        }],
        order: [[ 1, 'desc' ]],
        createdRow: function (row, data, dataIndex) {
            $(row).find("td:eq(0)").attr("data-label", "No");
            $(row).find("td:eq(1)").attr("data-label", "Tanggal dibuat");
            $(row).find("td:eq(2)").attr("data-label", "Nama Pemesan");
            $(row).find("td:eq(3)").attr("data-label", "&nbsp;");
        },
        initComplete: function () {
            const add_btn = `<a href="#" class="btn btn-primary btn-add mr-2 add-btn">Tambah data</a>`;
            $("#dataList_wrapper .dataTables_length").prepend(add_btn);
        },
    });

    setTimeout(() => {
        $.ajax({
            type: "POST",
            url: `${HOST}/apiGetAll`,
            beforeSend: function () {
                $('#dataList .dataTables_empty').html('<div class="spinner-icon"><span class="spinner-grow text-info"></span><span class="caption">Fetching data...</span></div>')
            },
            success: function (response) {
                $('#dataList').DataTable().clear();
                $('#dataList').DataTable().rows.add(response);
                $('#dataList').DataTable().draw();
            },
            error: function () {
                $('#dataList .dataTables_empty').html('Data gagal di retrieve.')
            },
            complete: function() {}
        })
    }, 50)

    $('#dataList').DataTable().on( 'order.dt search.dt', function () {
        let i = 1;
        $('#dataList').DataTable().cells(null, 0, {search:'applied', order:'applied'}).every( function (cell) {
            this.data(i++);
        });
    }).draw();

    $('.add-btn').on('click', function(e) {
        e.preventDefault();
        $('#dataForm').modal({
            show: true,
            backdrop: 'static'
        })
        $('#dataForm form').attr('name', 'addData')
        $('#dataForm .modal-title').html('Tambah data')
    })

    $('#dataForm').on('submit', 'form[name="addData"]', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: `${HOST}/apiAddProcess`,
            dataType: 'JSON',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#dataForm .modal-footer .loading-indicator').html(
                    '<div class="spinner-icon">' +
                        '<span class="spinner-border text-info"></span>' +
                        '<span class="caption">Memproses data...</span>' +
                    '</div>')
                $('form[name="addData"] input, form[name="addData"] textarea, form[name="addData"] button').attr('disabled', true)
            },
            success: function (response) {
                if(response.success) {
                    location.reload();
                } else {
                    $('#dataForm .msg').html(`<div class="alert alert-danger">${response.msg}</div>`)
                    $('#dataForm, html, body').animate({
                        scrollTop: 0
                    }, 500);
                }
            },
            error: function () {},
            complete: function () {
                $('#dataForm .modal-footer .loading-indicator').html('');
                $('form[name="addData"] input, form[name="addData"] textarea, form[name="addData"] button').attr('disabled', false)
            }
        })
    })

    $('#dataForm').on('hidden.bs.modal', function (event) {
        $('#dataForm form[name="addData"], #dataForm form[name="editData"]')[0].reset();
        $('#dataForm .msg').html('')
    })

    $('#dataList').on('click', '.item-detail', function(e) {
        e.preventDefault();
        $('#dataDetail').modal('show')
        const id = $(this).attr('data-id')
        $.ajax({
            type: "POST",
            url: `${HOST}/apiGetById`,
            dataType: 'JSON',
            data: { id },
            beforeSend: function () {},
            success: function (response) {
                if(response.success) {
                    for(const property in response.data) {
                        $(`#dataDetail .${property}`).html(response.data[property])
                    }
                }
            },
            error: function () {},
            complete: function () {}
        })
    })

    $('#dataList').on('click', '.item-edit', function(e) {
        e.preventDefault();
        $('#dataForm').modal({
            show: true,
            backdrop: 'static'
        })
        $('#dataForm .modal-title').html('Edit Data')
        $('#dataForm form').attr('name', 'editData')

        const id = $(this).attr('data-id')
        $('#dataForm form input[name="id"]').val(id)

        $.ajax({
            type: "POST",
            url: `${HOST}/apiGetById`,
            dataType: 'JSON',
            data: { id },
            beforeSend: function () {},
            success: function (response) {
                if(response.success) {
                    for(const property in response.data) {
                        $(`#dataForm input[name="${property}"], #dataForm textarea[name="${property}"]`).val(response.data[property])
                        $(`#dataForm select[name="${property}"] option:selected`).attr('selected', false)
                        $(`#dataForm select[name="${property}"] option[value="${response.data[property]}"]`).attr('selected', true)
                    }
                }
                //console.log(response.data['InternEkstern'])
            },
            error: function () {},
            complete: function () {}
        })
    });

    $('#dataForm').on('submit', 'form[name="editData"]', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: `${HOST}/apiEditProcess`,
            dataType: 'JSON',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#dataForm .modal-footer .loading-indicator').html(
                    '<div class="spinner-icon">' +
                        '<span class="spinner-border text-info"></span>' +
                        '<span class="caption">Memproses data...</span>' +
                    '</div>')
                $('form[name="editData"] input, form[name="editData"] textarea, form[name="editData"] button').attr('disabled', true)
            },
            success: function (response) {
                if(response.success) {
                    location.reload();
                } else {
                    $('#dataForm .msg').html(`<div class="alert alert-danger">${response.msg}</div>`)
                    $('#dataForm, html, body').animate({
                        scrollTop: 0
                    }, 500);
                }
            },
            error: function () {},
            complete: function () {
                $('#dataForm .modal-footer .loading-indicator').html('');
                $('form[name="editData"] input, form[name="editData"] textarea, form[name="editData"] button').attr('disabled', false)
            }
        })
    })

    if(window.location.href == `${HOST}/setting` ||
        window.location.href == `${HOST}/setting/`
    ) {
        
        $.ajax({
            type: "POST",
            url: `${HOST}/api/setting/smtp`,
            dataType: 'JSON',
            beforeSend: function () {},
            success: function (response) {
                if(response.success) {
                    $('form[name="submit-smtp"] input[name="smtp_id"]').val(response.id);
                    $('form[name="submit-smtp"] .smtp-host').html(response.data.SMTPHost)
                    $('form[name="submit-smtp"] .smtp-user').html(response.data.SMTPUser)
                    $('form[name="submit-smtp"] .smtp-password').html('*******')
                    $('form[name="submit-smtp"] .smtp-port').html(response.data.SMTPPort)
                    $('form[name="submit-smtp"] .smtp-encryption').html(response.data.SMTPCrypto)
                }
            },
            error: function () {},
            complete: function () {}
        })

        $.ajax({
            type: "POST",
            url: `${HOST}/api/setting`,
            dataType: 'JSON',
            beforeSend: function () {},
            success: function (response) {
                if(response.success) {
                    $('input[name="recipients_id"]').val(response.id)
                    for(let i=0;i < response.data.length;i++) {
                        if(response.data[i] !== '') {
                            $('.recipients-wrapper .recipients').prepend(`
                                    <div class="row mt-2" id="row-${i+1}">
                                    <div class="col-3">
                                        <input name="email[]" value="${response.data[i]}" type="text" class="form-control" readonly>
                                    </div>
                                    <div class="col-1">
                                        <a href="#" class="del-recipient" id="del-${i+1}"><i class="far fa-trash-alt"></i></a>
                                    </div>
                                </div>
                            `)
                        }
                    }
                }
            },
            error: function () {},
            complete: function () {}
        })

        
    }

    $('.add-recipient').on('click', function() {
        // console.log($('.recipients > div').length)
        let id = 1;
        if($('.recipients > div').length > 0) {
            id = $('.recipients > div:nth-child(1)').attr('id');
            id = parseInt(id.split('-')[1]);
        }
        $('.recipients').prepend(`
            <div class="row mt-2" id="row-${id+1}">
            <div class="col-3">
                <input name="email[]" type="text" class="form-control">
            </div>
            <div class="col-1">
                <a href="#" class="del-recipient" id="del-${id+1}"><i class="far fa-trash-alt"></i></a>
            </div>
        </div>
            `)
    })

    $('.recipients').on('click', '.del-recipient', function(e) {
        e.preventDefault();
        let id = parseInt($(this).attr('id').split('-')[1])
        $(`.recipients #row-${id}`).remove();
    })

    $('form[name="submit-recipients"]').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: `${HOST}/api/setting/store`,
            dataType: 'JSON',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {},
            success: function (response) {
                location.reload();
            },
            error: function () {},
            complete: function () {}
        })
    })

    $('.change-smtp').on('click', function() {
        $(this).attr('disabled', true);
        $('form[name="submit-smtp"] .button-wrapper').append('<button class="btn btn-success smtp-save" type="submit">Simpan</button> <button class="btn btn-danger smtp-save-cancel" type="button">Batal</button>')
        $.ajax({
            type: "POST",
            url: `${HOST}/api/setting/smtp`,
            dataType: 'JSON',
            beforeSend: function () {},
            success: function (response) {
                if(response.success) {
                    $('form[name="submit-smtp"] input[name="smtp_id"]').val(response.id);
                    $('form[name="submit-smtp"] .smtp-host').html(`<input type="text" name="SMTPHost" value="${response.data.SMTPHost}" class="form-control">`)
                    $('form[name="submit-smtp"] .smtp-user').html(`<input type="text" name="SMTPUser" value="${response.data.SMTPUser}" class="form-control">`)
                    $('form[name="submit-smtp"] .smtp-password').html(`<input type="password" name="SMTPPass" value="${response.data.SMTPPass}" class="form-control">`)
                    $('form[name="submit-smtp"] .smtp-port').html(`<input type="number" name="SMTPPort" value="${response.data.SMTPPort}" class="form-control">`)
                    $('form[name="submit-smtp"] .smtp-encryption').html(`<input type="text" name="SMTPCrypto" value="${response.data.SMTPCrypto}" class="form-control">`)
                }
            },
            error: function () {},
            complete: function () {}
        })
    })

    $('form[name="submit-smtp"]').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: `${HOST}/api/setting/smtp/store`,
            dataType: 'JSON',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {},
            success: function (response) {
                if(response.success) {
                    location.reload()
                }
            },
            error: function () {},
            complete: function () {}
        })
    })

    $('form[name="submit-smtp"]').on('click', '.smtp-save-cancel', function(e) {
        $(this).remove();
        $('form[name="submit-smtp"] button.smtp-save').remove()
        $('form[name="submit-smtp"] button.change-smtp').attr('disabled', false)
        $.ajax({
            type: "POST",
            url: `${HOST}/api/setting/smtp`,
            dataType: 'JSON',
            beforeSend: function () {},
            success: function (response) {
                if(response.success) {
                    $('form[name="submit-smtp"] input[name="smtp_id"]').val(response.id);
                    $('form[name="submit-smtp"] .smtp-host').html(response.data.SMTPHost)
                    $('form[name="submit-smtp"] .smtp-user').html(response.data.SMTPUser)
                    $('form[name="submit-smtp"] .smtp-password').html('*******')
                    $('form[name="submit-smtp"] .smtp-port').html(response.data.SMTPPort)
                    $('form[name="submit-smtp"] .smtp-encryption').html(response.data.SMTPCrypto)
                }
            },
            error: function () {},
            complete: function () {}
        })
    });

    $('form[name="submit-specific"]').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: `${HOST}/api/setting/specific/store`,
            dataType: 'JSON',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {},
            success: function (response) {
                if(response.success) {
                    location.reload()
                }
            },
            error: function () {},
            complete: function () {}
        })
    })

});