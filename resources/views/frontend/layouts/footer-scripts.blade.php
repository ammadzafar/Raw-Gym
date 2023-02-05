<script src="{{ asset('frontend/assets/js/jquery.js') }}"></script>
<script src="{{ asset('frontend/assets/js/popper.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/jquery.fancybox.js') }}"></script>
<script src="{{ asset('frontend/assets/js/appear.js') }}"></script>
<script src="{{ asset('frontend/assets/js/owl.js') }}"></script>
<script src="{{ asset('frontend/assets/js/wow.js') }}"></script>
<script src="{{ asset('frontend/assets/js/validate.js') }}"></script>
<script src="{{ asset('frontend/assets/js/jquery.bootstrap-touchspin.js') }}"></script>
<script src="{{ asset('frontend/assets/js/jquery-ui.js') }}"></script>
<script src="{{ asset('frontend/assets/js/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
    function toastrErrors(error) {
        if (!error.responseJSON.errors) {
            toastr.error(error.responseJSON.message);
        } else if (error.responseJSON.errors) {
            $.each(error.responseJSON.errors, function (key, value) {
                toastr.error(value);
            });
        }
    }
</script>

<script src="{{URL::asset('libs/toastr/vendor/toastr.min.js')}}"></script>
<script src="{{URL::asset('libs/toastr/plugin/toastr.js')}}"></script>

@yield('frontend-scripts')
