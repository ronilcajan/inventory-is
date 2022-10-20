@props(['designationCsv'])

@php
$designation = explode(',', $designationCsv);
@endphp

@foreach ($designation as $desig)
    <a class="badge bg-secondary text-white" href="/admin/personnel/?designation={{ $desig }}"> {{ $desig }}
    </a>
@endforeach
