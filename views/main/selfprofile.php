<link rel="stylesheet" href="/resource/css/croppie.css">
<section class="content-block">
    <div class="modal" id="modal">
        <div class="modal_content">
            <div class="modal_header">
                <h3 class="white">Создание Аватара</h3>
            </div>
            <div class="cropper"></div>
            <button class="submit-avatar stock-btn btn">Создать</button>
        </div>
    </div>

    <div class="tabContainer">
        <div class="buttonContainer">
            <button class="tab-btn first" onclick="showPanel(0)">Профиль</button>
            <button class="tab-btn" onclick="showPanel(1)">Редактирование</button>
            <?= $AdminPanelBtn?>
        </div>
        <div  class="TabPanel">
            <div class="profile-wrapper">
                <div class="profile-avatar"><img  src="<?=$avatar?>">
                    <label for="upload_avatar" class="upload-avatar"></label>
                    <form id="upload" enctype="multipart/form-data">
                        <input type="file" name="upload_avatar" id="upload_avatar"  accept='image/jpeg, image/png, image/gif'/>
                    </form>
                </div>
                    <div class="user-data">
                        <h3 class="white">Данные пользователя</h3>
                        <div>
                            <p class="white">Логин: <?= $_SESSION['USER_LOGIN']?></p>
                            <p class="white">Email: <?= $_SESSION['USER_EMAIL']?></p>
                            <p class="white">Звание: <?= $Rank ?></p>
                            <p class="white">Дата регистрации: <?=$regdate ?></p>
                        </div>
                       <div>
                           <form  method="post" action="/form/logout.php">
                               <input class="stock-btn btn blue" name="logout" type="submit" value="выйти">
                           </form>
                       </div>

                    </div>

                    <div class="user-stats">
                    <h3 class="white">Статистика пользователя</h3>
                    <p class="white">Создал обсуждений: <?=$user['Posts']?> </p>
                        <span class="rep">Репутация: <?= $user['Rep']?></span>
                    </div>
            </div>
        </div>

        <div class="TabPanel">
            <div class="edit-header">
                <h3 class="white twenty">Редактирование профиля</h3>
                <span class="msg white light" id="msg"></span>
            </div>
                <form class="edit-wrapper" id="edit"  method="post">
                    <div>

                        <p class="white">Изменение Логина</p>
                        <input name="login" class="input" type="text" placeholder="Логин" id="login" autocomplete="off">
                        <p class="white">Изменение Email</p>
                        <input name="email" class="input"  type="text" placeholder="Email" id="email" autocomplete="off">
                    </div>
                  <div>
                    <p class="white">Изменение Пароля</p>
                    <input name="oldpasswd" class="input" type="password" placeholder="Старый Пароль" id="oldpasswd" autocomplete="off">
                    <input name="newpasswd" class="input"  type="password" placeholder="Новый Пароль" id="newpasswd" autocomplete="off">
                  </div>
                    <input class="submit-edit btn blue"  type="submit" value="Изменить данные" onclick="edit_query('edit', 'login.email.oldpasswd.newpasswd'); return false">
                </form>
        </div>
        <?= $AdminPanelCont ?>
</section>
<script src="/resource/js/croppie.js"></script>
<script>
    $(document).ready(function(){
        $image_crop = $('.cropper').croppie({
            enableExif: true,
            viewport: {
                width: 160,
                height: 180,
                type: 'square'
            },
            boundary: {
                width: 400,
                height: 360,
                border: 'white'
            }
        })

        $('#upload_avatar').change(function () {

            $('#modal').css('display', 'flex');
            var reader = new FileReader();
            reader.onload = function (event) {
                $image_crop.croppie('bind', {
                    url: event.target.result
                }).then(function () {
                    console.log("Изображение загружено");
                })
            }
            reader.readAsDataURL(this.files[0]);
        })
        var modal = $('#modal');
        $(document).mouseup(function (event) {
            if (modal.is(event.target)) {
                modal.css('display', 'none');
                location.reload();
            }
        })
        $('.submit-avatar').click(function (event) {
            $image_crop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (response) {
                $.ajax({
                    url: '/form/edit.php',
                    type: 'post',
                    cache: false,
                    data: {avatar: response},
                    beforeSend: function () {
                        $('.submit-avatar').attr('disabled', 'true')
                    },
                    success: function (result) {
                        location.reload();
                    }
                })
            })
        })
        })
        var tabButtons = document.querySelectorAll(".tab-btn");
        var tabPanels = document.querySelectorAll(".TabPanel");

        function showPanel(panelIndex, colorCode) {
            tabButtons.forEach(function (node) {
                node.style.backgroundColor = "";
                node.style.color = "";
            });
            tabButtons[panelIndex].style.backgroundColor = '#0d3339';
            tabButtons[panelIndex].style.color = "white";
            tabPanels.forEach(function (node) {
                node.style.display = "none";
            });
            tabPanels[panelIndex].style.display = "block";
            tabPanels[panelIndex].style.backgroundColor = '#0d3339';
        }
        showPanel(0);

    $(document).on( 'click', '.action', function(){
        let btn = $(this);
            let action = btn.data('action');
            let tid = btn.data('tid');

                $.ajax({
                    url: '/form/admin.php',
                    type: 'post',
                    data: {
                        action: action,
                        tid: tid,
                    },
                    success: function (result) {
                        $('.threads-root').load("/profile .threads-root > *");
                    },
                    error: function (error) {
                        console.log('ошибка' + error);
                    }
                })
        })
    $(document).on( 'submit', '.rank-switch', function(e){
        e.preventDefault();
        let data = $(this.rank).val();
        let btn = $(this);
        let uid = btn.data('uid');
        $.ajax({
            url: '/form/admin.php',
            type: 'post',
            data: {
                rank:data,
                uid:uid,
            },
            success: function (result) {
                $('.users-root').load("/profile .users-root > *");
            },
            error: function (error) {
                console.log('ошибка' + error);
            }
        })
    })
</script>
