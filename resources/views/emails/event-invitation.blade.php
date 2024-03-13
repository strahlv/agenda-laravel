<h1>{{ $inviter->name }} te convidou para o evento "{{ $event->title }}"</h1>
<p>Data: {{ $event->start_date->format('d/m/Y') }}</p>
<p>
    Horário:
    {{ $event->is_all_day ? 'o dia todo' : $event->formatted_start_time . ' às ' . $event->formatted_end_time }}
</p>
<a href="http://localhost:3000/{{ $event->getUrl('month') }}">Ir ao calendário</button>
