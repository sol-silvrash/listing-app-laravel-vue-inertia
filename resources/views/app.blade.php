<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite('resources/js/app.js')
        @inertiaHead
        @routes
    </head>

    <body class="bg-slate-100
                text-slate-900
                dark:bg-slate-700
                dark:text-white">
        @inertia
    </body>

</html>