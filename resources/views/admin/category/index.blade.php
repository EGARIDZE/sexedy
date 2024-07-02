@extends('admin.layouts.admin-app')

@section('content')
<i class="fa-sotdd fa-cart-shopping"></i>
<main>
    <section class="content">


        <div class="page-announce vatdgn-wrapper"><a href="#" data-activates="stdde-out" class="button-collapse vatdgn hide-on-large-only"><i class="material-icons">menu</i></a>
            <h1 class="page-announce-text vatdgn">// Name Approvals </h1>
        </div>
        <div id="posttable" class="container">
            <table class="responsive-table striped hover centered" id="names-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Parent_id</th>
                        <th>Operations</th>
                    </tr>
                </thead>
                <tbody id="category__list">


                </tbody>
            </table>
        </div>

    </section>
</main>
@endsection

@section('api_representation')


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const categoryUrl = "{{ route('admin.category.index') }}";
        const category_list = document.querySelector('#category__list');

        fetch(categoryUrl)
            .then(response => response.json())
            .then(categories => {
                categories.forEach(category => {
                    const categoryTR = createCategoryRow(category);
                    category_list.appendChild(categoryTR);
                });
            })
            .catch(error => console.error('Error loading categories:', error));
    });

    function createCategoryRow(category) {
        const categoryTR = document.createElement('tr');

        const categoryId = document.createElement('td');
        categoryId.textContent = category.id;
        categoryTR.appendChild(categoryId);

        const categoryName = document.createElement('td');
        categoryName.textContent = category.name;
        categoryTR.appendChild(categoryName);

        const categoryParentId = document.createElement('td');
        const categoryParentIdLink = document.createElement('a');
        categoryParentIdLink.textContent = category.parent_id;
        categoryParentIdLink.href = `/category/${category.parent_id}`; // Установите URL для ссылки
        categoryParentId.appendChild(categoryParentIdLink);
        categoryTR.appendChild(categoryParentId);

        const categoryButton = document.createElement('td');
        const categoryButtonBlock = document.createElement('div');
        categoryButtonBlock.className = "btn-toolbar";



        const categoryUpdateButton = document.createElement('button');
        categoryUpdateButton.className = "btn green";
        categoryUpdateButton.innerHTML = '<i class="fa-solid fa-pen"></i>';

        const updateUrl = `{{ route('category.update', ['id' => 'PLACEHOLDER']) }}`.replace('PLACEHOLDER', category.id);

        categoryUpdateButton.addEventListener('click', () => {
            window.location.href = updateUrl;
        });

        const categoryDeleteButton = document.createElement('button');
        categoryDeleteButton.className = 'btn red';
        categoryDeleteButton.innerHTML = '<i class="fa-solid fa-trash"></i>';

        const deleteUrl = `{{ route('admin.category.delete', ['id' => 'PLACEHOLDER']) }}`.replace('PLACEHOLDER', category.id);

        categoryDeleteButton.addEventListener('click', () => {
            fetch(deleteUrl, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        categoryTR.remove();
                    } else {
                        console.error('Error deleting category:', response.statusText);
                    }
                })
                .catch(error => console.error('Error deleting category:', error));
        });

        categoryButtonBlock.appendChild(categoryUpdateButton);
        categoryButtonBlock.appendChild(categoryDeleteButton);
        categoryButton.appendChild(categoryButtonBlock);
        categoryTR.appendChild(categoryButton);

        return categoryTR;
    }
</script>

@endsection