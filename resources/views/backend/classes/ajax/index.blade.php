@section('script')
    <script src="{{URL::asset('/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script>
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.select2-multiple').select2();
        $('.select2-container').addClass('d-block');
        $(document).ready(function () {
            var table = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                cache: true,
                order: [[0, 'desc']],
                ajax: "{{route('classes.index')}}",
                columns: [{
                    data: 'name',
                    name: 'name'

                },
                    {
                        data: 'Monday',
                        name: 'Monday',
                        orderable: false,
                        searchable: false

                    },
                    {
                        data: 'Tuesday',
                        name: 'Tuesday',
                        orderable: false,
                        searchable: false

                    },
                    {
                        data: 'Wednesday',
                        name: 'Wednesday',
                        orderable: false,
                        searchable: false

                    },
                    {
                        data: 'Thursday',
                        name: 'Thursday',
                        orderable: false,
                        searchable: false

                    },
                    {
                        data: 'Friday',
                        name: 'Friday',
                        orderable: false,
                        searchable: false

                    },
                    {
                        data: 'Saturday',
                        name: 'Saturday',
                        orderable: false,
                        searchable: false

                    },
                    {
                        data: 'Sunday',
                        name: 'Sunday',
                        orderable: false,
                        searchable: false

                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

        });

        $('#create-classes').parsley();
        var classesId = null;
        $('#create-classes').on('submit', function (e) {
            e.preventDefault();
            var self = $(this);
            loading(self, true);
            var formData = new FormData(this);
            if ($('#create-classes').parsley().isValid()) {
                $.ajax({
                    url: "{{route('classes.store')}}",
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        toastr.success(response.message);
                        $('#create-classes-modal').modal('hide');
                        $('.datatable').DataTable().ajax.reload(null, false);
                        self[0].reset();
                        loading(self, false)
                    },
                    error: function (error) {
                        toastrErrors(error);
                        loading(self, false)
                    }
                });
            }

        });

        $('body').on('click', '.action-delete', function (e) {

            e.preventDefault();

            classesId = $(this).data('id');

            $.ajax({
                url: '{{ url("/classes/delete") }}' + '/' + classesId,
                method: 'GET',

                success: function (response) {
                    $('.datatable').DataTable().ajax.reload(null, false);
                    toastr.success(response.message);
                },

                error: function (error) {
                    toastrErrors(error)
                }
            });
        });

        $(document).on('click', '.action-edit', function (e) {
            $('#edit-classes-modal').modal('show');
            classesId = $(this).data("id");
            $('.edit_Monday').prop('checked', false);
            $('.edit_Tuesday').prop('checked', false);
            $('.edit_Wednesday').prop('checked', false);
            $('.edit_Thursday').prop('checked', false);
            $('.edit_Friday').prop('checked', false);
            $('.edit_Saturday').prop('checked', false);
            $('.edit_Sunday').prop('checked', false);

            $.ajax({
                url: "{{url('classes/edit/')}}" + "/" + classesId,
                type: 'get',
                success: function (response) {
                    $('#edit_classes_name').val(response.classes.name);

                    if(response.classes.Monday==true)
                    {
                        $('.edit_Monday').prop('checked', true);
                    }
                    if(response.classes.Tuesday==true)
                    {
                        $('.edit_Tuesday').prop('checked', true);
                    }
                    if(response.classes.Wednesday==true)
                    {
                        $('.eid_Wednesday').prop('checked', true);
                    }
                    if(response.classes.Thursday==true)
                    {
                        $('.eid_Thursday').prop('checked', true);
                    }
                    if(response.classes.Friday==true)
                    {
                        $('.eid_Friday').prop('checked', true);
                    }
                    if(response.classes.Saturday==true)
                    {
                        $('.eid_Saturday').prop('checked', true);
                    }
                    if(response.classes.Sunday==true)
                    {
                        $('.eid_Sunday').prop('checked', true);
                    }
                },

                error: function (error) {
                    toastrErrors(error);
                }
            });
        });

        // update classes
        $('#update-classes').parsley();
        $('body').on('submit', '#update-classes', function (e) {

            e.preventDefault();
            var self = $(this);
            loading(self, true);

            if ($('#update-classes').parsley().isValid()) {
                $.ajax({
                    url: '{{ url("/classes/update") }}' + '/' + classesId,
                    method: 'POST',
                    data: $(this).serialize(),

                    success: function (response) {
                        $('#edit-classes-modal').modal('hide');
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

        $('body').on('click', '.toggle-status-classes', function (e) {
            e.preventDefault();
            classesId = $(this).data('id');
            $.ajax({
                url: '{{ url("/classes/status") }}' + '/' + classesId,
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

    </script>

@endsection
