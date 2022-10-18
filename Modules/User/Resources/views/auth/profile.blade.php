@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')

    <x-core-content-header title="Profile" :breadcrumbs="$breadcrumbs"/>

@stop

@section('content')

    <x-adminlte-card theme="primary" theme-mode="outline">

        <livewire:user::auth.profile-form />

    </x-adminlte-card>

@stop

@section('css')

@stop

@section('js')

@stop
