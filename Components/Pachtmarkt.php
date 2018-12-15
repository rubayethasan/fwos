<?php
/**
 * Created by PhpStorm.
 * User: mdrubayethasan
 * Date: 21.09.18
 * Time: 02:54
 */

namespace app\Components;
use Yii;

class Pachtmarkt
{
    public $DEBUG = FALSE;

    public static function bodenmarkt($r, &$zpf, $zpp, &$vpf, $vpp, $nzp, $nvp, &$bodenpreis, &$flaechenumsatz) {

        global $DEBUG, $log; $EPSILON = 0.01;
        $log = fopen(Yii::$app->basePath."/web/files/fow.log", "w");
        if($nzp == 0 || $nvp == 0) {
            $flaechenumsatz = 0;
            $bodenpreis = 0.0;
            fputs($log, "nzp = $nzp, nvp = $nvp in Runde $r\n");
            for($i = 1; $i <= $nzp; $i++) {$zpf[$i] = 0;}
            for($i = 1; $i <= $nvp; $i++) {$vpf[$i] = 0;}
            return;
        }
        self::ndxSort($vpp, $vndx, $nvp, TRUE); // Die Angebote werden aufsteigend sortiert.
        $svpf = self::sum($vpf, $nvp);
        self::ndxSort($zpp, $zndx, $nzp, FALSE); // Die Nachfragen werden absteigend sortiert.
        $szpf = self::sum($zpf, $nzp);
        $fmax = min($szpf, $svpf);

        $f = 1;
        $v = 1; $a = $vpp[$vndx[$v]]; $fv = 1;
        $z = 1; $b = $zpp[$zndx[$z]]; $fz = 1;
        while($f < $fmax) {
            $fv += 1; if($fv > $vpf[$vndx[$v]]) { $v += 1; $a = $vpp[$vndx[$v]]; $fv = 1; }
            $fz += 1; if($fz > $zpf[$zndx[$z]]) { $z += 1; $b = $zpp[$zndx[$z]]; $fz = 1; }
            $f += 1;
        }
        if($DEBUG) {
            fputs($log, "  Angebot: (1," . $vpp[$vndx[1]] . ") -> (" . $f . "," . $a . ") -> (" . $svpf . "," . $vpp[$vndx[$nvp]] . ")\n");
            fputs($log, "Nachfrage: (1," . $zpp[$zndx[1]] . ") -> (" . $f . "," . $b . ") -> (" . $szpf . "," . $zpp[$zndx[$nzp]] . ")\n");
        }

        if($vpp[$vndx[1]] > $zpp[$zndx[1]]) {
            if($DEBUG) fputs($log, "Kein Bodenmarkt!\n");
            // Der kleinste Angebotspreis ist von Anfang an h�her als der h�chste Nachfragepreis.
            // Es kann keinen Schnittpunkt geben, oder er liegt sozusagen links der Preisachse.
            $bodenpreis = 0.5 * ($vpp[$vndx[1]] + $zpp[$zndx[1]]);
            // Niemand nimmt am Bodenmarkt teil.
            $flaechenumsatz = 0;
        } elseif($a < $b) {
            if($DEBUG) fputs($log, "Kein Schnittpunkt!\n");
            // Die Kurven schneiden sich nicht, weil ihrer eine vorher endet.
            if($szpf == $svpf) {
                $bodenpreis = 0.5 * ($a + $b);
            } elseif($f == $szpf) {
                $bodenpreis = $a;
                self::vp_ausgleich($nvp, $vpp, $vndx, $vpf, $a, $f);
            } elseif($f == $svpf) {
                $bodenpreis = $b;
                self::zp_ausgleich($nzp, $zpp, $zndx, $zpf, $b, $f);
            } else {
                fputs($log, "Schwerer Fehler im Pachtmarktprogramm!\n");
            }
            $flaechenumsatz = $f;
        } else {
            $f = 1;
            $v = 1; $a = $vpp[$vndx[$v]]; $fv = 1;
            $z = 1; $b = $zpp[$zndx[$z]]; $fz = 1;
            while($a <= $b && $f < $fmax) {
                $fv += 1; $last_a = $a; if($fv > $vpf[$vndx[$v]]) { $v += 1; $a = $vpp[$vndx[$v]]; $fv = 1; }
                $fz += 1; $last_b = $b; if($fz > $zpf[$zndx[$z]]) { $z += 1; $b = $zpp[$zndx[$z]]; $fz = 1; }
                $f += 1;
            }
            $flaechenumsatz = ($a > $b) ? $f - 1 : $fmax;

            if($a == $last_a) {
                $bodenpreis = $a;
                if($DEBUG) fputs($log, "Schnittpunkt: (" . $flaechenumsatz . ", " . $bodenpreis . ")\n");
                if($DEBUG) fputs($log, "Die Angebotstreppe geht waagerecht durch den Schnittpunkt. -> Verpachtausgleich\n");
                self::vp_ausgleich($nvp, $vpp, $vndx, $vpf, $bodenpreis, $flaechenumsatz);
            } elseif($b == $last_b) {
                $bodenpreis = $b;
                if($DEBUG) fputs($log, "Schnittpunkt: (" . $flaechenumsatz . ", " . $bodenpreis . "]\n");
                if($DEBUG) fputs($log, "Die Nachfragetreppe geht waagerecht durch den Schnittpunkt. -> Zupachtausgleich\n");
                self::zp_ausgleich($nzp, $zpp, $zndx, $zpf, $bodenpreis, $flaechenumsatz);
            } else {
                $bodenpreis = 0.5 * ($last_a + $last_b);
                $bodenpreis = min($bodenpreis, $a - $EPSILON);
                $bodenpreis = max($bodenpreis, $b + $EPSILON);
                if($DEBUG) fputs($log, "Schnittpunkt: (" . $flaechenumsatz . ", " . $bodenpreis . ")\n");
            }
        }

        $zp_sum = 0;
        for($i = 1; $i <= $nzp; $i++) {
            if($zpp[$i] < $bodenpreis) { $zpf[$i] = 0; }
            $zp_sum += $zpf[$i];
        }
        $vp_sum = 0;
        for($i = 1; $i <= $nvp; $i++) {
            if($vpp[$i] > $bodenpreis) { $vpf[$i] = 0; }
            $vp_sum += $vpf[$i];
        }
        if($vp_sum != $zp_sum || $zp_sum != $flaechenumsatz || $flaechenumsatz != $vp_sum || $DEBUG) {
            fputs($log, "FU = " . $flaechenumsatz . ", zp_sum = " . $zp_sum . ", vp_sum = " . $vp_sum . ", BP = " . $bodenpreis . "\n");
        }
    }

    public static  function ndxSort($x, &$p, $imax, $aufsteigend) {

        for($i = 1; $i <= $imax; $i++) $p[$i] = $i;

        for($i = 1; $i < $imax; $i++) {
            $k = $i;
            for($j = $i + 1; $j <= $imax; $j++) {
                if((bool)($x[$p[$j]] < $x[$p[$k]]) == $aufsteigend) $k = $j;
            }
            $j = $p[$k]; $p[$k] = $p[$i]; $p[$i] = $j;
        }
    }

    public static function sum($x, $imax) {

        $s = 0;
        for($i = 1; $i <= $imax; $i++) {
            $s += $x[$i];
        }
        return $s;
    }

    public static function vp_ausgleich($nvp, $vpp, $vndx, &$vpf, $bodenpreis, $flaechenumsatz) {

        global $DEBUG, $log;

        // Bestimme den kleinsten Index i1 und den gr��ten Index i2, derart dass
        // a[i] = bodenpreis f�r i1 <= i <= i2
        $f = 1; $v = 1; $a = $vpp[$vndx[$v]]; $fv = 1;
        while($a < $bodenpreis) {
            $f += 1; $fv += 1;
            if($fv > $vpf[$vndx[$v]]) { $v += 1; $a = $vpp[$vndx[$v]]; $fv = 1; }
        }
        $i1 = $f;
        while($a == $bodenpreis) {
            $f += 1; $fv += 1;
            if($fv > $vpf[$vndx[$v]]) {
                $v += 1;
                if($v > $nvp) break;
                $a = $vpp[$vndx[$v]]; $fv = 1;
            }
        }
        $i2 = $f - 1;
        $factor = (double)($flaechenumsatz - $i1 + 1) / (double)($i2 - $i1 + 1);
        if($DEBUG) fputs($log, "VPA: i1 = " . $i1 . ", FU = " . $flaechenumsatz . ", i2 = " . $i2 . ", fac = " . $factor . "\n");
        for($i = 1; $i <= $nvp; $i++) {
            if($vpp[$i] == $bodenpreis) {
                $vpf[$i] = round($factor * $vpf[$i], 0);
            }
        }
    }

    public static function zp_ausgleich($nzp, $zpp, $zndx, &$zpf, $bodenpreis, $flaechenumsatz) {

        global $DEBUG, $log;

        // Bestimme den kleinsten Index i1 und den gr��ten Index i2, derart dass
        // b[i] = bodenpreis f�r i1 <= i <= i2
        $f = 1; $z = 1; $b = $zpp[$zndx[$z]]; $fz = 1;
        while($b > $bodenpreis) {
            $f += 1; $fz += 1;
            if($fz > $zpf[$zndx[$z]]) { $z += 1; $b = $zpp[$zndx[$z]]; $fz = 1; }
        }
        $i1 = $f;
        while($b == $bodenpreis) {
            $f += 1; $fz += 1;
            if($fz > $zpf[$zndx[$z]]) {
                $z += 1;
                if($z > $nzp) break;
                $b = $zpp[$zndx[$z]]; $fz = 1;
            }
        }
        $i2 = $f - 1;
        $factor = (double)($flaechenumsatz - $i1 + 1) / (double)($i2 - $i1 + 1);
        if($DEBUG) fputs($log, "ZPA: i1 = " . $i1 . ", FU = " . $flaechenumsatz . ", i2 = " . $i2 . ", fac = " . $factor . "\n");
        for($i = 1; $i <= $nzp; $i++) {
            if($zpp[$i] == $bodenpreis) {
                $zpf[$i] = round($factor * $zpf[$i], 0);
            }
        }
    }
}