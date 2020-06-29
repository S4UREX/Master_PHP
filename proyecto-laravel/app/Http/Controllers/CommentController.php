<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');//Este middle ware hace que el resto de metodos sean privados a los usuarios NO identificados
    }

    public function save(Request $request)
    {
        //Validacion
        $validate = $this->validate($request, [
            "image_id" => ['integer', 'required'],
            'content' => ['string', 'required']
        ]);

        //Recoger datos
        $user = \Auth::user();
        $image_id = $request->input('image_id');
        $content = $request->input('content');

        //Asigno los valores a mi nuevo objeto
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;

        //Guardar en la base de datos
        $comment->save();

        //Redireccion
        return redirect()->route('image.detail', ['id' => $image_id])
            ->with([
                'message' => 'has publicado tu comentario correctamente'
            ]);

    }

    public function delete($id)
    {
        //conseguir datos del usuario identificado
        $user = \Auth::user();

        //Conseguir objeto del comentario
        $comment = Comment::find($id);//Find me saca un objeto de ese registro de la bd

        //Comprobar si soy el dueño del comentario o de la publicacion
        if($user && ($user->id == $comment->user_id || $comment->image->user_id == $user->id)){
            $comment->delete();
            return redirect()->route('image.detail', ['id' => $comment->image->id])
                ->with([
                    'message' => 'Comentario eliminado correctamente'
                ]);
        }else{
            return redirect()->route('image.detail', ['id' => $comment->image->id])
                ->with([
                    'message' => 'El comentario no se ha eliminado'
                ]);
        }
    }
}
