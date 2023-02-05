@section('script')

    {{--    <script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>--}}
    <script src="{{ URL::asset('libs/apexcharts/apexcharts.min.js')}}"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <script>
        $(document).ready(function () {
            dates = [];
            amount = [];
            var chart = '';

            $('.daterange').daterangepicker();

            function paymentReportChart(amount, date) {
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
                        categories: date,
                    }
                };

                chart = new ApexCharts(document.querySelector('#bar-chart'), paymentReport);
                chart.render();
            }

            function payments_report(filter_name = '', filter_date = '') {
                $('.total-payments').text('');
                $.ajax({
                    type: 'GET',
                    url: "{{ route('dashboard.payments.report') }}",
                    data: {
                        filter_name: filter_name,
                        filter_date: filter_date,
                    },
                    success: function (response) {
                        console.log("response-record",response);
                        filter_name == 'membership_fees' ? $('.discount_hd').show() : $('.discount_hd').hide();
                        let sum = 0;
                        // $('.total-payments').text(Object.keys(response).length);


                        $('.payments_data').html('');
                        $.each(response, function (index, value) {
                            sum += parseInt(value['payment']);

                            if (dates != null && amount != null){
                                const lastDate = dates[dates.length - 1];
                                if (lastDate == value['date']){
                                    const lastAmount = amount[amount.length - 1];
                                    let totalAmount = parseInt(lastAmount) + parseInt(value['payment']);
                                    amount.pop();
                                    amount.push(totalAmount)
                                }else {
                                    dates.push(value['date']);
                                    amount.push(value['payment']);
                                }
                            }else {
                                dates.push(value['date']);
                                amount.push(value['payment']);
                            }

                            let record = ' <tr>\n' +
                                '          <td>' + value['date'] + '</td>\n' +
                                '          <td>' + value['name'] + '</td>\n' +
                                '          <td>' + value['collected_by'] + '</td>\n' +
                                '          <td>' + value['payment'] + '</td>\n';
                            if (value['discount']) {
                                record += '          <td>' + value['discount'] + '</td>\n';
                            }
                            record += '        </tr>';

                            $('.payments_data').append(record);
                            $('.total-payments').text(' ksh ' + sum);
                            // console.log(total_payment);
                        });
                        if (chart) {chart.destroy()}
                        if (response.length) {paymentReportChart(amount, dates)}
                    },
                    error: function () {
                        // console.log(response);
                    }
                });

                {{--var datatable = $('#attendance_data').DataTable({--}}
                {{--    processing : true,--}}
                {{--    serverSide : true,--}}
                {{--    ajax: {--}}
                {{--        url: "{{ route('dashboard.payments.report') }}",--}}
                {{--        data: {--}}
                {{--            filter_name: filter_name,--}}
                {{--            filter_date: filter_date,--}}
                {{--        }--}}
                {{--    },--}}
                {{--    "drawCallback": function( settings, start, end, max, total, pre ) {--}}
                {{--        // console.log('pakistan ahdas',this.fnSettings().json);--}}
                {{--        // alert(this.fnSettings().fnRecordsTotal());--}}

                {{--        $('#total-records').text(this.fnSettings().fnRecordsTotal());--}}
                {{--        $('#total-records').show();--}}
                {{--    },--}}
                {{--    columns: [--}}
                {{--        {--}}
                {{--            data:'date',--}}
                {{--            name:'date'--}}
                {{--        },--}}
                {{--        {--}}
                {{--            data:'name',--}}
                {{--            name:'name'--}}
                {{--        },--}}
                {{--        {--}}
                {{--            data:'collected_by',--}}
                {{--            name:'collected_by'--}}
                {{--        },--}}
                {{--        {--}}
                {{--            data:'payment',--}}
                {{--            name:'amount'--}}
                {{--        },--}}
                {{--    ]--}}
                {{--});--}}
            }

            $('#filter').click(function () {
                var filter_name = $('#payments_type').val();
                var filter_date = $('#filter_date').val();

                if (filter_name != '' && filter_date != '') {
                    amount.length = 0;
                    dates.length = 0;
                    payments_report(filter_name, filter_date);
                } else {
                    toastr.warning('Please apply filters first!');
                }
            })

            $('#reset').click(function () {
                location.reload();
            });
        });
    </script>
@endsection
