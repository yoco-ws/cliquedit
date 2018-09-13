<?php 
namespace CE;

class CliquedIt{

    // Instancia de Singleton 
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            session::apiKey();
            self::$instance = new CliquedIt();
        }

        return self::$instance;
    }

    //Relaciones con los otros objetos singleton
    public function text(){
        return txt::getInstance();
    }

    public function image(){
        return img::getInstance();
    }

    public function link(){
        return a::getInstance();
    }

    public function video(){
        return video::getInstance();
    }

    public function audio(){
        return audio::getInstance();
    }

    public function embed(){
        return embed::getInstance();
    }

    public function composed(){
        return composed::getInstance();
    }

    public function page(){
        return page::getInstance();
    }

    public function collection(){
        return category::getInstance();
    }

    //Verificar si actualmente se encuentra en modo editor

    public function isEditMode(){
        return session::isEditMode();
    }

    //Llama los archivos necesarios para permitir la edición si hay una sesión iniciada

    public function loadEditor(){
        session::loadEditor();
    }

    // Prevenir la creacion de la clase por el constructor o por clonacion
    private function __construct() { }

    private function __clone() { }

    //Contenedor de instancia de la clase
    private static $instance = NULL;
}

?>