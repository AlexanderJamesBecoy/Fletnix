<?php

function getPage($page) {
    return stripos($_SERVER['REQUEST_URI'], $page);
}

function getGenres($db) {
    $list = '<ul>';
    $sth = $db->query("SELECT DISTINCT genre_name FROM Genre");
    while($genres = $sth->fetch()) {
        $genre = $genres['genre_name'];
        $list .= '<li><a href="films?genre='.$genre.'">'.$genre.'</a></li>';
    }
    $list .= '</ul>';
    return $list;
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

function getFilmPoster($cover) {
    if($cover == NULL) {
        return 'images/film_covers/default_poster.jpg';
    } else {
        return 'images/film_covers/'.$cover;
    }
}

function pagination($destination, $page, $pageLimit, $genre=NULL, $zoekveld=NULL) {
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
        $poster = $movie['cover_image'];
        if(($rowCount > ($page - 1) * 15) && ($rowCount <= $rowLimit)) {
            echo    '<div class="film">
                        <a href="view_movie?id='.$movie['movie_id'].'">
                            <img src="'.getFilmPoster($poster).'" alt="cover">
                            <h2>'.$movie['title'].'</h2>
                            <h3>'.$movie['publication_year'].'</h3>
                        </a>
                    </div>';
        }
        $rowCount++;
    }

    echo pagination('films', $page, $pageLimit, $genre);
}

/* View Movie */
function getDetailFromMovie($db, $movie) {
    $movie_id = $movie['movie_id'];
    echo '<table id="movie-detail">';
    if($movie['URL'] != NULL) {
        echo 	'<tr>
                    <th>Prequel</th>
                    <td><a href="'.$movie['URL'].'" target="_blank">Bekijk op youtube!</a></td>
                </tr>';
    }
    echo getCastFromMovie($db, $movie_id, 'Regisseur');
    echo    '<tr>
                    <th>Uitgekomen op</th>
                    <td>'.$movie['publication_year'].'</td>
                </tr>
                <tr>
                    <th>Speelduur</th>
                    <td>'.$movie['duration'].' min</td>
                </tr>'.getGenresFromMovie($db, $movie_id).'<tr>
                    <th>Omschrijving</th>
                    <td><p>'.$movie['description'].'</p></td>
                </tr>';
        if($movie['previous_part'] != NULL) {
            $previous_part = $movie['previous_part'];
            echo 	'<tr>
                        <th>Prequel</th>';
            $sth = $dbh->prepare("SELECT * FROM Movie WHERE movie_id = ?");
            $sth->execute(array($previous_part));
            $previous_movie = $sth->fetch();
            echo 		'<td><a href="view_movie?id='.$previous_movie['movie_id'].'">'.$previous_movie['title'].'</a></td>';
            echo	'</tr>';
        }
        echo '<tr>
                <th>Prijs</th>
                <td>'.$movie['price'].'</td>
            </tr>'.getCastFromMovie($db, $movie_id, 'Cast').'</table>';
}

function getGenresFromMovie($db, $movie_id) {
    $query = "SELECT * FROM Movie_Genre WHERE movie_id = ?";
    $sth = $db->prepare($query);
    $sth->execute(array($movie_id));
    $tr = '<tr><th>Genre</th><td>';
    $count = 0;
    while($genre = $sth->fetch()) {
        $tr .= $genre['genre_name'].',&nbsp;';
    }
    $tr .= '</td></tr>';
    return $tr;
}

function getCastFromMovie($db, $movie_id, $th) {
    $query = "SELECT TOP 15 * FROM Person P INNER JOIN Movie_Cast C ON P.person_id = C.person_id WHERE movie_id = ?";
    if(strtolower($th) == 'regisseur') {
        $query = "SELECT * FROM Person P INNER JOIN Movie_Director D ON P.person_id = D.person_id WHERE movie_id = ?";
    }
    $sth = $db->prepare($query);
	$sth->execute(array($movie_id));
    $count = 0;
    $tdCast = "";
    if($sth->rowCount() == 0) {
        return '<tr><th>'.$th.'</th><td>Onbekend persoon</td></tr>';
    }
	while($cast = $sth->fetch()) {
        $firstname = ($cast['firstname'] == NULL)? 'Onbekend' : $cast['firstname'];
        $lastname = ($cast['firstname'] == NULL)? 'Persoon' : $cast['lastname'];
        if($count === 0) {
            $tdCast .= '<td>'.$firstname.' '.$lastname.'</td></tr>';
        } else {
            $tdCast .= '<tr><td>'.$firstname.' '.$lastname.'</td></tr>';
        }
        $count++;
    }
    $thCast = '<tr><th rowspan='.$count.'>'.$th.'</th>';
    return $thCast.$tdCast;
}

?>
