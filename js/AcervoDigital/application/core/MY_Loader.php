<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class MY_Loader extends MX_Loader {

    // Outros métodos já existentes...

    /**
     * Carrega um service.
     *
     * @param string $service Nome do service
     * @param string $name Nome alternativo para a instância
     */
    public function service($service, $name = '') {
        if (empty($service)) {
            return;
        }
    
        $path = APPPATH . 'services/' . $service . '.php';
        $path = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $path);
    
        if (file_exists($path)) {
            require_once($path);
    
            $segments = explode('/', $service);
            $class = end($segments);
    
            // Se o nome personalizado não for passado, usa exatamente o nome da classe (case-sensitive)
            if (empty($name)) {
                $name = $class; // preserva maiúsculas/minúsculas do nome da classe
            }
    
            $CI =& get_instance();
    
            if (!isset($CI->$name)) {
                $CI->$name = new $class();
            }
        } else {
            show_error("Unable to locate the service you have specified: {$service}. Procurado em: {$path}");
        }
    }
    
    
}