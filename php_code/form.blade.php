 <form method="post" id="form" action="{{ route('admin.registration') }}" enctype="multipart/form-data" autocomplete="off">
     @csrf
     <div class="row g-3">

         <div class="col-lg-6">
             <div>
                 <label class="form-label">Name</label>
                 <div>
                     <input type="text" name="name" class="form-control rounded-end @error('name') is-invalid @enderror" placeholder="Enter Name" required autocomplete="one-time-code">
                     @error('name')
                     <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                     </span>
                     @enderror

                 </div>
             </div>
         </div>

         <div class="col-lg-6">
             <div>
                 <label class="form-label">User Name</label>
                 <div>
                     <input type="text" name="login" class="form-control rounded-end @error('login') is-invalid @enderror" placeholder="Enter Login Id" required autocomplete="one-time-code">
                     @error('login')
                     <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                     </span>
                     @enderror

                 </div>
             </div>
         </div>


         <div class="col-lg-6">
             <div>
                 <label class="form-label">Password</label>
                 <div>
                     <input type="password" name="password" class="form-control rounded-end" placeholder="Password" required autocomplete="one-time-code">

                 </div>
             </div>
         </div>

         <div class="col-lg-6">
             <div>
                 <label class="form-label">Type</label>
                 <div>
                     <select class="form-control" name="type" required>
                         <option value="">Select Type</option>
                         <option value="owner">Owner</option>
                     </select>
                 </div>
             </div>
         </div>

         <div class="col-lg-6">
             <div>
                 <label class="form-label">Vin No </label>
                 <div>
                     <select class="form-control selectpicker" multiple data-live-search="true" name="vin_no[]">
                         <option value="Abc">Abc</option>
                         <option value="Def">Def</option>
                         <option value="Ghi">Ghi</option>
                         <option value="Jkl">Jkl</option>
                     </select>
                 </div>
             </div>
         </div>

         <div class="col-lg-6"></div>


         <div class="col-lg-6">
             <div>
                 <button type="submit" class="btn btn-primary">Add Staff</button>
             </div>
         </div>
     </div>
 </form>


    *************************** Controller side code ********************************

    if ($request->isMethod('post')) {
            
            // dd($request->all());           
            $request->validate([
                'login'   => 'required|unique:nonriders',
                'password' => 'required',
                'type'    => 'required',
            ], [
                'login.unique' => 'Login Id Is Already Exist',
                'name' => 'required|alpha|max:255',
            ]);

        }