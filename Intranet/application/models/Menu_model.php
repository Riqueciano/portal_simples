<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu_model extends CI_Model
{

    public $table = 'intranet.menu';
    public $id = 'menu_id';
    public $order = 'asc';

    function __construct()
    {
        parent::__construct();
    }




    function get_menu_by_sistema($sistema_id, $pessoa_id)
    {
        $sql = "select 
                                      distinct s.*
                               from seguranca.tipo_usuario tu
                                    inner join seguranca.tipo_usuario_acao tua
                                            on tua.tipo_usuario_id = tu.tipo_usuario_id
                                    inner join seguranca.acao a	
                                            on a.acao_id = tua.acao_id 

                                    inner join seguranca.usuario_tipo_usuario utu
                                            on utu.tipo_usuario_id = tu.tipo_usuario_id
                                    inner join seguranca.secao s
                                            on s.secao_id = a.secao_id


                                    where s.secao_st = 0 and s.sistema_id = " . (int) $sistema_id . " and utu.pessoa_id = " . (int) $pessoa_id . " 
                                order by s.secao_indice  ";

        return $this->db->query($sql)->result();
    }

    function get_menu_by_secao($secao_id, $sistema_id, $pessoa_id)
    {
        $sql = "select 
                                               a.*,s.* from seguranca.tipo_usuario tu
                                    inner join seguranca.tipo_usuario_acao tua
                                            on tua.tipo_usuario_id = tu.tipo_usuario_id
                                    inner join seguranca.acao a	
                                            on a.acao_id = tua.acao_id 
                                    inner join seguranca.usuario_tipo_usuario utu
                                            on utu.tipo_usuario_id = tu.tipo_usuario_id
                                    inner join seguranca.sistema s
					    on s.sistema_id = tu.sistema_id        
                                    where a.acao_st = 0 and a.secao_id =" . $secao_id . " and s.sistema_id = " . (int) $sistema_id . " and utu.pessoa_id = " . (int) $pessoa_id . " 
                                        order by a.acao_indice  ";

        return $this->db->query($sql)->result();
    }



    // get all
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
        @$this->db->ilike('intranet.menu.menu_id', $q);
        $this->db->or_ilike('menu.menu_nm', $q);
        $this->db->or_ilike('menu.menu_icon', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->select('*');
        $this->db->order_by($this->table . '.' . $this->id, $this->order);
        @$this->db->ilike('menu.menu_id', $q);
        $this->db->or_ilike('menu.menu_nm', $q);
        $this->db->or_ilike('menu.menu_icon', $q);
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
                $where .=  " and " . $array[0] . " " . $array[1] . " '" . $array[2] . "' ";
            }
        }
        $this->db->where($where);
        $this->db->order_by('ordenacao asc');
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
    function delete($id)
    {
        $this->db->where($this->id, $id);

        if (!$this->db->delete($this->table)) {
            return 'erro_dependencia';
        }
    }
}

/* Final do arquivo Menu_model.php */
/* Local: ./application/models/Menu_model.php */
/* Data - 2019-09-25 10:59:23 */