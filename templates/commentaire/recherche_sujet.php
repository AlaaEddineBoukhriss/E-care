<?php
session_start();
require_once ('.env');
if (isset($_GET['sujet'])){
    $sujet = (String) trim($_GET['sujet']);
    $req= $this->getDoctrine()->getManager()->flush();
    array("$sujet%");
    $req =$req->fetchAll();
    foreach ($req as $r){
        ?>
<div style="margin-top: 20px %, border-bottom: 2px solid #ccc">
    <?= $r ['sujet'].""?>
</div>
<?php
    }
}
?>