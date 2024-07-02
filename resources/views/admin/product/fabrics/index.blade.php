@extends('admin.layouts.admin-app')

@section('content')
<main>
    <section class="content">
        <div class="page-announce valign-wrapper"><a href="#" data-activates="slide-out"
                class="button-collapse valign hide-on-large-only"><i class="material-icons">menu</i></a>
            <h1 class="page-announce-text valign">// Fabrics
            </h1>
        </div>
        <div class="container">
            @include('admin.product.include.product-slug-document')
            <h3>Create fabric</h3>
            <div class="row">
                <form id="fabrics_create-form" class="col s12">
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
            <h3>List fabrics</h3>
            <div id="posttable" class="container">
                <table class="responsive-table striped hover centered" id="names-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Description</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody id="fabrics__list">


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

const fabricsCreateForm = document.getElementById('fabrics_create-form');
const fabricsCreateFormUrl = `{{ route('admin.product.fabrics.store', ['id' => 'PRODUCT_ID']) }}`.replace('PRODUCT_ID', productId);

const productInputId = document.getElementById('product_input-id');
productInputId.value = productId;

fabricsCreateForm.addEventListener('submit', (event) => {

    const newFormData = new FormData(fabricsCreateForm);

    fetch(fabricsCreateFormUrl, {
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

const productFabricsUrl = `{{ route('admin.product.fabrics.index', ['id' => 'PRODUCT_ID']) }}`.replace('PRODUCT_ID', productId);
const fabricsList = document.getElementById('fabrics__list');


    fetch(productFabricsUrl)
        .then(response => response.json())
        .then(fabrics => {
            fabrics.forEach(fabric => {
                const fabricTR = document.createElement('tr');

                const fabricId = document.createElement('td');
                fabricId.textContent = fabric.id;
                fabricTR.appendChild(fabricId);

                const fabricDescription = document.createElement('td');
                fabricDescription.textContent = fabric.description;
                fabricTR.appendChild(fabricDescription);

                const productButtonTD = document.createElement('td');
                const productButtonBlock = document.createElement('div');
                productButtonBlock.className = "btn-toolbar";

                const productUpdateButton = document.createElement('button');
                productUpdateButton.className = "btn green";
                productUpdateButton.innerHTML = '<i class="fa-solid fa-pen"></i>';
                productUpdateButton.addEventListener('click', () => {
                    const productUpdatePageId = fabric.id;
                    console.log('Update button clicked for product ID:', productUpdatePageId);
                });

                const productDeleteButton = document.createElement('button');
                productDeleteButton.className = "btn red";
                productDeleteButton.innerHTML = '<i class="fa-solid fa-cart-shopping"></i>';
                productDeleteButton.addEventListener('click', () => {
                    const productDeleteUrl = `{{ route('admin.product.fabrics.delete', ['id' => 'PRODUCT_ID', 'fabric_id' => 'FABRIC_ID']) }}`
                        .replace('PRODUCT_ID', productId)
                        .replace('FABRIC_ID', fabric.id);
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
                fabricTR.appendChild(productButtonTD);

                fabricsList.appendChild(fabricTR);
            });
        })
        .catch(error => console.error('Error loading product fabrics:', error));


</script>

@include('admin.product.include.product-slug-logics')

@endsection