@section('script')
    <script src="{{URL::asset('/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="{{ URL::asset('/libs/jszip/jszip.min.js')}}"></script>
    <script src="{{ URL::asset('/libs/pdfmake/pdfmake.min.js')}}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var loadingBtn = null;
        var loadingBtn = null;
        var val = '';

        $('.select2-multiple').select2();
        $('.select2-container').addClass('d-block');

        $(document).ready(function () {
            var userId = null;
           /* $('#phone').inputmask("99999999999");
            $('#edit_user_phone').inputmask("99999999999");*/
            var table = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                cache: true,
                order: [[0, 'desc']],
                ajax: "{{ route('user.index') }}",
                /*lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                dom: '<"top d-flex justify-content-between"Bf>rt<"bottom d-flex justify-content-between"ip><"clear">',
                buttons: [
                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: [0, 1, 2]
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2]
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2]
                        }
                    },
                    {
                        extend: 'pageLength',
                        exportOptions: {
                            columns: [0, 1, 2]
                        }
                    },
                ],*/
                columns: [{
                    data: 'created',
                    name: 'created'
                },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('.buttons-html5, .buttons-print, .buttons-collection').addClass('btn-dark').removeClass('btn-secondary')

            $('.appendTime').append(time24());

            $('#is_employee_div, #is_pt_div, #edit_is_employee_div, #edit_is_pt_div').hide();
        });

        var userId = null;

        $('#is_employee_checkbox').change(function () {
            if ($(this).prop('checked')) {
                $('#is_employee_div').show();
            } else {
                $('#is_employee_div').hide();
            }
        });

        $('#is_pt_checkbox').change(function () {
            if ($(this).prop('checked')) {
                $('#is_pt_div').show();
            } else {
                $('#is_pt_div').hide();
            }
        });

        $('#edit_is_employee_checkbox').change(function () {
            if ($(this).prop('checked')) {
                $('#edit_is_employee_div').show();
            } else {
                $('#edit_is_employee_div').hide();
            }
        });

        $('#edit_is_pt_checkbox').change(function () {
            if ($(this).prop('checked')) {
                $('#edit_is_pt_div').show();
            } else {
                $('#edit_is_pt_div').hide();
            }
        });

        var count = 1;

        $('#create-user').parsley();

        $('#create-user').on('submit', function (e) {
            e.preventDefault();
            var self = $(this);
            var formData = new FormData(this);
            if ($('#create-user').parsley().isValid()) {
                loading(self, true);
                $.ajax({
                    url: "{{route('user.store')}}",
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        toastr.success(response.message);
                        $('#create-user-modal').modal('hide');
                        $('.datatable').DataTable().ajax.reload(null, false);
                        self[0].reset();
                        $('.select2OnCreate').trigger('change')
                        $('#is_employee_div, #is_pt_div').hide();
                        $('.appendedShifts').remove()
                        loading(self, false);
                    },
                    error: function (error) {
                        toastrErrors(error);
                        loading(self, false);
                    }
                });
            }
        });

        // edit
        $(document).on('click', '.action-edit', function (e) {
            $('#edit-user-modal').modal('show');
            userId = $(this).data("id");
            $('#edit_job').hide();
            $('#edit_employ_salary').hide();
            $.ajax({
                url: "{{url('user/edit/')}}" + "/" + userId,
                type: 'get',
                success: function (response) {
                    let dob = new Date(response.user.dob).toISOString().substr(0, 10);
                    let joiningdate = new Date(response.user.date).toISOString().substr(0, 10);
                    if (joiningdate == '1970-01-01') {
                        $('#edit-user-date').val('');
                    } else {
                        $('#edit-user-date').val(joiningdate);
                    }

                    $('#edit_user_name').val(response.user.name);
                    $('#edit_user_email').val(response.user.email);
                    $('#edit_user_phone').val(response.user.phone);
                    $('#edit_user_gender').val(response.user.gender);
                    $('#edit_user_dob').val(dob);
                    $('#edit-user-total-leaves').val(response.user.total_leaves);
                    $('#edit_user_address').val(response.user.address);
                    $('#edit-user-roles').val(response.userRoles);
                    $('#edit-user-roles').trigger('change');
                    $('#edit_job_type').val(response.user.job_type);

                    if (response.user.employ_type) {
                        $('#edit_is_employee_checkbox').prop("checked", true);
                        $('#edit_is_employee_div').show();

                        if (response.user.pt) {
                            $('#edit_is_pt_checkbox').prop("checked", true);
                            $('#edit_is_pt_div').show();

                            $('#edit_percentage').val(response.user.pt_percentage);
                            $('#edit_members').val(response.ptMembers).trigger('change');
                        }

                        $('#edit_salary').val(response.user.salary);
                        $('.appendShiftOnEdit').empty();
                        $(response.shifts).each(function (key, val) {
                            $('.appendShiftOnEdit').append(shift(val));
                            $('.edit-shift-from-' + val.id).val(val.from)
                            $('.edit-shift-to-' + val.id).val(val.to)
                            count++;
                        });
                    }
                },

                error: function (error) {
                    toastrErrors(error);
                }
            });
        });

        $('#update-user').parsley();
        $('body').on('submit', '#update-user', function (e) {

            var formData = new FormData(this);
            e.preventDefault();
            var self = $(this);

            if ($('#update-user').parsley().isValid()) {
                loading(self, true);

                $.ajax({
                    url: '{{ url("/user/update") }}' + '/' + userId,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#edit-user-modal').modal('hide');
                        $('.datatable').DataTable().ajax.reload(null, false);
                        self[0].reset();
                        $('.select2OnEdit').trigger('change')
                        $('#edit_is_employee_div, #edit_is_pt_div').hide();
                        $('.appendShiftOnEdit').remove()
                        toastr.success(response.message);
                        loading(self, false);
                    },
                    error: function (error) {
                        toastrErrors(error);
                        loading(self, false);
                    }
                });
            }
        });

        let userDeleteId = null;
        $('body').on('click', '#yes_user_delete_confirmed', function (e) {
            loadingBtn = Ladda.create($('#yes_user_delete_confirmed')[0]);

            loadingBtn.start();
            e.preventDefault();
            $.ajax({
                url: '{{ url("/user/delete") }}' + '/' + userDeleteId,
                method: 'GET',
                success: function (response) {
                    loadingBtn.stop();
                    $('#user-delete-modal').modal('hide')
                    $('.datatable').DataTable().ajax.reload(null, false);
                    toastr.success(response.message);
                },
                error: function (error) {
                    toastrErrors(error)
                }
            });
        });

        // Employ salary
        $(document).on('click', '.action-payment', function (e) {
            e.preventDefault();
            userId = $(this).data('id');

            $.ajax({
                url: "{{url('user/on-salary-data/')}}" + "/" + userId,
                type: 'get',
                success: function (response) {

                    let userSalary = 0;

                    let ptf_html = '';
                    let absents_html = '';

                    if (response.user.pt) {
                        let total = 0;
                        $.each(response.user.pt_members, function (key, value) {
                            let amount = percentage(response.user.pt_percentage, value.personal_training_fees, 2);
                            total += parseFloat(amount);
                            ptf_html +=
                                '<tr>' +
                                '<td>' + value.name + '</td>' +
                                '<td>' + value.personal_training_fees + '</td>' +
                                '<td>' + response.user.pt_percentage + '</td>' +
                                '<td>' + amount + '</td>' +
                                '</tr>';
                        })
                        ptf_html += '<tr><td colspan="4" class="text-right"><b>Total: </b>' + total + '</td></tr>';
                        userSalary += total;
                    } else {
                        ptf_html = '<tr><td colspan="4">No personal training!</td></tr>';
                    }

                    if ((response.absents).length) {
                        let totalAbsents = 0;
                        $.each(response.absents, function (key, value) {
                            totalAbsents++;
                            absents_html +=
                                '<tr>' +
                                '<td>' + new Date(value).toLocaleString() + '</td>' +
                                '</tr>';
                        })
                        absents_html += '<tr><td colspan="2" class="text-right"><b>Total Absents: </b>' + totalAbsents + '</td></tr>';
                    } else {
                        absents_html = '<tr><td colspan="2">No absents!</td></tr>';
                    }

                    let totalSalary = 0;
                    if(response.solidAbsents >= 1) {
                        totalSalary = response.userTotalSalary - (response.oneDaySalary * response.solidAbsents);
                    }

                    totalSalary = parseInt(response.userTotalSalary) + parseInt(userSalary);

                    $('#user_salary').val(totalSalary);
                    $('#ptf_table').html(ptf_html);
                    $('#absents_table').html(absents_html);
                    $('#member_payment_date').val(new Date(response.monthEndDate).toISOString().split('T')[0])
                },

                error: function (error) {
                    toastrErrors(error);
                }
            });
        });

        function percentage(value, percentage, floatingPoint) {
            return ((parseInt(value) / 100) * parseInt(percentage)).toFixed(floatingPoint);
        }

        $('#salary-payment').parsley();

        $('#salary-payment').on('submit', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            var self = $(this);
            loading(self, true);

            if ($('#salary-payment').parsley().isValid()) {
                $.ajax({
                    url: '{{url("user/salary")}}' + '/' + userId,
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        toastr.success(response.message);
                        $('#make-salary-modal').modal('hide');
                        $('#salary-payment').trigger('reset');
                        $('.datatable').DataTable().ajax.reload(null, false);
                        loading(self, false);

                    },

                    error: function (err) {
                        toastrErrors(err);
                        loading(self, false);

                    }
                });
            }
        });

        // for payhistory
        $(document).on('click', '.action-payment-history', function (e) {
            e.preventDefault();
            var self = $(this);
            userId = $(this).data('id');
            $('#member_payment_tr').empty();

            var options = {day: 'numeric', year: 'numeric', month: 'long'};
            $.ajax({
                url: '{{url("user/history")}}' + '/' + userId,
                type: 'get',
                success: function (response) {
                    if ((response.salaries).length) {
                        $.each((response.salaries), function (key, value) {
                            $('#member_payment_tr').append(
                                '<tr class="text-center">' +
                                '<td>' + new Date(value.payment_date).toLocaleDateString("en-US", options) + '</td>' +
                                '<td>' + value.user.name + '</td>' +
                                '<td>' + value.amount + '</td>' +
                                '<td>' + value.payment_method + '</td>' +
                                '<td style="color: green">' + value.status + '</td>' +

                                '</tr>'
                            );
                        });


                    } else {
                        $('#member_payment_tr').empty();
                        $('#member_payment_tr').append(
                            '<tr><td colspan="12" class="text-center">No Salary Found!</td></tr>'
                        );
                    }
                }
            });
        });

        $('body').on('click', '.action-user-delete', function (e) {
            var userName = $(this).data('name');
            userDeleteId = $(this).data('id');
            $('#confirm_user_modal_desc').html('Are you want to delete ' + '<b style="color: red">' + userName + '</b>');
        });

        function time24() {
            const hours = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
            let options = '';
            let timeFormat = 'AM';
            let status = true;
            let hoursLength = hours.length * 2;

            for (let i = 0; i < hoursLength; i++) {
                if (status && i == hours.length) {
                    timeFormat = 'PM';
                    status = false;
                    hoursLength = hours.length;
                    i = 0;
                }
                let time = hours[i] + ' ' + timeFormat;
                options += '<option value="' + time + '">' + time + '</option>';
            }
            var time = options;
            return time;
        }

        function shift(val) {

            if (!val) {
                val = {};
                val.id = '';
                val.name = '';
                val.to = '';
                val.from = '';
            }

            var abc =
                '<div class="row appendedShifts" id="delete-shift-' + count + '">' +
                '<div class="col-md-6">' +
                '<div class="form-group">' +
                '<label>Shift Name <span class="text-danger">*</span></label>' +
                '<input type="text" class="form-control" placeholder="Shift Name" name="shifts[' + count + '][name]" value="' + val.name + '"/>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-2">' +
                '<div class="form-group">' +
                '<div class="form-group">' +
                '<label>From <span class="text-danger">*</span></label>' +
                '<select class="select2 form-control select2-multiple shift edit-shift-from-' + val.id + '" name="shifts[' + count + '][from]" data-placeholder="Choose ..." data-parsley-required="true" data-parsley-required-message="Please select time">' +
                time24() +
                '</select>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-2">' +
                '<div class="form-group">' +
                '<div class="form-group">' +
                '<label>To <span class="text-danger">*</span></label>' +
                '<select class="select2 form-control select2-multiple shift edit-shift-to-' + val.id + '" name="shifts[' + count + '][to]" data-placeholder="Choose ..." data-parsley-required="true" data-parsley-required-message="Please select time">' +
                time24() +
                '</select>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-2 mt-4">' +
                '<div class="form-group">' +
                '<input type="button" data-id="' + count + '" class="btn btn-outline-danger btn-block btn-block deleteShift" value="Delete" />' +
                '</div>' +
                '</div>' +
                '</div>'
            return abc;
        }

        $('.appendMore').on('click', function (e) {
            e.preventDefault();
            let html = shift(val);
            count++;
            $('.appendShift').append(html);
            $('.select2-multiple').select2();
            $('.select2-container').addClass('d-block');
        })

        $('.appendMoreEditBtn').on('click', function (e) {
            e.preventDefault();
            let html = shift(val);
            count++;
            $('.appendShiftOnEdit').append(html);
            $('.select2-multiple').select2();
            $('.select2-container').addClass('d-block');
        })

        $(document).on('click', '.deleteShift', function () {
            let id = $(this).data('id');
            $('#delete-shift-' + id).remove()
        })
    </script>

@endsection
