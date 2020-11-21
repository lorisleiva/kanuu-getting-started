<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @php($user = auth()->user())
                    <h1 class="font-semibold text-xl mb-4">Hi {{ $user->name }}! 👋</h1>
                    @if($user->isSubscribed())
                        <p class="mb-4">You are subscribed, thank you so much for you support!</p>
                    @else
                        <p class="mb-4">You are not subscribed, click the button below to unlock all features!</p>
                    @endif
                    <a
                        href="{{ route('kanuu.redirect', $user) }}"
                        class="px-4 py-2 bg-gray-800 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        {{ $user->isSubscribed() ? 'Manage your subscription' : 'Subscribe to Acme' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
