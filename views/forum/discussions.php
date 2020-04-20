<section class="discussions">
    <div class="top-discussions">
        <header class="main-header">
            <h2 class="seventeen bold white">Топ разделов</h2>
            <img src="/resource/img/star.png">
        </header>
        <div class="disc-themes">
            <div class="theme">
                <div class="theme-img">
                    <img src="/resource/img/81-705.png">

                </div>
                <h3 class="white seventeen regular">Изменения & Обновления</h3>
                <ul class="theme-choise">
                        <?php foreach ($cat1['top'] as $Row)
                        echo
                            "<li class='choise-item'><a href='/discussions/section/$Row[ID]'><p class='fifteen light'>$Row[Theme]</p></a></li>";
                        ?>


                </ul>
            </div>
            <div class="theme">
                <div class="theme-img">
                    <img src="/resource/img/81-717.png">
                </div>
                <h3 class="white seventeen  regular">Моды и Аддоны</h3>
                <ul class="theme-choise">
                    <?php echo $cat2['top'] ?>
                </ul>
            </div>
            <div class="theme">
                <div class="theme-img">
                    <img src="/resource/img/81-710.png">
                </div>
                <h3 class="white twenty regular">Игровой процесс</h3>
                <ul class="theme-choise">
                    <?php echo $cat3['top'] ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="discussions-view">
        <header class="main-header">
            <h2 class="seventeen bold white">Все разделы</h2>
            <?php echo $createsect ?>
            <div class="create-block" id="create-block">
                <form method="POST" id="create-sect">
                    <input class="input" type="text" name="theme" placeholder="Введите название раздела" title="от 10 до 100 символов" minlength="10" maxlength="100" required autocomplete="off">
                    <select name="cat" class="select">
                        <option value="1">Изменения & Обновления</option>
                        <option value="2">Моды & Аддоны</option>
                        <option value="3">Игровой Процесс</option>
                    </select>
                    <input type="submit" class="create-btn"  value="Создать">
                </form>
            </div>
        </header>

        <div class="category">
            <div class="category-header">
                <p class="white twenty bold">Изменения & Обновления</p>
            </div>
            <?php echo $cat1['all'] ?>
            </div>

        <div class="category">
            <div class="category-header">
                <p class="white twenty bold">Моды & Аддоны</p>
            </div>
            <?php echo $cat2['all'] ?>
        </div>

    <div class="category">
        <div class="category-header">
            <p class="white twenty bold">Игровой Процесс</p>
        </div>
        <?php echo $cat3['all'] ?>
    </div>
</section>
