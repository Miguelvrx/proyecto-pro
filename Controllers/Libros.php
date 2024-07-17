<?php
class Libros extends Controller{
    public function __construct(){
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: ".base_url);
        }
        parent::__construct();
        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user,"Libros");
        if (!$perm && $id_user != 1) {
            $this->views->getView($this, "permisos");
            exit;
        }
    }

    public function index(){
        $this->views->getView($this, "index");
    }

    public function listar()
    {
        $data = $this->model->getLibros();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['foto'] = '<img class="img-thumbnail" src="' . base_url . "Assets/img/libros/" . $data[$i]['imagen'] . '" width="100">';
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Ativo</span>';
                $data[$i]['acciones'] = '<div class="d-flex">
                <button class="btn btn-primary" type="button" onclick="btnEditarLibro(' . $data[$i]['id'] . ');"><i class="fa fa-pencil-square-o"></i></button>
                <button class="btn btn-danger" type="button" onclick="btnEliminarLibro(' . $data[$i]['id'] . ');"><i class="fa fa-trash-o"></i></button>
                <div/>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inativo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarLibro(' . $data[$i]['id'] . ');"><i class="fa fa-reply-all"></i></button>
                <div/>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrar()
    {
        $titulo = strClean($_POST['titulo']);
        $autor = strClean($_POST['autor']);
        $editorial = strClean($_POST['editorial']);
        $materia = strClean($_POST['materia']);
        $cantidad = strClean($_POST['cantidad']);
        $num_pagina = strClean($_POST['num_pagina']);
        $anio_edicion = strClean($_POST['anio_edicion']);
        $descripcion = strClean($_POST['descripcion']);
        $id = strClean($_POST['id']);
        $img = $_FILES['imagen'];
        $name = $img['name'];
        $fecha = date("YmdHis");
        $tmpName = $img['tmp_name'];
        if (empty($titulo) || empty($autor) || empty($editorial) || empty($materia) || empty($cantidad)) {
            $msg = array('msg' => 'Todos los campos son obligatorios!', 'icono' => 'warning');
        } else {
            if (!empty($name)) {
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                $formatos_permitidos =  array('png', 'jpeg', 'jpg');
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                if (!in_array($extension, $formatos_permitidos)) {
                    $msg = array('msg' => 'Tipo de archivo no permitido!', 'icono' => 'warning');
                } else {
                    $imgNombre = $fecha . ".jpg";
                    $destino = "Assets/img/libros/" . $imgNombre;
                }
            } else if (!empty($_POST['foto_actual']) && empty($name)) {
                $imgNombre = $_POST['foto_actual'];
            } else {
                $imgNombre = "logo.png";
            }
            if ($id == "") {
                $data = $this->model->insertarLibros($titulo, $autor, $editorial, $materia, $cantidad, $num_pagina, $anio_edicion, $descripcion, $imgNombre);
                if ($data == "ok") {
                    if (!empty($name)) {
                        move_uploaded_file($tmpName, $destino);
                    }
                    $msg = array('msg' => 'Libro registrado exitosamente!', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'Este libro ya existe.!', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar el libro.!', 'icono' => 'error');
                }
            } else {
                $imgDelete = $this->model->editLibros($id);
                if ($imgDelete['imagen'] != 'logo.png') {
                    if (file_exists("Assets/img/libros/" . $imgDelete['imagen'])) {
                        unlink("Assets/img/libros/" . $imgDelete['imagen']);
                    }
                }
                $data = $this->model->actualizarLibros($titulo, $autor, $editorial, $materia, $cantidad, $num_pagina, $anio_edicion, $descripcion, $imgNombre, $id);
                if ($data == "modificado") {
                    if (!empty($name)) {
                        move_uploaded_file($tmpName, $destino);
                    }
                    $msg = array('msg' => 'Libro actualizado correctamente', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al actualizar el libro!', 'icono' => 'error');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar($id)
    {
        $data = $this->model->editLibros($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }




}
?>