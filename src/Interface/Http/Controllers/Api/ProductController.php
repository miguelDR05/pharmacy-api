<?php

namespace Interface\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Infrastructure\Http\Requests\ProductRequest;
use Application\UseCases\Product\CreateProduct;
use Application\UseCases\Product\UpdateProduct;
use Application\UseCases\Product\GetProduct;
use Application\UseCases\Product\ListProducts;
use Application\UseCases\Product\DeleteProduct;
// use Application\UseCases\Product\UpdateProductStock;

use Infrastructure\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

// Asegurarte de que la función responseApi está disponible globalmente o importarla si es necesario
// use function App\Helpers\responseApi; // Ejemplo si estuviera en App\Helpers

class ProductController extends Controller
{
    public function __construct(
        private CreateProduct $createProductUseCase,
        private UpdateProduct $updateProductUseCase,
        private GetProduct $getProductUseCase,
        private ListProducts $listProductsUseCase,
        private DeleteProduct $deleteProductUseCase,
        //private UpdateProductStock $updateProductStockUseCase,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): array
    {
        try {
            $filters = $request->all();
            $products = $this->listProductsUseCase->execute($filters);

            // Usar el Resource para formatear los datos antes de pasarlos a responseApi
            $formattedProducts = ProductResource::collection($products)->toArray($request);

            return responseApi(
                code: 200,
                title: "Lista de Productos",
                message: "Productos obtenidos exitosamente",
                data: $formattedProducts
                // Si responseApi soporta paginación en otherData o similar, podrías pasar los datos de paginación aquí
            );
        } catch (\Exception $e) {
            // Manejo de errores
            return responseApi(
                code: 500,
                title: "Error",
                message: "Error al obtener la lista de productos",
                messageError: $e->getMessage() // O un mensaje más genérico en producción
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request): array
    {
        $userId = Auth::id();
        $data = $request->validated();
        $data['user_created'] = $userId;
        $data['user_updated'] = $userId;

        try {
            $product = $this->createProductUseCase->execute($data);
            // Usar el Resource para formatear el dato antes de pasarlo a responseApi
            $formattedProduct = new ProductResource($product);

            return responseApi(
                code: 201, // 201 Created
                title: "Producto Creado",
                message: "Producto creado exitosamente",
                data: $formattedProduct->toArray($request)
            );
        } catch (\Exception $e) {
            // Manejo de errores
            return responseApi(
                code: 500,
                title: "Error",
                message: "Error al crear el producto",
                messageError: $e->getMessage()
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): array
    {
        try {
            $product = $this->getProductUseCase->execute($id);

            if (!$product) {
                // Si el caso de uso devuelve null si no encuentra
                return responseApi(
                    code: 404,
                    title: "Producto No Encontrado",
                    message: "El producto solicitado no existe."
                );
            }

            // Usar el Resource para formatear el dato antes de pasarlo a responseApi
            $formattedProduct = new ProductResource($product);

            return responseApi(
                code: 200,
                title: "Detalle del Producto",
                message: "Producto obtenido exitosamente",
                data: $formattedProduct
            );
        }
        // Capturar excepciones de "no encontrado" para responder con 404
        catch (ModelNotFoundException $e) {
            return responseApi(
                code: 404,
                title: "Producto No Encontrado",
                message: "El producto solicitado no existe."
            );
        } catch (ModelNotFoundException $e) { // Si creaste esta excepción y la lanzas
            return responseApi(
                code: 404,
                title: "Producto No Encontrado",
                message: $e->getMessage() // Usar el mensaje de la excepción
            );
        } catch (\Exception $e) {
            // Manejo de otros errores
            return responseApi(
                code: 500,
                title: "Error",
                message: "Error al obtener el producto",
                messageError: $e->getMessage()
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, int $id): array
    {
        $userId = Auth::id();
        $data = $request->validated();
        $data['user_updated'] = $userId;

        try {
            $product = $this->updateProductUseCase->execute($id, $data);
            // Usar el Resource para formatear el dato antes de pasarlo a responseApi
            $formattedProduct = new ProductResource($product);

            return responseApi(
                code: 200,
                title: "Producto Actualizado",
                message: "Producto actualizado exitosamente",
                data: $formattedProduct->toArray($request)
            );
        }
        // Capturar excepciones de "no encontrado" para responder con 404
        catch (ModelNotFoundException $e) {
            return responseApi(
                code: 404,
                title: "Producto No Encontrado",
                message: "El producto a actualizar no existe."
            );
        } catch (ModelNotFoundException $e) { // Si creaste esta excepción y la lanzas
            return responseApi(
                code: 404,
                title: "Producto No Encontrado",
                message: $e->getMessage()
            );
        } catch (\Exception $e) {
            return responseApi(
                code: 500,
                title: "Error",
                message: "Error al actualizar el producto",
                messageError: $e->getMessage()
            );
        }
    }

    /**
     * Remove the specified resource from storage (logical delete).
     */
    public function destroy(int $id): array
    {
        $userId = Auth::id();

        try {
            // Pasar el ID del usuario al caso de uso para la eliminación lógica
            $success = $this->deleteProductUseCase->execute($id, $userId);

            if ($success) {
                // Respuesta exitosa de eliminación lógica
                return responseApi(
                    code: 200,
                    title: "Producto Desactivado",
                    message: "Producto desactivado correctamente."
                );
            } else {
                // Si el caso de uso o repositorio devuelve false por alguna razón (ej: no encontrado)
                // En este caso, dado que deleteProductUseCase debería lanzar ProductNotFoundException
                // si el producto no existe, llegar aquí podría indicar un error interno del repo.
                return responseApi(
                    code: 500,
                    title: "Error",
                    message: "Error al desactivar el producto."
                    // Podrías agregar más detalles si el caso de uso proporciona un mensaje de error
                );
            }
        }
        // Capturar excepciones de "no encontrado" para responder con 404
        catch (ModelNotFoundException $e) {
            return responseApi(
                code: 404,
                title: "Producto No Encontrado",
                message: "El producto a desactivar no existe."
            );
        } catch (ModelNotFoundException $e) { // Si creaste esta excepción y la lanzas
            return responseApi(
                code: 404,
                title: "Producto No Encontrado",
                message: $e->getMessage()
            );
        } catch (\Exception $e) {
            // Manejo de otros errores
            return responseApi(
                code: 500,
                title: "Error",
                message: "Error al desactivar el producto",
                messageError: $e->getMessage()
            );
        }
    }

    // Considerar métodos adicionales para stock si es necesario
}
