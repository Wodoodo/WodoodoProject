<div class="games_information">
    <p class="title">Жанры</p>
    <div class="genre_wrapper">
        <a href="/services/games" class="genre_block">Все жанры</a>
        <a href="/services/games?genre=RPG" class="genre_block">RPG</a>
        <a href="/services/games?genre=Shouter" class="genre_block">Шутеры</a>
        <a href="/services/games?genre=Adventure" class="genre_block">Приключения</a>
    </div>
    <p class="title">Последние добавленные игры</p>
    <div class="games_wrapper">
        <?php for ($i = 0; $i < $game->num_rows; $i++) { ?>
        <a href="/services/pgames?id=<?php echo $game->rows[$i]['game_id']; ?>">
            <div class="games_block">
                <div class="games_photo_block">
                    <img src="/view/images/games/<?php echo $game->rows[$i]['game_photo']; ?>" alt="">
                </div>
                <div class="games_info_block">
                    <p class="games_name"><?php echo $game->rows[$i]['game_name']; ?></p>
                    <p class="games_genre"><?php echo $game->rows[$i]['game_genre']; ?></p>
                </div>
            </div>
        </a>
        <?php } ?>
    </div>
</div>