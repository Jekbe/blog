<header class="container">
    <h1>Draw&play</h1>
    <?php
        $nick = $_SESSION["nick"];
        $awatar = $_SESSION["awatar"];
        $user_id = $_SESSION["id"];
        $portfel = $_SESSION["portfel"];
        echo "<a href='/blog/Profile/Profil.php?id=$user_id'>$nick <img src='$awatar' width='20px'></a> $portfel krd <br>";
    ?>
    <a href='/../blog/Login and register/Logout.php' class="button">Wyloguj się</a>
</header>