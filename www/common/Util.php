<?php

namespace app\common;

use Yii;


class Util
{

    public static function cleanStr($str)

    {
        $str = str_replace("\r",'', $str);
        $str = str_replace("\n",'', $str);
        //$str = preg_replace('/\s+/', ' ', $str);
        $str = trim($str);

        return  $str;
    }


    public static function dateBRtoUS($data)
    {
        $output = $data ? DateTime::createFromFormat("d/m/Y", $data)->format("Y-m-d") : null;
        return $output;
    }


    public static function dateUStoBR($data)
    {
        $year = substr($data, 0, 4);
        $month = substr($data, 4, 2);
        $day = substr($data, 6, 2);
        return $day . "/" . $month . "/" . $year;
    }


    public static function timeAdjust($data)
    {
        $hour = substr($data, 0, 2);
        $minute = substr($data, 2, 2);
        $second = substr($data, 4, 2);
        return $hour . ":" . $minute . ":" . $second;
    }


    public static function formatCPF($data)
    {
        $firstPart     = substr($data, 0, 3);
        $secondPart   = substr($data, 3, 3);
        $thirdPart   = substr($data, 6, 3);
        $forthPart = substr($data, 9, 2);
        $monta_cpf = "$firstPart.$secondPart.$thirdPart-$forthPart";
        return $monta_cpf;
    }


    public static function getNewIdTable($tableName,$id)
    {
        $sql = "
                SELECT
                    MAX(".$id.") as max
                    FROM ".$tableName."                       
                ";
        $sql = Util::cleanStr($sql);
        $query_data = Yii::$app->db->createCommand($sql)->queryAll();

        $data=array();
        $data =  $query_data[0]['max']+1;
        return  $data;
    }


}
