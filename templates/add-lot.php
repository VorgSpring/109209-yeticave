<main class="main">
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($data['product_category'] as $item): ?>
                <li class="nav__item">
                    <a href="all-lots.html"><?= $item ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <form class="form form--add-lot container  <?= $data['errors']? 'form--invalid': '' ?>" enctype="multipart/form-data" action="add.php" method="post">
        <h2>Добавление лота</h2>
        <div class="form__container-two">
            <div class="form__item <?= $data['errors']['name']? 'form__item--invalid': '' ?>">
                <label for="lot-name">Наименование</label>
                <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" required>
                <span class="form__error"><?= $data['errors']['name'] ?></span>
            </div>
            <div class="form__item <?= $data['errors']['category']? 'form__item--invalid': '' ?>">
                <label for="category">Категория</label>
                <select id="category" name="category" required>
                    <option>Выберите категорию</option>
                    <?php foreach ($data['product_category'] as $item): ?>
                        <option><?= $item ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="form__error"><?= $data['errors']['category'] ?></span>
            </div>
        </div>
        <div class="form__item form__item--wide <?= $data['errors']['message']? 'form__item--invalid': '' ?>">
            <label for="message">Описание</label>
            <textarea id="message" name="message" placeholder="Напишите описание лота" required></textarea>
            <span class="form__error"><?= $data['errors']['message'] ?></span>
        </div>
        <div class="form__item form__item--file <?= $data['errors']['file']? 'form__item--invalid': '' ?>">
            <label>Изображение</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
                </div>
            </div>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" name="image" id="photo2">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>
            <span class="form__error"><?= $data['errors']['file'] ?></span>
        </div>
        <div class="form__container-three">
            <div class="form__item form__item--small <?= $data['errors']['lot-rate']? 'form__item--invalid': '' ?>">
                <label for="lot-rate">Начальная цена</label>
                <input id="lot-rate" type="number" name="lot-rate" placeholder="0" required>
                <span class="form__error"><?= $data['errors']['lot-rate'] ?></span>
            </div>
            <div class="form__item form__item--small <?= $data['errors']['lot-step']? 'form__item--invalid': '' ?>">
                <label for="lot-step">Шаг ставки</label>
                <input id="lot-step" type="number" name="lot-step" placeholder="0" required>
                <span class="form__error"><?= $data['errors']['lot-step'] ?></span>
            </div>
            <div class="form__item <?= $data['errors']['lot-date']? 'form__item--invalid': '' ?>">
                <label for="lot-date">Дата завершения</label>
                <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="20.05.2017" required>
                <span class="form__error"><?= $data['errors']['lot-date'] ?></span>
            </div>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Добавить лот</button>
    </form>
</main>
