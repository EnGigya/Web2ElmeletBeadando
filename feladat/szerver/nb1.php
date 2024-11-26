<?php
class Nb1 {
    /**
     * @return Klub
     */
    public function getklub(){
        $eredmeny = array("hibakod" => 0,
                              "uzenet" => "",
                              "klub" => Array());

         try { 
             $dbh = new PDO('mysql:host=127.0.0.1;dbname=nb1','root', '',
             array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION)); 
             $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci'); 

             $sql = "select id, csapatnev from klub order by id";   $sth = $dbh->prepare($sql); 
             $sth->execute(array()); 
             $eredmeny['klub'] = $sth->fetchAll(PDO::FETCH_ASSOC);
            } 
            catch (PDOException $e) { 
                $eredmeny["hibakod"] = 1; 
                $eredmeny["uzenet"] = $e->getMessage();  
            } 
            return $eredmeny;             
    } 
    /**
     * @param string $id
     * @return Labdarugo
     */
    function getlabdarugo($id){
        $eredmeny = array("hibakod" => 0,
                            "uzenet" => "", 
                            "id" => "", 
                            "csapatnev" => "", 
                            "labdarugo" => Array());
        try {
            $dbh = new PDO('mysql:host=127.0.0.1;dbname=nb1','root', '',

            array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
            $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');

            $eredmeny["id"] = $id;

            $sql = "select id, csapatnev from klub where id = :id";   $sth = $dbh->prepare($sql); 
            $sth->execute(array(":id" => $id)); 
            $csapatnev = $sth->fetch(PDO::FETCH_ASSOC); 
            $csapatid = $csapatnev["id"]; 
            $eredmeny["csapatnev"] = $csapatnev["csapatnev"]; 

            $sql = "select utonev, vezeteknev from labdarugo where klubid = :id order by klubid"; 
            $sth = $dbh->prepare($sql); 
            $sth->execute(array(":id" => $id)); 
            $eredmeny['labdarugo'] = $sth->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $e) {
            $eredmeny["hibakod"] = 1; 
             $eredmeny["uzenet"] = $e->getMessage();
        }
        return $eredmeny;
    }
}

class Klubok{
    /**
     * @var string
     */
     public $id;
     
     
     /**
     * @var string
     */
    public $csapatnev;
}

class Klub{
    /**
     * @var integer
     */
    public $hibakod;

     /**
     * @var string
     */
    public $uzenet;

   

     /**
     * @var Klubok[]
     */
    public $klub;
}

class Labdarugok{
     /**
     * @var string
     */
    public $utonev;

     /**
     * @var string
     */
    public $vezeteknev;

    
    

    
}

class Labdarugo{
     /**
     * @var integer
     */
    public $hibakod;

     /**
     * @var string
     */
    public $uzenet;

    /**
     * @var integer
     */
    public $id;
     
    /**
    * @var string
    */
   public $csapatnev;

     /**
    * @var Labdarugok[]
    */
   public $labdarugo;
}


    
?>