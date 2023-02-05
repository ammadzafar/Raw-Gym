@section('script')
    <script src="{{URL::asset('/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }
        });

        var membershipDeleteId = null;
        var loadingBtn = null;
        var membershipId = null;

        $('body').on('click', '.action-restore', function (e) {
            e.preventDefault();
            membershipId = $(this).data('id');
            $.ajax({
                url: '{{ url("/membership/restore") }}' + '/' + membershipId,
                method: 'GET',
                success: function (response) {
                    toastr.success(response.message);
                    refreshDiv('.memberships_list');
                },
                error: function (error) {
                    toastrErrors(error)
                }
            });
        });

        // delete membership
        $('body').on('click', '#yes_membership_delete_confirmed', function (e) {
            loadingBtn = Ladda.create($('#yes_membership_delete_confirmed')[0]);

            loadingBtn.start();
            e.preventDefault();

            $.ajax({
                url: '{{ url("/membership/hard-delete") }}' + '/' + membershipDeleteId,
                method: 'GET',

                success: function (response) {
                    loadingBtn.stop();
                    $('#membership-del-modal').modal('hide');
                    refreshDiv('.memberships_list');
                    toastr.success(response.message);
                },
                error: function (error) {
                    toastrErrors(error)
                    loadingBtn.stop();
                }
            });
        });

        $('body').on('click', '.action-membership-delete', function (e) {
            var membershipName = $(this).data('name');
            membershipDeleteId = $(this).data('id');
            $('#confirm_membership_modal_desc').html('Are you sure, you want to permanently delete ' + '<b class="text-danger">' + membershipName + '</b>');
        })
    </script>

@endsection
