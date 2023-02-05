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

            var genderDonat = JSON.parse('{{ $genderDonat }}');
            attendanceDonatChart(genderDonat);

            var customersDonat = JSON.parse('{{ $customersDonatChart }}');
            customersDonatChart(customersDonat);

        });

        function attendanceDonatChart(value) {
            var options = {
                series: value,
                chart: {
                    height: 230,
                    type: 'donut'
                },
                labels: ["Male", "Female", "Trans", "Other"],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '75%'
                        }
                    }
                },
                legend: {
                    show: false
                },
                colors: ['#4475E7', '#58CB85', '#EDBB3F', '#FA705A']
            };
            var chart = new ApexCharts(document.querySelector("#genderDonatChart"), options);
            chart.render();
        }

        function customersDonatChart(value) {
            var options = {
                series: value,
                chart: {
                    height: 180,
                    type: 'pie'
                },
                labels: ["Membership", "Without Membership"],
                legend: {
                    show: false
                },
                colors: ['#FFA81E', '#49A5FF']
            };
            var chart = new ApexCharts(document.querySelector("#customersDonatChart"), options);
            chart.render();
        }

        function membershipsMembersDonatChart(labels, values) {
            var options = {
                series: value,
                chart: {
                    height: 180,
                    type: 'pie'
                },
                labels: ["Membership", "Without Membership"],
                legend: {
                    show: false
                },
                colors: ['#FFA81E', '#49A5FF']
            };
            var chart = new ApexCharts(document.querySelector("#membershipsMemberDonatChart"), options);
            chart.render();
        }

        const last6MonthsChart = JSON.parse('{!! $last6MonthsChart !!}');

        var last6MonthsMembersChartOptions = {
            series: [{
                name: "Total Members",
                data: last6MonthsChart.last6MonthsCount
            }],
            chart: {
                type: 'bar',
                height: 250,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    barHeight: '24%',
                    endingShape: 'rounded'
                }
            },
            dataLabels: {
                enabled: false
            },
            colors: ['#556ee6'],
            xaxis: {
                categories: last6MonthsChart.last6Months,
            }
        };
        var last6MonthsMembersChart = new ApexCharts(document.querySelector("#bar-chart"), last6MonthsMembersChartOptions);
        last6MonthsMembersChart.render(); // Radar chart

        $(document).on("click", '.toggle-status-attendance', function (e) {
            // e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                url: '{{url("attendance/status/")}}' + '/' + id,
                type: 'get',
                success: function (response) {
                    toastr.success(response.message);
                },
                error: function (error) {
                    toastrErrors(error);
                }
            });
        });
    </script>
@endsection
