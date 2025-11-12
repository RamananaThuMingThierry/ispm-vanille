@component('mail::message')
# Nouvelle Réservation

Une nouvelle réservation a été effectuée :

**Nom :** {{ $reservation->name }}
**Email :** {{ $reservation->email }}
**Téléphone :** {{ $reservation->phone }}
**Message :**
{{ $reservation->message }}

@component('mail::button', ['url' => url('/')])
Voir le site
@endcomponent

Merci,
{{ config('app.name') }}
@endcomponent
