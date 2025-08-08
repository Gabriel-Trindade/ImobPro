@extends('adminlte::page')

@section('title', 'Dashboard')

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('content_header')
    @if (isset($company))
        <h1>Editar Empresa</h1>
    @else
        <h1>Criar Empresa</h1>
    @endif
@stop

@section('content')


    <div class="row" id="company_basic_registration">
        <x-adminlte-input name="name" label="Razão Social" placeholder="Razão Social" fgroup-class="col-md-3"
            disable-feedback />
        <x-adminlte-input name="trade_name" label="Nome Fantasia" placeholder="Nome Fantasia" fgroup-class="col-md-3"
            disable-feedback />
        <x-adminlte-input name="registration_number" type="text" label="CNPJ" placeholder="CNPJ"
            fgroup-class="col-md-3" disable-feedback />
    </div>
    <div id="company_contact">
        <h5>Contatos</h5>
        <div class="mt-2">
            <x-adminlte-button id="add-contact" label="Adicionar Contato" theme="success" icon="fas fa-plus" />
        </div>
    </div>

    <div class="row" id="company_address">

    </div>

@stop


@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('input[name="registration_number"]').mask('00.000.000/0000-00', { reverse: true });
            $('input[name="phone"]').mask('(00) 0000-0000');
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
    </script>
@stop
