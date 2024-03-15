<span>O evento "<strong>{{ $notification->data['event_title'] }}</strong>" começará às
    {{ Carbon::parse($notification->data['event_start_date'])->format('G:i') }}.</span>
