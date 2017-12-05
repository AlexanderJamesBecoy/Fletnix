<?php

function getPage($page) {
    return stripos($_SERVER['REQUEST_URI'], $page);
}

?>
