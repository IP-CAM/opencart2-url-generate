<?php

require_once('config.php');
require_once(DIR_SYSTEM . 'library/db.php');
require_once(DIR_SYSTEM . 'library/db/'.DB_DRIVER.'.php');

$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// create product alias
$query_product = $db->query("SELECT * FROM " . DB_PREFIX . "product_description");
foreach ($query_product->rows as $result) {

    $query_alias = $db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'product_id=" . (int)$result['product_id'] . "'");
    if (!$query_alias->num_rows) {
        $db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$result['product_id'] . "', `keyword` = '" . title2uri($result['name']) . "'");
    }
}

// create category alias
$query_category = $db->query("SELECT * FROM " . DB_PREFIX . "category_description");
foreach ($query_category->rows as $result) {

    $query_alias = $db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'category_id=" . (int)$result['category_id'] . "'");
    if (!$query_alias->num_rows) {
        $db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$result['category_id'] . "', `keyword` = '" . title2uri($result['name']) . "'");
    }
}

// create information alias
$query_information = $db->query("SELECT * FROM " . DB_PREFIX . "information_description");
foreach ($query_information->rows as $result) {

    $query_alias = $db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'information_id=" . (int)$result['information_id'] . "'");
    if (!$query_alias->num_rows) {
        $db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'information_id=" . (int)$result['information_id'] . "', `keyword` = '" . title2uri($result['title']) . "'");
    }
}

// create manufacturer alias
$query_manufacturer = $db->query("SELECT * FROM " . DB_PREFIX . "manufacturer");
foreach ($query_manufacturer->rows as $result) {

    $query_alias = $db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'manufacturer_id=" . (int)$result['manufacturer_id'] . "'");
    if (!$query_alias->num_rows) {
        $db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'manufacturer_id=" . (int)$result['manufacturer_id'] . "', `keyword` = '" . title2uri($result['name']) . "'");
    }
}

function convert_vi_to_en($str)
{
    if (!$str) return "";
    $unicode = array(
        'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|A|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'b' => 'B', 'c' => 'C', 'd' => 'd|D|đ|Đ',
        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|E|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'f' => 'F', 'g' => 'G', 'h' => 'H',
        'i' => 'í|ì|ỉ|ĩ|ị|I|Í|Ì|Ỉ|Ĩ|Ị',
        'j' => 'J', 'k' => 'K', 'l' => 'L', 'm' => 'M', 'n' => 'N',
        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|O|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Õ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'p' => 'P', 'q' => 'Q', 'r' => 'R', 's' => 'S', 't' => 'T',
        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|U|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'v' => 'V', 'w' => 'W', 'x' => 'X',
        'y' => 'ý|ỳ|ỷ|ỹ|ỵ|Y|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        'z' => 'Z',
    );
    foreach ($unicode as $nonUnicode => $uni)
        $str = preg_replace("/($uni)/i", $nonUnicode, $str);

    return $str;
}

function title2uri($sValue)
{
    $sValue = str_replace(
        array('&', '/', '\\', '"', '+', ' '),
        array('-', '-', '-', '-', '-', '-'),
        $sValue
    );

    return convert_vi_to_en($sValue);
}

echo 'All url rewrite done!';
?>