@extends('layouts.app')

@section('title') {{'Video live feed'}} @endsection

@section('content')
<!DOCTYPE html>
<html>
<div class="m-auto bg-opacity-75 bg-white rounded-md w-11/12 my-3">
    <iframe class="aspect-w-16 aspect-h-9 w-11/12 rounded-md m-auto p-3"  src="http://192.168.200.10/" title="video cam"></iframe>
</div>
</html>
