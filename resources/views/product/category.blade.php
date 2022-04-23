<x-app-layout>
    @section('title', $category->name)
    @php
        $linkedCategory = isset($linkedCategory) ? $linkedCategory : null;
        $breadcrumbs = isset($breadcrumbs) ? $breadcrumbs : [];
    @endphp
    <livewire:products-list
        :category="$category"
        :breadcrumbs="$breadcrumbs"
        :linkedCategory="$linkedCategory" />
    <div class="otstyp">
    </div>
</x-app-layout>
