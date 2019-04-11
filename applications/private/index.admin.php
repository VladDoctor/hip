<?php

  require_once '../../settings/php.settings.php';
  require_once '../../conf.php';
  require_once '../../databases/connect.php';
  require_once '../../library/php.php';
  
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GitRes | Admin panel</title>
    <link rel="stylesheet" href="/styles/normalize.css">
    <link rel="stylesheet" href="/styles/style.admin.min.css">
    <script src="/library/jquery-3.3.1.min.js"></script>
</head>
<body>
<nav>
    <ul>
        <li class="nav-items active" id="list-btn"><a href="#" title="Список Заведений"><img src="/images/admin/icons/items.svg" width="32" alt="Список Заведений"></a></li>
        <li class="nav-items" id="addPub-btn"><a href="#" title="Добавить Заведение"><img src="/images/admin/icons/add.svg" width="32" alt="Добавить Заведение"></a></li>
        <li class="nav-items" id="addMenu-btn"><a href="#" title="Добавить меню"><img src="/images/admin/icons/add.svg" width="32" alt="Добавить меню"></a></li>
        <li class="nav-items" id="settings-btn"><a href="#" title="Настройки"><img src="/images/admin/icons/setting.svg" width="32" alt="Настройки"></a></li>
        <font style="font-family: 'Roboto', sans-serif; margin-top: 55vh;"><hr style="border: 1px #f9476c solid;">GitRes AP</font>
    </ul>
</nav>
<main>
    <!-- Список Заведений -->
    <section id="list">
        <br>
        <h1>Список Заведений</h1>
    </section>
    <!-- ./Список Заведений -->
    <!-- Добавить Заведение -->
    <section id="addPub">
    <form action="../../controllers/controller.new_inst.php" method="POST" enctype="multipart/form-data" class="addPub">
        <div class="inputs">
            <br>
            <h1>Добавить Заведение</h1>
            <div class="city">
                <h4>Город</h4>
                <select type="text" name="city_inst" class="city_inst" required>
                    <option value="Нукус">Нукус</option>
                    <option value="Ходжейли">Ходжейли</option>
                    <option value="Тахия-таш">Тахия-таш</option>
                    <option value="Кунград">Кунград</option>
                </select>
            </div>
            <div class="category">
                <h4>Категория</h4>
                <select type="text" name="category_inst" class="category_inst" required>
                    <option value="Рестораны">Рестораны</option>
                    <option value="Фаст-фуды">Фаст-фуды</option>
                    <option value="Бары/пабы">Бары/пабы</option>
                </select>
            </div>
            <br>
            <div class="name">
                <h4>Название Заведения</h4>
                <input type="text" name="name_inst" class="name_inst" placeholder="Например: Premier Lounge" required>
            </div>
            <div class="adress">
                <h4>Адрес</h4>
                <input type="text" name="addr_inst" class="addr_inst" placeholder="Адрес" required>
            </div>
            <div class="features">
                <h4>Особенности</h4>
                <input type="text" name="feat_inst" class="feat_inst" id="features" placeholder="Еда на вынос, Доставка" required>
            </div>
            <div class="contacts">
                <h4>Контакты</h4>
                <input type="text" name="cont_inst" class="cont_inst" placeholder="Номер телефона" required>
                <input type="text" name="cont_snd_inst" class="cont_snd_inst" placeholder="Второй номер(не обязательно)">
                <h4>Режим работы</h4>
                <input type="text" name="wk_time_inst" class="wk_time_inst" placeholder="Например: Пн-Чт с 12:00 до 22:00" required>
            </div>
        </div>
        <div class="images">
            <br>
            <h1>Фотографии</h1>
            <div class="imgLogo">
                <h4>Логотип</h4>
                <input type="file" name="photo_logo" id="photo_logo" accept="image/jpeg, image/png" title="" required>
            </div>
            <div class="img">
                <h4>Изображение для превью</h4>
                <input type="file" name="photo_rew" id="photo_rew" accept="image/jpeg, image/png" title="" required>
            </div>
            <div class="img">
                <h4>Фотогалерея</h4>
                <input type="file" name="photo_one" id="photo_one" accept="image/jpeg, image/png" title="" required>
                <input type="file" name="photo_two" id="photo_two" accept="image/jpeg, image/png" title="" required>
                <input type="file" name="photo_three" id="photo_three" accept="image/jpeg, image/png" title="" required>
            </div>
            <button type="submit" name="large-btn-reg" class="large-btn" id="large-btn-reg">Добавить Заведение</button>
            <!-- Upload photos -->
            <!--<script>
                $(document).ready(function(){
                    
                    $('#large-btn-reg').on('click', function(){
                        let city_inst = $('.city_inst').val();
                        let category_inst = $('.category_inst').val();
                        let name_inst = $('.name_inst').val();
                        let addr_inst = $('.addr_inst').val();
                        let feat_inst = $('.feat_inst').val();
                        let cont_inst = $('.cont_inst').val();
                        let cont_snd_inst = $('.cont_snd_inst').val();
                        let wk_time_inst = $('.wk_time_inst').val();

                        let photo_logo = $('#photo_logo').prop('files')[0];
                        let photo_rew = $('#photo_rew').prop('files')[0];
                        let photo_one = $('#photo_one').prop('files')[0];
                        let photo_two = $('#photo_two').prop('files')[0];
                        let photo_three = $('#photo_three').prop('files')[0];
                        let form_data = new FormData();
                        form_data.append('photo_logo', photo_logo);
                        form_data.append('photo_rew', photo_rew);
                        form_data.append('photo_one', photo_one);
                        form_data.append('photo_two', photo_two);
                        form_data.append('photo_three', photo_three);
                        //let photo_logo = $('.photo_logo').val();
                        //let photo_rew = $('.photo_rew').val();
                        //let photo_one = $('.photo_one').val();
                        //let photo_two = $('.photo_two').val();
                        //let photo_three = $('.photo_three').val();
                        $.ajax({
                            method: "POST",
                            url: "/controllers/controller.new_inst.php",
                    /**/    //dataType: 'text',
                    /**/    //cache: false,
                    /**/    //contentType: false,
                    /**/    processData: false,
                            data: { 
                                city_inst: city_inst,
                                category_inst: category_inst,
                                name_inst: name_inst, 
                                addr_inst: addr_inst, 
                                feat_inst: feat_inst, 
                                cont_inst: cont_inst, 
                                cont_snd_inst: cont_snd_inst,
                                wk_time_inst: wk_time_inst,
                        /**/    form_data: form_data 
                                }
                       /**/ //type: 'post',
                       /**/ //success: function(php_script_response){
                            //    alert(php_script_response);
                            //}
                            });
                            //.done(function( msg ) {
                            //  alert( "Data Saved: " + msg );
                            //  });
                            $.ajax({
                               url: '/logs/php/log_new_inst.txt',
                               dataType: 'text',
                               success: function (data) {
                                    console.log(data);
                                }
                            });
                        $('.city_inst').val('');
                        $('.category_inst').val('');
                        $('.name_inst').val('');
                        $('.addr_inst').val('');
                        $('.feat_inst').val('');
                        $('.cont_inst').val('');
                        $('.cont_snd_inst').val('');
                        $('.wk_time_inst').val('');
                  });
                    
               });
            </script>-->
        </div>
    </form>
    </section>
    <!-- ./Добавить Заведение -->
    <!-- Добавить Меню -->
    <section id="addMenu">
        <br>
        <h1>Добавить Меню</h1>
    </section>
    <!-- ./Добавить Меню -->
    <!-- Настройки -->
    <section id="settings" class="current">
        <div class="settings">
            <br>
            <h1>Консоль</h1>
            <textarea name="" class="ta_console" cols="30" rows="10" placeholder="">
            </textarea>
            <input type="text" class="cns_input" placeholder="$">
            <button class="large-btn">Отправить</button>
        </div>
        <script>
           $(document).ready(function(){

              $('.large-btn').on('click', function(){

                let cns_input = $('.cns_input').val();
                $.ajax({
                    method: "POST",
                    url: "/controllers/controller.ad_console.php",
                    data: { cns_input: cns_input }
                    })
                    //.done(function( msg ) {
                    //  alert( "Data Saved: " + msg );
                    //  });
                    $.ajax({
                        url: '/logs/php/log_answ.txt',
                        dataType: 'text',
                        success: function (data) {
                            $('.ta_console').val(data);
                            console.log(data);
                            }
                        });
                    $('.cns_input').val('');
              });

           });
        </script>
    </section>
    <!-- ./Настройки -->
</main>
<!-- Javascripts -->
<script src="/js/script.js"></script>
<script src="/js/admin.js"></script>
</body>
</html>