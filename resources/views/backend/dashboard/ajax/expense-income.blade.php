@section('script')

    {{--    <script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>--}}
    <script src="{{ URL::asset('libs/apexcharts/apexcharts.min.js')}}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <script>
        $(document).ready(function () {
            dates = [];
            amount = [];
            let status = '';
            var chart = '';
            $('.daterange').daterangepicker();
            $(document).on('change','#expense_income',function () {
                status = $(this).val();
            })

            function expenseIncomeChart(amount,dates) {
                var options = {
                    series: [{
                        data: amount
                    }],
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 4,
                            horizontal: false,
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        categories: dates,
                    }
                };
                chart = new ApexCharts(document.querySelector("#expense-income-chart"), options);
                chart.render();
            }

            function expenseIncomeReport(filter_name = '',filter_date = ''){
                $.ajax({
                    type:'GET',
                    url: "{{ route('dashboard.expense.income.report') }}",
                    data: {
                        filter_name: filter_name,
                        filter_date: filter_date,
                    },
                    success: function (response) {
                        amount = [];
                        dates = [];
                        $.each(response, function(index, value) {
                            if (status == 'income'){
                                dates.push(value['date']);
                                let sum = parseInt(value['total_classes_fees']) + parseInt(value['total_fees']) + parseInt(value['total_personal_training_fees']) + parseInt(value['total_in_house_training_fees']) + parseInt(value['total_reg_fees']) - parseInt(value['total_discount']);
                                amount.push(sum);
                            }else {
                                dates.push(value['date']);
                                amount.push(value['amount']);
                            }
                        });
                        if(chart){chart.destroy()}
                        $('.income-expense').text('')
                        status == 'income' ? $('.income-expense').text('Income Report Chart') : $('.income-expense').text('Expense Report Chart')
                        if(response.length){expenseIncomeChart(amount,dates)}
                    },
                    error: function() {
                        // console.log(response);
                    }
                });
            }

            $('#filter').click(function () {
                var filter_name = $('#expense_income').val();
                var filter_date = $('#filter_date').val();
                if(filter_name != '' && filter_date != ''){
                    expenseIncomeReport(filter_name,filter_date);
                } else {
                    toastr.warning('Please apply filters first!');
                }
            })

            $('#reset').click(function(){
                location.reload();
            });
        });
    </script>
@endsection
