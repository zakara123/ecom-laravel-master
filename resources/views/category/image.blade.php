<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold leading-tight text-gray-800">
            Images for category :<span class="text-primary">{{ $category->name }}</span>
        </h1>
        <a href="/item" class="btn btn-primary">Go Back</a>
    </x-slot>
    <!-- Image category -->
    <!-- Image category -->
    <div class="container max-w-6xl mx-auto mt-20 w-full bg-white flex">
        @foreach ($images as $image)

        <div class="w-48 pr-4">
            <div class=" card tex-white bg-secondary mb-3">
                <div class="card-bod">
                    <img src="{{ $image->src }}" class="card-img-top" alt="{{ $category->name }}">
                </div>
            </div>
        </div>

        @endforeach
    </div>
</x-app-layout>
