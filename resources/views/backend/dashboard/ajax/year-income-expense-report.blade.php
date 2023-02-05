@section('script')

    @include('backend.dashboard.ajax.modals.show-day-income-report-modal')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script>

        $('.monthInExReportBtn').on('click', function (e) {
            e.preventDefault();
            let href = $(this).attr('href')

            $.ajax({
                url: href,
                type: 'get',

                success: function (res) {

                    let dateMonth = new Date(res.month).toISOString().split('T')[0];
                    let days = res.allDays;

                    let daysCards = '';

                    if (days.length) {
                        $.each(days, function (key, value) {
                            let newDate = moment(value.date).format('YYYY-MM-DD');
                            let link = '{{ env('APP_URL') }}' + '/dashboard/report/income-expense/day/' + newDate;
                            daysCards +=
                                '<div class="col-md-2">' +
                                '<div class="card card-dark-shadow">' +
                                '<div class="card-body">' +
                                '<div class="d-flex justify-content-between">' +
                                '<h3 class="card-title mb-4">' + newDate + '</h3>' +
                                '<a href="' + link + '" class="text-primary" target="_blank"><i class="fas fa-external-link-alt"></i></a>' +
                                '</div>' +
                                '<div>' +
                                '<a href="' + link + '" data-toggle="modal" data-target="#showDayIncomeReportModal" class="card-hover-pointer todayInExReportBtn">' +
                                '<div class="pb-1 text-secondary mt-2">' +
                                '<div class="row align-items-center">' +
                                '<div class="col-12">' +
                                '<table class="w-100">' +
                                '<tbody>' +
                                '<tr>' +
                                '<th>Income</th>' +
                                '<td>' + value.income + '</td>' +
                                '</tr>' +
                                '<tr class="border-bottom">' +
                                '<th>Expense</th>' +
                                '<td>' + value.expense + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<th>Profit</th>' +
                                '<td>' + value.profit + '</td>' +
                                '</tr>' +
                                '</tbody>' +
                                '</table>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</a>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>'
                        })
                    } else {
                        daysCards =
                            '<div class="col-md-12">' +
                            '<div class="card card-dark-shadow">' +
                            '<div class="card-body">' +
                            '<div class="d-flex justify-content-between">' +
                            '<h3 class="card-title mb-4">No data found!</h3>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    }

                    $('#daysCards').empty().append(daysCards)
                    $('#month_date').html(dateMonth)
                },

                error: function (err) {
                    toastrErrors(err);
                }
            })
        })
    </script>
@endsection
