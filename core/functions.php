<?php

function getPage($page) {
    return stripos($_SERVER['REQUEST_URI'], $page);
}

function viewFilmHeader($database, $genre=NULL) {
    $default = ($genre == NULL)? 'selected' : '';
    echo '<form method="GET">
               <input type="text" name="zoekveld" size="30" placeholder="Zoek een film...">
               <input type="submit" name="zoek" value="Zoek">
               <select name="filter_genre">
                   <option '.$default.' disabled hidden>-- Kies een genre --</option>';

    $query = $database->query("SELECT * FROM Genre WHERE genre_name != 'Sci-Fi'");
    while($genres = $query->fetch()) {
        if($genres['genre_name'] == $genre) {
            echo '<option selected value="'.$genres['genre_name'].'">'.$genres['genre_name'].'</option>';
        } else {
            echo '<option value="'.$genres['genre_name'].'">'.$genres['genre_name'].'</option>';
        }
    }
    echo		'</select>
            </form>';
}

function pagination($destination, $page, $pageLimit, $genre=NULL) {
    $pagination = '<div class="pagination">';
    if($page <= 3) {

        for($pageIndex = 1; $pageIndex <= 5; $pageIndex++) {
            $active = ($pageIndex == $page)? 'active' : '';
            $pagination .= '<a class="'.$active.'" href="'.$destination.'?page='.$pageIndex.'&genre='.$genre.'">'.$pageIndex.'</a>';
        }
        $pagination .= '<a href="'.$destination.'?page='.($page + 1).'&genre='.$genre.'">&raquo;</a>';
        $pagination .= '<a href="'.$destination.'?page='.$pageLimit.'&genre='.$genre.'">&raquo; Last</a></div>';

    } elseif($page >= $pageLimit - 2) {

        $pagination .= '<a href="'.$destination.'?page=1&genre='.$genre.'">First &laquo;</a>';
        $pagination .= '<a href="'.$destination.'?page='.($page - 1).'&genre='.$genre.'">&laquo;</a>';
        for($pageIndex = $pageLimit - 4; $pageIndex <= $pageLimit; $pageIndex++) {
            $active = ($pageIndex == $page)? 'active' : '';
            $pagination .= '<a class="'.$active.'" href="'.$destination.'?page='.$pageIndex.'&genre='.$genre.'">'.$pageIndex.'</a>';
        }

    } else {

        $pagination .= '<a href="'.$destination.'?page=1&genre='.$genre.'">First &laquo;</a>';
        $pagination .= '<a href="'.$destination.'?page='.($page - 1).'&genre='.$genre.'">&laquo;</a>';
        for($pageIndex = $page - 2; $pageIndex <= $page + 2; $pageIndex++) {
            $active = ($pageIndex == $page)? 'active' : '';
            $pagination .= '<a class="'.$active.'" href="'.$destination.'?page='.$pageIndex.'&genre='.$genre.'">'.$pageIndex.'</a>';
        }
        $pagination .= '<a href="'.$destination.'?page='.($page + 1).'&genre='.$genre.'">&raquo;</a>';
        $pagination .= '<a href="'.$destination.'?page='.$pageLimit.'&genre='.$genre.'">&raquo; Last</a></div>';

    }
    return $pagination;
}

function retrieveMoviesInBox($database, $page=1, $genre=NULL) {
    $rowCount = 0;
    $rowLimit = $page * 15;
    if($genre !== NULL) {
        $sqlQuery = 'SELECT * FROM Movie WHERE movie_id IN (SELECT movie_id FROM Movie_Genre WHERE genre_name = \'Sci-Fi\') AND movie_id IN (SELECT movie_id FROM Movie_Genre WHERE genre_name LIKE \''.$genre.'\')';
    } else {
        $sqlQuery = 'SELECT * FROM Movie WHERE movie_id IN (SELECT movie_id FROM Movie_Genre WHERE genre_name = \'Sci-Fi\')';
    }
    $query = $database->query($sqlQuery);
    $pageLimit = (int)(count($query->fetchAll()) / 15);
    $query = $database->query($sqlQuery);
    if(count($query->fetchAll()) % 15 > 0) $pageLimit += 1;
    if($page > $pageLimit || $page < 1) {
        header("Location: error");
    }

    $query = $database->query($sqlQuery.'ORDER BY title ASC');
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

    echo pagination('films', $page, $pageLimit, $genre);
}

?>
