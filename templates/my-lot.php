<main  class="main">
    <section class="lot-item container">
        <h2><?= $data['name'] ?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="<?= $data['image_url'] ?>" width="730" height="548"
                         alt="<?= $data['name'] ?>">
                </div>
                <p class="lot-item__category">Категория: <span><?= $data['category'] ?></span></p>
                <p class="lot-item__description"><?= $data['description'] ?></p>
            </div>
            <div class="lot-item__right">
                <div class="lot-item__state">
                    Дата завершения:
                    <div class="lot-item__timer lot-item__timer--date timer">
                        <?= $data['date'] ?>
                    </div>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Начальная цена</span>
                            <span class="lot-item__cost"><?= $data['price'] ?></span>
                        </div>
                        <div class="lot-item__min-cost">
                            Шаг ставки <span><?= $data['step'] ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>