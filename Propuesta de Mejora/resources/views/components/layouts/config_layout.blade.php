@vite(['resources/css/app.css', 'resources/js/app.js'])
@vite(['resources/css/layouts.css'])
@vite(['resources/css/listar.css'])

@extends('components.layouts.' . Auth::user()->tipo_usuario . '_layout')
