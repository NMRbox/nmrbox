<div>
    <ul class="navigation">
        <li {{ (Request::is('admin') ? 'class="active"' : '') }}>
            <a href="{{ route('dashboard') }}">
                <i class="menu-icon fa fa-fw fa-home"></i>
                <span class="mm-text ">Dashboard</span>
            </a>
        </li>
        <li class="menu-dropdown  {!! ((Request::is('admin/pages') ||  Request::is('admin/pages/create')) || Request::is('admin/pages/*') ? 'active' : '') !!}">
            <a href="#">
                <i class="menu-icon fa fa-fw fa-newspaper-o"></i>
                <span class="title">Pages</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="sub-menu">
                <li {!! (Request::is('admin/page') ? 'class="active"' : '') !!}>
                    <a href="{{ URL::to('admin/pages') }}">
                        <i class="fa fa-fw fa-th-list"></i>
                        Page List
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-dropdown {{ (Request::is('admin/files') || Request::is('admin/files/create') || Request::is('admin/files/*')) }}">
            <a href="#">
                <i class="menu-icon  fa fa-fw fa-file"></i>
                <span>Files</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="sub-menu">
                <li {{ (Request::is('admin/files') ? 'class=active' : '') }}>
                    <a href="{{ URL::to('admin/files') }}">
                        File Index
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-dropdown {{ (Request::is('admin/software') || Request::is('admin/categories') || Request::is('admin/keyword') || Request::is('admin/categories/*') || Request::is('admin/keyword/*') || Request::is('admin/software/*') ? 'active' : '') }}">
            <a href="#">
                <i class="menu-icon  fa fa-fw fa-laptop"></i>
                <span>Software</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="sub-menu">
                <li {{ (Request::is('admin/software') ? 'class=active' : '') }}>
                    <a href="{{ URL::to('admin/software') }}">
                        Software Index
                    </a>
                </li>
                <li {{ (Request::is('admin/keyword') ? 'class=active' : '') }}>
                    <a href="{{ URL::to('admin/keyword') }}">
                        Keyword Index
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-dropdown {{ (Request::is('admin/email') || Request::is('admin/email/create') || Request::is('admin/email/*') ? 'active' : '') }}">
            <a href="#">
                <i class="menu-icon  fa fa-fw fa-envelope-o"></i>
                <span>Email Templates</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="sub-menu">
                <li {{ (Request::is('admin/email') ? 'class=active' : '') }}>
                    <a href="{{ URL::to('admin/email') }}">
                        Email Templates Index
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-dropdown {{ (Request::is('admin/faq') || Request::is('admin/faq/create') || Request::is('admin/faq/*') ? 'active' : '') }}">
            <a href="#">
                <i class="menu-icon  fa fa-question-circle"></i>
                <span>FAQs</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="sub-menu">
                <li {{ (Request::is('admin/faq') ? 'class=active' : '') }}>
                    <a href="{{ URL::to('admin/faq') }}">
                        FAQs Index
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-dropdown {{ (Request::is('admin/search_keyword') || Request::is('admin/search_keyword/*') ? 'active' : '') }}">
            <a href="#">
                <i class="menu-icon  fa fa-fw fa-file"></i>
                <span>Search Keywords</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="sub-menu">
                <li {{ (Request::is('admin/search_keyword') ? 'class=active' : '') }}>
                    <a href="{{ URL::to('admin/search_keyword') }}">
                        Keywords Index
                    </a>
                </li>
            </ul>
        </li>
        {{--<li class="menu-dropdown {{ (Request::is('admin/users') || Request::is('admin/users/create') || Request::is('admin/users/*') || Request::is('admin/deleted_users') ? 'active' : '') }}">
            <a href="#">
                <i class="menu-icon  fa fa-fw fa-user"></i>
                <span>Users</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="sub-menu">
                <li {{ (Request::is('admin/users') ? 'class=active' : '') }}>
                    <a href="{{ URL::to('admin/users') }}">
                        Users
                    </a>
                </li>
            </ul>
        </li>--}}
        <li class="menu-dropdown {{ (Request::is('admin/vm') || Request::is('admin/vm/create') || Request::is('admin/vm/*') || Request::is('admin/vmdownload') || Request::is('admin/vmdownload/*') ? 'active' : '') }}">
            <a href="#">
                <i class="menu-icon  fa fa-fw fa-cubes"></i>
                <span>VM Versions</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="sub-menu">
                <li {{ (Request::is('admin/vm') ? 'class=active' : '') }}>
                    <a href="{{ URL::to('admin/vm') }}">
                        VM Index
                    </a>
                </li>
                <li {{ (Request::is('admin/vmdownload') ? 'class=active' : '') }}>
                    <a href="{{ URL::to('admin/vmdownload') }}">
                        VM Downloads Index
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-dropdown {{ (Request::is('admin/workshop') || Request::is('admin/groups') ? 'active' : '') }}">
            <a href="#">
                <i class="menu-icon  fa fa-fw fa-bar-chart"></i>
                <span>Workshops</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="sub-menu">
                <li {{ (Request::is('admin/workshop') ? 'class=active' : '') }}>
                    <a href="{{ URL::to('admin/workshop') }}">
                        Workshops Index
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-dropdown {{ (Request::is('admin/people') || Request::is('admin/classification') || Request::is('admin/groups') ? 'active' : '') }}">
            <a href="#">
                <i class="menu-icon  fa fa-fw fa-users"></i>
                <span>People</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="sub-menu">
                <li {{ (Request::is('admin/people') ? 'class=active' : '') }}>
                    <a href="{{ URL::to('admin/people') }}">
                        People Index
                    </a>
                </li>
                <li {{ (Request::is('admin/classification') ? 'class=active' : '') }}>
                    <a href="{{ URL::to('admin/classification') }}">
                        Classifications
                    </a>
                </li>
                {{--<li {{ (Request::is('admin/groups') ? 'class=active' : '') }}>
                    <a href="{{ URL::to('admin/groups') }}">
                        Categories
                    </a>
                </li>--}}
            </ul>
        </li>

    </ul>
</div>