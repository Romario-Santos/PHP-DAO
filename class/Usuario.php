<?php 
class Usuario {
    private $idusuario;
    private $deslogin;
    private $dessenha;
    private $dtcadastro;


    public function __construct($login = "",$senha = ""){
    
        $this->setLogin($login);
        $this->setSenha($senha);
    }

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

      $this->setData($result[0]);

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
         
            $this->setData($result[0]);

        }else{
            throw new Exception("LOGIN e/ou Senha Invalidos");
            
        }
    }

    public function setData($data){
        $this->setId($data['idusuario']);
        $this->setLogin($data['deslogin']);
        $this->setSenha($data['dessenha']);
        $this->setDataCadastro(new DateTime($data['dtcadastro']));
    }

    /**
     * para fazer um insert criamos uma procedure no banco 
     * para realizar essa ação
     */
    public function insert()
    {
        $sql = new Sql();
        $result = $sql->select("CALL sp_usuario_insert(:LOGIN, :SENHA)", array(
            ":LOGIN"=>$this->getLogin(),
            ":SENHA"=>$this->getSenha()
        ));

        if(count($result) > 0){
         
            $this->setData($result[0]);

        }
    }

    public function update($login,$senha){

        $this->setLogin($login);
        $this->setSenha($senha);

        $sql = new Sql();

        $sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID",array(
            ":LOGIN"=>$this->getLogin(),
            ":PASSWORD"=>$this->getSenha(),
            ":ID"=>$this->getId()
        ));

    }

    public function delete(){
        $sql = new Sql();
        $sql->query("DELETE FROM tb_usuarios WHERE idusuario = :ID",array(
            ":ID"=>$this->getId()
        ));
//zera dados do objeto
        $this->setId(0);
        $this->setLogin("");
        $this->setSenha("");
        $this->setDataCadastro(new DateTime());
    }
}
?>