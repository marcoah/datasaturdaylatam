<x-mail::message>

<x-mail::title>
{{ $title }}
</x-mail::title>

<x-mail::intro>
{!! $intro !!}
</x-mail::intro>

{!! $content_1 !!}

{!! $content_2 !!}

{!! $content_3 !!}

@if ($has_cta == 1)
<x-mail::button :url="$button_link">
{{ $button_text }}
</x-mail::button>
@endif

</x-mail::message>
