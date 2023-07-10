@extends('layouts.default')
@section('content')
    <form method="POST" action="/users/create">
        @csrf
        <input type="text" name="name" placeholder="name">
        <input type="email" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <input type="submit" value="crear">
    </form>
@stop
