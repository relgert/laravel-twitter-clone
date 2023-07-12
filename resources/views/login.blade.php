@extends('layouts.default')
@section('content')
    <form method="POST" action="/authenticate">
        @csrf
        <input type="email" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <input type="submit" value="Enviar">
    </form>
@stop



