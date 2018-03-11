<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="views/css/main.css">
    <link rel="stylesheet" href="views/css/bootstrap.min.css">
    <script src="views/js/jquery-3.2.1.min.js"></script>
    <script src="views/js/bootstrap.min.js"></script>
    <script src="views/js/common.js"></script>
    <title><?=$title?></title>
</head>
<body>
    <header>
        <div class="logo col-2">
            <img src="views/images/logo.png">
        </div>
        <div class="title col-5">
            <h3>Добро пожаловать на портал</h3>
        </div>
        <div class="search col-3">
            <form action="" method="get">
                <input name="query" class="search_field" placeholder="поиск">
                <input type="submit" class="search_button">
            </form>
        </div>
        <?php if($_SESSION['auth'] === true || $_COOKIE['auth'] == 1){?>
            <div class="buttons col-2">
                <a href="?page=edit"><?=$additional[0] . ' ' . $additional[1]?></a>
                <a href="?page=logout">Выход</a>
            </div>
        <?php }else{?>
            <div class="buttons col-2">
                <a href="?page=registration">Регистрация</a>
                <span>/</span>
                <a class="login_active" href="?page=login">Вход</a>
            </div>
            <div class="login-form">
                <h5>Войти</h5>
                <form action="<?=$_SERVER['REQUEST_URI']?>" enctype="multipart/form-data" method="post">
                    <div class="form-group login-group">
                        <!---<label for="login_form_login">Логин</label>--->
                        <input type="text" name="LOGIN[LOGIN]" class="form-control <?=$additional['login_login']['STATUS']?>" id="login_form_login" placeholder="Введите логин" value="<?=$_POST['LOGIN']['LOGIN']?>">
                        <div class="invalid-feedback"><?=$additional['login_login']['TEXT']?></div>
                    </div>
                    <div class="form-group pass-group">
                        <!---<label for="login_form_pass">Пароль</label>--->
                        <input type="password" name="LOGIN[PASS]" value="" class="form-control <?=$additional['pass_login']['STATUS']?>" id="login_form_pass" placeholder="Введите пароль">
                        <div class="invalid-feedback"><?=$additional['pass_login']['TEXT']?></div>
                    </div>
                    <div class="form-check">
                        <input name="LOGIN[REMEMBER]" class="form-check-input" type="checkbox" value="Y" id="remember_check">
                        <label class="form-check-label" for="remember_check">
                            Запомнить меня
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Войти</button>
                </form>
            </div>
        <?php }?>
    </header>
    <div class="container">
        <h1><?=$header?></h1>
        <div class="row">
            <?=$content?>
        </div>
    </div>
</body>
</html>