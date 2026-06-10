<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin SILART</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F8F3EA]">
    <div class="min-h-screen">
        @include('admin.layouts.sidebar')

        <main class="h-screen overflow-y-auto lg:ml-64">
            <div class="p-6">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
