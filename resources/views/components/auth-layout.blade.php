<!DOCTYPE html>
<html lang="en">

<head>

    @include('partials._head')

</head>

<body class="app app-login p-0">

    {{ $slot }}
    <script src="{{ asset('plugins/jquery.min.js') }}"></script>
    <script>
        // show password when toggle
        $(".toggle-password").click(function() {
            alert(2);
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));

            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }

        });
    </script>
</body>

</html>
