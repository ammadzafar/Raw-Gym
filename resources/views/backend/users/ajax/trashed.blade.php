@section('script')
    <script src="{{URL::asset('/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>
    <script src="{{ URL::asset('/libs/jszip/jszip.min.js')}}"></script>
    <script src="{{ URL::asset('/libs/pdfmake/pdfmake.min.js')}}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var loadingBtn = null;

        $(document).ready(function () {
            var userId = null;
            $('#phone').inputmask("(99) 999-9999999");
            $('edit_user_phone').inputmask("(99) 999-9999999");
            var table = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                cache: true,
                order: [[0, 'desc']],
                ajax: "{{ route('user.trashed-users') }}",
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
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
                ],
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
        });

        var userId = null;

        $('body').on('click', '.action-restore', function (e) {
            e.preventDefault();
            userId = $(this).data('id');
            $.ajax({
                url: '{{ url("/user/restore") }}' + '/' + userId,
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

        $('body').on('click', '#yes_user_delete_confirmed', function (e) {
            e.preventDefault();

            loadingBtn = Ladda.create($('#yes_user_delete_confirmed')[0]);
            loadingBtn.start();

            $.ajax({
                url: '{{ url("/user/hard-delete") }}' + '/' + userId,
                method: 'GET',
                success: function (response) {
                    loadingBtn.stop();
                    $('#user-delete-modal').modal('hide')
                    $('.datatable').DataTable().ajax.reload(null, false);
                    toastr.success(response.message);
                },
                error: function (error) {
                    toastrErrors(error)
                    loadingBtn.stop();
                }
            });
        });

        $('body').on('click', '.action-user-delete', function (e) {
            var userName = $(this).data('name');
            userId = $(this).data('id');
            $('#confirm_user_modal_desc').html('Are you sure, you want to permanently delete ' + '<b class="text-danger">' + userName + '</b>');
        })

    </script>

@endsection
