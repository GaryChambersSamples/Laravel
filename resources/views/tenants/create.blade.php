@extends('layouts.app')

@section('content')
<div class="wrapper create-property">
    <h1>Add a New Tenant</h1>
    <form action="/tenants" method="POST">
        @include('tenants.form')
        <button class="btn btn-primary" type="submit">Add Tenant</button>
    </form>
</div>
@endsection
