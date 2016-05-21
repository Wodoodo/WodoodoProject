<div class="travel_wrapper">
<<<<<<< HEAD
	<p class="travel_title">Поиск попутчиков</p>
    <div class="search_form">
        <form action="/services/travel/search" method="POST">
            <div class="search_how">
                <span class="search_title">Я являюсь</span>
                <input type="radio" name="search_whom" value="companion" <?php if ($_GET['search_whom'] == 'companion') echo 'checked'; ?> id="1">
                <label for="1">Попутчиком</label>
                <input type="radio" name="search_whom" value="driver" <?php if ($_GET['search_whom'] == 'driver') echo 'checked'; ?> id="2">
                <label for="2">Водителем</label>
            </div>
            <div class="search_place">
                <span class="search_title">Хочу из</span>
                <input type="text" name="travel_from" maxlength="50" value="<?php if (isset($_GET['travel_from'])) echo $_GET['travel_from'] ?>">
                <span class="search_title">отправиться в</span>
                <input type="text" name="travel_to" maxlength="50" value="<?php if (isset($_GET['travel_to'])) echo $_GET['travel_to'] ?>">
            </div>
            <a href="/services/travel/add" class="add_travel_offer">Добавить предложение</a><input type="submit" value="Начать поиск">
            <a href="/services/travel" class="add_travel_offer">Сбросить фильтр</a>
        </form>
    </div>
    <p class="travel_title">Последние добавленные</p>
    <div class="offers">
        <?php for ($i = 0; $i < $travels->num_rows; $i++){ ?>
        <a href="/services/travel/view?id=<?php echo $travels->rows[$i]['travel_id']; ?>">
            <div class="offer_block">
                <div class="user_image inline-top"><img src="/view/images/users/<?php echo $travels->rows[$i]['user_photo']; ?>" alt=""></div>
                <div class="offer_info inline-top">
                    <div class="upper_info">
                        <div class="offer_whom inline-top"><b>Ищу:</b> <?php echo ($travels->rows[$i]['travel_type'] == 1) ? 'Попутчика' : 'Водителя'; ?></div>
                        <div class="offer_path inline-top"><b>Маршрут:</b> <?php echo $travels->rows[$i]['travel_from'] . ' - ' . $travels->rows[$i]['travel_to']; ?></div>
                    </div>
                    <div class="down_info">
                        <div class="offer_user inline-top"><b>Кто:</b> <?php echo $travels->rows[$i]['user_firstname'] . ' ' . $travels->rows[$i]['user_lastname']; ?></div>
                        <?php if (strlen($travels->rows[$i]['travel_auto']) > 0) { ?>
                        <div class="offer_auto inline-top"><b>Авто:</b> <?php echo $travels->rows[$i]['travel_auto']; ?></div>
                        <div class="offer_place inline-top"><b>Кол-во мест:</b> <?php echo $travels->rows[$i]['travel_free_place'] . '/' . $travels->rows[$i]['travel_all_place']; ?></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </a>
        <?php } ?>
        <?php if ($travels->num_rows == 0) { ?>
        Предложений не найдено
        <?php } ?>
    </div>
=======
	
>>>>>>> 60629290047ef4efe0a2f0b60243d7d2c98df887
</div>