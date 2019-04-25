<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle padding-user" data-toggle="dropdown">
        @if(Sentinel::getUser()->pic)
            <img src="{!! url('/').'/uploads/users/'.Sentinel::getUser()->pic !!}" alt="img"
                 class="img-circle img-responsive pull-left" height="35" width="35"/>
        @else
            {{--<img src="" alt="img"--}}
                 {{--class="img-circle img-responsive pull-left" height="35" width="35"/>--}}
        @endif
        <div class="riot">
            <div>
                {{ Sentinel::getUser()->first_name }} {{ Sentinel::getUser()->last_name }}
                <span>
                                        <i class="caret"></i>
                                    </span>
            </div>
        </div>
    </a>
    <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header">
            @if(Sentinel::getUser()->pic)
                <img src="{!! url('/').'/uploads/users/'.Sentinel::getUser()->pic !!}" alt="img"
                     class="img-circle img-bor"/>
            @else
                <img src=""
                     alt="img" class="img-circle img-bor"/>
            @endif
            <p>{{ Sentinel::getUser()->first_name }} {{ Sentinel::getUser()->last_name }}</p>
        </li>
        <!-- Menu Body -->
        <li class="pad-3">
            <a href="{{ URL::to('admin/users/'.Sentinel::getUser()->id) }}">
                <i class="fa fa-fw fa-user"></i>
                My Profile
            </a>
        </li>
        <li role="presentation"></li>
        <li>
            <a href="{{ route('users.edit',Sentinel::getUser()->id) }}">
                <i class="fa fa-fw fa-gear"></i>
                Account Settings
            </a>
        </li>
        <li role="presentation" class="divider"></li>
        <!-- Menu Footer-->
        <li class="user-footer">
            <div class="pull-left">
                <a href="{{ URL::to('admin/lockscreen') }}">
                    <i class="fa fa-fw fa-lock"></i>
                    Lock
                </a>
            </div>
            <div class="pull-right">
                <a href="{{ URL::to('admin/logout') }}">
                    <i class="fa fa-fw fa-sign-out"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</li>