<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pinjolin</title>

    <!-- flowbite -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />

    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aoboshi+One&family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
     <link rel="stylesheet" href="/resources/css/styles.css">
</head>

<body class="font-sans antialiased bg-white">
    <div class="min-h-screen relative">
        <x-navigation />
        <!-- Page Content -->
        <main class="mx-auto min-h-screen">
            {{ $slot }}
        </main>
        <x-footer />
    </div>
</body>

</html>