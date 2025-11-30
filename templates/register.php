<?php require 'header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center">Регистрация</h3>
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $result = $auth->register(
                        $_POST['name'],
                        $_POST['email'],
                        $_POST['password'],
                        $_POST['password_confirm']
                    );
                    if ($result === true) {
                        echo '<div class="alert alert-success">Регистрация успешна! Сейчас можно войти.</div>';
                    } else {
                        echo '<div class="alert alert-danger">' . $result . '</div>';
                    }
                }
                ?>
                <form method="post">
                    <div class="mb-3">
                        <label>Имя в чате</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Пароль</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Повторите пароль</label>
                        <input type="password" name="password_confirm" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Зарегистрироваться</button>
                </form>
                <div class="text-center mt-3">
                    Уже есть аккаунт? <a href="index.php?page=login">Войти</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require 'footer.php'; ?>