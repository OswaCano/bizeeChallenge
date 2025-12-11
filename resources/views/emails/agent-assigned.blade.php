@component('mail::message')
<x-mail::message>

    Hello {{ $company->registered_agent->name }},

    You have been assigned as a **registered agent** for the following company:

    - **Nombre:** {{ $company->name }}
    - **Estado:** {{ $company->state }}
    - **ID:** {{ $company->id }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
@endcomponent
