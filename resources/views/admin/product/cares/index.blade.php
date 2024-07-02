@extends('admin.layouts.admin-app')

@section('content')
<main>
    <section class="content">
        <div class="page-announce valign-wrapper"><a href="#" data-activates="slide-out"
                class="button-collapse valign hide-on-large-only"><i class="material-icons">menu</i></a>
            <h1 class="page-announce-text valign">// Cares
            </h1>
        </div>
        <div class="container">
            @include('admin.product.include.product-slug-document')
            <h3>Create care</h3>
            <div class="row">
                <form id="cares_create-form" class="col s12">
                    @csrf
                    <div class="row">

                        <div class="input-field col s12">
                            <input id="product_input-id" type="hidden" name="product_id" value="">
                            <input type="text" name="description">
                            <label for="text" class="">Description: </label>
                            <p style="color:red" id="name_error"></p>
                        </div>

                    </div>
                    <div class="center-align"><input class="btn btn-success" type="submit" value="Submit"></div>
                </form>
            </div>
            <h3>List cares</h3>
            <div id="posttable" class="container">
                <table class="responsive-table striped hover centered" id="names-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Description</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody id="cares__list">


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
    return (urlSegments[urlSegments.length - 2]);
}
const productId = getProductIdFromUrl();

const caresCreateForm = document.getElementById('cares_create-form');
const caresCreateFormUrl = `{{ route('admin.product.cares.store', ['id' => 'PRODUCT_ID']) }}`.replace('PRODUCT_ID', productId);
const productInputId = document.getElementById('product_input-id');
productInputId.value = productId;

caresCreateForm.addEventListener('submit', (event) => {

    const newFormData = new FormData(caresCreateForm);

    fetch(caresCreateFormUrl, {
            method: "POST",
            body: newFormData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
        })
        .catch(error => console.error('Error:', error));
});

const productCaresUrl = `{{ route('admin.product.cares.index', ['id' => 'PRODUCT_ID']) }}`.replace('PRODUCT_ID', productId);
const caresList = document.getElementById('cares__list');


    fetch(productCaresUrl)
        .then(response => response.json())
        .then(cares => {
            cares.forEach(care => {
                const careTR = document.createElement('tr');

                const careId = document.createElement('td');
                careId.textContent = care.id;
                careTR.appendChild(careId);

                const careDescription = document.createElement('td');
                careDescription.textContent = care.description;
                careTR.appendChild(careDescription);

                const productButtonTD = document.createElement('td');
                const productButtonBlock = document.createElement('div');
                productButtonBlock.className = "btn-toolbar";

                const productUpdateButton = document.createElement('button');
                productUpdateButton.className = "btn green";
                productUpdateButton.innerHTML = '<i class="fa-solid fa-pen"></i>';
                productUpdateButton.addEventListener('click', () => {
                    const productUpdatePageId = care.id;
                    console.log('Update button clicked for product ID:', productUpdatePageId);
                });

                const productDeleteButton = document.createElement('button');
                productDeleteButton.className = "btn red";
                productDeleteButton.innerHTML = '<i class="fa-solid fa-cart-shopping"></i>';
                productDeleteButton.addEventListener('click', () => {
                    const careId = care.id;
                    const productDeleteUrl = `{{ route('admin.product.cares.delete', ['id' => 'PRODUCT_ID', 'care_id' => 'CARES_ID']) }}`
                    .replace('PRODUCT_ID', productId)
                    .replace('CARES_ID', care.id);
                    fetch(productDeleteUrl, {
                            method: "DELETE",
                        })
                        .then(response => response.json())
                        .then(data => {
                            document.location.reload()
                        })
                        .catch(error => console.error('Error deleting product:', error));
                });

                productButtonBlock.appendChild(productUpdateButton);
                productButtonBlock.appendChild(productDeleteButton);
                productButtonTD.appendChild(productButtonBlock);
                careTR.appendChild(productButtonTD);

                caresList.appendChild(careTR);
            });
        })
        .catch(error => console.error('Error loading product cares:', error));


</script>

@include('admin.product.include.product-slug-logics')

@endsection
