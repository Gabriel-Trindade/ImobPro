<x-adminlte-modal id="modalSuccess" title="Sucesso!" size="lg" theme="teal" icon="fas fa-bell" v-centered
    static-backdrop scrollable>
    <div style="height:800px;" id="modalSuccessContent"></div>
    <x-slot name="footerSlot">
        <x-adminlte-button class="mr-auto" theme="success" label="Accept" />
    </x-slot>
</x-adminlte-modal>


<x-adminlte-modal id="modalError" title="Erro!" theme="purple" icon="fa-solid fa-xmark" size='lg'
    disable-animations>
    <div style="height:800px;" id="modalErrorContent"></div>
    <x-slot name="footerSlot">
        <x-adminlte-button class="mr-auto" theme="success" label="Accept" />
    </x-slot>
</x-adminlte-modal>


<script>
    function openSuccess(contentHtml, title = 'Sucesso!') {
        $('#modalSuccess .modal-title').text(title);
        $('#modalSuccessContent').html(contentHtml);
        $('#modalSuccess').modal('show');
    }

    function openError(contentHtml, title = 'Erro!') {
        $('#modalError .modal-title').text(title);
        $('#modalErrorContent').html(contentHtml);
        $('#modalError').modal('show');
    }

</script>
