<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|min:3|max:255',
            'description' => 'nullable|max:1000',
            'due_date' => 'nullable|date|after_or_equal:today',
            'priority' => 'required|in:low,medium,high',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Please enter a title for your todo',
            'title.min' => 'The title must be at least 3 characters long',
            'title.max' => 'The title cannot exceed 255 characters',
            'description.max' => 'The description cannot exceed 1000 characters',
            'due_date.date' => 'Please enter a valid date',
            'due_date.after_or_equal' => 'The due date must be today or a future date',
            'priority.required' => 'Please select a priority level',
            'priority.in' => 'Please select a valid priority level',
        ];
    }
} 