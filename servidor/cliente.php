<?php

use FTP\Connection;

require_once("servidor/config.php");

class Parcela {
    public static function getAll(){
        $db= new Connection();
        $query = "SELECT * FROM parcela";
        $resultado= $db -> query($query);
        $datos = [];
        if ($resultado -> num_rows ){
            while($row = $resultado ->fetch_assoc()){
                $datos[] = [
                    'id' => $row['id'],
                    'direccion' => $row['direccion'],
                    'barrio' => $row['barrio'],
                    'superficie_edificada(m^2)' => $row['superficie_edificada(m^2)"'],
                    'superficie_parcela(m^2)' => $row['superficie_parcela(m^2)'],
                    'cant_total_unidades_funcionales"' => $row['cant_total_unidades_funcionales"'],
                    'cant_piso_sobre_rasante' => $row['cant_piso_sobre_rasante'],
                    'cant_piso_bajo_rasante' => $row['cant_piso_bajo_rasante']
                ];
            }
            return $datos;
        }
        return $datos;
    }

    public static function getWhere($id){
        $db= new Connection();
        $query = "SELECT * FROM parcela where id=$id";
        $resultado= $db -> query($query);
        $datos = [];
        if ($resultado -> num_rows ){
            while($row = $resultado ->fetch_assoc()){
                $datos[] = [
                    'id' => $row['id'],
                    'direccion' => $row['direccion'],
                    'barrio' => $row['barrio'],
                    'superficie_edificada(m^2)' => $row['superficie_edificada(m^2)"'],
                    'superficie_parcela(m^2)' => $row['superficie_parcela(m^2)'],
                    'cant_total_unidades_funcionales"' => $row['cant_total_unidades_funcionales"'],
                    'cant_piso_sobre_rasante' => $row['cant_piso_sobre_rasante'],
                    'cant_piso_bajo_rasante' => $row['cant_piso_bajo_rasante']
                ];
            }
            return $datos;
        }
        return $datos;
    }
    public static function insert($direccion,$barrio,$superficie_edificada,$superfice_parcela,$cant_tot_uf,$cant_pi_sr,$cant_pi_br){
        $db= new Connection();
        $query = "INSERT into parcela (direccion,barrio,superficie_edificada(m^2),superfice_parcela(m^2),
        cant_total_unidades_funcionales,cant_piso_sobre_rasante,cant_piso_bajo_rasante) 
        values ($direccion,$barrio,$superficie_edificada,$superfice_parcela,$cant_tot_uf,$cant_pi_sr,$cant_pi_br)";
        $resultado= $db -> query($query);
        $datos = [];
        if ($resultado -> num_rows ){
            while($row = $resultado ->fetch_assoc()){
                $datos[] = [
                    'id' => $row['id'],
                    'direccion' => $row['direccion'],
                    'barrio' => $row['barrio'],
                    'superficie_edificada(m^2)' => $row['superficie_edificada(m^2)"'],
                    'superficie_parcela(m^2)' => $row['superficie_parcela(m^2)'],
                    'cant_total_unidades_funcionales"' => $row['cant_total_unidades_funcionales"'],
                    'cant_piso_sobre_rasante' => $row['cant_piso_sobre_rasante'],
                    'cant_piso_bajo_rasante' => $row['cant_piso_bajo_rasante']
                ];
            }
            return $datos;
        }
        return $datos;
    }
}