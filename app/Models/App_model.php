<?php

class App_model extends Model{
  
private $mapper;
  
   public function __construct(){
     parent::__construct();
     $this->mapper=$this->getMapper('photos');
   } 
 
    public function home(){
    }


    /*Gestion de la carte*/

    public function mapHome()
    {
        $photo_mapper = $this->getMapper('photos');
        return $photo_mapper->find(array(), array(
            'order' => 'id_photo DESC'
        ));
    }
    
    public function getImage($params)
    {
        return $this->mapper->find(array(
            'arrondissement=?',
            $params['ardtId']
        ));
    }
    
    public function getPollution($params)
    {
        return $this->mapper->find(array(
            'pollution=?',
            $params['polId']
        ));
    }
    
    public function getPhotoUser($params)
    {
        return $this->mapper->find(array(
            'id_user=?',
            $params['userId']
        ));
    }
    

    /*Gestion des connexion et users*/

    function signin($params)
    {
        return $this->getMapper('user')->load(array(
            'pseudo=?',
            $params['login']
        ));
    }

    public function getMyAccount($params)
    {
        $userInfos = $this->dB->exec('SELECT   * FROM     `photos` p LEFT JOIN `users` u ON p.`user_id` = u.`id_user` LEFT JOIN `badges` b ON p.`user_id` = b.`user_id` WHERE    p.`user_id`= ' . $params['userId'] . ' ORDER BY `id_photo` DESC ;');
        return $userInfos;
    }
    
    public function updateAccount($nom, $anniversaire, $adresse, $mail, $phone, $userid)
    {
        $this->dB->exec('UPDATE users SET pseudo ="' . $nom . '",anniversaire="' . $anniversaire . '", adresse="' . $adresse . '",`mail`="' . $mail . '", `tel`="' . $phone . '" WHERE `id_user`=' . $userid . ';');
    }


    public function createAccount($nom,$mdp,$anniversaire,$adresse,$mail,$phone)
    {
      $this->dB->exec('INSERT INTO users (`pseudo`, `mdp`, `mail`, `adresse`, `tel`, `anniversaire`) VALUES ("'.$nom.'","'.$mdp.'","'.$mail.'","'.$adresse.'",'.$phone.','.$anniversaire.')');
    }

}
?>