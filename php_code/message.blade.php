
		 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
@if (Session::has('success'))
    <script>
        iziToast.success({
        //title: 'Success',
        message: "{{ Session::get('success') }}",
        position: 'topRight',
        timeout: 4000,
        displayMode: 0,
        color: 'green',
        theme: 'light',
        messageColor: 'black',
    });

    </script>
@endif
