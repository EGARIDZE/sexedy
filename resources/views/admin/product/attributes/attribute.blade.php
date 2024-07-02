@extends('admin.layouts.admin-app')

@section('content')
<main>
    <section class="content">
        <div class="page-announce valign-wrapper"><a href="#" data-activates="slide-out"
                class="button-collapse valign hide-on-large-only"><i class="material-icons">menu</i></a>
            <h1 class="page-announce-text valign">// Attributes
            </h1>
        </div>
        <div class="container">
            <h3>Create attribute</h3>
            <div class="row">
                <form id="attribute_create-form" class="col s12">
                    @csrf
                    <div class="row">

                        <div class="input-field col s12">
                            <input type="text" name="name">
                            <label for="text" class="">Name: </label>
                            <p style="color:red" id="name_error"></p>
                        </div>

                    </div>
                    <div class="center-align"><input class="btn btn-success" type="submit" value="Submit"></div>
                </form>
            </div>
            <h3>List attributes</h3>
            <div id="posttable" class="container">
                <table class="responsive-table striped hover centered" id="names-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody id="attribute__list">


                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>
@endsection

@section('api_representation')

<script>
const attributeCreateForm = document.getElementById('attribute_create-form');
const attributeCreateUrl = "{{route('admin.product.attribute.store')}}";

attributeCreateForm.addEventListener('submit', (event) => {
    const newFormData = new FormData(attributeCreateForm);
    const name = newFormData.get('name');

    fetch(attributeCreateUrl, {
            method: 'POST',
            body: newFormData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
        })
})

const attributeList = document.getElementById('attribute__list');
const attributeUrl = "{{route('admin.product.attribute.index')}}";

fetch(attributeUrl)
    .then(response => response.json())
    .then(attributes => {
        attributes.forEach(attribute => {
            const attributeTR = document.createElement('tr');

            const attributeId = document.createElement('td');
            attributeId.textContent = attribute.id;
            attributeTR.appendChild(attributeId);

            const attributeName = document.createElement('td');
            attributeName.textContent = attribute.name;
            attributeTR.appendChild(attributeName);


            const productButtonTD = document.createElement('td');
            const productButtonBlock = document.createElement('div');
            productButtonBlock.className = "btn-toolbar";

            const productDeleteButton = document.createElement('button');
            productDeleteButton.className = "btn red";
            productDeleteButton.innerHTML = '<i class="fa-solid fa-cart-shopping"></i>';
            productDeleteButton.addEventListener('click', () => {
                const attributeDeleteUrl =
                    `{{route('admin.product.attribute.delete', ['attribute_id' => 'ATTRIBUTE_ID'])}}`
                    .replace('ATTRIBUTE_ID', attribute.id);

                fetch(attributeDeleteUrl, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(response => response.json())
                    .then(data => {
                        console.log(data);
                        alert('Attribute deleted successfully');
                        window.location.reload();
                    })
            });

            productButtonBlock.appendChild(productDeleteButton);
            productButtonTD.appendChild(productButtonBlock);
            attributeTR.appendChild(productButtonTD);

            attributeList.appendChild(attributeTR);
        });
    })
</script>

@endsection