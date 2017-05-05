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
    <section class="lot-item container">
        <h1>лот не найден :(</h1>
    </section>
</main>