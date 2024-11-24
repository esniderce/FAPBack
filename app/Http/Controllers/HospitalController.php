<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;


/**
 * @OA\Server(
 *     url="http://swagger.local",
 *     description="Servidor local"
 * )
 * 
 * @OA\Schema(
 *     schema="Hospital",
 *     type="object",
 *     description="Atributos de la tabla de hospitales",
 *     @OA\Property(property="id", type="integer", description="ID of the hospital"),
 *     @OA\Property(property="name", type="string", description="Name of the hospital"),
 *     @OA\Property(property="address", type="string", description="Address of the hospital"),
 *     @OA\Property(property="phone_number", type="string", description="Phone number of the hospital"),
 *     @OA\Property(property="email", type="string", description="Email address of the hospital"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the record was created"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp when the record was last updated"),
 *     @OA\Property(property="deleted", type="boolean", description="Soft delete flag"),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", description="Timestamp when the record was deleted, if applicable")
 * )
 */
class HospitalController extends Controller
{
    /**
     * @OA\Get (
     *     path="/api/hospital",
     *     tags={"Hospitales"},
     *     summary="Obtiene la lista de hospitales",
     *     @OA\Response(
     *         response=200,
     *         description="Listado exitoso",
     *         @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="integer", description="ID del hospital"),
     *                  @OA\Property(property="name", type="string", description="Nombre del hospital"),
     *                  @OA\Property(property="address", type="string", description="Dirección del hospital"),
     *                  @OA\Property(property="phone_number", type="string", description="Teléfono del hospital"),
     *                  @OA\Property(property="email", type="string", description="Correo del hospital"),
     *                  @OA\Property(property="deleted", type="boolean", description="Estado de eliminación lógica"),
     *                  @OA\Property(property="created_at", type="string", format="date-time", example="2023-02-23T00:09:16.000000Z"),
     *                  @OA\Property(property="updated_at", type="string", format="date-time", example="2023-02-23T12:33:45.000000Z")
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Hospital no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\Hospital] #id")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $hospitals = Hospital::where('deleted', 0)->get();
            return response()->json(["data" => $hospitals, "state" => 1], 200);
        } catch (\Throwable $th) {
            return response()->json(["state" => 0, "error_message" => $th->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/hospital",
     *     tags={"Hospitales"},
     *     summary="Crear un nuevo hospital",
     *     description="Esta operación permite crear un nuevo registro de hospital en la base de datos.",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos necesarios para crear un hospital",
     *         @OA\JsonContent(
     *             required={"name", "address", "phone_number", "email"},
     *             @OA\Property(property="name", type="string", description="Nombre del hospital", example="Hospital General"),
     *             @OA\Property(property="address", type="string", description="Dirección del hospital", example="Av. Siempre Viva 123"),
     *             @OA\Property(property="phone_number", type="string", description="Teléfono del hospital", example="555-1234"),
     *             @OA\Property(property="email", type="string", description="Correo electrónico del hospital", example="contacto@hospital.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Hospital creado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
    *                 @OA\Property(property="id", type="integer", description="ID del hospital"),
    *                 @OA\Property(property="name", type="string", description="Nombre del hospital"),
    *                 @OA\Property(property="address", type="string", description="Dirección del hospital"),
    *                 @OA\Property(property="phone_number", type="string", description="Teléfono del hospital"),
    *                 @OA\Property(property="email", type="string", description="Correo electrónico del hospital"),
    *                 @OA\Property(property="deleted", type="boolean", description="Estado de eliminación lógica"),
    *                 @OA\Property(property="created_at", type="string", format="date-time", description="Fecha de creación"),
    *                 @OA\Property(property="updated_at", type="string", format="date-time", description="Última fecha de actualización")
    *             ),
    *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=1)
    *         )
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="Error en el servidor",
    *         @OA\JsonContent(
    *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=0),
    *             @OA\Property(property="error_message", type="string", description="Mensaje de error", example="Mensaje de error detallado")
    *         )
    *     )
    * )
    */
    public function store(Request $request)
    {
        try {
            $hospital = Hospital::create(array_merge(
                $request->only(['name', 'address', 'phone_number', 'email']),
                ['deleted' => 0]
            ));
            return response()->json(["data" => $hospital, "state" => 1], 201);
        } catch (\Throwable $th) {
            return response()->json(["state" => 0, "error_message" => $th->getMessage()], 500);
        }
    }
    /**
     * @OA\Put(
     *     path="/api/hospital/{id}",
     *     tags={"Hospitales"},
     *     summary="Actualizar un hospital existente",
     *     description="Actualiza los datos de un hospital en la base de datos utilizando su ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del hospital a actualizar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos actualizados del hospital",
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", description="Nombre del hospital", example="Hospital Renovado"),
     *             @OA\Property(property="address", type="string", description="Dirección del hospital", example="Calle Nueva 456"),
     *             @OA\Property(property="phone_number", type="string", description="Teléfono del hospital", example="555-5678"),
     *             @OA\Property(property="email", type="string", description="Correo electrónico del hospital", example="nuevo@hospital.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Hospital actualizado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", description="ID del hospital"),
     *                 @OA\Property(property="name", type="string", description="Nombre del hospital"),
     *                 @OA\Property(property="address", type="string", description="Dirección del hospital"),
     *                 @OA\Property(property="phone_number", type="string", description="Teléfono del hospital"),
     *                 @OA\Property(property="email", type="string", description="Correo electrónico del hospital"),
     *                 @OA\Property(property="deleted", type="boolean", description="Estado de eliminación lógica"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", description="Fecha de creación"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", description="Última fecha de actualización")
     *             ),
     *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Hospital no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=0),
     *             @OA\Property(property="error_message", type="string", description="Mensaje de error", example="No query results for model [App\\Models\\Hospital] #id")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error en el servidor",
     *         @OA\JsonContent(
     *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=0),
     *             @OA\Property(property="error_message", type="string", description="Mensaje de error", example="Mensaje de error detallado")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $hospital = Hospital::findOrFail($id);

            $hospital->update($request->only(['name', 'address', 'phone_number', 'email']));

            return response()->json(["data" => $hospital, "state" => 1], 200);
        } catch (\Throwable $th) {
            return response()->json(["state" => 0, "error_message" => $th->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/hospital/{id}",
     *     tags={"Hospitales"},
     *     summary="Elimina un hospital doctor (marcándolo como eliminado)",
     *     description="Marca un hospital como eliminado suavemente cambiando el valor del campo 'deleted' a 1.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del hospital a eliminar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Eliminación lógica exitosa",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", description="Mensaje de éxito", example="Se eliminó correctamente."),
     *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Hospital no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=0),
     *             @OA\Property(property="error_message", type="string", description="Mensaje de error", example="No query results for model [App\\Models\\Hospital] #id")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error en el servidor",
     *         @OA\JsonContent(
     *             @OA\Property(property="state", type="integer", description="Estado de la operación", example=0),
     *             @OA\Property(property="error_message", type="string", description="Mensaje de error", example="Mensaje de error detallado")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $hospital = Hospital::findOrFail($id);
            $hospital->update(['deleted' => 1]);

            return response()->json(["message" => "Se eliminó correctamente.", "state" => 1], 200);
        } catch (\Throwable $th) {
            return response()->json(["state" => 0, "error_message" => $th->getMessage()], 500);
        }
    }
}
