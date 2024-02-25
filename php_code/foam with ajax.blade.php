//////////////////////////// Web File Code ///////////////////////////////

Route::post('/submit-form', 'FormController@submitForm')->name('submit.form');



/////////////////////////// Controller Side Code //////////////////////

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    public function submitForm(Request $request)
    {
        // Handle form submission here
        // You can access form data using $request->input('input_name')

        // For demonstration purposes, let's just return the received data
        return response()->json($request->all());
    }
}




////////////////////////////// Blade File Code ////////////////////

<form id="myForm">
    <!-- Your form fields -->
    <input type="text" name="name" placeholder="Name">
    <input type="number" name="age" placeholder="Age">
    <select name="gender">
        <option value="male">Male</option>
        <option value="female">Female</option>
    </select>
    <input type="radio" name="status" value="single"> Single
    <input type="radio" name="status" value="married"> Married
    <textarea name="message" placeholder="Message"></textarea>
    <input type="file" name="file">

    <!-- Submit button -->
    <button type="submit">Submit</button>
</form>

<!-- Script for handling form submission with Ajax -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#myForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('submit.form') }}",
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    // Handle success response here
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    // Handle error response here
                }
            });
        });
    });
</script>
