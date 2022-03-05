<x-app-layout>
    @section('title', $category->name)
    @php
        $linkedCategory = isset($linkedCategory) ? $linkedCategory : null;
    @endphp
    <livewire:products-list :category="$category" :linkedCategory="$linkedCategory" />
    <div class="otstyp">
    </div>
</x-app-layout>
