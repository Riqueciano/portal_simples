<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario_model extends CI_Model
{

    public $table = 'seguranca.usuario';
    public $id = 'usuario_id';
    public $order = 'DESC';




    function __construct()
    {
        parent::__construct();
    }


    function get_usuario_sipaf($usuario_email)
    {

        $usuario_email = rupper(trim($usuario_email));
        $sql = "select * from vi_login v where upper(v.usuario_login) = upper('$usuario_email') and v.sistema_id = 66";
        return $this->db->query($sql)->row();
    }

    function get_usuarios($sistema_id = 104, $tipo_usuario_id = 442, $param = '')
    {
        $sql = "select * from vi_login v
                    inner join dados_unico.pessoa p
                        on p.pessoa_id = v.pessoa_id
        where $param and p.pessoa_st =0 and sistema_id = $sistema_id and tipo_usuario_id = $tipo_usuario_id";
        return $this->db->query($sql)->result();
    }


    // get all
    function ultimo_id()
    {
        $sql = "select max(usuario_id) as usuario_id from seguranca.usuario";

        $r = $this->db->query($sql)->row();
        return $r->usuario_id;
    }

    function get_all()
    {
        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        /*ilike, or_ilike, or_not_ilike, not_ilike funções não são nativa do CI, adaptada para o Collate do PG utilizado*/

        $this->db->ilike('usuario.usuario_login', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->select('*');
        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        $this->db->ilike('usuario.usuario_login', $q);
        $this->db->join('dados_unico.pessoa', 'usuario.pessoa_id = pessoa.pessoa_id', 'left');
        $this->db->join('dados_unico.empresa', 'pessoa.empresa_id = empresa.empresa_id', 'left');
        $this->db->join('dados_unico.lotacao', 'pessoa.lotacao_id = lotacao.lotacao_id', 'left');
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    function get_limit_data_param($param)
    {
        $this->db->select('*');
        $this->db->order_by($this->table . '.' . $this->id, $this->order);

        if (!empty($param)) {
            $this->db->where($param);
        }

        $this->db->join('dados_unico.pessoa', 'usuario.pessoa_id = pessoa.pessoa_id', 'left');
        $this->db->join('dados_unico.empresa', 'pessoa.empresa_id = empresa.empresa_id', 'left');
        $this->db->join('dados_unico.lotacao', 'pessoa.lotacao_id = lotacao.lotacao_id', 'left');

        return $this->db->get($this->table)->result();
    }

    function get_all_data($param, $order = null)
    {

        $this->db->select('*');

        $where = '1=1 ';
        foreach ($param as $array) {
            //se tiver parametro
            if ($array[2] != '') {
                $where .=  " and " . $array[0] . " " . $array[1] . " '" . $array[2] . "' ";
            }
        }
        $this->db->join('dados_unico.pessoa as p2', 'usuario.pessoa_id = p2.pessoa_id', 'left');
        $this->db->join('dados_unico.empresa', 'p2.empresa_id = empresa.empresa_id', 'left');
        $this->db->join('dados_unico.lotacao', 'p2.lotacao_id = lotacao.lotacao_id', 'left');
        $this->db->where($where);
        $this->db->order_by($order);
        return $this->db->get($this->table)->result();
    } // end get_all_data
    function get_all_data_param($param, $order = null)
    {

        $this->db->select('*');


        $this->db->where($param);
        $this->db->order_by($order);
        return $this->db->get($this->table)->result();
    } // end get_all_data


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
    function delete($pessoa_id)
    {

        $sql = "delete from seguranca.usuario_tipo_usuario where pessoa_id = $pessoa_id;";
        $sql .= "delete from seguranca.usuario where pessoa_id = $pessoa_id;";


        if (!$this->db->query($sql)) {
            return 'erro_dependencia';
        }
    }
}

/* Final do arquivo Usuario_model.php */
/* Local: ./application/models/Usuario_model.php */
/* Data - 2020-01-14 13:40:42 */