@extends('errors.template')

@section('content')

        Oops, something went wrong <i class="fa fa-frown-o"></i>

        <span>{!! $message !!}</span>

@stop
