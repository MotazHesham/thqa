<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- Page Title -->
    <title>{{ trans('panel.site_title') }}</title>

    <!-- Meta Data -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" />

    <!-- Web Fonts -->
    <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&display=swap" rel="stylesheet" />

    <!-- ======= BEGIN GLOBAL MANDATORY STYLES ======= -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/icofont/icofont.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.css') }}" />
    <!-- ======= END BEGIN GLOBAL MANDATORY STYLES ======= -->

    <!-- ======= BEGIN PAGE LEVEL PLUGINS STYLES ======= -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/apex/apexcharts.css') }}" />
    <!-- ======= END BEGIN PAGE LEVEL PLUGINS STYLES ======= -->

    <!-- ======= MAIN STYLES ======= -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <!-- ======= END MAIN STYLES ======= -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"
        rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <style>
        .bootstrap-datetimepicker-widget {
            z-index: 99999;
            width: 25em !important;
        }

        .select2-container--default .select2-selection--single {
            background-color: #f0f0f0;
            border: none;
        }

        .custom-select {
            height: 44px;
            padding: 7px 0 !important;
        }

        .select2-container--default .select2-selection--multiple {
            background: #f0f0f0 !important
        }
        .mysearch-header-nav .select2-container{
            width: 260px !important;
        }
    </style>
    @yield('styles')
</head>

<body>
    <!-- Offcanval Overlay -->
    <div class="offcanvas-overlay"></div>
    <!-- Offcanval Overlay -->

    <!-- Wrapper -->
    <div class="wrapper">
        <!-- Header -->
        <header class="header white-bg fixed-top d-flex align-content-center flex-wrap">
            <!-- Logo -->
            <div class="logo">
                <a href="#" class="default-logo"><img src="{{ asset('assets/img/logo.png') }}"
                        alt="" /></a>
                <a href="#" class="mobile-logo"><img src="{{ asset('assets/img/mobile-logo.png') }}"
                        alt="" /></a>
            </div>
            <!-- End Logo -->

            <!-- Main Header -->
            @include('partials.menu_header')
            <!-- End Main Header -->
        </header>
        <!-- End Header -->

        <!-- Main Wrapper -->
        <div class="main-wrapper">
            <!-- Sidebar -->
            @include('partials.menu_sidebar')
            <!-- End Sidebar -->

            <!-- Main Content -->
            @yield('content')
            <!-- End Main Content -->
        </div>

        <!-- End Main Wrapper -->

        <!-- Footer -->
        <footer class="footer">
            جميع الحقوق محفوظة ثقة © 2024 تصميم وبرمجة
            <a href="https://alliance-sa.com/">
                &nbsp; تكامل الرؤى &nbsp;
            </a>
        </footer>
        <!-- End Footer -->
    </div>
    <!-- End wrapper -->

    <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>

    <!-- ======= BEGIN GLOBAL MANDATORY SCRIPTS ======= -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <!-- ======= BEGIN GLOBAL MANDATORY SCRIPTS ======= -->

    <!-- ======= BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS ======= -->
    {{-- <script src="{{ asset('assets/plugins/apex/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/apex/custom-apexcharts.js') }}"></script> --}}
    <!-- ======= End BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS ======= -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>

    <script src="{{ asset('js/main.js') }}"></script>
    @yield('scripts')
    <script>
        $(document).ready(function() {
            $(".main-header-notification").on('click', function() {
                $.get('/admin/user-alerts/read');
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.searchable-field').select2({
                minimumInputLength: 3,
                ajax: {
                    url: '{{ route('admin.globalSearch') }}',
                    dataType: 'json',
                    type: 'GET',
                    delay: 200,
                    data: function(term) {
                        return {
                            search: term
                        };
                    },
                    results: function(data) {
                        return {
                            data
                        };
                    }
                },
                escapeMarkup: function(markup) {
                    return markup;
                },
                templateResult: formatItem,
                templateSelection: formatItemSelection,
                placeholder: '{{ trans('global.search') }}...',
                language: {
                    inputTooShort: function(args) {
                        var remainingChars = args.minimum - args.input.length;
                        var translation = '{{ trans('global.search_input_too_short') }}';

                        return translation.replace(':count', remainingChars);
                    },
                    errorLoading: function() {
                        return '{{ trans('global.results_could_not_be_loaded') }}';
                    },
                    searching: function() {
                        return '{{ trans('global.searching') }}';
                    },
                    noResults: function() {
                        return '{{ trans('global.no_results') }}';
                    },
                }

            });

            function formatItem(item) {
                if (item.loading) {
                    return '{{ trans('global.searching') }}...';
                }
                var markup = "<div class='searchable-link' href='" + item.url + "'>";
                markup += "<div class='searchable-title'>" + item.model + "</div>";
                $.each(item.fields, function(key, field) {
                    markup += "<div class='searchable-fields'>" + item.fields_formated[field] + " : " +
                        item[field] + "</div>";
                });
                markup += "</div>";

                return markup;
            }

            function formatItemSelection(item) {
                if (!item.model) {
                    return '{{ trans('global.search') }}...';
                }
                return item.model;
            }
            $(document).delegate('.searchable-link', 'click', function() {
                var url = $(this).attr('href');
                window.location = url;
            });
        });
    </script>
</body>

</html>
