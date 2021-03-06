<?php

    class Message {

        private $_id;
        private $_message;
        private $_date;
        private $_heure;
        private $_auteur;
        private $_conversation;

        public function __construct($datas){
            $this->hydrate($datas);
        }

        public function getId(){
            return $this->_id;
        }

        public function setId($id){
            $this->_id = $id;
            return $this;
        }

        public function getContenu(){
            return $this->_contenu;
        }

        public function setContenu($contenu){
            $this->_contenu = $contenu;
            return $this;
        }

        public function getDate(){
            return $this->_date;
        }

        public function setDate($date){
            $this->_date = $date;
            return $this;
        }

        public function getHeure(){
            return $this->_heure;
        }

        public function setHeure($heure){
            $this->_heure = $heure;
            return $this;
        }

        public function getAuteur(){
            return $this->_auteur;
        }

        public function setAuteur($auteur){
            $this->_auteur = $auteur;
            return $this;
        }

        //----------------------------------------------------------------------------
        //----------------------------FONCTION HYDRATE--------------------------------
        //----------------------------------------------------------------------------

        // La fonction hydrate() prend en paramètres le tableau de données qui aura été passé dans le construct pour créer un objet
        public function hydrate($data){

            // $this->setLogin($data['usr_login']);

            // Je parcours ce tableau de données 
            foreach ($data as $key => $value) {
                
                // Je crée une variable $methodeName dans laquelle je stocke 'set' en chaine de caractères (le set défini le début du nom de chacune de mes méthodes Setter)
                // Puis j'appelle la fonction php ucfirst() qui prend en paramètre une string et va mettre le premier caractère de ma chaine en majuscule ( donc la majuscule qui suit le 'set' de mes méthodes setter ) 
                // Puis j'appelle la fonction substr qui supprime les caractères souhaités d'une chaine. Je lui passe donc en premier paramètre ma $ket ( qui sera le nom de mes colonnes dans ma bdd, par exemple 'c_id') puis je passe 2 en second paramètres pour récupérer ma chaine à partir du troisième caractère. Puis enfin en troisième paramètres je passe la longueur de la chaine que je veux récupérer, donc le strlen() de ma clef - les 2 premiers caractères. Ce qui me retournera pour le 'c_id' par exemple -> setId (donc le nom de ma méthode)
                $methodName = 'set'.ucfirst(substr($key, 2, strlen($key) -2));

                // Et ensuite je vérifie grace à la fonction methodexist() qui vérifie si une méthode existe pour l'objet fourni, je cible l'objet en cours, et je passe le nom de ma méthode récupérér plus haut
                if (method_exists($this, $methodName)) {

                    // Donc si cette méthode existe, je cible l'objet en cours et appelle ma méthode (ici je précise le dollar avant $methodeName car il s'agit bien d'une variable temporaire crée dans ma fonction et non d'une propriété), et je passe en paramètres de ma méthode la valeur associée à ma clef stockée en BDD
                    $this->$methodName($value);
                }
            }
        }

    }

?>