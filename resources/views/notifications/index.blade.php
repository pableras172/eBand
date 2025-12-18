<x-app-layout>
    <x-slot name="header">
        <x-ui.breadcrumbs>
            <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
            <x-ui.breadcrumbs.separator />
            <x-ui.breadcrumbs.link active>{{ __('common.calendario') }}</x-ui.breadcrumbs.link>
        </x-ui.breadcrumbs>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notifications') }}
            <span id="notifications-counter" class="ml-2 bg-blue text-white rounded-md px-3">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
        </h2>
        <span id="mark-all-as-read" class="text-sm font-bold text-gb cursor-pointer hover:text-blue" href="#">
            {{ __('Mark all as read') }}
        </span>
        <button type="button" onclick="seedNotifications()" class="ml-3 text-sm font-bold text-blue hover:underline">
            {{ __('Generar pruebas') }}
        </button>
    </x-slot>

    <main class="xs:mx-3 w-auto bg-white lg:mx-auto lg:mt-16 lg:rounded-xl lg:p-8 lg:max-w-xl">
        @php
            $notifications = auth()->user()->notifications;
        @endphp

        @forelse ($notifications as $notification)
            @php
                $isUnread = is_null($notification->read_at);
                $data = $notification->data ?? [];
            @endphp

            <div id="notification-card-{{ $notification->id }}"
                 class="mt-3 {{ $isUnread ? 'bg-verylightgb' : 'bg-white' }} rounded-md flex justify-between p-3 ">
                <img src="{{ $data['avatar'] ?? asset('assets/images/default-avatar.webp') }}"
                     alt="notification user avatar" class="w-12 h-12 ">
                <div class="ml-2 text-sm flex-auto">
                    <a href="#" class="font-bold hover:text-blue">{{ $data['user_name'] ?? 'Sistema' }}</a>
                    <span class="text-darkgb">{{ $data['action'] ?? $notification->type }}</span>
                    @if(!empty($data['subject']))
                        <a href="#" class="font-bold text-darkgb cursor-pointer hover:text-blue">{{ $data['subject'] }}</a>
                    @endif

                    @if($isUnread)
                        <span id="notification-ping">
                            <span class="absolute inline-block rounded-full mt-2 ml-1 p-1 bg-red"> </span>
                            <span class="relative inline-block animate-ping rounded-full ml-1 p-1 bg-red"> </span>
                        </span>
                    @endif

                    <p class="text-gb mt-1">{{ $notification->created_at->diffForHumans() }}</p>

                    @if(!empty($data['message']))
                        <p class="border border-lightgb2 rounded-md text-darkgb mt-3 p-4 cursor-pointer hover:bg-lightgb2">
                            {{ $data['message'] }}
                        </p>
                    @endif
                </div>

                @if(!empty($data['image']))
                    <img src="{{ $data['image'] }}" alt="notification pictures" class="w-10 h-10 cursor-pointer">
                @endif
            </div>
        @empty
            <div class="mt-3 rounded-md p-3 bg-white text-gb">
                {{ __('No notifications') }}
            </div>
        @endforelse

        {{-- Script para generar notificaciones de prueba --}}
        <script>
            function seedNotifications() {
                const token = '{{ csrf_token() }}';
                // Intenta crear notificaciones vía backend (si existe la ruta)
                fetch('/notifications/seed', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({ count: 3 })
                })
                .then(r => {
                    if (r.ok) return r.json();
                    throw new Error('No seed endpoint');
                })
                .then(() => location.reload())
                .catch(() => clientSeed());
            }

            // Fallback: insertar muestras en cliente respetando el estilo actual
            function clientSeed() {
                const container = document.querySelector('main');
                const samples = [
                    { user_name: 'Mark Webber', action: 'reacted to your recent post', subject: 'My first tournament today!', time: '1m ago', unread: true },
                    { user_name: 'Angela Gray', action: 'followed you', time: '2m ago', unread: true },
                    { user_name: 'Jacob Thompson', action: 'has joined your group', subject: 'Chess Club', time: '1 day ago', unread: true },
                ];

                samples.forEach(s => {
                    const div = document.createElement('div');
                    div.className = `mt-3 ${s.unread ? 'bg-verylightgb' : 'bg-white'} rounded-md flex justify-between p-3`;
                    div.innerHTML = `
                        <img src="{{ asset('assets/images/default-avatar.webp') }}" alt="notification user avatar" class="w-12 h-12 ">
                        <div class="ml-2 text-sm flex-auto">
                            <a href="#" class="font-bold hover:text-blue">${s.user_name}</a>
                            <span class="text-darkgb">${s.action}</span>
                            ${s.subject ? `<a href="#" class="font-bold text-darkgb cursor-pointer hover:text-blue">${s.subject}</a>` : ''}
                            ${s.unread ? `
                                <span id="notification-ping">
                                    <span class="absolute inline-block rounded-full mt-2 ml-1 p-1 bg-red"></span>
                                    <span class="relative inline-block animate-ping rounded-full ml-1 p-1 bg-red"></span>
                                </span>` : ''
                            }
                            <p class="text-gb mt-1">${s.time}</p>
                        </div>
                    `;
                    container.appendChild(div);
                });
            }
        </script>
    </main>
</x-app-layout>