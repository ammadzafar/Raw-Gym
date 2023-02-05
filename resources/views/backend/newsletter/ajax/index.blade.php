@section('script')
    <script src="{{URL::asset('/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>
    <script src="{{ URL::asset('/libs/jszip/jszip.min.js')}}"></script>
    <script src="{{ URL::asset('/libs/pdfmake/pdfmake.min.js')}}"></script>

    <script>
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.select2-multiple').select2();
        $('.select2-container').addClass('d-block');
        var table = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            cache: true,
            order: [[0, 'desc']],
            ajax: "{{route('newsletter.index')}}",
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            dom: '<"top d-flex justify-content-between"Bf>rt<"bottom d-flex justify-content-between"ip><"clear">',
            buttons: [
                'copy', 'excel', 'pdf', 'print', 'pageLength'
            ],
            columns: [{
                data: 'created',
                name: 'created'

            },
                {
                    data: 'email',
                    name: 'email',
                },
            ]
        });

        $('.buttons-html5, .buttons-print, .buttons-collection').addClass('btn-dark').removeClass('btn-secondary')
    </script>

@endsection
