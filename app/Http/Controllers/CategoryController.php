<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 *   @OA\Info(
 *     title="API DEMO",
 *     version="1.0",
 *     description="API para gestionar catgorías, doctores, hospitales y otros recursos.",
 *     @OA\Contact(
 *         email="esnider@codestation.pe"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://apifap.codestation.pe/api-demo",
 *     description="Servidor prod"
 * )
 * 
 * Controlador de categorías
 *
 * @OA\Schema(
 *     schema="Category",
 *     type="object",
 *     description="Atributos de la tabla de categorías",
 *     @OA\Property(property="id", type="integer", description="ID of the category"),
 *     @OA\Property(property="name", type="string", description="Name of the category"),
 *     @OA\Property(property="image", type="string", description="Image URL or base64 of the category"),
 *     @OA\Property(property="description", type="string", nullable=true, description="Description of the category"),
 *     @OA\Property(property="state", type="integer", nullable=true, description="State of the category (e.g., active/inactive)"),
 *     @OA\Property(property="created_at", type="string", format="date-time", nullable=true, description="Creation timestamp of the category"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", nullable=true, description="Last update timestamp of the category"),
 *     @OA\Property(property="deleted", type="boolean", description="Soft delete flag (1 if deleted, 0 otherwise)"),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true, description="Timestamp when the category was deleted")
 * )
 */


class CategoryController extends Controller
{
    /**
     * @OA\Get (
     *     path="/api/categories",
     *     tags={"Categorías"},
     *     summary="Obtiene la lista de categorías",
     *     description="Devuelve un listado de todas las categorías que no han sido eliminadas lógicamente.",
     *     @OA\Response(
     *         response=200,
     *         description="Listado exitoso",
     *         @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="integer", description="ID de la categoría"),
     *                  @OA\Property(property="name", type="string", description="Nombre de la categoría"),
     *                  @OA\Property(property="image", type="string", description="Imagen de la categoría"),
     *                  @OA\Property(property="description", type="string", description="Descripción de la categoría"),
     *                  @OA\Property(property="state", type="integer", description="Estado de la categoría (1 activa, 0 inactiva)"),
     *                  @OA\Property(property="deleted", type="boolean", description="Estado de eliminación lógica (0 no eliminado, 1 eliminado)"),
     *                  @OA\Property(property="created_at", type="string", format="date-time", example="2023-02-23T00:09:16.000000Z"),
     *                  @OA\Property(property="updated_at", type="string", format="date-time", example="2023-02-23T12:33:45.000000Z")
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error en el servidor",
     *         @OA\JsonContent(
     *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=0),
     *             @OA\Property(property="error_message", type="string", description="Mensaje de error", example="Mensaje detallado del error")
     *         )
     *     )
     * )
     */
    public function index() // Listado
    {
        try {
            $categories = Category::where('deleted', 0)->get();
            return response()->json(["data" => $categories, "state" => 1], 200);
        } catch (\Throwable $th) {
            return response()->json(["state" => 0, "error_message" => $th->getMessage()], 200);
        }
    }
    
    /**
     * @OA\Get (
     *     path="/api/categories/bydoctor/{id}",
     *     tags={"Doctores"},
     *     summary="Obtiene el listado de doctores por categoría",
     *     description="Devuelve un listado de doctores que pertenecen a una categoría específica que no ha sido eliminada lógicamente.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la categoría",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Listado exitoso",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="id", type="integer", description="ID de la categoría"),
     *                  @OA\Property(property="name", type="string", description="Nombre de la categoría"),
     *                  @OA\Property(property="image", type="string", description="Imagen de la categoría"),
     *                  @OA\Property(property="description", type="string", description="Descripción de la categoría"),
     *                  @OA\Property(property="state", type="integer", description="Estado de la categoría (1 activa, 0 inactiva)"),
     *                  @OA\Property(property="deleted", type="boolean", description="Estado de eliminación lógica (0 no eliminado, 1 eliminado)"),
     *                  @OA\Property(property="doctors", type="array",
     *                      @OA\Items(
     *                          @OA\Property(property="id", type="integer", description="ID del doctor"),
     *                          @OA\Property(property="first_name", type="string", description="Nombre del doctor"),
     *                          @OA\Property(property="last_name", type="string", description="Apellido del doctor"),
     *                          @OA\Property(property="imagen", type="string", description="Imagen del doctor"),
     *                          @OA\Property(property="category_id", type="integer", description="ID de la categoría asociada"),
     *                          @OA\Property(property="hospital_id", type="integer", description="ID del hospital asociado"),
     *                          @OA\Property(property="phone_number", type="string", description="Número de teléfono del doctor"),
     *                          @OA\Property(property="favorite", type="boolean", description="Si el doctor está marcado como favorito"),
     *                          @OA\Property(property="email", type="string", description="Correo electrónico del doctor"),
     *                          @OA\Property(property="about_me", type="string", description="Descripción sobre el doctor"),
     *                          @OA\Property(property="experience", type="array", description="Experiencia del doctor",
     *                              @OA\Items(type="string")
     *                          ),
     *                          @OA\Property(property="hospital_experience", type="string", description="Experiencia hospitalaria"),
     *                          @OA\Property(property="deleted", type="boolean", description="Estado de eliminación lógica del doctor (0 no eliminado, 1 eliminado)"),
     *                          @OA\Property(property="created_at", type="string", format="date-time", example="2023-02-23T00:09:16.000000Z"),
     *                          @OA\Property(property="updated_at", type="string", format="date-time", example="2023-02-23T12:33:45.000000Z")
     *                      )
     *                  )
     *              ),
     *              @OA\Property(property="state", type="integer", description="Estado de la operación", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Categoría no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=0),
     *             @OA\Property(property="error_message", type="string", description="Mensaje de error", example="Categoría no encontrada")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error en el servidor",
     *         @OA\JsonContent(
     *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=0),
     *             @OA\Property(property="error_message", type="string", description="Mensaje de error", example="Mensaje detallado del error")
     *         )
     *     )
     * )
     */
    public function indexDoctor($id) // Listado de doctores por categoría
    {
        try {
            $category = Category::with(['doctors' => function ($query) {
                $query->where('deleted', 0); // Filtrar doctores no eliminados
            }])
            ->where('id', $id) // Filtrar por ID de la categoría
            ->where('deleted', 0) // Filtrar categorías no eliminadas
            ->first();

            if (!$category) {
                return response()->json(["state" => 0, "error_message" => "Categoría no encontrada"], 404);
            }

            return response()->json(["data" => $category, "state" => 1], 200);
        } catch (\Throwable $th) {
            return response()->json(["state" => 0, "error_message" => $th->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/categories",
     *     tags={"Categorías"},
     *     summary="Crea una nueva categoría",
     *     description="Permite crear una nueva categoría con sus respectivos datos y subir una imagen.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", description="Nombre de la categoría", example="Tecnología"),
     *             @OA\Property(property="image", type="string", format="binary", description="Archivo de imagen de la categoría"),
     *             @OA\Property(property="description", type="string", description="Descripción de la categoría", example="Artículos relacionados con tecnología."),
     *             @OA\Property(property="state", type="integer", description="Estado de la categoría (1 activa, 0 inactiva)", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Categoría creada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", description="Mensaje de éxito", example="Se creó correctamente."),
     *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=1),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", description="ID de la categoría"),
     *                 @OA\Property(property="name", type="string", description="Nombre de la categoría", example="Tecnología"),
     *                 @OA\Property(property="image", type="string", description="Ruta de la imagen guardada", example="images_categorias/AB12_tecnologia.jpg"),
     *                 @OA\Property(property="description", type="string", description="Descripción de la categoría", example="Artículos relacionados con tecnología."),
     *                 @OA\Property(property="state", type="integer", description="Estado de la categoría", example=1),
     *                 @OA\Property(property="deleted", type="boolean", description="Estado de eliminación lógica", example=0),
     *                 @OA\Property(property="created_at", type="string", format="date-time", description="Fecha de creación", example="2023-11-21T12:34:56Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", description="Fecha de última actualización", example="2023-11-21T12:34:56Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=0),
     *             @OA\Property(property="error_message", type="string", description="Detalle del error", example="El campo name es obligatorio.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error en el servidor",
     *         @OA\JsonContent(
     *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=0),
     *             @OA\Property(property="error_message", type="string", description="Mensaje detallado del error", example="Mensaje de error interno.")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:100',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'nullable|string',
                'state' => 'nullable|integer',
            ]);
    
            // Procesar y guardar la imagen
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $randomCode = Str::random(4);
                $imageName = $randomCode . '_' . $originalName . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->move(public_path('images_categorias'), $imageName);
                $validatedData['image'] = 'images_categorias/' . $imageName;
            }
    
            $validatedData['deleted'] = 0;
    
            $category = Category::create($validatedData);
    
            return response()->json([
                "message" => "Se creó correctamente.",
                "state" => 1,
                "data" => $category,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["state" => 0, "error_message" => $th->getMessage()], 200);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/categories/{id}",
     *     tags={"Categorías"},
     *     summary="Actualiza una categoría existente",
     *     description="Permite actualizar los datos de una categoría específica. Incluye la opción de actualizar su imagen.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la categoría a actualizar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", description="Nombre de la categoría", example="Tecnología actualizada"),
     *             @OA\Property(property="image", type="string", format="binary", description="Archivo de imagen de la categoría"),
     *             @OA\Property(property="description", type="string", description="Descripción de la categoría", example="Descripción actualizada."),
     *             @OA\Property(property="state", type="integer", description="Estado de la categoría (1 activa, 0 inactiva)", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoría actualizada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", description="Mensaje de éxito", example="Se actualizó correctamente."),
     *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=1),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", description="ID de la categoría"),
     *                 @OA\Property(property="name", type="string", description="Nombre de la categoría", example="Tecnología actualizada"),
     *                 @OA\Property(property="image", type="string", description="Ruta de la imagen actualizada", example="images_categorias/XY12_nuevaimagen.jpg"),
     *                 @OA\Property(property="description", type="string", description="Descripción de la categoría", example="Descripción actualizada."),
     *                 @OA\Property(property="state", type="integer", description="Estado de la categoría", example=1),
     *                 @OA\Property(property="deleted", type="boolean", description="Estado de eliminación lógica", example=0),
     *                 @OA\Property(property="created_at", type="string", format="date-time", description="Fecha de creación", example="2023-11-21T12:34:56Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", description="Fecha de última actualización", example="2023-11-21T13:45:56Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Categoría no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=0),
     *             @OA\Property(property="error_message", type="string", description="Detalle del error", example="No query results for model [App\\Models\\Category] #id")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=0),
     *             @OA\Property(property="error_message", type="string", description="Mensaje del error de validación", example="El campo name debe ser una cadena de texto.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error en el servidor",
     *         @OA\JsonContent(
     *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=0),
     *             @OA\Property(property="error_message", type="string", description="Detalle del error", example="Mensaje de error interno.")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'nullable|string|max:200',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'state' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $randomCode = Str::random(10);
            $imageName = $randomCode . '_' . $originalName . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('images_categorias'), $imageName);

            $validatedData['image'] = 'images_categorias/' . $imageName;
        }

        $updates = array_filter($validatedData, function ($value) {
            return !is_null($value);
        });
        
        $category->update($updates);

        return response()->json([
            "message" => "Se actualizó correctamente.",
            "state" => 1,
            "data" => $category,
        ], 200);
    } 

    /**
     * @OA\Delete(
     *     path="/api/categories/{id}",
     *     tags={"Categorías"},
     *     summary="Elimina una categoría (marcándolo como eliminado)",
     *     description="Marca una categoría como eliminada lógicamente, actualizando el campo `deleted` a 1.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la categoría a eliminar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoría eliminada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", description="Mensaje de éxito", example="Se eliminó correctamente."),
     *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Categoría no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=0),
     *             @OA\Property(property="error_message", type="string", description="Detalle del error", example="No query results for model [App\\Models\\Category] #id")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error en el servidor",
     *         @OA\JsonContent(
     *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=0),
     *             @OA\Property(property="error_message", type="string", description="Detalle del error", example="Mensaje de error interno.")
     *         )
     *     )
     * )
     */
    public function destroy($id) // Eliminar (suave)
    {
        try {
            $category = Category::findOrFail($id);

            $category->update(['deleted' => 1]);

            return response()->json([
                "message" => "Se eliminó correctamente.",
                "state" => 1,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(["state" => 0, "error_message" => $th->getMessage()], 200);
        }
    }
}
