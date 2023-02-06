<?php

namespace App\Http\Validations\Product;

use Validator;

class ProductValidation
{
    /**
     * Product Validation
     */
    public static function validate($request, $id = 0)
    {
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'sku'     => 'required'
        ]);

        if ($validator->fails()) {
            return ([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        return ['success'=>true];

    }
}
