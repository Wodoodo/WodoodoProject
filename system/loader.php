<?php
    final class Loader{
        private $registry;

        public function __construct($registry){
            $this->registry = $registry;
        }

        public function controller($route, $data = array()){
            $parts = explode('/',str_replace('../','',(string)$route));

            while ($parts){
                $file = CONTROLLER_DIRECTORY . implode('/', $parts) . '.php';
                $class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', implode('/', $parts));
                if (is_file($file)){
                    include_once($file);
                    break;
                } else {
                    $method = array_pop($parts);
                }
            }

            $controller = new $class($this->registry);

            if (!isset($method)){
                $method = 'index';
            }

            if (substr($method, 0 ,2) == '__'){
                return false;
            }

            $function = array($controller, $method);

            if (is_callable($function, true, $callableName)){
                $output = $controller->$method();
            } else {
                trigger_error('Error: Could not load controller ' . $file . '!');
                exit();
            }

            return $output;
        }

        public function model($model, $data = array()){
            $parts = explode('/', str_replace('../', '', (string)$model));
            while ($parts){
                $file = MODEL_DIRECTORY . implode('/', $parts) . '.php';
                $class = 'Model' . preg_replace('/[^a-zA-Z0-9]/', '', implode('/', $parts));
                if (is_file($file)){
                    include_once($file);
                    $this->registry->set('model_' . str_replace('/', '_', $model), new $class($this->registry));
                    break;
                }
            }
        }

        public function view($template, $data = array()){
            $file = VIEW_DIRECTORY . $template . $this->registry->get('devicePrefix') . '.tpl';

            file_exists($file) ? '' : $file = VIEW_DIRECTORY . $template . '.tpl';

            if (file_exists($file)){
                $data['registry'] = $this->registry;
                extract($data);
                require($file);
                $output = ob_get_contents();
            } else {
                trigger_error('Error: Could not load template ' . $file . '!');
            }

            return $output;
        }
    }
?>