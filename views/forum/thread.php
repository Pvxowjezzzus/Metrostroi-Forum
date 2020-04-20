<?php
/*/*
    $Param = "SELECT * FROM `answers` WHERE `ThreadID` = '$url' ORDER BY $sort LIMIT $max OFFSET $offset";
    $Result = mysqli_query($connect, $Param);
}*/
?>

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
            <a href='/discussions'><h3 class='white seventeen light'><?=$cat?></h3></a>
            <p class='white'>-></p>
                <a href='/discussions/section/<?=$val['ID']?>'><p class='white seventeen light'><?=$val['Theme']?></p></a>
            <p class='white'>-></p>
            <a><p class='white seventeen light'><?= $thread ?></p></a>
            <?php endforeach; ?>
        </div>
    <a class="back" href='/discussions/section/<?=$val['ID']?>'">
        <img src="/resource/img/back.png">
        <p class="white seventeen">Обратно в выбор тем</p>
    </a>
    <?php foreach ($threadbar as $Thread): ?>
            <div class="thread-header">
                    <div>
                        <p class="twenty blue bold"><?=$thread?></p>
                        <div class="thread-info">
                            <div class='rank_hor'><span class='white regular'><?=$Rank?></span></div>
                            <p class="seventeen blue light">Автор: <?=$Thread['Author']?></p>
                            <p class="seventeen blue light"><?=$Thread['Date']?></p>
                        </div>
                    </div>
     <?php endforeach; ?>
     <?= $threadel ?>
            </div>
    <div class="pagination">
        <?= $pagination ?>
        <div class="sortby">
        <p class="white fifteen regular">Сортировать по:</p>
        <a class="white fifteen light sort-elem" data-type="bystart">Сначала</a>
        <a class="white fifteen light sort-elem" data-type="bylast">Последнее</a>
        <a class="white fifteen light sort-elem" data-type="bypop">Популярные</a>
        </div>
    </div>

    </div>
<!--    --><?php
/*    $count = mysqli_num_rows($Result);
    if ($count > 0) {
        mysqli_query($connect, "UPDATE `threads`  SET `AnswerCount` = '$count' WHERE `ID` = '$Thread[ID]'");
        while ($Answer = mysqli_fetch_assoc($Result)) {
            $User = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '".$Answer['Login']."'"));
            switch ($User['Rank']) {
                case 1:
                    $Rank = 'Главный Амдин';
                    break;
                case 2:
                    $Rank = "Админстратор";
                    break;
                case 3:
                    $Rank = "Модератор";
                    break;
                case 4:
                    $Rank = "Пользователь";
                    break;

            }
            $Text =  nl2br($Answer['Text']);
            $Text =  strpbrk($Answer['Text'], "<img>");
            $Text = str_replace('<br>', '', $Text);
           if(date("d.m.Y", strtotime($Answer['Date'])) == date('d.m.Y')) {
               $date = 'Опубликовано в '.date("H:i", strtotime($Answer['Date']));
           }
            else {
                $date = 'Опубликовано '.$Answer['Date'];
            }

            echo "   <div class='respond-block'> 
                     <div class='main-respond'>                                             
                            <div class='answ-info'>";
            if (isset($_SESSION['USER_LOGIN_IN']) && $_SESSION['USER_LOGIN'] == $Answer['Login'])
                echo "<a><p class=\"seventeen blue bold nickname\">$Answer[Login]</p>
                      <img class='avatar' src='/resource/avatar/$User[Avatar].jpg'></a>";

            else echo "<a href='/profile/$Answer[Login]'><p class=\"seventeen blue bold nickname\">$Answer[Login]</p>
                                    <img class='avatar' src='/resource/avatar/$User[Avatar].jpg'>
                                 </a>";
                                 echo "
                                <p class=\"seventeen blue light\">$Rank</p>    
                                <hr>
                                   <p class='fifteen blue light'>$User[Posts] Обсуждений</p>        
                                   <span class='rep'><p class='ten regular'>Репутация $User[Rep]</p></span>   
                            </div>  
                          
                            <div class='answer'>
                                <p class=\"seventeen light_gray light\">$date</p>
                                <span>$Text</span>
                             </div>
                         </div>   ";
                        if($_SESSION['USER_LOGIN_IN'] && $_SESSION['USER_RANK'] <= 2 || $_SESSION['USER_LOGIN'] == $Answer['Login']) {
                            echo "<div class='controls'>
                                <button class='remove-answ' data-answid='$Answer[ID]'>Удалить</button>";

                        }
                        else  echo ' <div class=\'controls\'>';
                      if($Answer['Login'] == $_SESSION['USER_LOGIN'])
                          echo "                         
                               <button id='edit'>Изменить ответ</button>";
            if($Answer['Login'] != $_SESSION['USER_LOGIN'])
                echo "  
                               <span class='like-block'>   
                                    <p id='$Answer[ID]' class='seventeen blue light'>$Answer[Thumbup]</p>                           
                                    <img  data-uid='$_SESSION[USER_ID]' data-aid='$Answer[ID]' data-authorid='$Answer[Login]' class='like' id='like' src='/resource/img/thumb.png'>                                                                
                                </span>
                            </div>                  
                        </div>
                     </div>  ";

                    else echo "  
                             </div>                  
                        </div>
                     </div> ";
        }
    }
    else {
        echo '<p class="white seventeen regular">Ни одного ответа</p>';
    }
    if ($_SESSION['USER_LOGIN_IN'] == 1) {
    echo "
   <div class=\"forum-answer\">
       <img class='answer-avatar' src='/resource/avatar/$_SESSION[USER_AVATAR].jpg'>
         <div class='answer-area'>    
         <input type='hidden'>
            <div class='answer' id='answer'></div>
            <form id=\"upload\" enctype=\"multipart/form-data\">
               <input type=\"file\" name=\"picture\" id='picture' accept='image/jpeg, image/png, image/gif'>
            </form>
        </div>              
        <button id='send-answer' data-tid='$Thread[ID]' class=\"answer-btn\">Ответить</button>
    </div>";

    }
    */?>
    <div class="pagination"> <?php echo $pagination ?></div>
</section>
<?php echo $quill ?>

