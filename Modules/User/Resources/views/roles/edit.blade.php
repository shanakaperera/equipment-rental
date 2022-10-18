@extends('adminlte::page')

@section('title', 'Edit Role')

@section('content_header')

    <x-core-content-header :title="'Edit '.$role->display_name. ' Role'" :breadcrumbs="$breadcrumbs"/>

@stop

@section('content')

    <x-adminlte-card theme="primary" theme-mode="outline">

        <livewire:user::auth.role-form :model="$role" />

    </x-adminlte-card>

@stop
