const form = document.getElementById('form-cadastro');

form.addEventListener('submit', function (event) {

    const descricao = document.getElementById('descricao').value.trim();
    const preco = document.getElementById('preco').value;

    // só avançar caso descrição obrigatória
    if (descricao === '') {
        event.preventDefault();
        alert('A descrição é obrigatória.');
        return;
    }

    // só avançar caso estiver no limite máximo 45 caracteres
    if (descricao.length > 45) {
        event.preventDefault();
        alert('A descrição não pode ter mais de 45 caracteres.');
        return;
    }

    // só avançar se o preço existir
    if (preco === '') {
        event.preventDefault();
        alert('O preço é obrigatório.');
        return;
    }

    // só avançar se o numero for maior que zero
    if (Number(preco) <= 0) {
        event.preventDefault();
        alert('O preço deve ser maior que zero.');
        return;
    }

});