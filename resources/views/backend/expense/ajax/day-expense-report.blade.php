@section('script')
    <script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>
    <script src="{{URL::asset('/js/html2canvas.js')}}"></script>

    @include('backend.expense.ajax.modals.create-expense')

    <script>
        $(document).ready(function () {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
       var expenseDeleteId = null;
       var loadingBtn = null;

            var table = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                cache: true,
                order: [[0, 'desc']],
                ajax: "{{ route('expense.index', ['date' => $date]) }}",
                columns: [
                    {
                        data: 'created',
                        name: 'created'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'label',
                        name: 'label'
                    },
                    {
                        data: 'status',
                        name: 'status'
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

        // Edit Expense
        $(document).on('click', '.action-edit', function () {
            $('#Edit-expense-modal').modal('show');
            expenseId = $(this).data("id");
            $.ajax({
                url: "{{url('expense/edit/')}}" + "/" + expenseId,
                type: 'get',
                success: function (response) {
                    $('#edit-expense-date').val(response.expense_list.expense.date);
                    $('#edit-expense-status').val(response.expense_list.status);
                    $('#edit-expense-amount').val(response.expense_list.amount);
                    $('#edit-expense-label').val(response.expense_list.label);
                },

                error: function (error) {
                    toastrErrors(error);
                }
            });
        });

        // Update Expense
        $('#update-expense').parsley();
        $('body').on('submit', '#update-expense', function (e) {
            e.preventDefault();

            if ($('#update-expense').parsley().isValid()) {
                var self = $(this);
                loading(self, true);
                $.ajax({
                    url: '{{ url("/expense/update") }}' + '/' + expenseId,
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        loading(self, false);
                        $('#Edit-expense-modal').modal('hide');
                        $('.datatable').DataTable().ajax.reload(null, false);
                        toastr.success(response.message);
                    },

                    error: function (error) {
                        loading(self, false);
                        toastrErrors(error)
                    }
                });
            }

        });
        // End Expense update

        // delete expense
        $('body').on('click', '#yes_expense_delete_confirmed', function (e) {
            loadingBtn = Ladda.create($('#yes_expense_delete_confirmed')[0]);

            loadingBtn.start();
            e.preventDefault();

            $.ajax({
                url: '{{ url("/expense/delete") }}' + '/' + expenseDeleteId,
                method: 'GET',
                success: function (response) {
                    loadingBtn.stop();
                    $('#delete-expense-modal').modal('hide');
                    $('.datatable').DataTable().ajax.reload(null, false);
                    toastr.success(response.message);
                },
                error: function (error) {
                    toastrErrors(error);
                    loadingBtn.stop();
                }
            });
        });

        // Delete Expense

        $('body').on('click', '.action-expense-delete', function (e) {
            var expenseLable= $(this).data('label');
            expenseDeleteId = $(this).data('id');
            $('#confirm_expense_modal_desc').html('Are you want to delete '+'<b style="color: red">'+expenseLable+'</b>');
        })

    </script>
@endsection
