const loginForm = document.getElementById('login-form');
const registerForm = document.getElementById('register-form');
const welcomeText = document.getElementById('welcome-text');

loginForm.style.display = 'none';
registerForm.style.display = 'none';




const chooseLoginOnCLick = () => {
    welcomeText.style.display = 'none';
    registerForm.style.display = 'none';
    loginForm.style.display = 'flex';
}

const chooseRegisterOnClick = () => {
    let main = document.getElementById('main');
    welcomeText.style.display = 'none';
    loginForm.style.display = 'none';
    registerForm.style.display = 'flex';
}