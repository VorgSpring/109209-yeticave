<main class="main">
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($data['product_category'] as $item): ?>
                <li class="nav__item">
                    <a href=""><?= $item ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <section class="rates container">
        <h2>Мои ставки</h2>
        <?php if (!empty($data['my_rates'])): ?>
            <table class="rates__list">
                <?php foreach ($data['my_rates'] as $item): ?>
                    <tr class="rates__item">
                        <td class="rates__info">
                            <div class="rates__img">
                                <img src="<?= $item['image'] ?>" width="54" height="40" alt="<?= $item['name'] ?>">
                            </div>
                            <h3 class="rates__title"><a href="lot.php?id=<?= $item['id'] ?>"><?= $item['name'] ?></a></h3>
                        </td>
                        <td class="rates__category">
                            <?= $item['category'] ?>
                        </td>
                        <td class="rates__timer">
                            <div class="timer timer--finishing">07:13:34</div>
                        </td>
                        <td class="rates__price">
                            <?= $item['cost'] ?>
                        </td>
                        <td class="rates__time">
                            <?= formatTime($item['time']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <h3>В данный момент у вас нет ставок</h3>
        <?php endif; ?>
    </section>
</main>