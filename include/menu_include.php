<div class="user_info">
  Bejelentkezve: <?php echo $_SESSION["belepett_user"]->getName();?>
</div>
<div class="fomenu_befoglalo">
    <ul class="fomenu">
    <?php
        if($_SESSION["belepett_user"]->getRole()==="tanár"){
        echo '<li class="menupont"> <a href="users.php" id="felhasznalok_kezelese">Felhasználók kezelése</a></li>';
        echo '<li class="menupont"> <a href="orarendkezel.php" id="orarend_kezelese">Órarend kezelése</a></li>';
        }
    ?>
        <li class="menupont">
            <a href="index.php" id="orarend">Órarend</a>
        </li>
        <li class="menupont">
        <a href="logout.php" id="menupont_kijelentkezes">Kijelentkezés</a>
    </li>
    </ul>
</div>
