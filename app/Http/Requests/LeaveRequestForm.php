<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaveRequestForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Mengubah ini ke true agar request dapat diproses
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'reason' => 'required|in:izin,sakit',
            'leave_date' => 'required|date',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4048', 
        ];
    }
}
