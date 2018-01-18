<?php

function translateDate($date, $day, $month) {
    $newDay = "";
    switch($date){
        case 'Mon':
            $newDate = 'maandag';
            break;
        case 'Tue':
            $newDate = 'dinsdag';
            break;
        case 'Wed':
            $newDate = 'woensdag';
            break;
        case 'Thu':
            $newDate = 'donderdag';
            break;
        case 'Fri':
            $newDate = 'vrijdag';
            break;
        case 'Sat':
            $newDate = 'zaterdag';
            break;
        case 'Sun':
            $newDate = 'zondag';
            break;
        default:
            $newDate = 'onbekend';
    }
    switch($month){
        case 1:
            $newMonth = 'januari';
            break;
        case 2:
            $newMonth = 'februari';
            break;
        case 3:
            $newMonth = 'maart';
            break;
        case 4:
            $newMonth = 'april';
            break;
        case 5:
            $newMonth = 'mei';
            break;
        case 6:
            $newMonth = 'juni';
            break;
        case 7:
            $newMonth = 'juli';
            break;
        case 8:
            $newMonth = 'augustus';
            break;
        case 9:
            $newMonth = 'september';
            break;
        case 10:
            $newMonth = 'october';
            break;
        case 11:
            $newMonth = 'november';
            break;
        case 12:
            $newMonth = 'december';
            break;
        default:
            $newMonth = 'onbekend';
    }
    return $newDate .' '. $day .' '. $newMonth;
}

function getPage($page) {
    return stripos($_SERVER['REQUEST_URI'], $page);
}

function getGenres($db) {
    $list = '<ul>';
    $sth = $db->query("SELECT DISTINCT genre_name FROM Genre");
    while($genres = $sth->fetch()) {
        $genre = $genres['genre_name'];
        $list .= '<li><a href="films?filter_genre='.$genre.'">'.$genre.'</a></li>';
    }
    $list .= '</ul>';
    return $list;
}

function viewFilmHeader($database, $genre=NULL, $director=NULL) {
    $defaultGenre = ($genre == NULL)? 'selected' : '';
    $defaultDirector = ($director == NULL)? 'selected' : '';
    echo '<form method="GET" action="films">
               <input type="text" name="filter_search" size="30" placeholder="Zoek films op titel...">
               <input type="submit" value="Zoek">
               <select name="filter_genre">
                   <option '.$defaultGenre.' disabled hidden>-- Kies een genre --</option>
                   <option value="all">Alles</option>';
                    $query = $database->query("SELECT * FROM Genre WHERE genre_name != 'Sci-Fi'");
                    while($genres = $query->fetch()) {
                        $selected = '';
                        if($genres['genre_name'] == $genre) $selected = 'selected';
                        echo '<option '.$selected.' value="'.$genres['genre_name'].'">'.$genres['genre_name'].'</option>';
                    }

    echo        '</select><select name="filter_director">
                    <option '.$defaultDirector.' disabled hidden>-- Kies een regisseur --</option>
                    <option value="all">Alles</option>';
                    $query = $database->query("SELECT * FROM Person P WHERE person_id IN (SELECT person_id FROM Movie_Director WHERE movie_id IN (SELECT movie_id FROM Movie_Genre WHERE genre_name = 'Sci-Fi')) ORDER BY lastname ASC");
                    while($directors = $query->fetch()) {
                        $selected = '';
                        $name = $directors['firstname'].' '.$directors['lastname'];
                        if($directors['person_id'] == $person_id) $selected = 'selected';
                        echo '<option '.$selected.' title="'.$name.'" value="'.$directors['person_id'].'">'.$name.'</option>';
                    }
                /*<select name="filter_order">
                    <option value="title">Ordent op titel</option>
                    <option value="year">Ordent op jaar</option>
                </select>*/
    echo        '</select>
            </form>';
}

function pagination($destination, $page, $pageLimit, $genre=NULL, $search=NULL, $director=NULL) {
    $pagination = '<div class="pagination">';
    $genre = '&filter_genre='.$genre;
    $search = '&filter_search='.$search;
    $director = '&filter_director='.$director;
    $filter = $genre . $search . $director;
    if($pageLimit > 5) {
        if($page <= 3) {
            for($pageIndex = 1; $pageIndex <= 5; $pageIndex++) {
                $active = ($pageIndex == $page)? 'active' : '';
                $pagination .= '<a class="'.$active.'" href="'.$destination.'?page='.$pageIndex.$filter.'">'.$pageIndex.'</a>';
            }
            $pagination .= '<a href="'.$destination.'?page='.($page + 1).$filter.'">&raquo;</a>';
            $pagination .= '<a href="'.$destination.'?page='.$pageLimit.$filter.'">&raquo; Last</a></div>';
        } elseif($page >= $pageLimit - 2) {
            $pagination .= '<a href="'.$destination.'?page=1'.$filter.'">First &laquo;</a>';
            $pagination .= '<a href="'.$destination.'?page='.($page - 1).$filter.'">&laquo;</a>';
            for($pageIndex = $pageLimit - 4; $pageIndex <= $pageLimit; $pageIndex++) {
                $active = ($pageIndex == $page)? 'active' : '';
                $pagination .= '<a class="'.$active.'" href="'.$destination.'?page='.$pageIndex.$filter.'">'.$pageIndex.'</a>';
            }
        } else {
            $pagination .= '<a href="'.$destination.'?page=1'.$filter.'">First &laquo;</a>';
            $pagination .= '<a href="'.$destination.'?page='.($page - 1).$filter.'">&laquo;</a>';
            for($pageIndex = $page - 2; $pageIndex <= $page + 2; $pageIndex++) {
                $active = ($pageIndex == $page)? 'active' : '';
                $pagination .= '<a class="'.$active.'" href="'.$destination.'?page='.$pageIndex.$filter.'">'.$pageIndex.'</a>';
            }
            $pagination .= '<a href="'.$destination.'?page='.($page + 1).$filter.'">&raquo;</a>';
            $pagination .= '<a href="'.$destination.'?page='.$pageLimit.$filter.'">&raquo; Last</a></div>';
        }
    } else {
        for($pageIndex = 1; $pageIndex <= $pageLimit; $pageIndex++) {
            $active = ($pageIndex == $page)? 'active' : '';
            $pagination .= '<a class="'.$active.'" href="'.$destination.'?page='.$pageIndex.$filter.'">'.$pageIndex.'</a>';
        }
    }
    return $pagination;
}

function getFilmPoster($cover) {
    if($cover == NULL) {
        return 'images/film_covers/default_poster.jpg';
    } else {
        return 'images/film_covers/'.$cover;
    }
}

function drawFilms($database, $page=1, $genre=NULL, $search=NULL, $director=NULL) {
    $h1 = "";
    $directorName = "";
    $genre = ($genre == "all")? NULL : $genre;
    $director = ($director == "all")? NULL : $director;
    if(!empty($director)) {
        $getName = $database->prepare("SELECT * FROM Person WHERE person_id = ?");
        $getName->execute(array($director));
        $directorRows = $getName->fetchAll();
        $directorName = $directorRows[0]['firstname'] . ' ' . $directorRows[0]['lastname'];
    }
    if(!empty($genre) && !empty($directorName)) {
        $h1 .= '<h1>'.$genre.', directed by '.$directorName.'</h1>';
    } elseif(!empty($genre)) {
        $h1 .= '<h1>'.$genre.'</h1>';
    } elseif(!empty($directorName)) {
        $h1 .= '<h1> directed '.$directorName.'</h1>';
    }
    echo $h1;
    $filters = array();
    $movies = array();
    $rowCount = 0;
    $rowLimit = $page * 15;
    $sqlQuery = "SELECT * FROM Movie WHERE movie_id IN (SELECT movie_id FROM Movie_Genre WHERE genre_name = 'Sci-Fi')";
    if(!empty($genre)) {
        $sqlQuery .= ' AND movie_id IN (SELECT movie_id FROM Movie_Genre WHERE genre_name LIKE ?)';
        $filters[] = $genre;
    }
    if(!empty($search)) {
        $sqlQuery .= ' AND title LIKE ?';
        $filters[] = '%'.$search.'%';
    }
    if(!empty($director)) {
        $sqlQuery .= ' AND movie_id IN (SELECT movie_id FROM Movie_Director WHERE person_id = ?)';
        $filters[] = $director;
    }
    $sqlQuery .= ' ORDER BY publication_year DESC, title ASC';
    $sth = $database->prepare($sqlQuery);
    $sth->execute($filters);
    $movies = $sth->fetchAll();
    if(count($movies) > 0) {
        $pageLimit = ceil(count($movies) / 15);

        if($page > $pageLimit || $page < 1) {
            header("Location: error");
        }

        foreach($movies as $movie) {
            $poster = $movie['cover_image'];
            if(($rowCount >= ($page - 1) * 15) && ($rowCount < $rowLimit)) {
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

        echo pagination('films', $page, $pageLimit, $genre, $search, $director);
    } else {
        echo '<div class="box-error"><img src="images/not_found.jpg" alt="not-found"><p>Mayday mayday, movies not found!</p></div>';
    }
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
        return '<tr><th>'.$th.'</th><td>Onbekend</td></tr>';
    }
	while($cast = $sth->fetch()) {
        $firstname = ($cast['firstname'] == NULL)? 'Onbekend' : $cast['firstname'];
        $lastname = ($cast['lastname'] == NULL)? '' : $cast['lastname'];
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

function calculateDiscount($price, $discount) {
    $percentage = 1 - ($discount * 0.01);
    return $price * $percentage;
}

?>
