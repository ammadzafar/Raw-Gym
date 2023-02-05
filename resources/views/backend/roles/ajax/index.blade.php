@section('script')
    <script src="{{URL::asset('/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>
    <script src="{{ URL::asset('/libs/jszip/jszip.min.js')}}"></script>
    <script src="{{ URL::asset('/libs/pdfmake/pdfmake.min.js')}}"></script>

    <script>
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var loadingBtn = null;
        $('.select2-multiple').select2();
        $('.select2-container').addClass('d-block');
        $(document).ready(function () {
            var table = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                cache: true,
                order: [[0, 'desc']],
                ajax: "{{route('role.index')}}",
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                dom: '<"top d-flex justify-content-between"Bf>rt<"bottom d-flex justify-content-between"ip><"clear">',
                buttons: [
                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: [0, 1]
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1]
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1]
                        }
                    },
                    {
                        extend: 'pageLength',
                        exportOptions: {
                            columns: [0, 1]
                        }
                    },
                ],
                columns: [{
                    data: 'created',
                    name: 'created'

                },
                    {
                        data: 'name',
                        name: 'name',
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
        });

        $('#create-role').parsley();
        var roleId = null;
        $('#create-role').on('submit', function (e) {
            e.preventDefault();
            var self = $(this);
            loading(self, true);
            var formData = new FormData(this);
            if ($('#create-role').parsley().isValid()) {
                $.ajax({
                    url: "{{route('role.store')}}",
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        toastr.success(response.message);
                        $('#create-role-modal').modal('hide');
                        $('.datatable').DataTable().ajax.reload(null, false);
                        self[0].reset();
                        $('#role_permissions').val([]);
                        $('#role_permissions').trigger('change');
                        loading(self, false)
                    },
                    error: function (error) {
                        toastrErrors(error);
                        loading(self, false)
                    }
                });
            }

        });

        $('body').on('click', '#yes_role_delete_confirmed', function (e) {

            e.preventDefault();
            loadingBtn = Ladda.create($('#yes_role_delete_confirmed')[0]);

            loadingBtn.start();

            $.ajax({
                url: '{{ url("/role/delete") }}' + '/' + roleId,
                method: 'GET',
                success: function (response) {
                    loadingBtn.stop();
                    $('.datatable').DataTable().ajax.reload(null, false);
                    $('#role-modal').modal('hide');
                    toastr.success(response.message);
                },

                error: function (error) {
                    loadingBtn.stop();
                    toastrErrors(error)
                }
            });
        });

        $(document).on('click', '.action-edit', function (e) {
            $('#edit-role-modal').modal('show');
            roleId = $(this).data("id");


            $.ajax({
                url: "{{url('role/edit/')}}" + "/" + roleId,
                type: 'get',
                success: function (response) {
                    $('#edit_role_name').val(response.role.name);
                    $('#edit_role_permissions').val(response.rolePermissions);
                    $('#edit_role_permissions').trigger('change');
                },

                error: function (error) {
                    toastrErrors(error);
                }
            });
        });

        // update role
        $('#update-role').parsley();
        $('body').on('submit', '#update-role', function (e) {

            e.preventDefault();
            var self = $(this);
            loading(self, true);

            if ($('#update-role').parsley().isValid()) {
                $.ajax({
                    url: '{{ url("/role/update") }}' + '/' + roleId,
                    method: 'POST',
                    data: $(this).serialize(),

                    success: function (response) {
                        $('#edit-role-modal').modal('hide');
                        $('.datatable').DataTable().ajax.reload(null, false);
                        loading(self, false);

                        toastr.success(response.message);
                    },

                    error: function (error) {
                        toastrErrors(error)
                        loading(self, false);
                    }
                });
            }
        });

        $('body').on('click', '.action-role-delete', function (e) {
            e.preventDefault();
            roleId = $(this).data('id');
            $.ajax({
                url: "{{url('role/edit/')}}" + "/" + roleId,
                type: 'get',
                success: function (response) {
                    $('#confirm_role_delete_modal_desc').html('Are you sure to delete ' + '<b style="color: red">' + response.role.name + '</b>');
                },

                error: function (error) {
                    toastrErrors(error);
                }
            });

        })
    </script>

@endsection
