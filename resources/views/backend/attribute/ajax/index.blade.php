@section('script')
    <script src="{{URL::asset('/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>

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
                ajax: "{{route('attribute.index')}}",
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

        });

        $('#create-attribute').parsley();
        var attributeId = null;
        $('#create-attribute').on('submit', function (e) {
            e.preventDefault();
            var self = $(this);
            loading(self, true);
            var formData = new FormData(this);
            if ($('#create-attribute').parsley().isValid()) {
                $.ajax({
                    url: "{{route('attribute.store')}}",
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        toastr.success(response.message);
                        $('#create-attribute-modal').modal('hide');
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

            attributeId = $(this).data('id');

            $.ajax({
                url: '{{ url("/attribute/delete") }}' + '/' + attributeId,
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
            $('#edit-attribute-modal').modal('show');
            attributeId = $(this).data("id");

            $.ajax({
                url: "{{url('attribute/edit/')}}" + "/" + attributeId,
                type: 'get',
                success: function (response) {
                    $('#edit_attribute_name').val(response.attribute.name);
                },

                error: function (error) {
                    toastrErrors(error);
                }
            });
        });

        // update attribute
        $('#update-attribute').parsley();
        $('body').on('submit', '#update-attribute', function (e) {

            e.preventDefault();
            var self = $(this);
            loading(self, true);

            var formData = new FormData(this);
            if ($('#update-attribute').parsley().isValid()) {
                $.ajax({
                    url: '{{ url("/attribute/update") }}' + '/' + attributeId,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,

                    success: function (response) {
                        $('#edit-attribute-modal').modal('hide');
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

        $('body').on('click', '.toggle-status-attribute', function (e) {
            e.preventDefault();
            attributeId = $(this).data('id');
            $.ajax({
                url: '{{ url("/attribute/status") }}' + '/' + attributeId,
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
