<?php
    require_once("include/common_include.php") ;

    /*$l = new lib\Library;

    if (filter_has_var(INPUT_POST, 'kiadvany_felvetel') && $_POST["kiadvany_felvetel"] == "1") {
        $hibauzenet = "" ;
        //Megpróbáljuk felvenni a kiadványt és visszaadjuk az üzenetet a sikerességről
        if (!filter_has_var(INPUT_POST, "cim") || !$kiadvany_cim = filter_input(INPUT_POST, "cim")) {
            $hibauzenet .= "Nincs megadva a kiadvány címe.<br />" ;
        }
        if (!filter_has_var(INPUT_POST, "tipus") || !$kiadvany_tipus = filter_input(INPUT_POST, "tipus")) {
            $hibauzenet .= "Nincs megadva a kiadvány típusa.<br />" ;
        }
        if (!filter_has_var(INPUT_POST, "isbn") || !$kiadvany_isbn = filter_input(INPUT_POST, "isbn")) {
            $hibauzenet .= "Nincs megadva a ISBN azonosítója.<br />" ;
        }
        $kiadvany_szerzo = filter_input(INPUT_POST, "szerzo") ;
        $kiadvany_kulcsszavak = filter_input(INPUT_POST, "kulcsszavak") ;   
        if ($kiadvany_ar = filter_input(INPUT_POST, "ar", FILTER_SANITIZE_NUMBER_FLOAT)) {
            $kiadvany_ar = doubleval($kiadvany_ar) ;
        }
        else {
            $hibauzenet .= "Az árnak szám formátumúnak kell lennie.<br />" ;
        }
        if ($hibauzenet == "") {
            try {
                switch ($kiadvany_tipus) {
                    case "magazin": 
                        $kiadvany_evfolyam = filter_input(INPUT_POST, "evfolyam") ;
                        $kiadvany_szam = filter_input(INPUT_POST, "szam") ;
                        $kiadvany = new lib\Magazine($kiadvany_cim, $kiadvany_szerzo, $kiadvany_isbn, $kiadvany_tipus);
                        if (is_numeric($kiadvany_ar)) {
                            $kiadvany->setPrice($kiadvany_ar) ;
                        }
                        if (isset($kiadvany_evfolyam) && isset($kiadvany_szam)) {
                            $kiadvany->setSeason($kiadvany_evfolyam) ;
                            $kiadvany->setIssue($kiadvany_szam) ;
                        }
                        $kiadvany->mentes() ;
                        $kiadvany->addKeyword($kiadvany_kulcsszavak) ;
                        break;
                    case "tankonyv": 
                        $kiadvany_tema = filter_input(INPUT_POST, "tema") ;
                        $kiadvany = new lib\StudyBook($kiadvany_cim, $kiadvany_szerzo, $kiadvany_isbn, $kiadvany_tipus);
                        if (is_numeric($kiadvany_ar)) {
                            $kiadvany->setPrice($kiadvany_ar) ;
                        }
                        if (isset($kiadvany_tema)) {
                            $kiadvany->setTheme($kiadvany_tema) ;
                        }
                        $kiadvany->mentes() ;
                        $kiadvany->addKeyword($kiadvany_kulcsszavak) ;
                        break;    
                    default: 
                        $kiadvany = new lib\Book($kiadvany_cim, $kiadvany_szerzo, $kiadvany_isbn, $kiadvany_tipus);
                        if (is_numeric($kiadvany_ar)) {
                            $kiadvany->setPrice($kiadvany_ar) ;
                        }
                        $kiadvany->mentes() ;
                        $kiadvany->addKeyword($kiadvany_kulcsszavak) ;
                }
            }
            catch (\Exception $e) {
                $hibauzenet = "Nem sikerült a kiadvány felvétele: <br />" . $e->getMessage() ;
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
    else if (filter_has_var(INPUT_POST, 'kiadvany_modositas') && $_POST["kiadvany_modositas"] == "1") {
        //Megpróbáljuk módosítani a kiadványt és visszaadjuk az üzenetet a sikerességről
        $hibauzenet = "" ;
        if (!filter_has_var(INPUT_POST, "kiadvany_id") || !$kiadvany_id = filter_input(INPUT_POST, "kiadvany_id")) {
            $hibauzenet .= "Nincs kiadvány ID.<br />" ;
        }
        if (!filter_has_var(INPUT_POST, "cim") || !$kiadvany_cim = filter_input(INPUT_POST, "cim")) {
            $hibauzenet .= "Nincs megadva a kiadvány címe.<br />" ;
        }
        if (!filter_has_var(INPUT_POST, "tipus") || !$kiadvany_tipus = filter_input(INPUT_POST, "tipus")) {
            $hibauzenet .= "Nincs megadva a kiadvány típusa.<br />" ;
        }
        if (!filter_has_var(INPUT_POST, "isbn") || !$kiadvany_isbn = filter_input(INPUT_POST, "isbn")) {
            $hibauzenet .= "Nincs megadva a ISBN azonosítója.<br />" ;
        }
        $kiadvany_szerzo = filter_input(INPUT_POST, "szerzo") ;
        $kiadvany_kulcsszavak = filter_input(INPUT_POST, "kulcsszavak") ;   
        if ($kiadvany_ar = filter_input(INPUT_POST, "ar", FILTER_SANITIZE_NUMBER_FLOAT)) {
            $kiadvany_ar = doubleval($kiadvany_ar) ;
        }
        else {
            $hibauzenet .= "Az árnak szám formátumúnak kell lennie.<br />" ;
        }
        if ($hibauzenet == "") {
            try {
                switch ($kiadvany_tipus) {
                    case "magazin": 
                        $kiadvany_evfolyam = filter_input(INPUT_POST, "evfolyam") ;
                        $kiadvany_szam = filter_input(INPUT_POST, "szam") ;
                        $kiadvany = new lib\Magazine("", "", "", "", $kiadvany_id);
                        $kiadvany->setTitle($kiadvany_cim) ;
                        $kiadvany->setAuthor($kiadvany_szerzo) ;    
                        $kiadvany->setIsbn($kiadvany_isbn) ;
                        if (is_numeric($kiadvany_ar)) {
                            $kiadvany->setPrice($kiadvany_ar) ;
                            $kiadvany->setSeason($kiadvany_evfolyam) ;
                            $kiadvany->setIssue($kiadvany_szam) ;
                        }
                        $kiadvany->addKeyword($kiadvany_kulcsszavak) ;
                        $kiadvany->mentes() ;
                        break;
                    case "tankönyv": 
                        $kiadvany_tema = filter_input(INPUT_POST, "tema") ;
                        $kiadvany = new lib\StudyBook("", "", "", "", $kiadvany_id);
                        $kiadvany->setTitle($kiadvany_cim) ;
                        $kiadvany->setAuthor($kiadvany_szerzo) ;    
                        $kiadvany->setIsbn($kiadvany_isbn) ;
                        if (isset($kiadvany_tema)) {
                            $kiadvany->setTheme($kiadvany_tema) ;
                        }
                        $kiadvany->addKeyword($kiadvany_kulcsszavak) ;
                        $kiadvany->mentes() ;
                        break;    
                    default: $kiadvany = new lib\Book("", "", "", "", $kiadvany_id);
                        $kiadvany->setTitle($kiadvany_cim) ;
                        $kiadvany->setAuthor($kiadvany_szerzo) ;    
                        $kiadvany->setIsbn($kiadvany_isbn) ;
                        if (is_numeric($kiadvany_ar)) {
                            $kiadvany->setPrice($kiadvany_ar) ;
                        }
                        $kiadvany->addKeyword($kiadvany_kulcsszavak) ;
                        $kiadvany->mentes() ;
                }
            }
            catch (Exception $e) {
                $hibauzenet = "Nem sikerült a kiadvány módosítása: <br />" . $e->getMessage() ;
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
    else if (filter_has_var(INPUT_POST, 'kiadvany_torles') && $_POST["kiadvany_torles"] == "1") {
        //Megpróbáljuk törölni a kiadványt és visszaadjuk az üzenetet a sikerességről
        $hibauzenet = "" ;
        if (!filter_has_var(INPUT_POST, "kiadvany_id") || !$kiadvany_id = filter_input(INPUT_POST, "kiadvany_id")) {
            $hibauzenet .= "Nincs kiadvány ID.<br />" ;
        }
        if (!filter_has_var(INPUT_POST, "kiadvany_tipus") || !$kiadvany_tipus = filter_input(INPUT_POST, "kiadvany_tipus")) {
            $hibauzenet .= "Nincs megadva a kiadvány típusa.<br />" ;
        }
        if ($hibauzenet == "") {
            try {
                switch ($kiadvany_tipus) {
                    case "magazin": 
                        $kiadvany = new lib\Magazine("", "", "", $kiadvany_id);    
                        $kiadvany->torles() ;                        
                    break;
                    case "tankonyv": 
                        $kiadvany = new lib\StudyBook("", "", "", "", $kiadvany_id);
                        $kiadvany->torles() ;    
                    break;    
                    default: 
                        $kiadvany = new lib\Book("", "", "", "", $kiadvany_id);
                        $kiadvany->torles() ;
                }
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
    else if (filter_has_var(INPUT_POST, 'kiadvany_kereses') && $_POST["kiadvany_kereses"] == "1") {
        //A listán lefuttatjuk a szűrést, és visszaadjuk a találati listát
        $kiadvany_id = filter_input(INPUT_POST, "id") ;        
        $kiadvany_cim = filter_input(INPUT_POST, "cim") ;
        $kiadvany_tipus = filter_input(INPUT_POST, "tipus") ;
        $kiadvany_isbn = filter_input(INPUT_POST, "isbn") ;
        $kiadvany_szerzo = filter_input(INPUT_POST, "szerzo") ;
        $kiadvany_kulcsszavak = filter_input(INPUT_POST, "kulcsszo") ;        
        $szurok = array() ;
        if (strlen($kiadvany_id) > 0) {
            $szurok["id"] = $kiadvany_id ;
        }
        if (strlen($kiadvany_cim) > 0) {
            $szurok["cim"] = $kiadvany_cim ;
        }
        if (strlen($kiadvany_tipus) > 0) {
            $szurok["tipus"] = $kiadvany_tipus ;
        }
        if (strlen($kiadvany_isbn) > 0) {
            $szurok["isbn"] = $kiadvany_isbn ;
        }
        if (strlen($kiadvany_szerzo) > 0) {
            $szurok["szerzo"] = $kiadvany_szerzo ;
        }
        if (strlen($kiadvany_kulcsszavak) > 0) {
            $szurok["kulcsszo"] = $kiadvany_kulcsszavak ;
        }
        $talalatok = $l->getList("cim", $szurok) ;
        if (is_numeric($kiadvany_id)) {
            die(json_encode($talalatok)) ;
        }
        else
        {
            $html = "" ;
            if (is_array($talalatok) && count($talalatok) > 0) {
                $html = '
                <table>
                <tr>
                    <th colspan="6">
                        A könyvtárban lévő kiadványok
                    </th>                            
                </tr>
                <tr>
                    <th>Cím</th>
                    <th>Típus</th>
                    <th>ISBN</th>
                    <th>Szerző</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>' ;
                for ($i = 0; $i < count($talalatok); $i++) {
                    $html .= '        
                    <tr>
                        <td><a href="kiadvany.php?id=' . $talalatok[$i]["id"] . '" target="_blank" rel="modal:open">' . $talalatok[$i]["cim"] . '</td>
                        <td>' . $talalatok[$i]["tipus"] . '</td>
                        <td>' . $talalatok[$i]["isbn"] . '</td>
                        <td>' . $talalatok[$i]["szerzo"] . '</td>
                        <td><input type="button" name="modosit" id="modosit_' . $talalatok[$i]["id"] . '" class="kiadvany_modosit_gomb" value="Módosítás"></td>
                        <td><input type="button" name="torol" id="torol_' . $talalatok[$i]["id"] . '" class="kiadvany_torol_gomb" data-tipus="' . $talalatok[$i]["tipus"] . '" value="Törlés"></td>
                    </tr>
                    ' ;
                }
                $html .= '</table>' ;

            }
            die($html) ;
        }
    }
    else {
        $talalatok = $l->getList() ;
    }*/
?>

<html>
    <head>
        <title>
            Órarend-Alkalmazás :: Órarend
        </title>
        <meta charset="utf-8" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="js/orarend.js"></script>       
        <link rel='stylesheet' href="style/stilus.css" type='text/css' media='all' />     

        <!-- A részletes oldalt megjelenítő modal ablakhoz az alábbi két sor -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />        
    </head>
    <body>
<?php
    require_once("include/menu_include.php") ;    
?>
    
    <h1>Órarend</h1>

</body>
</html>