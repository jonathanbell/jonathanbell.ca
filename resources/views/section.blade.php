@extends('layouts.app')

@section('content')
    <article>
        <h2 class="visuallyhidden">{{ $section }}</h2>
        @foreach ($images as $image)
            <div class="image-item">
                <img
                    src="{{ $image['paths'][0] }}"
                    loading="lazy"
                    srcset="@for ($i = 0; $i < $image['length']; $i++){{ $image['paths'][$i] }} {{ $image['sizes'][$i] }}w{{ $i < $image['length'] - 1 ? ', ' : '' }}@endfor"
                    sizes="(min-width: 80rem) 47vw, (min-width: 65rem) 37vw, (min-width: 666px) 73vw, 100vw"
                    alt="A photograph by Jonathan Bell"
                />
            </div>
        @endforeach
    </article>
@endsection
