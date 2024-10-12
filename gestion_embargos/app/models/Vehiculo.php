<?php
class Vehiculo {
    public $matricula;
    public $marca;
    public $modelo;
    public $ano;
    public $estado;
    public $numero_identificacion;

    public function __construct($matricula, $marca, $modelo, $ano, $estado, $numero_identificacion) {
        $this->matricula = $matricula;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->ano = $ano;
        $this->estado = $estado;
        $this->numero_identificacion = $numero_identificacion;
    }
}
?>
