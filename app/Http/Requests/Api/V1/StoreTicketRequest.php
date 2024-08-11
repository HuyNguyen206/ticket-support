<?php

namespace App\Http\Requests\Api\V1;

use App\Enum\TicketStatus;
use App\Models\User;
use App\Permissions\V1\Abilities;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

///**
// * @bodyParam data.attributes.title string required The ticket's title no-example
// */
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
        $user = Auth::user();
        $baseRule = 'sometimes|integer|exists:users,id';

        $data = [
            'data' => 'required',
            'data.attributes' => 'required',
            'data.attributes.title' => 'required|string',
            'data.attributes.description' => 'required|string',
            'data.attributes.status' => ['required', Rule::enum(TicketStatus::class)],
            'data.relationships.user.id' => $baseRule . '|size:'. $user->id
        ];
        /**
         * @var User $user
         */
//        if ($this->routeIs('tickets.store')) {;
            if ($user->tokenCan(Abilities::CreateTicket)) {
                $data['data.relationships.user.id'] = $baseRule;
            }
//        }

        return $data;
    }

    public function messages()
    {
        return [
            'data.attributes.status' => __('The status must be one of the following [1,2,3,4,5]')
        ];
    }

    public function bodyParameters()
    {
        $doc = [
            'data.attributes.status' => [
                'description' => 'Ticket\'s status',
                'example' => 'No-example',
            ],
            'data.attributes.title' => [
                'description' => 'Ticket\'s title',
                'example' => 'No-example',
            ],
            'data.attributes.description' => [
                'description' => 'Ticket\'s description',
                'example' => 'No-example',
            ]
        ];

        // Add condition to dynamic generate dynamic docs

        return $doc;
    }
}
