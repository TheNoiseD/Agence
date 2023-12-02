@props(['active','menu'])
@if(!$dropdown)
    <li class="nav-item">
        <a class="nav-link {{ $active && $text !== 'Sair' ? 'active' : '' }}" aria-current="page" href="{{ $url }}">{{ $text }}</a>
    </li>
@else
    @php
    $menu = $menu->map(function($item, $key) use ($text){
        if($key == $text)
            return $item;
        else
            return null;
    });
    $menu = (object) $menu->filter();

    @endphp
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle {{ $active ? 'active' : '' }}" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{$text}}
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            @if(count($menu)>0)
                @foreach($menu->first()->child as $item)
                    <li><a class="dropdown-item" href="{{ $item->url }}">{{ $item->text }}</a></li>
                @endforeach
            @endif
        </ul>
    </li>
@endif



