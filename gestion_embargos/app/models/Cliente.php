<?php
class Cliente {
    public $numero_identificacion;
    public $nombre;
    public $direccion;
    public $contacto;
    public $historial_embargos;
    public $historial_creditos;

    public function __construct($numero_identificacion, $nombre, $direccion, $contacto, $historial_embargos, $historial_creditos) {
        $this->numero_identificacion = $numero_identificacion;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->contacto = $contacto;
        $this->historial_embargos = $historial_embargos;
        $this->historial_creditos = $historial_creditos;
    }
}
?>