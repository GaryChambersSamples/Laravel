@extends('layouts.app')

@section('content')
<div class="wrapper create-property">
<h1>Edit Details for {{ $tenant->first_name }} {{ $tenant->last_name}}</h1>
<form action="/tenants/{{ $tenant->id }} " method="POST">
    @method('PATCH')
    @include('tenants.form')

    <p><input type="submit" class="btn btn-primary"></button>
</form>



</div>
@endsection
