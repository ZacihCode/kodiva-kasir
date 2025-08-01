<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Karyawan - Sistem Kasir Tiket</title>
</head>

<body>
    @extends('layouts.app')
    @section('content')
    <div class="ml-0 md:ml-64 lg:ml-72 min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Attendance List -->
            <livewire:absensi-manager />
        </div>
    </div>
    @endsection
</body>

</html>