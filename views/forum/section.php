<section>
    <?php foreach ($path as $val):
    switch ($val['Category']) {
        case 1:
            $cat = "Изменения и обновления";
            break;
        case 2:
            $cat = "Моды и аддоны";
            break;
        case 3:
            $cat = "Игровой процесс";
            break;
    }?>
    <div class='path'>
        <a href='/discussions'><p class='white seventeen light'>Обсуждения</p></a>
        <p class='white'>-></p>
        <a href='/discussions'><p class='white seventeen light'><?php echo $cat ?></p></a>
        <p class='white'>-></p>
        <a href='/discussions/section/<?php echo $val['ID'] ?>'><p class='white seventeen light'><?php echo $val['Theme'] ?></p></a>
        <?php endforeach; ?>
    </div>
<div class="threads">
    <div class="threads-header">
        <h3 class="white seventeen bold"><?=$val['Theme']?></h3>
        <?php echo $createthread?>
    </div>
    <div class="modal">
        <div class="modal_content">
            <div class="form">
                <button class="close-modal btn">&times;</button>
                <div class="modal_header">
                    <h3 class="white twenty bold">Создание обсуждения</h3>
                    <p class="white fifteen light">Вы создаёте обсуждение в "<?=$val['Theme']?>"</p>
                    <p id="msg" class="seventeen regular"></p>
                </div>
                <form class="thread-form"  class="auth" method="post">
                    <input class="input" type="text" placeholder="Тема обсуждения" id='thread' autocomplete="off">
                        <div class='answer-area'>
                            <div class='answer' id='answer'></div>
                        </div>
                    <input type="hidden" value="<?=$val['ID']?>" id="section">
                    <button class="create-btn" type="submit" id="create-thread">Создать</button>
                </form>
                <form id="upload" enctype="multipart/form-data">
                    <input type="file" name="picture" id='picture' accept='image/jpeg, image/png, image/gif'>
                </form>
            </div>
        </div>
    </div>
    <?=$threads?>
</div>
</section>
<?php echo $quill?>
