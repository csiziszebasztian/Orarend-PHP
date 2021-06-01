<?php
    require_once("include/common_include.php") ;
    
    if (filter_has_var(INPUT_POST, 'Idopont_felvetel') && $_POST["Idopont_felvetel"] == "1") {
        $hibauzenet = "" ;
        if (!filter_has_var(INPUT_POST, "ido") || !$Idopont_ido = filter_input(INPUT_POST, "ido")) {
            $hibauzenet .= "Nincs megadva a időpont.<br />" ;
        }
        if ($hibauzenet == "") {
            try {
                    $Idopont_text =  filter_has_var(INPUT_POST, "leiras") ? filter_input(INPUT_POST, "leiras") : null ;
                    $Idopont_file =  filter_has_var(INPUT_POST, "csatolmany")   ?  filter_input(INPUT_POST, "csatolmany") : null;
                    $Idopont = new nep\Idopont($Idopont_ido, $Idopont_text, $Idopont_file, $_SESSION["belepett_user"]->getID());
                    $Idopont->mentes();
            }
            catch (Exception $e) {
                $hibauzenet = $e->getMessage() ;
            }            
        }
        if ($hibauzenet == "") {
            die("sikeres_mentes") ;
        }
        else
        {
            die($hibauzenet) ;
        }
    }
    /*else if (filter_has_var(INPUT_POST, 'Idopont_modositas') && $_POST["Idopont_modositas"] == "1") {
        //Megpróbáljuk módosítani a felhasználót és visszaadjuk az üzenetet a sikerességről
        $hibauzenet = "" ;
        //Megpróbáljuk felvenni a felhasználót és visszaadjuk az üzenetet a sikerességről
        if (!filter_has_var(INPUT_POST, "Idopont_id") || !$Idopont_id = filter_input(INPUT_POST, "Idopont_id")) {
            $hibauzenet .= "Nincs felhasználó ID.<br />" ;
        }
        if (!filter_has_var(INPUT_POST, "nev") || !$Idopont_nev = filter_input(INPUT_POST, "nev")) {
            $hibauzenet .= "Nincs megadva a felhasználó neve.<br />" ;
        }
        if (!filter_has_var(INPUT_POST, "email") || !$Idopont_email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL)) {
            $hibauzenet .= "Nincs megadva, vagy hibás a felhasználó e-mail címe.<br />" ;
        }
        else if (nep\Idopont::emailFoglaltsagEllenorzes($Idopont_email, $Idopont_id)) {
            $hibauzenet .= "Ezzel az e-mail címmel már van felvéve felhasználó.<br />" ;
        }
        $Idopont_jelszo = "" ;
        if (filter_has_var(INPUT_POST, "jelszo") && $_POST["jelszo"] != "") {
            if (!$Idopont_jelszo = filter_input(INPUT_POST, "jelszo")) {
                $hibauzenet .= "A megadott jelszó nem megfelelő.<br />" ;
            }
            else if (!filter_has_var(INPUT_POST, "jelszo_ismet") || !$Idopont_jelszo_ismet = filter_input(INPUT_POST, "jelszo_ismet")) {
                $hibauzenet .= "Nincs megadva a felhasználó jelszava ismét.<br />" ;
            }
            else if (strlen($Idopont_jelszo) < 6) {
                $hibauzenet .= "A jelszónak minimum 6 karakteresnek kell lennie.<br />" ;
            }
            else if ($Idopont_jelszo != $Idopont_jelszo_ismet) {
                $hibauzenet .= "A jelszónak és a jelszó ismét mezőnek egyeznie kell.<br />" ;
            }
        }
        if ($hibauzenet == "") {
            try {
                    $Idopont_subject = filter_input(INPUT_POST, "tantargy") ;
                    $Idopont_color = substr(filter_input(INPUT_POST, "szin"), 1) ;
                    $Idopont = new nep\Idopont("", "", "","", "", "", $Idopont_id);
                    $Idopont->setName($Idopont_nev) ;
                    $Idopont->setEmail($Idopont_email) ;
                    if ($Idopont_jelszo != "") {
                        $Idopont->setPassword($Idopont_jelszo) ;
                    }
                    if($Idopont_subject!==""){
                        $Idopont->setSubject($Idopont_subject);
                        $Idopont->setColor($Idopont_color);
                    } 
                    $Idopont->mentes() ;
            }
            catch (Exception $e) {
                $hibauzenet = $e->getMessage() ;
            }            
        }
        if ($hibauzenet == "") {
            die("sikeres_mentes") ;
        }
        else
        {
            die($hibauzenet) ;
        }        
    }
    else if (filter_has_var(INPUT_POST, 'Idopont_torles') && $_POST["Idopont_torles"] == "1") {
        //Megpróbáljuk törölni a felhasználót és visszaadjuk az üzenetet a sikerességről
        $hibauzenet = "" ;

        if (!filter_has_var(INPUT_POST, "Idopont_id") || !$Idopont_id = filter_input(INPUT_POST, "Idopont_id")) {
            $hibauzenet .= "Nincs felhasználó ID.<br />" ;
        }
        if ($hibauzenet == "") {
            try {
                    $Idopont = new nep\Idopont("", "", "","","","", $Idopont_id);
                    $Idopont->torles() ;
            }
            catch (Exception $e) {
                $hibauzenet = $e->getMessage() ;
            }            
        }
        if ($hibauzenet == "") {
            die("sikeres_torles") ;
        }
        else
        {
            die($hibauzenet) ;
        }        
    }*/
    else if (filter_has_var(INPUT_POST, 'Idopont_kereses') && $_POST["Idopont_kereses"] == "1") {
        if (filter_has_var(INPUT_POST, 'id')) {
            $keresett_id = filter_input(INPUT_POST, "id") ;
            $Idopontk = nep\Idopont::IdopontokListaja(array("id"=>$keresett_id)) ;
        }
        else
        {
            $Idopontok = nep\Idopont::IdopontokListaja() ;
        }
        die(json_encode($Idopontok)) ;
    }
    else {
        $Idopontk = nep\Idopont::IdopontokListaja() ;
    }*/
?>

<html>
    <head>
        <title>
            Órarend alkalmazás :: Órarendek kezelése
        </title>
        <meta charset="utf-8" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="js/orarend.js"></script>       
        <link rel='stylesheet' href="style/stilus.css" type='text/css' media='all' />     
    </head>
    <body>
<?php
    require_once("include/menu_include.php") ;    
?>
        <div class="content">
            <p class="valaszuzenet" id="I_valaszuzenet"></p>
            <div id="Idopont_felveteli_urlap_befoglalo">
                <fieldset>
                    <legend>Időpont felvétele</legend>
                    <form name="Idopont_felveteli_urlap" id="Idopont_felveteli_urlap">
                        <input type="hidden" name="Idopont_felvetel" id="Idopont_felvetel_hidden" value="1">
                        <div class="input_mezo">
                            Időpont: <input type="datetime-local" name="ido" id="idopont_input" value="2021-09-01T00:00" min="2021-09-01T00:00" max="2021-12-10T23:00" required>*
                        </div>
                        <div class="input_mezo">
                            Leírás: <textarea id="leiras_input" name="leiras" rows="4" cols="50"></textarea>
                        </div>
                        <div class="input_mezo">
                            Csatolmány: <input type="file" name="csatolmany" id="csatolmany_input" >
                        </div>
                        <input type="button" name="mentes" id="Idopont_mentes_gomb" value="Mentés">   
                    </form>
                </fieldset>
            </div>
            <div id="Idopont_modosito_urlap_befoglalo" style="display:none;">
                <fieldset>
                    <legend>Felhasználó adatok módosítása</legend>
                    <form name="Idopont_modositas_urlap" id="Idopont_modositas_urlap">
                        <input type="hidden" name="Idopont_modositas" id="Idopont_modositas_hidden" value="1">
                        <input type="hidden" name="Idopont_id" id="Idopont_modositas_id_hidden" value="">
                        <div class="input_mezo">
                            Neve: <input type="text" name="nev" id="Idopont_modositas_nev_input" value="" required />*
                        </div>
                        <div class="input_mezo">
                            E-mail cím: <input type="email" name="email" id="Idopont_modositas_email_input" value="" required />*
                        </div>
                        <div class="input_mezo">
                            Jelszó: <input type="password" name="jelszo" id="Idopont_modositas_jelszo_input" value="" required />*
                        </div>
                        <div class="input_mezo">
                            Jelszó ismét: <input type="password" name="jelszo_ismet" id="Idopont_modositas_jelszo_ismet_input" value="" required />*
                        </div>
                        <div class="input_mezo">
                            Szerepe: 
                            <select name="szerep" id="Idopont_modositas_szerep_select">
                                <option value="">Kérem, válasszon</option>
                                <option value="tanár">Tanár</option>
                                <option value="diák">Diák</option>
                            </select>
                        </div>
                        <div class="input_mezo plusz_mezok modosito_tanar_mezok"  style="display:none;">
                            Tantárgy: <input type="text" name="tantargy" id="modosito_tantargy_input" value="" />
                        </div>
                        <div class="input_mezo plusz_mezok modosito_tanar_mezok"  style="display:none;">
                            Szín: <input type="color" name="szin" id="modosito_szin_input" value="" />
                        </div>
                        <input type="button" name="mentes" id="Idopont_modositas_mentes_gomb" value="Mentés">   
                    </form>
                </fieldset>
            </div>
            <!--<div>
                <h3>Felhasználók listája</h3>
                <div id="Idopontk_lista">                                    
                    <table class="list">
                        <tr>
                            <th colspan="6">
                                A rendszerbe felvett felhasználók
                            </th>                            
                        </tr>
                        <tr>
                            <th>ID</th>
                            <th>Név</th>
                            <th>E-mail cím</th>
                            <th>Szerepe</th>
                            <th>Tantárgy</th>
                            <th>Szín</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                    <?php
                        for ($i = 0; $i < count($Idopontk); $i++) {
                    ?>
                        <tr>
                            <td><?=$Idopontok[$i]["id"]?></td>
                            <td><?=$Idopontok[$i]["nev"]?></td>
                            <td><?=$Idopontok[$i]["email"]?></td>
                            <td><?=$Idopontok[$i]["szerep"]?></td>
                            <td><?=$Idopontok[$i]["tantargy"]?></td>
                            <td style="background-color : #<?=$Idopontk[$i]["szin"]?>;"></td>
                            <td><input type="button" name="modosit" id="modosit_<?=$Idopontk[$i]["id"]?>" class="Idopont_modosit_gomb" value="Módosítás"></td>
                            <td><input type="button" name="torol" id="torol_<?=$Idopontk[$i]["id"]?>" class="Idopont_torol_gomb" value="Törlés"></td>
                        </tr>
                    <?php
                        }
                    ?>
                    </table>
                </div>
            </div>
        </div>-->
    </body>
</html>