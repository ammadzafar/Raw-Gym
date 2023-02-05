     <div class="col-xl-4 col-md-6">
        <div class="card plan-box">
            <div class="card-body p-4">
                <div class="media">
                    <div class="media-body">
                        <h4>{{ $title }}</h4>
                    </div>
                    <div class="ml-3">
                        <i class="{{ $icon }}"></i>
                    </div>
                </div>
                <div class="py-4 mt-4 text-center bg-soft-light">
                    <h1 class="m-0"><sup><small>$</small></sup> {{ $price }}/ <span class="font-size-13">Per month</span></h1>
                </div>

                <div class="mt-2">
                    <p class="text-muted">{{ $desc }}</p>
                </div>

                <div class="text-center">
                    <a href="#" class="btn btn-dark waves-effect waves-light">Sign up Now</a>
                </div>

            </div>
        </div>
    </div>
