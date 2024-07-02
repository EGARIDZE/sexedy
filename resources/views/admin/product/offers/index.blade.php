@extends('admin.layouts.admin-app')

@section('content')
<main>
    <section class="content">
        <div class="page-announce valign-wrapper"><a href="#" data-activates="slide-out"
                class="button-collapse valign hide-on-large-only"><i class="material-icons">menu</i></a>
            <h1 class="page-announce-text valign">// Fabrics
            </h1>
        </div>
        <div class="container">
            @include('admin.product.include.product-slug-document')
            <h3>Create fabric</h3>
            <div class="row">
                <form id="fabrics_create-form" class="col s12">
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
            <h3>List fabrics</h3>
            <div id="posttable" class="container">
                <table class="responsive-table striped hover centered" id="names-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Description</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody id="fabrics__list">


                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>
@endsection

@section('api_representation')

<script>

</script>

@include('admin.product.include.product-slug-logics')

@endsection