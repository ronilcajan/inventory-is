@php
$system = DB::table('settings')
    ->get()
    ->first();
@endphp

<title>{{ !empty($system->system_name) ? $system->system_name : null }} - {{ config('app.name') }}</title>

<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta name="description" content="Portal - Bootstrap 5 Admin Dashboard Template For Developers">
<meta name="author" content="Xiaoying Riley at 3rd Wave Media">
<link rel="shortcut icon"
    href="{{ !empty($system->logo) ? asset('storage/' . $system->logo) : asset('images/app-logo.svg') }}">

<!-- FontAwesome JS-->
<script defer src="{{ asset('plugins/fontawesome/js/all.min.js') }}"></script>

<!-- App CSS -->
<link id="theme-style" rel="stylesheet" href="{{ asset('css/portal.css') }}">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

<link id="theme-style" rel="stylesheet" href="{{ asset('css/custom.css') }}">
<meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
