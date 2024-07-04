@extends('admin.layouts.admin-app')

@section('content')
<main>
    <section class="content">
        <div class="page-announce valign-wrapper"><a href="#" data-activates="slide-out"
                class="button-collapse valign hide-on-large-only"><i class="material-icons">menu</i></a>
            <h1 class="page-announce-text valign">// Offers
            </h1>
        </div>
        <div class="container">
            @include('admin.product.include.product-slug-document')
            <h3>Create offer</h3>
            <div class="row">
                <form id="offer_create-form" class="col s12">
                    @csrf
                    <div class="row">

                        <div class="input-field col s12">
                            <input id="product_input-id" type="hidden" name="product_id" value="">
                            <input type="text" name="name">
                            <label for="text" class="">Name: </label>
                            <p style="color:red" id="name_error"></p>
                        </div>

                        <div class="input-field col s12">
                            <input id="" type="number" name="price">
                            <label for="text" class="">Price: </label>
                            <p style="color:red" id="price_error"></p>
                        </div>

                        <div class="input-field col s12">
                            <input type="number" name="discount">
                            <label for="number" class="">Discount: </label>
                            <p style="color:red" id="discount_error"></p>
                        </div>

                    </div>
                    <div class="center-align"><input class="btn btn-success" type="submit" value="Submit"></div>
                </form>
            </div>
            <h3>List offers</h3>
            <div id="posttable" class="container">
                <table class="responsive-table striped hover centered" id="names-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Price</th>
                            <th>Discount</th>
                        </tr>
                    </thead>
                    <tbody id="offers__list">


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

//offer creation logic 
const offerForm = document.getElementById('offer_create-form');
//offer store URL
const offerCreateUrl = `{{ route('admin.product.offers.store', ['id' => 'PRODUCT_ID']) }}`.replace('PRODUCT_ID',
    productId);

const productInputId = document.getElementById('product_input-id');
productInputId.value = productId; // Product ID to create an offer

//form logic
offerForm.addEventListener('submit', (event) => {
    event.preventDefault();
    const newFormData = new FormData(offerForm);

    const productId = newFormData.get('product_id');
    const offerName = newFormData.get('name');
    const offerPrice = newFormData.get('price');
    const offerDiscount = newFormData.get('discount');

    fetch(offerCreateUrl, {
            method: "POST",
            body: newFormData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => console.log(data))
});


const offersUrl = `{{ route('admin.product.offers.index', ['id' => 'PRODUCT_ID']) }}`.replace('PRODUCT_ID', productId);
const offersList = document.getElementById('offers__list');

fetch(offersUrl)
    .then(response => response.json())
    .then(offers => {
        offers.forEach(offer => {
            const offerTR = document.createElement('tr');

            const offerId = document.createElement('td');
            offerId.textContent = offer.id;
            offerTR.appendChild(offerId);

            const offerName = document.createElement('td');
            const offerLink = document.createElement('a');
            offerLink.textContent = offer.name;
            offerLink.href =
                `{{route('product.offers.show', ['id' => 'PRODUCT_ID', 'offer_id' => 'OFFER_ID'])}}`
                .replace('PRODUCT_ID', productId)
                .replace('OFFER_ID', offer.id);
            offerName.appendChild(offerLink);
            offerTR.appendChild(offerName);

            const offerCode = document.createElement('td');
            offerCode.textContent = offer.code;
            offerTR.appendChild(offerCode);

            const offerPrice = document.createElement('td');
            offerPrice.textContent = offer.price + '$';
            offerTR.appendChild(offerPrice);

            const offerDiscount = document.createElement('td');
            offerDiscount.textContent = offer.discount + '% ';
            offerTR.appendChild(offerDiscount);

            const offerButtonTD = document.createElement('td');
            const offerButtonBlock = document.createElement('div');
            offerButtonBlock.className = "btn-toolbar";

            const offerUpdateButton = document.createElement('button');
            offerUpdateButton.className = "btn green";
            offerUpdateButton.innerHTML = '<i class="fa-solid fa-pen"></i>';
            offerUpdateButton.addEventListener('click', () => {
                const offerUpdatePageId = offer.id;
                console.log('Update button clicked for offer ID:', offerUpdatePageId);
                // Add your logic to navigate to the update page
            });

            const offerDeleteButton = document.createElement('button');
            offerDeleteButton.className = "btn red";
            offerDeleteButton.innerHTML = '<i class="fa-solid fa-trash"></i>';
            offerDeleteButton.addEventListener('click', () => {

                const offerDeleteUrl =
                    `{{ route('admin.product.offers.delete', ['id' => 'PRODUCT_ID', 'offer_id' => 'OFFER_ID']) }}`
                    .replace('PRODUCT_ID', productId)
                    .replace('OFFER_ID', offer.id);
                fetch(offerDeleteUrl, {
                        method: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.location.reload();
                    })
                    .catch(error => console.error('Error deleting offer:', error));
            });

            offerButtonBlock.appendChild(offerUpdateButton);
            offerButtonBlock.appendChild(offerDeleteButton);
            offerButtonTD.appendChild(offerButtonBlock);
            offerTR.appendChild(offerButtonTD);

            offersList.appendChild(offerTR);
        });
    })
    .catch(error => console.error('Error fetching offers:', error));
</script>

@include('admin.product.include.product-slug-logics')

@endsection