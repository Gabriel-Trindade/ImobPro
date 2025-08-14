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
    @if (isset($company))
        <h1>Editar Empresa</h1>
    @else
        <h1>Criar Empresa</h1>
    @endif
@stop

@section('content')

    <form action="{{ isset($company) ? route('companies.update', $company->id) : route('companies.store') }}" method="POST"
        id="company-form">
        @csrf
        @if (isset($company))
            @method('PUT')
        @endif

        <div class="row" id="company_basic_registration">
            <x-adminlte-input name="name" label="Razão Social" placeholder="Razão Social"
                value="{{ old('name', $company->name ?? '') }}" fgroup-class="col-md-4" required>
                <x-slot name="prependSlot">
                    <div class="input-group-text"><i class="fas fa-building"></i></div>
                </x-slot>
            </x-adminlte-input>

            <x-adminlte-input name="trade_name" label="Nome Fantasia" placeholder="Nome Fantasia"
                value="{{ old('trade_name', $company->trade_name ?? '') }}" fgroup-class="col-md-4">
                <x-slot name="prependSlot">
                    <div class="input-group-text"><i class="fas fa-signature"></i></div>
                </x-slot>
            </x-adminlte-input>

            <x-adminlte-input name="registration_number" label="CNPJ" placeholder="00.000.000/0000-00"
                value="{{ old('registration_number', $company->registration_number ?? '') }}" fgroup-class="col-md-4"
                required>
                <x-slot name="prependSlot">
                    <div class="input-group-text"><i class="fas fa-id-card"></i></div>
                </x-slot>
            </x-adminlte-input>
        </div>

        <div id="company_contact" class="mt-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="fw-bold m-0">Contatos</h5>
                <x-adminlte-button id="add-contact" label="Adicionar Contato" theme="success" icon="fas fa-plus" />
            </div>

            @foreach (old('contacts', $company->contacts ?? []) as $i => $c)
                @include('companies.partials.contact-fields', ['index' => $i, 'contact' => $c])
            @endforeach
        </div>

        <div id="company_address" class="row mt-4">
            <div class="col-12 mb-2">
                <h5 class="fw-bold">Endereço</h5>
            </div>

            <x-adminlte-input name="zip_code" label="CEP" placeholder="00000-000"
                value="{{ old('zip_code', $company->address->zip_code ?? '') }}" fgroup-class="col-md-3 col-sm-6" required>
                <x-slot name="prependSlot">
                    <div class="input-group-text"><i class="fas fa-mail-bulk"></i></div>
                </x-slot>
            </x-adminlte-input>

            <x-adminlte-input name="street" label="Endereço" placeholder="Endereço" id="street"
                value="{{ old('street', $company->address->street ?? '') }}" fgroup-class="col-md-6 col-sm-12" required>
                <x-slot name="prependSlot">
                    <div class="input-group-text"><i class="fas fa-road"></i></div>
                </x-slot>
            </x-adminlte-input>

            <x-adminlte-input name="number" label="Número" placeholder="Número" id="number"
                value="{{ old('number', $company->address->number ?? '') }}" fgroup-class="col-md-3 col-sm-6" required>
                <x-slot name="prependSlot">
                    <div class="input-group-text"><i class="fas fa-hashtag"></i></div>
                </x-slot>
            </x-adminlte-input>

            <x-adminlte-input name="complement" label="Complemento" placeholder="Complemento" id="complement"
                value="{{ old('complement', $company->address->complement ?? '') }}" fgroup-class="col-md-3 col-sm-6">
                <x-slot name="prependSlot">
                    <div class="input-group-text"><i class="fas fa-door-open"></i></div>
                </x-slot>
            </x-adminlte-input>

            <x-adminlte-input name="state" label="Estado" placeholder="UF" id="state" maxlength="2"
                value="{{ old('state', $company->address->state ?? '') }}" fgroup-class="col-md-3 col-sm-6" required>
                <x-slot name="prependSlot">
                    <div class="input-group-text"><i class="fas fa-map"></i></div>
                </x-slot>
            </x-adminlte-input>

            <x-adminlte-input name="city" label="Cidade" placeholder="Cidade" id="city"
                value="{{ old('city', $company->address->city ?? '') }}" fgroup-class="col-md-3 col-sm-6" required>
                <x-slot name="prependSlot">
                    <div class="input-group-text"><i class="fas fa-city"></i></div>
                </x-slot>
            </x-adminlte-input>

            <x-adminlte-input name="neighborhood" label="Bairro" placeholder="Bairro" id="neighborhood"
                value="{{ old('neighborhood', $company->address->neighborhood ?? '') }}" fgroup-class="col-md-3 col-sm-6"
                required>
                <x-slot name="prependSlot">
                    <div class="input-group-text"><i class="fas fa-neuter"></i></div>
                </x-slot>
            </x-adminlte-input>
        </div>

        <x-adminlte-button type="submit" label="{{ isset($company) ? 'Atualizar' : 'Cadastrar' }}"
            theme="{{ isset($company) ? 'primary' : 'success' }}" class="mt-4" />
    </form>

    @include('vendor.adminlte.partials.modals.feedback')
@stop


@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="{{ asset('js/addressAutocomplete.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('input[name="registration_number"]').mask('00.000.000/0000-00', {
                reverse: true
            });
            $('input[name^="contacts"][name$="[phone]"]').mask('(00) 00000-0000');
        });

        let contactIndex = 0;

        $('#add-contact').on('click', function() {
            $.ajax({
                url: "{{ route('contact-fields-partial') }}",
                data: {
                    index: contactIndex
                },
                success: function(html) {
                    $('#company_contact').append(html);
                    contactIndex++;
                }
            });
        });

        $('#company_contact').on('click', '.remove-contact', function() {
            $(this).closest('.contact-block').remove();
        });


        $('#company-form').on('submit', function(e) {
            let isValid = true;

            $('#registration_number').val($('#registration_number').val().replace(/\D/g, ''));
            $('#phone').val($('#phone').val().replace(/\D/g, ''));

            $('#company-form .is-invalid').removeClass('is-invalid');

            $('#company-form [required]').each(function() {
                if (!$(this).val()) {
                    $(this).addClass('is-invalid');
                    isValid = false;
                }
            });

            if (!isValid) {
                e.preventDefault();
                openError(
                    '<div class="alert alert-danger" role="alert">Preencha todos os campos obrigatórios.</div>',
                    'Erro de validação');
                return false;
            }

            $.ajax({
                url: "{{ route('companies.store') }}",
                method: "POST",
                data: $('#company-form').serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                },
                success: function(response) {
                },
                error: function(xhr) {
                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        let list = '<ul class="mb-0">';
                        Object.keys(errors).forEach(function(field) {
                            errors[field].forEach(function(msg) {
                                list += `<li>${msg}</li>`;
                            });
                            // marcar campo
                            const $field = $(`[name="${field}"]`);
                            if ($field.length) $field.addClass('is-invalid');
                        });
                        list += '</ul>';
                        openError(`<div class="alert alert-danger" role="alert">${list}</div>`,
                            'Erros de validação');
                    } else {
                        // outros erros
                        const msg = xhr.responseJSON?.message ||
                            'Ocorreu um erro inesperado. Tente novamente.';
                        openError(`<p>${msg}</p>`);
                    }
                },
                complete: function() {
                    $btn.prop('disabled', false);
                }
            });
        });
    </script>
@stop
