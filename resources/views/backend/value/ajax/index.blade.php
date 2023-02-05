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
                ajax: "{{route('value.index')}}",
                columns: [{
                    data: 'created',
                    name: 'created'

                },
                    {
                        data: 'attribute',
                        name: 'attribute',
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

        $('#create-value').parsley();
        var valueId = null;
        $('#create-value').on('submit', function (e) {
            e.preventDefault();
            var self = $(this);
            loading(self, true);
            var formData = new FormData(this);
            if ($('#create-value').parsley().isValid()) {
                $.ajax({
                    url: "{{route('value.store')}}",
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        toastr.success(response.message);
                        $('#create-value-modal').modal('hide');
                        $('.datatable').DataTable().ajax.reload(null, false);
                        self[0].reset();
                        $('#select_attribute').trigger('change');
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

            valueId = $(this).data('id');

            $.ajax({
                url: '{{ url("/value/delete") }}' + '/' + valueId,
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
            $('#edit-value-modal').modal('show');
            valueId = $(this).data("id");

            $.ajax({
                url: "{{url('value/edit/')}}" + "/" + valueId,
                type: 'get',
                success: function (response) {
                    $('#edit_value_name').val(response.value.name);
                    $('#edit_attribute_id').val(response.value.attribute_id);
                    $('#edit_attribute_id').trigger('change');
                },

                error: function (error) {
                    toastrErrors(error);
                }
            });
        });

        // update valueedit_value_id
        $('#update-value').parsley();
        $('body').on('submit', '#update-value', function (e) {

            e.preventDefault();
            var self = $(this);
            loading(self, true);

            var formData = new FormData(this);
            if ($('#update-value').parsley().isValid()) {
                $.ajax({
                    url: '{{ url("/value/update") }}' + '/' + valueId,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,

                    success: function (response) {
                        $('#edit-value-modal').modal('hide');
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

        $('body').on('click', '.toggle-status-value', function (e) {
            e.preventDefault();
            valueId = $(this).data('id');
            $.ajax({
                url: '{{ url("/value/status") }}' + '/' + valueId,
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
