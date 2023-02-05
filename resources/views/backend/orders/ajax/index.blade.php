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
                ajax: "{{route('order.index')}}",
                columns: [{
                    data: 'created',
                    name: 'created'

                },
                    {
                        data: 'customer',
                        name: 'customer',
                    },
                    {
                        data: 'address',
                        name: 'address',
                    },
                    {
                        data: 'status',
                        name: 'status',
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

        var orderId = null;
        $('body').on('click', '.action-delete', function (e) {

            e.preventDefault();

            orderId = $(this).data('id');

            $.ajax({
                url: '{{ url("/order/delete") }}' + '/' + orderId,
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

        $('body').on('click', '.update-status', function (e) {

            e.preventDefault();

            let orderId = $(this).data('id');
            let status = $(this).val();

            $.ajax({
                url: '{{ url("/order/status") }}' + '/' + orderId + '/' + status,
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

    </script>

@endsection
