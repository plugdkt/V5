<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>คลังสื่ออัปโหลด (Media Picker)</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-white p-4 text-xs font-light text-navy antialiased">
    
    @livewire('admin.media-manager', ['pickerMode' => true])

    @livewireScripts
</body>
</html>
