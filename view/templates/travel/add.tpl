<script type="text/javascript" src="/view/javascripts/travel/addTravel.js"></script><div class="travel_wrapper">    <p class="travel_title">Добавление предложения о поездке</p>    <a href="/services/travel" class="back_to_travel">← Назад к поездкам</a>    <div class="search_form">        <?php MessageShow(); ?>        <form action="/services/travel/add" method="POST">            <div class="search_how">                <span class="search_title">Я являюсь</span>                <input type="radio" name="search_whom" value="companion" id="1">                <label for="1">Попутчиком</label>                <input type="radio" name="search_whom" value="driver" id="2">                <label for="2">Водителем</label>            </div>            <div class="search_place">                <span class="search_title">Направляюсь от</span>                <input type="text" name="from" maxlength="50" autocomplete="off" required>                <span class="search_title">до</span>                <input type="text" name="to" maxlength="50" autocomplete="off" required>            </div>            <div class="search_place" id="add_auto">                <span class="search_title">Автомобиль</span>                <input type="text" name="auto" maxlength="50">            </div>            <div class="search_place" id="add_places">                <span class="search_title">Общее кол-во мест</span>                <input type="text" name="all_place" maxlength="10">                <span class="search_title">из них свободно</span>                <input type="text" name="free_place" maxlength="10">            </div>            <div class="search_place" id="add_places">                <span class="search_title">Примерное время отправления</span>                <input type="text" name="date_time" max="20" placeholder="2016-05-21 20:50:00">            </div>            <span class="search_title">Описание предложения</span>            <textarea name="" id="travel_desc"></textarea>            <input type="submit" name="add_offer" value="Опубликовать">        </form>    </div></div><div class="help_block"></div>