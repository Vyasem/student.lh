<div class="reg_form col-6">
    <form action="/?page=registration&action=add" method="post" enctype="multipart/form-data">
        <div class="form-group login_group">
            <label for="form_login">Логин</label>
            <input type="text" name="ADD[LOGIN]" class="form-control {$login_group['STATUS']}" id="form_login" placeholder="Введите логин" value="{$_POST['ADD']['LOGIN']}">
            <div class="invalid-feedback">{$login_group['TEXT']}</div>
        </div>
        <div class="form-group pass_group">
            <label for="form_pass">Пароль</label>
            <input type="password" name="ADD[PASS]" value="{$_POST['ADD']['PASS']}" class="form-control {$pass_group['STATUS']}" id="form_pass" placeholder="Введите пароль">
            <div class="invalid-feedback">{$pass_group['TEXT']}</div>
        </div>
        <div class="form-group name_group">
            <label for="form_name">Имя</label>
            <input type="text" name="ADD[NAME]" value="{$_POST['ADD']['NAME']}" class="form-control {$name_group['STATUS']} " id="form_name" placeholder="Введите имя">
            <div class="invalid-feedback">{$name_group['TEXT']}</div>
        </div>
        <div class="form-group surname_group">
            <label for="form_surname">Фамилия</label>
            <input type="text" name="ADD[SURNAME]" value="{$_POST['ADD']['SURNAME']}" class="form-control {$surname_group['STATUS']}" id="form_surname" placeholder="Введите фамилию">
            <div class="invalid-feedback">{$surname_group['TEXT']}</div>
        </div>
        <div class="form-group sex_group">
            <label for="form_sex">Ваш пол</label>
            <select {$sex_group['SEX']} class="form-control" id="form_sex" name="ADD[SEX]">
            <option value="male">Мужской</option>
            <option value="female">Женский</option>
            </select>
            <div class="invalid-feedback">{$sex_group['TEXT']}</div>
        </div>
        <div class="form-group year_group">
            <label for="form_year">Год рождения</label>
            <input type="text" name="ADD[YEAR]" value="{$_POST['ADD']['YEAR']}" class="form-control {$year_group['STATUS']}" id="form_surname" placeholder="Введите год рождения">
            <div class="invalid-feedback">{$year_group['TEXT']}</div>
        </div>
        <div class="form-group visa_group">
            <label for="form_visa">Статус</label>
            <select {$visa_group['VISA']} class="form-control" id="form_visa" name="ADD[VISA]">
            <option value="city">Городской</option>
            <option value="vilage">Иногородний</option>
            </select>
            <div class="invalid-feedback">{$visa_group['TEXT']}</div>
        </div>
        <div class="form-group email_group">
            <label for="form_email">Email</label>
            <input type="text" name="ADD[EMAIL]" value="{$_POST['ADD']['EMAIL']}" class="form-control {$email_group['STATUS']}" id="form_email" placeholder="Введите email">
            <div class="invalid-feedback">{$email_group['TEXT']}</div>
        </div>
        <div class="form-group faculty_group">
            <label for="form_faculty">Факультет</label>
            <input type="text" name="ADD[FACULTY]" value="{$_POST['ADD']['FACULTY']}" class="form-control {$faculty_group['STATUS']}" id="form_faculty" placeholder="Введите факультет">
            <div class="invalid-feedback">{$faculty_group['TEXT']}</div>
        </div>
        <div class="form-group phone_group">
            <label for="form_phone">Телефон</label>
            <input type="text" name="ADD[PHONE]" value="{$_POST['ADD']['PHONE']}" class="form-control {$phone_group['STATUS']}" id="form_phone" placeholder="Введите телефон">
            <div class="invalid-feedback">{$phone_group['TEXT']}</div>
        </div>
        <div class="form-group score_group">
            <label for="form_score">Средний бал успеваемости</label>
            <input type="text" name="ADD[SCORE]" value="{$_POST['ADD']['SCORE']}" class="form-control {$score_group['STATUS']}" id="form_score" placeholder="Введите средний бал успеваемости">
            <div class="invalid-feedback">{$score_group['TEXT']}</div>
        </div>
        <div class="form-group">
            <label for="form_comment">Комментарий</label>
            <input type="text" name="ADD[COMMENT]" value="{$_POST['ADD']['COMMENT']}" class="form-control" id="form_comment" placeholder="Введите комментарий">
            <div class="invalid-feedback"></div>
        </div>
        <button type="submit" class="btn btn-primary">Зарегестрироваться</button>
    </form>
</div>