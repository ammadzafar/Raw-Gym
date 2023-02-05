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
                ajax: "{{route('brand.index')}}",
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

        $('#create-brand').parsley();
        var brandId = null;
        $('#create-brand').on('submit', function (e) {
            e.preventDefault();
            var self = $(this);
            loading(self, true);
            var formData = new FormData(this);
            if ($('#create-brand').parsley().isValid()) {
                $.ajax({
                    url: "{{route('brand.store')}}",
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        toastr.success(response.message);
                        $('#create-brand-modal').modal('hide');
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

            brandId = $(this).data('id');

            $.ajax({
                url: '{{ url("/brand/delete") }}' + '/' + brandId,
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
            $('#edit-brand-modal').modal('show');
            brandId = $(this).data("id");

            $.ajax({
                url: "{{url('brand/edit/')}}" + "/" + brandId,
                type: 'get',
                success: function (response) {
                    $('#edit_brand_name').val(response.brand.name);
                    $('#edit_brand_slug').val(response.brand.slug);
                    $('#edit_brand_description').val(response.brand.description);
                },

                error: function (error) {
                    toastrErrors(error);
                }
            });
        });

        // update brand
        $('#update-brand').parsley();
        $('body').on('submit', '#update-brand', function (e) {

            e.preventDefault();
            var self = $(this);
            loading(self, true);

            var formData = new FormData(this);
            if ($('#update-brand').parsley().isValid()) {
                $.ajax({
                    url: '{{ url("/brand/update") }}' + '/' + brandId,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,

                    success: function (response) {
                        $('#edit-brand-modal').modal('hide');
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

        $('body').on('click', '.toggle-status-brand', function (e) {
            e.preventDefault();
            brandId = $(this).data('id');
            $.ajax({
                url: '{{ url("/brand/status") }}' + '/' + brandId,
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
