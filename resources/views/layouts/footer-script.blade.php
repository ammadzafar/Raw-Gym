        <!-- JAVASCRIPT -->
        <script src="{{ URL::asset('libs/jquery/jquery.min.js')}}"></script>
        <script src="{{ URL::asset('libs/bootstrap/bootstrap.min.js')}}"></script>
        <script src="{{ URL::asset('libs/metismenu/metismenu.min.js')}}"></script>
        <script src="{{ URL::asset('libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{ URL::asset('libs/node-waves/node-waves.min.js')}}"></script>
        <script src="{{URL::asset('libs/toastr/vendor/toastr.min.js')}}"></script>
        <script src="{{URL::asset('libs/toastr/plugin/toastr.js')}}"></script>
        <script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>

        {{-- Dopzone --}}
{{--        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js" integrity="sha512-VQQXLthlZQO00P+uEu4mJ4G4OAgqTtKG1hri56kQY1DtdLeIqhKUp9W/lllDDu3uN3SnUNawpW7lBda8+dSi7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>--}}
        @yield('script-bottom')
        <!-- App js -->
        <script src="{{ URL::asset('js/app.min.js')}}"></script>
        <script src="{{ URL::asset('js/custom.js')}}"></script>
        <script src="{{URL::asset('/libs/parsleyjs/parsleyjs.min.js')}}"></script>
        <!-- validation init -->
        <script src="{{URL::asset('/js/pages/form-validation.init.js')}}"></script>

        <script src="https://unpkg.com/boxicons@2.0.9/dist/boxicons.js"></script>
        <script src="{{ URL::asset('/js/spin.min.js')}}"></script>
        <script src="{{ URL::asset('/js/ladda.min.js')}}"></script>

        @yield('script')
