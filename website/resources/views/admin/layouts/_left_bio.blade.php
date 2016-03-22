<div class="nav_profile">
    <div class="media profile-left">
        <a class="pull-left profile-thumb" href="#">
            @if(Sentinel::getUser()->pic)
                <img src="{!! url('/').'/uploads/users/'.Sentinel::getUser()->pic !!}" alt="img"
                     class="img-circle img-bor"/>
            @else
                {{--<img src=""--}}
                     {{--alt="img" class="img-circle img-bor"/>--}}
            @endif
        </a>

        <div class="content-profile">
            <h4 class="media-heading text-center">
                {{ Sentinel::getUser()->first_name }} {{ Sentinel::getUser()->last_name }}
            </h4>
            <ul class="icon-list text-center">
                <li>
                    <a href="{{ URL::to('admin/users/'.Sentinel::getUser()->id) }}">
                        <i class="fa fa-fw fa-user"></i>
                    </a>
                </li>
                {{--<li>--}}
                    {{--<a href="{{ URL::to('admin/lockscreen') }}">--}}
                        {{--<i class="fa fa-fw fa-lock"></i>--}}
                    {{--</a>--}}
                {{--</li>--}}
                <li>
                    <a href="{{ route('users.edit',Sentinel::getUser()->id) }}">
                        <i class="fa fa-fw fa-gear"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ URL::to('admin/logout') }}">
                        <i class="fa fa-fw fa-sign-out"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>