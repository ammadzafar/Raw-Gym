@section('script')

    {{--    <script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>--}}
    <script src="{{ URL::asset('libs/apexcharts/apexcharts.min.js')}}"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <script>
        $(document).ready(function () {
            dates = [];
            time = [];
            members = [];
            var hoursChart = '';
            var chart = '';
            $('.daterange').daterangepicker();
            // memberReportChart(members);
            function memberReportChart(members) {
                var options = {
                    series: members,
                    chart: {
                        width: 380,
                        type: 'pie',
                    },
                    labels: ['Active', 'Expired'],
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                chart = new ApexCharts(document.querySelector("#pie-chart"), options);
                chart.render();
            }

            function members_report(filter_date = ''){
                $.ajax({
                    type:'GET',
                    url: "{{ route('dashboard.member.report') }}",
                    data: {
                        filter_date: filter_date,
                    },
                    success: function (response) {
                        members = [];
                        members.push(response.active,response.expired)
                        if(chart){
                            chart.destroy()
                        }
                        if(members.length){memberReportChart(members)}
                    },
                    error: function() {
                        // console.log(response);
                    }
                });
            }

            $('#filter').click(function () {
                var filter_date = $('#filter_date').val();
                if(filter_date != ''){
                    members_report(filter_date);
                } else {
                    toastr.warning('Please apply filters first!');
                }
            })
            $('#reset').click(function(){
                location.reload();
            });

            /*  =========================  Hours Spent Inside Gym  ========================== */

            function hoursSpentChart(time,dates) {
                var paymentReport = {
                    series: [{
                        data: time
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

                hoursChart = new ApexCharts(document.querySelector('#hours-spent-chart'), paymentReport);
                hoursChart.render();
            }
            function hoursSpent(filter_date = '',filter_name = ''){
                $.ajax({
                    type:'GET',
                    url: "{{ route('dashboard.member.hours.spent') }}",
                    data: {
                        filter_date: filter_date,
                        filter_name: filter_name,
                    },
                    success: function (response) {
                        time = [];
                        dates = [];
                        $.each(response, function(index, value) {
                            time.push(value['time'])
                            dates.push(value['date'])
                        });
                        if(hoursChart){hoursChart.destroy()}
                        if(response.length){hoursSpentChart(time,dates)}
                    },
                    error: function() {
                        // console.log(response);
                    }
                });
            };

            /*  =========================  Close Hours Spent Inside Gym  ========================== */

            $('#filter-hours').click(function () {
                var filter_date = $('#filter_date_hours').val();
                var filter_name = $('#filter_name').val();
                if(filter_name != '' && filter_date != ''){
                    // hoursSpent(filter_date,filter_name);
                } else {
                    toastr.warning('Please apply filters first!');
                }
            })
            $('#reset-hours').click(function(){
                location.reload();
            });
        });
    </script>
@endsection
