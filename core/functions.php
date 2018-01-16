<?php

function getPage($page) {
    return stripos($_SERVER['REQUEST_URI'], $page);
}

function retrieveGenresInSelect($database) {
    $query = $database->query("SELECT * FROM Genre WHERE genre_name != 'Sci-Fi'");

    while($genre = $query->fetch()) {
        echo '<option value="genre_'.strtolower($genre['genre_name']).'">'.$genre['genre_name'].'</option>';
    }
}

function pagination($destination, $page=1) {
    $pagination = '<div class="pagination">';
    $pagination .= '<a href="'.$destination.'?page='.($page - 1).'">&laquo;</a>';
    for($pageIndex = $page; $pageIndex < $page + 5; $pageIndex++) {
        $pagination .= '<a href="'.$destination.'?page='.$pageIndex.'">'.$pageIndex.'</a>';
    }
    $pagination .= '<a href="'.$destination.'?page='.($page + 1).'">&raquo;</a></div>';
    return $pagination;
}

function retrieveMoviesInBox($database, $page=1) {
    $rowCount = 0;
    $rowLimit = $page * 15;
    $query = $database->query('SELECT * FROM Movie WHERE movie_id IN (SELECT movie_id FROM Movie_Genre WHERE genre_name = \'Sci-Fi\')');
    $pageLimit = (int)(count($query->fetchAll()) / 15);
    $query = $database->query('SELECT * FROM Movie WHERE movie_id IN (SELECT movie_id FROM Movie_Genre WHERE genre_name = \'Sci-Fi\')');
    if(count($query->fetchAll()) % 15 > 0) $pageLimit += 1;
    if($page > $pageLimit || $page < 1) {
        header("Location: error");
    }

    $query = $database->query('SELECT * FROM Movie WHERE movie_id IN (SELECT movie_id FROM Movie_Genre WHERE genre_name = \'Sci-Fi\') ORDER BY title ASC');
    while($movie = $query->fetch()) {
        if(($rowCount > ($page - 1) * 15) && ($rowCount <= $rowLimit)) {
            if($movie['cover_image'] == NULL) {
                $movie['cover_image'] = "default_poster.jpg";
            }

            echo    '<div class="film">
                        <a href="trailer.html">
                            <img src="images/film_covers/'.$movie['cover_image'].'" alt="cover">
                            <h2>'.$movie['title'].'</h2>
                            <h3>'.$movie['publication_year'].'</h3>
                        </a>
                    </div>';
        }
        $rowCount++;
    }

    echo pagination('films', $page);
}

?>
