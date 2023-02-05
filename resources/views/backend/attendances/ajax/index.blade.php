@section('script')
    <script src="{{URL::asset('/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>

    <script>

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function () {
            $('.datatable').DataTable({
                "pageLength": 10,
                "order": [[0, 'desc']]
            });
        });


       /* $(document).on("click", '.toggle-status-attendance', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                url: '{{url("attendance/status/")}}' + '/' + id,
                type: 'get',
                success: function (response) {
                    toastr.success(response.message);
                    refreshDiv('.attendance_list')
                },
                error: function (error) {
                    toastrErrors(error);
                }
            });
        });*/

        $(document).on("click", '.toggle-status-attendance', function (e) {
            // e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                url: '{{url("attendance/status/")}}' + '/' + id,
                type: 'get',
                success: function (response) {
                    toastr.success(response.message);
                },
                error: function (error) {
                    toastrErrors(error);
                }
            });
        });
    </script>
@endsection
