<?php
/**
 * Created by PhpStorm.
 * User: mdrubayethasan
 * Date: 08.03.18
 * Time: 23:13
 */

namespace app\Components;

use yii\web\Controller;
use Yii;

class Ccontroller extends Controller
{
    public function init(){
        Generic::setGlobalvariables();
    }
}