<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use laravel\sanctum\Sanctum;
use App\Models\User;
use App\Models\Product;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_get_products()
    {
        $this->withoutExceptionHandling();
        $product = Product::factory()->create();
        $response = $this->get('/api/products');
        //var_dump($response);
        $response->assertJson([
            'data'=>[
                        [
                            'id' => $product->id,
                            'name' => $product->name,
                            'slug' => $product->slug,
                            'description' => $product->description,
                            'price' => $product->price
                        ]
                    ],
            'status'=>true,
            ]);

        $response->assertStatus(200);
    }

    public function test_create_products()
    {
        //$this->withoutExceptionHandling();
        Sanctum::actingAs(User::factory()->create());
        $response = $this->post('/api/products',['name'=>'test', 'slug'=>'test','description'=>'test','price'=>600]);
        //var_dump($response);

        $response->assertJson([
            'data'=>[
                'name'=>'test',
                'slug'=>'test',
                'description'=>'test',
                'price'=>600
                ],
            'status'=>true,
            'message'=>'product created successfully'
            ]);

        $response->assertStatus(201);

        //create two more jobs
        Product::factory(2)->create();
        $this->assertDatabaseCount('products',4);
    }

    public function test_update_products()
    {
        //$this->withoutExceptionHandling();
        Sanctum::actingAs(User::factory()->create());
        $product = Product::factory()->create();
        $response = $this->put('/api/products/'.$product->id,['name'=>'test1', 'price'=>700]);
        //var_dump($response);

        $response->assertJson([
            'data'=>[
                'id'=>$product->id,
                'name'=>'test1',
                'price'=>700
                ],
            'status'=>true,
            'message'=>'product updated successfully'
            ]);

        $response->assertStatus(201);
    }

    public function test_failed_update_products()
    {
        //$this->withoutExceptionHandling();
        Sanctum::actingAs(User::factory()->create());
        $product = Product::factory()->create();
        $response = $this->put('/api/products/0',['description'=>'test1','price'=>700]);
        //var_dump($response);

        $response->assertJson([
            'data'=>null,
            'status'=>false,
            'message'=>'product not found'
            ]);

        $response->assertStatus(404);
    }

    public function test_delete_products()
    {
        //$this->withoutExceptionHandling();
        Sanctum::actingAs(User::factory()->create());
        $product = Product::factory()->create();
        $response = $this->delete('/api/products/'.$product->id);
        //var_dump($response);

        $response->assertJson([
            'data'=>null,
            'status'=>true,
            'message'=>'product deleted successfully'
            ]);

        $response->assertStatus(201);
    }

}
