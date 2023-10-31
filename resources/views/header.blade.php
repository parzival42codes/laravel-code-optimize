<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- CSRF Token -->
    <meta name="csrf-token"
          content="{{ csrf_token() }}">
    <meta name="robots" content="noindex" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

    <style>
        .card {
            margin: 1em 0;
        }

        .card .card-body{
            padding: 0.4em;
        }

        table {
            width: 100%;
            border: 1px black solid;
            margin: 0.5em;
            font-size: small;
        }

        table th {
            padding: 5px;
        }

        table td {
            padding: 5px;
        }

    </style>

    @include('code-optimize::headerCssUnittest')
    @include('code-optimize::headerCssPhpStan')
    @include('code-optimize::headerCssPhpInsights')
    @include('code-optimize::headerCssCodeVersion')

</head>

<body>
