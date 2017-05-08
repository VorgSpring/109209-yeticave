<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($data['product_category'] as $item): ?>
                <li class="nav__item">
                    <a href="all-lots.html"><?= $item ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <form class="form container  <?= $data['errors']? 'form--invalid': '' ?>" action="login.php" method="post">
        <h2>Вход</h2>
        <div class="form__item <?= $data['errors']['email']? 'form__item--invalid': '' ?>">
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail" required>
            <span class="form__error"><?= $data['errors']['email'] ?></span>
        </div>
        <div class="form__item form__item--last <?= $data['errors']['password']? 'form__item--invalid': '' ?>">
            <label for="password">Пароль*</label>
            <input id="password" type="password" name="password" placeholder="Введите пароль" required>
            <span class="form__error"><?= $data['errors']['password'] ?></span>
        </div>
        <button type="submit" class="button">Войти</button>
    </form>
</main>