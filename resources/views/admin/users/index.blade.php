@extends('layouts.admin', ['heading' => 'Users & Role'])

@section('content')
<div class="admin-panel p-4">
    <form class="d-flex gap-2 mb-3" method="GET">
        <input class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari user">
        <button class="btn btn-success">Cari</button>
    </form>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>Nama</th><th>Email</th><th>Role</th><th></th></tr></thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td class="text-end">
                        <form class="d-flex gap-2 justify-content-end" method="POST" action="{{ route('admin.users.role.update', $user) }}">
                            @csrf @method('PATCH')
                            <select class="form-select form-select-sm" name="role" style="width: 160px;">
                                @foreach(['user', 'staff', 'super-admin'] as $role)
                                    <option value="{{ $role }}" @selected($user->role === $role)>{{ $role }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-sm btn-outline-success">Update</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $users->links() }}
</div>
@endsection
