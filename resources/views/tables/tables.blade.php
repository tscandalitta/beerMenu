@extends('layouts.app')

@section('content')
    @foreach($tables as $table)
        {!! QrCode::size(300)->generate('https://maxituyhorus.com/?table_id=' . $table->id . '&token=' . $table->token); !!}
    @endforeach

@endsection

