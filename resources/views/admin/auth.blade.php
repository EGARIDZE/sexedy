@extends('admin.layouts.admin-app')

@section('content')
<main>
    <section class="content">
        <div class="page-announce valign-wrapper"><a href="#" data-activates="slide-out"
                class="button-collapse valign hide-on-large-only"><i class="material-icons">menu</i></a>
            <h1 class="page-announce-text valign">// Login </h1>
        </div>
        <div class="container">
            <div class="row">
                <form id="login_form" class="col s12">
                    @csrf
                    <div class="row">
                        <h4>Введите логин и пароль</h4>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="email" name="email" maxlength="200" >
                                <label for="text">Email </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="password" name="password" maxlength="200" >
                                <label for="text">Пароль </label>
                            </div>
                        </div>
                    </div>
                    <div style="color:red" id="errors" class="red-text"></div>
                    <div class="center-align"><input class="btn btn-success" type="submit" value="Войти"></div>
                </form>
            </div>
        </div>
    </section>
</main>
@endsection

@section('api_representation')
<script>
document.addEventListener('DOMContentLoaded', (event) => {
    const loginForm = document.getElementById('login_form');
    loginForm.addEventListener('submit', (event) => {
        event.preventDefault();

        const newFormData = new FormData(loginForm);

        const email = newFormData.get('email');
        const password = newFormData.get('password');

        const loginUrl = "http://localhost/shop/public/api/login";

        fetch(loginUrl, {
            method: 'POST',
            body: newFormData
        })
        .then(response => response.json())
        .then(data => {
            console.log('Ответ: ', data);
            if (data.status == "success") {
                // window.location.href = `http://localhost/shop/public/admin/dashboard`;
            } else {
    
                const errors = document.getElementById('errors');
                errors.innerHTML = data.message;
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
        });
    });
});
</script>
@endsection