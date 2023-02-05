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
        var roleId = null;

        $(document).ready(function () {
            var table = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                cache: true,
                order: [[0, 'desc']],
                ajax: "{{route('role.trashed-roles')}}",
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

        $('body').on('click', '.action-restore', function (e) {
            e.preventDefault();
            roleId = $(this).data('id');
            $.ajax({
                url: '{{ url("/role/restore") }}' + '/' + roleId,
                method: 'GET',
                success: function (response) {
                    toastr.success(response.message);
                    $('.datatable').DataTable().ajax.reload(null, false);
                },
                error: function (error) {
                    toastrErrors(error)
                }
            });
        });


        $('body').on('click', '#yes_role_delete_confirmed', function (e) {

            e.preventDefault();
            loadingBtn = Ladda.create($('#yes_role_delete_confirmed')[0]);

            loadingBtn.start();

            $.ajax({
                url: '{{ url("/role/hard-delete") }}' + '/' + roleId,
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

        $('body').on('click', '.action-role-delete', function (e) {
            var roleName = $(this).data('name');
            roleId = $(this).data('id');
            $('#confirm_role_delete_modal_desc').html('Are you sure, you want to permanently delete ' + '<b class="text-danger">' + roleName + '</b>');
        })
    </script>

@endsection
