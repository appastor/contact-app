@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mt-3">Alerts</h2>
    <ul id="alerts" class="list-group"></ul>
</div>

@section('scripts')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>
    document.onreadystatechange = () => {
        if (document.readyState === 'complete') {
            Pusher.logToConsole = true;

            Echo.channel('contacts')
                .listen('ContactCreated', (e) => {
                    addAlert(`Contact Created: ${e.name} (${e.email})`);
                })
                .listen('ContactUpdated', (e) => {
                    console.log(e);
                    addAlert(`Contact Updated: ${e.name} (${e.email})`);
                })
                .listen('ContactDeleted', (e) => {
                    addAlert(`Contact Deleted: ${e.name} (${e.email})`);
                });

            function addAlert(message) {
                let alertList = document.getElementById('alerts');
                let newAlert = document.createElement('li');
                newAlert.classList.add('list-group-item');
                newAlert.innerText = message;
                alertList.appendChild(newAlert);
            }
        }
    }
</script>
@endsection
@endsection
