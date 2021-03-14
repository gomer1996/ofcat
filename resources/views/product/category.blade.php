<x-app-layout>
    @section('title', $category->name)
    <livewire:products-list :category="$category" />
    <div class="otstyp">
    </div>
</x-app-layout>
