<?php
/**
 * Created by PhpStorm.
 * User: Windows 10
 * Date: 05/10/2016
 * Time: 21:43
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class TagM extends CI_Model
{

    private $table = 'TB_Tag';
    //private $viewEstabelecimentos = 'VW_Estabelecimentos2';

    /**
     * Estabelecimento constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Seleciona tag por ID
     *
     * @param $id int
     * @return CI_DB_result
     */
    public function getById($id)
    {

        return $this->db->get_where($this->table, array('CodTag' => $id));
    }

    /**
     * Seleciona tag pela View do banco
     *
     * @param array $where
     * @return CI_DB_result
     */
    public function getAllBy($where = array())
    {
        return $this->db->get_where($this->table, $where);
    }


}