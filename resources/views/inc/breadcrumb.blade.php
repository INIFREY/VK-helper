<ul class="breadcrumb">
    <li>
        <a href="#"><i class="icon-home"></i></a><span class="divider">&nbsp;</span>
    </li>
    @if ($slot && $slot!='')
    @foreach (explode('||', $slot) as $item)
        @php ($data = explode("=&gt;", $item))
        <li>
            <a href="{{isset($data[1]) ? url($data[1]) : '#!'}}">{{$data[0]}}</a> <span class="divider">&nbsp;</span>
        </li>
    @endforeach
    @endif
    <li>
        <a href="{{url()->current()}}">@yield('title')</a> <span class="divider-last">&nbsp;</span>
    </li>
</ul>