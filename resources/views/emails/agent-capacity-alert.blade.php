@component('mail::message')
<x-mail::message>
# Registered Agents Capacity Alert ({{ $state }})

    Total capacity for {{ $state }} has reached **{{ $percent }}%**.

    - Total Capacity: **{{ $total }}**
    - Assigned Companies: **{{ $used }}**
    - Threshold: **90%**

    Please review and add more agents if needed.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
@endcomponent
