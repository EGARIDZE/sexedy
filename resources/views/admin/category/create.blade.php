@extends('admin.layouts.admin-app')

@section('content')
<main>
    <section class="content">
        <div class="page-announce valign-wrapper"><a href="#" data-activates="slide-out"
                class="button-collapse valign hide-on-large-only"><i class="material-icons">menu</i></a>
            <h1 class="page-announce-text valign">// Add category
            </h1>
        </div>
        <div class="container">
            <div class="row">
                <form id="category_create-form" class="col s12">
                    @csrf
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" name="name" maxlength="200">
                            <label for="text" class="">Name: </label>
                        </div>
                        <div class="input-field col s12">
                            <select style="display: block" id="parent_id" name="parent_id">
                               <option disabled value="">Add parent</option>
                            </select>
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
const parentIdForFormUrl = "{{route('admin.category.create')}}";
const parentIdList = document.getElementById('parent_id');

fetch(parentIdForFormUrl)
    .then(response => response.json())
    .then(data => {
        for (const [name, id] of Object.entries(data)) {
            const option = document.createElement('option');
            option.value = id;
            option.text = `${name}`;
            parentIdList.appendChild(option);
        }
    })
    .catch(error => console.error('Error loading parent IDs:', error));



const categoryForm = document.getElementById('category_create-form');
categoryForm.addEventListener('submit', (event) => {
    event.preventDefault();
    const newFormData = new FormData(categoryForm);

    const name = newFormData.get('name');
    const parent_id = newFormData.get('parent_id');

    const createUrl = "{{route('admin.category.store')}}";

    fetch(createUrl, {
            method: 'POST',
            body: newFormData,

        }).then(response => response.json())
        .then(data => {
            console.log('Answer: ', data);
            alert('Категория создана');
        })
})
</script>
@endsection