<?php
    require_once("include/common_include.php") ;

    $hibauzenet = "" ;
    if (filter_has_var(INPUT_POST, 'bejelentkezes') && $_POST["bejelentkezes"] == "Bejelentkezés") {
        if (!filter_has_var(INPUT_POST, "email") || !$felhasznalo_email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL)) {
            $hibauzenet .= "Nincs megadva, vagy hibás a felhasználó e-mail címe.<br />" ;
        }
        if (!filter_has_var(INPUT_POST, "jelszo") || !$felhasznalo_jelszo = filter_input(INPUT_POST, "jelszo")) {
            $hibauzenet .= "Nincs megadva felhasználó jelszava.<br />" ;
        }
        if ($hibauzenet == "") {
            try {        
                    $belepes_hiba = nep\Felhasznalo::bejelentkezes($felhasznalo_email, $felhasznalo_jelszo) ;
                    if ($belepes_hiba == "") {
                        header('Location: index.php');
                        exit;                        
                    }
                    else
                    {
                        $hibauzenet = $belepes_hiba ;
                    }
            }
            catch (Exception $e) {
                $hibauzenet = $e->getMessage() ;
            }            
        }
    }
?>    

<html>
    <head>
        <title>
            Órarend alkalmazás
        </title>
        <meta charset="utf-8" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="js/konyvtar.js"></script>       
        <link rel='stylesheet' href="style/stilus.css" type='text/css' media='all' />     
    </head>
    <body>
        <div class="content">
            <div id="bejelentkezes_urlap_befoglalo">
                <fieldset>
                    <legend>Bejelentkezés</legend>
                    <p class="valaszuzenet" id="kiadvany_felvetel_valaszuzenet"><?php echo $hibauzenet;?></p>
                    <form name="bejelentkezes_form" id="bejelentkezes_form" action="<?=$_SERVER["PHP_SELF"]?>" method="POST">
                        <div class="input_mezo">
                            E-mail cím: <input type="email" name="email" id="email_input" value="" required />*
                        </div>
                        <div class="input_mezo">
                            Jelszó: <input type="password" name="jelszo" id="jelszo_input" value="" required/>*
                        </div>
                        <input type="submit" name="bejelentkezes" id="bejelentkezes_gomb" value="Bejelentkezés">   
                    </form>
                </fieldset>
            </div>
        </div>
    </body>
</html>