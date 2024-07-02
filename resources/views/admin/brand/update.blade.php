@extends('admin.layouts.admin-app')

@section('content')
<main>
    <section class="content">
        <div class="page-announce valign-wrapper"><a href="#" data-activates="slide-out"
                class="button-collapse valign hide-on-large-only"><i class="material-icons">menu</i></a>
            <h1 class="page-announce-text valign">// Update brand
            </h1>
        </div>
        <div class="container">
            <div class="row">
                <form id="brand_update-form" class="col s12">
                    @csrf
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="current_name" type="text" name="name" maxlength="200" placeholder="Name">
                        </div>
                    </div>
                    <div class="center-align"><input class="btn btn-success" type="submit" value="Submit"></div>
                </form>
            </div>
        </div>
    </section>
</main>
@endsection

@section('api_representation')
<script>
function getProductIdFromUrl() {
    const urlSegments = window.location.pathname.split('/');
    return urlSegments[urlSegments.length - 1];
}

const brandForm = document.getElementById('brand_update-form');
brandForm.addEventListener('submit', (event) => {
    event.preventDefault();
    const newFormData = new FormData(brandForm);

    const name = newFormData.get('name');

    const productFormId = getProductIdFromUrl();
    console.log(productFormId);
    const updateUrl = `{{ route('admin.brand.update', ['id' => 'BRAND_ID']) }}`.replace('BRAND_ID',
        productFormId);

    fetch(updateUrl, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                name: name
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Answer: ', data);
            alert('Категория обновлена');
        })
        .catch(error => console.error('Error updating category:', error));
});
</script>
@endsection