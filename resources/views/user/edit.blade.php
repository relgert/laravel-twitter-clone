@extends('layouts.default')
@section('content')
    <form method="POST" action="/users/edit/{{$user->id}}">
        @csrf
        <input type="hidden" name="id" value = "{{ $user->id }}"/>
        <x-input class="test" type="text" name="name" value="{{ $user->name }}" label="Name"/>
        <x-input class="test" type="email" name="email" value="{{ $user->email }}" label="Email"/>
        <input type="submit" value="Editar"/>
    </form>
@stop
