<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class Page42Request extends FormRequest
{
	/**
	* Indicates if the validator should stop on the first rule failure.
	*
	* @var bool
	*/
	//protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

	/**
	* Prepare the data for validation.
	*/
	protected function prepareForValidation(): void
	{
		$this->merge([
			'gender' => $this->gender,
		]);
	}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'name' => ['required', 'max:10'],
			'email_address' => 'required|email',
			'dob' => 'required|date',
			'occupation' => 'string|nullable',
			'gender' => 'required'
		];
    }

	/**
	* Get the error messages for the defined validation rules.
	*
	* @return array<string, string>
	*/
	public function messages(): array
	{
		return [
			'email_address.required' => 'Please enter your email address.',
			'dob.date' => 'Please enter a valid date of birth.'
		];
	}

	/**
	* Get custom attributes for validator errors.
	*
	* @return array<string, string>
	*/
	public function attributes(): array
	{
		return [
			'dob' => 'date of birth',
		];
	}

	/**
	* Get the "after" validation callables for the request.
	*/
	/*public function after(): array
	{
		return [
			function (Validator $validator) {
				if (request()->missing('gender')) {
					$validator->errors()->add(
						'gender',
						'Please select your gender.'
					);
				}
			}
		];
	}*/
}
