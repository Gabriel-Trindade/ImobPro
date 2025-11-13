@extends('adminlte::page')

@section('title', 'Dashboard')

@section('css')
    <style>
        .is-invalid {
            border-color: #dc3545;
        }
    </style>
@stop

@section('content_header')
    @if (isset($user))
        <h1>Editar Usuário</h1>
    @else
        <h1>Criar Usuário</h1>
    @endif
@stop

@section('content')

    <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="POST" id="user-form">
        @csrf
        @if (isset($user))
            @method('PUT')
        @endif

        <div class="row" id="user_basic_registration">
            <x-adminlte-input name="name" label="Nome" placeholder="Nome" value="{{ old('name', $user->name ?? '') }}"
                fgroup-class="col-md-4" required>
                <x-slot name="prependSlot">
                    <div class="input-group-text"><i class="fas fa-user"></i></div>
                </x-slot>
            </x-adminlte-input>

            <x-adminlte-select name="type" label="Tipo" placeholder="Tipo" value="{{ old('type', $user->type ?? '') }}"
                fgroup-class="col-md-4">
                <option value="">Selecione o tipo de usuário</option>
                <option value="super" @selected(old('type', $user->type ?? '') === 'super')>Super Admin</option>
                <option value="admin" @selected(old('type', $user->type ?? '') === 'admin')>Admin</option>
                <option value="agent" @selected(old('type', $user->type ?? '') === 'agent')>Agente</option>
                <x-slot name="prependSlot">
                    <div class="input-group-text"><i class="fas fa-signature"></i></div>
                </x-slot>
            </x-adminlte-select>

            <x-adminlte-input name="document" label="CPF/RG/Passaporte" placeholder="CPF/RG/Passaporte"
                value="{{ old('document', $user->document ?? '') }}" fgroup-class="col-md-4" required>
                <x-slot name="prependSlot">
                    <div class="input-group-text"><i class="fas fa-id-card"></i></div>
                </x-slot>
            </x-adminlte-input>
        </div>

        <x-adminlte-button type="submit" label="{{ isset($company) ? 'Atualizar' : 'Cadastrar' }}"
            theme="{{ isset($company) ? 'primary' : 'success' }}" class="mt-4" />
    </form>

    @include('vendor.adminlte.partials.modals.feedback')
@stop


@section('js')
    <script>
        $(document).ready(function() {
            const form = document.getElementById('user-form');
            const typeSelect = form.querySelector('select[name="type"]');

            function addSpecificFieldsForType() {
                typeSelect.addEventListener('change', function() {
                    const selectedType = this.value;
                    if (selectedType === 'agent') {
                        const newDiv = document.createElement('div');
                        newDiv.classList.add('row');
                        newDiv.id = 'agent_additional_fields';
                        newDiv.innerHTML = `
                        <x-adminlte-input name="license_number" label="CRECI / N° de Licença" placeholder="Se houver" fgroup-class="col-md-4" />
                    `;
                        form.querySelector('#user_basic_registration').after(newDiv);
                    } else {
                        const existingDiv = document.getElementById('agent_additional_fields');
                        if (existingDiv) {
                            existingDiv.remove();
                        }
                    }
                });
            }
            addSpecificFieldsForType();
        })
    </script>
@stop
