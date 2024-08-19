<?php

// Declaración del namespace que organiza el código en el directorio correspondiente.
namespace App\Http\Resources\Product;

// Importación de clases necesarias para trabajar con solicitudes y recursos JSON.
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

// Definición de la clase CategorieResource que extiende de JsonResource.
class CategorieResource extends JsonResource
{
    /**
     * Transforma el recurso en un array.
     *
     * @param Request $request La solicitud entrante.
     * @return array<string, mixed> Un array que representa los datos del recurso.
     */
    public function toArray(Request $request): array
    {
        // Retorna un array que contiene los datos de la categoría.
        return [
            "id" => $this->resource->id, // ID de la categoría.
            "name" => $this->resource->name, // Nombre de la categoría.
            "icon" => $this->resource->icon, // Icono de la categoría.
            "imagen" => $this->resource->imagen ? env("APP_URL")."storage/".$this->resource->imagen : NULL, // URL de la imagen de la categoría (si existe).
            "categorie_second_id" => $this->resource->categorie_second_id, // ID de la segunda categoría (si existe).
            
            // Datos de la segunda categoría, si existe.
            "categorie_second" => $this->resource->categorie_second ? [
                "name" => $this->resource->categorie_second->name , // Nombre de la segunda categoría.
            ] : NULL,
            
            "categorie_third_id" => $this->resource->categorie_third_id, // ID de la tercera categoría (si existe).
            
            // Datos de la tercera categoría, si existe.
            "categorie_third"=> $this->resource->categorie_third ? [
                "name" => $this->resource->categorie_third->name , // Nombre de la tercera categoría.
            ] : NULL,
            
            "position" => $this->resource->position, // Posición de la categoría.
            "type_categorie" => $this->resource->type_categorie, // Tipo de categoría.
            "state" => $this->resource->state, // Estado de la categoría.
            "created_at" => $this->resource->created_at->format("Y-m-d h:i:s"), // Fecha de creación de la categoría en formato específico.
        ];
    }
}
