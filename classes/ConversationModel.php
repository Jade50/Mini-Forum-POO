<?php

    class ConversationModel extends CoreModel {

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
        //--------------------------FONCTION NB MESSAGES------------------------------
        //----------------------------------------------------------------------------

        public function nbMessages($id){

            try {

                if (($this->_req = $this->getDb()->prepare('SELECT `m_id` FROM `message`
                JOIN `conversation` ON `message`.`m_conversation_fk` = `conversation`.`c_id`
                WHERE `c_id` = ?')) !== false) {
                    
                    if (($this->_req->execute([$id])) !== false) {

                        $nbMessages = $this->_req->rowcount();   
                        // var_dump($nbMessages); 
                    }
                }

                return $nbMessages;

            } catch(PDOException $e){
            
                die($e->getMessage());        
            }   
        }

        //----------------------------------------------------------------------------
        //----------------------------FONCTION READ ALL-------------------------------
        //----------------------------------------------------------------------------
        public function readAll(){

            try {
               
                // Je cible l'objet en cours et récupère ma propriété privée _req et lui donne la valeur du résultat de ma requête 
                // getDb() est une fonction de la class CoreModel (dont ma class COnversationModel hérite) qui contient ma connexion à la base de données.
                if (($this->_req = $this->getDb()->query('SELECT * FROM `conversation`')) !== false) {
                    
                    // J'execute la requête
                    if (($this->_req->execute()) !== false) {
                        
                        // Je stocke le résultat de fetchAll dans une variable $datas// fetchAll me renvoit un tableau associatif qui contiendra toutes les conversations de ma BDD, donc je stocke ce tableau dans ma variable $datas
                        $datas = $this->_req->fetchAll(PDO::FETCH_ASSOC);

                        // Je parcours la tableau qui contient toutes mes conversations
                        foreach ($datas as $conv) {
                            
                            // Pour chaque conversation je crée une nouvelle clef que je nomme 'c_messages' (pour que l'hydratation de mon objet Conversation au moment de sa création, réagisse de la même manière avec le nom de mes méthodes setters)
                            // Donc je crée une nouvelle clef pour le nombre de messages, qui aura la valeur de l'objet en cours, auquel j'applique la méthode nbMessage que j'ai créé plus haut pour récupérer le nombre de message pour chaque conversation, et je lui passe l'id de la conversation en paramètres
                            $conv['c_nbmessages'] = $this->nbMessages($conv['c_id']);

                            // Je crée également une nouvelle clef 'c_heure' 
                            $conv['c_heure'] = date('H:i:s', strtotime($conv['c_date']));

                            $conv['c_date'] = date('d/m/Y', strtotime($conv['c_date']));

                            // Et je stocke dans un nouveau tableau $convs, un nouvel objet de ma class Conversation, en lui passant en constructeur une conversation.
                            // chaque conversation sera donc un tableau contenant les informations d'une conversation avec les clefs associatives (nom de mes colonnes en BDD, 'c_id' par exemple) et leur valeurs associées
                            $convs[] = new Conversation($conv); 
                        }
                        // Puis je retourne le tableau qui contient toutes mes conversations
                        return $convs;
                    }
                } 

            } catch (PDOException $e) {

                die($e->getMessage());
            }
        }

    }

?>