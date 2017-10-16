@extends('layouts.vk')

@section('title', 'Список постов')
@section('breadcrumb', 'Ищу.Киев')

@push('styles')
<link href="/assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="/assets/uniform/css/uniform.default.css" />
<link rel="stylesheet" type="text/css" href="/assets/bootstrap-datepicker/css/datepicker.css" />
@endpush

@push('scripts')
<script type="text/javascript" src="/assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/assets/uniform/jquery.uniform.min.js"></script>
<script type="text/javascript" src="/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

@endpush

@section('content')
    @if ($errors->any())
    <div class="row-fluid">
        <div class="span12">
            <div class="alert alert-block alert-error fade in">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <h4 class="alert-heading">Ошибка!</h4>
                <br>
                <p>
                    {{$errors->first()}}
                </p>
            </div>
        </div>
    </div>
    @endif

    @if (Session::has('success'))
        <div class="row-fluid">
            <div class="span12">
                <div class="alert alert-block alert-success fade in">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <h4 class="alert-heading">Успешно!</h4>
                    <br>
                    <p>
                        {{ Session::get('success') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    @if ($user->hasRole(['administrator']))
    <div class="row-fluid">
        <div class="span12">
            <div class="widget">
                <div class="widget-title">
                    <h4><i class="icon-plus"></i> Добавление нового поста</h4>
									<span class="tools">
									<a href="javascript:;" class="icon-chevron-down"></a>
									<a href="javascript:;" class="icon-remove"></a>
									</span>
                </div>
                <div class="widget-body">
                    <form action="{{url('fk/posts/add')}}" class="form-inline" method="post">
                        <div class="control-group">
                            {{ csrf_field() }}
                            <input name="link" type="text" class="span5 one-half" placeholder="Ссылка">
                            <button type="submit" class="btn ">Добавить</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
    @endif

    <div class="row-fluid">
        <div class="span12">
            <div class="widget">
                <div class="widget-title">
                    <h4><i class="icon-globe"></i> @yield('title')</h4>
                           <span class="tools">
                           <a href="javascript:;" class="icon-chevron-down"></a>
                           </span>
                </div>
                <div class="widget-body">
                    <p>Показаны посты за: {{Carbon\Carbon::parse($lastPostDate)->format('d.m.Y') }}</p>
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