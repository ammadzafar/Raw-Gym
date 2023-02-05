@section('script')

    {{--    <script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>--}}
    <script src="{{ URL::asset('libs/apexcharts/apexcharts.min.js')}}"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <script>
        $(document).ready(function () {
            members = [];
            labels = [];
            var chart = '';
            $('.daterange').daterangepicker();

            function membershipReportChart(members,labels) {
                var options = {
                    series: members,
                    chart: {
                        width: 380,
                        type: 'pie',
                    },
                    labels: labels,
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

                chart = new ApexCharts(document.querySelector("#membership-types-chart"), options);
                chart.render();
            }

            function membershipTypeReport(filter_date = ''){
                $.ajax({
                    type:'GET',
                    url: "{{ route('dashboard.membership.type.report') }}",
                    data: {
                        filter_date: filter_date,
                    },
                    success: function (response) {
                        members = [];
                        labels = [];
                        $.each(response, function(index, value) {
                            members.push(value['total_members']);
                            labels.push(value['name']);
                        });
                        if(chart){chart.destroy()}
                        if(members.length){membershipReportChart(members,labels)}
                    },
                    error: function() {
                        // console.log(response);
                    }
                });
            }

            $('#filter').click(function () {
                var filter_date = $('#filter_date').val();
                if(filter_date != ''){
                    membershipTypeReport(filter_date);
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
