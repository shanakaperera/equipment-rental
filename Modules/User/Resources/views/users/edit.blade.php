@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')

    <x-core-content-header :title="'Edit '.$user->full_name" :breadcrumbs="$breadcrumbs"/>

@stop

@section('content')

    <x-adminlte-card theme="primary" theme-mode="outline">

        <livewire:user::auth.user-form :model="$user" />

    </x-adminlte-card>

@stop
