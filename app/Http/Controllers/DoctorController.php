<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str; 
use App\Models\Doctor;
use Illuminate\Http\Request;

/**
 * @OA\Server(
 *     url="http://swagger.local",
 *     description="Servidor local"
 * )
 * Controlador de doctor
 *
 * @OA\Schema(
 *     schema="Doctor",
 *     type="object",
 *     description="Atributos de la tabla de doctores",
 *     @OA\Property(property="id", type="integer", description="ID of the doctor"),
 *     @OA\Property(property="first_name", type="string", description="First name of the doctor"),
 *     @OA\Property(property="last_name", type="string", description="Last name of the doctor"),
 *     @OA\Property(property="imagen", type="string", description="URL or path to the doctor's image"),
 *     @OA\Property(property="category_id", type="integer", description="ID of the associated category"),
 *     @OA\Property(property="hospital_id", type="integer", description="ID of the associated hospital"),
 *     @OA\Property(property="phone_number", type="string", description="Phone number of the doctor"),
 *     @OA\Property(property="favorite", type="boolean", description="Indicates if the doctor is marked as favorite"),
 *     @OA\Property(property="email", type="string", description="Email address of the doctor"),
 *     @OA\Property(property="about_me", type="string", description="Biography or description about the doctor"),
 *     @OA\Property(property="experience", type="object", description="JSON object describing the doctor's experience. [{'name': '+120 Operaciones'}]"),
 *     @OA\Property(property="hospital_experience", type="string", description="Text detailing hospital experience"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the record was created"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp when the record was last updated"),
 *     @OA\Property(property="deleted", type="boolean", description="Soft delete flag"),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", description="Timestamp when the record was deleted, if applicable")
 * )
 */


class DoctorController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/doctor",
     *     tags={"Doctores"},
     *     summary="Obtiene la lista de doctores no eliminados",
     *     description="Devuelve todos los doctores que no están marcados como eliminados lógicamente (campo `deleted` igual a 0), incluyendo su categoría y hospital relacionados.",
     *     @OA\Response(
     *         response=200,
     *         description="Listado de doctores exitoso",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", description="ID del doctor"),
     *                 @OA\Property(property="first_name", type="string", description="Primer nombre del doctor"),
     *                 @OA\Property(property="last_name", type="string", description="Apellido del doctor"),
     *                 @OA\Property(property="imagen", type="string", description="Ruta de la imagen del doctor"),
     *                 @OA\Property(property="category_id", type="integer", description="ID de la categoría del doctor"),
     *                 @OA\Property(property="hospital_id", type="integer", description="ID del hospital del doctor"),
     *                 @OA\Property(property="phone_number", type="string", description="Número de teléfono del doctor"),
     *                 @OA\Property(property="favorite", type="boolean", description="Si el doctor es favorito o no"),
     *                 @OA\Property(property="email", type="string", description="Correo electrónico del doctor"),
     *                 @OA\Property(property="about_me", type="string", description="Información sobre el doctor"),
     *                 @OA\Property(property="experience", type="array", description="Experiencia del doctor. [{'name': '+120 Operaciones'}]", @OA\Items(type="string")),
     *                 @OA\Property(property="hospital_experience", type="string", description="Experiencia en el hospital"),
     *                 @OA\Property(property="deleted", type="boolean", description="Estado de eliminación lógica (0: no eliminado, 1: eliminado)"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-21T20:38:47.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-21T20:40:53.000000Z"),
     *                 @OA\Property(property="category", type="object", description="Categoría del doctor", 
     *                     @OA\Property(property="id", type="integer", description="ID de la categoría"),
     *                     @OA\Property(property="name", type="string", description="Nombre de la categoría")
     *                 ),
     *                 @OA\Property(property="hospital", type="object", description="Hospital del doctor", 
     *                     @OA\Property(property="id", type="integer", description="ID del hospital"),
     *                     @OA\Property(property="name", type="string", description="Nombre del hospital")
     *                 )
     *             )
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
    public function index()
    {
        try {
            $doctors = Doctor::with(['category', 'hospital'])
                ->where('deleted', 0)
                ->get();

            return response()->json(["data" => $doctors, "state" => 1], 200);
        } catch (\Throwable $th) {
            return response()->json(["state" => 0, "error_message" => $th->getMessage()], 500);
        }
    }

    /**
     * @OA\Get (
     *     path="/api/doctor/data/{id}",
     *     tags={"Doctores"},
     *     summary="Obtiene los datos de un doctor específico",
     *     description="Devuelve la información detallada de un doctor, incluyendo su categoría y hospital, siempre que no haya sido eliminado lógicamente.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del doctor a consultar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Datos del doctor obtenidos con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", description="ID del doctor"),
     *                     @OA\Property(property="first_name", type="string", description="Nombre del doctor"),
     *                     @OA\Property(property="last_name", type="string", description="Apellido del doctor"),
     *                     @OA\Property(property="imagen", type="string", description="URL de la imagen del doctor"),
     *                     @OA\Property(property="category_id", type="integer", description="ID de la categoría asociada"),
     *                     @OA\Property(property="hospital_id", type="integer", description="ID del hospital asociado"),
     *                     @OA\Property(property="phone_number", type="string", description="Número de teléfono del doctor"),
     *                     @OA\Property(property="favorite", type="boolean", description="Indicador de doctor favorito (1 sí, 0 no)"),
     *                     @OA\Property(property="email", type="string", description="Correo electrónico del doctor"),
     *                     @OA\Property(property="about_me", type="string", description="Descripción del perfil del doctor"),
     *                     @OA\Property(property="experience", type="array", description="Experiencia del doctor",
     *                         @OA\Items(type="string")
     *                     ),
     *                     @OA\Property(property="hospital_experience", type="string", description="Experiencia en hospitales"),
     *                     @OA\Property(property="category", type="object", description="Información de la categoría asociada",
     *                         @OA\Property(property="id", type="integer", description="ID de la categoría"),
     *                         @OA\Property(property="name", type="string", description="Nombre de la categoría"),
     *                         @OA\Property(property="description", type="string", description="Descripción de la categoría")
     *                     ),
     *                     @OA\Property(property="hospital", type="object", description="Información del hospital asociado",
     *                         @OA\Property(property="id", type="integer", description="ID del hospital"),
     *                         @OA\Property(property="name", type="string", description="Nombre del hospital")
     *                     ),
     *                     @OA\Property(property="deleted", type="boolean", description="Estado de eliminación lógica (0 no eliminado, 1 eliminado)"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2023-02-23T00:09:16.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-02-23T12:33:45.000000Z")
     *                 )
     *             ),
     *             @OA\Property(property="state", type="integer", description="Estado de la operación (1 éxito, 0 error)", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error en el servidor",
     *         @OA\JsonContent(
     *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=0),
     *             @OA\Property(property="error_message", type="string", description="Mensaje de error detallado", example="Mensaje del error")
     *         )
     *     )
     * )
     */
    public function indexDoctor($id)
    {
        try {
            $doctors = Doctor::with(['category', 'hospital'])
                ->where('deleted', 0)
                ->where('id', $id)
                ->get();

            return response()->json(["data" => $doctors, "state" => 1], 200);
        } catch (\Throwable $th) {
            return response()->json(["state" => 0, "error_message" => $th->getMessage()], 500);
        }
    }
    
    /**
     * @OA\Post(
     *     path="/api/doctor",
     *     tags={"Doctores"},
     *     summary="Crea un nuevo doctor",
     *     description="Crea un nuevo doctor en la base de datos. Requiere los datos del doctor, incluyendo nombre, apellido, categoría, hospital, y otros detalles. La imagen es opcional, pero si se proporciona, debe cumplir con las restricciones de tipo y tamaño.",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos del nuevo doctor",
     *         @OA\JsonContent(
     *             required={"first_name", "last_name", "category_id", "hospital_id", "email"},
     *             @OA\Property(property="first_name", type="string", description="Primer nombre del doctor", example="Adam"),
     *             @OA\Property(property="last_name", type="string", description="Apellido del doctor", example="Frewuyfbyi"),
     *             @OA\Property(property="imagen", type="string", format="binary", description="Imagen del doctor (opcional)"),
     *             @OA\Property(property="category_id", type="integer", description="ID de la categoría del doctor", example=2),
     *             @OA\Property(property="hospital_id", type="integer", description="ID del hospital del doctor", example=1),
     *             @OA\Property(property="phone_number", type="string", description="Número de teléfono del doctor", example="977845878"),
     *             @OA\Property(property="favorite", type="boolean", description="Si el doctor es favorito o no", example=true),
     *             @OA\Property(property="email", type="string", description="Correo electrónico del doctor", example="dwedwed@wedwed.com"),
     *             @OA\Property(property="about_me", type="string", description="Información sobre el doctor", example="Soy un doctor con mucha experiencia en cirugía."),
     *             @OA\Property(property="experience", type="array", description="Experiencia del doctor", example="[{'name': '+120 Operaciones'},{'name': '10 años de Experiencia'},{'name': 'Profesor de la UPC'}]", @OA\Items(type="string")),
     *             @OA\Property(property="hospital_experience", type="string", description="Experiencia en el hospital", example="5 años en el hospital X")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Doctor creado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object", description="Datos del doctor creado",
     *                 @OA\Property(property="id", type="integer", description="ID del doctor"),
     *                 @OA\Property(property="first_name", type="string", description="Primer nombre del doctor"),
     *                 @OA\Property(property="last_name", type="string", description="Apellido del doctor"),
     *                 @OA\Property(property="imagen", type="string", description="Ruta de la imagen del doctor"),
     *                 @OA\Property(property="category_id", type="integer", description="ID de la categoría del doctor"),
     *                 @OA\Property(property="hospital_id", type="integer", description="ID del hospital del doctor"),
     *                 @OA\Property(property="phone_number", type="string", description="Número de teléfono del doctor"),
     *                 @OA\Property(property="favorite", type="boolean", description="Si el doctor es favorito o no"),
     *                 @OA\Property(property="email", type="string", description="Correo electrónico del doctor"),
     *                 @OA\Property(property="about_me", type="string", description="Información sobre el doctor"),
     *                 @OA\Property(property="experience", type="array", description="Experiencia del doctor. [{'name': '+120 Operaciones'}]", @OA\Items(type="string")),
     *                 @OA\Property(property="hospital_experience", type="string", description="Experiencia en el hospital"),
     *                 @OA\Property(property="deleted", type="boolean", description="Estado de eliminación lógica (0: no eliminado, 1: eliminado)"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-21T20:38:47.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-21T20:40:53.000000Z")
     *             ),
     *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Datos de entrada inválidos",
     *         @OA\JsonContent(
     *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=0),
     *             @OA\Property(property="error_message", type="string", description="Descripción del error", example="The email has already been taken.")
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
    public function store(Request $request)
    {
        try {
            
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:100',
                'last_name' => 'required|string|max:100',
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'category_id' => 'required|integer|exists:categories,id',
                'hospital_id' => 'required|integer|exists:hospitals,id',
                'phone_number' => 'nullable|string|max:20',
                'favorite' => 'nullable|boolean',
                'email' => 'required|email|unique:doctors,email',
                'about_me' => 'nullable|string',
                'experience' => 'nullable|string',
                'hospital_experience' => 'nullable|string',
            ]);
    
            if ($request->hasFile('imagen')) {
                $image = $request->file('imagen');
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $randomCode = Str::random(6);
                $imageName = $randomCode . '_' . $originalName . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->move(public_path('imagen_doctor'), $imageName);
                $validatedData['imagen'] = 'imagen_doctor/' . $imageName;
            }
    
            $validatedData['deleted'] = 0;

            $doctor = Doctor::create($validatedData);
    
            return response()->json([
                "data" => $doctor,
                "state" => 1
            ], 201);
    
        } catch (\Throwable $th) {
            return response()->json([
                "state" => 0,
                "error_message" => $th->getMessage()
            ], 500);
        }
    }
    
    /**
     * @OA\Post(
     *     path="/api/doctor/{id}",
     *     tags={"Doctores"},
     *     summary="Actualiza los datos de un doctor",
     *     description="Actualiza los datos de un doctor existente. Si se proporciona una nueva imagen, se reemplazará la anterior. El ID del doctor es requerido en la URL y los campos proporcionados en la solicitud serán actualizados.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del doctor a actualizar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         description="Datos del doctor a actualizar",
     *         @OA\JsonContent(
     *             @OA\Property(property="first_name", type="string", description="Primer nombre del doctor", example="Adam"),
     *             @OA\Property(property="last_name", type="string", description="Apellido del doctor", example="Frewuyfbyi"),
     *             @OA\Property(property="imagen", type="string", format="binary", description="Imagen del doctor (opcional)"),
     *             @OA\Property(property="category_id", type="integer", description="ID de la categoría del doctor", example=2),
     *             @OA\Property(property="hospital_id", type="integer", description="ID del hospital del doctor", example=1),
     *             @OA\Property(property="phone_number", type="string", description="Número de teléfono del doctor", example="977845878"),
     *             @OA\Property(property="favorite", type="boolean", description="Si el doctor es favorito o no", example=true),
     *             @OA\Property(property="email", type="string", description="Correo electrónico del doctor", example="dwedwed@wedwed.com"),
     *             @OA\Property(property="about_me", type="string", description="Información sobre el doctor", example="Soy un doctor con mucha experiencia en cirugía."),
     *             @OA\Property(property="experience", type="array", description="Experiencia del doctor", example="[{'name': '+120 Operaciones'},{'name': '10 años de Experiencia'},{'name': 'Profesor de la UPC'}]", @OA\Items(type="string")),
     *             @OA\Property(property="hospital_experience", type="string", description="Experiencia en el hospital", example="5 años en el hospital X")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Doctor actualizado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object", description="Datos del doctor actualizado",
     *                 @OA\Property(property="id", type="integer", description="ID del doctor"),
     *                 @OA\Property(property="first_name", type="string", description="Primer nombre del doctor"),
     *                 @OA\Property(property="last_name", type="string", description="Apellido del doctor"),
     *                 @OA\Property(property="imagen", type="string", description="Ruta de la imagen del doctor"),
     *                 @OA\Property(property="category_id", type="integer", description="ID de la categoría del doctor"),
     *                 @OA\Property(property="hospital_id", type="integer", description="ID del hospital del doctor"),
     *                 @OA\Property(property="phone_number", type="string", description="Número de teléfono del doctor"),
     *                 @OA\Property(property="favorite", type="boolean", description="Si el doctor es favorito o no"),
     *                 @OA\Property(property="email", type="string", description="Correo electrónico del doctor"),
     *                 @OA\Property(property="about_me", type="string", description="Información sobre el doctor"),
     *             @OA\Property(property="experience", type="array", description="Experiencia del doctor. [{'name': '+120 Operaciones'}]", @OA\Items(type="string")),
     *                 @OA\Property(property="hospital_experience", type="string", description="Experiencia en el hospital"),
     *                 @OA\Property(property="deleted", type="boolean", description="Estado de eliminación lógica (0: no eliminado, 1: eliminado)"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-21T20:38:47.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-21T20:40:53.000000Z")
     *             ),
     *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Doctor no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=0),
     *             @OA\Property(property="message", type="string", description="Mensaje de error", example="Doctor no encontrado.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Datos de entrada inválidos",
     *         @OA\JsonContent(
     *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=0),
     *             @OA\Property(property="error_message", type="string", description="Descripción del error", example="El correo electrónico ya está en uso.")
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
    public function update(Request $request, $id) // Actualizar
    {
        try {
            $doctor = Doctor::find($id);

            if (!$doctor) {
                return response()->json([
                    'state' => 0,
                    'message' => 'Doctor no encontrado.',
                ], 404);
            }
            $validatedData = $request->validate([
                'first_name' => 'nullable|string|max:100',
                'last_name' => 'nullable|string|max:100',
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'category_id' => 'nullable|integer|exists:categories,id',
                'hospital_id' => 'nullable|integer|exists:hospitals,id',
                'phone_number' => 'nullable|string|max:20',
                'favorite' => 'nullable|boolean',
                'email' => 'nullable|email|unique:doctors,email,' . $id,
                'about_me' => 'nullable|string',
                'experience' => 'nullable|string',
                'hospital_experience' => 'nullable|string',
            ]);

            if ($request->hasFile('imagen')) {
                if ($doctor->imagen && file_exists(public_path($doctor->imagen))) {
                    unlink(public_path($doctor->imagen));
                }

                $originalName = pathinfo($request->file('imagen')->getClientOriginalName(), PATHINFO_FILENAME);
                $randomCode = Str::random(6);
                $imageName = $randomCode . '.' . $originalName . '_' . $request->file('imagen')->getClientOriginalExtension();

                $request->file('imagen')->move(public_path('imagen_doctor'), $imageName);

                $validatedData['imagen'] = 'imagen_doctor/' . $imageName;
            }

            $updates = array_filter($validatedData, function ($value) {
                return !is_null($value);
            });

            $doctor->update($updates);

            return response()->json([
                "data" => $doctor,
                "state" => 1,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                "state" => 0,
                "error_message" => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/doctor/{id}",
     *     tags={"Doctores"},
     *     summary="Elimina un doctor (marcándolo como eliminado)",
     *     description="Este endpoint marca a un doctor como eliminado (eliminado suave) estableciendo su campo `deleted` a 1. No elimina físicamente al doctor de la base de datos.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del doctor a eliminar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Doctor eliminado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", description="Mensaje de éxito", example="Se eliminó correctamente."),
     *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Doctor no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=0),
     *             @OA\Property(property="error_message", type="string", description="Mensaje de error", example="Doctor no encontrado.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error en el servidor",
     *         @OA\JsonContent(
     *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=0),
     *             @OA\Property(property="error_message", type="string", description="Descripción del error", example="Mensaje de error interno.")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $doctor = Doctor::findOrFail($id);
            $doctor->update(['deleted' => 1]);

            return response()->json(["message" => "Se eliminó correctamente.", "state" => 1], 200);
        } catch (\Throwable $th) {
            return response()->json(["state" => 0, "error_message" => $th->getMessage()], 500);
        }
    }
}
