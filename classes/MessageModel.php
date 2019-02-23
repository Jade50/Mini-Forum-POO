<?php

    class MessageModel extends CoreModel {

        // Je défini une propriété db et req pour la connexion à la BDD et pour les requêtes
        private $_req;

        // Quand il n'y a plus de référence sur un objet donné, le destructeur de la class se déclenche
        public function __destruct(){

            // ici je lui demande, si ma requête sql n'est pas vide
            if (!empty($this->_req)) {
                //alors je ferme l'exécution de la requête
                $this->_req->closeCursor();
            }
        }

        //----------------------------------------------------------------------------
        //-------------------------------PAGINATION-----------------------------------
        //----------------------------------------------------------------------------
        // public function page($id){

        //     $MessagesParPage = $limit;
        //     $nbMessages = $bdd->query("SELECT `m_id` FROM `message` JOIN `conversation` ON `m_conversation_fk` = `c_id` WHERE `c_id` = ?");
          
        //     $nbMessages->execute([$_GET['page']]);
        //     $TotalMessages = $nbMessages->rowCount();
        //     $pages_totales = ceil($TotalMessages / $MessagesParPage);
          
        //     if (isset($_GET["page"]) && !empty($_GET["page"]) && $_GET["page"] > 0) {
        //       $_GET["page"] = intval($_GET["page"]);
        //       $pageCourante = $_GET["page"];
        //     }
        //     else {
        //       $pageCourante = 1;
        //     }
          
        //     $depart = ($pageCourante-1) * $MessagesParPage;

        //      try {
                
        //         if (($this->_req = $this->getDb()->prepare("SELECT `m_id` FROM `message` JOIN `conversation` ON `m_conversation_fk` = `c_id` WHERE `c_id` = ?")) !== false) {
                    
        //             if (($this->_req->execute([$id])) !== false) {
                        
        //                 $totalMessages = $this->_req->rowcount();   
        //             }
        //         }

        //      } catch (PDOException $e) {
                 
        //          die($e->getMessage());
        //      }
        // }

        //----------------------------------------------------------------------------
        //----------------------------FONCTION READ ALL-------------------------------
        //----------------------------------------------------------------------------
        public function readAll($id, $limit, $tri, $order){

            try {
               
                if (($this->_req = $this->getDb()->prepare("SELECT *                                                                                      FROM `message`
                                                            JOIN `user` ON `message`.`m_auteur_fk` = `user`.`u_id`
                                                            WHERE `m_conversation_fk` = ?
                                                            ORDER BY $tri $order
                                                            LIMIT $limit")) !== false) {
                    
                    if (($this->_req->execute([$id])) !== false) {
                        
                        if (($datas = $this->_req->fetchAll(PDO::FETCH_ASSOC))!== false) {
                            
                            foreach ($datas as $message) {
                                
                                $message['m_auteur'] = $message['u_prenom'].' '.$message['u_nom'];

                                $message['m_heure'] = date('H:i:s', strtotime($message['m_date']));

                                $message['m_date'] = date('d/m/Y', strtotime($message['m_date']));
                                $messages[] = new Message($message);
                            }

                            return $messages;
                        }
                    }
                }

            } catch (PDOException $e) {

                die($e->getMessage());
            }
        }

    }

?>