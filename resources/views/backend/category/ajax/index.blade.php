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
                ajax: "{{route('category.index')}}",
                columns: [{
                    data: 'created',
                    name: 'created'

                },
                    {
                        data: 'parent',
                        name: 'parent',
                    },
                    {
                        data: 'position',
                        name: 'position',
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'image',
                        name: 'image',
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

        $('#create-category').parsley();
        var categoryId = null;
        $('#create-category').on('submit', function (e) {
            e.preventDefault();
            var self = $(this);
            loading(self, true);
            var formData = new FormData(this);
            if ($('#create-category').parsley().isValid()) {
                $.ajax({
                    url: "{{route('category.store')}}",
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        toastr.success(response.message);
                        $('#create-category-modal').modal('hide');
                        $('.datatable').DataTable().ajax.reload(null, false);
                        self[0].reset();
                        $('#select_parent_category').trigger('change')
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

            categoryId = $(this).data('id');

            $.ajax({
                url: '{{ url("/category/delete") }}' + '/' + categoryId,
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
            $('#edit-category-modal').modal('show');
            categoryId = $(this).data("id");

            $.ajax({
                url: "{{url('category/edit/')}}" + "/" + categoryId,
                type: 'get',
                success: function (response) {
                    $('#edit_category_name').val(response.category.name);
                    $('#edit_category_slug').val(response.category.slug);
                    $('#edit_category_id').val(response.category.category_id).trigger('change');
                    $('#edit_category_position').val(response.category.position);
                },

                error: function (error) {
                    toastrErrors(error);
                }
            });
        });

        $('#update-category').parsley();
        $('body').on('submit', '#update-category', function (e) {

            e.preventDefault();
            var self = $(this);
            loading(self, true);

            var formData = new FormData(this);
            if ($('#update-category').parsley().isValid()) {
                $.ajax({
                    url: '{{ url("/category/update") }}' + '/' + categoryId,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,

                    success: function (response) {
                        $('#edit-category-modal').modal('hide');
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

        $('body').on('click', '.toggle-status-category', function (e) {
            e.preventDefault();
            categoryId = $(this).data('id');
            $.ajax({
                url: '{{ url("/category/status") }}' + '/' + categoryId,
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
