<?php

  require_once('config/ini.php');
  require_once('config/autoload.php');

  if (isset($_GET["page"]) && !empty($_GET["page"]) && $_GET["page"] > 0) {
    $_GET["page"] = intval($_GET["page"]);
    $pageCourante = $_GET["page"];
  }
  else {
    $pageCourante = 1;
  }



?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8mb4">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion forum | AdminO3W</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <style>
      .is-fullheight{
        min-height: 100vh;
      }
    </style>
  </head>
  
  <body class="has-background-light is-fullheight">
    <div class="columns is-fullheight is-marginless">
      <div class="container column is-10 ">
  
        <a href="index.php" class="button is-dark ">Retour</a>
        <div class="section">
          <h1 class="title">MESSAGES LIST</h1>
   
          <!-------------------------------------------------------------------------->
          <!---------------------------FORMULAIRE SELECT------------------------------>
          <!-------------------------------------------------------------------------->
          <form action="" method="POST" novalidate>
            <div class="field is-horizontal">
              <div class="field-label is-normal">
                <label class="label">Afficher</label>
              </div>
                <div class="field">
                  <div class="select">
                    
                    <!---------------------------SELECT LIMIT------------------------------>
                    <select name="limit">
                      <option value="20">20</option>
                      <option value="10">10</option>
                      <option value="50">50</option>
                    </select>

                  </div>
                </div>
                <div class="field">
                  <div class="select">

                    <!---------------------------SELECT TRI------------------------------>
                    <select name="tri">
                      <option value="m_date">Date</option>
                      <option value="u_nom">Auteur</option>
                      <option value="m_id">ID</option>
                    </select>

                  </div>
                </div>
                <div class="field">
                  <div class="select">

                    <!---------------------------SELECT ORDER------------------------------>
                    <select name="order">
                      <option value="DESC">Décroissant</option>
                      <option value="ASC">Croissant</option>
                    </select>

                  </div>
                </div>
                <div class="control">
                  <button class="button is-dark">Trier</button>
                </div>
            </div>
          </form>



          <div class="card is-shadowless">
            <div class="card-content">
              <table class="table is-hoverable is-fullwidth">
                <thead>
                  <tr>
                    <th><a href="">Date</a></th>
                    <th>Heure</th>
                    <th><a href="">Auteur</a></th>
                    <th>Message</th>
                  </tr>
                </thead>
                <tbody>
                
                  <!-- <tr>
                    <td>04/03/2012</td>
                    <td>19:22:58</td>
                    <td>Frye Tobias</td>
                    <td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing lacus. Ut nec urna et arcu imperdiet ullamcorper. Duis</td>
                             
                  <tr>
                    <td>04/03/2012</td>
                    <td>03:10:07</td>
                    <td>STaylor Gisela</td>
                    <td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing lacus. Ut nec</td>                   
                  </tr>   -->

                  <?php
                    
                    $messModel = new MessageModel;

                    if (!empty($_POST['limit'])) {
                      $limit = $_POST['limit'];
                    } else {
                      $limit = 10;
                    }

                    if (!empty($_POST['tri'])) {
                      $tri = $_POST['tri'];
                    } else {
                      $tri = 'm_date';
                    }

                    if (!empty($_POST['order'])) {
                      $order = $_POST['order'];
                    } else {
                      $order = NULL;
                    }

//--------------------------------------------------------------------------------------------------

                    // $MessagesParPage = $limit;
                    // $nbMessages = $bdd->query("SELECT `m_id` FROM `message` JOIN `conversation` ON `m_conversation_fk` = `c_id` WHERE `c_id` = ?");
                  
                    // $nbMessages->execute([$_GET['page']]);
                    // $TotalMessages = $nbMessages->rowCount();
                    // $pages_totales = ceil($TotalMessages / $MessagesParPage);
                  
                    // if (isset($_GET["page"]) && !empty($_GET["page"]) && $_GET["page"] > 0) {
                    //   $_GET["page"] = intval($_GET["page"]);
                    //   $pageCourante = $_GET["page"];
                    // }
                    // else {
                    //   $pageCourante = 1;
                    // }
                  
                    // $depart = ($pageCourante-1) * $MessagesParPage;

 //-------------------------------------------------------------------------------------------------- 
                    

                    $messages = $messModel->readAll($_GET['conv'], $limit, $tri, $order);

                    foreach ($messages as $message) {
                      ?> 
                          <td><?= $message->getDate(); ?></td>
                          <td><?= $message->getHeure(); ?></td>
                          <td><?= $message->getAuteur(); ?></td>
                          <td><?= $message->getContenu(); ?></td>
                        </tr>
                      <?php
                    }
                ?>

                </tbody>
              </table>

              <div>
                <?php

                  for ($i=0; $i <=5 ; $i++) { 
                    ?>
                      <a href="<?= 'messages.php?conv='.$_GET['conv'].'?page='.$i ?>"><?= $i ?></a>
                    <?php
                  }

                ?>
              </div>

              <a class="button is-light">Page précédente</a>
              <a class="button is-light">Page suivante</a>
            </div>
          </div>
        </div>
      
      </div>
    </div>
    
  </body>
</html>