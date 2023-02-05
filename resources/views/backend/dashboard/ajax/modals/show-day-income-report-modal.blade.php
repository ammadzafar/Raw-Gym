<script>
    $('body').on('click', '.todayInExReportBtn', function (e) {
        e.preventDefault();
        let href = $(this).attr('href')

        $.ajax({
            url: href,
            type: 'get',

            success: function (res) {
                let date = new Date(res.date).toDateString();
                let income = res.income;
                let expense = res.expenses;

                let totalIncome = res.totalIncome;
                let totalExpense = res.totalExpense;
                let totalProfit = parseInt(totalIncome) - parseInt(totalExpense);

                let incomeHtml = '';
                let expenseHtml = '';
                let profitHtml = '';

                if (income.length) {
                    $.each(income, function (key, value) {
                        incomeHtml += '<tr>' +
                            '<td>' + value.collected_by.name + '</td>' +
                            '<td>' + value.member.name + '</td>' +
                            '<td>' + value.reg_fee + '</td>' +
                            '<td>' + value.fees + '</td>' +
                            '<td>' + value.personal_training_fees + '</td>' +
                            '<td>' + value.in_house_training_fees + '</td>' +
                            '<td>' + value.extra_charges + '</td>' +
                            '<td>' + value.classes_fees + '</td>' +
                            '</tr>';
                    })
                } else {
                    incomeHtml = '<tr class="text-center"><td colspan="5">No income found!</td></tr>';
                }

                if (expense.length) {
                    $.each(expense, function (key, value) {
                        expenseHtml += '<tr>' +
                            '<td>' + value.label + '</td>' +
                            '<td>' + value.amount + '</td>' +
                            '</tr>';
                    })
                } else {
                    expenseHtml = '<tr class="text-center"><td colspan="2">No expense found!</td></tr>';
                }

                if (totalProfit < 0) {
                    profitHtml = '<span class="text-danger">' + totalProfit + '</span>';
                } else {
                    profitHtml = '<span class="text-success">' + totalProfit + '</span>';
                }

                $('#incomeTable').empty().append(incomeHtml)
                $('#expenseTable').empty().append(expenseHtml)
                $('#totalIncome').html(totalIncome)
                $('#totalExpense').html(totalExpense)
                $('#totalProfit').html(profitHtml)
                $('#date').html(date)
            },

            error: function (err) {
                toastrErrors(err);
            }
        })
    })
</script>
