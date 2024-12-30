<ul class="nav nav-tabs">
    <li class="nav-item">
        <a href="{{ route('roles.index') }}" class="nav-link @if (request()->routeIs('roles.*')) active 
                           @else border-0
                           @endif" >Roles</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('permissions.index') }}" class="nav-link @if (request()->routeIs('permissions.*')) active 
                           @else border-0
                           @endif"  >Permissions</a>
    </li>
</ul>