@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')

    <x-core-content-header title="Roles" :breadcrumbs="$breadcrumbs"/>

@stop

@section('content')

    <x-adminlte-card theme="primary" theme-mode="outline">

        {!! $dataTable->table() !!}

    </x-adminlte-card>

@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('/vendor/datatables/editor/css/editor.bootstrap4.min.css')}}">
@stop

@section('js')
    <script type="text/javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <script type="text/javascript" src="{{asset('/vendor/datatables/editor/js/dataTables.editor.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/vendor/datatables/editor/js/editor.bootstrap4.min.js')}}"></script>
    {!! $dataTable->scripts() !!}
@stop
