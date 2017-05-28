<header class="main-header">
    <div class="main-header__container container">
        <h1 class="visually-hidden">YetiCave</h1>
        <a <?= (!$data['is_start_page'])? 'href="./"': '' ?> class="main-header__logo">
            <img src="img/logo.svg" width="160" height="39" alt="Логотип компании YetiCave">
        </a>
        <form class="main-header__search" method="get" action="/">
            <input type="search" name="search" placeholder="Поиск лота">
            <input class="main-header__search-btn" type="submit" value="Найти">
        </form>

        <?php if (isset($_SESSION['user'])): ?>
            <a class="main-header__add-lot button" href="add.php">Добавить лот</a>
        <?php endif; ?>

        <nav class="user-menu">
            <?php if (!isset($_SESSION['user'])): ?>
                <ul class="user-menu__list">
                    <li class="user-menu__item">
                        <a href="sign-up.php">Регистрация</a>
                    </li>
                    <li class="user-menu__item">
                        <a href="login.php">Вход</a>
                    </li>
                </ul>
            <?php else: ?>
                <a href="my-lots.php" class="user-menu__image">
                    <img src="<?=strip_tags($_SESSION['user']['avatar']);?>" width="40" height="40" alt="Пользователь">
                </a>
                <div class="user-menu__logged">
                    <p><?=strip_tags($_SESSION['user']['name']);?></p>
                    <a href="logout.php">Выйти</a>
                </div>
            <?php endif; ?>
        </nav>
    </div>
</header>
