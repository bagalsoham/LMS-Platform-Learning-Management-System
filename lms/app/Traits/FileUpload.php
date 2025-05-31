<?php
// Define the namespace for better organization and autoloading
namespace App\Traits;

use Illuminate\Http\UploadedFile;

/**
 * Trait FileUpload
 * 
 * This trait will contain reusable methods related to file uploading,
 * such as moving uploaded files, validating file types or sizes, and 
 * generating unique file names. 
 * 
 * It can be included in any class using `use FileUpload;`.
 */
trait FileUpload {
    public function uploadFile(UploadedFile $file, string $directory = 'uploads'):string{
        $filename = 'educore-'.uniqid().'.'.$file->getClientOriginalExtension();

        //move the file to storage
        $file->move(public_path($directory), $filename);

        return '/' .$directory. '/' . $filename; //uploads/ file.ext
    }
}
