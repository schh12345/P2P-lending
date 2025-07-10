<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="login-page">
            <div class="form">
                <form class="register-form" method="POST" action="/register">
                    @csrf
                  <input type="text" name="name" placeholder="name"/>
                  <input type="password" name="password" placeholder="password"/>
                  <input type="password" name="password_confirmation" placeholder="confirm password"/>
                  <input type="text" name="email" placeholder="email address"/>
                  <button type="submit">create</button>
                  <p class="message">Already registered? <a href="login">Sign In</a></p>
                </form>
            </div>
        </div>
    </body>
</html>
