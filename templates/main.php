<main class="main container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <?php foreach ($data['product_category'] as $item): ?>
                <li class="promo__item promo__item--<?= $item['id'] ?>">
                    <a class="promo__link" href="all-lots.html"><?= $item['name'] ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
            <select class="lots__select">
                <option>Все категории</option>
                <?php foreach ($data['product_category'] as $item): ?>
                    <option><?= $item['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <ul class="lots__list">
            <?php foreach ($data['data_ads'] as $index => $item): ?>
                <li class='lots__item lot'>
                    <div class='lot__image'>
                        <img src="<?= $item['image_url'] ?>" width='350' height='260' alt='фото товара'>
                    </div>
                    <div class='lot__info'>
                        <span class='lot__category'><?= $item['category'] ?></span>
                        <h3 class='lot__title'><a class='text-link' href='lot.php?id=<?= $item['id'] ?>'><?= $item['name'] ?></a></h3>
                        <div class='lot__state'>
                            <div class='lot__rate'>
                                <span class='lot__amount'>Стартовая цена</span>
                                <span class='lot__cost'><?= $item['start_price'] ?><b class='rub'>р</b></span>
                            </div>
                            <div class='lot__timer timer'>
                                <?= lotTimeRemaining() ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
</main>