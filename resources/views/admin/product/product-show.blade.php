@extends('admin.layouts.admin-app')

@section('content')

<main>
    <section class="content">
        <div class="page-announce valign-wrapper"><a href="#" data-activates="slide-out"
                class="button-collapse valign hide-on-large-only"><i class="material-icons">menu</i></a>
            <h1 class="page-announce-text valign">// Product Description </h1>
        </div>
        <div class="container">
            <h3>Full Information</h3>
            <br>
            <div id="user">
                <table class="table table-hover">
                    <tbody>
                        @include('admin.product.include.product-slug-document')
                        <tr>
                            <td><label for="usrname">Product Name </label></td>
                            <td><a id="product_name"></a></td>
                        </tr>
                        <tr>
                            <td><label for="djoined">Product slug: </label></td>
                            <td><a id="product_slug"></a></td>
                        </tr>
                        <tr>
                            <td><label for="djoined">Product slug: </label></td>
                            <td><a id="product_description"></a></td>
                        </tr>
                        <tr>
                            <td><label for="ipaddress">Category Name: </label></td>
                            <td><a id="product_category"></a></td>
                        </tr>
                        <tr>
                            <td><label for="ipaddress">Brand Name: </label></td>
                            <td><a id="product_brand"></a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>
@endsection

@section('api_representation')

<script>
function getProductIdFromUrl() {
    const urlSegments = window.location.pathname.split('/');
    return (urlSegments[urlSegments.length - 1]);
}
const productId = getProductIdFromUrl();
const productShowUrl = `{{route('admin.product.show', ['id' => 'PRODUCT_ID'])}}`.replace('PRODUCT_ID', productId);

fetch(productShowUrl)
    .then(response => response.json())
    .then(product => {

        const productName = document.getElementById('product_name');
        productName.textContent = product.name;

        const productSlug = document.getElementById('product_slug');
        productSlug.textContent = product.slug;

        const productDescription = document.getElementById('product_description');
        productDescription.textContent = product.description;

        const productCategoryName = document.getElementById('product_category');
        productCategoryName.textContent = product.category.name;

        const productBrandName = document.getElementById('product_brand');
        productBrandName.textContent = product.brand.name;
    });


</script>

@include('admin.product.include.product-slug-logics')

@endsection

