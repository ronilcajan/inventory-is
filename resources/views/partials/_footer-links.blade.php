<!-- Javascript -->
<script>
    var SITE_URL = "{{ URL::to('/') }}";
</script>
<script src="{{ asset('plugins/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/popper.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script src="//unpkg.com/alpinejs" defer></script>
<!-- Charts JS -->
<script src="{{ asset('plugins/chart.js/chart.min.js') }}"></script>


<!-- Page Specific JS -->
@if (Request::segment(2) != 'pos')
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/index-charts.js') }}"></script>
@endif


<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{ asset('js/pos.js') }}"></script>
<script src="{{ asset('js/report.js') }}"></script>
