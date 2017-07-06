@extends('errors.template')

@section('content')

        Oops, something went wrong <i class="fa fa-frown-o"></i>

        <span>It looks like the config files aren't <b>writable</b>.<br/>Make sure to <b>chmod -R 777</b> the config directory.</span>

@stop