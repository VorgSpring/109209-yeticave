<main class="main">
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($data['product_category'] as $item): ?>
                <li class="nav__item">
                    <a href="./?category_id=<?= $item['id'] ?>"><?= $item['name'] ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <form class="form container <?= $data['errors']? 'form--invalid': '' ?>"
          enctype="multipart/form-data" action="sign-up.php" method="post">
        <h2>Регистрация нового аккаунта</h2>
        <div class="form__item <?= $data['errors']['email']? 'form__item--invalid': '' ?>">
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail" required>
            <span class="form__error"><?= $data['errors']['email'] ?></span>
        </div>
        <div class="form__item <?= $data['errors']['password']? 'form__item--invalid': '' ?>">
            <label for="password">Пароль*</label>
            <input id="password" type="text" name="password" placeholder="Введите пароль" required>
            <span class="form__error"><?= $data['errors']['password'] ?></span>
        </div>
        <div class="form__item <?= $data['errors']['name']? 'form__item--invalid': '' ?>">
            <label for="name">Имя*</label>
            <input id="name" type="text" name="name" placeholder="Введите имя" required>
            <span class="form__error"><?= $data['errors']['name'] ?></span>
        </div>
        <div class="form__item <?= $data['errors']['contacts']? 'form__item--invalid': '' ?>">
            <label for="contacts">Контактные данные*</label>
            <textarea id="contacts" name="contacts" placeholder="Напишите как с вами связаться" required></textarea>
            <span class="form__error"><?= $data['errors']['contacts'] ?></span>
        </div>
        <div class="form__item form__item--file form__item--last <?= $data['errors']['image']? 'form__item--invalid': '' ?>">
            <label>Изображение</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="../img/avatar.jpg" width="113" height="113" alt="Изображение лота">
                </div>
            </div>
            <div class="form__input-file">
                <input class="visually-hidden" name="image" type="file" id="photo2" value="">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>
            <span class="form__error"><?= $data['errors']['image'] ?></span>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="login.php">Уже есть аккаунт</a>
    </form>
</main>