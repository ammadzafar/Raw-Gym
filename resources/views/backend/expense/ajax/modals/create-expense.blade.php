<script>
    $('#create-expense').parsley();
    $('#create-expense').on('submit', function (e) {
        e.preventDefault();
        var self = $(this);
        loading(self, true);
        var formData = new FormData(this);
        if ($('#create-expense').parsley().isValid()) {
            $.ajax({

                url: "{{route('expense.store')}}",
                type: 'post',
                processData: false,
                contentType: false,
                data: formData,
                success: function (response) {
                    loading(self, false);
                    toastr.success(response.message);
                    $('#create-expense-modal').modal('hide');
                    self[0].reset();
                    refreshDiv('.expenses_list')
                    $('.datatable').DataTable().ajax.reload(null, false);
                },
                error: function (error) {
                    toastrErrors(error);
                    loading(self, false);
                }
            });
        }

    });

    let statusesHTML = $('#select_expense_status').html();

    var index = 1;
    $('.addNewExpenseBtn').click(function () {
        $('.expenseRow').append(
            '<div class="col-md-12" id="expense-row-' + index + '">' +
            '<div class="row">' +
            '<div class="col-md-10">' +
            '<div class="row">' +
            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>Amount ({{ env("CURRENCY", "PKR") }})<span style="color: red"> *</span></label>' +
            '<input name="expenses[' + index + '][amount]" type="number" class="form-control" placeholder="amount" data-parsley-type="digits" data-parsley-required="true" data-parsley-required-message="please add only digit"/>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>Label<span style="color: red"> *</span></label>' +
            '<input name="expenses[' + index + '][label]" type="text" class="form-control" placeholder="Label" data-parsley-required="true" />' +
            '</div>' +
            '</div>' +
            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>Status<span style="color: red"> *</span></label>' +
            '<select name="expenses[' + index + '][status]" class="form-control select2-multiple"" data-placeholder="Choose ..." data-parsley-required="true" data-parsley-required-message="Please select status">' +
            statusesHTML +
            '</select>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-2">' +
            '<div class="form-group mt-3">' +
            '<input type="button" data-id="' + index + '" value="Remove" class="removeExpenseRow w-100 btn btn-danger waves-effect waves-light mt-2">' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>'
        );
        index++
    });

    $('body').on('click', '.removeExpenseRow', function () {
        let rowId = $(this).data('id');
        $('#expense-row-' + rowId).remove();
    });
</script>
