<?php

  require_once('config/ini.php');
  require_once('config/autoload.php');

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
  
      
        <div class="section">
          <h1 class="title">CONVERSATIONS LIST</h1>
          <div class="card is-shadowless">
            <div class="card-content">
              <table class="table is-hoverable is-fullwidth">
                <thead>
                  <tr>
                    <th>Id Conv</th>
                    <th>Date Conv</th>
                    <th>Heure Conv</th>
                    <th>Nb Messages Conv</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- <tr>
                    <th>1</th>
                    <td>01/03/2012</td>
                    <td>10:21:37</td>
                    <td>100</td>
                    <td><a href="messages.php" class="button is-dark is-small">Voir messages</a></td>
                  </tr>          
                  <tr class="has-background-danger">
                    <th>2</th>
                    <td>01/02/2012</td>
                    <td>06:40:28</td>
                    <td>100</td>
                    <td><a href="messages.php" class="button is-dark is-small">Voir messages</a></td>
                  </tr>    -->

                  <?php
                    
                      $convModel = new ConversationModel;

                      $convs = $convModel->readAll();

                      foreach ($convs as $conv) {
                        ?> 
                          <tr <?php if ($conv->getTermine() == 1) {echo 'class="has-background-danger"';}  ?> >
                            <td><?= $conv->getId(); ?></td>
                            <td><?= $conv->getDate(); ?></td>
                            <td><?= $conv->getHeure(); ?></td>
                            <td><?= $conv->getnbMessages(); ?></td>
                            <td><a class="button is-dark is-small" href="<?= 'messages.php?conv='.$conv->getId().'?page=1' ?>">Voir Messages</a></td>
                          </tr>
                        <?php
                      }

                  ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      
      </div>
    </div>
    
  </body>
</html>