@extends('adminlte::page')

@section('title', 'Empresas')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Usuários</h1>
        <a href="{{ route('users.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Novo Usuário
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
            'Nome',
            'Email',
            'Tipo',
            'N° de licença',
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
        @forelse ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->license_number }}</td>
                <td>
                    <nobr class="d-flex gap-1">
                        <a href="{{ route('users.edit', $user) }}"
                           class="btn btn-xs btn-default text-primary mx-1 shadow" title="Editar">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                        </a>

                        <form action="{{ route('users.destroy', $user) }}" method="POST"
                              onsubmit="return confirm('Confirma excluir o usuário {{ $user->name }}?');"
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
                <td colspan="6" class="text-center text-muted">Nenhum usuário cadastrado.</td>
            </tr>
        @endforelse
    </x-adminlte-datatable>
@stop

@section('js')
    <script>
        console.log('Usuários - index carregado');
    </script>
@stop
