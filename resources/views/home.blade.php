@extends('layouts.app')
@section('title','Domov')
@section('content')
    <h1>Vitaj v e-shope DedoMedo</h1>
    <p class="mt-1">Ochutnaj agátový, lipový, kvetový aj lesný med.</p>
    <a class="btn btn--brand mt-2" href="{{ route('products.index') }}">Pozrieť produkty</a>
@endsection
