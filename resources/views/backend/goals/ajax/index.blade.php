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
                ajax: "{{route('goal.index')}}",
                columns: [{
                    data: 'created',
                    name: 'created'

                },
                    {data: 'image', name: 'image'},
                    {data: 'category', name: 'category'},
                    {data: 'name', name: 'name'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

        });

        $('#create-goal').parsley();
        var goalId = null;
        $('#create-goal').on('submit', function (e) {
            e.preventDefault();
            var self = $(this);
            loading(self, true);
            var formData = new FormData(this);
            if ($('#create-goal').parsley().isValid()) {
                $.ajax({
                    url: "{{route('goal.store')}}",
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        toastr.success(response.message);
                        $('#create-goal-modal').modal('hide');
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

            goalId = $(this).data('id');

            $.ajax({
                url: '{{ url("/goal/delete") }}' + '/' + goalId,
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
            $('#edit-goal-modal').modal('show');
            goalId = $(this).data("id");

            $.ajax({
                url: "{{url('goal/edit/')}}" + "/" + goalId,
                type: 'get',
                success: function (response) {
                    $('#edit_goal_name').val(response.goal.name);
                    $('#edit_goal_category').val(response.goal.category_id).trigger('change');
                    $('#previous_goal_image').attr('src', '{{ env("ASSET_URL") }}' + response.goal.image);
                },

                error: function (error) {
                    toastrErrors(error);
                }
            });
        });

        // update goal
        $('#update-goal').parsley();
        $('body').on('submit', '#update-goal', function (e) {

            e.preventDefault();
            var self = $(this);
            loading(self, true);
            var formData = new FormData(this);

            if ($('#update-goal').parsley().isValid()) {
                $.ajax({
                    url: '{{ url("/goal/update") }}' + '/' + goalId,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,

                    success: function (response) {
                        $('#edit-goal-modal').modal('hide');
                        $('.datatable').DataTable().ajax.reload(null, false);
                        loading(self, false);
                        self[0].reset();
                        toastr.success(response.message);
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
