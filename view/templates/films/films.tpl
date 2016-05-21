<div class="film_information">
    <p class="title">Жанры</p>
    <div class="genre_wrapper">
        <a href="" class="genre_block">Комедия</a>
        <a href="" class="genre_block">Драма</a>
        <a href="" class="genre_block">Приключения</a>
        <a href="" class="genre_block">Ужасы</a>
    </div>
    <p class="title">Кино сегодня</p>
    <div class="tickets_wrapper">
    <?php /*var_dump($films);*/ for($i = 0; $i < count($films); $i++){ ?>
        <a href="/services/pfilm?film=<?php echo $films[$i]['url']; ?>">
            <div class="film_block">
                <div class="film_photo_block">
                    <img src="<?php echo $films[$i]['picture']; ?>">
                </div>
                <div class="film_info_block">
                    <p class="film_name"><?php echo $films[$i]['name']; ?></p>
                    <p class="film_genre"><?php echo $films[$i]['genre']; ?></p>
                </div>
            </div>
        </a>
    <?php } ?>
    </div>
</div>