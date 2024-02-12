<?
if (!defined("_GNUBOARD_")) exit;


if ($wr_pass) {
        $sql = "update $write_table 
        set wr_password = '" . get_encrypt_string($wr_pass) . "'
        where wr_id = '$wr_id'";
        sql_query($sql);
}

die("{\"error\":\"$error\"}");
