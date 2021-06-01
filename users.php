<?php
    require_once("include/common_include.php") ;

    if (filter_has_var(INPUT_POST, 'felhasznalo_felvetel') && $_POST["felhasznalo_felvetel"] == "1") {
        $hibauzenet = "" ;
        if (!filter_has_var(INPUT_POST, "nev") || !$felhasznalo_nev = filter_input(INPUT_POST, "nev")) {
            $hibauzenet .= "Nincs megadva a felhasználó neve.<br />" ;
        }
        if (!filter_has_var(INPUT_POST, "email") || !$felhasznalo_email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL)) {
            $hibauzenet .= "Nincs megadva, vagy hibás a felhasználó e-mail címe.<br />" ;
        }
        else if (nep\Felhasznalo::emailFoglaltsagEllenorzes($felhasznalo_email)) {
            $hibauzenet .= "Ezzel az e-mail címmel már van felvéve felhasználó.<br />" ;
        }
        if (!filter_has_var(INPUT_POST, "jelszo") || !$felhasznalo_jelszo = filter_input(INPUT_POST, "jelszo")) {
            $hibauzenet .= "Nincs megadva felhasználó jelszava.<br />" ;
        }
        else if (!filter_has_var(INPUT_POST, "jelszo_ismet") || !$felhasznalo_jelszo_ismet = filter_input(INPUT_POST, "jelszo_ismet")) {
            $hibauzenet .= "Nincs megadva a felhasználó jelszava ismét.<br />" ;
        }
        else if (strlen($felhasznalo_jelszo) < 6) {
            $hibauzenet .= "A jelszónak minimum 6 karakteresnek kell lennie.<br />" ;
        }
        else if ($felhasznalo_jelszo != $felhasznalo_jelszo_ismet) {
            $hibauzenet .= "A jelszónak és a jelszó ismét mezőnek egyeznie kell.<br />" ;
        }
        if (!filter_has_var(INPUT_POST, "szerep") || !$felhasznalo_szerep = filter_input(INPUT_POST, "szerep")) {
            $hibauzenet .= "Nincs megadva a felhasználó szerepe.<br />" ;
        }
        if ($hibauzenet == "") {
            try {
                    $felhasznalo_subject = filter_input(INPUT_POST, "tantargy") ;
                    $felhasznalo_color = substr(filter_input(INPUT_POST, "szin"), 1) ;
                    $felhasznalo = new nep\Felhasznalo($felhasznalo_nev, $felhasznalo_email, $felhasznalo_jelszo, $felhasznalo_szerep);
                    if($felhasznalo_szerep==="tanár"){
                        $felhasznalo->setSubject($felhasznalo_subject);
                        $felhasznalo->setColor($felhasznalo_color);
                    }
                    $felhasznalo->mentes();
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
    else if (filter_has_var(INPUT_POST, 'felhasznalo_modositas') && $_POST["felhasznalo_modositas"] == "1") {
        //Megpróbáljuk módosítani a felhasználót és visszaadjuk az üzenetet a sikerességről
        $hibauzenet = "" ;
        //Megpróbáljuk felvenni a felhasználót és visszaadjuk az üzenetet a sikerességről
        if (!filter_has_var(INPUT_POST, "felhasznalo_id") || !$felhasznalo_id = filter_input(INPUT_POST, "felhasznalo_id")) {
            $hibauzenet .= "Nincs felhasználó ID.<br />" ;
        }
        if (!filter_has_var(INPUT_POST, "nev") || !$felhasznalo_nev = filter_input(INPUT_POST, "nev")) {
            $hibauzenet .= "Nincs megadva a felhasználó neve.<br />" ;
        }
        if (!filter_has_var(INPUT_POST, "email") || !$felhasznalo_email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL)) {
            $hibauzenet .= "Nincs megadva, vagy hibás a felhasználó e-mail címe.<br />" ;
        }
        else if (nep\Felhasznalo::emailFoglaltsagEllenorzes($felhasznalo_email, $felhasznalo_id)) {
            $hibauzenet .= "Ezzel az e-mail címmel már van felvéve felhasználó.<br />" ;
        }
        $felhasznalo_jelszo = "" ;
        if (filter_has_var(INPUT_POST, "jelszo") && $_POST["jelszo"] != "") {
            if (!$felhasznalo_jelszo = filter_input(INPUT_POST, "jelszo")) {
                $hibauzenet .= "A megadott jelszó nem megfelelő.<br />" ;
            }
            else if (!filter_has_var(INPUT_POST, "jelszo_ismet") || !$felhasznalo_jelszo_ismet = filter_input(INPUT_POST, "jelszo_ismet")) {
                $hibauzenet .= "Nincs megadva a felhasználó jelszava ismét.<br />" ;
            }
            else if (strlen($felhasznalo_jelszo) < 6) {
                $hibauzenet .= "A jelszónak minimum 6 karakteresnek kell lennie.<br />" ;
            }
            else if ($felhasznalo_jelszo != $felhasznalo_jelszo_ismet) {
                $hibauzenet .= "A jelszónak és a jelszó ismét mezőnek egyeznie kell.<br />" ;
            }
        }
        if ($hibauzenet == "") {
            try {
                    $felhasznalo_subject = filter_input(INPUT_POST, "tantargy") ;
                    $felhasznalo_color = substr(filter_input(INPUT_POST, "szin"), 1) ;
                    $felhasznalo = new nep\Felhasznalo("", "", "","", "", "", $felhasznalo_id);
                    $felhasznalo->setName($felhasznalo_nev) ;
                    $felhasznalo->setEmail($felhasznalo_email) ;
                    if ($felhasznalo_jelszo != "") {
                        $felhasznalo->setPassword($felhasznalo_jelszo) ;
                    }
                    if($felhasznalo_subject!==""){
                        $felhasznalo->setSubject($felhasznalo_subject);
                        $felhasznalo->setColor($felhasznalo_color);
                    } 
                    $felhasznalo->mentes() ;
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
    else if (filter_has_var(INPUT_POST, 'felhasznalo_torles') && $_POST["felhasznalo_torles"] == "1") {
        //Megpróbáljuk törölni a felhasználót és visszaadjuk az üzenetet a sikerességről
        $hibauzenet = "" ;

        if (!filter_has_var(INPUT_POST, "felhasznalo_id") || !$felhasznalo_id = filter_input(INPUT_POST, "felhasznalo_id")) {
            $hibauzenet .= "Nincs felhasználó ID.<br />" ;
        }
        if ($hibauzenet == "") {
            try {
                    $felhasznalo = new nep\Felhasznalo("", "", "","","","", $felhasznalo_id);
                    $felhasznalo->torles() ;
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
    }
    else if (filter_has_var(INPUT_POST, 'felhasznalo_kereses') && $_POST["felhasznalo_kereses"] == "1") {
        if (filter_has_var(INPUT_POST, 'id')) {
            $keresett_id = filter_input(INPUT_POST, "id") ;
            $felhasznalok = nep\Felhasznalo::felhasznalokListaja(array("id"=>$keresett_id)) ;
        }
        else
        {
            $felhasznalok = nep\Felhasznalo::felhasznalokListaja() ;
        }
        die(json_encode($felhasznalok)) ;
    }
    else {
        $felhasznalok = nep\Felhasznalo::felhasznalokListaja() ;
    }
?>

<html>
    <head>
        <title>
            Órarend alkalmazás :: Felhasználók kezelése
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
            <p class="valaszuzenet" id="felhasznalo_valaszuzenet"></p>
            <div id="felhasznalo_felveteli_urlap_befoglalo">
                <fieldset>
                    <legend>Felhasználó felvétele</legend>
                    <form name="felhasznalo_felveteli_urlap" id="felhasznalo_felveteli_urlap">
                        <input type="hidden" name="felhasznalo_felvetel" id="felhasznalo_felvetel_hidden" value="1">
                        <div class="input_mezo">
                            Neve: <input type="text" name="nev" id="nev_input" value="" required />*
                        </div>
                        <div class="input_mezo">
                            E-mail cím: <input type="email" name="email" id="email_input" value="" required />*
                        </div>
                        <div class="input_mezo">
                            Jelszó: <input type="password" name="jelszo" id="jelszo_input" value="" required />*
                        </div>
                        <div class="input_mezo">
                            Jelszó ismét: <input type="password" name="jelszo_ismet" id="jelszo_ismet_input" value="" required />*
                        </div>
                        <div class="input_mezo">
                            Szerepe: 
                            <select name="szerep" id="szerep_select">
                                <option value="">Kérem, válasszon</option>
                                <option value="tanár">Tanár</option>
                                <option value="diák">Diák</option>
                            </select>
                        </div>
                        <div class="input_mezo plusz_mezok tanar_mezok" style="display:none;">
                            Tantárgy: <input type="text" name="tantargy" id="tantargy_input" value="" />
                        </div>
                        <div class="input_mezo plusz_mezok tanar_mezok" style="display:none;">
                            Szín: <input type="color" name="szin" id="szin_input" value="" />
                        </div>
                        <input type="button" name="mentes" id="felhasznalo_mentes_gomb" value="Mentés">   
                    </form>
                </fieldset>
            </div>
            <div id="felhasznalo_modosito_urlap_befoglalo" style="display:none;">
                <fieldset>
                    <legend>Felhasználó adatok módosítása</legend>
                    <form name="felhasznalo_modositas_urlap" id="felhasznalo_modositas_urlap">
                        <input type="hidden" name="felhasznalo_modositas" id="felhasznalo_modositas_hidden" value="1">
                        <input type="hidden" name="felhasznalo_id" id="felhasznalo_modositas_id_hidden" value="">
                        <div class="input_mezo">
                            Neve: <input type="text" name="nev" id="felhasznalo_modositas_nev_input" value="" required />*
                        </div>
                        <div class="input_mezo">
                            E-mail cím: <input type="email" name="email" id="felhasznalo_modositas_email_input" value="" required />*
                        </div>
                        <div class="input_mezo">
                            Jelszó: <input type="password" name="jelszo" id="felhasznalo_modositas_jelszo_input" value="" required />*
                        </div>
                        <div class="input_mezo">
                            Jelszó ismét: <input type="password" name="jelszo_ismet" id="felhasznalo_modositas_jelszo_ismet_input" value="" required />*
                        </div>
                        <div class="input_mezo">
                            Szerepe: 
                            <select name="szerep" id="felhasznalo_modositas_szerep_select">
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
                        <input type="button" name="mentes" id="felhasznalo_modositas_mentes_gomb" value="Mentés">   
                    </form>
                </fieldset>
            </div>
            <div>
                <h3>Felhasználók listája</h3>
                <div id="felhasznalok_lista">                                    
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
                        for ($i = 0; $i < count($felhasznalok); $i++) {
                    ?>
                        <tr>
                            <td><?=$felhasznalok[$i]["id"]?></td>
                            <td><?=$felhasznalok[$i]["nev"]?></td>
                            <td><?=$felhasznalok[$i]["email"]?></td>
                            <td><?=$felhasznalok[$i]["szerep"]?></td>
                            <td><?=$felhasznalok[$i]["tantargy"]?></td>
                            <td style="background-color : #<?=$felhasznalok[$i]["szin"]?>;"></td>
                            <td><input type="button" name="modosit" id="modosit_<?=$felhasznalok[$i]["id"]?>" class="felhasznalo_modosit_gomb" value="Módosítás"></td>
                            <td><input type="button" name="torol" id="torol_<?=$felhasznalok[$i]["id"]?>" class="felhasznalo_torol_gomb" value="Törlés"></td>
                        </tr>
                    <?php
                        }
                    ?>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>