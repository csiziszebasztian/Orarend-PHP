<?php
    require_once("include/common_include.php") ;
    ini_set('display_errors', 1);
  

   define("ID", $_SESSION["belepett_user"]->getID()) ;

  function validateDate($date, $format = 'Y-m-d\TH:i')
  {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
  }


    if (filter_has_var(INPUT_POST, 'Idopont_felvetel') && $_POST["Idopont_felvetel"] == "1") {
        $hibauzenet = "" ;
        if (!filter_has_var(INPUT_POST, "ido") || !$Idopont_ido = filter_input(INPUT_POST, "ido")) {
            $hibauzenet .= "Nincs megadva a időpont.<br />" ;
        }
        if(!validateDate($Idopont_ido)){
            $hibauzenet .= "Nem helyes időformátum.<br />" ;
        }
        if ($hibauzenet == "") {
            try {
                    $Idopont_text =  filter_has_var(INPUT_POST, "leiras") ? filter_input(INPUT_POST, "leiras") : null ;
                    $Idopont_file =  !empty($_FILES["csatolmany"])  ?  $_FILES['csatolmany']['name'] : null;
                    $Idopont = new nep\Idopont($Idopont_ido, ID ,$Idopont_text, $Idopont_file);
                    $Idopont->mentes();
                    if($Idopont_file!==null) {
                        nep\FileManagement::feltolt(ID, $_FILES['csatolmany']);
                    }
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
    else if (filter_has_var(INPUT_POST, 'Idopont_modositas') && $_POST["Idopont_modositas"] == "1") {
        $hibauzenet = "" ;
        if (!filter_has_var(INPUT_POST, "ido") || !$Idopont_dt = filter_input(INPUT_POST, "ido")) {
            $hibauzenet .= "Nincs időpont.<br />" ;
        }
        if(!validateDate($Idopont_ido)){
            $hibauzenet .= "Nem helyes időformátum.<br />" ;
        }
        if (!filter_has_var(INPUT_POST, "Idopont_id") || !$Idopont_id = filter_input(INPUT_POST, "Idopont_id")) {
            $hibauzenet .= "Nincs időpont ID.<br />" ;
        }
        if ($hibauzenet == "") {
            try {
                    $Idopont_text =  filter_has_var(INPUT_POST, "leiras") ?  filter_input(INPUT_POST, "leiras") : null;
                    $Idopont_file =  !empty($_FILES["csatolmany"])  ?  $_FILES['csatolmany']['name'] : null;
                    $Idopont = new nep\Idopont("", null ,"", "", $Idopont_id);
                    $Idopont->setDateTime($Idopont_dt);
                    $Idopont->setText($Idopont_text) ;
                    $Idopont->setFile($Idopont_file);
                    $Idopont->mentes();
                    if($Idopont_file!==null) {
                        nep\FileManagement::torles(ID);
                    }
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
        $hibauzenet = "" ;
        if (!filter_has_var(INPUT_POST, "Idopont_id") || !$Idopont_id = filter_input(INPUT_POST, "Idopont_id")) {
            $hibauzenet .= "Nincs felhasználó ID.<br />" ;
        }
        if ($hibauzenet == "") {
            try {
                    $Idopont = new nep\Idopont("", null ,"","", $Idopont_id);
                    $Idopont->torles();
                    nep\FileManagement::torles($Idopont->getFile());
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


    if (isset($_GET['idopont_id'])) { 
        try {
            $Idopont = new nep\Idopont("", null ,"","", $_GET['idopont_id']);
            $fileName =  $Idopont->getFile();
            nep\FileManagement::letolt($fileName);

         }
       catch (Exception $e) {
           $hibauzenet = $e->getMessage() ;
         }            
      
        if ($hibauzenet == "") {
           die("sikeres_torles") ;
        }
        else{
           die($hibauzenet) ;
        }
    
    }


    else if (filter_has_var(INPUT_POST, 'idopont_kereses') && $_POST["idopont_kereses"] == "1") {
        $Idopontok = nep\Idopont::IdopontokListaja(ID);
    }
    else {
        $Idopontok = nep\Idopont::IdopontokListaja(ID);
    }

   
?>

<html>
    <head>
        <title>
            Órarend alkalmazás :: Órarendek kezelése
        </title>
        <meta charset="utf-8" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="js/orarend.js"></script>       
        <script src="js/lap.js"></script>       
        <link rel='stylesheet' href="style/stilus.css" type='text/css' media='all' />     
    </head>
    <body>
<?php
    require_once("include/menu_include.php") ;    
?>
        <div class="content">
            <p class="valaszuzenet" id="Idopont_valaszuzenet"></p>
            <div id="Idopont_felveteli_urlap_befoglalo">
                <fieldset>
                    <legend>Időpont felvétele</legend>
                    <form name="Idopont_felveteli_urlap" id="Idopont_felveteli_urlap" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>"enctype="multipart/form-data">
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
                        <input type="submit" name="mentes" id="Idopont_mentes_gomb" value="Mentés">   
                    </form>
                </fieldset>
            </div>
            <div id="Idopont_modosito_urlap_befoglalo" style="display:none;">
                <fieldset>
                    <legend>Időpont adatok módosítása</legend>
                    <form name="Idopont_modositas_urlap" id="Idopont_modositas_urlap" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>"enctype="multipart/form-data">
                        <input type="hidden" name="Idopont_modositas" id="Idopont_modositas_hidden" value="1">
                        <input type="hidden" name="Idopont_id" id="Idopont_modositas_id_hidden" value="">
                        <div class="input_mezo">
                            Időpont: <input type="datetime-local" name="ido" id="idopont_input" value="2021-09-01T00:00" min="2021-09-01T00:00" max="2021-12-10T23:00" required>*
                        </div>
                        <div class="input_mezo">
                            Leírás: <textarea id="leiras_input" name="leiras" rows="4" cols="50"></textarea>
                        </div>
                        <div class="input_mezo">
                            Csatolmány: <input type="file" name="csatolmany" id="csatolmany_input" >
                        </div> 
                        <input type="submit" name="mentes" id="Idopont_modositas_mentes_gomb" value="Mentés">   
                    </form>
                </fieldset>
            </div>
            <div>
               <h3>Órák listája</h3>
                <div id="Idopontk_lista">                                    
                    <table class="list">
                        <tr>
                            <th colspan="6">
                                <?=$_SESSION["belepett_user"]->getSubject();?>
                            </th>                            
                        </tr>
                        <tr>
                            <th>Időpont</th>
                            <th>Leírás</th>
                            <th>Csatolmány</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                    <?php
                        for ($i = 0; $i < count($Idopontok); $i++) {
                    ?>
                        <tr>
                            <td><?=$Idopontok[$i]["idopont"]?></td>
                            <td><?=$Idopontok[$i]["leiras"]?></td>
                            <td><a href="orarendkezel.php?idopont_id=<?php echo $Idopont["id"] ?>"><?=$Idopont['csatolmany']?></a></td>
                            <td><input type="button" name="modosit" id="modosit_<?=$Idopontok[$i]["id"]?>" class="Idopont_modosit_gomb" value="Módosítás"></td>
                            <td><input type="button" name="torol" id="torol_<?=$Idopontok[$i]["id"]?>" class="Idopont_torol_gomb" value="Törlés"></td>
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