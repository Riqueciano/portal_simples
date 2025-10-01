<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario_model extends CI_Model
{

    public $table = 'seguranca.usuario';
    public $id = 'pessoa_id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    function get_by_pessoa_id($pessoa_id)
    {
        $pessoa_id = (int)$pessoa_id;
        $sql = "select * from seguranca.usuario u 
                inner join dados_unico.pessoa p 
                        on p.pessoa_id = u.pessoa_id 
        where u.pessoa_id = $pessoa_id";
        return $this->db->query($sql)->row();
    }


    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        $this->db->join('dados_unico.pessoa', 'pessoa.pessoa_id = usuario.pessoa_id', 'INNER');

        return $this->db->get($this->table)->row();
    }
    function get_by_usuario($usuario_login)
    {
        $this->db->where('usuario_login', $usuario_login);
        $this->db->join('dados_unico.pessoa', 'pessoa.pessoa_id = usuario.pessoa_id', 'INNER');
        return $this->db->get($this->table)->row();
    }

    function get_by_login($usuario_login)
    {
        $this->db->where('usuario_login', $usuario_login);
        $this->db->where_not_in('usuario_login', '');
        // $this->db->join('vi_pessoa_unidade_orcamentaria2 as v', 'v.pessoa_id = usuario.pessoa_id', 'INNER');
        // $this->db->where("v.pessoa_st = 0"); //apenas pessoas ativas 
        $this->db->join('dados_unico.pessoa', 'pessoa.pessoa_id = usuario.pessoa_id', 'INNER');
        return $this->db->get($this->table)->row();
        // echo_pre($this->db->last_query());
    }
    function get_by_login_senha($usuario_login, $senha)
    {
        $where = "usuario_login = '$usuario_login' and usuario_senha = '$senha'";

        $this->db->where($where);

        $this->db->join('dados_unico.pessoa', 'pessoa.pessoa_id = usuario.pessoa_id', 'INNER');
        $this->db->where_not_in('usuario_login', '');
        // $this->db->join('vi_pessoa_unidade_orcamentaria2 as v', 'v.pessoa_id = usuario.pessoa_id', 'INNER');
        // $this->db->where("v.pessoa_st = 0"); //apenas pessoas ativas 
        return $this->db->get($this->table)->row();
        // echo_pre($this->db->last_query());
    }

    // get total rows
    function total_rows($q = NULL)
    {

        $this->db->from($this->table);
        $this->db->join('dados_unico.pessoa', 'pessoa.pessoa_id = usuario.pessoa_id', 'INNER');
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        // $this->db->select('*');
        // $this->db->order_by($this->table . '.' . $this->id, $this->order);
        // @$this->db->ilike('usuario.pessoa_id', $q);
        // $this->db->or_ilike('usuario.usuario_login', $q);
        // $this->db->or_ilike('usuario.usuario_senha', $q);
        // $this->db->or_ilike('usuario.usuario_st', $q);
        // $this->db->or_ilike('usuario.usuario_dt_criacao', $q);
        // $this->db->or_ilike('usuario.usuario_dt_alteracao', $q);
        // $this->db->or_ilike('usuario.usuario_primeiro_logon', $q);
        // $this->db->or_ilike('usuario.usuario_diaria', $q);
        // $this->db->or_ilike('usuario.usuario_login_st', $q);
        // $this->db->or_ilike('usuario.usuario_login_dt_alteracao', $q);
        // $this->db->or_ilike('usuario.usuario_login_alterador', $q);
        // $this->db->or_ilike('usuario.validade', $q);
        // $this->db->or_ilike('usuario.flag_senha_nova', $q);
        // $this->db->or_ilike('usuario.usuario_id', $q);
        $this->db->join('dados_unico.pessoa', 'pessoa.pessoa_id = usuario.pessoa_id', 'INNER');
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    function get_all_data($param, $order = null)
    {

        $this->db->select('*');

        $where = '1=1 ';
        foreach ($param as $array) {
            //se tiver parametro
            if ($array[2] != '') {
                $where .= " and " . $array[0] . " " . $array[1] . " '" . $array[2] . "' ";
            }
        }
        $this->db->join('dados_unico.pessoa', 'pessoa.pessoa_id = usuario.pessoa_id', 'INNER');
        $this->db->where($where);
        $this->db->order_by($order);
        return $this->db->get($this->table)->result();
    }

    // end get_all_data

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    // function delete($id)
    // {
    //     $this->db->where($this->id, $id);

    //     if (!$this->db->delete($this->table)) {
    //         return 'erro_dependencia';
    //     }
    // }

    function pega_perfil_sistema($sistema_id, $pessoa_id)
    {
        $sqlConsulta = "SELECT * FROM seguranca.tipo_usuario tp 
                                   , seguranca.usuario_tipo_usuario utu 
                              WHERE (tp.tipo_usuario_id = utu.tipo_usuario_id) 
                                AND sistema_id = " . $sistema_id . "  
                                AND pessoa_id  = " . $pessoa_id;

        return $this->db->query($sqlConsulta)->row();
    }

    //ignora os usuarios q tem acesso ao SIR pois possuem uma frequencia de acesso diferente
    //nao inativa motoristas
    function pega_usuarios_sem_uso($tempo_dias, $param = '')
    {
        //nao pega usuarios do SIR nem motoristas que não usam diretamente o sistema 
        $sql = "select * from seguranca.usuario u 
                        inner join dados_unico.pessoa p
                            on p.pessoa_id = u.pessoa_id
                    where u.dt_ultimo_login <= ('" . date('Y-m-d') . "'::date - $tempo_dias )
                        and p.pessoa_st = 0 /*ativo*/

                        and u.pessoa_id not in (select pessoa_id from vi_login where sistema_id in (93, 66)) /*SIR, SIPAF*/
                        and u.pessoa_id not in (select pessoa_id from vi_login where tipo_usuario_id in (443,442,441,117,483,455,440,332)) /*cotacao*/
                        and u.pessoa_id not in (select pessoa_id from dados_unico.funcionario f2 where motorista = 1) /*nao inativa motorista*/
                        
                        $param 
                ";
        // echo_pre($sql);exit;
        return $this->db->query($sql)->result();
    }
}

/* Final do arquivo Usuario_model.php */
/* Local: ./application/models/Usuario_model.php */
/* Data - 2019-09-18 11:09:36 */