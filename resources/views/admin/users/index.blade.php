@extends('layouts.admin') {{-- Pastikan nama layout admin Anda benar --}}

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-gray-700 text-3xl font-medium">Manajemen User</h3>
    </div>

    <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="w-full h-16 border-gray-300 border-b py-8">
                    <th class="text-left pl-8 font-semibold text-sm text-gray-600 uppercase">Nama</th>
                    <th class="text-left font-semibold text-sm text-gray-600 uppercase">Email</th>
                    <th class="text-left font-semibold text-sm text-gray-600 uppercase">Role</th>
                    <th class="text-left font-semibold text-sm text-gray-600 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="h-16 border-gray-300 border-b">
                    <td class="pl-8 text-sm text-gray-800">{{ $user->name }}</td>
                    <td class="text-sm text-gray-800">{{ $user->email }}</td>
                    <td class="text-sm">
                        <span class="px-2 py-1 font-semibold leading-tight {{ $user->role === 'admin' ? 'text-red-700 bg-red-100' : 'text-green-700 bg-green-100' }} rounded-full">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="text-sm">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Hapus user ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-5 py-5 bg-white border-t">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection