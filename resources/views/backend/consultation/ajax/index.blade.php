@section('script')
    <script src="{{URL::asset('/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>

    <script>
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var consultationDeleteId =null;
       var loadingBtn =null;

        $('.select2-multiple').select2();
        $('.select2-container').addClass('d-block');
        $(document).ready(function () {
            var table = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                cache: true,
                order: [[0, 'desc']],
                ajax: "{{route('consultation.index')}}",
                columns: [{
                    data: 'created',
                    name: 'created'

                },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'mobile',
                        name: 'mobile',
                    },
                    {
                        data: 'subject',
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

        $('body').on('click', '#yes_consultation_delete_confirmed', function (e) {
            loadingBtn = Ladda.create($('#yes_consultation_delete_confirmed')[0]);

            loadingBtn.start();
            e.preventDefault();
            $.ajax({
                url: '{{ url("/consultation/delete") }}' + '/' + consultationDeleteId,
                method: 'GET',
                success: function (response) {
                    loadingBtn.stop();
                    $('#create-consultation-modal').modal('hide');
                    $('.datatable').DataTable().ajax.reload(null, false);
                    toastr.success(response.message);
                },

                error: function (error) {
                    loadingBtn.stop();
                    toastrErrors(error)
                }
            });
        });

        $('.action-consultation-history').on("click",function (e) {


        });


        $('body').on('click', '.action-consultation-delete', function (e) {
            var consultationName= $(this).data('name');
            consultationDeleteId = $(this).data('id');
            $('#confirm_consultation_modal_desc').html('Are you want to delete '+'<b style="color: red">'+consultationName+'</b>');
        })

    </script>

@endsection
