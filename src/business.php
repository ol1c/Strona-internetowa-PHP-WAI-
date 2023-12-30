<?php


use MongoDB\BSON\ObjectID;


function get_db()
{
    $mongo = new MongoDB\Client(
        "mongodb://localhost:27017/wai",
        [
            'username' => 'wai_web',
            'password' => 'w@i_w3b',
        ]);

    $db = $mongo->wai;

    return $db;
}

function get_products()
{
    $db = get_db();
    return $db->products->find()->toArray();
}

function get_images()
{
    $db = get_db();
    return $db->images->find()->toArray();
}

function get_users()
{
    $db = get_db();
    return $db->users->find()->toArray();
}

function get_products_by_category($cat)
{
    $db = get_db();
    $products = $db->products->find(['cat' => $cat]);
    return $products;
}

function get_product($id)
{
    $db = get_db();
    return $db->products->findOne(['_id' => new ObjectID($id)]);
}

function get_image($id)
{
    $db = get_db();
    return $db->images->findOne(['_id' => new ObjectID($id)]);
}

function get_user($login)
{
    $db = get_db();
    return $db->users->findOne(['login' => $login]);
}

function get_user_byid($id)
{
    $db = get_db();
    return $db->users->findOne(['_id' => new ObjectID($id)]);
}

function save_product($id, $image)
{
    $db = get_db();

    if ($id == null) {
        $db->images->insertOne($image);
    } else {
        $db->images->replaceOne(['_id' => new ObjectID($id)], $image);
    }

    return true;
}

function save_user($id, $user)
{
    $db = get_db();

    if ($id == null) {
        $db->users->insertOne($user);
    } else {
        $db->users->replaceOne(['_id' => new ObjectID($id)], $user);
    }

    return true;
}

function delete_product($id)
{
    $db = get_db();
    $db->images->deleteOne(['_id' => new ObjectID($id)]);
}

function delete_user($id)
{
    $db = get_db();
    $db->users->deleteOne(['_id' => new ObjectID($id)]);
}

function delete_images()
{
    $db = get_db();
    $db->images->drop();
}

function watermark($uploadfile, $uploaddir, $znka_wodny)
{
    if ($_FILES["file"]['type'] === 'image/png') {
        $image = imagecreatefrompng($uploadfile);
    } else {
        $image = imagecreatefromjpeg($uploadfile);
    }
    $x = 10;
    $y = imagesy($image) / 2;

    $color = imagecolorallocate($image, 255, 255, 255);
    $font = $uploaddir . 'RubikMaps-Regular.ttf';
    $rozmiar = imagesy($image) / 8;

    imagettftext($image, $rozmiar, 0, $x, $y, $color, $font, $znka_wodny);

    $file_wm = $uploaddir . '/zw/' . pathinfo($uploadfile, PATHINFO_FILENAME) . '.png';

    imagepng($image, $file_wm);

    imagedestroy($image);

    return $file_wm;
}

function thumbnail($uploadfile, $uploaddir, $filepath)
{
    $image = imagecreatefrompng($filepath);
    $image_width = imagesx($image);
    $image_height = imagesy($image);

    $new_image = imagecreatetruecolor(200, 125);

    imagecopyresized($new_image, $image, 0, 0, 0, 0, 200, 125, $image_width, $image_height);

    $file_m = $uploaddir . '/miniaturki/' . pathinfo($uploadfile, PATHINFO_FILENAME) . '.png';
    imagepng($new_image, $file_m);

    imagedestroy($new_image);
    imagedestroy($image);
}

function display($page, $images)
{
    $directory_m = './img/miniaturki/';
    //$directory_zw = './img/zw/';
    $img_on_page = 5;
    $start = ($page - 1) * $img_on_page;
    $end = $start + $img_on_page;

    //$images = glob($directory_m . '*.png', GLOB_BRACE);
    $display = '';
    // for ($i = $start; $i < $end && $i < count($images); $i++) {
    //     $file = basename($images[$i]);
    //     $display = $display . '<div class="gallery-item"><a href="' . $directory_zw . $file . '" target="_blank"><img src="' . $images[$i] . '" alt="' . $file . '" class="gallery-img"></a></div>';
    // }
    // $display = $display . '</div><div class ="prev-next">';
    // if ($start > 0) {
    //     $prev_page = $page - 1;
    //     $display = $display . '<a href="?page=' . $prev_page . '">Poprzednia</a>';
    // }
    // if ($end < count($images)) {
    //     $next_page = $page + 1;
    //     $display = $display . '<a href="?page=' . $next_page . '">Następna</a>';
    // }
    // $display = $display . '</div>';

    if (count($images)) {
        for ($i = $start; $i < $end && $i < count($images); $i++) {
            $file = $images[$i];
            $file_name = pathinfo($file['file_name'], PATHINFO_FILENAME) . '.png';
            $display = $display . '<div class="gallery-item"><a href="image?id=' . $file['_id'] . '"><img src="' . $directory_m . $file_name . '" alt="' . $file_name . '" class="gallery-img"></a><div class="gallery-text"><h3>' . $file['title'] . '</h3>' . $file['author'] . '</div></div>';
        }
        $display = $display . '</div><div class ="prev-next">';
        if ($start > 0) {
            $prev_page = $page - 1;
            $display = $display . '<a href="?page=' . $prev_page . '">Poprzednia</a>';
        }
        if ($end < count($images)) {
            $next_page = $page + 1;
            $display = $display . '<a href="?page=' . $next_page . '">Następna</a>';
        }
        $display = $display . '</div>';
    } else {

        $display = '<h3>Nie ma niczego</h3>';
    }


    return $display;
}
