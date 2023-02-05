@section('script')

    <script src="{{URL::asset('/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>


    <script>

        function formatState(state) {
            if (!state.id) {
                return state.text;
            }
            var baseUrl = "{{ env('ASSET_URL') }}";
            let path = $(state.element).data('image') ? $(state.element).data('image') : '/images/users/noprofile.jfif';
            var $state = $(
                '<span><img src="' + baseUrl + path + '" class="rounded-circle mr-1" width="25" height="25"/>' + state.text + '</span>'
            );
            return $state;
        };

        $('#member-locker').select2({
            templateResult: formatState
        });

        $('.select2-container').addClass('d-block');
        let lockerId = null;
        var loadingBtn = null;
        $('body').on('click', '#create-new-locker', function (e) {

            lockerId = $(this).data('id');

            $.ajax({
                url: '{{ url('locker/edit')}}' + '/' + lockerId,
                type: 'GET',

                success: function (response) {
                    $('#member-locker').val(response.members ? response.members.id : '');
                    $('#member-locker').trigger('change');
                    $('#locker-no').text(response.locker.number);
                },

                error: function (error) {
                    toastrErrors(error);
                }
            })
        })

        $('body').on('submit', '#create-locker', function (e) {
            e.preventDefault()
            var self = $(this);
            loading(self, true);
            $.ajax({
                url: '{{ url('locker/update')}}' + '/' + lockerId,
                type: 'POST',
                data: $(this).serialize(),

                success: function (response) {
                    toastr.success(response.message);
                    loading(self, false);
                    $('#create-locker-modal').modal('hide');
                    refreshDiv('.locker_list');
                },

                error: function (error) {
                    toastrErrors(error);
                    loading(self, false);
                }
            })
        });
        $('body').on('click', '#locker_modal_btn', function (e) {
            lockerId = $(this).data('id');
            $.ajax({
                url: '{{ url('locker/edit')}}' + '/' + lockerId,
                type: 'GET',
                success: function (response) {
                    $('#locker_number').text(response.locker.number);
                    $('#confirm_locker_modal_desc').text("Are you sure taking key from " + response.members.name);
                },

                error: function (error) {
                    toastrErrors(error);
                }
            })

        });
        $('body').on('click', '#yes_locker_confirmed', function () {
            loadingBtn = Ladda.create($('#yes_locker_confirmed')[0]);

            loadingBtn.start();

            $.ajax({
                url: '{{ url('locker/delete')}}' + '/' + lockerId,
                type: 'GET',
                success: function (response) {
                    toastr.success(response.message);
                    loadingBtn.stop();
                    $('#confirm-locker-modal').modal('hide');
                    refreshDiv('.locker_list');

                },
                error: function (error) {
                    toastrErrors(error);
                }
            });

        });
    </script>
@endsection
