@php $i = $index ?? 0; @endphp
<div class="contact-block row mb-2" data-index="{{ $i }}">
    <x-adminlte-input name="contacts[{{ $i }}][phone]" type="text" label="Telefone" fgroup-class="col-md-3" />
    <x-adminlte-input name="contacts[{{ $i }}][email]" type="email" label="Email" fgroup-class="col-md-3" />
    <x-adminlte-input name="contacts[{{ $i }}][instagram]" type="text" label="Instagram" fgroup-class="col-md-3" />
    <x-adminlte-input name="contacts[{{ $i }}][facebook]" type="url" label="Facebook" fgroup-class="col-md-3" />
    <x-adminlte-input name="contacts[{{ $i }}][olx]" type="url" label="OLX" fgroup-class="col-md-3" />
    <x-adminlte-input name="contacts[{{ $i }}][website]" type="url" label="Site" fgroup-class="col-md-3" />
    <x-adminlte-select name="contacts[{{ $i }}][type]" label="Tipo" fgroup-class="col-md-3">
        <option value="">Selecione o tipo de contato</option>
        <option value="sales">Vendas</option>
        <option value="support">Suporte</option>
        <option value="finances">Financeiro</option>
    </x-adminlte-select>
    <div class="col-md-1 d-flex align-items-end">
        <button type="button" class="btn btn-danger btn-sm remove-contact">Remover</button>
    </div>
</div>
