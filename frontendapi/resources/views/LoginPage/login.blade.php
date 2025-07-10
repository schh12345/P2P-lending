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
            @if ($errors->any())
                <div style="color:red;">
                    @foreach ($errors->all() as $error)
                        <p>{{$error}}</p>
                    @endforeach
                </div>

            @endif
          <div class="form">
            <form class="login-form" method="POST" action="/login">
                @csrf
              <input type="text" name="email" placeholder="email"/>
              <input type="password" name="password" placeholder="password"/>
              <button type="submit">login</button>
              <p class="message">Not registered? <a href="register">Create an account</a></p>
            </form>
          </div>
        </div>
    </body>
</html>
