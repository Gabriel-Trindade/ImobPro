(function() {
  const debounce = (fn, wait=300) => {
    let t; return (...args) => { clearTimeout(t); t = setTimeout(() => fn(...args), wait); };
  };

  const selectCepInputs = () => [
    ...document.querySelectorAll('[data-cep]'),
    ...document.querySelectorAll('#cep'),
    ...document.querySelectorAll('input[name="zip_code"]')
  ];

const getTargets = (root=document) => ({
    street:       root.querySelector('#street')       || document.getElementById('street'),
    neighborhood: root.querySelector('#neighborhood') || document.getElementById('neighborhood'),
    city:         root.querySelector('#city')         || document.getElementById('city'),
    state:        root.querySelector('#state')        || document.getElementById('state'),
    complement:   root.querySelector('#complement')   || document.getElementById('complement')
});

  const fill = (targets, data) => {
    if (targets.street)       targets.street.value = data.logradouro || '';
    if (targets.neighborhood) targets.neighborhood.value = data.bairro || '';
    if (targets.city)         targets.city.value = data.localidade || '';
    if (targets.state)        targets.state.value = data.uf || '';
    if (targets.complement)   targets.complement.value = data.complemento || '';
  };

  const clear = (targets) => fill(targets, {});

  const fetchCep = async (cep) => {
    const resp = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
    if (!resp.ok) throw new Error('CEP request failed');
    const json = await resp.json();
    if (json.erro) throw new Error('CEP inválido');
    return json;
  };

  const onInput = debounce(async (ev) => {
    const input = ev.target;
    const raw = (input.value || '').replace(/\D/g, '');
    if (input.value !== raw) {
      input.value = raw;
    }

    const container = input.closest('form') || document;
    const targets = getTargets(container);

    if (raw.length < 8) { clear(targets); return; }
    if (raw.length > 8) { input.value = raw.slice(0,8); }

    try {
      const data = await fetchCep(raw.slice(0,8));
      fill(targets, data);
    } catch (e) {
      clear(targets);
    }
  }, 400);

  document.addEventListener('input', (ev) => {
    if (!['INPUT','TEXTAREA'].includes(ev.target.tagName)) return;
    const isCep = ev.target.matches('[data-cep], #cep, input[name="zip_code"]');
    if (isCep) onInput(ev);
  });

  window.addEventListener('DOMContentLoaded', () => {
    selectCepInputs().forEach(inp => {
      if ((inp.value || '').replace(/\D/g, '').length === 8) {
        inp.dispatchEvent(new Event('input', { bubbles: true }));
      }
    });
  });
})();
