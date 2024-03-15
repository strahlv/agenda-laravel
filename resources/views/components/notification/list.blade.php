@auth
    @php
        $user = auth()->user();
        $notifications = $user->notifications;
        $unreadNotifications = $user->unreadNotifications;
        $hasUnreadNotifications = $user->unreadNotifications->count() > 0;
    @endphp

    <x-dropdown>
        <x-slot name="trigger">
            <button id="notifications" @class(['btn', 'btn-icon', 'notification' => $hasUnreadNotifications])><i class="fa-solid fa-bell"></i></button>
        </x-slot>

        <p class="greeting">Notificações</p>

        @csrf

        <ul class="notification-list" data-notification-ids="{{ $unreadNotifications }}">
            @foreach ($notifications as $notification)
                <x-notification.message :notification="$notification" />
            @endforeach
            @if (count($notifications) === 0)
                <p class="no-notifications">Sem notificações.</p>
            @endif
        </ul>
    </x-dropdown>
@endauth
