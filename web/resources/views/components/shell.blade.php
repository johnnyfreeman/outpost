<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full font-mono text-black">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>command-post</title>

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Source+Code+Pro&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jetbrains-mono@1.0.6/css/jetbrains-mono.min.css">
    <link rel="stylesheet" href="https://kit.fontawesome.com/49a7a85d82.css" crossorigin="anonymous">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full">
    {{ $slot }}

    <x-notifications />
</body>

</html>
