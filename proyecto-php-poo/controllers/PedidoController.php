<?php

require_once 'models/Pedido.php';

class PedidoController{
    public function hacer(){
        require_once 'views/pedido/hacer.php';
    }

    public function add(){
        if(isset($_SESSION['identity'])){
            $usuario_id = $_SESSION['identity']->id;
            $provincia  = isset($_POST['provincia'])    ? $_POST['provincia']   : false;
            $direccion  = isset ($_POST['direccion'])   ? $_POST['direccion']   : false;
            $localidad  = isset ($_POST['localidad'])   ? $_POST['localidad']   : false;
            $stats      = Utils::statsCarrito();
            $coste      = $stats['total'];

            if($provincia && $localidad && $direccion){
                //Guardar datos en la base de datos
                $pedido = new Pedido();
                $pedido->setProvincia($provincia)
                    ->setLocalidad($localidad)
                    ->setDireccion($direccion)
                    ->setUsuarioId($usuario_id)
                    ->setCoste($coste);

                $save = $pedido->save();

                //Guardar linea pedido
                $save_linea = $pedido->save_linea();

                if($save && $save_linea){
                    $_SESSION['pedido'] = 'completed';
                }else{
                    $_SESSION['pedido'] = 'failed';
                }
            }else{
                $_SESSION['pedido'] = 'failed';
            }

            header("Location:".base_url."pedido/confirmado");

        }else{
            //Redirigir al index
            header("Location:".base_url);
        }
    }

    public function confirmado(){
        if(isset($_SESSION['identity'])){
            $identity = $_SESSION['identity'];
            $pedido = new Pedido();
            $pedido->setUsuarioId($identity->id);

            $pedido = $pedido->getOneByUser();

            $pedido_productos = new Pedido();
            $productos = $pedido_productos->getProductosByPedido($pedido->id);

            echo $pedido_productos->db->error;

        }

        require_once 'views/pedido/confirmado.php';
    }

    public function misPedidos(){
        Utils::isIdentity();
        $usuario_id = $_SESSION['identity']->id;

        $pedido = new Pedido();
        $pedido->setUsuarioId($usuario_id);

        //Sacar lso pedidos del usuario
        $pedidos = $pedido->getAllByUser();

        require_once 'views/pedido/misPedidos.php';
    }

    public function detalle(){
        Utils::isIdentity();

        if(isset($_GET['id'])){
            $id = $_GET['id'];

            //Sacar el pedido
            $pedido = new Pedido();
            $pedido->setId($id);
            $pedido = $pedido->getOne();

            //Sacar los productos
            $pedido_productos = new Pedido();
            $productos = $pedido_productos->getProductosByPedido($id);

            require_once 'views/pedido/detalle.php';
        }else{
            header("Location:".base_url."pedido/detalle");
        }
    }

    public function gestion()
    {
        Utils::isAdmin();

        $gestion = true;

        $pedido = new Pedido();
        $pedidos = $pedido->getAll();

        require_once 'views/pedido/misPedidos.php';
    }

    public static function estado(){
        Utils::isAdmin();

        if( isset($_POST['pedido_id']) && $_POST['estado']){
            //Recoger datos del formulario
            $id = $_POST['pedido_id'];
            $estado = $_POST['estado'];

            //Update del pedido
            $pedido = new Pedido();
            $pedido->setId($id)
                ->setEstado($estado)
                ->edit();

            header("Location:".base_url."pedido/detalle&id=".$id);
        }else{
            header("Location:".base_url);
        }
    }
}