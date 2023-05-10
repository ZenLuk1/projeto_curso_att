<?php

defined('BASEPATH') or exit('Ação não permitida');

class Usuarios extends CI_Controller
{

    public function index()
    {

        $data = array(
            'titulo' => 'Usuários cadastrados',
            'sub_titulo' => 'Listando todos os usuários cadastrados no banco de dados',
            'icone_view' => 'ik ik-user',
            'usuarios' => $this->ion_auth->users()->result(), //get all users  
            'perfil_usuario' => $this->ion_auth->get_users_groups()->row()
        );


        $this->load->view('layout/header', $data);
        $this->load->view('usuarios/index');
        $this->load->view('layout/footer');
    }

    public function core($usuario_id = NULL) {
    

        if (!$usuario_id) {

            exit('Pode cadastrar novo usuario');
           

            //Cadastro novo usuário

        } else {
            
            //Editar usuário

        if (!$this->ion_auth->user($usuario_id)->row()) {

            exit('Usuario não existe'); 

        } else {
                
             //Editar usuario

            $this->form_validation->set_rules('first_name', 'Nome', 'trim|required|min_lenght[5]|max_lenght[20]'); 
            $this->form_validation->set_rules('last_name', 'Sobrenome', 'trim|required|min_lenght[5]|max_lenght[20]'); 
            $this->form_validation->set_rules('username', 'usuário', 'trim|required|min_lenght[5]|max_lenght[30]|callback_username_check'); 
            $this->form_validation->set_rules('email', 'E-mail', 'trim|valid_email|required|min_lenght[5]|max_lenght[200]|callback_email_check'); 
            $this->form_validation->set_rules('password', 'Password', 'trim|min_lenght[8]|max_lenght[30]'); 
            $this->form_validation->set_rules('Confirmação', 'confirmacao', 'trim|required|min_lenght[8]|max_lenght[30]'); 

            if($this->form_validation->run()){

                echo '<pre>';
                print_r($this->input->post());
                exit();

            }else{
                
               //Erro de validação

               $data = array(

                'titulo' => 'Editar usuário',
                'sub_titulo' => 'Chegou a hora de editar o usuário',                   
                'usuarios' => $this->ion_auth->user($usuario_id)->row(), //get all users  
                    
                    
                );

                $this->load->view('layout/header', $data);
                $this->load->view('usuarios/core');
                $this->load->view('layout/footer');

            }

            



            }
        }

        

    }

    public function username_check($username) {

        $usuario_id = $this->input->post('usuario_id');

        if($this->Core_model->get_by_id('users', array('username' => $username, 'id !=>' => $usuario_id))) {

            $this->form_validation->set_message('username_check' , 'Esse usuário já existe');
            
            return FALSE;

        }else{
            
            return TRUE;
        }    

    }

    public function email_check($email) {

        $usuario_id = $this->input->post('usuario_id');

        if($this->core_model->get_by_id('users', array('username' => $email, 'id !=>' => $usuario_id))) {

            $this->form_validation->set_message('username_check' , 'Esse e-mail já existe');
            
            return FALSE;

        }else{
            
            return TRUE;
        }    

    }

}

