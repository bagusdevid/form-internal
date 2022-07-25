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
            "targets": [0, 3]
        },
        {
            "width": 30,
            "targets": 0
        }],
        order: [[ 1, 'desc' ]],
        createdRow: function (row, data, dataIndex) {
            $(row).find("td:eq(0)").attr("data-label", "No");
            $(row).find("td:eq(1)").attr("data-label", "Tanggal dibuat");
            $(row).find("td:eq(2)").attr("data-label", "&nbsp;");
        },
        initComplete: function () {
            const add_btn = `<a href="#" class="btn btn-primary btn-add mr-2 add-btn">Tambah data</a>`;
            $("#dataList_wrapper .dataTables_length").prepend(add_btn);
        },
    });

    setTimeout(() => {
        $.ajax({
            type: "POST",
            url: `${HOST}/api/users`,
            beforeSend: function () {
                $('#dataList .dataTables_empty').html('<div class="spinner-icon"><span class="spinner-grow text-info"></span><span class="caption">Fetching data...</span></div>')
            },
            success: function (response) {
                console.log(response)
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
            url: `${HOST}/api/users/store`,
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

    $('#changepasswdForm').on('hidden.bs.modal', function (event) {
        $('#changepasswdForm form[name="changepasswd"]')[0].reset();
        $('#changepasswdForm .msg').html('')
    })

    $('#dataList').on('click', '.change-passwd', function(e) {
        e.preventDefault();
        const id = $(this).attr('data-id')
        $('form[name="changepasswd"] input[name="id"]').val(id)
        $('#changepasswdForm').modal({
            show: true,
            backdrop: 'static'
        })
    });

    $('form[name="changepasswd"]').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: `${HOST}/api/users/changepasswd`,
            dataType: 'JSON',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {},
            success: function (response) {
                if(response.success) {
                    location.reload();
                } else {
                    $('#changepasswdForm .msg').html(`<div class="alert alert-danger">${response.msg}</div>`)
                }
            },
            error: function () {},
            complete: function () {}
        })
    });

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
            type: "GET",
            url: `${HOST}/api/users/${id}`,
            dataType: 'JSON',
            beforeSend: function () {},
            success: function (response) {
                console.log(response)
                if(response.success) {
                    for(const property in response.data) {
                        $(`#dataForm input[name="${property}"], #dataForm textarea[name="${property}"]`).val(response.data[property])
                        $(`#dataForm select[name="${property}"] option:selected`).attr('selected', false)
                        $(`#dataForm select[name="${property}"] option[value="${response.data[property]}"]`).attr('selected', true)
                    }
                }
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

});