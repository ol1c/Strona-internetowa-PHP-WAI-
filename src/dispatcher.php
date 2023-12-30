<?php

const REDIRECT_PREFIX = 'redirect:';

function dispatch($routing, $action_url)
{
    $controller_name = $routing[$action_url];

    $model = [];
    $view_name = $controller_name($model);
    //unset($_SESSION['user']);
    if (isset($_SESSION['user'])) {
        $model['user'] = get_user_byid($_SESSION['user']);
    }

    build_response($view_name, $model);
}

function build_response($view, $model)
{
    if (strpos($view, REDIRECT_PREFIX) === 0) {
        $url = substr($view, strlen(REDIRECT_PREFIX));
        header("Location: " . $url);
        exit;

    } else {
        render($view, $model);
    }
}

function render($view_name, $model)
{
    global $routing;
    extract($model);
    include 'views/template/header.php';
    include 'views/' . $view_name . '.php';
    include 'views/template/footer.php';
}
