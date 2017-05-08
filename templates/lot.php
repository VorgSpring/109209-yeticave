<main  class="main">
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($data['product_category'] as $item): ?>
                <li class="nav__item">
                    <a href=""><?= $item ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <section class="lot-item container">
        <h2><?= $data['data_ads'][$_GET['id']]['name'] ?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="<?= $data['data_ads'][$_GET['id']]['image_url'] ?>" width="730" height="548"
                            alt="<?= $data['data_ads'][$_GET['id']]['name'] ?>">
                </div>
                <p class="lot-item__category">Категория: <span><?= $data['data_ads'][$_GET['id']]['category'] ?></span></p>
                <p class="lot-item__description"><?= $data['data_ads'][$_GET['id']]['description'] ?></p>
            </div>
            <div class="lot-item__right">
                <div class="lot-item__state">
                    <div class="lot-item__timer timer">
                        <?= lotTimeRemaining() ?>
                    </div>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?= $data['data_ads'][$_GET['id']]['price'] ?></span>
                        </div>
                        <?php if (checkCookieAndAuthorization()): ?>
                            <div class="lot-item__min-cost">
                                Мин. ставка <span><?= $data['data_ads'][$_GET['id']]['price'] ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if (checkCookieAndAuthorization()): ?>
                        <form class="lot-item__form <?= $data['errors']? 'form--invalid': '' ?>"
                              action="lot.php?<?= 'id='.$_GET['id']?>" method="post">
                            <p class="lot-item__form-item <?= $data['errors']['cost']? 'form__item--invalid': '' ?>">
                                <label for="cost">Ваша ставка</label>
                                <input id="cost" type="number" name="cost"
                                       min="<?= $data['data_ads'][$_GET['id']]['price'] ?>"
                                       placeholder="<?= $data['data_ads'][$_GET['id']]['price'] ?>">
                                <span class="form__error"><?= $data['errors']['cost'] ?></span>
                            </p>
                            <button type="submit" class="button">Сделать ставку</button>
                        </form>
                    <?php endif; ?>

                </div>
                <div class="history">
                    <h3>История ставок (<span><?= count($data['bets']) ?></span>)</h3>
                    <table class="history__list">
                        <?php foreach ($data['bets'] as $item):?>
                            <tr class="history__item">
                                <td class="history__name"><?= $item['name'] ?></td>
                                <td class="history__price"><?= $item['price'] ?> р</td>
                                <td class="history__time"><?= formatTime($item['ts']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>