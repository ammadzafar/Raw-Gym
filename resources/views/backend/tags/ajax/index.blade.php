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
                ajax: "{{route('tag.index')}}",
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

        $('#create-tag').parsley();
        var tagId = null;
        $('#create-tag').on('submit', function (e) {
            e.preventDefault();
            var self = $(this);
            loading(self, true);
            var formData = new FormData(this);
            if ($('#create-tag').parsley().isValid()) {
                $.ajax({
                    url: "{{route('tag.store')}}",
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        toastr.success(response.message);
                        $('#create-tag-modal').modal('hide');
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

            tagId = $(this).data('id');

            $.ajax({
                url: '{{ url("/tag/delete") }}' + '/' + tagId,
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
            $('#edit-tag-modal').modal('show');
            tagId = $(this).data("id");

            $.ajax({
                url: "{{url('tag/edit/')}}" + "/" + tagId,
                type: 'get',
                success: function (response) {
                    $('#edit_tag_name').val(response.tag.name);
                },

                error: function (error) {
                    toastrErrors(error);
                }
            });
        });

        // update tag
        $('#update-tag').parsley();
        $('body').on('submit', '#update-tag', function (e) {

            e.preventDefault();
            var self = $(this);
            loading(self, true);

            if ($('#update-tag').parsley().isValid()) {
                $.ajax({
                    url: '{{ url("/tag/update") }}' + '/' + tagId,
                    method: 'POST',
                    data: $(this).serialize(),

                    success: function (response) {
                        $('#edit-tag-modal').modal('hide');
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

        $('body').on('click', '.toggle-status-tag', function (e) {
            e.preventDefault();
            tagId = $(this).data('id');
            $.ajax({
                url: '{{ url("/tag/status") }}' + '/' + tagId,
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
