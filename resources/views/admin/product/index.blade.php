@extends('admin.layouts.admin-app')

@section('content')
<i class="fa-sotdd fa-cart-shopping"></i>
<main>
    <section class="content">


        <div class="page-announce vatdgn-wrapper"><a href="#" data-activates="stdde-out"
                class="button-collapse vatdgn hide-on-large-only"><i class="material-icons">menu</i></a>
            <h1 class="page-announce-text vatdgn">// Name Product </h1>
        </div>
        <div id="posttable" class="container">
            <table class="responsive-table striped hover centered" id="names-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Category Name</th>
                        <th>Brand</th>
                        <th>Operations</th>
                    </tr>
                </thead>
                <tbody id="product__list">


                </tbody>
            </table>
        </div>

    </section>
</main>
@endsection

@section('api_representation')

<script>
const productUrl = "{{route('admin.product.index')}}";
const productList = document.getElementById('product__list');

fetch(productUrl)
    .then(response => response.json())
    .then(products => {
        products.forEach(product => {
            const productTR = createProductRow(product);
            productList.appendChild(productTR);
        });
    });

function createProductRow(product) {
    const productTR = document.createElement('tr');

    const productId = document.createElement('td');
    productId.textContent = product.id;
    productTR.appendChild(productId);

    const productName = document.createElement('td');
    productName.textContent = product.name;
    productTR.appendChild(productName);

    const productSlug = document.createElement('td');
    const productSlugLink = document.createElement('a');
    productSlugLink.textContent = product.slug;
    productSlugLink.href = `{{ route('product.show', ['id' => 'PRODUCT_ID']) }}`.replace('PRODUCT_ID', product.id);
    productSlug.appendChild(productSlugLink);
    productTR.appendChild(productSlug);

    const productCategoryName = document.createElement('td');
    productCategoryName.textContent = product.category.name;
    productTR.appendChild(productCategoryName);

    const productBrandName = document.createElement('td');
    productBrandName.textContent = product.brand.name;
    productTR.appendChild(productBrandName);

    const productButtonTD = document.createElement('td');
    const productButtonBlock = document.createElement('div');
    productButtonBlock.className = "btn-toolbar";

    const productUpdateButton = document.createElement('button');
    productUpdateButton.className = "btn green";
    productUpdateButton.innerHTML = '<i class="fa-solid fa-pen"></i>';
    productUpdateButton.addEventListener('click', () => {
        const productUpdatePageId = product.id;
        console.log('Кнопка update (логика ещё не прописана!!!)');
        
    });

    const productDeleteButton = document.createElement('button');
    productDeleteButton.className = "btn red";
    productDeleteButton.innerHTML = '<i class="fa-solid fa-cart-shopping"></i>';
    productDeleteButton.addEventListener('click', () => {
        const productDeleteUrl = `{{ route('admin.product.delete', ['id' => 'PRODUCT_ID']) }}`.replace('PRODUCT_ID', product.id);
        fetch(productDeleteUrl).then(response => response.json());
        document.location.reload();
    });

    productButtonBlock.appendChild(productUpdateButton);
    productButtonBlock.appendChild(productDeleteButton);
    productButtonTD.appendChild(productButtonBlock);
    productTR.appendChild(productButtonTD);

    return productTR;
}
</script>

@endsection