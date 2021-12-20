@extends('layouts.main-layout')

@section('title', 'Home')

@section('content')
    <link-create-form-component submit-url="{{route('store.link')}}" site-url="{{url('/')}}"></link-create-form-component>
@stop
