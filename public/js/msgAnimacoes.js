  const mensagem = document.getElementById('mensagem');

        if (mensagem) {

            setTimeout(() => {
                mensagem.classList.add('ocultar');
            }, 3000);

            setTimeout(() => {
                mensagem.remove();
            }, 3500);
        }