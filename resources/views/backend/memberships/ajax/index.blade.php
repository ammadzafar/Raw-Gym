@section('script')
    <script src="{{URL::asset('/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }
            });
            var membershipDeleteId = null;
            loadingBtn = null;
            $('.select2-multiple').select2();
            $('.select2-container').addClass('d-block');


            var membershipId = null;
            $('#create-membership').parsley();

            $('#create-membership').on('submit', function (e) {
                e.preventDefault();
                var self = $(this);
                loading(self, true);
                var formData = new FormData(this);
                if ($('#create-membership').parsley().isValid()) {

                    $.ajax({
                        url: "{{route('membership.store')}}",
                        type: 'post',
                        processData: false,
                        contentType: false,
                        data: formData,

                        success: function (response) {
                            toastr.success(response.message);
                            loading(self, false);
                            $('#create-membership-modal').modal('hide');
                            self[0].reset();
                            refreshDiv('.memberships_list');
                        },
                        error: function (error) {
                            toastrErrors(error);
                            loading(self, false);
                        }
                    });
                }

            });

            // delete membership
            $('body').on('click', '#yes_membership_delete_confirmed', function (e) {
                loadingBtn = Ladda.create($('#yes_membership_delete_confirmed')[0]);

                loadingBtn.start();
                e.preventDefault();

                $.ajax({
                    url: '{{ url("/membership/delete") }}' + '/' + membershipDeleteId,
                    method: 'GET',

                    success: function (response) {
                        loadingBtn.stop();
                        $('#membership-del-modal').modal('hide');
                        refreshDiv('.memberships_list');
                        toastr.success(response.message);
                    },
                    error: function (error) {
                        toastrErrors(error)
                    }
                });
            });

            // Edit membership
            $(document).on('click', '.action-edit', function (e) {
                $('#edit-membership-modal').modal('show');
                membershipId = $(this).data("id");


                $.ajax({
                    url: "{{url('membership/edit/')}}" + "/" + membershipId,
                    type: 'get',
                    success: function (response) {
                        if (response.membership.membership_type == "monthly"){
                            $('#duration-mw').html('');
                            $('#duration-mw').append("Duration (in month's)\n" +
                                "                    <span style=\"color: red\"> *</span>");
                            $('#edit_membership_type').val('monthly')
                        }else {
                            $('#duration-mw').html('');
                            $('#duration-mw').append("Duration (in week's)\n" +
                                "                    <span style=\"color: red\"> *</span>");
                            $('#edit_membership_type').val('weekly')
                        }
                        $('#edit-membership-name').val(response.membership.name);
                        $('#edit-membership-amount').val(response.membership.fees);
                        $('#edit-membership-signup-fee').val(response.membership.reg_fee);
                        $('#edit-membership-period').val(response.membership.duration);
                        $('#edit-membership-description').val(response.membership.description);

                    },

                    error: function (error) {
                        toastrErrors(error);
                    }
                });


            });

            // Update
            $('#update-membership').parsley();
            $('body').on('submit', '#update-membership', function (e) {
                var self = $(this);
                loading(self, true);
                e.preventDefault();
                if ($('#update-membership').parsley().isValid()) {
                    $.ajax({
                        url: '{{ url("/membership/update") }}' + '/' + membershipId,
                        method: 'POST',
                        data: $(this).serialize(),

                        success: function (response) {
                            loading(self, false);
                            $('#edit-membership-modal').modal('hide');
                            refreshDiv('.memberships_list');
                            toastr.success(response.message);
                        },

                        error: function (error) {
                            toastrErrors(error);
                            loading(self, false);
                        }
                    });
                }

            });

            // for membership status.
            $('body').on('click', '.toggle-status-membership', function (e) {
                e.preventDefault();
                membershipId = $(this).data('id');
                $.ajax({
                    url: '{{ url("/membership/status") }}' + '/' + membershipId,
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


            // for membership Featured.
            $('body').on('click', '.toggle-featured-membership', function (e) {
                e.preventDefault();
                membershipId = $(this).data('id');
                $.ajax({
                    url: '{{ url("/membership/featured") }}' + '/' + membershipId,
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

            $('body').on('click', '.action-membership-delete', function (e) {
                var membershipName = $(this).data('name');
                membershipDeleteId = $(this).data('id');
                $('#confirm_membership_modal_desc').html('Are you want to delete ' + '<b style="color: red">' + membershipName + '</b>');
            })

            $(document).on('click','#create-new-membership',function () {
                if ($(this).text() == 'Monthly'){

                    $('#month_week').html('');
                    $('#month_week').append("Duration (in month's)\n" +
                        "                    <span style=\"color: red\"> *</span>");
                    $('#membership_type').val('monthly')
                }else {
                    $('#month_week').html('');
                    $('#month_week').append("Duration (in week's)\n" +
                        "                    <span style=\"color: red\"> *</span>");
                    $('#membership_type').val('weekly')
                }
            })
        });
    </script>

@endsection
