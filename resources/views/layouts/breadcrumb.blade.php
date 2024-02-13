<nav id="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ URL::to('/') }}"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>

        @php
        $bread = URL::to('/');
        $link = Request::path();
        $subs = explode("/", $link);
        @endphp

        @if (Request::path() != '/')

            @for($i = 0; $i < count($subs); $i++)

                @php
                $bread = $bread."/".$subs[$i];
                $title = urldecode($subs[$i]);
                $title = str_replace("-", " ", $title);
                $title = Str::title($title);
                @endphp

                @if ($i == 1)
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                @endif

                @if ($i == 0)
                <li class="breadcrumb-item"><a href="{{ $bread }}">{{ $title }}</a></li>
                @endif

                <!--@if ($i != (count($subs)-1))
                    <li><i class="fa fa-angle-right"></i></li>
                @endif-->

            @endfor
        @endif
    </ol>
</nav>

<!--<ul class="breadcrumb">
    <li><i class="fa fa-home"></i><a href="{{ url::to('home') }}">Home</a></li>
    <li><i class="fa fa-angle-right"></i></li>
    @for($i = 0; $i <= count(Request::segments()); $i++)
    <li><a href="">{{Request::segment($i)}}</a>
        @if($i < count(Request::segments()) & $i > 0)
        {!! '<i class="fa fa-angle-right"></i>' !!}
        @endif
    </li>
    @endfor
</ul>-->

<!-- Last Segment  Request::segment(3) / request()->segment(count(request()->segments())) / { collect(request()->segments())->last() }}  / basename(request()->path()) / last(request()->segments()) -->
