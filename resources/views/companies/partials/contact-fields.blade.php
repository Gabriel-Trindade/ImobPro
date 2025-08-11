@php
    $i = $index ?? 0;
    $c = $contact ?? [];
@endphp

<div class="contact-block row g-3 align-items-end mb-2" data-index="{{ $i }}">
    <x-adminlte-input name="contacts[{{ $i }}][phone]" type="text" label="Telefone" value="{{ $c['phone'] ?? '' }}" fgroup-class="col-md-3" />
    <x-adminlte-input name="contacts[{{ $i }}][email]" type="email" label="Email" value="{{ $c['email'] ?? '' }}" fgroup-class="col-md-3" />
    <x-adminlte-input name="contacts[{{ $i }}][instagram]" type="text" label="Instagram" value="{{ $c['instagram'] ?? '' }}" fgroup-class="col-md-3" />
    <x-adminlte-input name="contacts[{{ $i }}][facebook]" type="url" label="Facebook" value="{{ $c['facebook'] ?? '' }}" fgroup-class="col-md-3" />
    <x-adminlte-input name="contacts[{{ $i }}][olx]" type="url" label="OLX" value="{{ $c['olx'] ?? '' }}" fgroup-class="col-md-3" />
    <x-adminlte-input name="contacts[{{ $i }}][website]" type="url" label="Site" value="{{ $c['website'] ?? '' }}" fgroup-class="col-md-3" />

    <x-adminlte-select name="contacts[{{ $i }}][type]" label="Tipo" fgroup-class="col-md-3">
        <option value="">Selecione o tipo de contato</option>
        <option value="sales" @selected(($c['type'] ?? '') === 'sales')>Vendas</option>
        <option value="support" @selected(($c['type'] ?? '') === 'support')>Suporte</option>
        <option value="finances" @selected(($c['type'] ?? '') === 'finances')>Financeiro</option>
    </x-adminlte-select>

    <div class="col-md-1">
        <button type="button" class="btn btn-danger btn-sm remove-contact">
            <i class="fas fa-times"></i> Remover
        </button>
    </div>
</div>
