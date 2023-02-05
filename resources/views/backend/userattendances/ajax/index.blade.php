@section('script')
    <script src="{{URL::asset('/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>

    <script>

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on("click", '.toggle-status-attendance', function (e) {
            e.preventDefault();

            let id = $(this).data('id');

            $.ajax({
                url: '{{url("userattendance/approval/")}}' + '/' + id,
                type: 'GET',
                success: function (response) {
                    toastr.success(response.message);
                    refreshDiv('.attendance_list')
                },
                error: function (error) {
                    toastrErrors(error);
                }
            });
        });

        $(document).on('change', '.select_attendance_type', function (e) {
            e.preventDefault();
            var status = '';
            var attendanceId = $(this).data('id');
            status = $(this).val();
            $.ajax({
                url: '{{url("userattendance/status")}}' + '/' + attendanceId,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "status": status
                },

                success: function (response) {
                    toastr.success(response.message);
                    refreshDiv('.attendance_list')
                },
                error: function (error) {
                    toastrErrors(error);
                }
            })
        });

        $('#user-attendance').parsley();
        $(document).on('submit', '#user-attendance', function (e) {
            e.preventDefault();
            var self = $(this);
            loading(self, true);

            if ($('#user-attendance').parsley().isValid()) {
                $.ajax({
                    url: '{{ route("userattendance.bulkapproval") }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        $('#bulk-user-attendance').modal('hide');
                        refreshDiv('.attendance_list')
                        loading(self, false);
                        toastr.success(response.message);
                        self.trigger('reset');
                    },

                    error: function (error) {
                        toastrErrors(error)
                        loading(self, false);

                    }
                });
            }
        });

    </script>
@endsection
