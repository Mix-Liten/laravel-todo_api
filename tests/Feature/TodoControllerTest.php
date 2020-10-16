<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TodoControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testIndex()
    {
        Sanctum::actingAs($this->user, ['*']);

        /** @var Todo $todo */
        $todo = Todo::factory()->make();
        $todo->created_by = $this->user->id;
        $todo->save();

        $this->json('GET', 'api/todos')
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    [
                        'content',
                        'is_completed',
                    ],
                ],
            ]);
    }

    /**
     * @return void
     */
    public function testStore()
    {
        Sanctum::actingAs($this->user, ['*']);

        $data = Todo::factory()->make()->toArray();

        $this->json('POST', 'api/todos', $data)
            ->assertCreated();
        
        $this->assertCount(1, Todo::all());
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        Sanctum::actingAs($this->user, ['*']);

        /** @var Todo $todo */
        $todo = Todo::factory()->make();
        $todo->created_by = $this->user->id;
        $todo->save();

        $data = Todo::factory()->make([
            'content' => 'test content',
            'is_completed' => false,
        ])->toArray();

        $this->json('PUT', 'api/todos/'.$todo->id, $data)
            ->assertOk();
    }
    
    /**
     * @return void
     */
    public function testUpdateForbidden()
    {
        Sanctum::actingAs($this->user, ['*']);

        $user_2 = User::factory()->create();

        /** @var Todo $todo */
        $todo = Todo::factory()->make();
        $todo->created_by = $user_2->id;
        $todo->save();

        $data = Todo::factory()->make([
            'content' => 'test content',
            'is_completed' => false,
        ])->toArray();

        $this->json('PUT', 'api/todos/'.$todo->id, $data)
            ->assertForbidden();
    }

    /**
     * @return void
     */
    public function testDestroy()
    {
        Sanctum::actingAs($this->user, ['*']);

        /** @var Todo $todo */
        $todo = Todo::factory()->make();
        $todo->created_by = $this->user->id;
        $todo->save();

        $this->assertCount(1, Todo::all());

        $this->json('DELETE', 'api/todos/'.$todo->id)
            ->assertNoContent();
    }
    
    /**
     * @return void
     */
    public function testDestroyForbidden()
    {
        Sanctum::actingAs($this->user, ['*']);

        /** @var Todo $todo */
        $todo = Todo::factory()->make();
        $todo->created_by = $this->user->id;
        $todo->save();

        $this->assertCount(1, Todo::all());

        $user_2 = User::factory()->create();
        /** @var Todo $todo_2 */
        $todo_2 = Todo::factory()->make();
        $todo_2->created_by = $user_2->id;
        $todo_2->save();

        $this->assertCount(2, Todo::all());

        $this->json('DELETE', 'api/todos/'.$todo_2->id)
            ->assertForbidden();
    }
}
