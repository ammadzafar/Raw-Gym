@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>
    <script src="{{ URL::asset('/libs/apexcharts/apexcharts.min.js')}}"></script>
    <script type="text/javascript"
            src="https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    {{--    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>--}}
    <script src="{{URL::asset('/libs/magnific-popup/magnific-popup.min.js')}}"></script>
    {{--    <script src="{{URL::asset('/libs/select2/select2.min.js')}}"></script>--}}
    {{--    <script src="{{ URL::asset('/js/pages/profile.init.js')}}"></script>--}}
    {{--    <script src="{{ URL::asset('js/pages/dashboard.init.js')}}"></script>--}}

    <script>
        // $('.select2-multiple').select2();
        // $('.select2-container').addClass('d-block');
        $(document).ready(function () {
            dates = [];
            amount = [];
            var chart = '';

            function paymentReportChart(amount, dates) {
                var paymentReport = {
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

                chart = new ApexCharts(document.querySelector('#financial-report-chart'), paymentReport);
                chart.render();
            }

            function payments_report(filter_name = '', filter_date = '') {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('financialReport') }}",
                    data: {
                        filter_name: filter_name,
                        filter_date: filter_date,
                        member_id: $('#filter_date').data('id'),
                    },
                    success: function (response) {
                        dates = [];
                        amount = [];
                        $.each(response, function (index, value) {
                            var date = new Date(value['date']).toLocaleDateString();
                            date = date.split("/");
                            date = date[2] + "-" + (date[0].length == 1 ? "0" + date[0] : date[0]) + "-" + (date[1].length == 1 ? "0" + date[1] : date[1]);
                            dates.push(date);
                            amount.push(value['amount']);
                        });
                        if (chart) {
                            chart.destroy()
                        }
                        if (response.length) {
                            paymentReportChart(amount, dates)
                        }
                    },
                    error: function () {
                        // console.log(response);
                    }
                });
            }

            $('#filter').click(function () {
                var filter_name = $('#payments_type').val();
                var filter_date = $('#filter_date').val();

                if (filter_name != '' && filter_date != '') {
                    payments_report(filter_name, filter_date);
                } else {
                    toastr.warning('Please apply filters first!');
                }
            })
            $('#reset').click(function () {
                location.reload();
            });
        })

        $('.member-profile-image').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            mainClass: 'mfp-img-mobile',
            image: {
                verticalFit: true
            }
        });

        $(document).ready(function () {

            $('.daterange').daterangepicker();

            // $('.datatable').DataTable({
            //     "pageLength": 5,
            //     "order": [[0, 'desc']]
            // });
            //
            // $('.attendance_datatable').DataTable({
            //     "pageLength": 5,
            //     // "bPaginate": false,
            //     "bLengthChange": false,
            //     "bFilter": false,
            //     // "bInfo": false,
            //     // "bAutoWidth": false,
            //     "order": [[0, 'desc']]
            // });

            var attendanceDonat = JSON.parse('{{ $attendanceDonat }}');
            attendanceDonatChart(attendanceDonat);
        });

        {{--$(document).on("click", '.toggle-status-attendance', function (e) {--}}
        {{--    e.preventDefault();--}}
        {{--    var id = $(this).data('id');--}}
        {{--    $.ajax({--}}
        {{--        url: '{{url("attendance/status/")}}' + '/' + id,--}}
        {{--        type: 'get',--}}
        {{--        success: function (response) {--}}
        {{--            toastr.success(response.message);--}}
        {{--            refreshDiv('.attendance_datatable');--}}
        {{--            attendanceDonatChart(response.attendanceDonat);--}}
        {{--        },--}}
        {{--        error: function (error) {--}}
        {{--            toastrErrors(error);--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}


        /*  =========================  Hours Spent Inside Gym Chart ========================== */
        let presents = 0;
        let absents = 0;
        totalAttend = [];
        var pie_chart = '';
        var hoursChart = '';
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
        function hoursSpent(filter_date = '',member_id = ''){
            $.ajax({
                type:'GET',
                url: "{{ route('dashboard.member.hours.spent') }}",
                data: {
                    filter_date: filter_date,
                    filter_member_id: member_id,
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

        /*  =========================  Attendance Pie Chart Visuals ========================== */
        function attedancePieChart(value){
            var options = {
                series: value,
                chart: {
                    type: 'donut',
                },
                labels: ["Absent","Present"],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        },
                    }
                }]
            };

            pie_chart = new ApexCharts(document.querySelector("#attendancePie"), options);
            pie_chart.render();
        }

        /*  =========================  Attendance Datatable ========================== */
        function statusDatatable(member_id = '', filter_date = '') {
            var datatable = $('#attendance_table').DataTable({
                destroy: true,
                ajax: {
                    url: "{{ route('attendanceRecord') }}",
                    data: {
                        filter_member_id: member_id,
                        filter_date: filter_date,
                    },
                    "dataSrc": function ( json ) {
                        totalAttend = [];
                        absents = 0;
                        presents = 0;
                        $.each(json.data, function (index, value) {
                            value['status'] == 'absent' ? absents++ : presents++
                        });
                        totalAttend.push(absents,presents);
                        if (pie_chart) {pie_chart.destroy()}
                        if (json.data) {attedancePieChart(totalAttend)}
                        console.log("values are:",totalAttend)
                        return json.data;
                    },
                },
                columns: [
                    {
                        data: 'date',
                        name: 'date',
                        "render": function (data, type, full, meta) {
                            var date = new Date(data).toLocaleDateString();
                            date = date.split("/");
                            date = date[2] + "-" + (date[0].length == 1 ? "0" + date[0] : date[0]) + "-" + (date[1].length == 1 ? "0" + date[1] : date[1]);
                            return date;
                        }
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'clock_in',
                        name: 'clock_in'
                    },
                    {
                        data: 'clock_out',
                        name: 'clock_out'
                    }
                ]
            });
        }

        $('#filter_attendce').click(function () {
            var member_id = $('#filter_attend').data('id');
            var filter_date = $('#filter_attend').val();
            $('#attendance_table').css("w-100");

            if (filter_date != '') {
                statusDatatable(member_id, filter_date);
                hoursSpent(filter_date,member_id);
            } else {
                toastr.warning('Please apply filters first!');
            }
        })

        function attendanceDonatChart(value) {
            var options = {
                series: value,
                chart: {
                    height: 230,
                    type: 'donut'
                },
                labels: ["Present", "Absent"],
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
                colors: ['#0cc364', '#eeb902']
            };
            var chart = new ApexCharts(document.querySelector("#attendanceDonat"), options);
            chart.render();
        }



        $('#submit-verify-user-form').on('submit', function (e) {
            e.preventDefault()
            let self = $(this);
            $.ajax({
                url: '{{ route("user.verify") }}',
                type: 'post',
                data: $(this).serialize(),
                success: function (response) {
                    $('.show_member_fees').text(response.fees);
                    self[0].reset();
                    $('#verify-user-modal').modal('hide');
                    $('.fees-show-hide-btn').empty();
                    $('.fees-show-hide-btn').append('<a href="#" class="hide-btn">(hide)</a>');
                },
                error: function (error) {
                    toastrErrors(error);
                }
            });
        })

        $('body').on('click', '.hide-btn', function (e) {
            e.preventDefault()
            $('.fees-show-hide-btn').empty();
            $('.fees-show-hide-btn').append('<a href="#" class="show_fees_btn" data-toggle="modal" data-target="#verify-user-modal">(show)</a>');
            $('.show_member_fees').text('* * * * *');
        })

    </script>
@endsection
