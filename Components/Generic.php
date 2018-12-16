<?php
/**
 * Created by PhpStorm.
 * User: mdrubayethasan
 * Date: 08.03.18
 * Time: 23:13
 */

namespace app\Components;

use app\models\Eingeben;
use app\models\Eingabe;
use Yii;
use app\models\Benutzer;
use app\models\Eparam;
use app\models\Questionset;
use app\models\Testfragetrace;



class Generic
{

    /**
     * Function for setting global variables
     */
    public static function setGlobalvariables(){
        //self::deleteCache();
        $parameter = Yii::$app->cache->get('parameters');

        if ($parameter === false) {

            $params = Eparam::find()
                ->asArray()
                ->all();

            $parameter = [];
            foreach($params as $param){
                $parameter[trim($param['name'])] = trim($param['value']);
            }

            Yii::$app->cache->set('parameters',$parameter);
        }

        if(isset($parameter['rmax']))Yii::$app->params['rmax'] = $parameter['rmax'];
        if(isset($parameter['total_round']))Yii::$app->params['total_round'] = $parameter['total_round'];
        /*if(isset($parameter['current_round']))Yii::$app->params['current_round'] = $parameter['current_round'];*/
        if(isset($parameter['max_gruppe']))Yii::$app->params['max_gruppe'] = $parameter['max_gruppe'];
        if(isset($parameter['zins_eigenkapital']))Yii::$app->params['zins_eigenkapital'] = $parameter['zins_eigenkapital'];
        if(isset($parameter['Preis_Mais']))Yii::$app->params['Preis_Mais'] = $parameter['Preis_Mais'];
        if(isset($parameter['Preis_HHS']))Yii::$app->params['Preis_HHS'] = $parameter['Preis_HHS'];
        if(isset($parameter['Preis_Fleisch']))Yii::$app->params['Preis_Fleisch'] = $parameter['Preis_Fleisch'];
        if(isset($parameter['c1']))Yii::$app->params['c1'] = $parameter['c1'];
        if(isset($parameter['c2a']))Yii::$app->params['c2a'] = $parameter['c2a'];
        if(isset($parameter['aw3']))Yii::$app->params['aw3'] = $parameter['aw3'];
        if(isset($parameter['c32']))Yii::$app->params['c32'] = $parameter['c32'];
    }

    /**
     * Function for deleting cache
     */
    public static function deleteCache(){
        Yii::$app->cache->delete('parameters');
    }

    /**
     * Function forchecking action permission
     * @return bool
     */
    public static function checkPermission(){
        $user_role = Generic::getCurrentuser(Yii::$app->user->id,'rolle');
        if($user_role != 'admin'){
            Yii::$app->session->setFlash('danger', "Access Denied");
            return false;
        }
        return true;
    }

    /**
     * function for getting current user details
     * @param $id
     * @param $key
     * @return mixed
     */
    public static function getCurrentuser($id,$key){

        $user = Benutzer::find()
            ->where(["id" => $id])
            ->asArray()
            ->one();
        return $user[$key];

    }

    /**
     * function for getting all user
     * @param array $select
     * @param array $where
     * @return Benutzer[]|array
     */
    public static function getAllUserDetails($select = [], $where = []){
        $user = Benutzer::find()
            ->select($select)
            ->where($where)
            ->asArray()
            ->all();
        return $user;
    }

    public static function getOneUserDetails($select = [], $where = []){
        $user = Benutzer::find()
            ->select($select)
            ->where($where)
            ->asArray()
            ->one();
        return $user;
    }

    /**
     * function for getting qn set for a specific round
     * @param $round
     * @return Questionset|array|null
     */
    public static function getQnSet($round){
        $qnset = Questionset::find()
            ->where(["round" => $round])
            ->asArray()
            ->one();
        return $qnset;
    }

    /**
     * Function for processing Eingeben data
     * @param $qn_set
     * @param $data
     * @return array|mixed|object
     */
    public static function processEingenenData($qn_set,$data){
        $qn_set_ans= json_decode($qn_set['qn_ans'],true);
        unset($data['round']);
        //print_r($data);
        $update_trace_flag_list = [];
        foreach($data as $key => $value){
            $key_arr = explode( '_', $key);
            $sec_num = $key_arr[7];
            $qn_num = $key_arr[6];
            $ans_num = $key_arr[5];
            $option_num = $key_arr[4];

            $qn_set_ans['section'][$sec_num-1]['qn'][$qn_num-1]['ans'][$ans_num-1]['option'][$option_num-1]['single_ans_option_value_' . $option_num . '_' . $ans_num . '_' . $qn_num . '_' . $sec_num] = $value;

            $update_trace_flag = $ans_num . '_' . $qn_num . '_' . $sec_num;
            $option_count = $qn_set_ans['section'][$sec_num-1]['qn'][$qn_num-1]['ans'][$ans_num-1]['option_count'];
            $option_type = $qn_set_ans['section'][$sec_num-1]['qn'][$qn_num-1]['ans'][$ans_num-1]['option_type'];
            if($option_type == 'text'){
                $new_val_for_empty_input = '';
            }else{
                $new_val_for_empty_input = 'off';
            }

            //echo 'key: '.$key.' update_trace_flag: '.$update_trace_flag.' option_num: '.$option_num;
            if(!in_array($update_trace_flag, $update_trace_flag_list)){
                for($i = 1; $i <= $option_count ; $i++){
                    //echo ' i: '.$i;
                    if($i != $option_num){
                        //echo 'here';
                        $qn_set_ans['section'][$sec_num-1]['qn'][$qn_num-1]['ans'][$ans_num-1]['option'][$i -1]['single_ans_option_value_' . $i . '_' . $ans_num . '_' . $qn_num . '_' . $sec_num] = $new_val_for_empty_input;
                    }
                }
                $update_trace_flag_list[]= $update_trace_flag;
            }
            //print_r($update_trace_flag_list);
        }
        //print_r($qn_set_ans);

        return $qn_set_ans;
    }

    /**
     * Function for getting eingeben details with user and round
     * @param $round
     * @param $user_id
     * @return Eingeben|array|null
     */
    public static function getEingeben($round,$user_id){
        $eingeben = Eingeben::find()
            ->where(["round" => $round, "user_id" => $user_id])
            ->asArray()
            ->one();
        return $eingeben;
    }

    /**
     * Function for getting eingabe
     * @param bool $round
     * @param bool $user_id
     * @return Eingabe[]|array
     */
    public static function getEingabe($round = false,$user_id = false){
        $where = [];
        if($round){
            $where["round"]=  $round;
        }
        if($user_id){
            $where["user_id"]=  $user_id;
        }
        $eingabe = Eingabe::find()
            ->where($where)
            ->asArray()
            ->all();
        return $eingabe;
    }

    public static function getEingaben(){
        $eingabe = Eingabe::find()
            ->asArray()
            ->all();
        return $eingabe;
    }

    /**
     * Function for getting all essential parameters
     * @return Eparam[]|array
     */
    public static function getEssentialParams(){
        $params = Eparam::find()
            ->asArray()
            ->all();
        return $params;
    }


    public static function makeFcolumn($checkbox_array,$eval_each,$eval_data,$fkey){

        foreach($checkbox_array as $val){
            if (in_array($val, json_decode($eval_each[$fkey]))) {

                $eval_data[$fkey.$val] = 1;
            }else{
                $eval_data[$fkey.$val] = 0;
            }
        }
        return $eval_data;
    }

    public static function ganzeZahl($x) {
        $x = floatval($x);
        return "<font face=\"courier\">" . number_format($x, 0, ",", ".") . "&nbsp;&nbsp;&nbsp;</font>";
    }

    public static function KommaZahl($x) {
        $x = floatval($x);
        return "<font face=\"courier\">" . number_format($x, 2, ",", ".") . "</font>";
    }

    public static function fowCalculation() {

        $rmaxmax = Yii::$app->params['total_round'];
        $log = fopen(Yii::$app->basePath."/web/files/fow.log", "w");
        $essential_params = self::getEssentialParams();
        $params = [];
        foreach($essential_params as $essential_param){
            $params[trim($essential_param['name'])] = trim($essential_param['value']);
        }
        $n     = (int)$params['n'];
        $rmax     = (int)$params['rmax'];
        $fl_0     = (double)$params['fl_0'];
        $p4_0     = (double)$params['p4_0'];
        $liq_0     = (double)$params['liq_0'];
        $fac0     = (double)$params['fac0'];
        $fac1     = (double)$params['fac1'];
        $fac2a     = (double)$params['fac2a'];
        $fac2b     = (double)$params['fac2b'];
        $fac3     = (double)$params['fac3'];
        $xxp0     = $params['p0'];     $p0  = explode("#", $xxp0 ); array_unshift( $p0, 0);
        $xxp1a     = $params['p1a'];   $p1a = explode("#", $xxp1a); array_unshift($p1a, 0);
        $p1b     = (double)$params['p1b'];
        $xxp2a     = $params['p2a'];   $p2a = explode("#", $xxp2a); array_unshift($p2a, 0);
        $p2b     = (double)$params['p2b'];
        $p2c     = (double)$params['p2c'];
        $p3a     = (double)$params['p3a'];
        $p3b     = (double)$params['p3b'];
        $fixk     = (double)$params['fixk'];
        $xxc1     = $params['c1'];     $c1  = explode("#", $xxc1 ); array_unshift( $c1, 0);
        $xxc2a     = $params['c2a'];   $c2a = explode("#", $xxc2a); array_unshift($c2a, 0);
        $c2b     = (double)$params['c2b'];
        $c31     = (double)$params['c31'];
        $c32     = (double)$params['c32'];
        $nd     = (double)$params['nd'];
        $aw3     = (double)$params['aw3'];
        $awq     = (double)$params['awq'];
        $iek     = (double)$params['iek'];
        $ikk     = (double)$params['ikk'];
        $ilk     = (double)$params['ilk'];
        $kkog     = (double)$params['kkog'];
        $bg3     = (double)$params['bg3'];
        $bgq     = (double)$params['bgq'];
        $lu     = (double)$params['lu'];
        $fl_w     = (double)$params['fl_w'];
        $x5_0     = (double)$params['x5_0'];
        $x5min     = (double)$params['x5min'];
        $w5a     = (double)$params['w5a'];
        $w5b     = (double)$params['w5b'];
        $w5c     = (double)$params['w5c'];
        $p5     = (double)$params['p5'];

        $eingaben = self::getEingabe();
        $users = self::getAllUserDetails(['id','user_id','gruppe','username'],['rolle'=>'user','status' => '1']);

        $rechnen = [];
        foreach ($eingaben as $eingabe){
            $user_detail = self::getOneUserDetails(['user_id'],['username' => $eingabe['username']]);
            foreach ($users as $user){
                if($user['username'] == $eingabe['username']){
                    $rechnen[$user_detail['user_id']][$eingabe['round']] = $eingabe;
                }
            }

        }

        $gruppe =[];
        $name = [];
        foreach($users as $user){
            $gruppe[$user['user_id']] = $user['gruppe'];
            $name[$user['user_id']] = $user['username'];
        };

        //echo'<pre>';
        //print_r($rechnen);//die();

        $aktiv =[];
        for($r = 1; $r <= $rmax; $r++) {
            for($i = 1; $i <= $n; $i++) {

                $aktiv[$i][$r] = (isset($rechnen[$i][$r])) ? true :false;

                $x0[$i][$r]  = (isset($rechnen[$i][$r]['x0']))?$rechnen[$i][$r]['x0']: 0;  $x0org[$i][$r]  = $x0[$i][$r];
                $x1[$i][$r]  = (isset($rechnen[$i][$r]['x1']))?$rechnen[$i][$r]['x1']: 0;  $x1org[$i][$r]  = $x1[$i][$r];
                $x2[$i][$r]  = (isset($rechnen[$i][$r]['x2']))?$rechnen[$i][$r]['x2']: 0;  $x2org[$i][$r]  = $x2[$i][$r];
                $e2[$i][$r]  = (isset($rechnen[$i][$r]['e2']))?$rechnen[$i][$r]['e2']: 0;  $e2org[$i][$r]  = $e2[$i][$r];
                $e5[$i][$r]  = (isset($rechnen[$i][$r]['e5']))?$rechnen[$i][$r]['e5']: 0;  $e5org[$i][$r]  = $e5[$i][$r];
                $x31[$i][$r]  = (isset($rechnen[$i][$r]['x31']))?$rechnen[$i][$r]['x31']: 0;  $x31org[$i][$r]  = $x31[$i][$r];
                $x32[$i][$r]  = (isset($rechnen[$i][$r]['x32']))?$rechnen[$i][$r]['x32']: 0;  $x32org[$i][$r]  = $x32[$i][$r];


                if(isset($rechnen[$i][$r]['q']) && $rechnen[$i][$r]['q'] == 'J'){
                    $q[$i][$r]  = 1;
                }else{
                    $q[$i][$r]  = 0;
                }
                $qorg[$i][$r]  = $q[$i][$r];

                $lk[$i][$r]  = (isset($rechnen[$i][$r]['lk']))?$rechnen[$i][$r]['lk']: 0;  $lkorg[$i][$r]  = $lk[$i][$r];
                $kk[$i][$r]  = (isset($rechnen[$i][$r]['kk']))?$rechnen[$i][$r]['kk']: 0;  $kkorg[$i][$r]  = $kk[$i][$r];
                $zpf[$i][$r]  = (isset($rechnen[$i][$r]['zpf']))?$rechnen[$i][$r]['zpf']: 0;  $zpforg[$i][$r]  = $zpf[$i][$r];
                $zpp[$i][$r]  = (isset($rechnen[$i][$r]['zpp']))?$rechnen[$i][$r]['zpp']: 0;  $zpporg[$i][$r]  = $zpp[$i][$r];
                $vpf[$i][$r]  = (isset($rechnen[$i][$r]['vpf']))?$rechnen[$i][$r]['vpf']: 0;  $vpforg[$i][$r]  = $vpf[$i][$r];
                $vpp[$i][$r]  = (isset($rechnen[$i][$r]['vpp']))?$rechnen[$i][$r]['vpp']: 0;  $vpporg[$i][$r]  = $vpp[$i][$r];
            }
        }
        //print_r($aktiv);
// initialize();
        $qpot[0] = 1.0; $qpot[1] = 1.0 + $ilk;
        for($t = 2; $t <= $nd; $t++) {
            $qpot[$t] = $qpot[$t - 1] * $qpot[1];
        }

        $wgf[0] = $ilk / ($qpot[$nd] - 1.0);
        for($t = 1; $t <= $nd; $t++) {
            $wgf[$t] = $wgf[0] * $qpot[$t];
        }

        for($i = 0; $i <= $nd; $i++) {
            $rwfak[$i] = ($qpot[$nd] - $qpot[$i]) / ($qpot[$nd] - 1.0);
        }

        for($i = 1; $i <= $n; $i++) {
            $fl[$i][0]  = 0;
            $liq[$i][0] = $liq_0;
            $ek[$i][0]  = $liq_0;
            $v3[$i][0]  = 0.0;
            $vq[$i][0]  = 0.0;
            $pleite[$i] = false;
            $vpf[$i][0] = 0;
            $zpf[$i][0] = $fl_0;
            $x2[$i][0] = 0.0;
            $e2[$i][0] = 0.0;
            $bun[$i][0] = 0;
            $x5[$i][0] = $x5_0 * $fl_w;
        }
        $npl = 0;

        $p4[0] = $p4_0;

// Rundenschleife
        for($r = 1; $r <= $rmax; $r++) {
// checkinput($r);
            for($i = 1; $i <= $n; $i++) {
                $grp = $gruppe[$i];
                if($pleite[$i]) {
                    $x0[$i][$r]  = 0.0;
                    $x1[$i][$r]  = 0.0;
                    $x2[$i][$r]  = 0.0;
                    $e2[$i][$r]  = 0.0;
                    $e5[$i][$r]  = 0.0;
                    $x31[$i][$r]  = 0;
                    $x32[$i][$r]  = 0;
                    $q[$i][$r]   = 0;
                    $lk[$i][$r]  = 0.0;
                    $kk[$i][$r]  = 0.0;
                    $zpf[$i][$r] = 0;
                    $zpp[$i][$r] = 0.0;
                    $vpf[$i][$r] = 0;
                    $vpp[$i][$r] = 0.0;
                }
                //  Nichtbeteiligung am Pachtmarkt
                if($zpp[$i][$r] == 0.0) $zpf[$i][$r] = 0;
                if($vpp[$i][$r] == 0.0) $vpf[$i][$r] = 0;

                // 0. Maschinenbedingung
                $masch[$i][$r] = 0;
                for($t = max(1, $r - $nd + 1); $t <= $r; $t++) {
                    $masch[$i][$r] += $q[$i][$t];
                }
                if($masch[$i][$r] == 0) {
                    if($x1[$i][$r] > 0.0) {
                        $x1[$i][$r] = 0.0;
                    }
                    if($x2[$i][$r] > 0.0) {
                        $x2[$i][$r] = 0.0;
                    }
                }

                // 0.5 Waldbedingung
                $zuw[$i][$r] = round(($w5a - $w5b*$x5[$i][$r-1] / $fl_w) * $w5c * $x5[$i][$r-1]); // Wachstumskurve
                $x5[$i][$r] = $x5[$i][$r-1] + $zuw[$i][$r];
                if($x5[$i][$r] - $e5[$i][$r] < $x5min * $fl_w) { // Der Rest ist kleiner als das Minimum
                    $e5[$i][$r] = $x5[$i][$r] - $x5min * $fl_w;
                }
                $x5[$i][$r] -= $e5[$i][$r];

                $level = 0;
                $fl[$i][$r] = $fl[$i][$r - 1] + $zpf[$i][$r - 1] - $vpf[$i][$r - 1] - $x2[$i][$r - 1] + $e2[$i][$r - 1];
                if($r > 4) {
                    $fl[$i][$r] += ($vpf[$i][$r - 4] - $zpf[$i][$r - 4]);
                }
                while(TRUE) {
                    // 1. Fl�chenbedingung
                    if($x0[$i][$r] + $x1[$i][$r] + $x2[$i][$r] <= $fl[$i][$r]) {
                        // Alles in Ordnung
                    } elseif($x0[$i][$r] + $x1[$i][$r] <= $fl[$i][$r]) {
                        // x2 herabsetzen
                        $x2[$i][$r] = $fl[$i][$r] - $x1[$i][$r] - $x0[$i][$r];
                    } elseif($x0[$i][$r] <= $fl[$i][$r]) {
                        // x2 0 setzen
                        $x2[$i][$r] = 0.0;
                        // x1 herabsetzen
                        $x1[$i][$r] = $fl[$i][$r] - $x0[$i][$r];
                    } else {
                        // x2 0 setzen
                        $x2[$i][$r] = 0.0;
                        // x1 0 setzen
                        $x1[$i][$r] = 0.0;
                        // x0 herabsetzen
                        $x0[$i][$r] = $fl[$i][$r];
                    }
                    // 2. Erntebedingung
                    $sku = $x2[$i][$r];
                    $rku = [];
                    for($t = 1; $t <= $r - 1; $t++) {
                        if(isset($rku[$i][$t])){
                            $sku += $rku[$i][$t];
                        }
                    }
                    if(($e2[$i][$r] > $sku) || ($r == $rmaxmax && $e2[$i][$r] < $sku)) {
                        $e2[$i][$r] = $sku;
                    }
                    // 3. Obergrenze des kurzfristigen Kredits
                    if($kk[$i][$r] > $kkog) {
                        $kk[$i][$r] = $kkog;
                    }
                    // 4. Obergrenze des langfristigen Kredits
                    $lkog = $x31[$i][$r] * $bg3 * $aw3 + $q[$i][$r] * $bgq * $awq;
                    if($lk[$i][$r] > $lkog) {
                        $lk[$i][$r] = $lkog;
                    }
                    // 5a. Schweinemastst�lle
                    $bun[$i][$r] = 0;
                    if(!$pleite[$i]) {
                        for($t = max(1, $r - $nd + 1); $t <= $r; $t++) {
                            $bun[$i][$r] += $x31[$i][$t];
                        }
                    }
                    // 5b. belegte Schweinemastpl�tze
                    if($pleite[$i]) {
                        $x32[$i][$r] = 0;
                    } else {
                        if($x32[$i][$r] > 1000 * $bun[$i][$r]) {
                            $x32[$i][$r] = 1000 * $bun[$i][$r];
                        }
                    }
                    // 6. zu zahlende Pacht
                    $k4[$i][$r] = $p4[0] * $zpf[$i][0];
                    for($t = max($r-3, 1); $t <= $r - 1; $t++) {
                        $k4[$i][$r] += $p4[$t] * $zpf[$i][$t];
                    }
                    // 7. Erl�s aus Verpachtung
                    $erl4[$i][$r] = 0.0;
                    for($t = max(1, $r-3); $t <= $r - 1; $t++) {
                        $erl4[$i][$r] += $p4[$t] * $vpf[$i][$t];
                    }
                    // _. Erl�s aus Holzverkauf
                    $erl5[$i][$r] = $e5[$i][$r] * $p5;

                    // 8. Kosten
                    $kosten[$i][$r] = $fixk + $k4[$i][$r] + $x1[$i][$r]*$c1[$grp] + $x2[$i][$r]*$c2a[$grp] +
                        $bun[$i][$r]*$c31 + $x32[$i][$r]*$c32 + $x31[$i][$r]*$aw3 + $q[$i][$r]*$awq;
                    if($masch[$i][$r] > 0) {
                        $kosten[$i][$r] += $e2[$i][$r] * $c2b;
                    }
                    // 9. Geldanlage
                    $ga[$i][$r] = round(
                        $liq[$i][$r - 1] + $lk[$i][$r] + $kk[$i][$r] + $erl4[$i][$r] - $kosten[$i][$r], 2); // +$erl5[$i][$r] Januar 2016

                    if(($ga[$i][$r] >= 0.0) || $pleite[$i]) break;

                    switch($level) {

                        // kurzfristigen Kredit heraufsetzen
                        case 0:
                            $tmp = round($kosten[$i][$r] - $erl4[$i][$r] - $lk[$i][$r] - $liq[$i][$r - 1], 2);
                            if($tmp <= $kkog) {
                                $kk[$i][$r] = $tmp;
                            } else {
                                $kk[$i][$r] = $kkog;
                                $level += 1;
                            }
                            break;

                        // Kosten senken
                        case 1:
                            // Anzahl der belegten Schweinemastpl�tze herabsetzen
                            $tmp = floor(($liq[$i][$r-1] + $lk[$i][$r] + $kk[$i][$r] + $erl4[$i][$r]
                                    - $fixk - $k4[$i][$r] - $x1[$i][$r]*$c1[$grp] - $x2[$i][$r]*$c2a[$grp] - $e2[$i][$r]*$c2b
                                    - $bun[$i][$r]*$c31 - $x31[$i][$r]*$aw3 - $q[$i][$r]*$awq) / $c32 );
                            if($tmp >= 0) {
                                $x32[$i][$r] = $tmp;
                            } else {
                                $x32[$i][$r] = 0;
                                $level += 1;
                            }
                            break;

                        case 2:
                            // Anzahl der Schweinemastst�lle herabsetzen
                            $tmp = floor(($liq[$i][$r-1] + $lk[$i][$r] + $kk[$i][$r] + $erl4[$i][$r]
                                    - $fixk - $k4[$i][$r] - $x1[$i][$r]*$c1[$grp] - $x2[$i][$r]*$c2a[$grp] - $e2[$i][$r]*$c2b
                                    - $bun[$i][$r-1]*$c31 - $x32[$i][$r]*$c32 - $q[$i][$r]*$awq) / ($aw3 + $c31));
                            if($tmp >= 0) {
                                $x31[$i][$r] = $tmp;
                            } else {
                                $x31[$i][$r] = 0;
                                $level += 1;
                            }
                            break;

                        case 3:
                            if(!$pleite[$i]) {
                                $pleite[$i] = true;
                                $npl += 1;
                                for($t = 1; $t <= $r; $t++) {
                                    $rku[$i][$t] = 0.0;
                                }
                                $bun[$i][$r] = 0;
                                $zpf[$i][$r] = 0;
                                $zpp[$i][$r] = 0.0;
                                $vpf[$i][$r] = 0;
                                $vpp[$i][$r] = 0.0;
                            }
                            break;

                        default:
                            break;

                    }
                    if($pleite[$i]) break;
                }

                $szpf = 0;
                for($t = max($r-3, 1); $t <= max($r-1, 1); $t++) {
                    $szpf += $zpf[$i][$t];
                }
                $tmp = $fl[$i][$r] - $x2[$i][$r] + $e2[$i][$r] - $szpf;
                if($r > 3) {
                    $tmp += $vpf[$i][$r - 3];
                }
                if($vpf[$i][$r] > $tmp) {
                    $vpf[$i][$r] = max($tmp, 0);
                }
            }

// pachtmarkt($r);

            $_zpp = [];
            $_vpp = [];
            $j = 0;
            for($i = 1; $i <= $n; $i++) {
                $zpflag[$i] = ($zpporg[$i][$r] > 0.0 && $zpf[$i][$r] > 0);
                if($zpflag[$i]) { $j += 1; $_zpf[$j] = $zpf[$i][$r]; $_zpp[$j] = $zpp[$i][$r];}
            }
            $nzp = $j;

            $j = 0;
            for($i = 1; $i <= $n; $i++) {
                $vpflag[$i] = ($vpporg[$i][$r] > 0.0 && $vpf[$i][$r] > 0);
                if($vpflag[$i]) { $j += 1; $_vpf[$j] = $vpf[$i][$r]; $_vpp[$j] = $vpp[$i][$r]; }
            }
            $nvp = $j;

            Pachtmarkt::bodenmarkt($r, $_zpf, $_zpp, $_vpf, $_vpp, $nzp, $nvp, $p4[$r], $spf[$r]);

            $j = 0;
            for($i = 1; $i <= $n; $i++) {
                if($zpflag[$i]) { $j += 1; $zpf[$i][$r] = $_zpf[$j]; $zpp[$i][$r] = $_zpp[$j]; }
            }

            $j = 0;
            for($i = 1; $i <= $n; $i++) {
                if($vpflag[$i]) { $j += 1; $vpf[$i][$r] = $_vpf[$j]; $vpp[$i][$r] = $_vpp[$j]; }
            }

// calculate($r);

            $sx0[$r] = 0.0;
            $sx1[$r] = 0.0;
            $sx2[$r] = 0.0;
            $sx3[$r] = 0.0;
            $se2[$r] = 0.0;
            $sy0[$r] = 0.0;
            $sy1[$r] = 0.0;
            $sy2[$r] = 0.0;
            $sy3[$r] = 0.0;
            for($i = 1; $i <= $n; $i++) {
                if(!$pleite[$i]) {
                    // *** Ertr�ge
                    // 0 Stilllegung
                    $y0[$i][$r] = $fac0 * $x0[$i][$r];
                    $sx0[$r] += $x0[$i][$r];
                    $sy0[$r] += $y0[$i][$r];
                    // 1 Mais
                    $y1[$i][$r] = $fac1 * $x1[$i][$r];
                    $sx1[$r] += $x1[$i][$r];
                    $sy1[$r] += $y1[$i][$r];
                    // 2 Kurzumtieb
                    $rku[$i][$r] = $x2[$i][$r]; // Kurzumtriebsanbau aus der Runde r
                    // $e2 nach Alter aufteilen
                    for($t = 0; $t <= $r; $t++) {
                        $e2part[$i][$t] = 0.0;
                    }
                    $sku = 0.0;
                    $t = 0;
                    $a = 0; // falls die Schleife nicht durchlaufen wird
                    $y2[$i][$r] = 0.0;
                    while(($sku < $e2[$i][$r]) && ($t + 1 <= $r) && $t > 0) {
                        $t += 1;
                        $a = $r - $t + 1;
                        $y2[$i][$r] += ($fac2a - $fac2b * $a) * $a * $rku[$i][$t];
                        $sku += $rku[$i][$t];
                        $e2part[$i][$t] = $rku[$i][$t];
                        $rku[$i][$t] = 0.0; // Kurzumtriebsernte
                    }
                    // in Runde t hat sku e2 erreicht oder �berschritten -> korrigieren
                    $rku[$i][$t] = $sku - $e2[$i][$r];
                    $e2part[$i][$t] -= $rku[$i][$t];
                    $y2[$i][$r] -= ($fac2a - $fac2b * $a) * $a * $rku[$i][$t]; // t und a aus der Schleife wurden noch nicht ver�ndert!
                    $sx2[$r] += $x2[$i][$r];
                    $sy2[$r] += $y2[$i][$r];
                    $se2[$r] += $e2[$i][$r];
                    // 3 Schweinemast
                    $y3[$i][$r] = $x32[$i][$r];
                    $sx3[$r] += $x31[$i][$r];
                    $sy3[$r] += $y3[$i][$r];
                } else {
                    $y1[$i][$r] = 0.0;
                    $y2[$i][$r] = 0.0;
                    $y3[$i][$r] = 0.0;
                    $rku[$i][$r] = 0.0;
                }
            }
            // Anzahl der Teilnehmer, die abgegeben haben und nicht pleite sind, bestimmen
            $n_aktiv = 0;
            for($i = 1; $i <= $n; $i++) {
                if($aktiv[$i][$r] && !$pleite[$i]){
                    $n_aktiv += 1;
                }else{
                    $n_aktiv = 1;
                    //echo $pleite[$i].'i'.$i.'r'.$r;die();
                }
            }
            // Preise
            $p1[$r] = round(max(0.0, $p1a[$r] - $p1b * $sy1[$r] / $n_aktiv), 2);
            $p2[$r] = round(max(0.0, $p2a[$r] - $p2b * $sy2[$r] / $n_aktiv + $p2c * $sy2[$r] / $n_aktiv * $sy2[$r] / $n_aktiv), 2);
            $p3[$r] = round(max(0.0, $p3a - $p3b * $sy3[$r] / $n_aktiv), 2);
            for($i = 1; $i <= $n; $i++) {
                // Erl�se
                $srku = 0.0;
                for($t = 1; $t <= $r; $t++) {
                    if(isset($rku[$i][$t])){
                        $srku += $rku[$i][$t];
                    }
                }
                $erl0[$i][$r] = (!$pleite[$i]) ? ($y0[$i][$r] + $srku + $e2[$i][$r]) * $p0[$r] : 0.0;
                $erl1[$i][$r] = $y1[$i][$r] * $p1[$r];
                $erl2[$i][$r] = $y2[$i][$r] * $p2[$r];
                if($masch[$i][$r] == 0) {
                    $erl2[$i][$r] *= $lu;
                }
                $erl3[$i][$r] = $fac3 * $y3[$i][$r] * $p3[$r];
                $erlga[$i][$r] = $ga[$i][$r] * $iek;
                $serl[$i][$r] = $erl0[$i][$r] + $erl1[$i][$r] + $erl2[$i][$r] + $erl3[$i][$r] + $erl4[$i][$r] + $erl5[$i][$r] + $erlga[$i][$r];
                // Kapitaldienste, Zinsen
                $kdk[$i][$r] = $kk[$i][$r] * (1.0 + $ikk);
                $kdl[$i][$r] = 0.0; $szins[$i][$r] = 0.0;
                for($t = max(1, $r - $nd + 1); $t <= $r; $t++) {
                    $kdl[$i][$r] += $lk[$i][$t] * $wgf[$nd];
                    $szins[$i][$r] += $lk[$i][$t] * ($wgf[$nd] - $wgf[$r - $t]);
                }
                $szins[$i][$r] += $kk[$i][$r] * $ikk;
                // Restwert des Fremdkapitals
                $rwlk[$i][$r] = 0.0;
                for($t = max(1, $r - $nd + 1); $t <= $r; $t++) {
                    $rwlk[$i][$r] += $lk[$i][$t] * $rwfak[1 + $r - $t];
                }
                $rwlk[$i][$r] = round($rwlk[$i][$r], 2);
                // Abschreibungen
                $ab[$i][$r] = ($bun[$i][$r] * $aw3 + $masch[$i][$r] * $awq) / $nd;
                // Anlageverm�gen
                $av[$i][$r] = 0.0;
                for($t = max(1, $r - $nd + 1); $t <= $r; $t++) {
                    $av[$i][$r] += ($nd - $r + $t) * ($aw3 * $bun[$i][$t] + $awq * $masch[$i][$t]) / $nd;
                }
                $av[$i][$r] = round($av[$i][$r], 2);
                $v3[$i][$r] = round($v3[$i][$r - 1] + $x31[$i][$r] * $aw3 - $bun[$i][$r] * $aw3 / $nd, 2);
                $vq[$i][$r] = round($vq[$i][$r - 1] + $q[$i][$r] * $awq - $masch[$i][$r] * $awq / $nd, 2);
                // Gewinn
                $g[$i][$r] = $serl[$i][$r] - $kosten[$i][$r] - $szins[$i][$r] - $ab[$i][$r] + $x31[$i][$r] * $aw3 + $q[$i][$r] * $awq;
                // Eigenkapital
                $ek[$i][$r] = round($ek[$i][$r - 1] + $g[$i][$r], 2);
                $ek5[$i][$r] = $ek[$i][$r] + $x5[$i][$r]*$p5; // F�r die Rangliste und die Schlussbilanz
                // Liquidit�t
                $liq[$i][$r] = round($ga[$i][$r] + $serl[$i][$r] - $kdl[$i][$r] - $kdk[$i][$r] - $erl4[$i][$r], 2);
            }

// writeoutput($rmax);
            if($r == $rmax) {
                for($i = 1; $i <= $n; $i++) {
                    $grp = $gruppe[$i];
                    $file_path = Yii::$app->basePath."/web/data/" . rawurlencode($name[$i]) . "_ausgabe_".$r.".html";
                    $fd = fopen($file_path, "w");
                    if(!$fd) echo "Kann Ausgabedatei[$i][$r] nicht �ffnen!<br>\n";
                    fputs($fd, "<h3>Informationen f&uuml;r das Unternehmen &quot;" . trim($name[$i]) . "&quot;<br>\n");
                    fputs($fd, "nach der " . $r . ". Runde</h3>\n");
                    // --------------------------------------------------------------------------------------------------
                    if($pleite[$i]) {
                        fputs($fd, "<h2 style=\"color:red\">Das Unternehmen hat die Konkursgrenze &uuml;berschritten und scheidet aus!</h2>\n");
                    }
                    // --------------------------------------------------------------------------------------------------
                    // Tabelle 1: Eingabeecho
                    fputs($fd, "<br>\n");
                    fputs($fd, "<h2>Eingabeecho</h2>\n");
                    fputs($fd, "<table class=\"table table-striped table-result\">\n");
                    fputs($fd, "  <thead>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <th>&nbsp;</th>\n");
                    fputs($fd, "    <th>von Ihnen eingegebener Wert</th>\n");
                    fputs($fd, "    <th>vom Programm verwendeter,<br>eventuell korrigierter Wert</th>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  </thead>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Fl&auml;chenstilllegung [ha]</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($x0org[$i][$r]) . "</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($x0[$i][$r]   ) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Mais [ha]</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($x1org[$i][$r]) . "</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($x1[$i][$r]   ) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Kurzumtrieb [ha]</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($x2org[$i][$r]) . "</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($x2[$i][$r]   ) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Schweinemastst&auml;lle</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($x31org[$i][$r]) . "</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($x31[$i][$r]   ) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>belegte Schweinemastpl&auml;tze</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($x32org[$i][$r]) . "</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($x32[$i][$r]   ) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Kurzumtriebernte [ha]</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($e2org[$i][$r]) . "</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($e2[$i][$r]   ) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Holzernte [Festmeter]</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($e5org[$i][$r]) . "</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($e5[$i][$r]   ) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Maschinen</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($qorg[$i][$r]) . "</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($q[$i][$r]   ) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>kurzfristiger Kredit [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl($kkorg[$i][$r]) . "</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl($kk[$i][$r]   ) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Annuit&auml;tendarlehen [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl($lkorg[$i][$r]) . "</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl($lk[$i][$r]   ) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>nachgefragte Fl&auml;che [ha]</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($zpforg[$i][$r]) . "</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($zpf[$i][$r]   ) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>zum Zupachtpreis [&euro; / ha]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl($zpporg[$i][$r]) . "</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl($zpp[$i][$r]   ) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>angebotene Fl&auml;che [ha]</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($vpforg[$i][$r]) . "</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($vpf[$i][$r]   ) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>zum Verpachtpreis [&euro; / ha]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl($vpporg[$i][$r]) . "</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl($vpp[$i][$r]   ) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "</table>\n");
                    // --------------------------------------------------------------------------------------------------
                    // Tabelle 2: Marktdaten
                    fputs($fd, "<br>\n");
                    fputs($fd, "<br>\n");
                    fputs($fd, "<h2>Marktdaten</h2>\n");
                    fputs($fd, "<table class=\"table table-striped table-result\">\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>insgesamt am Marktgeschehen teilnehmende Unternehmen</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($n) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Anzahl der Unternehmen, die die Konkursgrenze &uuml;berschritten haben</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($npl) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>insgesamt stillgelegte Fl&auml;chen [ha]</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($sy0[$r] / $fac0) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Gesamtertrag Mais [t]</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($sy1[$r]) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Gesamtertrag Kurzumtrieb [t]</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($sy2[$r]) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Gesamtanzahl der belegten Schweinemastpl&auml;tze</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($sy3[$r]) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Insgesamt auf dem Pachtmarkt gehandelte Fl&auml;che [ha]</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($spf[$r]) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "</table>\n");
                    // --------------------------------------------------------------------------------------------------
                    // Tabelle 3: Preisentwicklung
                    fputs($fd, "<br>\n");
                    fputs($fd, "<br>\n");
                    fputs($fd, "<h2>Preisentwicklung von Runde zu Runde</h2>\n");
                    fputs($fd, "<table class=\"table table-striped table-result\">\n");
                    // Kopfzeile

                    fputs($fd, "  <thead>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <th></th>\n");
                    for($t = 1; $t <= $r; $t++) {
                        fputs($fd, "    <th><b>Runde " . $t . "</b></th>\n");
                    }
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  </thead>\n");


                    // 1. Zeile
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Stilllegungspr&auml;mie [&euro; / ha]</td>\n");
                    for($t = 1; $t <= $r; $t++) {
                        fputs($fd, "    <td>" . self::KommaZahl($p0[$r]) . "</td>\n");
                    }
                    fputs($fd, "  </tr>\n");
                    // 2. Zeile
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Produktpreis Mais [&euro; / t]</td>\n");
                    for($t = 1; $t <= $r; $t++) {
                        fputs($fd, "    <td>" . self::KommaZahl($p1[$t]) . "</td>\n");
                    }
                    fputs($fd, "  </tr>\n");
                    // 3. Zeile
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Produktpreis Holzhackschnitzel [&euro; / t]</td>\n");
                    for($t = 1; $t <= $r; $t++) {
                        fputs($fd, "    <td>" . self::KommaZahl($p2[$t]) . "</td>\n");
                    }
                    fputs($fd, "  </tr>\n");
                    // 4. Zeile
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Schlachtpreis [&euro; / kg]</td>\n");
                    for($t = 1; $t <= $r; $t++) {
                        fputs($fd, "    <td>" . self::KommaZahl($p3[$t]) . "</td>\n");
                    }
                    fputs($fd, "  </tr>\n");
                    // 5. Zeile
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Pachtpreis [&euro; / ha]</td>\n");
                    for($t = 1; $t <= $r; $t++) {
                        fputs($fd, "    <td>" . self::KommaZahl($p4[$t]) . "</td>\n");
                    }
                    fputs($fd, "  </tr>\n");
                    // 6. Zeile
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Holzpreis [&euro; / Festmeter]</td>\n");
                    for($t = 1; $t <= $r; $t++) {
                        fputs($fd, "    <td>" . self::KommaZahl($p5) . "</td>\n");
                    }
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "</table>\n");
                    // --------------------------------------------------------------------------------------------------
                    fputs($fd, "<br>\n");
                    fputs($fd, "<br>\n");
                    fputs($fd, "<b>Hinweis:</b> Die folgenden Angaben gelten nur f&uuml;r Ihr Unternehmen.\n");
                    // --------------------------------------------------------------------------------------------------
                    // Tabelle 4: Bilanz
                    fputs($fd, "<br>\n");
                    fputs($fd, "<br>\n");
                    fputs($fd, "<h2>Schlussbilanz</h2>\n");
                    fputs($fd, "<table class=\"table table-striped table-result\">\n");
                    fputs($fd, "  <thead>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <th colspan=\"2\">Aktiva</th>\n");
                    fputs($fd, "    <th colspan=\"2\">Passiva</th>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  </thead>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Geb&auml;udeverm&ouml;gen [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl($v3[$i][$r]) . "</td>\n");
                    fputs($fd, "    <td>Eigenkapital [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl($ek5[$i][$r]) . "</td>\n"); // Januar, Mai 2016
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Forstbestandsverm&ouml;gen [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl($x5[$i][$r]*$p5) . "</td>\n");
                    fputs($fd, "    <td>Fremdkapital [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl($rwlk[$i][$r]) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Maschinenverm&ouml;gen [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl($vq[$i][$r]) . "</td>\n");
                    fputs($fd, "    <td colspan=\"2\" rowspan=\"2\">&nbsp;</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Geldverm&ouml;gen [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl($liq[$i][$r]) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    $aktiva = round($v3[$i][$r] + $vq[$i][$r] + $x5[$i][$r]*$p5 + $liq[$i][$r], 2);
                    $passiva = round($ek[$i][$r] + $x5[$i][$r]*$p5 + $rwlk[$i][$r], 2);  // Januar 2016

                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td><b>Summe</b></td>\n");
                    fputs($fd, "    <td><b>" . self::KommaZahl($aktiva) . "</b></td>\n");
                    fputs($fd, "    <td><b>Summe</b></td>\n");
                    fputs($fd, "    <td><b>" . self::KommaZahl($passiva) . "</b></td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "</table>\n");
                    // --------------------------------------------------------------------------------------------------
                    // Tabelle 5: Gewinn- und Verlustrechnung
                    fputs($fd, "<br>\n");
                    fputs($fd, "<br>\n");
                    fputs($fd, "<h2>Gewinn- und Verlustrechnung</h2>\n");
                    fputs($fd, "<table class=\"table table-striped table-result\">\n");
                    fputs($fd, "  <thead>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <th colspan=\"2\">Betriebliche Ertr&auml;ge</th>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  </thead>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Stilllegung [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl($erl0[$i][$r]) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Mais [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl($erl1[$i][$r]) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Kurzumtrieb [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl($erl2[$i][$r]) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Holzernte [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl($erl5[$i][$r]) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Schweinemast [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl($erl3[$i][$r]) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Verpachtung [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl($erl4[$i][$r]) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td><b>Summe der Ertr&auml;ge</b> [&euro;]</td>\n");
                    fputs($fd, "    <td><b>" . self::KommaZahl($erl0[$i][$r] + $erl1[$i][$r] + $erl2[$i][$r] + $erl3[$i][$r] + $erl4[$i][$r] + $erl5[$i][$r]) . "</b></td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <thead>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <th colspan=\"2\">Betriebliche Aufwendungen</th>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  </thead>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Fixkosten [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl(-$fixk) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Maisanbau und -ernte [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl(-$x1[$i][$r] * $c1[$grp]) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Kurzumtriebsanbau [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl(-$x2[$i][$r] * $c2a[$grp]) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Kurzumtriebsernte [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl(-$e2[$i][$r] * $c2b) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Betrieb der Schweinemastst&auml;lle [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl(-$bun[$i][$r] * $c31) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Schweinemast [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl(-$x32[$i][$r] * $c32) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Abschreibungen Maschinen [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl(-$masch[$i][$r] * $awq / $nd) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Abschreibungen Schweinemastst&auml;lle [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl(-$bun[$i][$r] * $aw3 / $nd) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Zupachtung [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl(-$k4[$i][$r]) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td><b>Summe der Aufwendungen</b> [&euro;]</td>\n");
                    fputs($fd, "    <td><b>" . self::KommaZahl(-$fixk - $k4[$i][$r] - $x1[$i][$r]*$c1[$grp] - $x2[$i][$r]*$c2a[$grp] - $e2[$i][$r]*$c2b - $bun[$i][$r]*$c31 - $x32[$i][$r]*$c32 - $bun[$i][$r]*$aw3/$nd - $masch[$i][$r]*$awq/$nd) . "</b></td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <thead>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <th colspan=\"2\">Finanzergebnis</th>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  </thead>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Zinsertr&auml;ge [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl($erlga[$i][$r]) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Zinsaufwendungen [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl(-$szins[$i][$r]) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td><b>Summe der Zinsen</b> [&euro;]</td>\n");
                    fputs($fd, "    <td><b>" . self::KommaZahl($erlga[$i][$r] - $szins[$i][$r]) . "</b></td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td><b>Gewinn/Verlust des Unternehmens</b> [&euro;]</td>\n");
                    fputs($fd, "    <td><b>" . self::KommaZahl($g[$i][$r]) . "</b></td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "</table>\n");
                    // --------------------------------------------------------------------------------------------------
                    // Tabelle 6: Kurzumtriebs�bersicht
                    fputs($fd, "<br>\n");
                    fputs($fd, "<br>\n");
                    fputs($fd, "<h2>In Kurzumtriebsplantagen gebundene Fl&auml;chen</h2>\n");
                    fputs($fd, "<table class=\"table table-striped table-result\">\n");
                    fputs($fd, "  <thead>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <th>Alter der Fl&auml;che</th>\n");
                    for($t = $r; $t >= 1; $t--) {
                        fputs($fd, "    <th>" . (1 + $r - $t) . "</th>\n");
                    }
                    fputs($fd, "    <th><b>&Sigma;</b></th>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  </thead>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td align=\"center\">Menge</td>\n");
                    $sku = 0.0;
                    for($t = $r; $t >= 1; $t--) {
                        if(isset($rku[$i][$t])){
                            fputs($fd, "    <td align=\"center\">" . $rku[$i][$t] . "</td>\n");
                            $sku += $rku[$i][$t];
                        }else{
                            fputs($fd, "    <td align=\"center\"></td>\n");
                        }
                    }
                    fputs($fd, "    <td align=\"center\"><b>" . $sku . "</b></td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "</table>\n");
                    // --------------------------------------------------------------------------------------------------
                    // Tabelle 7: Holzwirtschaft
                    fputs($fd, "<br>\n");
                    fputs($fd, "<br>\n");
                    fputs($fd, "<h2>Forstbewirtschaftung</h2>\n");
                    fputs($fd, "<table class=\"table table-striped table-result\">\n");
                    // 1. Zeile

                    fputs($fd, "  <thead>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <th></th>\n");
                    for($t = 0; $t <= $r; $t++) {
                        fputs($fd, "    <th>Runde ".$t."</th>\n");
                    }
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  </thead>\n");
                    // 2. Zeile
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Zuwachs [Festmeter]</td>\n");
                    for($t = 0; $t <= $r; $t++) {
                        if($t > 0) {
                            fputs($fd, "    <td>" . self::ganzeZahl($zuw[$i][$t]) . "</td>\n");
                        } else {
                            fputs($fd, "    <td>&nbsp;</td>\n");
                        }
                    }
                    fputs($fd, "  </tr>\n");
                    // 3. Zeile
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Entnahme [Festmeter]</td>\n");
                    for($t = 0; $t <= $r; $t++) {
                        if($t > 0) {
                            fputs($fd, "    <td>" . self::ganzeZahl($e5[$i][$t]) . "</td>\n");
                        } else {
                            fputs($fd, "    <td>&nbsp;</td>\n");
                        }
                    }
                    fputs($fd, "  </tr>\n");
                    // 4. Zeile
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Bestand [Festmeter]</td>\n");
                    for($t = 0; $t <= $r; $t++) {
                        fputs($fd, "    <td>" . self::ganzeZahl($x5[$i][$t]) . "</td>\n");
                    }
                    fputs($fd, "  </tr>\n");
                    // 5. Zeile
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Erl&ouml;s der Entnahme [&euro;]</td>\n");
                    for($t = 0; $t <= $r; $t++) {
                        if($t > 0) {
                            fputs($fd, "    <td>" . self::KommaZahl($erl5[$i][$t]) . "</td>\n");
                        } else {
                            fputs($fd, "    <td>&nbsp;</td>\n");
                        }
                    }
                    fputs($fd, "  </tr>\n");
                    // 6. Zeile
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Wert des Bestands [&euro;]</td>\n");
                    for($t = 0; $t <= $r; $t++) {
                        fputs($fd, "    <td>" . self::KommaZahl($x5[$i][$t] * $p5) . "</td>\n");
                    }
                    fputs($fd, "  </tr>\n");
                    //
                    fputs($fd, "</table>\n");
                    // --------------------------------------------------------------------------------------------------
                    // Tabelle 8: Schweinemast
                    fputs($fd, "<br>\n");
                    fputs($fd, "<br>\n");
                    fputs($fd, "<h2>Schweinemastst&auml;lle</h2>\n");
                    fputs($fd, "<table class=\"table table-striped table-result\">\n");
                    // Kopfzeile

                    fputs($fd, "  <thead>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <th></th>\n");
                    for($t = 1; $t <= $r; $t++) {
                        fputs($fd, "    <th>Runde ".$t."</th>\n");
                    }
                    fputs($fd, "    <th></th>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  </thead>\n");

                    // 1. Zeile
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Anzahl errichteter Schweinemastst&auml;lle</td>\n");
                    for($t = 1; $t <= $r; $t++) {
                        fputs($fd, "    <td align=\"center\">" . $x31[$i][$t] . "</td>\n");
                    }
                    fputs($fd, "    <td>&nbsp;</td>\n");
                    fputs($fd, "  </tr>\n");
                    // 2. Zeile
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Anzahl nutzbarer Schweinemastst&auml;lle</td>\n");
                    for($t = 1; $t <= $r; $t++) {
                        fputs($fd, "    <td align=\"center\">" . $bun[$i][$t] . "</td>\n");
                    }
                    fputs($fd, "    <td>&nbsp;</td>\n");
                    fputs($fd, "  </tr>\n");
                    if($r < $rmaxmax) {
                        // 3. Zeile
                        fputs($fd, "  <tr>\n");
                        fputs($fd, "    <td colspan=\"" . ($r + 1) . "\">in der n&auml;chsten Runde zur Verf&uuml;gung stehende Schweinemastst&auml;lle:</td>\n");
                        $tmp = 0;
                        for($t = max(1, $r+2-$nd); $t <= $r; $t++) {
                            $tmp += $x31[$i][$t];
                        }
                        fputs($fd, "    <td align=\"center\"><b>" . $tmp . "</b></td>\n");
                        fputs($fd, "  </tr>\n");
                    }
                    fputs($fd, "</table>\n");
                    // --------------------------------------------------------------------------------------------------
                    // Tabelle 9: Pachtbilanz
                    fputs($fd, "<br>\n");
                    fputs($fd, "<br>\n");
                    fputs($fd, "<h2>Pachtbilanz</h2>\n");
                    fputs($fd, "<table class=\"table table-striped table-result\">\n");
                    // Kopfzeile

                    fputs($fd, "  <thead>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <th></th>\n");
                    for($t = 0; $t <= $r; $t++) {
                        fputs($fd, "    <th>Runde ".$t."</th>\n");
                    }
                    fputs($fd, "    <th>&Sigma;</th>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  </thead>\n");

                    // 1. Zeile
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>verpachtete Fl&auml;che [ha]</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($vpf[$i][0]) . "</td>\n");
                    for($t = 1; $t <= $r-3; $t++) {
                        fputs($fd, "    <td align=\"center\">-</td>\n");
                    }
                    $svpf = 0;
                    for($t = max($r-2, 1); $t <= $r; $t++) {
                        fputs($fd, "    <td>" . self::ganzeZahl($vpf[$i][$t]) . "</td>\n");
                        $svpf += $vpf[$i][$t];
                    }
                    fputs($fd, "    <td>" . self::ganzeZahl($svpf) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    // 2. Zeile
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>zugepachtete Fl&auml;che [ha]</td>\n");
                    fputs($fd, "    <td>" . self::ganzeZahl($zpf[$i][0]) . "</td>\n");
                    $szpf = $zpf[$i][0];
                    for($t = 1; $t <= $r-3; $t++) {
                        fputs($fd, "    <td align=\"center\">-</td>\n");
                    }
                    for($t = max($r-2, 1); $t <= $r; $t++) {
                        fputs($fd, "    <td>" . self::ganzeZahl($zpf[$i][$t]) . "</td>\n");
                        $szpf += $zpf[$i][$t];
                    }
                    fputs($fd, "    <td>" . self::ganzeZahl($szpf) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    // 3. Zeile
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Pachtpreis [&euro; / ha]</td>\n");
                    for($t = 0; $t <= $r; $t++) {
                        fputs($fd, "    <td>" . self::KommaZahl($p4[$t]) . "</td>\n");
                    }
                    fputs($fd, "    <td align=\"center\">&nbsp;</td>\n");
                    fputs($fd, "  </tr>\n");
                    // 4. Zeile
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td colspan=\"" . ($r + 2) . "\">in der n&auml;chsten Runde zur Verf&uuml;gung stehende Fl&auml;che [ha]:</td>\n");
                    fputs($fd, "    <td><b>" . self::ganzeZahl($szpf - $svpf) . "</b></td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "</table>\n");
                    // --------------------------------------------------------------------------------------------------
                    // Tabelle 10: Liquidit�tsrechnung
                    fputs($fd, "<br>\n");
                    fputs($fd, "<br>\n");
                    fputs($fd, "<h2>Kontoauszug</h2>\n");
                    fputs($fd, "<table class=\"table table-striped table-result\">\n");

                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td><b>alter Kontostand</b> [&euro;]</td>\n");
                    fputs($fd, "    <td><b>" . self::KommaZahl($liq[$i][$r - 1]) . "</b></td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Fixkosten [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl(-$fixk) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Kredite [&euro;]</td>\n");
                    fputs($fd, "    <td>+" . self::KommaZahl($kk[$i][$r] + $lk[$i][$r]) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Schweinemaststallbau [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl(-$x31[$i][$r] * $aw3) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Maschinenkauf [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl(-$q[$i][$r] * $awq) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Maisanbau und -ernte [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl(-$x1[$i][$r] * $c1[$grp]) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Kurzumtriebsanbau [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl(-$x2[$i][$r] * $c2a[$grp]) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Kurzumtriebsernte [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl(-$e2[$i][$r] * $c2b) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    if($c31 > 0) {
                        fputs($fd, "  <tr>\n");
                        fputs($fd, "    <td>Betrieb der Schweinemastst&auml;lle [&euro;]</td>\n");
                        fputs($fd, "    <td>" . self::KommaZahl(-$bun[$i][$r] * $c31) . "</td>\n");
                        fputs($fd, "  </tr>\n");
                    }
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Schweinemast [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl(-$x32[$i][$r] * $c32) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Pachtsaldo [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl($erl4[$i][$r] - $k4[$i][$r]) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td><b>Geldanlage</b> [&euro;]</td>\n");
                    fputs($fd, "    <td><b>+" . self::KommaZahl($ga[$i][$r]) . "</b></td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Stilllegungspr&auml;mie [&euro;]</td>\n");
                    fputs($fd, "    <td>+" . self::KommaZahl($erl0[$i][$r]) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Maisverkauf [&euro;]</td>\n");
                    fputs($fd, "    <td>+" . self::KommaZahl($erl1[$i][$r]) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Verkauf Holzhackschnitzel [&euro;]</td>\n");
                    fputs($fd, "    <td>+" . self::KommaZahl($erl2[$i][$r]) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Einnahmen aus Holzernte [&euro;]</td>\n");
                    fputs($fd, "    <td>+" . self::KommaZahl($erl5[$i][$r]) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Einnahmen aus Schweinemast [&euro;]</td>\n");
                    fputs($fd, "    <td>+" . self::KommaZahl($erl3[$i][$r]) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Zinsertrag aus Geldanlage (" . (100 * $iek) . "%)  [&euro;]</td>\n");
                    fputs($fd, "    <td>+" . self::KommaZahl($erlga[$i][$r]) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td>Kapitaldienste [&euro;]</td>\n");
                    fputs($fd, "    <td>" . self::KommaZahl(-$kdk[$i][$r] - $kdl[$i][$r]) . "</td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "  <tr>\n");
                    fputs($fd, "    <td><b>neuer Kontostand</b> [&euro;]</td>\n");
                    fputs($fd, "    <td><b>" . self::KommaZahl($liq[$i][$r]) . "</b></td>\n");
                    fputs($fd, "  </tr>\n");
                    fputs($fd, "</table>");

                    // -------------------------------------------------------------------------------------------------
                    fclose($fd);
                }

                // Rangliste Anfang; neu ab SS14
                // Rangliste aufstellen
                for($k = 1; $k <= $n; $k++) {
                    $nummer[$k] = $k;
                }
                for($i = 1; $i < $n; $i++) {
                    $k = $i;
                    for($j = $i + 1; $j <= $n; $j++) {
                        if($ek5[$nummer[$j]][$r] > $ek5[$nummer[$k]][$r])
                            $k = $j;
                        elseif($ek5[$nummer[$j]][$r] == $ek5[$nummer[$k]][$r]) {
                            if($nummer[$j] > $nummer[$k])
                                $k = $j;
                        }
                    }
                    if($k != $i) {
                        $j = $nummer[$k];
                        $nummer[$k] = $nummer[$i];
                        $nummer[$i] = $j;
                    }
                }

                // Rangliste ausgeben
                $fd = fopen(Yii::$app->basePath."/web/berichte/rangliste.html", "w");
                fputs($fd, "<h3>Rangliste nach der $r. Runde</h3>\n");
                fputs($fd, "<table class=\"table table-striped table-result\">\n" );
                fputs($fd, "  <thead>\n");
                fputs($fd, "  <tr>\n");
                fputs($fd, "    <th>Rang</th>\n");
                fputs($fd, "    <th>Benutzer Name</th>\n");
                fputs($fd, "    <th>Price</th>\n");
                fputs($fd, "    <th>Gruppe</th>\n");
                fputs($fd, "  </tr>\n");
                fputs($fd, "  </thead>\n");
                for($rang = 1; $rang <= $n; $rang++) {
                    $i = $nummer[$rang];
                    fputs($fd, "<tr>");
                    fputs($fd, "<td>$rang</td>");
                    fputs($fd, "<td>" . $name[$i] . "</td>");
                    fputs($fd, "<td>" . sprintf("%.2f &euro;", $ek5[$i][$r]) . "</td>");
                    fputs($fd, "<td>" . $gruppe[$i] . "</td>");
                    fputs($fd, "</tr>\n");
                }
                fputs($fd, "</table>\n");
                fclose($fd);
            }
            // Ende von writeoutput()

        }
        // Ende der Rundenschleife

        fclose($log);
    }
}