<?php

/* Compare email and password */
function compareLogin($database, $email, $password) {
	$query = $database->prepare("SELECT TOP 1 * FROM Customer WHERE customer_mail_address=? AND password=?");
	$query->execute(array($email, $password));
	$user = $query->fetchAll();
	if (count($user) > 0){
		return $user[0];
	} else {
		echo '<div class="notification-box">
				<dt>Access denied</dt>
				<dd>Onjuist combinatie of account bestaat niet.</dd>
			</div>';
	}
}

/* Get Country */
function getCountry($database) {
	$query = $database->query("SELECT DISTINCT country_name FROM Country");
	while($country = $query->fetch()) {
		echo '<option value="'.$country['country_name'].'">'.$country['country_name'].'</option>';
	}
}

/* Get Payment Method */
function getPaymentMethods($database) {
	$query = $database->query("SELECT DISTINCT payment_method FROM Payment");
	while($payment = $query->fetch()) {
		echo '<option value="'.$payment['payment_method'].'">'.$payment['payment_method'].'</option>';
	}
}

/* Translate numeric date to text */
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
function getDetailFromMovie($db, $movie, $userInfo) {
    $movie_id = $movie['movie_id'];
    echo '<table class="table-detail">
				<tr>
					<th>Prijs</th>
					<td>'.calculateDiscount($db, $movie['price'], $userInfo['contract_type']).'</td>
				</tr>';
    if($movie['URL'] != NULL) {
        echo 	'<tr>
                    <th>Trailer</th>
                    <td><a href="#trailer">Bekijk trailer!</a></td>
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
			            $sth = $db->prepare("SELECT * FROM Movie WHERE movie_id = ?");
			            $sth->execute(array($previous_part));
			            $previous_movie = $sth->fetch();
            			echo 		'<td><a href="view_movie?id='.$previous_movie['movie_id'].'">'.$previous_movie['title'].'</a></td>';
            echo	'</tr>';
        }
        echo getCastFromMovie($db, $movie_id, 'Cast').'</table>';
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

/* Calculate discount */
function calculateDiscount($db, $price, $contract) {
	$query = $db->prepare("SELECT discount_percentage FROM Contract WHERE contract_type = ?");
	$query->execute(array($contract));
	$row = $query->fetchAll();
	$discount = $row[0]['discount_percentage'];
	if($discount > 0) {
		$percentage = 1.0 - ($discount * 0.01);
    	return '<span class="blue">Voor maar &euro;'.number_format($price * $percentage, 2, ',', '.').'!</span> Origineel &#8212; &euro;'.number_format($price, 2, ',', '.').'<br/>
		Vanwege je contract, heb je '.$discount.'%';
	} else {
		return '&euro;'.number_format($price, 2, ',', '.');
	}
}

/* Get gender */
function getGender($char) {
	if($char === 'F') {
		return '<span class="fem user-text">Vrouwelijk</span>';
	} else {
		return '<span class="men user-text">Mannelijk</span>';
	}
}

/* Contract Type Aesthetic */
function getContract($contract_type) {
	$contract = "";
	switch($contract_type) {
		case 'Pro':
			$contract = '<span class="user-text" style="color: #FFF67F;">Mothership</span>';
			break;
		case 'Premium':
			$contract = '<span class="user-text" style="color: #89521E;">Enterprise</span>';
			break;
		default:
			$contract = '<span class="user-text" style="color: #FFFFFF;">Millenium Falcon</span>';
	}
	return $contract;
}

/* Get invoiced */
function collectInvoiced($db, $email_address, $invoiced=true) {
	$query = $db->prepare("SELECT SUM(M.price) as 'price' FROM Movie M INNER JOIN Watchhistory W ON M.movie_id = W.movie_id WHERE customer_mail_address = ? AND invoiced = ?");
	$paid = ($invoiced)? 1 : 0;
	$query->execute(array($email_address, $paid));
	$row = $query->fetchAll();
	if(count($row) > 0) {
		return '&euro;'.$row[0]['price'];
	} else {
		return 'Je hebt nog niets gehuurd.';
	}
}

/* Get most viewed movies */
function mostViewedMovies($db, $userInfo) {
	$query = $db->prepare("SELECT TOP 10 M.movie_id, title, duration, publication_year, COUNT(*) as 'viewed'
				FROM Movie M INNER JOIN Watchhistory W
					ON M.movie_id = W.movie_id
				WHERE customer_mail_address = ?
				GROUP BY M.movie_id, title, duration, publication_year
				ORDER BY COUNT(*) DESC");
	$query->execute(array($userInfo['customer_mail_address']));
	$movies = $query->fetchAll();
	if(count($movies) > 0) {
		foreach($movies as $movie) {
			echo '<tr>
					<td>'.$movie['title'].'</td>
					<td class="center">'.$movie['publication_year'].'</td>
					<td class="center">'.$movie['viewed'].'</td>
				</tr>';
		}
	} else {
		echo '<tr>
				<td colspan="3">Je hebt nog geen films gekeken!</td>
			</tr>';
	}
}

/* Change contract */
function updateCustomerContract($db, $email_address, $contract) {
	switch($contract) {
		case 'abonnement_mothership':
			$contract = 'Pro';
			break;
		case 'abonnement_enterprise':
			$contract = 'Premium';
			break;
		default:
			$contract = 'Basic';
	}
	$query = $db->prepare("UPDATE Customer SET contract_type = ? WHERE customer_mail_address = ?");
	$query->execute(array($contract, $email_address));
	switch($contract) {
		case 'Pro':
			$contract = 'Mothership';
			break;
		case 'Premium':
			$contract = 'Enterprise';
			break;
		default:
			$contract = 'Millenium Falcon';
	}
	$query = $db->prepare("SELECT * FROM Customer WHERE customer_mail_address = ?");
	$query->execute(array($email_address));
	$_SESSION['user'] = $query->fetch();
	echo '<div class="notification-box">
			<dt>Updated account</dt>
			<dd>U heeft nu de contract '.$contract.'</dd>
		</div>';
}

/* Delete account */
function deleteCustomer($db, $email_address, $firstname) {
	session_unset();
	session_destroy();
	$query = $db->prepare("DELETE FROM Customer WHERE customer_mail_address = ?");
	$query->execute(array($email_address));
	echo '<div class="notification-box">
			<dt>Gebruiker succesvol verwijderd</dt>
			<dd>Goodbye '.$firstname.' :(</dd>
		</div>';
}

/* Create Account */
function createUser($database, $firstname, $lastname, $customerMailAddress, $username, $birthDate, $password, $countryName, $contractType, $paymentMethod, $paymentCardNumber, $gender) {

	$query = $database->prepare("SELECT * FROM Customer WHERE customer_mail_address = ?");
	$query->execute(array($customerMailAddress));
	$row = $query->fetch();
	if($row > 0) {
		echo '<div class="notification-box">
					<dt>Access denied!</dt>
					<dd>Account met de bijbehorende e-mail bestaat al.</dd>
				</div>';
		return 0;
	}
	$today = date('Y-m-d');

	$query = $database->prepare("INSERT INTO Customer VALUES (?, ?, ?, ?, ?, ?, ?, NULL, ?, ?, ?, ?, ?)");
	$query->execute(array($customerMailAddress, $lastname, $firstname, $paymentMethod, $paymentCardNumber, $contractType, $today, $username, $password, $countryName, $gender, $birthDate));

	$query = $database->prepare("SELECT * FROM Customer WHERE customer_mail_address = ?");
	$query->execute(array($customerMailAddress));
	$row = $query->fetchAll();
	if($row > 0) {
		echo '<div class="notification-box">
					<dt>Nieuw account is aangemakt!</dt>
					<dd>Geniet nu van duizenden films!</dd>
				</div>';
	} else {
		echo '<div class="notification-box">
					<dt>Access denied</dt>
					<dd>Er is iets fout gegaan.</dd>
				</div>';
	}
}

?>
