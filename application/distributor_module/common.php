<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  common.php
 *  创 建 者 :  Feng TianShui
 *  创建日期 :  2018/08/29 21:08
 *  文件描述 :  分销模块模块公共何函数文件
 *  历史记录 :  -----------------------
 */

// +----------------------------------
// : 自定义函数区域
// +----------------------------------
/**
 * 精确加法
 * @param [type] $a [description]
 * @param [type] $b [description]
 */
function math_add($a,$b,$scale = '2') {
    return bcadd($a,$b,$scale);
}
/**
 * 精确减法
 * @param [type] $a [description]
 * @param [type] $b [description]
 */
function math_sub($a,$b,$scale = '2') {
    return bcsub($a,$b,$scale);
}
/**
 * 精确乘法
 * @param [type] $a [description]
 * @param [type] $b [description]
 */
function math_mul($a,$b,$scale = '2') {
    return bcmul($a,$b,$scale);
}
/**
 * 精确除法
 * @param [type] $a [description]
 * @param [type] $b [description]
 */
function math_div($a,$b,$scale = '2') {
    return bcdiv($a,$b,$scale);
}
/**
 * 精确求余/取模
 * @param [type] $a [description]
 * @param [type] $b [description]
 */
function math_mod($a,$b) {
    return bcmod($a,$b);
}
/**
 * 比较大小
 * @param [type] $a [description]
 * @param [type] $b [description]
 * 大于 返回 1 等于返回 0 小于返回 -1
 */
function math_comp($a,$b,$scale = '5') {
    return bccomp($a,$b,$scale); // 比较到小数点位数
}