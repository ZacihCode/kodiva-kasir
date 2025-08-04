<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wisata Sendang Plesungan - Diskon</title>
</head>

<body>
    @extends('layouts.app')
    @section('content')
    <div class="ml-0 md:ml-64 lg:ml-72 min-h-screen bg-gray-50 p-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <livewire:diskon-manager />
            </div>
        </div>
    </div>
    @endsection
</body>

</html>