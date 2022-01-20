<div class="list-group d-flex d-column">
    @foreach ($menuItems as $menuItem)
        @if ($menuItem->submenu())
        @if ($menuItem->isOpen())
        <a href="#submenu-{{ $loop->index }}" data-toggle="collapse" aria-expanded="true" class="list-group-item flex-column align-items-start">
        @else
        <a href="#submenu-{{ $loop->index }}" data-toggle="collapse" aria-expanded="false" class="list-group-item flex-column align-items-start collapsed">
        @endif
            <div class="d-flex w-100 justify-content-start align-items-center">
                <span class="menu-icon {{ $menuItem->icon() }} fa-fw"></span>
                <span class="menu-collapse ml-3">{{ $menuItem->label() }}</span>
                <span class="menu-caret ml-auto"></span>
            </div>
        </a>
        @if ($menuItem->isOpen())
        <div id="submenu-{{ $loop->index }}" class="list-group-submenu show">
        @else
        <div id="submenu-{{ $loop->index }}" class="list-group-submenu collapse">
        @endif
            @foreach ($menuItem->submenu() as $submenuItem)
            <a href="{{ $submenuItem->url() }}" data-parent="#submenu-{{ $loop->index }}" aria-expanded="false" class="list-group-item sub-item flex-column align-items-start">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="menu-icon fa-fw"></span>
                    <span class="menu-collapse ml-3">{{ $submenuItem->label() }}</span>
                </div>
            </a> 
            @endforeach
        </div>
        @else
        <a href="{{ $menuItem->url() }}" aria-expanded="false" class="list-group-item flex-column align-items-start">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <span class="menu-icon {{ $menuItem->icon() }} fa-fw"></span>
                <span class="menu-collapse ml-3">{{ $menuItem->label() }}</span>
            </div>
        </a>
        @endif
    @endforeach
</div>
