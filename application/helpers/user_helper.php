<?php
/**
 * Helper referente ao usuario
 */

function getSesUser($campos = null)
{

    $valores = null;
    $ci = &get_instance();

    $ci->load->library('session');

    $user = $ci->session->userdata('usuario');

    if (count($campos) == 0) {
        return $user;
    } elseif (count($campos) == 1) {
        return $user[$campos[0]];
    } else {
        foreach ($campos as $c) {
            if (array_key_exists($c, $user)) {
                $valores[$c] = $user[$c];
            } else {
                $valores[$c] = null;
            }
        }
        return $valores;
    }
}

function setSesUsuario($usuario)
{
    $ci = &get_instance();
    $ci->load->model('LocalizacaoM', 'localizacao');
    $ci->load->model('UsuarioM', 'usuario');
    $ci->load->model('PermissaoM', 'permissao');

    $session['usuario'] = $usuario;
    if (isset($usuario['LocalizacaoCod'])) {
        $session['localizacao'] = $ci->localizacao->getById($usuario['LocalizacaoCod'])->result_array()[0];
    }
    $session['permissao'] = $ci->permissao->getWhere(['CodPermissao' => $usuario['PermissaoCod']])->result_array()[0];
    $ci->session->unset_userdata('usuario');
    $ci->session->unset_userdata('localizacao');
    $ci->session->unset_userdata('permissao');
    $ci->session->set_userdata($session);
}

function getSesLocalizacao($campos = null)
{

    $valores = null;
    $ci = &get_instance();

    $ci->load->library('session');

    $location = $ci->session->userdata('localizacao');

    if (count($campos) == 0) {
        return $location;
    } elseif (count($campos) == 1) {
        return $location[$campos[0]];
    } else {
        foreach ($campos as $c) {
            if (array_key_exists($c, $location)) {
                $valores[$c] = $location[$c];
            } else {
                $valores[$c] = null;
            }
        }
        return $valores;
    }
}

function setSesLocation($location)
{
    $ci = &get_instance();
    $session['localizacao'] = $location;

    $ci->session->unset_userdata('localizacao');

    $ci->session->set_userdata($session);
}

function getSesPermissao($campos = null)
{

    $valores = null;
    $ci = &get_instance();

    $ci->load->library('session');

    $permissao = $ci->session->userdata('permissao');

    if (count($campos) == 0) {
        return $permissao;
    } elseif (count($campos) == 1) {
        return $permissao[$campos[0]];
    } else {
        foreach ($campos as $c) {
            if (array_key_exists($c, $permissao)) {
                $valores[$c] = $permissao[$c];
            } else {
                $valores[$c] = null;
            }
        }
        return $valores;
    }
}