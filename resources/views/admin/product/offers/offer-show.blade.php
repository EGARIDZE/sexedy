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

            <h3>Create offer</h3>
            <div class="row">
                <form id="option_create-form" class="col s12">
                    @csrf
                    <div class="row">

                        <div class="input-field col s12">
                            <input id="offer_input-id" type="hidden" name="offer_id" value="">
                            <select style="display: block" id="attribute" name="attribute_id">
                                <option disabled value="">Add attribute</option>
                            </select>
                            <p style="color:red" id="name_error"></p>
                        </div>

                        <div class="input-field col s12">
                            <input id="" type="text" name="value">
                            <label for="text" class="">Value: </label>
                            <p style="color:red" id="value_error"></p>
                        </div>

                    </div>
                    <div class="center-align"><input class="btn btn-success" type="submit" value="Submit"></div>
                </form>
            </div>

            <h3>List color option</h3>
            <div id="posttable" class="container">
                <table class="responsive-table striped hover centered" id="names-table">
                    <thead>
                        <tr>
                            <th>Color</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody id="option__color-list"></tbody>
                </table>
            </div>
            <h3>List size option</h3>
            <div id="posttable" class="container">
                <table class="responsive-table striped hover centered" id="names-table">
                    <thead>
                        <tr>
                            <th>Size</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody id="option__size-list"></tbody>
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
    return urlSegments[urlSegments.length - 3];
}

function getOfferIdFromUrl() {
    const urlSegments = window.location.pathname.split('/');
    return urlSegments[urlSegments.length - 1];
}

const productId = getProductIdFromUrl();
const offerId = getOfferIdFromUrl();
const updateUrl = null;
const deleteUrl =
    `{{ route('admin.product.offers.show.option.delete', ['id' => 'PRODUCT_ID', 'offer_id' => 'OFFER_ID', 'name' => 'NAME']) }}`;
const csrfToken = '{{ csrf_token() }}';
const optionsUrl =
    `{{ route('admin.product.offers.show.option.index', ['id' => 'PRODUCT_ID', 'offer_id' => 'OFFER_ID']) }}`
    .replace('PRODUCT_ID', productId)
    .replace('OFFER_ID', offerId);

const optionsColorList = document.getElementById('option__color-list');
const optionsSizeList = document.getElementById('option__size-list');

fetch(optionsUrl)
    .then(response => response.json())
    .then(options => {
        options['option-color'].forEach(option => {
            const optionTR = document.createElement('tr');
            const optionName = document.createElement('td');
            optionName.textContent = option;
            optionTR.appendChild(optionName);

            const offerButtonTD = createActionButtons(productId, offerId, option, updateUrl, deleteUrl,
                csrfToken);
            optionTR.appendChild(offerButtonTD);
            optionsColorList.appendChild(optionTR);
        });

        options['option-size'].forEach(option => {
            const optionTR = document.createElement('tr');
            const optionSize = document.createElement('td');
            optionSize.textContent = option;
            optionTR.appendChild(optionSize);

            const offerButtonTD = createActionButtons(productId, offerId, option, updateUrl, deleteUrl,
                csrfToken);
            optionTR.appendChild(offerButtonTD);
            optionsSizeList.appendChild(optionTR);
        });
    });

function createActionButtons(productId, offerId = null, option, updateUrl = null, deleteUrl, csrfToken) {
    const actionButtonTD = document.createElement('td');
    const actionButtonBlock = document.createElement('div');
    actionButtonBlock.className = "btn-toolbar";

    const updateButton = document.createElement('button');
    updateButton.className = "btn green";
    updateButton.innerHTML = '<i class="fa-solid fa-pen"></i>';
    updateButton.addEventListener('click', () => {
        const updatePageId = option;
        console.log('Update button clicked for offer ID:', updatePageId);
        window.location.href = updateUrl.replace('OFFER_ID', updatePageId);
    });

    const deleteButton = document.createElement('button');
    deleteButton.className = "btn red";
    deleteButton.innerHTML = '<i class="fa-solid fa-trash"></i>';
    deleteButton.addEventListener('click', () => {
        const deleteRequestUrl = deleteUrl
            .replace('PRODUCT_ID', productId)
            .replace('OFFER_ID', offerId)
            .replace('NAME', option);
        fetch(deleteRequestUrl, {
                method: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                document.location.reload();
            })
            .catch(error => console.error('Error deleting offer:', error));
    });

    actionButtonBlock.appendChild(updateButton);
    actionButtonBlock.appendChild(deleteButton);
    actionButtonTD.appendChild(actionButtonBlock);

    return actionButtonTD;
}


// const categorySelect = document.getElementById('category');
const attributeSelect = document.getElementById('attribute');

const selectAttributeUrl =
    `{{ route('admin.product.offers.show.option.attributes', ['id' => 'PRODUCT_ID', 'offer_id' => 'OFFER_ID']) }}`
    .replace('PRODUCT_ID', productId)
    .replace('OFFER_ID', offerId);
fetch(selectAttributeUrl)
    .then(response => response.json())
    .then(attributes => {
        attributes.forEach(attribute => {
            const option = document.createElement('option');
            option.value = attribute.id;
            option.text = attribute.name;
            attributeSelect.appendChild(option);
        });
    })
    .catch(error => console.error('Error loading parent IDs:', error));



const optionForm = document.getElementById('option_create-form');
const optionCreateUrl =
    `{{ route('admin.product.offers.show.option.store', ['id' => 'PRODUCT_ID', 'offer_id' => 'OFFER_ID']) }}`
    .replace('PRODUCT_ID', productId)
    .replace('OFFER_ID', offerId);

const offerInputId = document.getElementById('offer_input-id');
offerInputId.value = offerId; // Offer ID to create an option


//form logic
optionForm.addEventListener('submit', (event) => {
    event.preventDefault();
    const newFormData = new FormData(optionForm);

    const optionOfferId = newFormData.get('offer_id');
    const offerValue = newFormData.get('value');

    fetch(optionCreateUrl, {
            method: "POST",
            body: newFormData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => console.log(data))
});
</script>

@endsection