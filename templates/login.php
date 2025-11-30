<?php require 'header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center">Вход</h3>
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $result = $auth->login($_POST['email'], $_POST['password']);
                    if ($result === true) {
                        redirect('index.php');
                    } else {
                        echo '<div class="alert alert-danger">' . $result . '</div>';
                    }
                }
                ?>
                <form method="post">
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Пароль</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Войти</button>
                </form>
                <div class="text-center mt-3">
                    Нет аккаунта? <a href="index.php?page=register">Зарегистрироваться</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require 'footer.php'; ?>