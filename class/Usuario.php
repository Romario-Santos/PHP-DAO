<?php 
class Usuario {
    private $idusuario;
    private $deslogin;
    private $dessenha;
    private $dtcadastro;

    public function getId(){
        return $this->idusuario;
    }
    public function setId($value){
        $this->idusuario = $value;
    }
    public function getLogin(){
        return $this->deslogin;
    }
    public function setLogin($value){
        $this->deslogin = $value;
    }
    public function getSenha(){
        return $this->dessenha;
    }
    public function setSenha($value){
        $this->dessenha = $value;
    }
    public function getDataCadastro(){
        return $this->dtcadastro;
    }
    public function setDataCadastro($value){
        $this->dtcadastro = $value;
    }

/**
 * carregda a classe com dados da tabela tb_usuario
 * para isso passamos o id do usuario que iremos carregar
 */
    public function loadById($id){
      $sql = new Sql();
      $result = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID",array(
          ":ID"=>$id
      ));
      
      if(count($result) > 0){
      $row = $result[0];

      $this->setId($row['idusuario']);
      $this->setLogin($row['deslogin']);
      $this->setSenha($row['dessenha']);
      $this->setDataCadastro(new DateTime($row['dtcadastro']));
      }
    
    }


    public function __toString(){
        return json_encode(array(
            "idusuario"=>$this->getId(),
            "deslogin"=>$this->getLogin(),
            "dessenha"=>$this->getSenha(),
            "dtcadastro"=>$this->getDataCadastro()->format('d.m.Y H:i:s')
        ));
    }

    public static function getList(){
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin");
    }
    
    public static function search($login){

    $sql = new Sql();
    return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :LOGIN ORDER BY deslogin",array(
        ":LOGIN"=>"%".$login."%"
    ));

    }

    public function login($login,$password){
    

        $sql = new Sql();
        $result = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD",array(
            ":LOGIN"=>$login,
            ":PASSWORD"=>$password
        ));
        
        if(count($result) > 0){
        $row = $result[0];
  
        $this->setId($row['idusuario']);
        $this->setLogin($row['deslogin']);
        $this->setSenha($row['dessenha']);
        $this->setDataCadastro(new DateTime($row['dtcadastro']));
        }else{
            throw new Exception("LOGIN e/ou Senha Invalidos");
            
        }
    }
}
?>