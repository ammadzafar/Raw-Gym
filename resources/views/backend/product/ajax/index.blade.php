@section('script')
    <script src="{{URL::asset('/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>

    <script>
        $('.select2-multiple').select2();
        $('.select2-container').addClass('d-block');

        $(document).ready(function () {
            var table = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                cache: true,
                order: [[0, 'desc']],
                ajax: "{{route('product.index')}}",
                columns: [{
                    data: 'created',
                    name: 'created'
                },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'brand',
                        name: 'brand',
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

        $('body').on('click', '.action-delete', function (e) {

            e.preventDefault();

            productId = $(this).data('id');

            $.ajax({
                url: '{{ url("/product/delete") }}' + '/' + productId,
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

        $('body').on('click', '.toggle-status-product', function (e) {
            e.preventDefault();
            productId = $(this).data('id');
            $.ajax({
                url: '{{ url("/product/status") }}' + '/' + productId,
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

        $('body').on('click', '.toggle-featured-product', function (e) {
            e.preventDefault();
            productId = $(this).data('id');
            $.ajax({
                url: '{{ url("/product/featured") }}' + '/' + productId,
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

        $('body').on('click', '.toggle-top-product', function (e) {
            e.preventDefault();
            productId = $(this).data('id');
            $.ajax({
                url: '{{ url("/product/top") }}' + '/' + productId,
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
