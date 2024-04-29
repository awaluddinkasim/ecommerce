<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
    @include('includes.styles')
    @stack('styles')
</head>

<body>

    <div class="tap-top"><i data-feather="chevrons-up"></i></div>

    <div class="page-wrapper horizontal-wrapper" id="pageWrapper">

        @include('includes.user.header')

        <div class="page-body-wrapper">
            <div class="page-body" style="margin-top: 80px">

                <div class="container pt-4">
                    @yield('content')
                </div>
            </div>


            <!-- footer start-->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 footer-copyright text-center">
                            <p class="mb-0">Copyright © 2024</p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    @stack('modals')


    @include('includes.scripts')
    @stack('scripts')

</body>

</html>
