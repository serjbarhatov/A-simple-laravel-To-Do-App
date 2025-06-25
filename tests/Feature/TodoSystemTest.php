<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoSystemTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $otherUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->otherUser = User::factory()->create();
    }

    /**
     * User Story 1: Create Todo - Happy Path
     * System Test: User successfully creates a todo with valid data
     */
    public function test_user_can_create_todo_with_valid_data(): void
    {
        $this->actingAs($this->user);

        $todoData = [
            'title' => 'Complete project documentation',
            'description' => 'Write comprehensive documentation for the todo app',
            'due_date' => now()->addDays(7)->format('Y-m-d'),
            'priority' => 'high'
        ];

        $response = $this->post(route('todos.store'), $todoData);

        $response->assertRedirect(route('todos.index'));
        $response->assertSessionHas('success', 'Todo created successfully!');

        $this->assertDatabaseHas('todos', [
            'title' => 'Complete project documentation',
            'description' => 'Write comprehensive documentation for the todo app',
            'priority' => 'high',
            'user_id' => $this->user->id,
            'completed' => false
        ]);
    }

    /**
     * User Story 1: Create Todo - Unhappy Path
     * System Test: User attempts to create a todo with invalid data
     */
    public function test_user_cannot_create_todo_with_invalid_data(): void
    {
        $this->actingAs($this->user);

        $invalidData = [
            'title' => 'ab', // Too short (min 3 characters)
            'description' => str_repeat('a', 1001), // Too long (max 1000 characters)
            'due_date' => '2020-01-01', // Past date
            'priority' => 'invalid_priority' // Invalid priority
        ];

        $response = $this->post(route('todos.store'), $invalidData);

        $response->assertSessionHasErrors([
            'title' => 'The title must be at least 3 characters long',
            'description' => 'The description cannot exceed 1000 characters',
            'due_date' => 'The due date must be today or a future date',
            'priority' => 'Please select a valid priority level'
        ]);

        // Verify no todo was created in the database
        $this->assertDatabaseMissing('todos', [
            'title' => 'ab'
        ]);
    }

    /**
     * User Story 2: Toggle Todo Completion - Happy Path
     * System Test: User successfully toggles their own todo completion status
     */
    public function test_user_can_toggle_own_todo_completion(): void
    {
        $this->actingAs($this->user);

        $todo = Todo::factory()->create([
            'user_id' => $this->user->id,
            'completed' => false
        ]);

        $response = $this->post(route('todos.toggle-complete', $todo));

        $response->assertRedirect(route('todos.index'));
        $response->assertSessionHas('success', 'Todo status updated successfully!');

        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'completed' => true
        ]);

        // Toggle back to incomplete
        $response = $this->post(route('todos.toggle-complete', $todo));

        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'completed' => false
        ]);
    }

    /**
     * User Story 2: Toggle Todo Completion - Unhappy Path
     * System Test: User attempts to toggle another user's todo
     */
    public function test_user_cannot_toggle_another_users_todo(): void
    {
        $this->actingAs($this->user);

        $otherUserTodo = Todo::factory()->create([
            'user_id' => $this->otherUser->id,
            'completed' => false
        ]);

        $response = $this->post(route('todos.toggle-complete', $otherUserTodo));

        $response->assertStatus(403); // Forbidden

        // Verify the todo status was not changed
        $this->assertDatabaseHas('todos', [
            'id' => $otherUserTodo->id,
            'completed' => false
        ]);
    }

    /**
     * Additional System Test: User must be authenticated to create todos
     */
    public function test_unauthenticated_user_cannot_create_todo(): void
    {
        $todoData = [
            'title' => 'Test todo',
            'priority' => 'medium'
        ];

        $response = $this->post(route('todos.store'), $todoData);

        $response->assertRedirect(route('login'));
    }

    /**
     * Additional System Test: User must be authenticated to toggle todos
     */
    public function test_unauthenticated_user_cannot_toggle_todo(): void
    {
        $todo = Todo::factory()->create([
            'user_id' => $this->user->id,
            'completed' => false
        ]);

        $response = $this->post(route('todos.toggle-complete', $todo));

        $response->assertRedirect(route('login'));
    }
} 