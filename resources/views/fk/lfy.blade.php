@extends('layouts.vk')

@section('title', 'Ищу тебя')
@section('breadcrumb', 'Ищу.Киев')

@push('styles')
<link href="/assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="/assets/uniform/css/uniform.default.css" />
@endpush

@push('scripts')
<script type="text/javascript" src="/assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/assets/uniform/jquery.uniform.min.js"></script>
@endpush

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <div class="widget">
                <div class="widget-title">
                    <h4><i class="icon-globe"></i>@yield('title')</h4>
                           <span class="tools">
                           <a href="javascript:;" class="icon-chevron-down"></a>
                           </span>
                </div>
                <div class="widget-body">
                    <p>Дата последнего поста: {{Carbon\Carbon::parse($lastPostDate)->format('d.m.Y') }}</p>
                    @foreach($messages as $msg)
                    <div class="well">
                     {{$msg}}
                    </div>
                    @endforeach
                    {{--<button type="button" class="btn">--}}
                        {{--<i class="icon-plus"></i>--}}
                        {{--Получить последний пост--}}
                    {{--</button>--}}
                </div>
            </div>
        </div>
    </div>
@endsection