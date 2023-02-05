@section('script')

    {{--    <script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>--}}
    <script src="{{ URL::asset('libs/apexcharts/apexcharts.min.js')}}"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <script>
        $(document).ready(function () {
            toastr.info('For Daily Expenditure use only date filter');
            amount = [];
            date = [];
            let chart = '';
            $('.daterange').daterangepicker();

            function paymentReportChart(amount,date) {
                var dailyExpenseReport = {
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
                        categories: date,
                    }
                };

                chart = new ApexCharts(document.querySelector('#expense-chart'), dailyExpenseReport);
                chart.render();
            }

            function dailyExpenditure(filter_date= '') {
                $.ajax({
                    type:'GET',
                    url: "{{ route('dashboard.daily.expenditure') }}",
                    data: {
                        filter_date: filter_date,
                    },
                    success: function (response) {
                        amount = [];
                        date = [];
                        $.each(response, function(index, value) {
                            date.push(value['date'])
                            amount.push(value['amount'])
                        });
                        if(chart){chart.destroy()}
                        if(response){paymentReportChart(amount,date)}
                    },
                    error: function() {
                        // console.log(response);
                    }
                });
            }

            function expense_report(filter_name = '',filter_date = ''){
                $('.total-payments').text('');
                $.ajax({
                    type:'GET',
                    url: "{{ route('dashboard.expense.report') }}",
                    data: {
                        filter_name: filter_name,
                        filter_date: filter_date,
                    },
                    success: function (response) {
                        console.log("my-response",response);
                        let sum = 0;
                        // $('.total-payments').text(Object.keys(response).length);

                        $('.expense_data').html('');
                        $.each(response, function(index, value) {
                            $.each(value.amount,function (index,item) {
                                console.log("my-item",item);
                                sum += parseInt(item['amount'])
                                let record = ' <tr>\n' +
                                    '          <td>'+value['date']+'</td>\n' +
                                    '          <td>'+value['category']+'</td>\n'+
                                    '          <td>'+item['label']+'</td>\n'+
                                    '          <td>'+item['amount']+'</td>\n'+
                                    '          </tr>';

                                $('.expense_data').append(record);
                                $('.total-payments').text(sum);
                            })
                            // console.log(total_payment);
                        });
                    },
                    error: function() {
                        // console.log(response);
                    }
                });
            }

            $('#filter').click(function () {
                var filter_name = $('#category').val();
                var filter_date = $('#filter_date').val();

                if(filter_name != '' && filter_date != ''){
                    expense_report(filter_name,filter_date);
                }else if (filter_name == '' && filter_date != ''){
                    dailyExpenditure(filter_date)
                }
                else {
                    toastr.warning('Please apply filters first!');
                }
            })

            $('#reset').click(function(){
                location.reload();
                toastr.info('For Daily Expenditure use only date filter');
            });
        });
    </script>
@endsection
