
// Aggiungi un gestore di eventi ai pulsanti "Login" e "Annulla"
const loginButton = document.querySelector('.loginBtn');
const cancelButton = document.querySelector('.cancelBtn');

loginButton.addEventListener('click', toggleLoginForm);
cancelButton.addEventListener('click', toggleLoginForm);


// Funzione per gestire il click sul pulsante di login
function toggleLoginForm() {
    const loginForm = document.getElementById('loginForm');
    // Verifica se il modulo di login è attualmente visibile
    if (loginForm.style.display === 'none') {
        // Se è nascosto, mostra il modulo di login
        loginForm.style.display = 'block';
    } else {
        // Altrimenti, nascondi il modulo di login
        loginForm.style.display = 'none';
    }
}

