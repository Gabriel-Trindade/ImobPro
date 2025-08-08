@extends('adminlte::page')

@section('title', 'Dashboard')

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Empresas</h1>
        <a href="{{ route('companies.create') }}" class="btn btn-success">Nova Empresa</a>
    </div>
@stop

@section('content')
    @php
        $heads = [
            'ID',
            'Razão Social',
            'Nome Fantasia',
            ['label' => 'CNPJ', 'width' => 40],
            ['label' => 'Ações', 'no-export' => true, 'width' => 5],
        ];

        $btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </button>';
        $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                  <i class="fa fa-lg fa-fw fa-trash"></i>
              </button>';
        $btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                   <i class="fa fa-lg fa-fw fa-eye"></i>
               </button>';

    @endphp

    {{-- Minimal example / fill data using the component slot --}}
    <x-adminlte-datatable id="table1" :heads="$heads">
        @foreach ($companies as $company)
            <tr>
                <td>{{ $company->id }}</td>
                <td>{{ $company->razao_social }}</td>
                <td>{{ $company->nome_fantasia }}</td>
                <td>{{ $company->cnpj }}</td>
                <td>
                    <nobr>{!! $btnEdit !!}{!! $btnDelete !!}{!! $btnDetails !!}</nobr>
                </td>
            </tr>
        @endforeach
    </x-adminlte-datatable>
@stop


@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
