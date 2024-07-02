@extends('admin.layouts.admin-app')

@section('content')
<main>
    <section class="content">
        <div class="page-announce valign-wrapper"><a href="#" data-activates="slide-out"
                class="button-collapse valign hide-on-large-only"><i class="material-icons">menu</i></a>
            <h1 class="page-announce-text valign">// Add product
            </h1>
        </div>
        <div class="container">
            <div class="row">
                <form id="product_create-form" class="col s12">
                    @csrf
                    <div class="row">

                        <div class="input-field col s12">
                            <input type="text" name="name" maxlength="200">
                            <label for="text" class="">Name: </label>
                            <p style="color:red" id="name_error"></p>
                        </div>

                        <div class="input-field col s12">
                            <input type="text" name="slug" maxlength="200">
                            <label for="text" class="">Slug: </label>
                            <p style="color:red" id="slug_error"></p>
                        </div>

                        <div class="input-field col s12">
                            <label style="padding-left: 10px" for="text">Description: </label>
                            <textarea style="border-radius:10px; height: 170px" name="description" id=""></textarea>
                            <p style="color:red" id="description_error"></p>
                        </div>

                        <div class="input-field col s12">
                            <select style="display: block" id="category" name="category_id">
                                <option disabled value="">Add categoru</option>
                            </select>
                            <p style="color:red" id="category_error"></p>
                        </div>

                        <div class="input-field col s12">
                            <select style="display: block" id="brand" name="brand_id">
                                <option disabled value="">Add brand</option>
                            </select>
                            <p style="color:red" id="brand_error"></p>
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
const categorySelect = document.getElementById('category');
const brandSelect = document.getElementById('brand');

const selectOptionUrl = "{{route('admin.product.create')}}";
fetch(selectOptionUrl)
    .then(response => response.json())
    .then(response => {

        response.categories.forEach(category => {
            const option = document.createElement('option');
            option.value = category.id;
            option.text = category.name;
            categorySelect.appendChild(option);
        });

        response.brands.forEach(brand => {
            const option = document.createElement('option');
            option.value = brand.id;
            option.text = brand.name;
            brandSelect.appendChild(option);
        });

    })
    .catch(error => console.error('Error loading parent IDs:', error));


const productForm = document.getElementById('product_create-form');

productForm.addEventListener('submit', (event) => {
    event.preventDefault();
    const newFormData = new FormData(productForm);

    const name = newFormData.get('name');
    const slug = newFormData.get('slug');
    const category_id = newFormData.get('category_id');
    const brand_id = newFormData.get('brand_id');

    const createProductUrl = "{{route('admin.product.store')}}";
    fetch(createProductUrl, {
            method: "POST",
            body: newFormData,
        }).then(response => response.json())
        .then(data => {
            switch (data.status) {
                case true:
                    console.log(data);
                    alert('Product created');

                    break;
                case false:
                    const message = JSON.parse(data.message);
                    const nameError = document.getElementById('name_error');
                    nameError.textContent = message.name;
                    const slugError = document.getElementById('slug_error');
                    slugError.textContent = message.slug;
                    const categoryError = document.getElementById('category_error');
                    categoryError.textContent = message.category_id;
                    const brandError = document.getElementById('brand_error');
                    brandError.textContent = message.brand_id;
                    const descriptionError = document.getElementById('description_error');
                    descriptionError.textContent = message.description;
                    break;
                default:
                    console.log('Неизвестная ошибка');
            }

        })
})
</script>
@endsection