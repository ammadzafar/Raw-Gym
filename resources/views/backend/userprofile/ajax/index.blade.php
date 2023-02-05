@section('script')
    <script src="{{URL::asset('/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>

    <script>
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#update-user-profile').on('submit', function (e) {
            e.preventDefault();
            var self = $(this);
            loading(self, true);
            var formData = new FormData(this);
            $.ajax({

                url: "{{route('userprofile.update')}}",
                type: 'post',
                processData: false,
                contentType: false,
                data: formData,
                success: function (response) {
                    console.log(response.user.image);
                    $('.profile_image').attr('src', '{{ env('ASSET_URL') }}' + response.user.image);
                    toastr.success(response.message);
                    loading(self, false);

                },
                error: function (error) {
                    toastrErrors(error);
                    loading(self, false);

                }
            });

        });

        $('#update-user-password').on("submit", function (e) {
            e.preventDefault();
            var self = $(this);
            loading(self, true);
            var formData = new FormData(this);
            $.ajax({
                url: '{{route('userprofile.resetpassword')}}',
                type: 'post',
                processData: false,
                contentType: false,
                data: formData,
                success: function (response) {
                    toastr.success(response.message);
                    loading(self, false);
                },
                error: function (error) {
                    toastrErrors(error);
                    loading(self, false);

                }

            })
        });
        $(document).ready(function () {
            $('input[type="file"]').each(function () {

                var $file = $(this),
                    $label = $file.next('label'),
                    $labelText = $label.find('span'),
                    labelDefault = $labelText.text();

                $file.on('change', function (event) {
                    var fileName = $file.val().split('\\').pop(),
                        tmppath = URL.createObjectURL(event.target.files[0]);
                    if (fileName) {
                        $label
                            .addClass('file-ok')
                            .css({
                                'background-image': 'url(' + tmppath + ')',
                                'background-size': 'cover'
                            });
                        $labelText.text(fileName)
                        $labelText.css({
                            'position': 'absolute',
                            'bottom': '0',
                            'font-size': '12px'
                        });
                    } else {
                        $label.removeClass('file-ok');
                        $labelText.text(labelDefault);
                    }
                });
            });
        });
    </script>

@endsection
