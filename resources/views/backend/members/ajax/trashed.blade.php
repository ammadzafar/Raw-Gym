@section('script')
    <script src="{{URL::asset('/libs/select2/select2.min.js')}}"></script>
    <script src="{{URL::asset('/libs/magnific-popup/magnific-popup.min.js')}}"></script>
    <script src="{{URL::asset('/libs/dropzone/dropzone.min.js')}}"></script>

    <script src="{{URL::asset('/js/html2canvas.js')}}"></script>

    <script>

        var loadingBtn = null;
        var memberId = null;

        $('body').on('click', '.action-restore', function (e) {
            e.preventDefault();
            memberId = $(this).data('id');
            $.ajax({
                url: '{{ url("/member/restore") }}' + '/' + memberId,
                method: 'GET',
                success: function (response) {
                    toastr.success(response.message);
                    refreshDiv('.members_list');
                },
                error: function (error) {
                    toastrErrors(error)
                }
            });
        });

        $('body').on('click', '#yes_member_delete_confirmed', function (e) {

            loadingBtn = Ladda.create($('#yes_member_delete_confirmed')[0]);

            e.preventDefault();
            loadingBtn.start();

            $.ajax({
                url: '{{ url("/member/hard-delete") }}' + '/' + memberId,
                method: 'GET',

                success: function (response) {
                    toastr.success(response.message);
                    refreshDiv('.members_list');
                    loadingBtn.stop();
                    $('#confirm-member-delete-modal').modal('hide');
                },

                error: function (error) {
                    toastrErrors(error)
                    loadingBtn.stop();
                }
            });
        });

        $(document).on('submit', '#searchForm', function (e) {

            e.preventDefault()
            let query = $('#search_query').val();

            let url = '{{ url("/members/trashed") }}' + '?query=' + query;

            window.location.replace(url);
        });

        $('body').on('click', '.action-member-delete', function (e) {
            memberId = $(this).data('id');
            var memberName = $(this).data('name');
            $('#confirm_member_delete_modal_desc').html("Are you sure, you want to permanently delete " + '<b class="text-danger">' + memberName + '</b>');
        });
    </script>
@endsection
