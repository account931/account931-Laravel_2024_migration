<?php

//Used for validation via Request Class, not via controller

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule; //for in: validation
use App\Models\Venue;
use Illuminate\Http\Request;

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
		    
			//if is json (case when it is  API)........
		    //dd($validator->errors()); //tempo, works,  get validation errors
			if($this->wantsJson()){
				//dd($validator->errors());
				//return response([ 'message' => 'Updated successfully'], 200);
			} 
			
			//redirect fot normal http requests
			//return response(['error' => $validator->errors(), 'Validation Error']);
            return redirect('/owner/create-new')->withInput()->with('flashMessageFailX', 'Validation Failed!!!' )->withErrors($validator);
        }
	}
	
	/**
     * Custom validation failed response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
	/*
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        // Check if validation fails and return a custom JSON response
        if ($this->isJson()) {
            // If the request is JSON, send a JSON response with validation errors
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Default response if it's not JSON
        parent::failedValidation($validator);
    }
	
    */
	
	
	 
	

   
	 
}