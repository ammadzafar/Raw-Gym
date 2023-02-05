@section('script')

    <script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>
    <script src="{{ URL::asset('libs/apexcharts/apexcharts.min.js')}}"></script>
    {{--    <script src="{{ URL::asset('/libs/daterangepicker/jquery.daterangepicker.min.js')}}"></script>--}}
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    <script>
        $(document).ready(function () {
            presents = [];
            dates = [];
            var chart = '';

            let name = 'nothing';
            let membership = 'nothing';
            let date = 'nothing';
            // attendanceReport(name, membership, date);

            $('.daterange').daterangepicker();

            function paymentReportChart(presents, dates) {
                var paymentReport = {
                    series: [{
                        data: presents,
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
                chart = new ApexCharts(document.querySelector('#payment-chart'), paymentReport);
                chart.render();
            }

            var search_route = "{{ route('dashboard.autocomplete-search') }}";
            $('#filter_name').typeahead({
                source: function (query, process) {
                    return $.get(search_route, {
                        query: query
                    }, function (data) {
                        return process(data);
                    });
                }
            });

            // fill_datatable();

            function fill_datatable(filter_name = '', filter_membership = '', filter_date = '') {

                var datatable = $('#attendance_data').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('dashboard.report') }}",
                        data: {
                            filter_name: filter_name,
                            filter_membership: filter_membership,
                            filter_date: filter_date,
                        }
                    },
                    // success: function (response) {
                    //     console.log("my-response-is",response);
                    // },
                    columns: [
                        {
                            data: 'date',
                            name: 'date'
                        },
                        {
                            data: 'name',
                            name: 'name'
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

            $('#filter').click(function () {
                var filter_name = $('#filter_name').val();
                var filter_membership = $('#filter_membership').val();
                var filter_date = $('#filter_date').val();
                if (chart) {chart.destroy()}
                if (filter_name == '' || filter_date == '') {
                    toastr.warning('Please select all filters')
                }
                // if (filter_name != '' && filter_date != '') {
                //     $('#attendance_percenatge').html('');
                //     attendanceReport(filter_name, filter_membership, filter_date);
                // }
                // if (filter_name != '' && filter_date != '') {
                //     $('#attendance_data').DataTable().destroy();
                //     fill_datatable(filter_name, filter_membership, filter_date);
                // }
                else {
                    $('#attendance_percenatge').html('');
                    attendanceReport(filter_name, filter_membership, filter_date);
                    $('#attendance_data').DataTable().destroy();
                    fill_datatable(filter_name, filter_membership, filter_date);
                }
            })

            $('#reset').click(function () {
                location.reload();
                // attendanceReport(name, membership, date);
                // $('#filter_name').val('');
                // $('#filter_membership').val('');
                // $('#filter_date').val('');
                // $('#attendance_data').DataTable().destroy();
                // fill_datatable();
            });

            function attendanceReport(filter_name, filter_membership, filter_date) {
                $.ajax({
                    type: 'GET',
                    url: '{{route('dashboard.report.attendance.percentage')}}',
                    data: {
                        filter_name: filter_name,
                        filter_date: filter_date,
                        filter_membership: filter_membership ? filter_membership : null,
                    },
                    success: function (response) {
                        $('#attendance_percenatge').html('');
                        $('#attendance_percenatge').append('<tr>\n' +
                            '           <th>Name</th>\n' +
                            '           <th>Present</th>\n' +
                            '           <th>Absent</th>\n' +
                            '           </tr>');
                        $.each(response, function (index, value) {
                            if (value['name']) {
                                let record = ' <tr>\n' +
                                    '          <td>' + value['name'] + '</td>\n' +
                                    '          <td>' + value['present'] + '</td>\n' +
                                    '          <td>' + value['absent'] + '</td>\n' +
                                    '        </tr>';
                                $('#attendance_percenatge').append(record);
                            }
                        });
                        presents = [];
                        dates = [];
                        $.each(response['record'], function (index, value) {
                            // console.log("values",value);
                            if (typeof value['presents'] == "string") {
                                presents.push(1);
                            } else {
                                presents.push(value['presents']);
                            }
                            dates.push(value['date'])

                        });
                        if (chart) {
                            chart.destroy()
                        }
                        if (response['record']) {
                            paymentReportChart(presents, dates)
                        }
                    },
                    error: function () {
                        // console.log(response);
                    }
                });
            }

        });
    </script>
@endsection
