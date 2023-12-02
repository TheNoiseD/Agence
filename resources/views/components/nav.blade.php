<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a href="http://www.agence.com.br/"  class="navbar-brand">
            <img src="{{Vite::asset('resources/img/logo.gif')  }}" class="h-8" alt="Flowbite Logo" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <x-nav-item url="{{route('agence')}}" :active="request()->routeIs('agence')" text="Agence" />
                <x-nav-item url="{{route('projectos')}}" :active="request()->routeIs('projectos')" text="Projetos" />
                <x-nav-item url="{{route('administrativo')}}" :active="request()->routeIs('administrativo')" text="Administrativo" />
                <x-nav-item url="{{route('comercial')}}" :active="request()->routeIs('comercial.*')" text="Comercial" :menu="$menu" dropdown/>
                <x-nav-item url="{{route('financiero')}}" :active="request()->routeIs('financiero')" text="Financeiro" />
                <x-nav-item url="{{route('usuario')}}" :active="request()->routeIs('usuario')" text="Usuário" />
                <x-nav-item url="{{route('index')}}" :active="request()->routeIs('index')" text="Sair"  />
            </ul>
        </div>
    </div>
</nav>
