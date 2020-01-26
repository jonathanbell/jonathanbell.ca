<div class="masthead">
    <h1 class="site-title"><a href="/">Jonathan Bell</a></h1>

    <nav>
        @foreach ($sections as $key => $value)
            <div>
                <a href="/{{ $key }}{{ $key === 'credit-to-creation' ? '/1' : '' }}">{{ $value }}</a>
            </div>
        @endforeach
        <hr />
        <div><a href="https://vimeo.com/jonathanbell">Video</a></div>
        <div><a href="mailto:jonathanbell.ca+site@gmail.com">Contact</a></div>
    </nav>

    @if($section === 'Credit to Creation' && !Request::is('/'))
        <hr class="show" />
        <footer role="navigation">
            @if((int) $page !== 1)
                <a href="/credit-to-creation/{{ $page - 1 }}">&lt;&lt; Previous</a>
            @endif
            <span style="font-weight: bold">{{ $page }} / {{ $number_of_pages }}</span>
            @if((int) $page < (int) $number_of_pages)
                <a href="/credit-to-creation/{{ $page + 1 }}">Next &lt;&lt;</a>
            @endif
        </footer>
    @endif
</div>
