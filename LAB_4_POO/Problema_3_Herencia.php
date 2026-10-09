<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Problema 3 - Herencia Persona</title>
<style>
:root {
  --brave-orange: #FB542B; --brave-orange-light: #FF7654;
  --brave-purple: #5B2D90; --brave-dark: #212529;
  --brave-bg: #FDFDFD; --brave-gray: #F1F1F1; --brave-text: #3F3F3F;
}
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: Arial, Helvetica, sans-serif; background-color: var(--brave-bg); color: var(--brave-text); line-height: 1.6; }
header { background-color: var(--brave-dark); color: #fff; padding: 20px 40px; }
header h1 { color: var(--brave-orange); margin: 0; font-size: 1.6rem; }
.container { max-width: 700px; margin: 40px auto; background-color: #fff; border-top: 5px solid var(--brave-orange); border-radius: 8px; padding: 30px 40px; box-shadow: 0 2px 10px rgba(0,0,0,.08); }
h2 { color: var(--brave-purple); margin: 20px 0 10px; }
.resultado { background-color: var(--brave-gray); border-left: 4px solid var(--brave-orange); padding: 15px 20px; margin-top: 10px; border-radius: 4px; }
.resultado p { margin-bottom: 4px; }
hr { border: none; border-top: 1px solid #eee; margin: 20px 0; }
footer { text-align: center; padding: 15px; color: #888; font-size: .85rem; }
</style>
</head>
<body>
<header><h1>Problema 3 — Herencia: Persona → Estudiante / Docente</h1></header>
<div class="container">
<?php
class Persona {
    protected string $nombre;
    protected string $apellido;
    protected string $fechaNacimiento;

    public function __construct(string $nombre, string $apellido, string $fechaNacimiento) {
        $this->nombre          = $nombre;
        $this->apellido        = $apellido;
        $this->fechaNacimiento = $fechaNacimiento;
    }
    public function getNombre(): string         { return $this->nombre; }
    public function getApellido(): string        { return $this->apellido; }
    public function getFechaNacimiento(): string { return $this->fechaNacimiento; }
}

class Estudiante extends Persona {
    protected float $indiceAcademico;
    protected int   $cohorte;
    protected int   $estadoAcademico;
    protected int   $modalidadEstudio;

    public function __construct(float $indiceAcademico, int $cohorte, int $estadoAcademico,
                                int $modalidadEstudio, string $nombre, string $apellido, string $fechaNacimiento) {
        parent::__construct($nombre, $apellido, $fechaNacimiento);
        $this->indiceAcademico  = $indiceAcademico;
        $this->cohorte          = $cohorte;
        $this->estadoAcademico  = $estadoAcademico;
        $this->modalidadEstudio = $modalidadEstudio;
    }
    public function getIndiceAcademico(): float { return $this->indiceAcademico; }
    public function getCohorte(): int           { return $this->cohorte; }
    public function getEstadoAcademico(): int   { return $this->estadoAcademico; }
    public function getModalidadEstudio(): int  { return $this->modalidadEstudio; }
}

class Docente extends Persona {
    protected string $codigoDocente;
    protected string $departamento;
    protected string $categoria;
    protected string $tituloAcademico;
    protected string $tipoContratacion;

    public function __construct(string $codigoDocente, string $departamento, string $categoria,
                                string $tituloAcademico, string $tipoContratacion,
                                string $nombre, string $apellido, string $fechaNacimiento) {
        parent::__construct($nombre, $apellido, $fechaNacimiento);
        $this->codigoDocente    = $codigoDocente;
        $this->departamento     = $departamento;
        $this->categoria        = $categoria;
        $this->tituloAcademico  = $tituloAcademico;
        $this->tipoContratacion = $tipoContratacion;
    }
    public function getCodigoDocente(): string    { return $this->codigoDocente; }
    public function getDepartamento(): string     { return $this->departamento; }
    public function getCategoria(): string        { return $this->categoria; }
    public function getTituloAcademico(): string  { return $this->tituloAcademico; }
    public function getTipoContratacion(): string { return $this->tipoContratacion; }
}

$miEstudiante = new Estudiante(3.5, 2023, 1, 2, 'Juan', 'Pérez', '2000-05-15');
$miDocente    = new Docente('D-001', 'Sistemas Computacionales', 'Titular', 'Doctor/PhD',
                            'Tiempo Completo', 'Irina', 'Fong', '1980-03-22');
?>

  <h2>Estudiante</h2>
  <div class="resultado">
    <p><strong>Nombre:</strong> <?= htmlspecialchars($miEstudiante->getNombre()) ?></p>
    <p><strong>Apellido:</strong> <?= htmlspecialchars($miEstudiante->getApellido()) ?></p>
    <p><strong>Fecha de nacimiento:</strong> <?= htmlspecialchars($miEstudiante->getFechaNacimiento()) ?></p>
    <p><strong>Índice académico:</strong> <?= $miEstudiante->getIndiceAcademico() ?></p>
    <p><strong>Cohorte:</strong> <?= $miEstudiante->getCohorte() ?></p>
    <p><strong>Estado académico:</strong> <?= $miEstudiante->getEstadoAcademico() ?> (1 = Activo)</p>
    <p><strong>Modalidad de estudio:</strong> <?= $miEstudiante->getModalidadEstudio() ?> (2 = Presencial)</p>
  </div>

  <hr>

  <h2>Docente</h2>
  <div class="resultado">
    <p><strong>Nombre:</strong> <?= htmlspecialchars($miDocente->getNombre()) ?></p>
    <p><strong>Apellido:</strong> <?= htmlspecialchars($miDocente->getApellido()) ?></p>
    <p><strong>Fecha de nacimiento:</strong> <?= htmlspecialchars($miDocente->getFechaNacimiento()) ?></p>
    <p><strong>Código docente:</strong> <?= htmlspecialchars($miDocente->getCodigoDocente()) ?></p>
    <p><strong>Departamento:</strong> <?= htmlspecialchars($miDocente->getDepartamento()) ?></p>
    <p><strong>Categoría:</strong> <?= htmlspecialchars($miDocente->getCategoria()) ?></p>
    <p><strong>Título académico:</strong> <?= htmlspecialchars($miDocente->getTituloAcademico()) ?></p>
    <p><strong>Tipo de contratación:</strong> <?= htmlspecialchars($miDocente->getTipoContratacion()) ?></p>
  </div>

</div>
<footer>Problema 3 &mdash; Programación II, UTP</footer>
</body>
</html>