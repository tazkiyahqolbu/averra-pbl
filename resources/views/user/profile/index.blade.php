@extends('user.layouts.app')

@section('content')
<div class="rounded-3xl bg-white border border-border p-8 shadow-soft max-w-xl">
    <h2 class="text-2xl font-semibold text-gray-900">Profil Saya</h2>
    <dl class="mt-6 space-y-4 text-sm">
        <div class="flex justify-between border-b pb-2">
            <dt class="text-gray-500">Email</dt>
            <dd class="text-gray-900 font-semibold">{{ $user->email ?? '-' }}</dd>
        </div>

        @if(!empty($user?->no_hp))
        <div class="flex justify-between border-b pb-2">
            <dt class="text-gray-500">Telepon</dt>
            <dd class="text-gray-900 font-semibold">{{ $user->no_hp }}</dd>
        </div>
        @endif

        <div class="flex justify-between border-b pb-2">
            <dt class="text-gray-500">Peran</dt>
            <dd class="text-gray-900 font-semibold capitalize">
                @if($user && method_exists($user, 'getRoleNames'))
                    {{ $user->getRoleNames()->first() ?? '-' }}
                @else
                    -
                @endif
            </dd>
        </div>
    </dl>
</div>
@endsection
