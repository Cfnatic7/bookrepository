const chooseLoginOnCLick = () => {
    let main = document.getElementById('main');
    main.innerHTML = 
    `<form class = 'login-form' method="POST"> 
        <div> 
            <span>Username</span>
            <input type="text" name="username"
            minlength="8" required>
        </div>
        <div>
            <span>Password</span>
            <input type="password" name="password" 
            minlength="8" required>
        </div>
        <div>
            <button type="submit" id="login">Login</button>
        </div>
    </form>`
}

const chooseRegisterOnClick = () => {
    let main = document.getElementById('main');
    main.innerHTML = 
    `<form class = 'register-form' method="POST"> 
        <div> 
            <span>Name</span>
            <input type="text" name="username"
            minlength="2" required>
        </div>
        <div> 
            <span>Surname</span>
            <input type="text" name="username"
            minlength="2" required>
        </div>
        <div> 
            <span>email</span>
            <input type="email" name="username"
            required>
        </div>
        <div> 
            <span>Username</span>
            <input type="text" name="username"
            minlength="8" required>
        </div>
        <div>
            <span>Password</span>
            <input type="password" name="password" 
            minlength="8" required>
        </div>
        <div>
            <button type="submit" id="register">Register</button>
        </div>
    </form>`
}