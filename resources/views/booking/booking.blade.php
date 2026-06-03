@extends('layout.main')

@section('css')
<link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css">
    
@endsection

@section('title')
    Bookings
@endsection


@section('breadcrumbs')
<x-breadcrumbs :items="$breadcrumbs"></x-breadcrumbs>
@endsection

@section('content')
    <a class="btn btn-sm btn-success">Add a Booking</a>
    <div id="kt_calendar"></div>
@endsection

@section('modals')

@endsection

@section('javascript')
<script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>

<script>
    $(document).ready(function(){
        var calendarEl = $('#kt_calendar')[0];
        if(!calendarEl)
            return;

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',

        }).render();

    });

</script>
@endsection