@if(Session::has('success'))
    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
        <span class="font-medium">Success : </span> {{ Session::get('success')}}
    </div>
@endif
@if(Session::has('error_message'))
    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
        <span class="font-medium">Error : </span> {{ Session::get('error_message')}}
    </div>
@endif

@foreach ($errors->all() as $error)
    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
        <span class="font-medium">Error : </span> {{ $error }}
    </div>
@endforeach
