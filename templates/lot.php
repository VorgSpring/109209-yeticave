<main  class="main">
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($data['product_category'] as $item): ?>
                <li class="nav__item">
                    <a href=""><?= $item['name'] ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <section class="lot-item container">
        <h2><?= $data['lot']['name'] ?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="<?= $data['lot']['image_url'] ?>" width="730" height="548"
                            alt="<?= $data['lot']['name'] ?>">
                </div>
                <p class="lot-item__category">Категория: <span><?= $data['lot']['category'] ?></span></p>
                <p class="lot-item__description"><?= $data['lot']['description'] ?></p>
            </div>
            <div class="lot-item__right">
                <div class="lot-item__state">
                    <div class="lot-item__timer timer">
                        <?= lotTimeRemaining() ?>
                    </div>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?= $data['lot']['start_price'] ?></span>
                        </div>
                        <?php if ($data['check']): ?>
                            <div class="lot-item__min-cost">
                                Мин. ставка <span><?= $data['lot']['start_price'] ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if ($data['check']): ?>
                        <form class="lot-item__form <?= $data['errors']? 'form--invalid': '' ?>"
                              action="lot.php?<?= 'id='.$_GET['id']?>" method="post">
                            <p class="lot-item__form-item <?= $data['errors']['cost']? 'form__item--invalid': '' ?>">
                                <label for="cost">Ваша ставка</label>
                                <input id="cost" type="number" name="cost"
                                       min="<?= $data['lot']['start_price'] ?>"
                                       placeholder="<?= $data['lot']['start_price'] ?>">
                                <span class="form__error"><?= $data['errors']['cost'] ?></span>
                            </p>
                            <button type="submit" class="button">Сделать ставку</button>
                        </form>
                    <?php endif; ?>

                </div>
                <div class="history">
                    <h3>История ставок (<span><?= count($data['rates']) ?></span>)</h3>
                    <table class="history__list">
                        <?php foreach ($data['rates'] as $item):?>
                            <tr class="history__item">
                                <td class="history__name"><?= $item['user'] ?></td>
                                <td class="history__price"><?= $item['price'] ?> р</td>
                                <td class="history__time"><?= formatTime($item['date']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>