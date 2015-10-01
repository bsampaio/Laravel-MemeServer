<?php
/**
 * Created by PhpStorm.
 * User: criativa
 * Date: 01/10/15
 * Time: 14:00
 */
?>

<!DOCTYPE html>
<html>
    <head>
        <title>@yield('page-title')</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/bootstrap-wizard.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/chosen.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/image-picker.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/plugin.css') }}" rel="stylesheet" />

        @section('custom-styles')
            <style>
                .wizard-modal p {
                    margin: 0 0 10px;
                    padding: 0;
                }

                #wizard-ns-detail-servers, .wizard-additional-servers {
                    font-size: 12px;
                    margin-top: 10px;
                    margin-left: 15px;
                }
                #wizard-ns-detail-servers > li, .wizard-additional-servers li {
                    line-height: 20px;
                    list-style-type: none;
                }
                #wizard-ns-detail-servers > li > img {
                    padding-right: 5px;
                }

                .wizard-modal .chzn-container .chzn-results {
                    max-height: 150px;
                }
                .wizard-addl-subsection {
                    margin-bottom: 40px;
                }
                .create-server-agent-key {
                    margin-left: 15px;
                    width: 90%;
                }
            </style>
        @show
    </head>
    <body>
        @yield('content')

        <script src="{{asset('js/jquery-2.0.3.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('js/chosen.jquery.js')}}"></script>
        <script src="{{asset('js/bootstrap.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('js/prettify.js')}}" type="text/javascript"></script>
        <script src="{{asset('js/bootstrap-wizard.js')}}" type="text/javascript"></script>
        <script src="{{asset('js/plugin.js')}}" type="text/javascript"></script>
        <script>
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        @yield('custom-scripts')

    </body>
</html>

