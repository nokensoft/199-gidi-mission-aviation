@extends('layouts.admin')
@section('title', 'Pengguna')
@section('page-title', 'Manajemen Pengguna')
@section('content')
<div class="grid lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm">
        <h3 class="font-bold text-slate-900 mb-4">Tambah Pengguna</h3>
        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-3">
            @csrf
            <input type="text" name="name" required placeholder="Nama lengkap" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm">
            <input type="email" name="email" required placeholder="Email" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm">
            <input type="password" name="password" required placeholder="Password" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm">
            <input type="password" name="password_confirmation" required placeholder="Konfirmasi password" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm">
            <select name="role" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm">
                <option value="guest">Guest (Lihat Saja)</option>
                <option value="admin">Admin (Akses Penuh)</option>
            </select>
            @if($errors->any())<div class="text-red-500 text-xs">{{ $errors->first() }}</div>@endif
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl font-medium transition">Tambah</button>
        </form>
    </div>
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200"><tr>
                    <th class="text-left px-6 py-3 font-semibold text-slate-600">Nama</th>
                    <th class="text-left px-6 py-3 font-semibold text-slate-600">Email</th>
                    <th class="text-left px-6 py-3 font-semibold text-slate-600">Role</th>
                    <th class="text-right px-6 py-3 font-semibold text-slate-600">Aksi</th>
                </tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($users as $u)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 font-medium text-slate-900">{{ $u->name }}</td>
                        <td class="px-6 py-4 text-slate-500">{{ $u->email }}</td>
                        <td class="px-6 py-4">
                            <form method="POST" action="{{ route('admin.users.update-role', $u) }}" class="inline" x-data>
                                @csrf @method('PUT')
                                <select name="role" @change="$el.closest('form').submit()" class="text-xs px-2 py-1 rounded-lg border border-slate-200 {{ $u->role === 'admin' ? 'bg-blue-50 text-blue-600' : 'bg-slate-50 text-slate-600' }}">
                                    <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="guest" {{ $u->role === 'guest' ? 'selected' : '' }}>Guest</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($u->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $u) }}" class="inline" onsubmit="event.preventDefault(); confirmDelete(this, 'Hapus Pengguna', 'Apakah Anda yakin ingin menghapus pengguna &quot;{{ addslashes($u->name) }}&quot;?')">@csrf @method('DELETE')<button class="text-red-400 hover:text-red-600 cursor-pointer"><i class="fa-solid fa-trash"></i></button></form>
                            @else
                            <span class="text-xs text-slate-400">(Anda)</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-6 py-3 border-t border-slate-100">{{ $users->links() }}</div>
        </div>
    </div>
</div>
@endsection
