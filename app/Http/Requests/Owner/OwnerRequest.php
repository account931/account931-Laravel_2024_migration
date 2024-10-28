<?php

//Used for validation via Request Class, not via controller

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule; //for in: validation
use App\Models\Venue;

class OwnerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //return false; //return False will stop everything
		return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
		$RegExp_Phone = '/^[+]380[\d]{1,4}[0-9]+$/';
		
		$existingVenues = Venue::active()->pluck('id'); 
	
        return [
		    'first_name'    => 'required|string|min:3|max:255',
			'last_name'     => 'required|string|min:3|max:255',
			'location'      => 'required|string|min:3|max:255',
			'email'         => 'required|email|unique:owners,id,',  //email is unique on create only, not on update
			'phone'         => ['required', "regex: $RegExp_Phone" ],	
			'owner_venue'   => ['required', 'array',  ],               //Rule::in($existingVenues)
			"owner_venue.*" => Rule::in($existingVenues)
		];
		
    }
	
	
	/**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
		
		return [
		   'first_name.required'   => 'Kindly asking for a first name',
		   'last_name.required'    => 'Kindly asking for a last name',
		   'phone.regex'           => 'Phone must be +380...',
		   'owner_venue.required'  => 'Select venue',
		];
	}
	 
	 
	 
    /**
     * Return validation errors. 
     *
     * @param Validator $validator
     */
    public function withValidator(Validator $validator)
    {
	
	    if ($validator->fails()) {
            return redirect('/owner/create-new')->withInput()->with('flashMessageFailX', 'Validation Failed!!!' )->withErrors($validator);
        }
	}
	 
	

   
	 
}