<?php
/**
 * Created by PhpStorm.
 * User: laodiao
 * Date: 2018/4/23
 * Time: 22:36
 */

class DataUtil
{
    function __construct()
    {

    }
    public static $pagedaxiao = 4;
    public static function typeNameToId($trs){
        switch ($trs){
            case '图书':return 1;
            case '出行':return 6;
            case '娱乐':return 7;
            case '影像':return 2;
            case '数码产品':return 4;
            case '衣物':return 5;
            case '鞋靴箱包':return 3;
            default:return 0;
        }
    }

    public static function typeIdToName($str){
        switch ($str){
            case '1':return '图书';
            case '2':return '影像';
            case '3':return '鞋靴箱包';
            case '4':return '数码产品';
            case '5':return '衣物';
            case '6':return '出行';
            case '7':return '娱乐';
            default:return "全品类";
        }
    }

    public static function statusIdToName($str){
        switch ($str){
            case '-1':return '已下架';
            case '0':return '上架审核中';
            case '1':return '已上架';
            case '2':return '已出租';
            case '3':return '已卖出';
            default:return '无状态';
        }
    }

    public static function jiaoyiownerstatusToName($str){
        switch ($str){
            case '0':return '出租者审核中';
            case '1':return '出租者愿意前来交易';
            case '-1':return '不好意思，出租者拒绝了您的交易申请';
            default :return '无状态';
        }
    }
}