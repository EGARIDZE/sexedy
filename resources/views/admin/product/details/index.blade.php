@extends('admin.layouts.admin-app')

@section('content')
<main>
    <section class="content">
        <div class="page-announce valign-wrapper"><a href="#" data-activates="slide-out"
                class="button-collapse valign hide-on-large-only"><i class="material-icons">menu</i></a>
            <h1 class="page-announce-text valign">// Details
            </h1>
        </div>
        <div class="container">
            @include('admin.product.include.product-slug-document')
            <h3>Create detail</h3>
            <div class="row">
                <form id="details_create-form" class="col s12">
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
            <h3>List details</h3>
            <div id="posttable" class="container">
                <table class="responsive-table striped hover centered" id="names-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Description</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody id="details__list">


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

const detailsCreateForm = document.getElementById('details_create-form');
const detailsCreateFormUrl = `{{ route('admin.product.details.store', ['id' => 'PRODUCT_ID']) }}`.replace('PRODUCT_ID',
    productId);
const productInputId = document.getElementById('product_input-id');
productInputId.value = productId;

detailsCreateForm.addEventListener('submit', (event) => {

    const newFormData = new FormData(detailsCreateForm);

    const dascription = newFormData.get('description');
    const product_id = newFormData.get('product_id');

    fetch(detailsCreateFormUrl, {
            method: "POST",
            body: newFormData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => console.log(data))
});


const productDetailsUrl = `{{ route('admin.product.details.index', ['id' => 'PRODUCT_ID']) }}`.replace('PRODUCT_ID',
    productId);
const detailsList = document.getElementById('details__list');

fetch(productDetailsUrl)
    .then(response => response.json())
    .then(details => {
        details.forEach(detail => {
            const detailTR = document.createElement('tr');

            const detailId = document.createElement('td');
            detailId.textContent = detail.id;
            detailTR.appendChild(detailId);

            const detailDescription = document.createElement('td');
            detailDescription.textContent = detail.description;
            detailTR.appendChild(detailDescription);

            const productButtonTD = document.createElement('td');
            const productButtonBlock = document.createElement('div');
            productButtonBlock.className = "btn-toolbar";

            const productUpdateButton = document.createElement('button');
            productUpdateButton.className = "btn green";
            productUpdateButton.innerHTML = '<i class="fa-solid fa-pen"></i>';
            productUpdateButton.addEventListener('click', () => {
                const productUpdatePageId = detail.id;
                console.log('Update button clicked for product ID:', productUpdatePageId);
            });

            const productDeleteButton = document.createElement('button');
            productDeleteButton.className = "btn red";
            productDeleteButton.innerHTML = '<i class="fa-solid fa-cart-shopping"></i>';
            productDeleteButton.addEventListener('click', () => {
                const productDeleteUrl =
                    `{{ route('admin.product.details.delete', ['id' => 'PRODUCT_ID', 'detail_id' => 'DETAIL_ID']) }}`
                    .replace('PRODUCT_ID', productId)
                    .replace('DETAIL_ID', detail.id);
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
            detailTR.appendChild(productButtonTD);

            detailsList.appendChild(detailTR);
        });
    })
</script>

@include('admin.product.include.product-slug-logics')

@endsection