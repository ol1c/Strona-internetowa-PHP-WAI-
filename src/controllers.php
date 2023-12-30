<?php
require_once 'business.php';
require_once 'controller_utils.php';


// function products(&$model)
// {
//     $products = get_products();
//     $model['products'] = $products;

//     return 'products_view';
// }

function products(&$model)
{
    $images = get_images();
    $model['images'] = $images;

    return 'products_view';
}

function users(&$model)
{
    $users = get_users();
    $model['users'] = $users;

    return 'users_view';
}

function product(&$model)
{
    if (!empty($_GET['id'])) {
        $id = $_GET['id'];

        if ($product = get_product($id)) {
            $model['product'] = $product;
            return 'product_view';
        }
    }

    http_response_code(404);
    exit;
}

function image(&$model)
{
    if (!empty($_GET['id'])) {
        $id = $_GET['id'];

        if ($image = get_image($id)) {
            $model['image'] = $image;
            return 'image_view';
        }
    }

    http_response_code(404);
    exit;
}

function edit(&$model)
{
    $product = [
        'name' => null,
        'price' => null,
        'description' => null,
        '_id' => null
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (
            !empty($_POST['name']) &&
            !empty($_POST['price']) /* && ...*/
        ) {
            $id = isset($_POST['id']) ? $_POST['id'] : null;

            $product = [
                'name' => $_POST['name'],
                'price' => (int) $_POST['price'],
                'description' => $_POST['description']
            ];

            if (save_product($id, $product)) {
                return 'redirect:products';
            }
        }
    } elseif (!empty($_GET['id'])) {
        $product = get_product($_GET['id']);
    }

    $model['product'] = $product;

    return 'edit_view';
}

function add()
{
    $image = [
        'author' => null,
        'title' => null,
        'file_name' => null,
        'watermark' => null,
        '_id' => null
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (
            (isset($_FILES["file"])) &&
            (isset($_POST['author']))
            && (isset($_POST['title']))
            && (isset($_POST['watermark']))
        ) {
            if ($_FILES["file"]["error"] == UPLOAD_ERR_OK) {
                $uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/img/';
                $uploadfile = $uploaddir . 'og/' . basename($_FILES['file']['name']);

                if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {

                    $filepath = watermark($uploadfile, $uploaddir, $_POST['watermark']);
                    thumbnail($uploadfile, $uploaddir, $filepath);

                } else {
                    echo "Possible file upload attack! <a href='add' >Wróć</a>\n";
                    exit();
                }
            } else {
                echo "Jest problem z tym plikiem <a href='add' >Wróć</a>";
                exit();
            }

            $id = isset($_POST['id']) ? $_POST['id'] : null;

            $image = [
                'author' => $_POST['author'],
                'title' => $_POST['title'],
                'file_name' => basename($_FILES['file']['name']),
                'watermark' => $_POST['watermark'],
            ];

            if (save_product($id, $image)) {
                return 'redirect:gallery';
            }
        } else {
            echo "Wybierz parametry <a href='add'>Wróć</a>";
            exit;
        }
    } elseif (!empty($_GET['id'])) {
        $image = get_image($_GET['id']);
    }
    return 'add_view';
}

function delete(&$model)
{
    if (!empty($_REQUEST['id'])) {
        $id = $_REQUEST['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            delete_user($id);
            return 'redirect:users';

        } else {
            if ($user = get_user_byid($id)) {
                $model['user'] = $user;
                return 'delete_view';
            }
        }
    }

    http_response_code(404);
    exit;
}

function cart(&$model)
{
    $model['cart'] = get_cart();
    return 'partial/cart_view';
}

function add_to_cart()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
        $id = $_POST['id'];
        $product = get_product($id);

        $cart = &get_cart();
        $amount = isset($cart[$id]) ? $cart[$id]['amount'] + 1 : 1;

        $cart[$id] = ['name' => $product['name'], 'amount' => $amount];

        return 'redirect:' . $_SERVER['HTTP_REFERER'];
    }
}

function clear_cart()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_SESSION['cart'] = [];
        return 'redirect:' . $_SERVER['HTTP_REFERER'];
    }
}

function gallery(&$model)
{
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    $images = get_images();

    $model['display'] = display($page, $images);

    //delete_images();
    return 'gallery_view';
}

function login(&$model)
{
    if (isset($_SESSION['user'])) {
        return 'redirect:gallery';
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (
            isset($_POST['login'])
            && isset($_POST['password'])
        ) {
            $login = htmlentities($_POST['login']);

            if ($user = get_user($login)) {
                if (password_verify($_POST['password'], $user['password'])) {
                    $_SESSION['user'] = $user['_id'];
                    $model['blad'] = 'Zalogowano.';
                    return 'redirect:gallery';
                } else {
                    $model['blad'] = 'Niepoprawne hasło.';
                }
            } else {
                $model['blad'] = 'Niepoprawny login.';
            }
        } else {
            $model['blad'] = 'Błąd logowania.';
        }
    }
    return 'login_view';
}

function singup(&$model)
{
    if (isset($_SESSION['user'])) {
        return 'redirect:gallery';
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (
            isset($_POST['login'])
            && isset($_POST['password'])
            && isset($_POST['password2'])
            && isset($_POST['email'])
        ) {
            if ($_POST['password'] == $_POST['password2']) {
                $login = htmlentities($_POST['login']);
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $email = $_POST['email'];

                if (!($user = get_user($_POST['login']))) {
                    $id = isset($_POST['id']) ? $_POST['id'] : null;

                    $user = [
                        'login' => $login,
                        'password' => $password,
                        'email' => $email
                    ];

                    if (save_user($id, $user)) {
                        $user = get_user($_POST['login']);
                        $_SESSION['user'] = $user['_id'];
                        $model['blad'] = 'Zalogowano';
                        return 'redirect:gallery';
                    }
                } else {
                    $model['blad'] = 'Login zajęty.';
                }
            } else {
                $model['blad'] = '"Powtórz hasło" musi być takie same ja "Hasło".';
            }
        } else {
            $model['blad'] = 'Błąd rejestracji.';
        }
    }
    return 'singup_view';
}

function logout()
{
    if (isset($_SESSION['user'])) {
        unset($_SESSION['user']);
    }
    return 'redirect:gallery';
}

function user(&$model)
{
    $model['user'] = get_user('admin');
    return 'user_view';
}
