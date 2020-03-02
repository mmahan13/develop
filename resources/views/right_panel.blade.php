<div class="col-xs-12 col-sm-12 col-md-9 col-lg-8 hidden" @yield('ng-attribute')>
    <div class="panel panel-default base-panel" style="height: 180%">
        <div class="panel-heading" ng-controller="">
            <h3 class="panel-title">@yield('panel-tilte')</h3>
        </div>
        <div class="panel-body">
            @yield('panel-content')
        </div>
    </div>
</div>