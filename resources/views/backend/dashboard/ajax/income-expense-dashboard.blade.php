@section('script')
    <script src="{{ URL::asset('libs/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{ URL::asset('libs/jquery-vectormap/jquery-vectormap.min.js')}}"></script>
    <script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>
    {{--    <script src="{{ URL::asset('js/pages/dashboard.init.js')}}"></script>--}}

    <script>

        $(document).ready(function () {
            $('.datatable').DataTable({
                "pageLength": 5,
                "order": [[0, 'desc']]
            });
        });

        const currentDayIncome = JSON.parse('{{ $currentDayincome }}');
        const currentDayExpense = JSON.parse('{{ $currentDayExpense }}');
        const currentDayProfit = JSON.parse('{{ $currentDayprofit }}');

        const yesterdayIncome = JSON.parse('{{ $yesterdayIncome }}');
        const yesterdayExpense = JSON.parse('{{ $yesterdayExpense }}');
        const yesterdayProfit = JSON.parse('{{ $yesterdayProfit }}');

        const currentWeekIncome = JSON.parse('{{ $currentWeekIncome }}');
        const currentWeekExpense = JSON.parse('{{ $currentWeekExpense }}');
        const currentWeekProfit = JSON.parse('{{ $currentWeekProfit }}');

        const currentMonthIncome = JSON.parse('{{ $currentmonthincome }}');
        const currentMonthExpense = JSON.parse('{{ $currentMonthExpense }}');
        const currentMonthProfit = JSON.parse('{{ $currentMonthprofit }}');

        const currentYearIncome = JSON.parse('{{ $currentYearincome }}');
        const currentYearExpense = JSON.parse('{{ $currentYearExpense }}');
        const currentYearProfit = JSON.parse('{{ $currentYearprofit }}');

        const totalIncome = JSON.parse('{{ $totalincome }}');
        const totalExpense = JSON.parse('{{ $totalExpense }}');
        const totalProfit = JSON.parse('{{ $totalprofit }}');

        const last12MonthsInEx = JSON.parse('{!! $last12MonthsChart !!}');

        const currency = '{{ env('CURRENCY', 'Ksh') }}';

        var IncomeExpenseChartOptions = {
            series: [totalIncome, totalExpense, totalProfit],
            chart: {
                height: 180,
                type: 'pie'
            },
            labels: ["Income (" + currency + ")", "Expense (" + currency + ")", "Profit (" + currency + ")"],
            legend: {
                show: false
            },
            colors: ['#49A5FF', '#FFA81E', '#27bf00']
        };

        var inExChart = new ApexCharts(document.querySelector("#InExDonatChart"), IncomeExpenseChartOptions);
        inExChart.render();

        var incomeExpenseLineChartOptions = {
            series: [{
                name: "Income (" + currency + ")",
                type: 'area',
                data: last12MonthsInEx.last12MonthsIncome,
            }, {
                name: "Expense (" + currency + ")",
                data: last12MonthsInEx.last12MonthsExpense,
                type: 'area'
            }, {
                name: "Profit (" + currency + ")",
                data: last12MonthsInEx.last12MonthsProfit,
                type: 'line'
            }],
            chart: {
                height: 260,
                type: 'line',
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            colors: ['#3b5de7', '#e7913b', '#45cb85'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: '3',
                dashArray: [4, 4, 0]
            },
            markers: {
                size: 3
            },
            xaxis: {
                categories: last12MonthsInEx.last12Months,
                // title: {
                //     text: 'Month'
                // }
            },
            fill: {
                type: 'solid',
                opacity: [0.1, 0.1, 0.1]
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right'
            }
        };
        var incomeExpenseLineChart = new ApexCharts(document.querySelector("#line-chart"), incomeExpenseLineChartOptions);
        incomeExpenseLineChart.render();

        $(document).on('change', '#incomeExpenseChartFilter', function (e) {

            const value = $(this).val();

            if (value === 'today') {
                $('.incomeCountChart').text(currentDayIncome + ' ' + currency);
                $('.expenseCountChart').text(currentDayExpense + ' ' + currency);
                $('.profitCountChart').text(currentDayProfit + ' ' + currency);
                inExChart.updateOptions({
                    series: [currentDayIncome, currentDayExpense, currentDayProfit],
                })
            } else if (value === 'yesterday') {
                $('.incomeCountChart').text(yesterdayIncome + ' ' + currency);
                $('.expenseCountChart').text(yesterdayExpense + ' ' + currency);
                $('.profitCountChart').text(yesterdayProfit + ' ' + currency);
                inExChart.updateOptions({
                    series: [yesterdayIncome, yesterdayExpense, yesterdayProfit],
                })
            } else if (value === 'week') {
                $('.incomeCountChart').text(currentWeekIncome + ' ' + currency);
                $('.expenseCountChart').text(currentWeekExpense + ' ' + currency);
                $('.profitCountChart').text(currentWeekProfit + ' ' + currency);
                inExChart.updateOptions({
                    series: [currentWeekIncome, currentWeekExpense, currentWeekProfit],
                })
            } else if (value === 'month') {
                $('.incomeCountChart').text(currentMonthIncome + ' ' + currency);
                $('.expenseCountChart').text(currentMonthExpense + ' ' + currency);
                $('.profitCountChart').text(currentMonthProfit + ' ' + currency);
                inExChart.updateOptions({
                    series: [currentMonthIncome, currentMonthExpense, currentMonthProfit],
                })
            } else if (value === 'year') {
                $('.incomeCountChart').text(currentYearIncome + ' ' + currency);
                $('.expenseCountChart').text(currentYearExpense + ' ' + currency);
                $('.profitCountChart').text(currentYearProfit + ' ' + currency);
                inExChart.updateOptions({
                    series: [currentYearIncome, currentYearExpense, currentYearProfit],
                })
            } else if (value === 'all') {
                $('.incomeCountChart').text(totalIncome + ' ' + currency);
                $('.expenseCountChart').text(totalExpense + ' ' + currency);
                $('.profitCountChart').text(totalProfit + ' ' + currency);
                inExChart.updateOptions({
                    series: [totalIncome, totalExpense, totalProfit],
                })
            }
        })

        // function incomeExpenseDonatChart(totalIncome, totalExpense, totalProfit) {
        //     var options = {
        //         series: [totalIncome, totalExpense, totalProfit],
        //         chart: {
        //             height: 180,
        //             type: 'pie'
        //         },
        //         labels: ["Income", "Expense", "Profit"],
        //         legend: {
        //             show: false
        //         },
        //         colors: ['#49A5FF', '#FFA81E', '#27bf00']
        //     };
        //     var chart = new ApexCharts(document.querySelector("#customersDonatChart"), options);
        //     chart.render();
        // }
    </script>
@endsection
