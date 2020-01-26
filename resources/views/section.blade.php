@extends('layouts.app')

@section('content')
    <article>
        <h2 class="visuallyhidden">{{ $section }}</h2>
        @foreach ($images as $image)
            <div class="image-item">
                <img
                    src="{{ $image['paths'][$image['length'] - 1] }}"
                    srcset="@for ($i = 0; $i < $image['length']; $i++){{ $image['paths'][$i] }} {{ $image['sizes'][$i] }}w{{ $i < $image['length'] - 1 ? ', ' : '' }}@endfor"
                    sizes="(max-width: 665px) 666px, (max-width: 65rem) 760px, (max-width: 1279px) 523px, 900px"
                    alt="A photograph by Jonathan Bell"
                />
            </div>
        @endforeach
    </article>
@endsection
