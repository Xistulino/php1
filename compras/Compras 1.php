<?php

defined ('BASEPATH') or exit('No direct script access allowed');

class M_usuario extends CI_Model{
    public function inserir($usuario, $senha, $nome, $tipo_usuario, $usu_sistema){
        //Query de inserção de dados
        $sql = "insert into usuarios (usuario, senha, nome, tipo)
                          values('$usuario', md5('$senha'), '$nome', '$tipo_usuario')";
        $this->db->query($sql);
       
         //Verificar se a inserção ocorreu com sucesso
         if($this->db->affected_rows() >0){
            //Fazemos a inserção no Log na nuvem
            //fazemos a instância da model M_log
            $this->load->model('m_log');

            //Fazemos a chamada do método de inserção do Log
            $retorno_log = $this->m_log->inserir_log($usu_sistema, $sql);

            if($retorno_log ['codigo'] ==1){
              $dados = array('codigo' => 1,
                              'msg' => 'Usuário cadastro corretamente');
            }else{
              $dados = array('codigo' => 8,
                               'msg' => 'Houve algum problema no salvamento do Log, porém, 
                                         usuário cadastrado corretamente');    
           }
           
        }else{
            $dados = array('codigo' => 6,
                           'msg' => 'Houve algum problema na inserção na tabela de usuários');
        
        }
        return $dados;
    
    } 
    public function consultar($usuario, $nome, $tipo_usuario){
        $sql = "select * from usuarios where estatus = '' ";

        if(trim($usuario) != ''){
            $sql = $sql . "and tipo = '$usuario' ";
        
        }if(trim($tipo_usuario) != ''){
            $sql = $sql . "and tipo = '$tipo_usuario' ";
        
        }if(trim($nome) != ''){
            $sql = $sql . "and nome like '%nome%'";
        }

        $retorno = $this->db->query($sql);


        if($retorno->num_rows() >0){
            $dados = array('codigo' => 1,
                            'msg' => 'Consulta efetuada com sucesso!',
                            'dados'=> $retorno->result());
        }else{
            $dados = array('codigo' => 6,
                            'msg' => 'Dados não encontrados');
        
        }                
        return $dados;
    }
    public function alterar($usuario, $senha, $nome, $tipo_usuario, $usu_sistema){
         
        $sql = "update usuarios set nome = '$nome', senha = md5('$senha'),
         tipo = '$tipo_usuario' where usuario = '$usuario'";

        $this->db->query($sql);
        
         if($this->db->affected_rows() >0){

            $this->load->model('m_log');

            $retorno_log = $this->m_log->inserir_log($usu_sistema, $sql);

            if($retorno_log ['codigo'] ==1){
            $dados = array('codigo' => 1,
                            'msg' => 'Usuário alterado corretamente');
            }else{
                $dados = array('codigo' => 8,
                                 'msg' => 'Houve algum problema no salvamento do Log, porém, 
                                           usuário excluido corretamente');    
            }
        }else{
            $dados = array('codigo' => 6,
                        'msg' => 'Houve algum problema na alteração na tabela de usuários');

        }
        return $dados;
         
    }
    public function desativar($usuario, $usu_sistema){
        //Query de atualização dos dados

        $sql = "update usuarios set estatus = 'D'
        where usuario = '$usuario'";
        
        $this->db->query($sql);
        
        //Verificar se a atualização ocorreu com sucesso
        if($this->db->affected_rows() > 0){

           $this->load->model('m_log');

           $retorno_log = $this->m_log->inserir_log($usu_sistema, $sql);

           if($retorno_log ['codigo'] ==1){
              $dados = array('codigo' => 1,
                         'msg'=> 'Usuário DESATIVO corretamente');

          }else{
            $dados = array('codigo' => 8,
                             'msg' => 'Houve algum problema no salvamento do Log, porém, 
                                       usuário excluido corretamente');    
         }
        }else{
            $dados = array('codigo' => 6,
                            'msg' => 'Houve algum problema na DESATIVAÇÃO do usuário ');
        }
        //Envia o array $dados com as informações tratadas
    //acima pela estrutura de decisão if 
    
    return $dados;
    }  
}  
?>