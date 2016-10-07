<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Estabelecimento extends CI_Controller
{
    /**
     * Perfil constructor.
     */
    public function __construct()
    {
        parent::__construct();


        /** Carregamento de models */
        $this->load->model('EstabelecimentoM', 'estabelecimento');
    }

    public function busca(){
        $this->output->set_content_type('application/json');
        $where = null;
//        $where = [
//            "EsNome" => $this->uri->segment(4),
//            "UsNome" => $this->uri->segment(5),
//        ];

        $valores = $this->estabelecimento->getAllBy($where)->result_array();

        foreach ($valores as $valor){

            $saida[] = [
                "categoria" => $valor['CaNome'],
                "nome" => $valor['EsNome'],
                "descricao" => $valor['EsDescricao'],
                "foto" => $valor['EsFoto'],
                "lat" => $valor['LoLatitude'],
                "long" => $valor['LoLongitude'],
                "tipoContato" => $valor['CoNome'],
                "contato" => $valor['CoValor']
            ];
        }

        if (!isset($saida)){
            $saida[] = ["nome" => "Nenhum resultado"];
        }

        echo json_encode($saida);
    }

    public function buscaEstabelecimentoCategoria($id = null)
    {
        $this->output->set_content_type('application/json');
        $where = [
            "CaCodCategoria" => $this->uri->segment(4),
        ];

        $valores = $this->estabelecimento->getAllBy($where)->result_array();

        foreach ($valores as $valor) {

            $saida[] = [
                "categoria" => $valor['CaNome'],
                "nome" => $valor['EsNome'],
                "descricao" => $valor['EsDescricao'],
                "foto" => $valor['EsFoto'],
                "lat" => $valor['LoLatitude'],
                "long" => $valor['LoLongitude'],
                "tipoContato" => $valor['CoTelefonePrincipal'],
                "contato" => $valor['CoTelefoneSecundario']
            ];
        }

        if (isset($saida)) {
            echo json_encode($saida);
        }

    }


}