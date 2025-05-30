@if(Auth::user()->rol === 'cliente')
    @include('layouts.nav_cliente')
@elseif(Auth::user()->rol === 'trabajador')
    @include('layouts.nav_trabajador')
@elseif(Auth::user()->rol === 'admin')
    @include('layouts.nav_admin')
@endif
