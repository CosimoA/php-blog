
const createPostForm = document.querySelector('#createPost form');


const loginButton = document.querySelector('.loginBtn');
const cancelBtnLogin = document.querySelector('.cancelBtnLogin');

const createButton = document.querySelector('.createBtn');
const cancelBtnCreate = document.querySelector('.cancelBtnCreate');


loginButton.addEventListener('click', toggleLoginForm);
cancelBtnLogin.addEventListener('click', toggleLoginForm);

createButton.addEventListener('click', toggleCreatePost);
cancelBtnCreate.addEventListener('click', toggleCreatePost);


// Funzione per gestire il click sul pulsante di login
function toggleLoginForm() {
    const loginForm = document.getElementById('loginForm');
    // Verifica se il modulo di login è attualmente visibile
    if (loginForm.style.display === 'block') {
        // Se è nascosto, mostra il modulo di login
        loginForm.style.display = 'none';
    } else {
        // Altrimenti, nascondi il modulo di login
        loginForm.style.display = 'block';
    }
}

// Funzione per gestire il click sul pulsante di New Post
function toggleCreatePost() {
    const createPost = document.getElementById('createPost');
    // Verifica se il modulo è attualmente visibile
    if (createPost.style.display === 'block') {
        // Se è nascosto, mostra il modulo
        createPost.style.display = 'none';
    } else {
        // Altrimenti, nascondi il modulo
        createPost.style.display = 'block';
    }
}


// Aggiungi un gestore di eventi alla submit del form
createPostForm.addEventListener('submit', function (event) {
    // Ottieni i valori dei campi di input
    const title = document.getElementById('title').value.trim();
    const content = document.getElementById('content').value.trim();

    // Verifica se i campi sono vuoti e mostra un messaggio di errore se necessario
    if (title === '') {
        event.preventDefault(); // Previeni l'invio del form
        document.getElementById('titleError').innerText = 'Inserisci un titolo.';
    }

    if (content === '') {
        event.preventDefault(); // Previeni l'invio del form
        document.getElementById('contentError').innerText = 'Inserisci il contenuto.';
    }
});




