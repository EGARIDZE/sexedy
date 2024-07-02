@extends('admin.layouts.admin-app')

@section('content')
<main>
    <section class="content">
        <div class="page-announce valign-wrapper"><a href="#" data-activates="slide-out"
                class="button-collapse valign hide-on-large-only"><i class="material-icons">menu</i></a>
            <h1 class="page-announce-text valign">// Update category
            </h1>
        </div>
        <div class="container">
            <div class="row">
                <form id="category_update-form" class="col s12">
                    @csrf
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="current_name" type="text" name="name" maxlength="200" placeholder="Name">
                        </div>
                        <div class="input-field col s12">
                            <select style="display: block" id="parent_id" name="parent_id">
                                <option id="current_parent-id" value=""></option>
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
function getCategoryIdFromUrl() {
    const urlSegments = window.location.pathname.split('/');
    return (urlSegments[urlSegments.length - 1]);
}

const categoryId = getCategoryIdFromUrl();
const categoryDataUrl = `{{ route('admin.category.edit', ['id' => 'PLACEHOLDER']) }}`.replace('PLACEHOLDER', categoryId);
const parentIdList = document.getElementById('parent_id');

fetch(categoryDataUrl)
    .then(response => response.json())
    .then(response => {
        const currentCategory = response['current-category'];
        const currentCategoryOptionParentId = document.getElementById('current_parent-id');
        const currentCategoryOptionName = document.getElementById('current_name');
        currentCategoryOptionName.value = currentCategory.name;
        currentCategoryOptionParentId.textContent = currentCategory.parent_category.name;

        const allCategories = response['all-categories'];
        for (const [name, id] of Object.entries(allCategories)) {
            const option = document.createElement('option');
            option.value = id;
            option.text = `${name}`;
            parentIdList.appendChild(option);
        }
    });

const categoryForm = document.getElementById('category_update-form');
categoryForm.addEventListener('submit', (event) => {
    event.preventDefault();
    const newFormData = new FormData(categoryForm);

    const name = newFormData.get('name');
    const parent_id = newFormData.get('parent_id');
    const updateUrl = `{{ route('admin.category.update', ['id' => 'PLACEHOLDER']) }}`.replace('PLACEHOLDER',
        categoryFormId);

    fetch(updateUrl, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                name: name,
                parent_id: parent_id
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Answer: ', data);
            alert('Категория обновлена');
        })
        .catch(error => console.error('Error updating category:', error));
})
</script>
@endsection