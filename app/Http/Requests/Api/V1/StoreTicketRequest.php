<?php

namespace App\Http\Requests\Api\V1;

use App\Enum\TicketStatus;
use App\Permissions\V1\Abilities;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $data = [
            'data.attributes.title' => 'required|string',
            'data.attributes.description' => 'required|string',
            'data.attributes.status' => ['required', Rule::enum(TicketStatus::class)],
        ];

        if ($this->routeIs('tickets.store')) {
            $data['data.relationships.user.id'] = 'required|numeric|exists:users,id';
            $user = $this->user();
            if ($user->tokenCan(Abilities::CreateOwnTicket)) {
                $data['data.relationships.user.id'] .='|size:'. $user->id;
            }
        }

        return $data;
    }

    public function messages()
    {
        return [
            'data.attributes.status' => __('The status must be one of the following [1,2,3,4,5]')
        ];
    }
}
