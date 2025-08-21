<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wisata Sendang Plesungan - Broadcast</title>
</head>

<body>
    @extends('layouts.app')
    @section('content')
    <div class="min-h-screen ml-6 mr-2 p-6">
        <div class="grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <livewire:broadcast-manager />
        </div>
    </div>
    @endsection
</body>

</html>