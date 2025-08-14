@extends('adminlte::page')

@section('title', 'Empresas')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Empresas</h1>
        <a href="{{ route('companies.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Nova Empresa
        </a>
    </div>
@stop

@section('content')
    @if (session('success'))
        <x-adminlte-alert theme="success" title="Sucesso" dismissable>
            {{ session('success') }}
        </x-adminlte-alert>
    @endif

    @php
        $heads = [
            'ID',
            'Razão Social',
            'Nome Fantasia',
            ['label' => 'CNPJ', 'width' => 30],
            ['label' => 'Ações', 'no-export' => true, 'width' => 15],
        ];

        $config = [
            'order' => [[0, 'desc']],
            'paging' => true,
            'searching' => true,
            'responsive' => true,
            'lengthMenu' => [10, 25, 50, 100],
            'language' => ['url' => '//cdn.datatables.net/plug-ins/1.13.5/i18n/pt-BR.json'],
        ];
    @endphp

    <x-adminlte-datatable id="companiesTable" :heads="$heads" :config="$config" class="table-striped table-hover">
        @forelse ($companies as $company)
            <tr>
                <td>{{ $company->id }}</td>
                <td>{{ $company->name }}</td>
                <td>{{ $company->trade_name }}</td>
                <td>{{ preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '$1.$2.$3/$4-$5', $company->registration_number) }}</td>
                <td>
                    <nobr class="d-flex gap-1">
                        <a href="{{ route('companies.edit', $company) }}"
                           class="btn btn-xs btn-default text-primary mx-1 shadow" title="Editar">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                        </a>

                        <form action="{{ route('companies.destroy', $company) }}" method="POST"
                              onsubmit="return confirm('Confirma excluir a empresa {{ $company->name }}?');"
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Excluir">
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </button>
                        </form>
                    </nobr>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center text-muted">Nenhuma empresa cadastrada.</td>
            </tr>
        @endforelse
    </x-adminlte-datatable>
@stop

@section('js')
    <script>
        console.log('Empresas - index carregado');
    </script>
@stop
