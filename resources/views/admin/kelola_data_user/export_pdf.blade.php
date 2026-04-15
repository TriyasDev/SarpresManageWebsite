<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Data User</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; }
        h1 { font-size: 18px; text-align: center; margin-bottom: 5px; }
        .date { text-align: center; font-size: 11px; color: #555; margin-bottom: 20px; }
        .filter-info { background: #f3f4f6; padding: 8px; margin-bottom: 15px; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #2563eb; color: white; font-weight: bold; font-size: 11px; }
        .footer { margin-top: 20px; text-align: center; font-size: 10px; color: #777; }
    </style>
</head>
<body>
    <h1>Laporan Data User</h1>
    <div class="date">Dicetak: {{ now()->format('d/m/Y H:i') }}</div>

    @php
        $hasFilter = !empty($filters['search']) || !empty($filters['role']);
    @endphp
    @if($hasFilter)
    <div class="filter-info">
        <strong>Filter yang diterapkan:</strong><br>
        @if(!empty($filters['search'])) • Pencarian: "{{ $filters['search'] }}"<br> @endif
        @if(!empty($filters['role'])) • Role: {{ ucfirst($filters['role']) }}<br> @endif
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>NIPD</th>
                <th>Kelas</th>
                <th>No Telpon</th>
                <th>Points</th>
                <th>Tier</th>
                <th>Status Banned</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->role) }}</td>
                <td>{{ $user->nipd ?? '-' }}</td>
                <td>{{ $user->kelas ?? '-' }}</td>
                <td>{{ $user->no_telpon ?? '-' }}</td>
                <td>{{ $user->points }}</td>
                <td>{{ $user->tier ?? '-' }}</td>
                <td>{{ $user->is_banned ? 'Ya' : 'Tidak' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" style="text-align: center;">Tidak ada data user</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="footer">Total {{ $users->count() }} user | Sistem Informasi Aset</div>
</body>
</html>
