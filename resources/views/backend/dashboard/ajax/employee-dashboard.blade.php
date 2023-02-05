@section('script')

    <script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>

    <script>

        // $(document).ready(function () {
        //     $('.datatable').DataTable();
        // })
        $(document).ready(function () {
            $('.datatable').DataTable({
                "pageLength": 5,
                "order": [[0, 'desc']]
            });
        });


        $('body').on('click', '.markAttendanceBtn', function () {

            let self = $(this);
            let shiftName = self.data('shift-name');
            let shiftFrom = self.data('shift-from');
            let type = self.attr('data-type');

            $.ajax({
                url: '{{ route("dashboard.markAttendance")}}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    type: type,
                    shiftFrom: shiftFrom,
                },

                success: function (response) {

                    toastr.success(response.message)
                    if (type === 'clock-in') {
                        let btnHtml = '<b class="text-dark">' + shiftName + ': </b><span>Clock Out</span>';
                        self.html(btnHtml).removeClass('btn-warning').addClass('btn-danger').attr('data-type', 'clock-out')
                    } else {
                        let btnHtml = '<b class="text-dark">' + shiftName + ': </b><span>Clock In</span>';
                        self.html(btnHtml).removeClass('btn-danger').addClass('btn-warning').attr('data-type', 'clock-in')
                    }
                },

                error: function (error) {
                    toastrErrors(error);
                }
            })
        });
        // attendance mark
        $(document).on("click", '.toggle-status-attendance', function (e) {
            var clock_out = $(this).hasClass("clock-out");
            let disable_btn = $(this).closest('tr').find('td.clock_btn_dist');
            disable_btn.find('.example').removeAttr('disabled')
            var self = $(this);
            var id = $(this).data('id');

            var d = new Date();
            var localTime = d.getTime();
            var localOffset = d.getTimezoneOffset() * 60000;
            var utc = localTime + localOffset;
            var offset = 3;
            var Nairobi = utc + (3600000*offset);
            var nd = new Date(Nairobi);
            var hours = nd. getHours();
            var minutes = nd. getMinutes();
            var seconds = nd. getSeconds();

            $.ajax({
                url: '{{url("attendance/status/")}}' + '/' + clock_out + '/' + id ,
                type: 'get',
                success: function (response) {
                    toastr.success(response.message);
                    hours = hours < 10 ? '0'+hours : hours;
                    minutes = minutes < 10 ? '0'+minutes : minutes;
                    seconds = seconds < 10 ? '0'+seconds : seconds;
                    var time = hours + ":" + minutes + ":" + seconds;
                    self.text(time);
                    clock_out ? self.replaceWith($('<h6 style="color: red">' + time + '</h6>')) : self.replaceWith($('<h6 style="color: darkgreen">' + time + '</h6>'));

                    // location.reload();
                },
                error: function (error) {
                    toastrErrors(error);
                }
            });
        });



        // function calcTime(city, offset) {
        //     let d = new Date();
        //     let utc = d.getTime() + (d.getTimezoneOffset() * 60000);
        //     let nd = new Date(utc + (3600000*offset));
        //     return "The local time in" + city + "is" + nd.toLocaleString();
        //
        // }

    </script>
@endsection
