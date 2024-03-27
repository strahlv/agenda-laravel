<section id="event-details" class="event-details" x-show="showContentType === 'show'">
    <h1 class="event-details-title" x-text="data.title"></h1>

    <div class="event-details-date-time">
        <div>
            <span class="label">Data</span>
            <div class="event-details-date-time-item">
                <i class="fa-solid fa-calendar-day clr-primary"></i>
                <p x-text="data.fancy_date"></p>
            </div>
        </div>
        <div>
            <span class="label">Horário</span>
            <div class="event-details-date-time-item">
                <i class="fa-solid fa-clock clr-primary"></i>
                <p x-text="data.fancy_time"></p>
            </div>
        </div>
    </div>

    <template x-if="data?.creator?.name">
        <div>
            <span class="label">Organizador</span>
            <div class="event-details-date-time-item">
                <i class="fa-solid fa-user clr-primary"></i>
                <p x-text="data.creator.name"></p>
            </div>
        </div>
    </template>

    <template x-if="data?.participants?.length">
        <ul class="event-details-participant-list">
            <p class="label" x-text="data.participants.length + ' participante(s)'"></p>

            <template x-for="user in data.participants">
                <li class="event-details-participant">
                    <div class="flex-col">
                        <span x-text="user.id === data.user_id ? 'Você' : user.name"></span>
                        <span class="label" x-text="user.email"></span>
                    </div>

                    <template x-if="user.id === data.creator_id">
                        <span class="participant-role">Organizador</span>
                    </template>
                </li>
            </template>
        </ul>
    </template>

    <template x-if="data?.creator?.name">
        <form method="POST" action="/">
            @csrf
            @method('PATCH')

            <button type="submit" class="btn btn-primary btn-with-icon"><i class="fa-solid fa-xmark"></i>
                Cancelar presença</button>
        </form>
    </template>
</section>
