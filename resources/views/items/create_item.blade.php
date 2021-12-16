@extends('layouts.app')
@section('title','Crear Item')
@section('content')
    @if (isset($item))

        <item-form :item="{{ $item }}"></item-form>
    @else
        <item-form></item-form>
    @endif
@endsection
