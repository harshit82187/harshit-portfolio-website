<select id="ownerFilter" class="form-control">
                            <option value="">Select</option>
                            <option value="shweta">Shweta</option>
                            <option value="siddhant">Siddhant</option>
                            <option value="aarti">Aarti</option>
                            <option value="siraj">Siraj</option>                                
                            <option value="merown">Merown</option>
                            <option value="vor">VOR</option>
</select>





<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

           $(document).ready(function (){
            var table = $('#dataTable').DataTable();

           $('#ownerFilter').on('change', function () {
            var filterValue = $(this).val();  
            
            // Clear the DataTable search and update the search to the selected filter value
            table.search('').columns().search('').draw();
            table.column(3).search(filterValue).draw();

            });
        });

 </script>