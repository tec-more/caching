@extends('tukecx-core::admin._master')

@section('css')

@endsection

@section('js')

@endsection

@section('js-init')

@endsection

@section('content')
    <div class="layout-1columns">
        <div class="column main">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="icon-layers font-dark"></i>
                        缓存管理
                    </h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <a href="{{ route('admin::tukecx-caching.clear-cms-cache.get') }}"
                           data-toggle="confirmation"
                           data-placement="right"
                           title="Are you sure?"
                           class="btn btn-danger">
                            清理CMS缓存
                        </a>
                        <a href="{{ route('admin::tukecx-caching.refresh-compiled-views.get') }}"
                           data-toggle="confirmation"
                           data-placement="right"
                           title="Are you sure?"
                           class="btn btn-warning">
                            刷新编译视图
                        </a>
                    </div>
                    <div class="form-group">
                        <a href="{{ route('admin::tukecx-caching.create-config-cache.get') }}"
                           data-toggle="confirmation"
                           data-placement="right"
                           title="Are you sure?"
                           class="btn green">
                            创建配置缓存
                        </a>
                        <a href="{{ route('admin::tukecx-caching.clear-config-cache.get') }}"
                           data-toggle="confirmation"
                           data-placement="right"
                           title="Are you sure?"
                           class="btn green-meadow">
                            清空配置缓存
                        </a>
                    </div>
                    <div class="form-group">
                        <a href="{{ route('admin::tukecx-caching.optimize-class.get') }}"
                           data-toggle="confirmation"
                           data-placement="right"
                           title="Are you sure?"
                           class="btn purple">
                            优化类加载
                        </a>
                        <a href="{{ route('admin::tukecx-caching.clear-compiled-class.get') }}"
                           data-toggle="confirmation"
                           data-placement="right"
                           title="Are you sure?"
                           class="btn red-haze">
                            清理编译类加载
                        </a>
                    </div>
                    <div class="form-group hidden">
                        <a href="{{ route('admin::tukecx-caching.create-route-cache.get') }}"
                           data-toggle="confirmation"
                           data-placement="right"
                           title="Are you sure?"
                           class="btn yellow-crusta">
                            创建路由缓存
                        </a>
                        <a href="{{ route('admin::tukecx-caching.clear-route-cache.get') }}"
                           data-toggle="confirmation"
                           data-placement="right"
                           title="Are you sure?"
                           class="btn purple">
                            清理路由缓存
                        </a>
                    </div>
                </div>
            </div>
            @php do_action('meta_boxes', 'main', 'tukecx-caching.index') @endphp
        </div>
    </div>
@endsection
