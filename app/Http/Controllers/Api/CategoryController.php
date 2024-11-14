<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return response()->json([

            'success' => true,
            'message' => 'Categories retrieved successfully.',
            'data' => $categories

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories',

        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors occurred.',
                'errors' => $validator->getMessageBag(), // Get validation errors
            ], 422); // 422 Unprocessable Entity status code
        }

        $formdata = $validator->validated();
        $formdata['slug'] = str::slug($formdata['name']);
        // Create the category if validation passes
        $category = Category::create($formdata);

        return response()->json([
            'success' => true,
            'message' => 'Success.',
            'data' => $category,
        ], 201); // 201 Created status code
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Show a specific category
    public function show(Category $category)
    {
        // Find the category by ID
        // $category = Category::find($id);

        // // Check if the category exists
        // if (!$category) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Category not found.'
        //     ], 404); // 404 Not Found status code
        // }

        // Return the found category
        return response()->json([
            'success' => true,
            'message' => 'Category  found successfully.',
            'data' => $category,
        ], 200); // 200 OK status code
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Update an existing category
    public function update(Request $request, Category $category)
    {
        // // Find the category by ID
        // $category = Category::find($id);

        // // Check if the category exists
        // if (!$category) {
        //     return response()->json(['success' => false, 'message' => 'Category not found.'], 404); // 404 Not Found
        // }

        // Define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories,name,' . $category->id,
            'description' => 'nullable|string', // You can add more fields as necessary
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors occurred.',
                'errors' => $validator->getMessageBag(), // Get validation errors
            ], 422); // 422 Unprocessable Entity status code
        }

        // Get validated data and add/update the slug
        $formdata = $validator->validated();
        $formdata['slug'] = Str::slug($formdata['name']); // Create slug from name

        // Update the category with the validated data
        $category->update($formdata);

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully.',
            'data' => $category,
        ], 200); // 200 OK status code
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Delete a category
    // Delete a category
    public function destroy(Category $category)
    {
        // // Find the category by ID
        // $category = Category::find($id);

        // // Check if the category exists
        // if (!$category) {
        //     return response()->json(['success' => false, 'message' => 'Category not found.'], 404); // 404 Not Found
        // }

        // Delete the category
        $category->delete();

        // Return a success response with a message
        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully.'
        ], 200); // 200 OK status code
    }
}
