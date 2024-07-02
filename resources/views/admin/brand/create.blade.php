@extends('admin.layouts.admin-app')

@section('content')
<main>
    <section class="content">
        <div class="page-announce valign-wrapper"><a href="#" data-activates="slide-out" class="button-collapse valign hide-on-large-only"><i class="material-icons">menu</i></a>
            <h1 class="page-announce-text valign">// Add brand
            </h1>
        </div>
        <div class="container">
            <div class="row">
                <form id="category_brand-form" class="col s12">
                    @csrf
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" name="name" maxlength="200">
                            <label for="text" class="">Name: </label>
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
    const brandUrl = `{{route('admin.brand.store')}}`;
    const parentIdList = document.getElementById('parent_id');

    const brandForm = document.getElementById('category_brand-form');
    brandForm.addEventListener('submit', (event) => {
        event.preventDefault();
        const newFormData = new FormData(brandForm);

        const name = newFormData.get('name');

        fetch(brandUrl, {
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